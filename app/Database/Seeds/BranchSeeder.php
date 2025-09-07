<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'branch_code' => 'DAV-001',
                'branch_name' => 'Davao Main Branch',
                'address' => '123 Main Street, Davao City',
                'city' => 'Davao City',
                'contact_person' => 'John Santos',
                'contact_phone' => '+63 912 345 6789',
                'contact_email' => 'main@chakanoks.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'branch_code' => 'DAV-002',
                'branch_name' => 'Davao SM Mall',
                'address' => 'SM Mall, Davao City',
                'city' => 'Davao City',
                'contact_person' => 'Maria Santos',
                'contact_phone' => '+63 912 345 6790',
                'contact_email' => 'smmall@chakanoks.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'branch_code' => 'DAV-003',
                'branch_name' => 'Davao Abreeza',
                'address' => 'Abreeza Mall, Davao City',
                'city' => 'Davao City',
                'contact_person' => 'Pedro Cruz',
                'contact_phone' => '+63 912 345 6791',
                'contact_email' => 'abreeza@chakanoks.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'branch_code' => 'DAV-004',
                'branch_name' => 'Davao Gaisano',
                'address' => 'Gaisano Mall, Davao City',
                'city' => 'Davao City',
                'contact_person' => 'Ana Reyes',
                'contact_phone' => '+63 912 345 6792',
                'contact_email' => 'gaisano@chakanoks.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'branch_code' => 'DAV-005',
                'branch_name' => 'Davao Victoria Plaza',
                'address' => 'Victoria Plaza, Davao City',
                'city' => 'Davao City',
                'contact_person' => 'Carlos Mendoza',
                'contact_phone' => '+63 912 345 6793',
                'contact_email' => 'victoria@chakanoks.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'branch_code' => 'TAG-001',
                'branch_name' => 'Tagum New Branch',
                'address' => '456 New Street, Tagum City',
                'city' => 'Tagum City',
                'contact_person' => 'Elena Torres',
                'contact_phone' => '+63 912 345 6794',
                'contact_email' => 'tagum@chakanoks.com',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('branches')->insertBatch($data);
    }
}

