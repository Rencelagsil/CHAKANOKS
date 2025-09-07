<?php

namespace App\Models;

use CodeIgniter\Model;

class StockMovementModel extends Model
{
    protected $table = 'stock_movements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_id', 'branch_id', 'movement_type', 'quantity', 
        'reference_type', 'reference_id', 'notes', 'created_by'
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
        'movement_type' => 'required|in_list[in,out,adjustment,transfer_in,transfer_out]',
        'quantity' => 'required|decimal|greater_than[0]',
        'reference_type' => 'permit_empty|in_list[purchase_order,transfer,adjustment,delivery]',
        'reference_id' => 'permit_empty|integer',
        'notes' => 'permit_empty',
        'created_by' => 'required|integer'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getMovementsByProduct($productId, $branchId = null)
    {
        $builder = $this->select('stock_movements.*, products.product_name, products.product_code, users.first_name, users.last_name')
                       ->join('products', 'products.id = stock_movements.product_id')
                       ->join('users', 'users.id = stock_movements.created_by')
                       ->where('stock_movements.product_id', $productId);

        if ($branchId) {
            $builder->where('stock_movements.branch_id', $branchId);
        }

        return $builder->orderBy('stock_movements.created_at', 'DESC')->findAll();
    }

    public function getMovementsByBranch($branchId, $limit = 50)
    {
        return $this->select('stock_movements.*, products.product_name, products.product_code, users.first_name, users.last_name')
                   ->join('products', 'products.id = stock_movements.product_id')
                   ->join('users', 'users.id = stock_movements.created_by')
                   ->where('stock_movements.branch_id', $branchId)
                   ->orderBy('stock_movements.created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function addMovement($productId, $branchId, $movementType, $quantity, $referenceType = null, $referenceId = null, $notes = null, $createdBy = null)
    {
        return $this->insert([
            'product_id' => $productId,
            'branch_id' => $branchId,
            'movement_type' => $movementType,
            'quantity' => $quantity,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
            'created_by' => $createdBy
        ]);
    }

    public function getRecentMovements($branchId = null, $limit = 20)
    {
        $builder = $this->select('stock_movements.*, products.product_name, products.product_code, branches.branch_name, users.first_name, users.last_name')
                       ->join('products', 'products.id = stock_movements.product_id')
                       ->join('branches', 'branches.id = stock_movements.branch_id')
                       ->join('users', 'users.id = stock_movements.created_by');

        if ($branchId) {
            $builder->where('stock_movements.branch_id', $branchId);
        }

        return $builder->orderBy('stock_movements.created_at', 'DESC')
                      ->limit($limit)
                      ->findAll();
    }
}

