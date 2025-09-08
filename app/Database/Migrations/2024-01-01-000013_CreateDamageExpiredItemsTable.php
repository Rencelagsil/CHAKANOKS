<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDamageExpiredItemsTable extends Migration
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
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'branch_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'damage_type' => [
                'type' => 'ENUM',
                'constraint' => ['damaged', 'expired', 'defective', 'contaminated', 'broken', 'other'],
            ],
            'quantity' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'unit_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'total_loss' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'expiry_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'batch_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'action_taken' => [
                'type' => 'ENUM',
                'constraint' => ['disposed', 'returned_supplier', 'donated', 'recycled', 'pending'],
                'default' => 'pending',
            ],
            'disposal_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'disposal_method' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reported_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['reported', 'approved', 'disposed', 'completed'],
                'default' => 'reported',
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
        $this->forge->addKey(['product_id', 'branch_id']);
        $this->forge->addKey('reported_by');
        $this->forge->addKey('approved_by');
        $this->forge->addKey(['damage_type', 'status']);
        $this->forge->createTable('damage_expired_items');
    }

    public function down()
    {
        $this->forge->dropTable('damage_expired_items');
    }
}
