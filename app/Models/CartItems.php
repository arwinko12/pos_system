<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItems extends Model
{
    protected $table            = 'tbl_order_items';
    protected $primaryKey       = 'order_item_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_item_id', 'order_id', 'quantity', 'subtotal', 'product_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getItems()
    {
        return $this->db->table($this->table)->get()->getRowArray();
    }

     public function getItemsById($id)
    {
        $builder = $this->db->table($this->table)->get()->getResultArray();
        $builder->where('product_id', $id);

        return $builder->get()->getRowArray();
    }

    public function getOrders()
    {
        return $this->db->table($this->table('tbl_order'))->get()->getResultArray();
    }

}
