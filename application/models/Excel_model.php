<?php
class Excel_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();

        $this->load->model('Admin_model');
    }

    public function merchant($merchant_id='', $state_id='', $city_id='')
    {
        $where = array();   

        $this->db->select('establishment_name, merchant_id, IF(finance_available, "YES", "NO") AS finance_available, finance_terms, IF(home_delivery_available, "YES", "NO") AS home_delivery_available, home_delivery_terms, IF(installation_available, "YES", "NO") AS installation_available, installation_terms, IF(replacement_available, "YES", "NO") AS replacement_available, replacement_terms, IF(return_available, "YES", "NO") AS return_available, return_policy, seller_offering');

        //create joins
        if ($state_id || $city_id)
        {
            $where_on_clause = "merchant.userId = address.userId";

            if ($state_id) 
                $where_on_clause .= " AND address.state_id = ".$state_id;

            if ($city_id) 
                $where_on_clause .= " AND address.city_id = ".$city_id;

            $this->db->join('address', $where_on_clause, 'inner');
        }

        if ($merchant_id) 
            $this->db->where(array('merchant_id' => $merchant_id));

        $this->db->group_by('merchant.merchant_id');
        $query = $this->db->get('merchant');
        $isDbError = $this->Admin_model->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;
        else if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function product($category_id, $brand_id)
    {
    	$where = array();

    	$this->db->select('product_id, product_name, product.brand_id, brand.name AS brand_name, product.category_id, category_name, mrp_price');
        $this->db->join('product_category', 'product.category_id = product_category.category_id', 'inner');
        $this->db->join('brand', 'product.brand_id = brand.brand_id', 'inner');

        if ($category_id) 
            $where['product.category_id'] = $category_id;

        if ($brand_id) 
            $where['product.brand_id'] = $brand_id;

        if (count($where)>0) 
            $this->db->where($where);

        $this->db->order_by('product_name', 'ASC');

        $query = $this->db->get('product');
        $isDbError = $this->Admin_model->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;
        else if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function listing($where)
    {
    	$this->db->select('listing_id, establishment_name, product_listing.merchant_id, product_name, product_listing.product_id, brand.name As brand_name, category_name, list_price AS price, IF(product_listing.in_stock, "YES", "NO") AS in_stock, will_back_in_stock_on, product_listing.seller_offering, IF(product_listing.finance_available, "YES", "NO") AS finance_available, product_listing.finance_terms, IF(product_listing.home_delivery_available, "YES", "NO") AS home_delivery_available, product_listing.home_delivery_terms, IF(product_listing.installation_available, "YES", "NO") AS installation_available, product_listing.installation_terms, IF(product_listing.replacement_available, "YES", "NO") AS replacement_available, product_listing.replacement_terms, IF(product_listing.return_available, "YES", "NO") AS return_available, product_listing.return_policy');
        $this->db->join('product', 'product.product_id = product_listing.product_id', 'left');
        $this->db->join('merchant', 'merchant.merchant_id = product_listing.merchant_id', 'left');
        $this->db->join('brand', 'brand.brand_id = product.brand_id', 'left');
        $this->db->join('product_category', 'product_category.category_id = product.category_id', 'left');

        if (count($where)>0) 
            $this->db->where($where);

        $this->db->order_by('product_listing.merchant_id', 'ASC');
        $query = $this->db->get('product_listing');
        $isDbError = $this->Admin_model->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;
        else if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }
}
