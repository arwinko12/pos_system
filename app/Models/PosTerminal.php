<?php

namespace App\Models;

use CodeIgniter\Model;

class PosTerminal extends Model
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

    public function getCartItem()
    {
        $builder =  $this->db->table($this->table);
        $builder->join('tbl_products', 'tbl_cart.product_id = tbl_products.product_id', 'left');

        return $builder->get()->getResultArray();
    }

    public function getItemsByBarcode($barcode)
    {
      $builder = $this->db->table('tbl_products');
      $builder->join('tbl_category', 'tbl_products.category_id = tbl_category.category_id');
      $builder->where('tbl_products.barcode', $barcode);

      return $builder->get()->getRowArray();
    }

   public function getCartTotal()
{
    $builder = $this->db->table($this->table);

    $builder->select('SUM(tbl_cart.quantity * tbl_products.price) AS total_price');

    $builder->join(
        'tbl_products',
        'tbl_cart.product_id = tbl_products.product_id',
        'left'
    );

    return $builder->get()->getRowArray();
}
}
