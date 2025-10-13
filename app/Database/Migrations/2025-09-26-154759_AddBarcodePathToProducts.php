<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBarcodePathToProducts extends Migration
{
    public function up()
    {
        // Check if barcode_path column already exists
        if (!$this->db->fieldExists('barcode_path', 'products')) {
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
    }

    public function down()
    {
        // Only drop column if it exists
        if ($this->db->fieldExists('barcode_path', 'products')) {
            $this->forge->dropColumn('products', 'barcode_path');
        }
    }
}
