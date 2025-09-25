<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // seed minimal inventory for branch 1
        $data = [
            [ 'product_id' => 1, 'branch_id' => 1, 'current_stock' => 20, 'min_stock_level' => 10, 'max_stock_level' => 100, 'reorder_point' => 12, 'last_updated' => date('Y-m-d H:i:s') ],
            [ 'product_id' => 2, 'branch_id' => 1, 'current_stock' => 50, 'min_stock_level' => 5, 'max_stock_level' => 200, 'reorder_point' => 10, 'last_updated' => date('Y-m-d H:i:s') ],
            [ 'product_id' => 3, 'branch_id' => 1, 'current_stock' => 8, 'min_stock_level' => 10, 'max_stock_level' => 150, 'reorder_point' => 12, 'last_updated' => date('Y-m-d H:i:s') ],
        ];

        $this->db->table('inventory')->ignore(true)->insertBatch($data);
    }
}

