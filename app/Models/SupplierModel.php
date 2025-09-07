<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'supplier_code', 'company_name', 'contact_person', 'email', 
        'phone', 'address', 'city', 'payment_terms', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'supplier_code' => 'required|min_length[2]|max_length[20]|is_unique[suppliers.supplier_code,id,{id}]',
        'company_name' => 'required|min_length[2]|max_length[255]',
        'contact_person' => 'required|min_length[2]|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'address' => 'required|min_length[10]',
        'city' => 'required|min_length[2]|max_length[100]',
        'payment_terms' => 'permit_empty|max_length[100]',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getActiveSuppliers()
    {
        return $this->where('is_active', 1)->findAll();
    }

    public function getSupplierByCode($code)
    {
        return $this->where('supplier_code', $code)->first();
    }
}

