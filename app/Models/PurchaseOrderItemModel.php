<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderItemModel extends Model
{
    protected $table = 'purchase_order_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'purchase_order_id', 'product_id', 'quantity', 'unit_price', 
        'total_price', 'received_quantity'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'purchase_order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|decimal|greater_than[0]',
        'unit_price' => 'required|decimal|greater_than[0]',
        'total_price' => 'required|decimal|greater_than_equal_to[0]',
        'received_quantity' => 'permit_empty|decimal|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getItemsByPurchaseOrder($poId)
    {
        return $this->select('purchase_order_items.*, products.product_name, products.product_code, products.unit')
                   ->join('products', 'products.id = purchase_order_items.product_id')
                   ->where('purchase_order_items.purchase_order_id', $poId)
                   ->findAll();
    }

    public function addItem($poId, $productId, $quantity, $unitPrice)
    {
        $totalPrice = $quantity * $unitPrice;
        
        return $this->insert([
            'purchase_order_id' => $poId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'received_quantity' => 0
        ]);
    }

    public function updateReceivedQuantity($itemId, $receivedQuantity)
    {
        return $this->update($itemId, ['received_quantity' => $receivedQuantity]);
    }

    public function calculateTotalAmount($poId)
    {
        $result = $this->select('SUM(total_price) as total')
                      ->where('purchase_order_id', $poId)
                      ->first();
        
        return $result['total'] ?? 0;
    }
}

