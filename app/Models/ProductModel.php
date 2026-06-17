<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'tbl_products';
    protected $primaryKey       = 'product_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['barcode', 'category_id','product_name','description', 'price','product_status','product_image'];

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


    public function getProducts()
    {
        $builder =  $this->db->table($this->table);
        $builder->join('tbl_category', 'tbl_products.category_id = tbl_category.category_id', 'left');

        return $builder->get()->getResultArray();
    }

    public function getCategory()
    {
        return $this->db->table('tbl_category')->get()->getResultArray();
    }

    public function getProductId($id){
        return $this->db->table($this->table)->where('product_id', $id)->get()->getRowArray();
    }

    public function getUpdatebyId($id)
    {
        return $this->db->table($this->table)->where('product_id', $id)->get()->getRowArray();
    }

    // public function getProductsJoinCategory($id)
    // {

    //     $builder = $this->db->table($this->table);
    //     $builder->join('tbl_category', 'tbl_products.category_id = tbl_category.category_id', 'left')->where('product_id', $id);
    //     return $builder->get()->getRowArray();

    // }


}
