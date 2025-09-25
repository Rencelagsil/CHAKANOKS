<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitializeSchema extends Migration
{
    public function up()
    {
        // branches
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'branch_code' => [ 'type' => 'VARCHAR', 'constraint' => 20 ],
            'branch_name' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'address' => [ 'type' => 'TEXT', 'null' => true ],
            'city' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'contact_person' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'contact_phone' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'null' => true ],
            'contact_email' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'is_active' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 1 ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('branch_code');
        $this->forge->createTable('branches', true);

        // users
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'username' => [ 'type' => 'VARCHAR', 'constraint' => 100 ],
            'email' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'password' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'first_name' => [ 'type' => 'VARCHAR', 'constraint' => 100 ],
            'last_name' => [ 'type' => 'VARCHAR', 'constraint' => 100 ],
            'role' => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true ],
            'is_active' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 1 ],
            'last_login' => [ 'type' => 'DATETIME', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('users', true);

        // suppliers
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'supplier_code' => [ 'type' => 'VARCHAR', 'constraint' => 20 ],
            'company_name' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'contact_person' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'email' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'phone' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'null' => true ],
            'address' => [ 'type' => 'TEXT', 'null' => true ],
            'city' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'payment_terms' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'is_active' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 1 ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('supplier_code');
        $this->forge->createTable('suppliers', true);

        // products
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'product_code' => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'product_name' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'description' => [ 'type' => 'TEXT', 'null' => true ],
            'category' => [ 'type' => 'VARCHAR', 'constraint' => 100 ],
            'unit' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'null' => true ],
            'unit_price' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'stock' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'supplier_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'barcode' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'barcode_path' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'is_perishable' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 0 ],
            'shelf_life_days' => [ 'type' => 'INT', 'constraint' => 11, 'null' => true ],
            'is_active' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 1 ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('product_code');
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('products', true);

        // inventory
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'product_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'current_stock' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'min_stock_level' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'max_stock_level' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'reorder_point' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'last_updated' => [ 'type' => 'DATETIME', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['product_id', 'branch_id']);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventory', true);

        // stock_movements
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'product_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'movement_type' => [ 'type' => 'VARCHAR', 'constraint' => 30 ],
            'quantity' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'reference_type' => [ 'type' => 'VARCHAR', 'constraint' => 50, 'null' => true ],
            'reference_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true ],
            'notes' => [ 'type' => 'TEXT', 'null' => true ],
            'created_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('stock_movements', true);

        // purchase_orders
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'po_number' => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'supplier_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'requested_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'status' => [ 'type' => 'VARCHAR', 'constraint' => 30, 'default' => 'draft' ],
            'total_amount' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'notes' => [ 'type' => 'TEXT', 'null' => true ],
            'requested_date' => [ 'type' => 'DATETIME', 'null' => true ],
            'approved_date' => [ 'type' => 'DATETIME', 'null' => true ],
            'approved_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true ],
            'expected_delivery' => [ 'type' => 'DATETIME', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('po_number');
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('requested_by', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('purchase_orders', true);

        // purchase_order_items
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'purchase_order_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'product_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'quantity' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'unit_price' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'total_price' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'received_quantity' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_order_id', 'purchase_orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('purchase_order_items', true);

        // deliveries
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'delivery_number' => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'purchase_order_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'supplier_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'status' => [ 'type' => 'VARCHAR', 'constraint' => 30, 'default' => 'scheduled' ],
            'scheduled_date' => [ 'type' => 'DATETIME', 'null' => true ],
            'delivered_date' => [ 'type' => 'DATETIME', 'null' => true ],
            'driver_name' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'vehicle_number' => [ 'type' => 'VARCHAR', 'constraint' => 50, 'null' => true ],
            'notes' => [ 'type' => 'TEXT', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('delivery_number');
        $this->forge->addForeignKey('purchase_order_id', 'purchase_orders', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('deliveries', true);

        // delivery_items
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'delivery_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'product_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'expected_quantity' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'received_quantity' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'unit_cost' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'condition_status' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'default' => 'good' ],
            'batch_number' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'expiry_date' => [ 'type' => 'DATE', 'null' => true ],
            'notes' => [ 'type' => 'TEXT', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('delivery_id', 'deliveries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('delivery_items', true);

        // damage_expired_items
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'product_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'damage_type' => [ 'type' => 'VARCHAR', 'constraint' => 20 ],
            'quantity' => [ 'type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000' ],
            'unit_cost' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'total_loss' => [ 'type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00' ],
            'expiry_date' => [ 'type' => 'DATE', 'null' => true ],
            'batch_number' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'reason' => [ 'type' => 'TEXT', 'null' => true ],
            'action_taken' => [ 'type' => 'TEXT', 'null' => true ],
            'disposal_date' => [ 'type' => 'DATETIME', 'null' => true ],
            'disposal_method' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
            'reported_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'approved_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true ],
            'status' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'default' => 'reported' ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reported_by', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('damage_expired_items', true);

        // inventory_reports
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'report_type' => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'report_name' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'branch_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'date_range_start' => [ 'type' => 'DATETIME', 'null' => true ],
            'date_range_end' => [ 'type' => 'DATETIME', 'null' => true ],
            'filters' => [ 'type' => 'TEXT', 'null' => true ],
            'export_format' => [ 'type' => 'VARCHAR', 'constraint' => 20, 'null' => true ],
            'file_path' => [ 'type' => 'VARCHAR', 'constraint' => 255, 'null' => true ],
            'records_count' => [ 'type' => 'INT', 'constraint' => 11, 'default' => 0 ],
            'generated_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('generated_by', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('inventory_reports', true);
    }

    public function down()
    {
        $this->forge->dropTable('inventory_reports', true);
        $this->forge->dropTable('damage_expired_items', true);
        $this->forge->dropTable('delivery_items', true);
        $this->forge->dropTable('deliveries', true);
        $this->forge->dropTable('purchase_order_items', true);
        $this->forge->dropTable('purchase_orders', true);
        $this->forge->dropTable('stock_movements', true);
        $this->forge->dropTable('inventory', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('suppliers', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('branches', true);
    }
}


