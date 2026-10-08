<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #<?= esc($transaction['kode_transaksi']) ?> - Warung Kopi Tradisional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f3f4f6;
            font-family: 'Space Mono', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .receipt-card {
            background: #fff;
            width: 320px;
            padding: 24px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            font-size: 12px;
            line-height: 1.4;
            color: #111;
        }
        .text-center { text-align: center; }
        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .divider {
            border-top: 1px dashed #888;
            margin: 8px 0;
        }
        .double-divider {
            border-top: 1px double #333;
            margin: 8px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        .item-row {
            margin: 6px 0;
        }
        .item-name { font-weight: 700; }
        .item-calc { font-size: 11px; color: #555; }
        .total-row {
            font-size: 14px;
            font-weight: 800;
        }
        .print-btn-bar {
            margin-top: 16px;
            display: flex;
            gap: 8px;
        }
        .btn {
            flex: 1;
            padding: 8px;
            font-family: sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 4px;
        }
        .btn.primary {
            background: #e67e22;
            color: #fff;
            border-color: #e67e22;
        }
        @media print {
            body { background: none; padding: 0; }
            .print-btn-bar { display: none; }
            .receipt-card { box-shadow: none; width: 100%; max-width: 100%; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="text-center">
            <div class="brand-title">WARUNG KOPI TRADISIONAL</div>
            <div>Jl. Teuku Umar No. 24, Warkop Heritage</div>
            <div style="font-size: 11px; color:#555;">Telp: 0812-3456-7890</div>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>No. Struk:</span>
            <span><?= esc($transaction['kode_transaksi']) ?></span>
        </div>
        <div class="row">
            <span>Waktu:</span>
            <span><?= esc(date('d/m/Y H:i', strtotime($transaction['created_at']))) ?></span>
        </div>
        <div class="row">
            <span>Kasir:</span>
            <span><?= esc($cashier['nama_lengkap'] ?? 'Kasir') ?></span>
        </div>
        <div class="row">
            <span>Pelanggan:</span>
            <span><?= esc($transaction['nama_pelanggan']) ?></span>
        </div>
        <div class="row">
            <span>Layanan:</span>
            <span><?= ($transaction['tipe_pesanan'] === 'dine_in') ? 'Dine In ' . ($table ? '('.$table['nomor_meja'].')' : '') : 'Take Away' ?></span>
        </div>

        <div class="double-divider"></div>

        <?php foreach ($details as $d): ?>
            <div class="item-row">
                <div class="row">
                    <span class="item-name"><?= esc($d['nama_menu']) ?></span>
                    <span>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></span>
                </div>
                <div class="item-calc">
                    <?= $d['jumlah'] ?> x Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?>
                    <?= !empty($d['catatan']) ? ' (' . esc($d['catatan']) . ')' : '' ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="divider"></div>

        <div class="row">
            <span>Subtotal:</span>
            <span>Rp <?= number_format($transaction['subtotal'], 0, ',', '.') ?></span>
        </div>
        <?php if ($transaction['diskon'] > 0): ?>
            <div class="row">
                <span>Diskon:</span>
                <span>- Rp <?= number_format($transaction['diskon'], 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>
        <?php if ($transaction['pajak'] > 0): ?>
            <div class="row">
                <span>Pajak (PPN):</span>
                <span>Rp <?= number_format($transaction['pajak'], 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>

        <div class="divider"></div>

        <div class="row total-row">
            <span>TOTAL:</span>
            <span>Rp <?= number_format($transaction['total_akhir'], 0, ',', '.') ?></span>
        </div>
        <div class="row">
            <span>Bayar (<?= strtoupper($transaction['metode_pembayaran']) ?>):</span>
            <span>Rp <?= number_format($transaction['total_bayar'], 0, ',', '.') ?></span>
        </div>
        <div class="row" style="font-weight:700;">
            <span>Kembalian:</span>
            <span>Rp <?= number_format($transaction['kembalian'], 0, ',', '.') ?></span>
        </div>

        <div class="double-divider"></div>

        <div class="text-center" style="margin-top: 8px;">
            <div>-- MATUR NUWUN --</div>
            <div style="font-size: 11px; color:#555; margin-top:2px;">Kopi Asli Tradisional, Rasa Terbaik!</div>
        </div>

        <div class="print-btn-bar">
            <button class="btn" onclick="window.history.back()">Kembali</button>
            <button class="btn primary" onclick="window.print()">Cetak</button>
        </div>
    </div>
</body>
</html>
