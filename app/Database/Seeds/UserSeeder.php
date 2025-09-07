<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@chakanoks.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'role' => 'admin',
                'branch_id' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'manager',
                'email' => 'manager@chakanoks.com',
                'password' => password_hash('manager123', PASSWORD_DEFAULT),
                'first_name' => 'John',
                'last_name' => 'Santos',
                'role' => 'branch_manager',
                'branch_id' => 1,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'maria',
                'email' => 'maria@chakanoks.com',
                'password' => password_hash('maria123', PASSWORD_DEFAULT),
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'role' => 'inventory_staff',
                'branch_id' => 2,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'pedro',
                'email' => 'pedro@chakanoks.com',
                'password' => password_hash('pedro123', PASSWORD_DEFAULT),
                'first_name' => 'Pedro',
                'last_name' => 'Cruz',
                'role' => 'inventory_staff',
                'branch_id' => 3,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'logistics',
                'email' => 'logistics@chakanoks.com',
                'password' => password_hash('logistics123', PASSWORD_DEFAULT),
                'first_name' => 'Carlos',
                'last_name' => 'Mendoza',
                'role' => 'logistics_coordinator',
                'branch_id' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'supplier1',
                'email' => 'supplier1@freshfoods.com',
                'password' => password_hash('supplier123', PASSWORD_DEFAULT),
                'first_name' => 'Roberto',
                'last_name' => 'Garcia',
                'role' => 'supplier',
                'branch_id' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}

