<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $data = [];
        
        // Create inventory for each product in each branch
        $products = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // Product IDs
        $branches = [1, 2, 3, 4, 5, 6]; // Branch IDs
        
        foreach ($products as $productId) {
            foreach ($branches as $branchId) {
                // Set different stock levels based on product and branch
                $baseStock = rand(10, 100);
                $minLevel = $baseStock * 0.2;
                $maxLevel = $baseStock * 2;
                $reorderPoint = $baseStock * 0.3;
                
                // Make some items low stock for demonstration
                if (rand(1, 10) <= 3) {
                    $baseStock = rand(1, 5);
                }
                
                $data[] = [
                    'product_id' => $productId,
                    'branch_id' => $branchId,
                    'current_stock' => $baseStock,
                    'min_stock_level' => $minLevel,
                    'max_stock_level' => $maxLevel,
                    'reorder_point' => $reorderPoint,
                    'last_updated' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('inventory')->insertBatch($data);
    }
}

