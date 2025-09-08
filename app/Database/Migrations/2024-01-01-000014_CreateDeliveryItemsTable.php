<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDeliveryItemsTable extends Migration
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
            'delivery_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'expected_quantity' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'received_quantity' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'unit_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'condition_status' => [
                'type' => 'ENUM',
                'constraint' => ['good', 'damaged', 'expired', 'defective'],
                'default' => 'good',
            ],
            'batch_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'expiry_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('delivery_id');
        $this->forge->addKey('product_id');
        $this->forge->addKey(['delivery_id', 'product_id']);
        $this->forge->createTable('delivery_items');
    }

    public function down()
    {
        $this->forge->dropTable('delivery_items');
    }
}
