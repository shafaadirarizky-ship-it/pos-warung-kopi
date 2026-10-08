<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use App\Models\TableModel;
use App\Models\IngredientModel;
use App\Models\MenuRecipeModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pos extends BaseController
{
    protected $categoryModel;
    protected $menuModel;
    protected $tableModel;
    protected $ingredientModel;
    protected $menuRecipeModel;
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->categoryModel          = new CategoryModel();
        $this->menuModel              = new MenuModel();
        $this->tableModel             = new TableModel();
        $this->ingredientModel        = new IngredientModel();
        $this->menuRecipeModel        = new MenuRecipeModel();
        $this->transactionModel       = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->userModel              = new UserModel();
        $this->db                     = \Config\Database::connect();
    }

    /**
     * Tampilan Layanan Kasir Interaktif POS Warung Kopi
     */
    public function index()
    {
        $categories  = $this->categoryModel->findAll();
        $menus       = $this->menuModel
            ->select('menus.*, categories.nama_kategori')
            ->join('categories', 'categories.id = menus.category_id', 'left')
            ->orderBy('category_id', 'ASC')
            ->orderBy('nama_menu', 'ASC')
            ->findAll();

        // Ambil resep bahan baku per menu untuk info visual di frontend
        $menuRecipes = $this->db->table('menu_recipes')
            ->select('menu_recipes.menu_id, menu_recipes.jumlah_pakai, ingredients.nama_bahan, ingredients.satuan, ingredients.stok as stok_bahan')
            ->join('ingredients', 'ingredients.id = menu_recipes.ingredient_id')
            ->get()
            ->getResultArray();

        $recipesByMenu = [];
        foreach ($menuRecipes as $recipe) {
            $recipesByMenu[$recipe['menu_id']][] = $recipe;
        }

        // Sematkan resep ke data menu
        foreach ($menus as &$menu) {
            $menu['resep'] = $recipesByMenu[$menu['id']] ?? [];
        }

        $tables      = $this->tableModel->orderBy('id', 'ASC')->findAll();
        $ingredients = $this->ingredientModel->orderBy('nama_bahan', 'ASC')->findAll();
        $activeUser  = $this->userModel->where('role', 'kasir')->first() ?? $this->userModel->first();

        // Riwayat 5 transaksi terakhir untuk widget live feed
        $recentTransactions = $this->transactionModel
            ->select('transactions.*, tables.nomor_meja, users.nama_lengkap as nama_kasir')
            ->join('tables', 'tables.id = transactions.table_id', 'left')
            ->join('users', 'users.id = transactions.user_id', 'left')
            ->orderBy('transactions.id', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'title'              => 'Layanan Kasir Interaktif - POS Warung Kopi Tradisional',
            'categories'         => $categories,
            'menus'              => $menus,
            'tables'             => $tables,
            'ingredients'        => $ingredients,
            'activeUser'         => $activeUser,
            'recentTransactions' => $recentTransactions,
        ];

        return view('pos/index', $data);
    }

    /**
     * Logika Otomatisasi Transaksi & Pengurangan Stok Bahan Baku Sesuai Resep
     */
    public function checkout()
    {
        if (!$this->request->isAJAX() && !$this->request->is('post')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Permintaan tidak valid.',
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $jsonData = $this->request->getJSON(true) ?? $this->request->getPost();

        $items          = $jsonData['items'] ?? [];
        $customerName   = trim($jsonData['nama_pelanggan'] ?? 'Pelanggan');
        $orderType      = $jsonData['tipe_pesanan'] ?? 'dine_in';
        $tableId        = !empty($jsonData['table_id']) ? (int) $jsonData['table_id'] : null;
        $paymentMethod  = $jsonData['metode_pembayaran'] ?? 'tunai';
        $discountInput  = (float) ($jsonData['diskon'] ?? 0);
        $taxPercent     = (float) ($jsonData['pajak_persen'] ?? 0);
        $cashPaidInput  = (float) ($jsonData['total_bayar'] ?? 0);
        $note           = trim($jsonData['catatan'] ?? '');
        $userId         = (int) ($jsonData['user_id'] ?? 2);

        if (empty($items)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Keranjang pesanan masih kosong! Silakan pilih menu terlebih dahulu.',
            ]);
        }

        if (empty($customerName)) {
            $customerName = 'Pelanggan';
        }

        // 1. Validasi Menu & Hitung Subtotal serta Akumulasi Bahan Baku
        $itemDetails          = [];
        $calculatedSubtotal   = 0.00;
        $requiredIngredients  = []; // [ingredient_id => ['jumlah_pakai_total' => X, 'nama_bahan' => Y, 'satuan' => Z]]

        foreach ($items as $item) {
            $menuId = (int) ($item['menu_id'] ?? 0);
            $qty    = (int) ($item['qty'] ?? 0);
            $itemNote = trim($item['catatan'] ?? '');

            if ($menuId <= 0 || $qty <= 0) {
                continue;
            }

            $menu = $this->menuModel->find($menuId);
            if (!$menu) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Menu dengan ID #{$menuId} tidak ditemukan.",
                ]);
            }

            // Validasi ketersediaan stok porsi menu
            if ($menu['stok'] < $qty) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Stok porsi menu '{$menu['nama_menu']}' tidak mencukupi! Tersisa: {$menu['stok']}, Dipesan: {$qty}.",
                ]);
            }

            $price    = (float) $menu['harga'];
            $subtotal = $price * $qty;
            $calculatedSubtotal += $subtotal;

            $itemDetails[] = [
                'menu_id'      => $menuId,
                'nama_menu'    => $menu['nama_menu'],
                'harga_satuan' => $price,
                'jumlah'       => $qty,
                'subtotal'     => $subtotal,
                'catatan'      => $itemNote,
            ];

            // Ambil resep bahan baku untuk menu ini
            $recipes = $this->menuRecipeModel
                ->select('menu_recipes.*, ingredients.nama_bahan, ingredients.satuan, ingredients.stok')
                ->join('ingredients', 'ingredients.id = menu_recipes.ingredient_id')
                ->where('menu_recipes.menu_id', $menuId)
                ->findAll();

            foreach ($recipes as $r) {
                $ingId = (int) $r['ingredient_id'];
                $pakai = (float) $r['jumlah_pakai'] * $qty;

                if (!isset($requiredIngredients[$ingId])) {
                    $requiredIngredients[$ingId] = [
                        'ingredient_id' => $ingId,
                        'nama_bahan'    => $r['nama_bahan'],
                        'satuan'        => $r['satuan'],
                        'total_butuh'   => 0.00,
                        'stok_sekarang' => (float) $r['stok'],
                    ];
                }
                $requiredIngredients[$ingId]['total_butuh'] += $pakai;
            }
        }

        if (empty($itemDetails)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada item yang valid dalam keranjang.',
            ]);
        }

        // 2. Validasi Stok Bahan Baku di Database MySQL
        $deductedIngredientsLog = [];
        foreach ($requiredIngredients as $ingId => $ingReq) {
            $ingDb = $this->ingredientModel->find($ingId);
            if (!$ingDb) {
                continue;
            }

            $currentStock = (float) $ingDb['stok'];
            if ($currentStock < $ingReq['total_butuh']) {
                $kurang = $ingReq['total_butuh'] - $currentStock;
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Stok bahan baku '{$ingDb['nama_bahan']}' tidak mencukupi untuk pesanan ini! Tersisa di gudang: {$currentStock} {$ingDb['satuan']}, Dibutuhkan: {$ingReq['total_butuh']} {$ingDb['satuan']} (Kurang {$kurang} {$ingDb['satuan']}).",
                ]);
            }

            $deductedIngredientsLog[] = [
                'ingredient_id' => $ingId,
                'nama_bahan'    => $ingDb['nama_bahan'],
                'satuan'        => $ingDb['satuan'],
                'stok_awal'     => $currentStock,
                'jumlah_pakai'  => $ingReq['total_butuh'],
                'stok_sisa'     => $currentStock - $ingReq['total_butuh'],
            ];
        }

        // 3. Kalkulator Transaksi (Subtotal, Diskon, Pajak, Total Akhir, Kembalian)
        $discountAmount = min($discountInput, $calculatedSubtotal);
        $taxableAmount  = max(0, $calculatedSubtotal - $discountAmount);
        $taxAmount      = round($taxableAmount * ($taxPercent / 100), 2);
        $grandTotal     = round($taxableAmount + $taxAmount, 2);

        $changeAmount   = 0.00;
        if ($paymentMethod === 'tunai') {
            if ($cashPaidInput < $grandTotal) {
                $selisih = $grandTotal - $cashPaidInput;
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Uang pembayaran tunai kurang Rp ' . number_format($selisih, 0, ',', '.') . ' dari total pesanan!',
                ]);
            }
            $changeAmount = $cashPaidInput - $grandTotal;
        } else {
            // QRIS atau Transfer Bank dianggap pas
            $cashPaidInput = $grandTotal;
            $changeAmount  = 0.00;
        }

        // 4. Generate Nomor Kode Transaksi Unik Warkop: WKP-YYYYMMDD-XXXX
        $todayPrefix = 'WKP-' . date('Ymd') . '-';
        $lastTrx = $this->transactionModel
            ->like('kode_transaksi', $todayPrefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastTrx && preg_match('/WKP-\d+-(\d+)/', $lastTrx['kode_transaksi'], $matches)) {
            $nextSequence = ((int) $matches[1]) + 1;
        } else {
            $nextSequence = 1;
        }
        $kodeTransaksi = $todayPrefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

        // 5. Eksekusi Database Transaction (Atomicity)
        $this->db->transBegin();

        try {
            // Simpan Transaksi Utama
            $transactionData = [
                'kode_transaksi'    => $kodeTransaksi,
                'user_id'           => $userId,
                'table_id'          => ($orderType === 'dine_in') ? $tableId : null,
                'nama_pelanggan'    => $customerName,
                'tipe_pesanan'      => $orderType,
                'subtotal'          => $calculatedSubtotal,
                'diskon'            => $discountAmount,
                'pajak'             => $taxAmount,
                'total_akhir'       => $grandTotal,
                'total_bayar'       => $cashPaidInput,
                'kembalian'         => $changeAmount,
                'metode_pembayaran' => $paymentMethod,
                'status_pembayaran' => 'selesai',
                'catatan'           => $note,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            $this->transactionModel->insert($transactionData);
            $transactionId = $this->transactionModel->getInsertID();

            // Simpan Detail Transaksi & Kurangi Stok Porsi Menu
            foreach ($itemDetails as $detail) {
                $detailData = [
                    'transaction_id' => $transactionId,
                    'menu_id'        => $detail['menu_id'],
                    'jumlah'         => $detail['jumlah'],
                    'harga_satuan'   => $detail['harga_satuan'],
                    'subtotal'       => $detail['subtotal'],
                    'catatan'        => $detail['catatan'],
                ];
                $this->transactionDetailModel->insert($detailData);

                // Kurangi stok menu
                $this->db->table('menus')
                    ->where('id', $detail['menu_id'])
                    ->set('stok', 'stok - ' . (int) $detail['jumlah'], false)
                    ->update();
            }

            // Otomatisasi Pengurangan Stok Bahan Baku Sesuai Resep di MySQL
            foreach ($requiredIngredients as $ingId => $ingReq) {
                $this->db->table('ingredients')
                    ->where('id', $ingId)
                    ->set('stok', 'stok - ' . (float) $ingReq['total_butuh'], false)
                    ->set('updated_at', date('Y-m-d H:i:s'))
                    ->update();
            }

            // Jika Dine In dan memilih meja, update status meja menjadi 'terisi'
            if ($orderType === 'dine_in' && $tableId) {
                $this->db->table('tables')
                    ->where('id', $tableId)
                    ->update(['status' => 'terisi', 'updated_at' => date('Y-m-d H:i:s')]);
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memproses transaksi di database.',
                ]);
            }

            $this->db->transCommit();

            // Ambil data meja & kasir untuk struk
            $tableData = $tableId ? $this->tableModel->find($tableId) : null;
            $cashier   = $this->userModel->find($userId);

            // Susun data struk lengkap untuk cetak
            $receiptData = [
                'transaction_id'     => $transactionId,
                'kode_transaksi'     => $kodeTransaksi,
                'tanggal'            => date('d/m/Y H:i:s'),
                'kasir'              => $cashier['nama_lengkap'] ?? 'Kasir Warkop',
                'nama_pelanggan'     => $customerName,
                'tipe_pesanan'       => ($orderType === 'dine_in') ? 'Dine In (Makan di Tempat)' : 'Take Away (Bungkus)',
                'nomor_meja'         => $tableData['nomor_meja'] ?? '-',
                'items'              => $itemDetails,
                'subtotal'           => $calculatedSubtotal,
                'diskon'             => $discountAmount,
                'pajak'              => $taxAmount,
                'pajak_persen'       => $taxPercent,
                'total_akhir'        => $grandTotal,
                'total_bayar'        => $cashPaidInput,
                'kembalian'          => $changeAmount,
                'metode_pembayaran'  => strtoupper($paymentMethod),
                'catatan'            => $note,
                'deducted_materials' => $deductedIngredientsLog,
            ];

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan! Stok bahan baku otomatis diperbarui sesuai resep.',
                'receipt' => $receiptData,
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Endpoint API Data Bahan Baku Terkini (Live Monitor Stok)
     */
    public function getIngredients()
    {
        $ingredients = $this->ingredientModel->orderBy('nama_bahan', 'ASC')->findAll();
        return $this->response->setJSON([
            'success'     => true,
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * Endpoint API Reset / Kosongkan Meja Warkop
     */
    public function resetTable($tableId)
    {
        $this->tableModel->update($tableId, [
            'status'     => 'tersedia',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status meja berhasil diubah menjadi tersedia.',
        ]);
    }

    /**
     * Halaman Cetak Struk Terpisah (Stand-alone Printable Receipt)
     */
    public function receipt($id)
    {
        $transaction = $this->transactionModel->find($id);
        if (!$transaction) {
            return redirect()->to('/')->with('error', 'Transaksi tidak ditemukan');
        }

        $details = $this->transactionDetailModel
            ->select('transaction_details.*, menus.nama_menu')
            ->join('menus', 'menus.id = transaction_details.menu_id')
            ->where('transaction_id', $id)
            ->findAll();

        $table   = $transaction['table_id'] ? $this->tableModel->find($transaction['table_id']) : null;
        $cashier = $this->userModel->find($transaction['user_id']);

        $data = [
            'transaction' => $transaction,
            'details'     => $details,
            'table'       => $table,
            'cashier'     => $cashier,
        ];

        return view('pos/receipt', $data);
    }
}
