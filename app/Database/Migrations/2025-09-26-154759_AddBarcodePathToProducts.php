<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBarcodePathToProducts extends Migration
{
    public function up()
    {
        $fields = [
            'barcode_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'barcode',
            ],
        ];

        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'barcode_path');
    }
}
