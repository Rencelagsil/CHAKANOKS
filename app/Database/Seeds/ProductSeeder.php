<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // assumes supplier ids exist
        $data = [
            [ 'product_code' => 'ING-CHKN', 'product_name' => 'Chicken (kg)', 'category' => 'Meat', 'unit' => 'kg', 'unit_price' => 180.00, 'supplier_id' => 1, 'is_perishable' => 1, 'shelf_life_days' => 5, 'is_active' => 1 ],
            [ 'product_code' => 'ING-RICE', 'product_name' => 'Rice (sack)', 'category' => 'Grains', 'unit' => 'sack', 'unit_price' => 1800.00, 'supplier_id' => 2, 'is_perishable' => 0, 'is_active' => 1 ],
            [ 'product_code' => 'ING-OIL', 'product_name' => 'Cooking Oil (L)', 'category' => 'Condiments', 'unit' => 'L', 'unit_price' => 120.00, 'supplier_id' => 1, 'is_perishable' => 0, 'is_active' => 1 ],
        ];

        $this->db->table('products')->ignore(true)->insertBatch($data);
    }
}

