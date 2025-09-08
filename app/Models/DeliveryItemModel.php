<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryItemModel extends Model
{
    protected $table = 'delivery_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'delivery_id',
        'product_id',
        'expected_quantity',
        'received_quantity',
        'unit_cost',
        'condition_status',
        'batch_number',
        'expiry_date',
        'notes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'delivery_id' => 'required|integer',
        'product_id' => 'required|integer',
        'expected_quantity' => 'required|decimal',
        'received_quantity' => 'decimal',
        'unit_cost' => 'required|decimal',
        'condition_status' => 'in_list[good,damaged,expired,defective]'
    ];

    protected $validationMessages = [
        'delivery_id' => [
            'required' => 'Delivery ID is required',
            'integer' => 'Delivery ID must be an integer'
        ],
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be an integer'
        ],
        'expected_quantity' => [
            'required' => 'Expected quantity is required',
            'decimal' => 'Expected quantity must be a valid number'
        ],
        'received_quantity' => [
            'decimal' => 'Received quantity must be a valid number'
        ],
        'unit_cost' => [
            'required' => 'Unit cost is required',
            'decimal' => 'Unit cost must be a valid number'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get items by delivery ID
     */
    public function getItemsByDelivery($deliveryId)
    {
        return $this->select('delivery_items.*, products.product_name, products.product_code')
                   ->join('products', 'products.id = delivery_items.product_id')
                   ->where('delivery_id', $deliveryId)
                   ->orderBy('products.product_name', 'ASC')
                   ->findAll();
    }

    /**
     * Get items by condition status
     */
    public function getItemsByCondition($condition, $deliveryId = null)
    {
        $builder = $this->select('delivery_items.*, products.product_name, products.product_code, deliveries.delivery_date')
                       ->join('products', 'products.id = delivery_items.product_id')
                       ->join('deliveries', 'deliveries.id = delivery_items.delivery_id')
                       ->where('condition_status', $condition);
        
        if ($deliveryId) {
            $builder->where('delivery_id', $deliveryId);
        }
        
        return $builder->orderBy('delivery_items.created_at', 'DESC')->findAll();
    }

    /**
     * Get delivery completion status
     */
    public function getDeliveryCompletionStatus($deliveryId)
    {
        $items = $this->where('delivery_id', $deliveryId)->findAll();
        
        if (empty($items)) {
            return ['status' => 'pending', 'completion_rate' => 0];
        }
        
        $totalItems = count($items);
        $receivedItems = 0;
        $partialItems = 0;
        
        foreach ($items as $item) {
            if ($item['received_quantity'] > 0) {
                if ($item['received_quantity'] >= $item['expected_quantity']) {
                    $receivedItems++;
                } else {
                    $partialItems++;
                }
            }
        }
        
        $completionRate = ($receivedItems / $totalItems) * 100;
        
        if ($receivedItems === $totalItems) {
            $status = 'completed';
        } elseif ($receivedItems > 0 || $partialItems > 0) {
            $status = 'partial';
        } else {
            $status = 'pending';
        }
        
        return [
            'status' => $status,
            'completion_rate' => round($completionRate, 2),
            'total_items' => $totalItems,
            'received_items' => $receivedItems,
            'partial_items' => $partialItems
        ];
    }

    /**
     * Get items nearing expiry
     */
    public function getItemsNearingExpiry($days = 30, $branchId = null)
    {
        $futureDate = date('Y-m-d', strtotime("+{$days} days"));
        
        $builder = $this->select('delivery_items.*, products.product_name, products.product_code, deliveries.branch_id')
                       ->join('products', 'products.id = delivery_items.product_id')
                       ->join('deliveries', 'deliveries.id = delivery_items.delivery_id')
                       ->where('expiry_date <=', $futureDate)
                       ->where('expiry_date >=', date('Y-m-d'))
                       ->where('condition_status', 'good');
        
        if ($branchId) {
            $builder->where('deliveries.branch_id', $branchId);
        }
        
        return $builder->orderBy('expiry_date', 'ASC')->findAll();
    }

    /**
     * Update received quantities for delivery
     */
    public function updateReceivedQuantities($deliveryId, $items)
    {
        $this->db->transStart();
        
        foreach ($items as $item) {
            $this->where('delivery_id', $deliveryId)
                 ->where('product_id', $item['product_id'])
                 ->set([
                     'received_quantity' => $item['received_quantity'],
                     'condition_status' => $item['condition_status'] ?? 'good',
                     'notes' => $item['notes'] ?? null
                 ])
                 ->update();
        }
        
        $this->db->transComplete();
        
        return $this->db->transStatus();
    }
}
