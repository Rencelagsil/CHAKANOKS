<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [ 'branch_code' => 'DVO-01', 'branch_name' => 'ChakaNoks Matina', 'city' => 'Davao City', 'address' => 'Matina, Davao City', 'is_active' => 1 ],
            [ 'branch_code' => 'DVO-02', 'branch_name' => 'ChakaNoks Bajada', 'city' => 'Davao City', 'address' => 'Bajada, Davao City', 'is_active' => 1 ],
            [ 'branch_code' => 'DVO-03', 'branch_name' => 'ChakaNoks Toril', 'city' => 'Davao City', 'address' => 'Toril, Davao City', 'is_active' => 1 ],
            [ 'branch_code' => 'DVO-04', 'branch_name' => 'ChakaNoks Buhangin', 'city' => 'Davao City', 'address' => 'Buhangin, Davao City', 'is_active' => 1 ],
            [ 'branch_code' => 'DVO-05', 'branch_name' => 'ChakaNoks Lanang', 'city' => 'Davao City', 'address' => 'Lanang, Davao City', 'is_active' => 1 ],
        ];

        $this->db->table('branches')->ignore(true)->insertBatch($data);
    }
}

