<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Fresh Foods Supply Co. products
            [
                'product_code' => 'CHK-001',
                'product_name' => 'Premium Chicken Breast',
                'description' => 'Fresh premium chicken breast, skinless and boneless',
                'category' => 'Meat',
                'unit' => 'kg',
                'unit_price' => 320.00,
                'supplier_id' => 2,
                'barcode' => '1234567890123',
                'is_perishable' => 1,
                'shelf_life_days' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_code' => 'PRK-001',
                'product_name' => 'Fresh Pork Belly',
                'description' => 'Fresh pork belly with skin',
                'category' => 'Meat',
                'unit' => 'kg',
                'unit_price' => 380.00,
                'supplier_id' => 2,
                'barcode' => '1234567890124',
                'is_perishable' => 1,
                'shelf_life_days' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_code' => 'BEF-001',
                'product_name' => 'Beef Sirloin',
                'description' => 'Premium beef sirloin cut',
                'category' => 'Meat',
                'unit' => 'kg',
                'unit_price' => 650.00,
                'supplier_id' => 2,
                'barcode' => '1234567890125',
                'is_perishable' => 1,
                'shelf_life_days' => 5,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Grain & Rice Distributors products
            [
                'product_code' => 'RIC-001',
                'product_name' => 'Jasmine Rice',
                'description' => 'Premium jasmine rice, 50kg sack',
                'category' => 'Grains',
                'unit' => 'sack',
                'unit_price' => 2800.00,
                'supplier_id' => 3,
                'barcode' => '1234567890126',
                'is_perishable' => 0,
                'shelf_life_days' => 365,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_code' => 'WHT-001',
                'product_name' => 'All-Purpose Flour',
                'description' => 'All-purpose flour, 25kg bag',
                'category' => 'Grains',
                'unit' => 'bag',
                'unit_price' => 1200.00,
                'supplier_id' => 3,
                'barcode' => '1234567890127',
                'is_perishable' => 0,
                'shelf_life_days' => 180,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Beverage Solutions Ltd. products
            [
                'product_code' => 'COK-001',
                'product_name' => 'Coca-Cola Classic',
                'description' => 'Coca-Cola Classic, 330ml can, 24 pieces per case',
                'category' => 'Beverages',
                'unit' => 'case',
                'unit_price' => 480.00,
                'supplier_id' => 4,
                'barcode' => '1234567890128',
                'is_perishable' => 0,
                'shelf_life_days' => 365,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_code' => 'SPR-001',
                'product_name' => 'Sprite',
                'description' => 'Sprite, 330ml can, 24 pieces per case',
                'category' => 'Beverages',
                'unit' => 'case',
                'unit_price' => 480.00,
                'supplier_id' => 4,
                'barcode' => '1234567890129',
                'is_perishable' => 0,
                'shelf_life_days' => 365,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Snack & Confectionery Co. products
            [
                'product_code' => 'CHP-001',
                'product_name' => 'Potato Chips',
                'description' => 'Crunchy potato chips, 50g pack, 24 pieces per box',
                'category' => 'Snacks',
                'unit' => 'box',
                'unit_price' => 360.00,
                'supplier_id' => 5,
                'barcode' => '1234567890130',
                'is_perishable' => 0,
                'shelf_life_days' => 90,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_code' => 'CND-001',
                'product_name' => 'Assorted Candies',
                'description' => 'Mixed fruit candies, 1kg bag',
                'category' => 'Confectionery',
                'unit' => 'bag',
                'unit_price' => 180.00,
                'supplier_id' => 5,
                'barcode' => '1234567890131',
                'is_perishable' => 0,
                'shelf_life_days' => 180,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}

