<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // assumes supplier ids exist
        $data = [
            [ 'product_code' => 'ING-CHKN', 'product_name' => 'Chicken (kg)', 'description' => 'Fresh chicken meat', 'category' => 'Meat', 'unit' => 'kg', 'unit_price' => 180.00, 'stock' => 0.00, 'supplier_id' => 1, 'barcode' => '1234567890001', 'barcode_path' => '', 'is_perishable' => 1, 'shelf_life_days' => 5, 'is_active' => 1 ],
            [ 'product_code' => 'ING-RICE', 'product_name' => 'Rice (sack)', 'description' => 'Premium rice', 'category' => 'Grains', 'unit' => 'sack', 'unit_price' => 1800.00, 'stock' => 0.00, 'supplier_id' => 2, 'barcode' => '1234567890002', 'barcode_path' => '', 'is_perishable' => 0, 'shelf_life_days' => 365, 'is_active' => 1 ],
            [ 'product_code' => 'ING-OIL', 'product_name' => 'Cooking Oil (L)', 'description' => 'Vegetable cooking oil', 'category' => 'Condiments', 'unit' => 'L', 'unit_price' => 120.00, 'stock' => 0.00, 'supplier_id' => 1, 'barcode' => '1234567890003', 'barcode_path' => '', 'is_perishable' => 0, 'shelf_life_days' => 365, 'is_active' => 1 ],
        ];

        $this->db->table('products')->ignore(true)->insertBatch($data);
    }
}

