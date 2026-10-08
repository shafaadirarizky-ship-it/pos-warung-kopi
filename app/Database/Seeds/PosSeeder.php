<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // 1. Seed Users
        $userModel = model('UserModel');
        $userModel->truncate();
        $users = [
            [
                'nama_lengkap' => 'Admin Warkop',
                'username'     => 'admin',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'admin',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Kasir Melly',
                'username'     => 'kasir',
                'password'     => password_hash('kasir123', PASSWORD_DEFAULT),
                'role'         => 'kasir',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // 2. Seed Categories
        $this->db->table('categories')->truncate();
        $categories = [
            ['id' => 1, 'nama_kategori' => 'Kopi Tradisional'],
            ['id' => 2, 'nama_kategori' => 'Kopi Susu & Modern'],
            ['id' => 3, 'nama_kategori' => 'Minuman Non-Kopi'],
            ['id' => 4, 'nama_kategori' => 'Makanan Berat'],
            ['id' => 5, 'nama_kategori' => 'Cemilan & Gorengan'],
        ];
        $this->db->table('categories')->insertBatch($categories);

        // 3. Seed Tables (Meja Warkop)
        $this->db->table('tables')->truncate();
        $tables = [
            ['nomor_meja' => 'Meja 01', 'kapasitas' => 4, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Meja 02', 'kapasitas' => 4, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Meja 03', 'kapasitas' => 2, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Meja 04', 'kapasitas' => 6, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Meja 05 (Outdoor)', 'kapasitas' => 4, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Meja 06 (Outdoor)', 'kapasitas' => 4, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Meja Bar 01', 'kapasitas' => 2, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ['nomor_meja' => 'Lesehan A', 'kapasitas' => 8, 'status' => 'tersedia', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('tables')->insertBatch($tables);

        // 4. Seed Ingredients (Bahan Baku Warkop)
        $this->db->table('ingredients')->truncate();
        $ingredients = [
            ['id' => 1, 'nama_bahan' => 'Biji Kopi Robusta', 'satuan' => 'gram', 'stok' => 5000.00, 'stok_minimum' => 500.00, 'harga_satuan' => 150.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'nama_bahan' => 'Biji Kopi Arabika', 'satuan' => 'gram', 'stok' => 3000.00, 'stok_minimum' => 300.00, 'harga_satuan' => 250.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 3, 'nama_bahan' => 'Susu Kental Manis', 'satuan' => 'ml', 'stok' => 10000.00, 'stok_minimum' => 1000.00, 'harga_satuan' => 35.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 4, 'nama_bahan' => 'Susu Fresh Milk (UHT)', 'satuan' => 'ml', 'stok' => 8000.00, 'stok_minimum' => 1000.00, 'harga_satuan' => 22.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 5, 'nama_bahan' => 'Gula Pasir', 'satuan' => 'gram', 'stok' => 10000.00, 'stok_minimum' => 1000.00, 'harga_satuan' => 18.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 6, 'nama_bahan' => 'Gula Aren Cair', 'satuan' => 'ml', 'stok' => 5000.00, 'stok_minimum' => 500.00, 'harga_satuan' => 40.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 7, 'nama_bahan' => 'Daun Teh Tubruk', 'satuan' => 'gram', 'stok' => 2500.00, 'stok_minimum' => 200.00, 'harga_satuan' => 50.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 8, 'nama_bahan' => 'Bubuk Cokelat Premium', 'satuan' => 'gram', 'stok' => 2000.00, 'stok_minimum' => 200.00, 'harga_satuan' => 120.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 9, 'nama_bahan' => 'Sirup Lemon', 'satuan' => 'ml', 'stok' => 3000.00, 'stok_minimum' => 300.00, 'harga_satuan' => 45.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 10, 'nama_bahan' => 'Mie Instan', 'satuan' => 'bungkus', 'stok' => 120.00, 'stok_minimum' => 20.00, 'harga_satuan' => 3500.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 11, 'nama_bahan' => 'Telur Ayam', 'satuan' => 'butir', 'stok' => 150.00, 'stok_minimum' => 25.00, 'harga_satuan' => 2200.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 12, 'nama_bahan' => 'Pisang Kepok', 'satuan' => 'buah', 'stok' => 80.00, 'stok_minimum' => 15.00, 'harga_satuan' => 1500.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 13, 'nama_bahan' => 'Roti Tawar', 'satuan' => 'lembar', 'stok' => 100.00, 'stok_minimum' => 20.00, 'harga_satuan' => 1000.00, 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 14, 'nama_bahan' => 'Kentang Beku (Frozen)', 'satuan' => 'gram', 'stok' => 5000.00, 'stok_minimum' => 500.00, 'harga_satuan' => 40.00, 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('ingredients')->insertBatch($ingredients);

        // 5. Seed Menus
        $this->db->table('menus')->truncate();
        $menus = [
            // Kopi Tradisional (Category 1)
            [
                'id'          => 1,
                'category_id' => 1,
                'nama_menu'   => 'Kopi Hitam Tubruk Robusta',
                'harga'       => 8000.00,
                'stok'        => 100,
                'foto'        => 'kopi_tubruk.jpg',
            ],
            [
                'id'          => 2,
                'category_id' => 1,
                'nama_menu'   => 'Kopi Saring Tradisional',
                'harga'       => 10000.00,
                'stok'        => 100,
                'foto'        => 'kopi_saring.jpg',
            ],
            // Kopi Susu & Modern (Category 2)
            [
                'id'          => 3,
                'category_id' => 2,
                'nama_menu'   => 'Kopi Sanger Khas Warkop',
                'harga'       => 12000.00,
                'stok'        => 80,
                'foto'        => 'kopi_sanger.jpg',
            ],
            [
                'id'          => 4,
                'category_id' => 2,
                'nama_menu'   => 'Es Kopi Susu Gula Aren',
                'harga'       => 15000.00,
                'stok'        => 80,
                'foto'        => 'kopi_gula_aren.jpg',
            ],
            [
                'id'          => 5,
                'category_id' => 2,
                'nama_menu'   => 'Kopi Susu Panas Klasik',
                'harga'       => 11000.00,
                'stok'        => 75,
                'foto'        => 'kopi_susu_panas.jpg',
            ],
            // Minuman Non-Kopi (Category 3)
            [
                'id'          => 6,
                'category_id' => 3,
                'nama_menu'   => 'Teh Tarik Warkop',
                'harga'       => 10000.00,
                'stok'        => 90,
                'foto'        => 'teh_tarik.jpg',
            ],
            [
                'id'          => 7,
                'category_id' => 3,
                'nama_menu'   => 'Lemon Tea Segar (Es/Panas)',
                'harga'       => 12000.00,
                'stok'        => 90,
                'foto'        => 'lemon_tea.jpg',
            ],
            [
                'id'          => 8,
                'category_id' => 3,
                'nama_menu'   => 'Cokelat Susu Mantap',
                'harga'       => 14000.00,
                'stok'        => 60,
                'foto'        => 'cokelat_susu.jpg',
            ],
            // Makanan Berat (Category 4)
            [
                'id'          => 9,
                'category_id' => 4,
                'nama_menu'   => 'Indomie Goreng + Telur Ceplok',
                'harga'       => 14000.00,
                'stok'        => 50,
                'foto'        => 'indomie_goreng_telur.jpg',
            ],
            [
                'id'          => 10,
                'category_id' => 4,
                'nama_menu'   => 'Indomie Rebus Kari + Telur',
                'harga'       => 14000.00,
                'stok'        => 50,
                'foto'        => 'indomie_kuah_telur.jpg',
            ],
            // Cemilan & Gorengan (Category 5)
            [
                'id'          => 11,
                'category_id' => 5,
                'nama_menu'   => 'Pisang Goreng Crispy Keju',
                'harga'       => 13000.00,
                'stok'        => 40,
                'foto'        => 'pisang_goreng.jpg',
            ],
            [
                'id'          => 12,
                'category_id' => 5,
                'nama_menu'   => 'Roti Bakar Cokelat Keju',
                'harga'       => 14000.00,
                'stok'        => 40,
                'foto'        => 'roti_bakar.jpg',
            ],
            [
                'id'          => 13,
                'category_id' => 5,
                'nama_menu'   => 'Kentang Goreng Warkop',
                'harga'       => 13000.00,
                'stok'        => 40,
                'foto'        => 'french_fries.jpg',
            ],
        ];
        $this->db->table('menus')->insertBatch($menus);

        // 6. Seed Menu Recipes (Relasi Bahan Baku per Porsi Menu)
        $this->db->table('menu_recipes')->truncate();
        $recipes = [
            // Menu 1: Kopi Hitam Tubruk (Biji Robusta 15g, Gula Pasir 10g)
            ['menu_id' => 1, 'ingredient_id' => 1, 'jumlah_pakai' => 15.00],
            ['menu_id' => 1, 'ingredient_id' => 5, 'jumlah_pakai' => 10.00],

            // Menu 2: Kopi Saring Tradisional (Biji Robusta 18g, Gula Pasir 12g)
            ['menu_id' => 2, 'ingredient_id' => 1, 'jumlah_pakai' => 18.00],
            ['menu_id' => 2, 'ingredient_id' => 5, 'jumlah_pakai' => 12.00],

            // Menu 3: Kopi Sanger (Biji Robusta 18g, Susu Kental Manis 30ml)
            ['menu_id' => 3, 'ingredient_id' => 1, 'jumlah_pakai' => 18.00],
            ['menu_id' => 3, 'ingredient_id' => 3, 'jumlah_pakai' => 30.00],

            // Menu 4: Es Kopi Susu Aren (Biji Arabika 18g, Fresh Milk 100ml, Gula Aren 25ml)
            ['menu_id' => 4, 'ingredient_id' => 2, 'jumlah_pakai' => 18.00],
            ['menu_id' => 4, 'ingredient_id' => 4, 'jumlah_pakai' => 100.00],
            ['menu_id' => 4, 'ingredient_id' => 6, 'jumlah_pakai' => 25.00],

            // Menu 5: Kopi Susu Panas (Biji Robusta 15g, Susu Kental Manis 25ml, Gula 5g)
            ['menu_id' => 5, 'ingredient_id' => 1, 'jumlah_pakai' => 15.00],
            ['menu_id' => 5, 'ingredient_id' => 3, 'jumlah_pakai' => 25.00],
            ['menu_id' => 5, 'ingredient_id' => 5, 'jumlah_pakai' => 5.00],

            // Menu 6: Teh Tarik Warkop (Teh 10g, Susu Kental Manis 35ml)
            ['menu_id' => 6, 'ingredient_id' => 7, 'jumlah_pakai' => 10.00],
            ['menu_id' => 6, 'ingredient_id' => 3, 'jumlah_pakai' => 35.00],

            // Menu 7: Lemon Tea (Teh 8g, Sirup Lemon 25ml, Gula Pasir 15g)
            ['menu_id' => 7, 'ingredient_id' => 7, 'jumlah_pakai' => 8.00],
            ['menu_id' => 7, 'ingredient_id' => 9, 'jumlah_pakai' => 25.00],
            ['menu_id' => 7, 'ingredient_id' => 5, 'jumlah_pakai' => 15.00],

            // Menu 8: Cokelat Susu (Bubuk Cokelat 25g, Fresh Milk 120ml, Susu Kental Manis 15ml)
            ['menu_id' => 8, 'ingredient_id' => 8, 'jumlah_pakai' => 25.00],
            ['menu_id' => 8, 'ingredient_id' => 4, 'jumlah_pakai' => 120.00],
            ['menu_id' => 8, 'ingredient_id' => 3, 'jumlah_pakai' => 15.00],

            // Menu 9: Indomie Goreng + Telur (Mie Instan 1 bungkus, Telur 1 butir)
            ['menu_id' => 9, 'ingredient_id' => 10, 'jumlah_pakai' => 1.00],
            ['menu_id' => 9, 'ingredient_id' => 11, 'jumlah_pakai' => 1.00],

            // Menu 10: Indomie Rebus + Telur (Mie Instan 1 bungkus, Telur 1 butir)
            ['menu_id' => 10, 'ingredient_id' => 10, 'jumlah_pakai' => 1.00],
            ['menu_id' => 10, 'ingredient_id' => 11, 'jumlah_pakai' => 1.00],

            // Menu 11: Pisang Goreng Keju (Pisang 2 buah)
            ['menu_id' => 11, 'ingredient_id' => 12, 'jumlah_pakai' => 2.00],

            // Menu 12: Roti Bakar (Roti Tawar 2 lembar)
            ['menu_id' => 12, 'ingredient_id' => 13, 'jumlah_pakai' => 2.00],

            // Menu 13: Kentang Goreng (Kentang 150g)
            ['menu_id' => 13, 'ingredient_id' => 14, 'jumlah_pakai' => 150.00],
        ];
        $this->db->table('menu_recipes')->insertBatch($recipes);

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
