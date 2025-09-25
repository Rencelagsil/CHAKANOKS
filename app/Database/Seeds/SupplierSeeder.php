<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [ 'supplier_code' => 'SUP-PRIME', 'company_name' => 'Prime Foods Supply Co.', 'email' => 'sales@primefoods.test', 'phone' => '09171234567', 'city' => 'Davao City', 'payment_terms' => '30 days', 'is_active' => 1 ],
            [ 'supplier_code' => 'SUP-FRESH', 'company_name' => 'Fresh Harvest Logistics', 'email' => 'orders@freshharvest.test', 'phone' => '09179876543', 'city' => 'Davao City', 'payment_terms' => 'COD', 'is_active' => 1 ],
        ];

        $this->db->table('suppliers')->ignore(true)->insertBatch($data);
    }
}

