<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\BranchModel;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class Staff extends Controller
{
    protected $inventoryModel;
    protected $branchModel;
    protected $productModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
        $this->branchModel = new BranchModel();
        $this->productModel = new ProductModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function index()
    {
        $branchId = session()->get('branch_id');
        
        if (!$branchId) {
            return redirect()->to('/login')->with('error', 'Branch not assigned to user.');
        }

        $branch = $this->branchModel->find($branchId);
        $inventory = $this->inventoryModel->getInventoryByBranch($branchId);
        $lowStockItems = $this->inventoryModel->getLowStockItems($branchId);
        $criticalStockItems = $this->inventoryModel->getCriticalStockItems($branchId);
        $recentMovements = $this->stockMovementModel->getMovementsByBranch($branchId, 10);
        
        $data = [
            'branch' => $branch,
            'inventory' => $inventory,
            'lowStockItems' => $lowStockItems,
            'criticalStockItems' => $criticalStockItems,
            'recentMovements' => $recentMovements,
            'totalInventoryValue' => $this->inventoryModel->getInventoryValue($branchId),
            'user' => [
                'name' => session()->get('first_name') . ' ' . session()->get('last_name'),
                'role' => session()->get('role'),
                'branch_id' => session()->get('branch_id')
            ]
        ];

        return view('inventory/dashboard', $data);
    }

    // Views for sidebar items
    public function stockLevels()
    {
        return view('inventory/stock_levels');
    }

    public function deliveries()
    {
        return view('inventory/deliveries');
    }

    public function damagesExpired()
    {
        return view('inventory/damages_expired');
    }

    public function reports()
    {
        return view('inventory/reports');
    }

    public function adjustStock()
    {
        $branchId = session()->get('branch_id');
        $userId = session()->get('user_id');
        
        $productId = $this->request->getPost('product_id');
        $newQuantity = $this->request->getPost('new_quantity');
        $notes = $this->request->getPost('notes');
        
        if (!$productId || !$newQuantity) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required data']);
        }

        // Get current stock
        $inventory = $this->inventoryModel->where('product_id', $productId)
                                        ->where('branch_id', $branchId)
                                        ->first();
        
        if (!$inventory) {
            return $this->response->setJSON(['success' => false, 'message' => 'Inventory record not found']);
        }

        $oldQuantity = $inventory['current_stock'];
        $difference = $newQuantity - $oldQuantity;
        
        // Update inventory
        if ($this->inventoryModel->updateStock($productId, $branchId, $newQuantity, 'adjustment')) {
            // Record stock movement
            $movementType = $difference > 0 ? 'in' : 'out';
            $this->stockMovementModel->addMovement(
                $productId, 
                $branchId, 
                $movementType, 
                abs($difference), 
                'adjustment', 
                null, 
                $notes, 
                $userId
            );
            
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Stock adjusted successfully',
                'old_quantity' => $oldQuantity,
                'new_quantity' => $newQuantity
            ]);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to adjust stock']);
    }

    public function receiveDelivery()
    {
        $branchId = session()->get('branch_id');
        $userId = session()->get('user_id');
        
        $productId = $this->request->getPost('product_id');
        $receivedQuantity = $this->request->getPost('received_quantity');
        $notes = $this->request->getPost('notes');
        
        if (!$productId || !$receivedQuantity) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required data']);
        }

        // Update inventory
        if ($this->inventoryModel->updateStock($productId, $branchId, $receivedQuantity, 'in')) {
            // Record stock movement
            $this->stockMovementModel->addMovement(
                $productId, 
                $branchId, 
                'in', 
                $receivedQuantity, 
                'delivery', 
                null, 
                $notes, 
                $userId
            );
            
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Delivery received successfully'
            ]);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to receive delivery']);
    }
}
