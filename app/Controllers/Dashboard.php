<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\BranchModel;
use App\Models\PurchaseOrderModel;
use App\Models\StockMovementModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $inventoryModel;
    protected $branchModel;
    protected $purchaseOrderModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
        $this->branchModel = new BranchModel();
        $this->purchaseOrderModel = new PurchaseOrderModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function index()
    {
        // Get all branches for admin view
        $branches = $this->branchModel->getActiveBranches();
        
        // Get system-wide statistics
        $totalBranches = count($branches);
        $criticalStockItems = $this->inventoryModel->getCriticalStockItems();
        $pendingApprovals = $this->purchaseOrderModel->getPurchaseOrdersByStatus('pending');
        
        // Calculate total inventory value across all branches
        $totalInventoryValue = 0;
        foreach ($branches as $branch) {
            $totalInventoryValue += $this->inventoryModel->getInventoryValue($branch['id']);
        }
        
        $data = [
            'branches' => $branches,
            'totalBranches' => $totalBranches,
            'criticalStockItems' => $criticalStockItems,
            'pendingApprovals' => $pendingApprovals,
            'totalInventoryValue' => $totalInventoryValue,
            'user' => [
                'name' => session()->get('first_name') . ' ' . session()->get('last_name'),
                'role' => session()->get('role'),
                'branch_id' => session()->get('branch_id')
            ]
        ];

        return view('admin/dashboard', $data);
    }
}
