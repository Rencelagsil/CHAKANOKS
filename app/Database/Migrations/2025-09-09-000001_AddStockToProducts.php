<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStockToProducts extends Migration
{
    public function up()
    {
        $fields = [
            'stock' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
                'null' => false,
                'after' => 'unit_price',
            ],
        ];

        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'stock');
    }
}




