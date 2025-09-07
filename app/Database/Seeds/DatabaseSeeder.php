<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('BranchSeeder');
        $this->call('SupplierSeeder');
        $this->call('UserSeeder');
        $this->call('ProductSeeder');
        $this->call('InventorySeeder');
    }
}

