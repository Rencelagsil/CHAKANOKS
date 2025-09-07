<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'supplier_code' => 'SUP-001',
                'company_name' => 'Fresh Foods Supply Co.',
                'contact_person' => 'Roberto Garcia',
                'email' => 'roberto@freshfoods.com',
                'phone' => '+63 912 345 6800',
                'address' => '789 Supply Street, Davao City',
                'city' => 'Davao City',
                'payment_terms' => 'Net 30',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_code' => 'SUP-002',
                'company_name' => 'Premium Meats Inc.',
                'contact_person' => 'Isabella Lopez',
                'email' => 'isabella@premiummeats.com',
                'phone' => '+63 912 345 6801',
                'address' => '321 Meat Avenue, Davao City',
                'city' => 'Davao City',
                'payment_terms' => 'Net 15',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_code' => 'SUP-003',
                'company_name' => 'Grain & Rice Distributors',
                'contact_person' => 'Miguel Rodriguez',
                'email' => 'miguel@grainrice.com',
                'phone' => '+63 912 345 6802',
                'address' => '654 Grain Road, Davao City',
                'city' => 'Davao City',
                'payment_terms' => 'Net 30',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_code' => 'SUP-004',
                'company_name' => 'Beverage Solutions Ltd.',
                'contact_person' => 'Carmen Flores',
                'email' => 'carmen@beveragesolutions.com',
                'phone' => '+63 912 345 6803',
                'address' => '987 Beverage Blvd, Davao City',
                'city' => 'Davao City',
                'payment_terms' => 'Net 20',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_code' => 'SUP-005',
                'company_name' => 'Snack & Confectionery Co.',
                'contact_person' => 'Antonio Martinez',
                'email' => 'antonio@snackconfectionery.com',
                'phone' => '+63 912 345 6804',
                'address' => '147 Snack Street, Davao City',
                'city' => 'Davao City',
                'payment_terms' => 'Net 30',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('suppliers')->insertBatch($data);
    }
}

