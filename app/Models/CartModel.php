<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'tbl_cart';
    protected $primaryKey       = 'cart_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['cart_id', 'product_id', 'quantity'];

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

    public function getCarts()
{
    return $this->db->table('tbl_cart')
        ->select('
            tbl_cart.id,
            tbl_cart.quantity,
            tbl_products.product_id,
            tbl_products.product_name,
            tbl_products.price,
            tbl_products.product_image
        ')
        ->join(
            'tbl_products',
            'tbl_products.product_id = tbl_cart.product_id'
        )
        ->get()
        ->getResultArray();
}

public function getUserById($id)
{
   return $this->db->table($this->table)->where('cart_id', $id)->get()->getRowArray();
}

}
