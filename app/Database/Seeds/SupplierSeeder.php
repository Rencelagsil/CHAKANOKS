<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [ 
                'supplier_code' => 'SUP-PRIME', 
                'company_name' => 'Prime Foods Supply Co.', 
                'contact_person' => 'John Smith',
                'email' => 'sales@primefoods.test', 
                'phone' => '09171234567', 
                'address' => '123 Main Street',
                'city' => 'Davao City', 
                'payment_terms' => '30 days', 
                'is_active' => 1 
            ],
            [ 
                'supplier_code' => 'SUP-FRESH', 
                'company_name' => 'Fresh Harvest Logistics', 
                'contact_person' => 'Maria Garcia',
                'email' => 'orders@freshharvest.test', 
                'phone' => '09179876543', 
                'address' => '456 Business Ave',
                'city' => 'Davao City', 
                'payment_terms' => 'COD', 
                'is_active' => 1 
            ],
        ];

        $this->db->table('suppliers')->ignore(true)->insertBatch($data);
    }
}

