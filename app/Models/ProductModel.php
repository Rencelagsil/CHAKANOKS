<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_code', 'product_name', 'description', 'category', 'unit', 
        'unit_price', 'stock', 'supplier_id', 'barcode', 'barcode_path', 'is_perishable', 
        'shelf_life_days', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'product_code' => 'required|min_length[2]|max_length[50]|is_unique[products.product_code,id,{id}]',
        'product_name' => 'required|min_length[2]|max_length[255]',
        'description' => 'permit_empty',
        'category' => 'required|min_length[2]|max_length[100]',
        'unit' => 'required|min_length[1]|max_length[20]',
        'unit_price' => 'required|decimal|greater_than[0]',
        'supplier_id' => 'required|integer',
        'barcode' => 'permit_empty|max_length[100]',
        'is_perishable' => 'permit_empty|in_list[0,1]',
        'shelf_life_days' => 'permit_empty|integer|greater_than[0]',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getActiveProducts()
    {
        return $this->where('is_active', 1)->findAll();
    }

    public function getProductsByCategory($category)
    {
        return $this->where('category', $category)
                   ->where('is_active', 1)
                   ->findAll();
    }

    public function getProductsBySupplier($supplierId)
    {
        return $this->where('supplier_id', $supplierId)
                   ->where('is_active', 1)
                   ->findAll();
    }

    public function getProductByCode($code)
    {
        return $this->where('product_code', $code)->first();
    }

    public function getProductByBarcode($barcode)
    {
        return $this->where('barcode', $barcode)->first();
    }

    public function getCategories()
    {
        return $this->select('category')
                   ->distinct()
                   ->where('category IS NOT NULL')
                   ->findAll();
    }
}

