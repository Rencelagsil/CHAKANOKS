<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Get all products and branches
        $products = $this->db->table('products')->get()->getResultArray();
        $branches = $this->db->table('branches')->where('is_active', 1)->get()->getResultArray();
        
        if (empty($products) || empty($branches)) {
            return; // Skip if no products or branches exist
        }
        
        $data = [];
        
        // Create inventory for each product in each branch
        foreach ($products as $product) {
            foreach ($branches as $branch) {
                // Generate random stock levels for variety
                $currentStock = rand(5, 100);
                $minStock = rand(5, 15);
                $maxStock = rand(100, 200);
                $reorderPoint = $minStock + rand(2, 5);
                
                // Make some items critical/low stock for testing
                if (rand(1, 10) <= 3) { // 30% chance of low stock
                    $currentStock = rand(1, $minStock - 1);
                }
                
                $data[] = [
                    'product_id' => $product['id'],
                    'branch_id' => $branch['id'],
                    'current_stock' => $currentStock,
                    'min_stock_level' => $minStock,
                    'max_stock_level' => $maxStock,
                    'reorder_point' => $reorderPoint,
                    'last_updated' => date('Y-m-d H:i:s')
                ];
            }
        }

        $this->db->table('inventory')->ignore(true)->insertBatch($data);
    }
}

