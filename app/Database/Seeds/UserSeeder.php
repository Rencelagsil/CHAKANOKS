<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@chakanoks.test',
                'password' => $password,
                'first_name' => 'System',
                'last_name' => 'Admin',
                'role' => 'admin',
                'branch_id' => null,
                'is_active' => 1,
            ],
            [
                'username' => 'bm_dvo01',
                'email' => 'bm_dvo01@chakanoks.test',
                'password' => $password,
                'first_name' => 'Branch',
                'last_name' => 'Manager',
                'role' => 'branch_manager',
                'branch_id' => 1,
                'is_active' => 1,
            ],
            [
                'username' => 'staff_dvo01',
                'email' => 'staff_dvo01@chakanoks.test',
                'password' => $password,
                'first_name' => 'Inventory',
                'last_name' => 'Staff',
                'role' => 'inventory_staff',
                'branch_id' => 1,
                'is_active' => 1,
            ],
        ];

        $this->db->table('users')->ignore(true)->insertBatch($data);
    }
}

