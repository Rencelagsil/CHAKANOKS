<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [ 
                'branch_code' => 'DVO-01', 
                'branch_name' => 'ChakaNoks Matina', 
                'city' => 'Davao City', 
                'address' => 'Matina, Davao City', 
                'contact_person' => 'Maria Santos',
                'contact_phone' => '09171234567',
                'contact_email' => 'matina@chakanoks.com',
                'is_active' => 1 
            ],
            [ 
                'branch_code' => 'DVO-02', 
                'branch_name' => 'ChakaNoks Bajada', 
                'city' => 'Davao City', 
                'address' => 'Bajada, Davao City', 
                'contact_person' => 'Juan Dela Cruz',
                'contact_phone' => '09179876543',
                'contact_email' => 'bajada@chakanoks.com',
                'is_active' => 1 
            ],
            [ 
                'branch_code' => 'DVO-03', 
                'branch_name' => 'ChakaNoks Toril', 
                'city' => 'Davao City', 
                'address' => 'Toril, Davao City', 
                'contact_person' => 'Ana Rodriguez',
                'contact_phone' => '09175551234',
                'contact_email' => 'toril@chakanoks.com',
                'is_active' => 1 
            ],
            [ 
                'branch_code' => 'DVO-04', 
                'branch_name' => 'ChakaNoks Buhangin', 
                'city' => 'Davao City', 
                'address' => 'Buhangin, Davao City', 
                'contact_person' => 'Pedro Martinez',
                'contact_phone' => '09174445678',
                'contact_email' => 'buhangin@chakanoks.com',
                'is_active' => 1 
            ],
            [ 
                'branch_code' => 'DVO-05', 
                'branch_name' => 'ChakaNoks Lanang', 
                'city' => 'Davao City', 
                'address' => 'Lanang, Davao City', 
                'contact_person' => 'Lisa Garcia',
                'contact_phone' => '09173338901',
                'contact_email' => 'lanang@chakanoks.com',
                'is_active' => 1 
            ],
        ];

        $this->db->table('branches')->ignore(true)->insertBatch($data);
    }
}

