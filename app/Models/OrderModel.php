<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'tbl_order';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'invoice_no', 'subtotal', 'total_amount', 'payment_method', 'date_ordered'];

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

      public function getOrders()
    {
        return $this->db->table($this->table)->get()->getRowArray();
    }

public function getOrderByOrderNo()
{
    $lastInvoice = $this->db
    ->table('tbl_order')
    ->select('invoice_no')
    ->orderBy('order_id', 'DESC')
    ->limit(1)
    ->get()
    ->getRow()
    ->invoice_no;

return $this->db
    ->table('tbl_order')
    ->select('
        tbl_order.order_id,
        tbl_order.invoice_no,
        tbl_order.date_ordered,
        tbl_order.total_amount,
        tbl_order.payment_method,
        tbl_order_items.quantity,
        tbl_order_items.subtotal,
        tbl_products.product_name,
        tbl_products.price
    ')
    ->join('tbl_order_items', 'tbl_order.order_id = tbl_order_items.order_id')
    ->join('tbl_products', 'tbl_order_items.product_id = tbl_products.product_id')
    ->where('tbl_order.invoice_no', $lastInvoice)
    ->get()
    ->getResultArray();
}
}
