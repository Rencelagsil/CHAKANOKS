<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'report_type' => [
                'type' => 'ENUM',
                'constraint' => ['stock_level', 'low_stock', 'expiry', 'damage', 'movement', 'valuation'],
            ],
            'report_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'branch_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'date_range_start' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'date_range_end' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'filters' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'export_format' => [
                'type' => 'ENUM',
                'constraint' => ['csv', 'pdf', 'excel'],
                'default' => 'csv',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'records_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'generated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('branch_id');
        $this->forge->addKey('generated_by');
        $this->forge->addKey(['report_type', 'created_at']);
        $this->forge->createTable('inventory_reports');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_reports');
    }
}
