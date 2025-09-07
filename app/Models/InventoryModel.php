<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_id', 'branch_id', 'current_stock', 'min_stock_level', 
        'max_stock_level', 'reorder_point', 'last_updated'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'product_id' => 'required|integer',
        'branch_id' => 'required|integer',
        'current_stock' => 'required|decimal|greater_than_equal_to[0]',
        'min_stock_level' => 'required|decimal|greater_than_equal_to[0]',
        'max_stock_level' => 'required|decimal|greater_than_equal_to[0]',
        'reorder_point' => 'required|decimal|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getInventoryByBranch($branchId)
    {
        return $this->select('inventory.*, products.product_name, products.product_code, products.unit, products.unit_price')
                   ->join('products', 'products.id = inventory.product_id')
                   ->where('inventory.branch_id', $branchId)
                   ->where('products.is_active', 1)
                   ->findAll();
    }

    public function getLowStockItems($branchId = null)
    {
        $builder = $this->select('inventory.*, products.product_name, products.product_code, products.unit')
                       ->join('products', 'products.id = inventory.product_id')
                       ->where('inventory.current_stock <= inventory.reorder_point')
                       ->where('products.is_active', 1);

        if ($branchId) {
            $builder->where('inventory.branch_id', $branchId);
        }

        return $builder->findAll();
    }

    public function getCriticalStockItems($branchId = null)
    {
        $builder = $this->select('inventory.*, products.product_name, products.product_code, products.unit')
                       ->join('products', 'products.id = inventory.product_id')
                       ->where('inventory.current_stock <= inventory.min_stock_level')
                       ->where('products.is_active', 1);

        if ($branchId) {
            $builder->where('inventory.branch_id', $branchId);
        }

        return $builder->findAll();
    }

    public function updateStock($productId, $branchId, $quantity, $movementType = 'adjustment')
    {
        $inventory = $this->where('product_id', $productId)
                         ->where('branch_id', $branchId)
                         ->first();

        if (!$inventory) {
            return false;
        }

        $newStock = $inventory['current_stock'];
        if ($movementType === 'in') {
            $newStock += $quantity;
        } elseif ($movementType === 'out') {
            $newStock -= $quantity;
        } else {
            $newStock = $quantity; // adjustment
        }

        if ($newStock < 0) {
            return false; // Cannot have negative stock
        }

        $this->update($inventory['id'], [
            'current_stock' => $newStock,
            'last_updated' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    public function getInventoryValue($branchId = null)
    {
        $builder = $this->select('SUM(inventory.current_stock * products.unit_price) as total_value')
                       ->join('products', 'products.id = inventory.product_id')
                       ->where('products.is_active', 1);

        if ($branchId) {
            $builder->where('inventory.branch_id', $branchId);
        }

        $result = $builder->first();
        return $result['total_value'] ?? 0;
    }
}

