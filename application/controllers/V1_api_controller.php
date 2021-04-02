<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_controller.php';
require_once 'Common_controller.php';

class V1_api_controller extends Admin_controller 
{
	function __construct()
	{
		parent::__construct();
        
        //allow header
        header("Access-Control-Allow-Headers: Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		header("Access-Control-Allow-Origin: *");

		//common controller
		$this->common_controller = new Common_controller();

		//get request data
		$this->requestData = (object)$_POST;
     	$file_data = json_decode(file_get_contents("php://input"));
     	if($file_data && is_object($file_data))
     		$this->requestData = $file_data;

     	$this->limit = '';
		$this->start = '';
		$this->current_page = isset($_GET['page']) ? $_GET['page'] : "";
		
		if (isset($_GET['limit'])) 
		{
			if ($_GET['limit'] != "") 
			{
				$this->limit = $_GET['limit'];
				$this->start = 0;

				if (isset($_GET['page']) && $_GET['page'] != "") 
					$this->start = ($this->limit*$_GET['page']) - $this->limit;
			}
		}

		//current date
		$this->current_date = date("Y-m-d H:i:s");
	}

	public function sendMailTesting()
	{
		$reciever_email = 'rahulsavita477@gmail.com';
		$subject = 'testing mail';
		$body = 'asdasd';
		$atch = '';

		$mail_response = sendEmail($reciever_email, $subject, $body, $atch);
		print_r($mail_response); 
		die;
	}

	//get app version
	public function version()
	{
		$res = array();
		$res['version_info']['current_version_code'] = 7;
		$res['version_info']['current_version_name'] = "1.0.6";
		$res['version_info']['min_supported_version_code'] = 7;
		$res['version_info']['min_supported_version_name'] = "1.0.6";

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	//get brand(s)
	public function brands($brand_id='', $brands_for='')
	{
		$res = array();
		$where = "";
		
		if ($brand_id && $brands_for == 'products')
			$res = $this->getProducts(array('brand_id' => $brand_id));
		else
		{
			if ($brand_id) 
				$where = array('brand_id' => $brand_id);

			$res = $this->getBrands($where);
		}
			
		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getBrands($where = '', $like = array())
	{
		//get brand result
		$columns = 'SQL_CALC_FOUND_ROWS brand_id, name as brand_name, brand_desc as description, IF(brand_logo, CONCAT("'.$this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.'", "/", brand_id, "/", brand_logo), "") as brand_logo, update_date as last_updated';
		$brands_result = $this->Admin_model->selectRecords($where, 'brand', $columns, array(), $this->limit, $this->start, $like, true);
		$res['brands'] = array();
		
		if ($brands_result) 
		{
			if ($where) 
			{
				$brands_result = $brands_result['result'][0];
				$brand_id = $brands_result['brand_id'];
				$res['brands'] = $brands_result;

				//get brand images
				$attatchments = array();
				$brand_imgs = $this->attatchments($brand_id, "BRAND");
				if ($brand_imgs['result']) 
				{
					foreach ($brand_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$atch_value['atch_url']);
				}

				$res['brands']['brand_images'] = $attatchments;
				$res['brands']['brand_htmls'] = $this->getWebLinks( $brand_id, 'BRAND' );
			}
			else
			{
				$res['brands'] = $brands_result['result'];
				$i = 0;

				//get brand images
				foreach ($brands_result['result'] as $brand_value) 
				{
					$attatchments = array();
					$brand_id = $brand_value['brand_id'];
					$brand_imgs = $this->attatchments($brand_id, "BRAND");
					if ($brand_imgs['result']) 
					{
						foreach ( $brand_imgs['result'] as $atch_value ) 
							array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$atch_value['atch_url']);

						$res['brands'][$i]['brand_images'] = $attatchments;
					}
					else
						$res['brands'][$i]['brand_images'] = array();

					//get brand web links
					$res['brands'][$i]['brand_htmls'] = $this->getWebLinks( $brand_id, 'BRAND' );

					$i++;
				}

				//pagination array
				if (isset($brands_result['count'])) 
					$res['paging'] = $this->createPagingArray($brands_result['count']);
			}
		}
		else if ($this->current_page && !isset($res['paging'])) 
			$this->createPagingArray();

		if (!$where) 
			$res['deleted_brand_ids'] = $this->getDeletedItems('BRAND');

		return $res;	
	}

	public function getWebLinks($link_id, $type)
	{
		//get brand web links
		$web_links = array();
		$where = array(
					'link_id' => $link_id,
					'linked_type' => $type
				);
		$links = $this->Admin_model->selectRecords($where, 'html_files', 'html_file');

		if ( $links ) 
		{
			foreach ( $links['result'] as $html_file_value ) 
				array_push($web_links, $this->config->item('site_url').HTML_FILES_PATH.'/'.$html_file_value['html_file']);
		}

		return $web_links;
	}

	//get category/categories
	public function categories($cat_id = '', $cat_for = '')
	{
		$res = array();
		$where = "";
		
		if ($cat_id && $cat_for == 'products')
			$res = $this->getProducts(array('category_id' => $cat_id));
		else
		{
			if ($cat_id == 'no-parent')
				$where = array('has_parent' => 0);
			else if ($cat_id && $cat_for == 'categories')
				$where = array('has_parent' => 1, 'parent_category_id' => $cat_id);
			else if ($cat_id) 
				$where = array('category_id' => $cat_id);

			$res = $this->getCategories($where);

			if (!$where) 
				$res['deleted_category_ids'] = $this->getDeletedItems('CATEGORY');
		}

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getCategories($where = '', $like = array())
	{
		$columns = 'SQL_CALC_FOUND_ROWS category_id, category_name, has_parent, parent_category_id, update_date as last_updated';

		$cat_result = $this->Admin_model->selectRecords($where, 'product_category', $columns, array(), $this->limit, $this->start, $like, true);	

		if ($cat_result) 
		{
			$i = 0;
			$res['categories'] = $cat_result['result'];

			foreach ($cat_result['result'] as $cat_value) 
			{
				//get category images
				$attatchments = array();
				$cat_id = $cat_value['category_id'];
				$cat_imgs = $this->attatchments($cat_id, "CATEGORY");

				if ( $cat_imgs ) 
				{
					foreach ($cat_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').CATEGORY_ATTACHMENT_PATH.$cat_id.'/'.$atch_value['atch_url']);

					$res['categories'][$i]['category_images'] = $attatchments;
				}
				else
					$res['categories'][$i]['category_images'] = array();

				//get category web links
				$res['categories'][$i]['category_htmls'] = $this->getWebLinks( $cat_id, 'CATEGORY' );

				$i++;
			}

			//pagination array
			if (isset($cat_result['count'])) 
				$res['paging'] = $this->createPagingArray( $cat_result['count'] );

			return $res;
		}
		else if ($this->current_page && !isset($res['paging'])) 
			$this->createPagingArray();

		return array();
	}

	//get product listing(s)
	public function listings($listing_id = '', $listing_for = '')
	{
		$res = array();
		$where = "";

		if ($listing_id && $listing_for == 'merchants') 
		{
			$listing_result = $this->Admin_model->listingMerchants($listing_id);

			if ($listing_result)
				$res['merchants'] = $listing_result[0];
		}
		else if ($listing_id && $listing_for == 'products') 
		{
			$listing_result = $this->Admin_model->listingProducts(array('listing_id' => $listing_id));

			if ($listing_result)
			{
				$res['products'] = $listing_result[0];

				//get brand images
				$attatchments = array();
				$prd_id = $listing_result[0]['product_id'];
				$prd_imgs = $this->attatchments($prd_id, "PRODUCT");
				if ( $prd_imgs ) 
				{
					foreach ($prd_imgs['result'] as $atch_value) 
						array_push($attatchments, base_url(PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$atch_value['atch_url']));

					$res['products']['product_images'] = $attatchments;
				}
				else
					$res['products']['product_images'] = array();
			}
		}
		else
		{
			if ($listing_id)
				$where = array('listing_id' => $listing_id);

			$listing_result = $this->getListings($where);

			if ($listing_result)
			{
				$res['listings'] = $listing_result['result'];

				//pagination array
				if (isset($listing_result['count'])) 
					$res['paging'] = $this->createPagingArray($listing_result['count']);
			}
			else if ($this->current_page && !isset($res['paging'])) 
				$this->createPagingArray();
			else
				$res['listings'] = array();

			if (!$where)
				$res['deleted_listing_ids'] = $this->getDeletedItems('LISTING');
		}

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getListings($where='')
	{
		$columns = 'SQL_CALC_FOUND_ROWS listing_id, product_id, merchant_id, sell_price as price, finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, in_stock, will_back_in_stock_on, replacement_available, replacement_terms, return_available, return_policy, seller_offering, isVerified, update_date as last_updated';
		
		$listing_result = $this->Admin_model->selectRecords($where, 'product_listing', $columns, array(), $this->limit, $this->start, array(), true);		

		return $listing_result;
	}

	//get products on the basis of conition(i.e. brand id, category id)
	public function getProducts($where = '', $like = array())
	{
		$res = array();
		$columns = 'SQL_CALC_FOUND_ROWS product_id, product_name, amazon_prd_id, flipkart_prd_id, description, mrp_price, category_id, brand_id, update_date as last_updated, in_the_box';
		$result = $this->Admin_model->selectRecords($where, 'product', $columns, array(), $this->limit, $this->start, $like, true);
		$prd_result = $result['result'];

		if ($prd_result) 
		{
			$res['products'] = $prd_result;
			
			$i = 0;

			foreach ($prd_result as $prd_value) 
			{
				//get brand images
				$attatchments = array();
				$prd_id = $prd_value['product_id'];
				$prd_imgs = $this->attatchments($prd_id, "PRODUCT");

				if ($prd_imgs['result']) 
				{
					foreach ($prd_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$atch_value['atch_url']);

					$res['products'][$i]['product_images'] = $attatchments;
				}
				else
					$res['products'][$i]['product_images'] = array();

				//get product attributes
				$prd_att_res = $this->Admin_model->productAttributes($prd_id);
				if ($prd_att_res) 
					$res['products'][$i]['specifications'] = $prd_att_res;
				else
					$res['products'][$i]['specifications'] = array();

				//get product varients
				$prd_att_res = $this->Admin_model->productVarients($prd_id);
				if ($prd_att_res) 
					$res['products'][$i]['varients'] = $prd_att_res;
				else
					$res['products'][$i]['varients'] = array();

				//get product key features
				$key_features = array();
				$prd_feature = $this->Admin_model->selectRecords(array('product_id' => $prd_id), 'product_key_features', 'feature');
				if ($prd_feature) 
				{
					foreach ($prd_feature['result'] as $feature_value) 
						array_push($key_features, $feature_value['feature']);
				}

				$res['products'][$i]['key_features'] = $key_features;

				//get product web links
				$res['products'][$i]['product_htmls'] = $this->getWebLinks( $prd_id, 'PRODUCT' );

				$i++;
			}

			//pagination array
			if (isset($result['count'])) 
				$res['paging'] = $this->createPagingArray($result['count']);
		}
		else if ($this->current_page && !isset($res['paging'])) 
			$this->createPagingArray();

		if (!$where) 
			$res['deleted_product_ids'] = $this->getDeletedItems('PRODUCT');

		return $res;
	}

	//get product rating
	public function getProductRating($prd_id = '')
	{
		if ($prd_id) 
		{
			$rating_info = $this->Admin_model->selectRecords(array('product_id' => $prd_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star", array(), '', '', array(), true);

			return $rating_info['result'][0];
		}

		return false;
	}

	//get product rating
	public function getMerchantRating($merchant_id = '')
	{
		if ($merchant_id) 
		{
			$rating_info = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star", array(), '', '', array(), true);

			return $rating_info['result'][0];
		}

		return false;
	}

	public function products($prd_id = '', $product_for = '')
	{
		$where = '';
		$res = array();

		if ($prd_id == 'reviews')
		{
			$mer_reviews = $this->Admin_model->productReviews(array(), $this->limit, $this->start);
			if ($mer_reviews)
				$res['product_reviews'] = $mer_reviews['result'];
			else
				$res['product_reviews'] = array();

			$res['deleted_product_review_ids'] = $this->getDeletedItems('PRODUCT_REVIEW');
		}
		else if ($prd_id && $product_for == 'reviews') 
		{
			$product_reviews = $this->Admin_model->productReviews(array('product_review.product_id' => $prd_id), $this->limit, $this->start);
			if ($product_reviews)
				$res['product_reviews'] = $product_reviews['result'];
			else
				$res['product_reviews'] = array();
		}
		else if ($prd_id && $product_for == 'listings') 
		{
			$where = array('product_id' => $prd_id);
			$listing_result = $this->getListings($where);

			if ($listing_result)
				$res['listings'] = $listing_result['result'];
			else
				$res['listings'] = array();
		}
		else
		{
			if ($prd_id)
				$where = array('product_id' => $prd_id);

			$res = $this->getProducts($where);
		}

		//pagination array
		if (isset($mer_reviews['count'])) 
			$res['paging'] = $this->createPagingArray($mer_reviews['count']);
		else if ( isset($listing_result['count']) ) 
			$res['paging'] = $this->createPagingArray($listing_result['count']);
		else if ( $this->current_page && !isset($res['paging']) )
			$this->createPagingArray();

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function merchants($merchant_id = '', $merchant_for = '')
	{
		$res = array();
		$where = "";

		if ($merchant_id == 'reviews') 
		{
			$mer_reviews = $this->Admin_model->merchantReviews(array(), $this->limit, $this->start);
			if ($mer_reviews['result'])
				$res['merchant_reviews'] = $mer_reviews['result'];
			else
				$res['merchant_reviews'] = array();
		}
		else if ($merchant_id == 'address') 
		{
			$columns = 'SQL_CALC_FOUND_ROWS address_id, address.userId as user_id, merchant_id, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city';

			$mer_reviews = $this->Admin_model->getUserAddress(array(), $columns, $this->limit, $this->start);
			if ($mer_reviews)
				$res['addresses'] = $mer_reviews['result'];
			else
				$res['addresses'] = array();
		}
		else if ($merchant_id && $merchant_for == 'address') 
		{
			//get merchant user id
			$merchant_user_id = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     		$user_id = $merchant_user_id['result'][0]['userId'];

			$columns = 'SQL_CALC_FOUND_ROWS address_id, address.userId as user_id, merchant_id, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city';

			$mer_reviews = $this->Admin_model->getUserAddress(array('address.userId' => $user_id), $columns);
			if ($mer_reviews)
				$res['addresses'] = $mer_reviews['result'];
			else
				$res['addresses'] = array();
		}
		else if ($merchant_id && $merchant_for == 'reviews') 
		{
			$mer_reviews = $this->Admin_model->merchantReviews(array('merchant_review.merchant_id' => $merchant_id), $this->limit, $this->start);
			if ($mer_reviews['result'])
				$res['merchant_reviews'] = $mer_reviews['result'];
			else
				$res['merchant_reviews'] = array();
		}
		else if ($merchant_id && $merchant_for == 'offers') 
			$res = $this->getOffers(array('merchant_id' => $merchant_id));
		else if ($merchant_id && $merchant_for == 'listings')
		{
			$where = array('merchant_id' => $merchant_id);
			$listing_result = $this->getListings($where);

			if ($listing_result['result'])
				$res['listings'] = $listing_result['result'];
			else
				$res['listings'] = array();
		}
		else
		{
			if ($merchant_id)
				$where = array('merchant_id' => $merchant_id);

			$res = $this->getMerchants($where);
		}

		//pagination array
		if (isset($mer_reviews['count'])) 
			$res['paging'] = $this->createPagingArray($mer_reviews['count']);
		else if (isset($listing_result['count'])) 
			$res['paging'] = $this->createPagingArray($listing_result['count']);
		else if ($this->current_page && !isset($res['paging']))
			$this->createPagingArray();

		if (!$where && $merchant_id != 'address' && $merchant_for != 'address') 
			$res['deleted_merchant_ids'] = $this->getDeletedItems('MERCHANT');
		else if ($merchant_id == 'address' || $merchant_for == 'address') 
			$res['deleted_Address'] = $this->getDeletedItems('ADDRESS');

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);	
	}

	public function getMerchants($where = '', $like = array())
	{
		$res = array();
		$columns = "SQL_CALC_FOUND_ROWS merchant_id, establishment_name, description, userId as user_id, contact, is_verified, business_days, business_hours, IF(merchant_logo, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', merchant_logo), '') as merchant_logo, status as enabled, update_date as last_updated";
		$merchant_result = $this->Admin_model->selectRecords($where, 'merchant', $columns, array(), $this->limit, $this->start, $like, true);

		if ($merchant_result)
		{
			$res['merchants'] = $merchant_result['result'];

			$columns = 'address_id, address.userId as user_id, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city';

			$i = 0;
			foreach ($merchant_result['result'] as $mer_value) 
			{
				//select attachment of seller
				$attatchments = array();
				$merchant_id = $mer_value['merchant_id'];
				$seller_imgs = $this->attatchments($merchant_id, "SELLER");
				if ($seller_imgs['result']) 
				{
					foreach ($seller_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$atch_value['atch_url']);

					$res['merchants'][$i]['merchant_images'] = $attatchments;
				}
				else
					$res['merchants'][$i]['merchant_images'] = array();

				//select seller offerings
				$seller_offering = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant_offering', 'offering');
				
				if ($seller_offering) 
					$res['merchants'][$i]['key_features'] = array_column($seller_offering['result'], 'offering');
				else
					$res['merchants'][$i]['key_features'] = array();

				$i++;
			}

			if (isset($merchant_result['count'])) 
				$res['paging'] = $this->createPagingArray($merchant_result['count']);
		}
		else if ($this->current_page && !isset($res['paging']))
			$this->createPagingArray();

		return $res;
	}

	public function getOffers($where = "")
	{
		$columns = 'SQL_CALC_FOUND_ROWS offer_id, offer_title, merchant_id, description as offer_detail, start_date, end_date, update_date as last_updated, current_status AS enabled';
		$mer_offers = $this->Admin_model->selectRecords($where, 'product_listing_offer', $columns, array(), $this->limit, $this->start, array(), true);

		if ($mer_offers)
		{
			$res['offers'] = $mer_offers['result'];

			$i = 0;
			foreach ($mer_offers['result'] as $mer_offer) 
			{
				$attatchments = array();
				$listing_ids  = array();

				//get offer images
				$offer_id = $mer_offer['offer_id'];
				$offer_imgs = $this->attatchments($offer_id, "OFFER");
				if ($offer_imgs['result']) 
				{
					foreach ($offer_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').OFFER_ATTATCHMENTS_PATH.$offer_id.'/'.$atch_value['atch_url']);

					$res['offers'][$i]['offer_images'] = $attatchments;
				}
				else
					$res['offers'][$i]['offer_images'] = array();

				//get listings of offer
				$offer_listing_ids = $this->Admin_model->selectRecords(array('ofr_id' => $offer_id), 'offer_listing_mp', 'lst_id');
				if ($offer_listing_ids['result']) 
				{
					foreach ($offer_listing_ids['result'] as $list_ids) 
						array_push($listing_ids, $list_ids['lst_id']);

					$res['offers'][$i]['listing_ids'] = $listing_ids;
				}
				else
					$res['offers'][$i]['listing_ids'] = array();						

				$res['offers'][$i]['offer_htmls'] = $this->getWebLinks( $offer_id, 'OFFER' );

				$i++;
			}

			//pagination array
			if (isset($mer_offers['count'])) 
				$res['paging'] = $this->createPagingArray($mer_offers['count']);
		}
		else if ($this->current_page && !isset($res['paging']))
			$res['paging'] = $this->createPagingArray();
		else
			$res['offers'] = array();

		if (!$where) 
			$res['deleted_offer_ids'] = $this->getDeletedItems('OFFER');

		return $res;
	}

	public function offers($offer_id = '')
	{
		$where = '';

		if ($offer_id)
			$where = array('offer_id' => $offer_id);

		$res = $this->getOffers( $where );

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function addMerchantReview($mer_id, $con_id)
    {
    	$token = isset($this->requestData->token)?$this->requestData->token:"";
    	$review_data = array();
    	$review_result = array();
    	$review_data['rating'] = isset($this->requestData->rating)?$this->requestData->rating:1;
     	$review_data['review'] = isset($this->requestData->review)?$this->requestData->review:"";
     	$review_data['review_title'] = isset($this->requestData->review_title)?$this->requestData->review_title:"";

     	if ($token != '' && $mer_id && $con_id) 
     	{
     		$this->isValidToken($token, '', $con_id);

     		$review_data['consumer_id'] = $con_id;
     		$review_data['merchant_id'] = $mer_id;
     		$review_data['update_date'] = date("Y-m-d H:i:s");
     		
     		$condition = array('consumer_id' => $con_id, 'merchant_id' => $mer_id);
			$isExistMerchantReview = $this->Admin_model->selectRecords($condition, 'merchant_review', 'review_id');
			if ($isExistMerchantReview) 
			{
				$review_id = $isExistMerchantReview['result'][0]['review_id'];
				$condition = array('review_id' => $review_id);
				$this->Admin_model->updateData('merchant_review', $review_data, $condition);

				$msg = 'Merchant review updated!';
			}
			else
			{
				$review_data['create_date'] = date("Y-m-d H:i:s");
				
				$review_id = $this->Admin_model->insertData('merchant_review', $review_data);

				$msg = 'Merchant review inserted!';
			}

     		if ($review_id)
			{
				$mer_review = $this->Admin_model->merchantReviews(array('review_id' => $review_id));
				if ($mer_review)
		    	{
		    		$review_result['merchant_reviews'] = $mer_review['result'];     		
					$code = CODE_SUCCESS;
		    	}
		    	else
		    	{
		    		$msg = 'ERROR: Review is inserted but unable to get data from db.';     		
					$code = CODE_ERROR_IN_QUERY;
		    	}
			}	
	     	else
	     	{
	     		$msg = 'ERROR: Unable to insert review!';
	     		$code = CODE_ERROR_IN_QUERY;
	     	}
     	}
     	else
     	{
     		$msg = 'ERROR: token, consumer id and merchant id are required';
     		$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $review_result);
	}

	public function addProductReview($prd_id, $con_id)
    {
    	$review_data = array();
    	$review_result = array();
    	$token = isset($this->requestData->token)?$this->requestData->token:"";
    	$review_data['rating'] = isset($this->requestData->rating)?$this->requestData->rating:1;
     	$review_data['review'] = isset($this->requestData->review)?$this->requestData->review:"";
     	$review_data['review_title'] = isset($this->requestData->review_title)?$this->requestData->review_title:"";

     	if ($token != '' && $prd_id && $con_id) 
     	{
     		$this->isValidToken($token, '', $con_id);

     		$review_data['consumer_id'] = $con_id;
     		$review_data['product_id'] = $prd_id;
     		$review_data['update_date'] = date("Y-m-d H:i:s"); 

     		$condition = array('consumer_id' => $con_id, 'product_id' => $prd_id);
			$isExistProductReview = $this->Admin_model->selectRecords($condition, 'product_review', 'review_id');
			if ($isExistProductReview) 
			{
				$review_id = $isExistProductReview['result'][0]['review_id'];
				$condition = array('review_id' => $review_id);
				$this->Admin_model->updateData('product_review', $review_data, $condition);

				$msg = 'Product review updated!';
			}
			else
			{
				$review_data['create_date'] = date("Y-m-d H:i:s");
				
				$review_id = $this->Admin_model->insertData('product_review', $review_data);     		

				$msg = 'Product review inserted!';
			}

	     	if ($review_id)
			{
				//get review data
		    	$product_review = $this->Admin_model->productReviews(array('review_id' => $review_id));

		    	if ($product_review)
		    	{
		    		$review_result['product_reviews'] = $product_review['result'];     		
					$code = CODE_SUCCESS;
		    	}
		    	else
		    	{
		    		$msg = 'ERROR: Review is inserted but unable to get data from db.';     		
					$code = CODE_ERROR_IN_QUERY;
		    	}
			}
	     	else
	     	{
	     		$msg = 'ERROR: Unable to insert review!';
	     		$code = CODE_ERROR_IN_QUERY;
	     	}
     	}
     	else
     	{
     		$msg = 'ERROR: token, consumer id and product id are required';
     		$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $review_result);
	}

	//upload profile picture
	public function uploadProfilePic()
	{
		$user_id = isset($this->requestData->user_id)?$this->requestData->user_id:"";
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		
		if ($token && $user_id) 
     	{
     		$this->isValidToken($token, $user_id);

     		if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['tmp_name']))
     		{
     			$condition = array('userId' => $user_id);

     			//check image exist or not
		    	$isExistProfileImage = $this->Admin_model->selectRecords($condition, 'user', 'picture');
		    	if (isset($isExistProfileImage['result'])) 
		    	{
		    		//if exist file, remove profile pic from folder
		    		if (is_file(PROFILE_PIC_PATH.$isExistProfileImage['result'][0]['picture']))
		    			unlink(PROFILE_PIC_PATH.$isExistProfileImage['result'][0]['picture']);

		    		//update record in db
		    		$this->Admin_model->updateData('user', array('picture' => ''), $condition);
		    	}

		    	//upload new picture
	    		$profile_image = $this->common_controller->single_upload(PROFILE_PIC_PATH, '', 'profile_image');

	    		//insert image in db
	    		$this->Admin_model->updateData('user', array('picture' => $profile_image), $condition);

	    		//get user detail
	    		$usr_detail = $this->Admin_model->getConsumer($user_id);
				if ($usr_detail)
				{
					$user['user'] = $usr_detail[0];

					$msg = 'Profile image updated successfully!';
					$code = CODE_SUCCESS;
					$res = json_decode(json_encode($user), True);
				}
				else 
				{
					$msg = 'ERROR: User not varified';
					$code = CODE_ERROR_AUTHENTICATION_FAILED;
				}

	    		$this->getJsonData($code, $msg, $res);
     		}
     	}
     	
     	$msg = 'ERROR: token, user_id, profile_image required';
     	$code = CODE_ERROR_PARAM_MISSING;
     	$this->getJsonData($code, $msg, array());
	}

	public function addUser()
    {
    	$user_id = isset($this->requestData->user_id)?$this->requestData->user_id:"";
    	$token = isset($this->requestData->token)?$this->requestData->token:"";
    	
    	if ($user_id) 
	 	{
	 		if ($token != '') 	
	 			$this->isValidToken($token, $user_id);	
	 		else
	 			$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: token is required', array());
	 	}

    	$user_data = array();
     	$consumer_data = array();

     	//user data
     	$user_data['status'] = 1;

     	$full_name = isset($this->requestData->full_name) ? $this->requestData->full_name : "";
     	if ($user_id && !$full_name)
     		$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: full_name required', array());
     	elseif (!$user_id && !$full_name) 
     		$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: full_name, email and password required', array());
     	else
     		$user_data['first_name'] = $full_name;

     	//consumer data
     		//1. gender
     	if (isset($this->requestData->gender))
     		$consumer_data['gender'] = $this->requestData->gender;

     		//2. birthday
     	if (isset($this->requestData->birthday))
     	{
     		$birthday = $this->requestData->birthday;

     		if (1 !== preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $birthday)) 
				$this->getJsonData(CODE_ERROR_INCORRECT_FORMAT, 'Error: birthday needs to have a valid date format - dd-mm-yyyy', array());
			else
     			$consumer_data['birthday'] = $birthday;
     	}
     	else
     		$consumer_data['birthday'] = "";

     		//3. phone
     	if (isset($this->requestData->phone))
     	{
     		$phone = $this->requestData->phone;

     		if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone))
     			$this->getJsonData(CODE_ERROR_INCORRECT_FORMAT, 'Error: phone should be in numaric format', array());

            $consumer_data['phone'] = $phone;
     	}

     	if ($user_id) 
     	{
     		$condition = array('userId' => $user_id);
			$this->Admin_model->updateData('user', $user_data, $condition);
			$this->Admin_model->updateData('consumer', $consumer_data, $condition);

			$msg = "user detail updated successfully!";
			$code = CODE_SUCCESS;
     	}
     	else
     	{
     		$user_data['email'] = isset($this->requestData->email)?$this->requestData->email:"";
     		$user_data['password'] = isset($this->requestData->password)?$this->requestData->password:"";

     		if (!$user_data['email'] || !$user_data['password'])
	     		$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: full_name, email and password required', array());

     		$isEmailExist = $this->isEmailExist($user_data['email']);
     		if ($isEmailExist) 
     		{
     			$msg = 'ERROR: This email address is already exist.';
     			$code = CODE_ERROR_ALREADY_EXIST; 
     		}
     		else
     		{
     			$user_id = $this->Admin_model->insertData('user', $user_data);

		     	if ($user_id)
				{
					$type_data['usr_id'] = $user_id;
					$type_data['type_name'] = 'BUYER';

					$type_id = $this->Admin_model->insertData('user_type', $type_data);

					if ($type_id)
					{
						$consumer_data['userId'] = $user_id;

						$con_id = $this->Admin_model->insertData('consumer', $consumer_data);

						if ($con_id)
						{
							$msg = 'Consumer signup done!';
							$code = CODE_SUCCESS;
						}
						else
						{
							$msg = 'Error: Unable to add user as consumer!';
							$code = CODE_ERROR_IN_QUERY;
						}
					}
					else
					{
						$msg = 'Error: Unable to add user role';
						$code = CODE_ERROR_IN_QUERY;
					}
				}     		
		     	else
		     	{
		     		$msg = 'Error: Unable to insert user data!';
		     		$code = CODE_ERROR_IN_QUERY;
		     	}
     		}
     	}

     	$consumer_detail = array();
     	if ($user_id) 
     	{
     		$consumer_profile_data = $this->Admin_model->getConsumer($user_id);

     		if ($consumer_profile_data)
     		{
     			$consumer_detail['user'] = $consumer_profile_data[0];
     			$consumer_detail['user']['auth_token'] = $this->createToken($user_id);
     		}
     		else
     			$consumer_detail['user'] = array();
     	}

		$this->getJsonData($code, $msg, $consumer_detail);
	}

	public function login()
	{
		$res = array();
		$email = isset($this->requestData->email)?$this->requestData->email:"";
		$password = isset($this->requestData->password)?$this->requestData->password:"";
		
		if ($email && $password) 
		{
			$usr_id = $this->Admin_model->doLogin($email, $password);

			if ($usr_id) 
			{
				$user_id = $usr_id['userId'];
				$usr_detail = $this->Admin_model->getConsumer($user_id);

				if ($usr_detail)
				{
					$user['user'] = $usr_detail[0];
					$usr_roles = $this->Admin_model->selectRecords(array('usr_id' => $user_id), 'user_type', '*');

					if ($usr_roles) 
					{
						$isConsumer = false;
						foreach ($usr_roles['result'] as $role) 
						{
							if ($role['type_name'] == 'BUYER')
							{
								$isConsumer = true;
								break;
							}
						}

						if ($isConsumer)
						{	
							$msg = 'Consumer login done!';
							$code = CODE_SUCCESS;
							$user['user']['auth_token'] = $this->createToken($user_id);
							
							$res = json_decode(json_encode($user), True);
						}
						else
						{
							$msg = 'ERROR: User is not consumer';
							$code = CODE_ERROR_AUTHENTICATION_FAILED;
						}
					}
					else
					{
						$msg = 'ERROR: No user role found!';
						$code = CODE_ERROR_AUTHENTICATION_FAILED;
					}
				}
				else 
				{
					$msg = 'ERROR: User not varified';
					$code = CODE_ERROR_AUTHENTICATION_FAILED;
				}
			}
			else
			{
				$msg = 'ERROR: email/password is incorrect';
				$code = CODE_ERROR_AUTHENTICATION_FAILED;
			}
		}
		else
		{
			$msg = 'ERROR: email and password are required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);
	}

	public function changePassword($user_id='')
	{	
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$old_password = isset($this->requestData->old_password)?$this->requestData->old_password:"";
		$new_password = isset($this->requestData->new_password)?$this->requestData->new_password:"";
		$user_id = isset($this->requestData->user_id)?$this->requestData->user_id:$user_id;
		$new_token = md5(uniqid(rand(), true));
		$data = array();

		if ($user_id != '' && $old_password != '' && $new_password != '' && $token != '') 
		{
			$this->isValidToken($token, $user_id);	

			$condition = array('userId' => $user_id, 'password' => $old_password);
			$isValidaOldPassword['result'] = $this->Admin_model->selectRecords($condition, 'user', 'userId');

			if ($isValidaOldPassword['result']) 
			{
				$condition = array('userId' => $user_id);
				$this->Admin_model->updateData('user', array('password' => $new_password, 'auth_token' => $new_token), $condition);

				$consumer_profile_data = $this->Admin_model->getConsumer($user_id);

	     		if ($consumer_profile_data)
	     			$data['user'] = $consumer_profile_data[0];
	     		else
	     			$data['user'] = array();

				$msg = 'Password changed!';
				$code = CODE_SUCCESS;
			}
			else
			{
				$msg = 'ERROR: Old password is not correct!';
				$code = CODE_ERROR_UNKNOWN;
			}				
		}
		else
		{
			$msg = 'ERROR: token, user_id, old_password and new_password are required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $data);
	}

	public function resetPassword($isMerchant=false)
	{	
		$email = isset($this->requestData->email)?$this->requestData->email:"";

		if ($email != '') 
		{
			if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$isEmailExist = $this->isEmailExist($email);
				if ($isEmailExist) 
				{
					$data = array();
					$data['password'] = substr(md5(uniqid(rand(1,6))), 0, 5);
					$data['auth_token'] = md5(uniqid(rand(), true));

					$condition = array('email' => $email);
					$this->Admin_model->updateData('user', $data, $condition);

					$mail_data = array();
					$mail_data['password'] = $data['password'];
					$mail_data['name'] = $isEmailExist['result'][0]['first_name'];
					$mail_data['email'] = $email;
					$mail_data['code'] = MAIL_CODE_RESET_PASSWORD;
					$isSent = $this->common_controller->sendMail($mail_data);
					if ($isSent) 
					{
						if ($isMerchant) 
							return $data['auth_token'];

						$msg = 'Your new password has been sent to provided Email Id';
						$code = CODE_SUCCESS;
					}
					else
					{
						$msg = 'ERROR: Unable to send email';
						$code = CODE_ERROR_UNKNOWN;
					}
				}
				else
				{
					$msg = 'ERROR: No user found with provided Email Id';
					$code = CODE_ERROR_ALREADY_EXIST;
				}
			}
			else
			{
				$msg = 'ERROR: please provide a valid Email Id';
				$code = CODE_ERROR_ALREADY_EXIST;
			}
		}
		else
		{
			$msg = 'ERROR: email is required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, array());
	}

	public function search()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		if (isset($_GET['str'])) 
		{
			//search categories
			$cat_result = $this->getCategories('', array('category_name', $_GET['str']));	
			if ($cat_result)
				$res['categories'] = $cat_result['categories'];
			else
				$res['categories'] = array();

			//search products
			$prd_result = $this->getProducts('', array('product_name', $_GET['str']));
			if ($prd_result)
				$res['products'] = $prd_result;
			else
				$res['products'] = array();

			//search brand
			$brands = $this->getBrands('', array('name', $_GET['str']));
			if ($brands)
				$res['brands'] = $brands;
			else
				$res['brands'] = array();

			//search merchants
			$merchants = $this->getMerchants('', array('establishment_name', $_GET['str']));
			if ($merchants)
				$res['merchants'] = $merchants;
			else
				$res['merchants'] = array();
		}
		else
		{
			$msg = "ERROR: Search string not found";
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);
	}

	public function country()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->Admin_model->selectRecords('', 'country', 'SQL_CALC_FOUND_ROWS country_id, name, status as isEnabled, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['countries'] = $cnt_result['result'];
		else
			$res['countries'] = array();

		$res['deleted_country_ids'] = $this->getDeletedItems('COUNTRY');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function state()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->Admin_model->selectRecords('', 'state', 'SQL_CALC_FOUND_ROWS state_id, name, country_id, status as isEnabled, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['states'] = $cnt_result['result'];
		else
			$res['states'] = array();

		$res['deleted_state_ids'] = $this->getDeletedItems('STATE');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function city()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->Admin_model->selectRecords('', 'city', 'SQL_CALC_FOUND_ROWS city_id, name, latitude, longitude, status as isEnabled, state_id, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['cities'] = $cnt_result['result'];
		else
			$res['cities'] = array();

		$res['deleted_city_ids'] = $this->getDeletedItems('CITY');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function area()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->Admin_model->selectRecords('', 'area', 'SQL_CALC_FOUND_ROWS area_id, area_name, latitude, longitude, city_id, status as isEnabled, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['areas'] = $cnt_result['result'];
		else
			$res['areas'] = array();

		$res['deleted_area_ids'] = $this->getDeletedItems('AREA');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function isEmailExist($email)
	{
		$isEmailExist = $this->Admin_model->selectRecords(array('email' => $email), 'user', 'userId, first_name');

		if ($isEmailExist)
			return $isEmailExist;
		else
			return false;
	}

	public function isValidToken($token, $user_id='', $consumer_id='')
	{
		//get user id from consumer id
		if ($consumer_id) 
		{
			$user_data = $this->Admin_model->selectRecords(array('consumer_id' => $consumer_id), 'consumer', 'userId');

			if ($user_data)
				$user_id = $user_data['result'][0]['userId'];
			else
			{
				$msg = 'ERROR: wrong consumer_id';
				$code = CODE_ERROR_AUTHENTICATION_FAILED;
				$this->getJsonData($code, $msg, array());
			}
		}

		if ($token && $user_id) 
		{
			$isValidToken = $this->Admin_model->selectRecords(array('auth_token' => $token, 'userId' => $user_id), 'user', 'userId');
			
			if ($isValidToken)
				return true;
		}
		
		$msg = 'ERROR: Your login session expired, please login again';
		$code = CODE_ERROR_LOGIN_EXPIRED;
		$this->getJsonData($code, $msg, array());
	}

	//get attatchments
	public function attatchments($link_id, $atch_for)
	{
		$columns  = 'atch_url';
		$where = array('link_id' => $link_id, 'atch_for' => $atch_for);
		$atch_res = $this->Admin_model->selectRecords($where, 'attatchments', $columns, array(), '', '', array(), false);

		if ($atch_res) 
			return $atch_res;
		else
			return FALSE;
	}

	public function createToken($user_id)
	{
		if ($user_id) 
		{
			$where = array('userId' => $user_id);
			$isExistToken = $this->Admin_model->selectRecords($where, 'user', 'auth_token');

			if ( $isExistToken && !empty($isExistToken['result'][0]['auth_token']) ) 
				return $isExistToken['result'][0]['auth_token'];
			else
			{
				$token_data = array();
				$token_data['auth_token'] = md5(uniqid(rand(), true));
				$token_data['update_date'] = date("Y-m-d H:i:s");

				$this->Admin_model->updateData('user', $token_data, $where);
			}

			$token_data = $this->Admin_model->selectRecords($where, 'user', 'auth_token');
			if ($token_data) 
				return $token_data['result'][0]['auth_token'];
		}

		$msg = 'ERROR: Your login session expired, please login again';
		$code = CODE_ERROR_LOGIN_EXPIRED;
		$this->getJsonData($code, $msg, array());
	}

	public function getDeletedItems($item_type = '')
	{
		$last_updateDate = isset($_GET['last_updateDate']) ? $_GET['last_updateDate'] : "";

	 	if ($item_type)
	 	{
	 		$where = array();
	 		$where['item_type'] = $item_type;
	 		
	 		if ($last_updateDate) 
	 			$where['deletion_time >='] = $last_updateDate;	

	 		$deleted_items = $this->Admin_model->selectRecords($where, 'deleted_items', 'item_id');
	 		$values = array();

	 		if ( $deleted_items ) 
	 		{
	 			foreach ($deleted_items['result'] as $value) 
	 				array_push($values, $value['item_id']);
	 		}

	 		return $values;
	 	}
	 	else
	 	{
	 		$msg = 'ERROR: Unable to get item type.';
			$code = CODE_ERROR_PARAM_MISSING;
			$this->getJsonData($code, $msg, array());
	 	}
	}


				/***********************************************/
				/******** MERCHANT API'S STARTS FROM HERE ******/
				/***********************************************/


	//-- merchant login api
	public function merchantLogin()
    {
        $usr_roles = array(); 
        $usr_details = array();
        $res = array();
        $user = array();
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        
        if ($username && $password) 
        {
	        $usr_id = $this->Admin_model->doLogin($username, $password);
	        if ($usr_id) 
	        {
	            $usr_id = $usr_id['userId'];
	            $usr_details = $this->Admin_model->getUser($usr_id, 1);
	            $usr_roles = $this->Admin_model->selectRecords(array('usr_id' => $usr_id), 'user_type', '*');
	            if ($usr_details) 
	            {
	                $isValidUser = false;
	                $usr_roles = array_column($usr_roles['result'], 'type_name');

	                if (!in_array('SELLER', $usr_roles))
	                {
	                    //insert seller role
	                    $type_data['usr_id'] = $usr_id;
	                    $type_data['type_name'] = "SELLER";

	                    $type_id = $this->Admin_model->insertData('user_type', $type_data);
	                    if (!$type_id)
	                    {
	                    	$msg = 'ERROR: unable to add you as seller.';
							$code = CODE_ERROR_IN_QUERY;

							$this->getJsonData($code, $msg, $res);	
	                    }
	                    else //insert seller data
	                    {
	                        //seller data
	                        $seller_data = array();
	                        $seller_data['userId'] = $usr_id;
	                        $seller_data['is_verified'] = 0;
	                        $seller_data['status'] = 1;
	                        $seller_data['create_date'] = $this->current_date;
	                        $seller_data['update_date'] = $this->current_date;

	                        $seller_id = $this->Admin_model->insertData('merchant', $seller_data);
	                        if (!$seller_id)
	                        {
	                        	$msg = 'ERROR: unable to add you as seller.';
								$code = CODE_ERROR_IN_QUERY;

								$this->getJsonData($code, $msg, $res);	
	                        }
	                    }
	                }
	                else
	                {
	                	$merchantId = $this->Admin_model->selectRecords(array('userId' => $usr_id), 'merchant', 'merchant_id');
	                	$seller_id = $merchantId['result'][0]['merchant_id'];
	                }

	                $msg = 'Selller login done!';
					$merchantDetail = $this->getMerchantData($seller_id, $usr_id);
                    $res = json_decode(json_encode($merchantDetail), True);
					$code = CODE_SUCCESS;
	            }
	            else
	            {
	            	$msg = 'ERROR: You are not a varified user, please contact to system administrator!';
					$code = CODE_ERROR_AUTHENTICATION_FAILED;
	            }
	        }
	        else
	        {
	        	$msg = 'ERROR: Wrong credential.';
				$code = CODE_ERROR_PARAM_MISSING;
	        }
    	}
    	else
		{
			$msg = 'ERROR: email and password are required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);	
    }

    //get inserted merchant detail
    private function getMerchantData($seller_id, $user_id)
    {
    	$user = array();
    	$usr_details = $this->Admin_model->getUser($user_id, 1);
        $user = $usr_details[0];
        $user['auth_token'] = $this->createToken($user_id);
		$user['user_id'] = $user['userId'];
		$first_name = $user['first_name'];
		$last_name = ($user['last_name']) ? " ".$user['last_name'] : "";
		$user['full_name'] = $first_name.$last_name;
		$user['last_updated'] = $user['update_date'];
		$user['enabled'] = $user['status'];

		//unset unnecessary params
		unset($user['first_name']);
		unset($user['middle_name']);
		unset($user['last_name']);
		unset($user['userId']);
		unset($user['create_date']);
		unset($user['update_date']);
		unset($user['status']);

		//get merchant data
		$merchant = $this->Admin_model->selectRecords(array('userId' => $user_id), 'merchant', "merchant_id, establishment_name, description, IF(merchant_logo, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', merchant_logo), '') AS merchant_logo, IF(business_proof, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', business_proof), '') AS business_proof, contact, is_verified, is_completed, status, business_days, business_hours, status AS merchant_enabled");

		//get merchant default values
		$merchant_default_values = $this->Admin_model->selectRecords(array('userId' => $user_id), 'merchant', "finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, replacement_available, replacement_terms, return_available, return_policy, seller_offering");

        //get shop images
        $merchant_images = $this->Admin_model->selectRecords(array('link_id' => $seller_id, 'atch_for' => 'SELLER', 'atch_type' => 'IMAGE'), 'attatchments', "CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', link_id, '/', atch_url) AS atch_url");
        $merchant_images = ($merchant_images) ? $merchant_images['result'] : array();

        //get key features/offering
		$seller_offering = $this->Admin_model->selectRecords(array('merchant_id' => $seller_id), 'merchant_offering', "offering AS value, offering_id AS id");        
		$seller_offering = ($seller_offering) ? $seller_offering['result'] : array();

        $res['user'] = $user+$merchant['result'][0];
        $res['user']['default_values'] = $merchant_default_values['result'][0];
		$res['user']['merchant_images'] = array_column($merchant_images, 'atch_url');
		$res['user']['key_features'] = $seller_offering;

        return $res;
    }

    //-- merchant signup
    public function merchantSignup()
    {
    	$user_data = array();
    	$res = array();

    	//user data
        $user_data['status'] = 1;
        $user_data['first_name'] = isset($this->requestData->full_name)?$this->requestData->full_name:"";
        $user_data['email'] = isset($this->requestData->email)?$this->requestData->email:"";
        $user_data['password'] = isset($this->requestData->password)?$this->requestData->password:"";
        $user_contact = isset($this->requestData->contact)?$this->requestData->contact:"";
        $user_data['create_date'] = $this->current_date;
        $user_data['update_date'] = $this->current_date;
    	
    	if ($user_data['first_name'] && $user_data['email'] && $user_data['password'] && $user_contact) 
    	{
	    	//check email is already exist or not
	        $isEmailExist = $this->isEmailExist($user_data['email']);
	 		if ($isEmailExist) 
	 		{
	 			$msg = 'ERROR: This email address is already exist.';
	 			$code = CODE_ERROR_ALREADY_EXIST; 
	 		}
	        else
	        {
	            //insert user detail
	            $user_id = $this->Admin_model->insertData('user', $user_data);
	            if ($user_id)
	            {
	                //insert seller role
	                $type_data['usr_id'] = $user_id;
	                $type_data['type_name'] = "SELLER";

	                $type_id = $this->Admin_model->insertData('user_type', $type_data);
	                if (!$type_id)
	                {
	                	$msg = 'ERROR: unable to add you as seller!';
						$code = CODE_ERROR_IN_QUERY;
	                }
	                else
	                {
	                    //seller data
	                    $seller_data = array();
	                    $seller_data['userId'] = $user_id;
	                    $seller_data['contact'] = $user_contact;
	                    $seller_data['is_verified'] = 0;
	                    $seller_data['status'] = 0;
	                    $seller_data['create_date'] = $this->current_date;
	                    $seller_data['update_date'] = $this->current_date;
	                    $seller_data['establishment_name'] = isset($this->requestData->establishment_name) ? $this->requestData->establishment_name : "";
	        			$seller_data['business_hours'] = isset($this->requestData->business_hours) ? $this->requestData->business_hours : "";
	        			$seller_data['business_days'] = isset($this->requestData->business_days) ? $this->requestData->business_days : "";

	                    //insert data in db
	                    $seller_id = $this->Admin_model->insertData('merchant', $seller_data);
	                    if (!$seller_id)
	                    {
	                    	$msg = 'ERROR: unable to add you as seller!';
							$code = CODE_ERROR_IN_QUERY;
	                    }
	                    else
	                    {
	                        //send mail to company
	                        $mail_data = array();
	                        $mail_data['first_name'] = $user_data['first_name'];
	                        $mail_data['last_name'] = "";
	                        $mail_data['seller_id'] = $seller_id;
	                        $mail_data['email'] = $user_data['email'];
	                        $mail_data['contact_number'] = $user_contact;
	                        $mail_data['code'] = MAIL_CODE_SELLER_SIGNUP;
	                        $mail_data['url'] = str_replace("seller", "admin", base_url()).'seller/'.$seller_id.'/view';
	                        $this->common_controller->sendMail($mail_data);

	                        //get merchant detail
	                        $merchantDetail = $this->getMerchantData($seller_id, $user_id);
	                        $res = json_decode(json_encode($merchantDetail), True);
	                        $msg = 'Merchant signup done!';
							$code = CODE_SUCCESS;
	                    }
	                }
	            }           
	            else
	            {
	            	$msg = 'ERROR: unable to add you as seller!';
					$code = CODE_ERROR_IN_QUERY;
	            }
	        }
        }
        else
        {
        	$msg = 'ERROR: full_name, email, password, contact are required.';
	 		$code = CODE_ERROR_PARAM_MISSING; 
        }

        $this->getJsonData($code, $msg, $res);
    }

    private function merchantUserDetail($token)
    {
    	$merchantUserDetail = $this->Admin_model->merchantUserDetail($token);
    	if ($merchantUserDetail)
    	{
    		$merchantUserDetail['roles'] = (explode(",",$merchantUserDetail['roles']));

    		return $merchantUserDetail;
    	}
    	else
    	{
    		$msg = 'ERROR: Could not get user detail!';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, array());
    }

    //merchant step2, update detail
    public function updateMerchant($token1 = '')
    {
    	$token = ($token1) ? $token1 : $this->requestData->token;
    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
        $full_name = isset($this->requestData->full_name)?$this->requestData->full_name:"";
        $establishment_name = isset($this->requestData->establishment_name)?$this->requestData->establishment_name:"";
        $contact = isset($this->requestData->contact)?$this->requestData->contact:"";
        $res = array();

        if ($token && $full_name && $establishment_name && $contact) 
        {
        	$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
        	$this->isValidToken($token, $user_id);

        	//address data
	        $line1 = isset($this->requestData->address_line_1) ? $this->requestData->address_line_1 : "";
	        $line2 = isset($this->requestData->address_line_2) ? $this->requestData->address_line_2 : "";
	        $landmark = isset($this->requestData->landmark) ? $this->requestData->landmark : "";
	        $pin = isset($this->requestData->pin) ? $this->requestData->pin : "";
	        $is_default_address = isset($this->requestData->is_default_address) ? $this->requestData->is_default_address : 0;
	        $business_days = isset($this->requestData->business_days) ? $this->requestData->business_days : "";
	        $business_hours = isset($this->requestData->business_hours) ? $this->requestData->business_hours : "";
	        $lat = isset($this->requestData->latitude) ? $this->requestData->latitude : "";
	        $long = isset($this->requestData->longitude) ? $this->requestData->longitude : "";
	        $country_id = isset($this->requestData->country_id) ? $this->requestData->country_id : "";
	        $state_id = isset($this->requestData->state_id) ? $this->requestData->state_id : "";
	        $city_id = isset($this->requestData->city_id) ? $this->requestData->city_id : "";
	        $locality = isset($this->requestData->locality) ? $this->requestData->locality : "";

	        if ($line1 || $line2 || $landmark || $pin || $lat || $long || $country_id || $state_id || $city_id || $locality) 
	        {
	        	if (!$line1 || !$country_id || !$state_id || !$city_id)
	        	{
	        		$msg = 'ERROR: please provide line1, country_id, state_id and city_id to insert address!';
					$code = CODE_ERROR_PARAM_MISSING;

					$this->getJsonData($code, $msg, $res);
	        	}
	        	else
	        	{
	        		//insert merchant address
		            $address_id = $this->insertAddress1($user_id);
		            if ($address_id['status'] > 2) 
		            	$this->getJsonData(CODE_ERROR_PARAM_MISSING, $address_id['msg'], $res);
	        	}
	        }

	        //seller data
            $seller_data = array();
            $seller_data['establishment_name'] = $establishment_name;
            $seller_data['contact'] = $contact;

            if (isset($this->requestData->description))
            	$seller_data['description'] = $this->requestData->description;

            if (isset($this->requestData->business_days))
            	$seller_data['business_days'] = isset($this->requestData->business_days)?$this->requestData->business_days:"";

            if (isset($this->requestData->business_hours))
            	$seller_data['business_hours'] = isset($this->requestData->business_hours)?$this->requestData->business_hours:"";

            //$seller_data['is_verified'] = 1;
            $seller_data['status'] = 1;
            //$seller_data['is_completed'] = 1;
            $seller_data['update_date'] = $this->current_date;

            //update merchant data
            $this->Admin_model->updateData('merchant', $seller_data, array('merchant_id' => $merchant_id));

            //user data
            $user_data = array();
            $user_data['first_name'] = $full_name;
            $user_data['update_date'] = $this->current_date;

            //update user data
            $this->Admin_model->updateData('user', $user_data, array('userId' => $user_id));

            if (!$token1) 
            {
            	//if key_feature exist, then perform action
            	if (isset($this->requestData->key_features)) 
            	{
            		$key_features = $this->requestData->key_features;

            		if ((is_string($key_features) && $key_features == "") || (is_array($key_features) && count($key_features) == 0)) 
            			$this->CommonModel->deleteRecord('merchant_offering', array('merchant_id' => $merchant_id));
            		else
            		{
		            	$seller_offering = isset($key_features) ? $key_features : array();

		            	//delete merchant offering
		            	$ids = array_column($seller_offering, 'id');
		            	$this->Admin_model->deleteOffering($merchant_id, $ids);

		            	foreach ($seller_offering as $value) 
		            	{
		            		//if id exist then go for insert
		            		if (isset($value->id)) 
		            			$this->Admin_model->updateData('merchant_offering', array('offering' => $value->value), array('offering_id' => $value->id));
		            		else //else go for update
		            			$this->Admin_model->insertData('merchant_offering', array('offering' => $value->value, 'merchant_id' => $merchant_id));
		            	}
		            }
	            }

            	//get merchant detail
                $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);

                if (isset($key_features) && is_string($key_features) && $key_features != "") 
        		{
        			$msg = 'ERROR: key_features not in there correct format!';
					$code = CODE_ERROR_PARAM_MISSING;
        		}
        		else
        		{
		            $msg = 'Merchant update successfully!';
					$code = CODE_SUCCESS;
				}
			}
			else
				return TRUE;
        }
        else
        {
        	$msg = 'ERROR: token, full_name, establishment_name, contact required!';
			$code = CODE_ERROR_PARAM_MISSING;
        }

        $this->getJsonData($code, $msg, $res);
    }

    //insert/update business proof
    public function uploadBusinessProof()
    {
    	$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		if (isset($_FILES['business_proof']) && !empty($_FILES['business_proof']['tmp_name']))
     		{
     			$condition = array('merchant_id' => $merchant_id);

     			//check image exist or not
		    	$isExistBusinessProof = $this->Admin_model->selectRecords($condition, 'merchant', 'business_proof');
		    	if (isset($isExistBusinessProof['result'])) 
		    	{
		    		$path = SELLER_ATTATCHMENTS_PATH.$merchant_id.'/';
		    		$proof = $isExistBusinessProof['result'][0]['business_proof'];

		    		if (!is_dir($path))
		            {
		                if (!mkdir($path, 0777, true)) 
		                {
		                    echo 'Error: Unable to create folder!';
		                    die;
		                }
		                else
		                    chmod($path, 0777);
		            }

		    		//if exist file, remove profile pic from folder
		    		if (is_file($path.$proof))
		    			unlink($path.$proof);

		    		//update record in db
		    		$this->Admin_model->updateData('merchant', array('business_proof' => ''), $condition);
		    	}

		    	//upload new picture
	    		$business_proof = $this->common_controller->single_upload(SELLER_ATTATCHMENTS_PATH.$merchant_id, '', 'business_proof');

	    		//insert image in db
	    		$this->Admin_model->updateData('merchant', array('business_proof' => $business_proof), $condition);

	    		$msg = 'business proof uploaded successfully!';
	     		$code = CODE_ERROR_PARAM_MISSING;
	     		$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
     		}
     		else
     		{
     			$msg = 'ERROR: business_proof required';
	     		$code = CODE_ERROR_PARAM_MISSING;
     		}
     	}
     	else
     	{
	     	$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    //insert/update business proof
    public function uploadShopLogo()
    {
    	$res = array();
        $token = isset($this->requestData->token) ? $this->requestData->token : "";
		$merchant_id = isset($this->requestData->merchant_id) ? $this->requestData->merchant_id : "";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);

     		//check authorization
     		if ($merchant_id && (($merchantUserDetail['merchant_id'] != $merchant_id) && !in_array("ADMIN", $merchantUserDetail['roles'])))
     		{
     			$msg = 'ERROR: unauthorized merchant';
	     		$code = CODE_ERROR_AUTHENTICATION_FAILED;
     		}
     		else
     		{
	        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
	        	$user_id = $merchantUserDetail['userId'];
	     		$this->isValidToken($token, $user_id);

	     		if (isset($_FILES['merchant_logo']) && !empty($_FILES['merchant_logo']['tmp_name']))
	     		{
	     			$condition = array('merchant_id' => $merchant_id);

	     			//check image exist or not
			    	$isExistMerchnantLogo = $this->Admin_model->selectRecords($condition, 'merchant', 'merchant_logo');
			    	if (isset($isExistMerchnantLogo['result'])) 
			    	{
			    		$path = SELLER_ATTATCHMENTS_PATH.$merchant_id.'/';
			    		$proof = $isExistMerchnantLogo['result'][0]['merchant_logo'];

			    		if (!is_dir($path))
			            {
			                if (!mkdir($path, 0777, true)) 
			                {
			                    echo 'Error: Unable to create folder!';
			                    die;
			                }
			                else
			                    chmod($path, 0777);
			            }

			    		//if exist file, remove profile pic from folder
			    		if (is_file($path.$proof))
			    			unlink($path.$proof);

			    		//update record in db
			    		$this->Admin_model->updateData('merchant', array('merchant_logo' => ''), $condition);
			    	}

			    	//upload new picture
		    		$merchant_logo = $this->common_controller->single_upload(SELLER_ATTATCHMENTS_PATH.$merchant_id, '', 'merchant_logo');

		    		//insert image in db
		    		$this->Admin_model->updateData('merchant', array('merchant_logo' => $merchant_logo), $condition);

		    		$msg = 'shop logo uploaded successfully!';
		     		$code = CODE_SUCCESS;
		    		$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
	                $res = json_decode(json_encode($merchantDetail), True);
	     		}
	     		else
	     		{
	     			$msg = 'ERROR: merchant_logo required';
		     		$code = CODE_ERROR_PARAM_MISSING;
	     		}
     		}
     	}
     	else
     	{
	     	$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    //insert shop images
    public function uploadShopImage()
    {
    	$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

	    	//atatchment data
	        $img_data['link_id'] = $merchant_id;
	        $img_data['atch_type'] = "IMAGE";
	        $img_data['atch_for'] = "SELLER";

	        //insert seller images
	        if (count($_FILES) > 0)
	        //if (isset($_FILES['file1']) && $_FILES['file1']['name'] != '')
	        {
	        	$path = SELLER_ATTATCHMENTS_PATH.$merchant_id;

	            $isUploaded = $this->upload_image1($path, $img_data);
	            if (isset($isUploaded['db_error'])) 
	            {
	            	$msg = 'Error: '.$isUploaded['msg'];
					$code = CODE_ERROR_IN_QUERY;
	            }
	            else
		        {
		        	//get all images of shop
		        	$images = $this->Admin_model->selectRecords(array('link_id' => $merchant_id, 'atch_type' => 'IMAGE'), 'attatchments', 
		        		"CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', link_id, '/', atch_url) AS atch_url");

		        	$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                	$res = json_decode(json_encode($merchantDetail), True);
		        	$msg = 'image uploaded successfully!';
					$code = CODE_SUCCESS;
		        }
	        }
	        else
	        {
	        	$msg = 'Error: there is no such attachment!';
				$code = CODE_ERROR_PARAM_MISSING;
	        }
	    }
	    else
     	{
	     	$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    private function deleteShopImage1($file_name, $merchant_id)
    {
    	if ($file_name && $merchant_id) 
    	{
	    	//get file from db
	    	$fileData = $this->Admin_model->selectRecords(array('link_id' => $merchant_id), 'attatchments', 'atch_id, atch_url', array(), '', '', array('atch_url', $file_name));
	     	
	     	if ($fileData)
	     	{
	     		foreach ($fileData['result'] as $value) 
	     		{
		     		$fileName = $value['atch_url'];
		     		$fileId = $value['atch_id'];
		     		$path = SELLER_ATTATCHMENTS_PATH.'/'.$merchant_id.'/'.$fileName;

		     		//delete file from db and folder
		     		if (is_file($path))
		    		{
		    			//delete file from folder
			    		unlink($path);

			    		//delete file from db
			    		$this->Admin_model->deleteRecord('attatchments', array('atch_id' => $fileId));

			    		//update record 
						$deletedStatus = $this->saveDeleteItem($merchant_id, 'MERCHANT');
						if (isset($deletedStatus['db_error'])) 
			            {
			            	$msg = 'Error: '.$deletedStatus['msg'];
							$code = CODE_ERROR_IN_QUERY;
			            }
			    	}
			    }
	     	}
	     	else
	     		return false;
	    }
	    else
	    {
	    	$msg = 'ERROR: file_name, merchant_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

	    if (isset($code)) 
	    	$this->getJsonData($code, $msg, array());
	    
	    return true;
    }

    public function deleteShopImage()
    {
    	$res = array();
        $token = isset($this->requestData->token)?$this->requestData->token:"";
		$remove_img = $this->input->post('image_name');
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token && $remove_img) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		$isDeleted = $this->deleteShopImage1($remove_img, $merchant_id);
     		if ($isDeleted) 
     		{
     			$msg = 'Image deleted successfully!';
		     	$code = CODE_SUCCESS;
		     	$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
     		}
     		else
     		{
     			$msg = 'Error: image not found!';
		     	$code = CODE_ERROR_IN_QUERY;
     		}
     		
	    	//remove image from db and folder
			//delete from the folder
			/*$this->Admin_model->deleteRecord('attatchments', array('atch_url' => $remove_img));

			$path = SELLER_ATTATCHMENTS_PATH.$merchant_id;

			//if exist file, remove profile pic from folder
    		if (is_file($path.'/'.$remove_img))
    		{
	    		unlink($path.'/'.$remove_img);

				//update record 
				$deletedStatus = $this->saveDeleteItem($merchant_id, 'MERCHANT');
				if (isset($deletedStatus['db_error'])) 
	            {
	            	$msg = 'Error: '.$deletedStatus['msg'];
					$code = CODE_ERROR_IN_QUERY;
	            }
	            else
	            {
					$msg = 'Image deleted successfully!';
		     		$code = CODE_SUCCESS;
		     	}
		    }
		    else
		    {
		    	$msg = 'Error: unauthorized merchant';
		     	$code = CODE_SUCCESS;
		    }*/
		}
		else
     	{
	     	$msg = 'ERROR: token, image_name are required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    private function upload_image1($path, $img_data)
	{
		//insert category images
		for ($i = 1; $i < 7; $i++) 
		{ 
			$obj_name = 'file'.$i;
			if (isset($_FILES[$obj_name]['name']) && $_FILES[$obj_name]['name'] != '')
			{
				$new_name = $obj_name.'_'.rand();

				//delete image from db and folder
				$this->deleteShopImage1($obj_name, $img_data['link_id']);

				$img_data['atch_url'] = $this->common_controller->single_upload($path, $new_name, $obj_name);

				//insert images
				if ($img_data['atch_url'])
					$this->Admin_model->insertData('attatchments', $img_data);
			}
		}

		return true;
	}

	//delete listing
	public function deleteListingAPI($list_id)
	{
		$res = array();
		$token = isset($this->requestData->token) ? $this->requestData->token : "";

		if ($token && $list_id) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
     		$merchant_id = $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		//check listing id is available or not
     		$isListingExist = $this->Admin_model->selectRecords(array('listing_id' => $list_id), 'product_listing', 'merchant_id');
     		if (!$isListingExist) 
     		{
     			$msg = 'Error: Listing id not available';
		     	$code = CODE_ERROR_IN_QUERY;
     		}
     		else
     		{
     			if (!in_array("ADMIN", $merchantUserDetail['roles'])) 
	     		{
	     			if ($merchant_id != $isListingExist['result'][0]['merchant_id']) 
	     			{
	     				$msg = 'Error: unauthorized merchant';
			     		$code = CODE_ERROR_AUTHENTICATION_FAILED;

			     		$this->getJsonData($code, $msg, $res);
	     			}

	     			$where['merchant_id'] = $merchant_id;
	     		}

	     		$where['listing_id'] = $list_id;

	     		$isDeleted = $this->Admin_model->deleteRecord('product_listing', $where);
				if ($isDeleted > 0) 
				{
					$isDeleted = $this->saveDeleteItem($list_id, 'LISTING');
					if (isset($isDeleted['db_error'])) 
					{
						$msg = 'Error: '.$isDeleted['msg'];
			     		$code = CODE_ERROR_IN_QUERY;
					}
					else
					{
						$msg = 'Listing deleted successfully!';
			     		$code = CODE_SUCCESS;
			     		$res['deleted_listing_id'] = array($list_id);
			     	}
			    }
			    else
				{
					$msg = 'Error: unable to delete listing';
			     	$code = CODE_ERROR_IN_QUERY;
				}
			}
     	}
     	else
     	{
	     	$msg = 'ERROR: token and listing_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}

	//get requested product
	public function getRequestedProduct()
	{
		$res = array();
        $token = isset($this->requestData->token)?$this->requestData->token:"";
        $merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

			$req_prds = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id, 'status' => 'PENDING'), 'requested_product', 'SQL_CALC_FOUND_ROWS request_id, product_name, description, brand_name, amazon_link, flipkart_link, paytm_link, other_link1, other_link2, isLinked, update_date AS last_updated', array(), $this->limit, $this->start, array(), true);

			$msg = 'ok';
	     	$code = CODE_SUCCESS;
			$res['requested_products'] = ($req_prds) ? $req_prds['result'] : array();
			
			//pagination array
			if (isset($req_prds['count'])) 
				$res['paging'] = $this->createPagingArray($req_prds['count']);
		}
		else
		{
			$msg = 'ERROR: token, merchant_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);
	}

	//delete listing
	public function deleteRequestedProduct()
	{
		$res = array();
        $req_id = isset($this->requestData->requested_product_id)?$this->requestData->requested_product_id:"";
		$token = isset($this->requestData->token)?$this->requestData->token:"";

		if ($token && $req_id) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
     		$merchant_id = $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		if (!in_array("ADMIN", $merchantUserDetail['roles'])) 
     			$where['merchant_id'] = $merchant_id;

     		$where['request_id'] = $req_id;
			$isDeleted = $this->Admin_model->deleteRecord('requested_product', $where);
			if ($isDeleted > 0) 
			{
				$isDeleted = $this->saveDeleteItem($req_id, 'REQUESTED_PRODUCT');
				if (isset($isDeleted['db_error'])) 
				{
					$msg = 'Error: '.$isDeleted['msg'];
		     		$code = CODE_ERROR_IN_QUERY;
				}
				else
				{
					$msg = 'Requested product deleted successfully!';
		     		$code = CODE_SUCCESS;
		     		$res['deleted_requested_product_id'] = $req_id;
		     	}
			}
			else
			{
				$msg = 'Error: unauthorized merchant';
		     	$code = CODE_ERROR_AUTHENTICATION_FAILED;
			}
     	}
     	else
     	{
	     	$msg = 'ERROR: token, requested_product_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}

	public function updateMerchantDefaultValues()
	{
    	$token = isset($this->requestData->token) ? $this->requestData->token : "";
    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
        $res = array();

        if ($token) 
        {
        	$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
        	$this->isValidToken($token, $user_id);

        	//seller data
            $seller_data = array();
            $seller_data['finance_available'] = isset($this->requestData->finance_available) ? $this->requestData->finance_available : "";
            $seller_data['finance_terms'] = isset($this->requestData->finance_terms) ? $this->requestData->finance_terms : "";
            $seller_data['home_delivery_available'] = isset($this->requestData->home_delivery_available) ? $this->requestData->home_delivery_available : "";
            $seller_data['home_delivery_terms'] = isset($this->requestData->home_delivery_terms) ? $this->requestData->home_delivery_terms : "";
            $seller_data['installation_available'] = isset($this->requestData->installation_available) ? $this->requestData->installation_available : "";
            $seller_data['installation_terms'] = isset($this->requestData->installation_terms) ? $this->requestData->installation_terms : "";
            $seller_data['replacement_available'] = isset($this->requestData->replacement_available) ? $this->requestData->replacement_available : "";
            $seller_data['replacement_terms'] = isset($this->requestData->replacement_terms) ? $this->requestData->replacement_terms : "";
            $seller_data['return_available'] = isset($this->requestData->return_available) ? $this->requestData->return_available : "";
            $seller_data['return_policy'] = isset($this->requestData->return_policy) ? $this->requestData->return_policy : "";
            $seller_data['seller_offering'] = isset($this->requestData->seller_offering) ? $this->requestData->seller_offering : "";
            $seller_data['update_date'] = $this->current_date;

            //update merchant data
            $this->Admin_model->updateData('merchant', $seller_data, array('merchant_id' => $merchant_id));

            //get merchant data
            $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
            $res = json_decode(json_encode($merchantDetail), True);
            $msg = 'Merchant update successfully!';
			$code = CODE_SUCCESS;
        }
        else
        {
        	$msg = 'ERROR: token required!';
			$code = CODE_ERROR_PARAM_MISSING;
        }

        $this->getJsonData($code, $msg, $res);
	}

	public function addAddress()
	{
		$token = isset($this->requestData->token) ? $this->requestData->token : "";
    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
    	$res = array();

        if ($token) 
        {
        	$merchantUserDetail = $this->merchantUserDetail($token);

        	if ($merchant_id) 
        	{
        		$merchant_user_id = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     			$user_id = $merchant_user_id['result'][0]['userId'];
        	}
        	else
        	{
        		$user_id = $merchantUserDetail['userId'];
        		$merchant_id = $merchantUserDetail['merchant_id'];
        	}

        	$this->isValidToken($token, $merchantUserDetail['userId']);

        	if ($user_id) 
        	{
	        	//insert merchant address
	            $address_id = $this->insertAddress1($user_id);
	            if ($address_id['status'] > 2) 
		            $this->getJsonData(CODE_ERROR_IN_QUERY, $address_id['msg'], $res);
	            else 
	            {
	            	if ($address_id['status'] == 1) 
	            		$msg = 'Address updated successfully!';
	            	else if ($address_id['status'] == 2) 
	            		$msg = 'Address added successfully!';

					$code = CODE_SUCCESS;

					//get inserted or updated address
		            $columns = 'SQL_CALC_FOUND_ROWS address_id, address.userId as user_id, merchant_id, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city';

					$mer_reviews = $this->Admin_model->getUserAddress(array('address.userId' => $user_id, 'address.address_id' => $address_id['address_id']), $columns);
					$res['addresses'] = $mer_reviews['result'][0];
	            }
			}
			else
			{
				$msg = 'ERROR: wrong merchant_id';
				$code = CODE_ERROR_PARAM_MISSING;
			}
        }
        else
        {
        	$msg = 'ERROR: token required!';
			$code = CODE_ERROR_PARAM_MISSING;
        }

        $this->getJsonData($code, $msg, $res);
	}

	//add/update user or merchant address
	private function insertAddress1($user_id)
	{
		$address_id = isset($this->requestData->address_id)?$this->requestData->address_id:"";

		//address detail
		$address_data['address_line_1'] = isset($this->requestData->address_line_1)?$this->requestData->address_line_1:"";

		if (isset($this->requestData->address_line_2))
			$address_data['address_line_2'] = $this->requestData->address_line_2;

		if (isset($this->requestData->landmark))
			$address_data['landmark'] = $this->requestData->landmark;

		if (isset($this->requestData->pin))
			$address_data['pin'] = $this->requestData->pin;

		if (isset($this->requestData->locality))
			$address_data['locality'] = $this->requestData->locality;

		$address_data['is_default_address'] = isset($this->requestData->is_default_address)?$this->requestData->is_default_address:0;

		if (isset($this->requestData->contact))
			$address_data['contact'] = $this->requestData->contact;

		if (isset($this->requestData->business_days))
			$address_data['business_days'] = $this->requestData->business_days;

		if (isset($this->requestData->business_hours))
			$address_data['business_hours'] = $this->requestData->business_hours;

		$address_data['latitude'] = isset($this->requestData->latitude)?$this->requestData->latitude:"";
		$address_data['longitude'] = isset($this->requestData->longitude)?$this->requestData->longitude:"";

		$address_data['country_id'] = isset($this->requestData->country_id)?$this->requestData->country_id:"";
		$address_data['state_id'] = isset($this->requestData->state_id)?$this->requestData->state_id:"";
		$address_data['city_id'] = isset($this->requestData->city_id)?$this->requestData->city_id:"";
		$address_data['update_date'] = $this->current_date;

		//get lat long from address
		if (!$address_data['latitude'] || !$address_data['longitude']) 
		{
			$address_values = getLAtLongFromAddress($address_data);
			$address_values = json_decode(json_encode($address_values), True);
			
			if (isset($address_values['msg'])) 
				return array('status' => 3, 'msg' => 'Error: '.$address_values['msg']);

            if ($address_values) 
            {
                $address_data['latitude'] = $address_values['results'][0]['geometry']['location']['lat'];
                $address_data['longitude'] = $address_values['results'][0]['geometry']['location']['lng'];
            }
		}
		else if(preg_match("/^\\d+\\.\\d+$/", $address_data['latitude']) !== 1 || preg_match("/^\\d+\\.\\d+$/", $address_data['longitude']) !== 1)
			return array('status' => 4, 'msg' => 'Error: latitude, longitude are not in correct format.');

		//update address detail
		if ($address_id) 
		{
			//check address is exist or not
			$addressRes = $this->Admin_model->selectRecords(array('address_id' => $address_id), 'address', 'userId');
			if ($addressRes) 
			{
				$condition = array('address_id' => $address_id);
				$this->Admin_model->updateData('address', $address_data, $condition);

				return array('status' => 1, 'address_id' => $address_id);
			}
			else
				return array('status' => 6, 'msg' => 'Error: wrong address_id');
		}
		else
		{
			$address_data['userId'] = $user_id;
			$address_data['create_date'] = $this->current_date;

			$address_id = $this->Admin_model->insertData('address', $address_data);

			if ($address_id) 
				return array('status' => 2, 'address_id' => $address_id);
		}

		return array('status' => 5, 'msg' => 'Error: something went wrong.');
	}

	public function addRequestedProduct()
	{
		$res = array();
        $req_prd_data = array();
        $requested_detail = $this->requestData->requested_detail;
		$req_prd_id = isset($requested_detail->request_id)?$requested_detail->request_id:"";
		$product_name = isset($requested_detail->product_name)?$requested_detail->product_name:"";
		$req_prd_data['product_name'] = $product_name;
		$brand_name = isset($requested_detail->brand_name)?$requested_detail->brand_name:"";
		$req_prd_data['brand_name'] = $brand_name;
		$prd_desc = isset($requested_detail->prd_desc
		)?$requested_detail->prd_desc:"";
		$req_prd_data['description'] = $prd_desc;
		$req_prd_data['amazon_link'] = isset($requested_detail->merchant_id)?$requested_detail->merchant_id:"";
		$req_prd_data['flipkart_link'] = isset($requested_detail->flipkart_link)?$requested_detail->flipkart_link:"";
		$req_prd_data['paytm_link'] = isset($requested_detail->paytm_link)?$requested_detail->paytm_link:"";
		$req_prd_data['other_link1'] = isset($requested_detail->other_link1)?$requested_detail->other_link1:"";
		$req_prd_data['other_link2'] = isset($requested_detail->other_link2)?$requested_detail->other_link2:"";
		$req_prd_data['update_date'] = $this->current_date;
		$token = isset($this->requestData->token)?$this->requestData->token:"";

		if ($token && $product_name) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		$req_prd_data['merchant_id'] = $merchant_id;

     		if (!$req_prd_data['amazon_link'] && !$req_prd_data['flipkart_link'] && !$req_prd_data['paytm_link'] && !$req_prd_data['other_link1'] && !$req_prd_data['other_link2']) 
     		{
     			$msg = 'Error: please set atleast one referance link!';
	     		$code = CODE_ERROR_PARAM_MISSING;
     		}
			else
			{
				//check product name is already exist in requested product or product table
				$isExistProduct = $this->Admin_model->checkRequestedProductExistance($product_name);
				if ($isExistProduct) 
				{
					$msg = 'Error: product_name already exist';
	     			$code = CODE_ERROR_PARAM_MISSING;
				}
				else if ($req_prd_id) 
				{
					$condition = array('request_id' => $req_prd_id);
					$this->Admin_model->updateData('requested_product', $req_prd_data, $condition);

					$msg = "Requested product updated successfully!!";
					$code = CODE_SUCCESS;
				}
				else
				{
					$req_prd_data['create_date'] = $this->current_date;

					$req_prd_id = $this->Admin_model->insertData('requested_product', $req_prd_data);

					if ($req_prd_id)
					{
						$msg = "Requested product inserted successfully!!";
						$code = CODE_SUCCESS;
					}
					else
					{
						$msg = "Error: Unable to insert requested product!";
						$code = CODE_ERROR_IN_QUERY;
					}
				}

				//insert or update product
				if ($req_prd_id) 
				{
					$data = array();
					$images = array();
					$product_detail = $this->requestData->product_detail;
					$prd_id = isset($product_detail->product_id)?$product_detail->product_id:"";
					$data['category_id'] = isset($product_detail->category_id)?$product_detail->category_id:"";
					$data['brand_id'] = isset($product_detail->brand_id)?$product_detail->brand_id:"";
					$data['product_name'] = $product_name;
					$data['mrp_price'] = isset($product_detail->prd_price)?$product_detail->prd_price:"";
					$data['description'] = $prd_desc;
					$data['in_the_box'] = isset($product_detail->in_the_box)?$product_detail->in_the_box:"";
					$data['update_date'] = $this->current_date;
					
					if (count(array_filter($data)) >= 3) 
					{
						$data['create_date'] = $this->current_date;

						if ($prd_id)
							$this->Admin_model->updateData('product', $data, array('product_id' => $prd_id));
						else
							$prd_id = $this->Admin_model->insertData('product', $data);

						if ($prd_id) 
						{
							//insert or update product attribute values
							//insert product category attribute
							$category_attributes_res = $this->Admin_model->categoryAttributes($data['category_id'], $prd_id);	

							$category_attributes = array();
							if ($category_attributes_res)
								$category_attributes = $category_attributes_res;

							$tbl_name = 'category_attribute_value';
							$i = 0;
							foreach ($category_attributes as $att_value) 
							{
								if ($att_value['mp_id']) 
								{
									$att_field_value = $this->input->post($att_value['att_id']);

									$columns = 'value_id';
									$where = array('prd_id' => $prd_id, 'cat_att_mp_id' => $att_value['mp_id']);
									$prd_att_res = $this->Admin_model->selectRecords($where, $tbl_name, $columns);
									
									$att_values_data['cat_att_mp_id'] = $att_value['mp_id'];
									$att_values_data['prd_id'] = $prd_id;
									$att_values_data['att_value'] = $att_field_value;	
									
									if ($prd_att_res) //update attribute value
									{
										$condition = array('value_id' => $prd_att_res['result'][0]['value_id']);
										$this->Admin_model->updateData($tbl_name, $att_values_data, $condition);
									}
									else //insert attribute value
										$this->Admin_model->insertData($tbl_name, $att_values_data);
								}
							}

							if ($req_prd_id) 
							{
								$listing_data = $this->Admin_model->selectRecords(array('req_prd_id' => $req_prd_id), 'product_listing', 'listing_id');
								
								if ($listing_data) 
									$this->Admin_model->updateData('product_listing', array('product_id' => $prd_id), array('req_prd_id' => $req_prd_id));
								else
									$this->Admin_model->insertData('product_listing', array('req_prd_id' => $req_prd_id, 'product_id' => $prd_id, 'merchant_id' => $merchant_id));

								$this->Admin_model->updateData('requested_product', array('status' => 'CREATED'), array('request_id' => $req_prd_id));
							}

							$key_features = isset($product_detail->key_features)?$product_detail->key_features:"";

							//insert product key features
							if ($key_features) 
							{
								$key_feature_data = array();
								$key_feature_data['product_id'] = $prd_id;

								foreach ($key_features as $key_feature_value)
								{
									$key_feature_data['feature'] = $key_feature_value;
									$key_feature_id = $this->Admin_model->insertData('product_key_features', $key_feature_data);

									if (!$key_feature_id)
									{
										$msg = 'Error: Unable to insert product feature!';
										$code = CODE_ERROR_IN_QUERY;
									}
								}
							}
						}
						else
						{
							$code = CODE_ERROR_IN_QUERY;
							$msg = 'Error: Unable to insert product!';
						}
					}
					else
					{
						$msg = 'ERROR: category_id, brand_id, product_name required';
	     				$code = CODE_ERROR_PARAM_MISSING;
					}
				}
			}
     	}
     	else
     	{
	     	$msg = 'ERROR: token, product_name are required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}

	public function addListing()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
		$product_id = isset($this->requestData->product_id)?$this->requestData->product_id:"";
		$list_id = false;

		if ($token && $merchant_id && $product_id) 
     	{
     		//$req_prd_id = $this->input->post('req_prd_id');
			//$merchant_id = $this->input->post('merchant_id');
			//$list_id = $this->input->post('listing_id');

     		$merchantUserDetail = $this->merchantUserDetail($token);

        	if ($merchant_id) 
        	{
        		$merchant_user_id = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     			$user_id = $merchant_user_id['result'][0]['userId'];
        	}
        	else
        	{
        		$user_id = $merchantUserDetail['userId'];
        		$merchant_id = $merchantUserDetail['merchant_id'];
        	}

        	$this->isValidToken($token, $user_id);

			$listing_data = array();
			$listing_data['merchant_id'] = $merchant_id;
			//$listing_data['list_price'] = isset($this->requestData->list_price)?$this->requestData->list_price:"";
			$listing_data['sell_price'] = isset($this->requestData->price)?$this->requestData->price:"";
			$listing_data['finance_available'] = isset($this->requestData->finance_available)?$this->requestData->finance_available:"0";
			$listing_data['finance_terms'] = isset($this->requestData->finance_terms)?$this->requestData->finance_terms:"";
			$listing_data['home_delivery_available'] = isset($this->requestData->home_delivery_available)?$this->requestData->home_delivery_available:"0";
			$listing_data['home_delivery_terms'] = isset($this->requestData->home_delivery_terms)?$this->requestData->home_delivery_terms:"";
			$listing_data['installation_available'] = isset($this->requestData->installation_available)?$this->requestData->installation_available:"0";
			$listing_data['installation_terms'] = isset($this->requestData->installation_terms)?$this->requestData->installation_terms:"";
			$listing_data['in_stock'] = isset($this->requestData->in_stock)?$this->requestData->in_stock:"0";
			$listing_data['will_back_in_stock_on'] = isset($this->requestData->will_back_in_stock_on)?$this->requestData->will_back_in_stock_on:"";
			$listing_data['replacement_available'] = isset($this->requestData->replacement_available)?$this->requestData->replacement_available:"0";
			$listing_data['replacement_terms'] = isset($this->requestData->replacement_terms)?$this->requestData->replacement_terms:"";
			$listing_data['return_available'] = isset($this->requestData->return_available)?$this->requestData->return_available:"0";
			$listing_data['return_policy'] = isset($this->requestData->return_policy)?$this->requestData->return_policy:"";
			$listing_data['seller_offering'] = isset($this->requestData->seller_offering)?$this->requestData->seller_offering:"";
			$listing_data['update_date'] = $this->current_date;
			$listing_data['isVerified'] = 1;
			$listing_data['product_id'] = $product_id;

			/*if ($this->input->post('prd_id'))
				$listing_data['product_id'] = $this->input->post('prd_id');
			else if($req_prd_id)
				$listing_data['req_prd_id'] = $req_prd_id;*/

			//check merchent and product is already exist or not
			$condition = array('product_id' => $product_id, 'merchant_id' => $merchant_id);
			$isExistMerchantReview = $this->Admin_model->selectRecords($condition, 'product_listing', 'listing_id');
			if ($isExistMerchantReview) 
			{
				$list_id = $isExistMerchantReview['result'][0]['listing_id'];
				$this->Admin_model->updateData('product_listing', $listing_data, array('listing_id' => $list_id));

				$msg = "Detail updated successfully!!";	
				$code = CODE_SUCCESS;
			}
			else
			{
				$listing_data['isVerified'] = 0;
				$listing_data['create_date'] = $this->current_date;

				$list_id = $this->Admin_model->insertData('product_listing', $listing_data);

				if ($list_id)
				{
					$msg = "Detail inserted successfully!!";
					$code = CODE_SUCCESS;
				}
			}

			if ($list_id) 
			{
				$listingData = $this->Admin_model->selectRecords(array('listing_id' => $list_id), 'product_listing', 'listing_id, product_id, merchant_id, sell_price AS price, finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, in_stock, will_back_in_stock_on, replacement_available, replacement_terms, return_available, return_policy, seller_offering, isVerified');
				$res['listing'] = $listingData['result'][0];
			}
			else
			{
				$msg = "Error: unable to update information.";
				$code = CODE_ERROR_IN_QUERY;
			}
		}
		else
     	{
	     	$msg = 'ERROR: token, merchant_id, product_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}
	
	public function deleteLogo()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
     		$user_id = $merchantUserDetail['userId'];
        	if (!$merchant_id) 
        		$merchant_id = $merchantUserDetail['merchant_id'];

        	$merchantLogo = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'merchant_logo');
     		$merchantLogo = $merchantLogo['result'][0]['merchant_logo'];
     		
     		$this->isValidToken($token, $user_id);

     		if ($merchantLogo) 
     		{
     			$file = SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$merchantLogo;
     			if (is_file($file))
		    		unlink($file);

		    	$this->Admin_model->updateData('merchant', array('merchant_logo' => ''), array('merchant_id' => $merchant_id));

		    	$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
				$msg = "Logo removed!";	
				$code = CODE_SUCCESS;
     		} 
     		else
     		{
     			$msg = "Error: logo not found!";	
				$code = CODE_ERROR_IN_QUERY;	
     		}       	
     	}
     	else
     	{
     		$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function deleteAddress1()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
		$address_id = isset($this->requestData->address_id)?$this->requestData->address_id:"";

		if ($token) 
     	{
     		if ($merchant_id) 
        	{
        		$userId = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     			$user_id = $userId['result'][0]['userId'];
        	}
        	else
        	{
        		$merchantUserDetail = $this->merchantUserDetail($token);
     			$user_id = $merchantUserDetail['userId'];
        	}

        	$address_data = $this->Admin_model->selectRecords(array('address_id' => $address_id), 'address', 'userId, is_default_address');
     		
     		if (!$address_data) 
     		{
     			$msg = 'ERROR: wrong address_id';
	     		$code = CODE_ERROR_IN_QUERY;
     		}
     		else if ($address_data['result'][0]['userId'] == $user_id) 
     		{
     			$this->Admin_model->deleteRecord('address', array('address_id' => $address_id));
     			$this->saveDeleteItem($address_id, 'ADDRESS');

     			//check if deleted record has default address
     			if ($address_data['result'][0]['is_default_address'] == 1) 
     			{
     				$address = $this->Admin_model->selectRecords(array('address_id' => $address_id), 'address', 'address_id', array('address_id' => 'ASC'), 1, 0);
     				if ($address) 
     				{
     					$address_id = $userId['result'][0]['address_id'];
     					$this->Admin_model->updateData('address', array('is_default_address' => 1), array('address_id' => $address_id, 'update_date' => $this->current_date));
     				}
     			}

     			$msg = 'address deleted successfully';
	     		$code = CODE_SUCCESS;
	     		$res['deleted_address_id'] = array($address_id);
     		}
     		else
     		{
     			$msg = 'ERROR: unauthorized merchant';
	     		$code = CODE_ERROR_IN_QUERY;
     		}
        }
        else
     	{
     		$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function changeMerchantPassword()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$old_password = isset($this->requestData->old_password)?$this->requestData->old_password:"";
		$new_password = isset($this->requestData->new_password)?$this->requestData->new_password:"";
		$new_token = md5(uniqid(rand(), true));

		if ($old_password != '' && $new_password != '' && $token != '') 
     	{
			$merchantUserDetail = $this->merchantUserDetail($token);
	     	$user_id = $merchantUserDetail['userId'];
	     	$merchant_id = $merchantUserDetail['merchant_id'];

			$condition = array('userId' => $user_id, 'password' => $old_password);
			$isValidaOldPassword = $this->Admin_model->selectRecords($condition, 'user', 'userId');

			if ($isValidaOldPassword) 
			{
				$condition = array('userId' => $user_id);
				$this->Admin_model->updateData('user', array('password' => $new_password, 'auth_token' => $new_token), $condition);

				//get merchant detail
                $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
				$msg = 'Password changed!';
				$code = CODE_SUCCESS;
			}
			else
			{
				$msg = 'ERROR: old_password is not correct!';
				$code = CODE_ERROR_UNKNOWN;
			}
		}
		else
     	{
     		$msg = 'ERROR: token, new_password, old_password required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function resetMerchantPassword()
	{
		$res = array();
		
		$token = $this->resetPassword(true);

		$merchantUserDetail = $this->merchantUserDetail($token);
     	$user_id = $merchantUserDetail['userId'];
     	$merchant_id = $merchantUserDetail['merchant_id'];

     	//get merchant detail
        $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
        $res = json_decode(json_encode($merchantDetail), True);
		$msg = 'Password sent to your mail id!';
		$code = CODE_SUCCESS;

     	$this->getJsonData($code, $msg, $res);
	}

	public function getCategoryAttribtes($cat_id)
	{
		$category_attributes_res = $this->Admin_model->categoryAttribute1($cat_id);
		
		$res['category_id'] = $cat_id;
		$res['specifications'] = ($category_attributes_res) ? $category_attributes_res : array();

		$code = CODE_SUCCESS;
		$msg = 'category attributes';
		$this->getJsonData($code, $msg, $res);
	}

	//-- function for return json encoded data
    public function getJsonData($code, $msg, $data)
	{
		$arrayResponse = $data;
		$arrayResponse['code'] = $code;
		$arrayResponse['msg'] = $msg;
		$arrayResponse['response_date_time'] = date("Y-m-d H:i:s");

		echo json_encode($arrayResponse);
		die;
	}

	public function createPagingArray($count = 0)
	{
		if ($count || $this->current_page == 1) 
		{
			$paging = array();

			$paging['total_results'] = $count;
			
			if (!$count) 
				$paging['total_pages'] = $this->current_page;
			else
				$paging['total_pages'] = ceil($count/$this->limit);
			
			$paging['page'] = $this->current_page;
			$paging['limit'] = $this->limit;

			return $paging;
		}
		else
		{
			$msg = 'ERROR: Requested for wrong page.';
			$code = CODE_ERROR_WRONG_PAGE;
			$this->getJsonData($code, $msg, array());
		}
	}
}
