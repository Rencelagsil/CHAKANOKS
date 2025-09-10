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

    // API: Inventory data for branch manager inventory view
    public function apiInventoryData()
    {
        $branchId = session()->get('branch_id');
        if (!$branchId) {
            // Fallback to first active branch (useful for local testing)
            $fallback = $this->branchModel->where('is_active', 1)->orderBy('id', 'ASC')->first();
            if ($fallback) {
                $branchId = $fallback['id'];
            }
        }
        if (!$branchId) {
            return $this->response->setJSON(['success' => false, 'error' => 'No branch available'])->setStatusCode(401);
        }

        $items = $this->inventoryModel
            ->select('products.id as id, inventory.id as inventory_id, products.product_code, products.product_name, products.category, products.unit_price, inventory.current_stock, inventory.min_stock_level, inventory.max_stock_level, inventory.reorder_point, inventory.last_updated')
            ->join('products', 'products.id = inventory.product_id')
            ->where('inventory.branch_id', $branchId)
            ->where('products.is_active', 1)
            ->orderBy('products.product_name', 'ASC')
            ->findAll();

        return $this->response->setJSON(['success' => true, 'data' => $items]);
    }

    // API: Critical stock alerts
    public function apiCriticalAlerts()
    {
        $branchId = session()->get('branch_id');
        if (!$branchId) {
            $fallback = $this->branchModel->where('is_active', 1)->orderBy('id', 'ASC')->first();
            if ($fallback) {
                $branchId = $fallback['id'];
            }
        }
        if (!$branchId) {
            return $this->response->setJSON(['success' => false, 'error' => 'No branch available'])->setStatusCode(401);
        }

        $alerts = $this->inventoryModel
            ->select('products.product_name, inventory.current_stock, inventory.min_stock_level')
            ->join('products', 'products.id = inventory.product_id')
            ->where('inventory.branch_id', $branchId)
            ->where('products.is_active', 1)
            ->where('inventory.current_stock <= inventory.min_stock_level')
            ->orderBy('products.product_name', 'ASC')
            ->findAll();

        return $this->response->setJSON(['success' => true, 'data' => $alerts]);
    }

    // API: Adjust stock for quick adjustment in inventory view
    public function apiAdjustStock()
    {
        $branchId = session()->get('branch_id');
        if (!$branchId) {
            return $this->response->setJSON(['success' => false, 'error' => 'Branch not assigned'])->setStatusCode(401);
        }

        $payload = $this->request->getJSON(true) ?? $this->request->getPost();

        $productId = isset($payload['product_id']) ? (int) $payload['product_id'] : 0;
        $type = $payload['type'] ?? '';
        $quantity = isset($payload['quantity']) ? (int) $payload['quantity'] : 0;

        if ($productId <= 0 || $quantity <= 0 || !in_array($type, ['add', 'remove', 'set'], true)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid input'])->setStatusCode(400);
        }

        $movementType = $type === 'add' ? 'in' : ($type === 'remove' ? 'out' : 'adjustment');

        $ok = $this->inventoryModel->updateStock($productId, $branchId, $quantity, $movementType);
        if (!$ok) {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update stock'])->setStatusCode(422);
        }

        return $this->response->setJSON(['success' => true]);
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
