<?php

namespace App\Models;

use CodeIgniter\Model;

class BranchModel extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'branch_code', 'branch_name', 'address', 'city', 
        'contact_person', 'contact_phone', 'contact_email', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'branch_code' => 'required|min_length[2]|max_length[20]|is_unique[branches.branch_code,id,{id}]',
        'branch_name' => 'required|min_length[2]|max_length[255]',
        'address' => 'required|min_length[10]',
        'city' => 'required|min_length[2]|max_length[100]',
        'contact_person' => 'required|min_length[2]|max_length[255]',
        'contact_phone' => 'required|min_length[10]|max_length[20]',
        'contact_email' => 'required|valid_email|max_length[255]',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getActiveBranches()
    {
        return $this->where('is_active', 1)->findAll();
    }

    public function getBranchByCode($code)
    {
        return $this->where('branch_code', $code)->first();
    }
}

