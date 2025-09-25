<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryModel extends Model
{
	protected $table = 'deliveries';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	protected $protectFields = true;
	protected $allowedFields = [
		'delivery_number',
		'purchase_order_id',
		'supplier_id',
		'branch_id',
		'status',
		'scheduled_date',
		'delivered_date',
		'driver_name',
		'vehicle_number',
		'notes',
	];

	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';

	protected $validationRules = [
		'delivery_number' => 'required|min_length[5]|max_length[50]|is_unique[deliveries.delivery_number,id,{id}]',
		'purchase_order_id' => 'required|integer',
		'supplier_id' => 'required|integer',
		'branch_id' => 'required|integer',
		'status' => 'required|in_list[scheduled,in_transit,delivered,cancelled]',
		'scheduled_date' => 'required|valid_date',
		'delivered_date' => 'permit_empty|valid_date',
		'driver_name' => 'permit_empty|max_length[255]',
		'vehicle_number' => 'permit_empty|max_length[50]',
	];

	public function generateDeliveryNumber(): string
	{
		$prefix = 'DLV-' . date('Y') . '-';
		$last = $this->like('delivery_number', $prefix)
			->orderBy('delivery_number', 'DESC')
			->first();

		if ($last) {
			$lastNumber = (int) substr($last['delivery_number'], -4);
			$newNumber = $lastNumber + 1;
		} else {
			$newNumber = 1;
		}

		return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
	}

	public function getDeliveriesByBranch(int $branchId): array
	{
		return $this->select('deliveries.*, suppliers.company_name as supplier_name')
			->join('suppliers', 'suppliers.id = deliveries.supplier_id', 'left')
			->where('deliveries.branch_id', $branchId)
			->orderBy('deliveries.created_at', 'DESC')
			->findAll();
	}

	public function updateStatus(int $deliveryId, string $status): bool
	{
		$fields = ['status' => $status];
		if ($status === 'delivered') {
			$fields['delivered_date'] = date('Y-m-d H:i:s');
		}
		return (bool) $this->update($deliveryId, $fields);
	}
}


