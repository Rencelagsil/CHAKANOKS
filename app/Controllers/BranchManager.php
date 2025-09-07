<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\PurchaseOrderModel;
use App\Models\BranchModel;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class BranchManager extends Controller
{
    protected $inventoryModel;
    protected $purchaseOrderModel;
    protected $branchModel;
    protected $productModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
        $this->purchaseOrderModel = new PurchaseOrderModel();
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
        $purchaseOrders = $this->purchaseOrderModel->getPurchaseOrdersByBranch($branchId);
        $pendingApprovals = $this->purchaseOrderModel->getPurchaseOrdersByStatus('pending');
        $recentMovements = $this->stockMovementModel->getMovementsByBranch($branchId, 10);
        
        $data = [
            'branch' => $branch,
            'inventory' => $inventory,
            'lowStockItems' => $lowStockItems,
            'criticalStockItems' => $criticalStockItems,
            'purchaseOrders' => $purchaseOrders,
            'pendingApprovals' => $pendingApprovals,
            'recentMovements' => $recentMovements,
            'totalInventoryValue' => $this->inventoryModel->getInventoryValue($branchId),
            'user' => [
                'name' => session()->get('first_name') . ' ' . session()->get('last_name'),
                'role' => session()->get('role'),
                'branch_id' => session()->get('branch_id')
            ]
        ];

        return view('branchmanager/dashboard', $data);
    }

    // Views for sidebar items
    public function inventory()
    {
        return view('branchmanager/inventory');
    }

    public function purchaseRequests()
    {
        return view('branchmanager/purchase_requests');
    }

    public function transfers()
    {
        return view('branchmanager/transfers');
    }

    public function reports()
    {
        return view('branchmanager/reports');
    }

    public function createPurchaseOrder()
    {
        $branchId = session()->get('branch_id');
        $requestedBy = session()->get('user_id');
        
        $supplierId = $this->request->getPost('supplier_id');
        $items = $this->request->getPost('items');
        $notes = $this->request->getPost('notes');
        
        if (!$supplierId || !$items) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required data']);
        }

        // Create purchase order
        $poData = [
            'po_number' => $this->purchaseOrderModel->generatePONumber(),
            'supplier_id' => $supplierId,
            'branch_id' => $branchId,
            'requested_by' => $requestedBy,
            'status' => 'pending',
            'total_amount' => 0,
            'notes' => $notes,
            'requested_date' => date('Y-m-d H:i:s')
        ];

        $poId = $this->purchaseOrderModel->insert($poData);
        
        if ($poId) {
            $poItemModel = new \App\Models\PurchaseOrderItemModel();
            $totalAmount = 0;
            
            foreach ($items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $totalAmount += $itemTotal;
                
                $poItemModel->addItem($poId, $item['product_id'], $item['quantity'], $item['unit_price']);
            }
            
            // Update total amount
            $this->purchaseOrderModel->update($poId, ['total_amount' => $totalAmount]);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Purchase order created successfully', 'po_id' => $poId]);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to create purchase order']);
    }

    public function approvePurchaseOrder($poId)
    {
        $approvedBy = session()->get('user_id');
        
        if ($this->purchaseOrderModel->approvePurchaseOrder($poId, $approvedBy)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Purchase order approved']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to approve purchase order']);
    }

    public function rejectPurchaseOrder($poId)
    {
        $approvedBy = session()->get('user_id');
        
        if ($this->purchaseOrderModel->rejectPurchaseOrder($poId, $approvedBy)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Purchase order rejected']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to reject purchase order']);
    }
}
