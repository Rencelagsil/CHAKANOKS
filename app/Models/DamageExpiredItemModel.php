<?php

namespace App\Models;

use CodeIgniter\Model;

class DamageExpiredItemModel extends Model
{
    protected $table = 'damage_expired_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_id',
        'branch_id',
        'damage_type',
        'quantity',
        'unit_cost',
        'total_loss',
        'expiry_date',
        'batch_number',
        'reason',
        'action_taken',
        'disposal_date',
        'disposal_method',
        'reported_by',
        'approved_by',
        'status'
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
        'damage_type' => 'required|in_list[damaged,expired,defective,contaminated,broken,other]',
        'quantity' => 'required|decimal',
        'unit_cost' => 'required|decimal',
        'total_loss' => 'required|decimal',
        'reported_by' => 'required|integer',
        'status' => 'in_list[reported,approved,disposed,completed]'
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be an integer'
        ],
        'branch_id' => [
            'required' => 'Branch ID is required',
            'integer' => 'Branch ID must be an integer'
        ],
        'damage_type' => [
            'required' => 'Damage type is required',
            'in_list' => 'Invalid damage type'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'decimal' => 'Quantity must be a valid number'
        ],
        'unit_cost' => [
            'required' => 'Unit cost is required',
            'decimal' => 'Unit cost must be a valid number'
        ],
        'total_loss' => [
            'required' => 'Total loss is required',
            'decimal' => 'Total loss must be a valid number'
        ],
        'reported_by' => [
            'required' => 'Reporter ID is required',
            'integer' => 'Reporter ID must be an integer'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['calculateTotalLoss'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['calculateTotalLoss'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Calculate total loss before insert/update
     */
    protected function calculateTotalLoss(array $data)
    {
        if (isset($data['data']['quantity']) && isset($data['data']['unit_cost'])) {
            $data['data']['total_loss'] = $data['data']['quantity'] * $data['data']['unit_cost'];
        }
        return $data;
    }

    /**
     * Get damage items by type
     */
    public function getDamageItemsByType($type, $branchId = null)
    {
        $builder = $this->select('damage_expired_items.*, products.product_name, products.product_code')
                       ->join('products', 'products.id = damage_expired_items.product_id')
                       ->where('damage_type', $type);
        
        if ($branchId) {
            $builder->where('damage_expired_items.branch_id', $branchId);
        }
        
        return $builder->orderBy('damage_expired_items.created_at', 'DESC')->findAll();
    }

    /**
     * Get pending approvals
     */
    public function getPendingApprovals($branchId = null)
    {
        $builder = $this->select('damage_expired_items.*, products.product_name, products.product_code, users.username as reported_by_name')
                       ->join('products', 'products.id = damage_expired_items.product_id')
                       ->join('users', 'users.id = damage_expired_items.reported_by', 'left')
                       ->where('damage_expired_items.status', 'reported');
        
        if ($branchId) {
            $builder->where('damage_expired_items.branch_id', $branchId);
        }
        
        return $builder->orderBy('damage_expired_items.created_at', 'DESC')->findAll();
    }

    /**
     * Get items by expiry date range
     */
    public function getItemsByExpiryRange($startDate, $endDate, $branchId = null)
    {
        $builder = $this->select('damage_expired_items.*, products.product_name, products.product_code')
                       ->join('products', 'products.id = damage_expired_items.product_id')
                       ->where('damage_type', 'expired')
                       ->where('expiry_date >=', $startDate)
                       ->where('expiry_date <=', $endDate);
        
        if ($branchId) {
            $builder->where('damage_expired_items.branch_id', $branchId);
        }
        
        return $builder->orderBy('expiry_date', 'ASC')->findAll();
    }

    /**
     * Get total loss by period
     */
    public function getTotalLossByPeriod($startDate, $endDate, $branchId = null)
    {
        $builder = $this->selectSum('total_loss')
                       ->where('created_at >=', $startDate)
                       ->where('created_at <=', $endDate);
        
        if ($branchId) {
            $builder->where('branch_id', $branchId);
        }
        
        $result = $builder->first();
        return $result['total_loss'] ?? 0;
    }
}
