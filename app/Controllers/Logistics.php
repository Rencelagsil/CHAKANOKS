<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DeliveryModel;
use App\Models\DeliveryItemModel;
use App\Models\PurchaseOrderModel;
use App\Models\InventoryModel;

class Logistics extends Controller
{
    protected $deliveryModel;
    protected $deliveryItemModel;
    protected $purchaseOrderModel;
    protected $inventoryModel;

    public function __construct()
    {
        $this->deliveryModel = new DeliveryModel();
        $this->deliveryItemModel = new DeliveryItemModel();
        $this->purchaseOrderModel = new PurchaseOrderModel();
        $this->inventoryModel = new InventoryModel();
    }

    public function index()
    {
        return view('logistics/dashboard');
    }

    // API: Create/schedule a delivery from an approved PO
    public function scheduleDelivery()
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getPost();

        $poId = (int) ($payload['purchase_order_id'] ?? 0);
        $scheduledDate = $payload['scheduled_date'] ?? null;
        $driverName = $payload['driver_name'] ?? null;
        $vehicleNumber = $payload['vehicle_number'] ?? null;
        $notes = $payload['notes'] ?? null;

        if ($poId <= 0 || !$scheduledDate) {
            return $this->response->setJSON(['success' => false, 'error' => 'Missing required data'])->setStatusCode(400);
        }

        $po = $this->purchaseOrderModel->find($poId);
        if (!$po || !in_array($po['status'], ['approved', 'ordered'], true)) {
            return $this->response->setJSON(['success' => false, 'error' => 'PO not approved or not found'])->setStatusCode(422);
        }

        $deliveryData = [
            'delivery_number' => $this->deliveryModel->generateDeliveryNumber(),
            'purchase_order_id' => $poId,
            'supplier_id' => $po['supplier_id'],
            'branch_id' => $po['branch_id'],
            'status' => 'scheduled',
            'scheduled_date' => $scheduledDate,
            'driver_name' => $driverName,
            'vehicle_number' => $vehicleNumber,
            'notes' => $notes,
        ];

        $deliveryId = $this->deliveryModel->insert($deliveryData);
        if (!$deliveryId) {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to create delivery'])->setStatusCode(500);
        }

        // Optionally mark PO as ordered
        if ($po['status'] === 'approved') {
            $this->purchaseOrderModel->update($poId, ['status' => 'ordered']);
        }

        return $this->response->setJSON(['success' => true, 'delivery_id' => $deliveryId]);
    }

    // API: Update delivery status (scheduled -> in_transit -> delivered/cancelled)
    public function updateDeliveryStatus($deliveryId)
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getPost();
        $status = $payload['status'] ?? '';

        if (!in_array($status, ['scheduled', 'in_transit', 'delivered', 'cancelled'], true)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid status'])->setStatusCode(400);
        }

        $ok = $this->deliveryModel->updateStatus((int) $deliveryId, $status);
        if (!$ok) {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update status'])->setStatusCode(500);
        }

        return $this->response->setJSON(['success' => true]);
    }

    // API: List deliveries with optional branch filter
    public function listDeliveries()
    {
        $branchId = (int) ($this->request->getGet('branch_id') ?? 0);
        if ($branchId > 0) {
            $data = $this->deliveryModel->getDeliveriesByBranch($branchId);
        } else {
            $data = $this->deliveryModel->orderBy('created_at', 'DESC')->findAll();
        }
        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
}
