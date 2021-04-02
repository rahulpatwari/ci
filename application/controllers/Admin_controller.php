<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Common_controller.php';

class Admin_controller extends Common_controller 
{
	function __construct()
	{
		parent::__construct();

		//clean all garbage objects
		ob_start();

		//session start from here
		session_start();

		//get seller data
		$this->sellers = $this->Admin_model->sellers();
		if (isset($this->sellers['db_error'])) 
			$this->dashboard();

		//current date
		$this->current_date = date("Y-m-d H:i:s");

		//allow header
        header("Access-Control-Allow-Headers: Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		header("Access-Control-Allow-Origin: *");

		//common controller
		$this->common_controller = new Common_controller();

		//get request data
		if(file_get_contents("php://input"))
     		$this->requestData = json_decode(file_get_contents("php://input"));
     	else
     		$this->requestData = (object)$_POST;
	}

	public function site_settings()
	{
		$data = array();
		$site_setting = $this->Admin_model->selectRecords('', 'site_settings', 'setting_type, value');
		if (isset($site_setting['db_error'])) 
			redirectWithMessage('Error: '.$site_setting['msg'], $controller);
		else if ($site_setting) 
		{
			foreach ($site_setting['result'] as $value) 
				$data[$value['setting_type']] = $value['value'];

			return $data;
		}
		else
			redirectWithMessage('Error: Unable to get settings', 'dashboard');
	}

	public function updateSiteSetting()
	{
		$product_title_suffix = $this->input->post('product_title_suffix');
		$merchant_title_suffix = $this->input->post('merchant_title_suffix');
		$brand_title_suffix = $this->input->post('brand_title_suffix');
		$listing_title_suffix = $this->input->post('listing_title_suffix');
		$category_title_suffix = $this->input->post('category_title_suffix');
		$home_page_meta_description = $this->input->post('home_page_meta_description');
		$home_page_title = $this->input->post('home_page_title');
		$home_page_key_words = $this->input->post('home_page_key_words');
		$merchants_meta_title = $this->input->post('merchants_meta_title');
		$merchants_meta_description = $this->input->post('merchants_meta_description');
		$merchants_meta_keywords = $this->input->post('merchants_meta_keywords');
		$products_meta_title = $this->input->post('products_meta_title');
		$products_meta_description = $this->input->post('products_meta_description');
		$products_meta_keywords = $this->input->post('products_meta_keywords');
		$brands_meta_title = $this->input->post('brands_meta_title');
		$brands_meta_description = $this->input->post('brands_meta_description');
		$brands_meta_keywords = $this->input->post('brands_meta_keywords');
		$categories_meta_title = $this->input->post('categories_meta_title');
		$categories_meta_description = $this->input->post('categories_meta_description');
		$categories_meta_keywords = $this->input->post('categories_meta_keywords');

		$this->Admin_model->updateData('site_settings', array('value' => $product_title_suffix), array('setting_type' => 'product_title_suffix'));
		$this->Admin_model->updateData('site_settings', array('value' => $merchant_title_suffix), array('setting_type' => 'merchant_title_suffix'));
		$this->Admin_model->updateData('site_settings', array('value' => $brand_title_suffix), array('setting_type' => 'brand_title_suffix'));
		$this->Admin_model->updateData('site_settings', array('value' => $listing_title_suffix), array('setting_type' => 'listing_title_suffix'));
		$this->Admin_model->updateData('site_settings', array('value' => $category_title_suffix), array('setting_type' => 'category_title_suffix'));
		$this->Admin_model->updateData('site_settings', array('value' => $home_page_meta_description), array('setting_type' => 'home_page_meta_description'));
		$this->Admin_model->updateData('site_settings', array('value' => $home_page_title), array('setting_type' => 'home_page_title'));
		$this->Admin_model->updateData('site_settings', array('value' => $home_page_key_words), array('setting_type' => 'home_page_key_words'));
		$this->Admin_model->updateData('site_settings', array('value' => $merchants_meta_title), array('setting_type' => 'merchants_meta_title'));
		$this->Admin_model->updateData('site_settings', array('value' => $merchants_meta_description), array('setting_type' => 'merchants_meta_description'));
		$this->Admin_model->updateData('site_settings', array('value' => $merchants_meta_keywords), array('setting_type' => 'merchants_meta_keywords'));
		$this->Admin_model->updateData('site_settings', array('value' => $products_meta_title), array('setting_type' => 'products_meta_title'));
		$this->Admin_model->updateData('site_settings', array('value' => $products_meta_description), array('setting_type' => 'products_meta_description'));
		$this->Admin_model->updateData('site_settings', array('value' => $products_meta_keywords), array('setting_type' => 'products_meta_keywords'));
		$this->Admin_model->updateData('site_settings', array('value' => $brands_meta_title), array('setting_type' => 'brands_meta_title'));
		$this->Admin_model->updateData('site_settings', array('value' => $brands_meta_description), array('setting_type' => 'brands_meta_description'));
		$this->Admin_model->updateData('site_settings', array('value' => $brands_meta_keywords), array('setting_type' => 'brands_meta_keywords'));
		$this->Admin_model->updateData('site_settings', array('value' => $categories_meta_title), array('setting_type' => 'categories_meta_title'));
		$this->Admin_model->updateData('site_settings', array('value' => $categories_meta_description), array('setting_type' => 'categories_meta_description'));
		$this->Admin_model->updateData('site_settings', array('value' => $categories_meta_keywords), array('setting_type' => 'categories_meta_keywords'));


		redirectWithMessage('Settings updated succesfully', 'page/siteSettings');	
	}

	//create database backup
	public function createDbBackup()
	{
		$this->Admin_model->createDbBackup();
		redirect(base_url(), 'refresh');
	}

	//load 404 error page
	public function Error404()
	{
		$this->output->set_status_header('404');

        $this->load->view('admin/include/header');
		$this->load->view('error404');
		$this->load->view('admin/include/footer');
	}

	//login method
	public function doLogin()
	{
		if (!isset($_COOKIE['site_code'])) 
		{
			redirect('', 'refresh');
			die;
		}

		//get controller
		$controller = 'login';

		$usr_roles = array(); 
		$usr_details = array();
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$usr_id = $this->Admin_model->doLogin($username, $password);
		if (isset($usr_id['db_error'])) 
			redirectWithMessage('Error: '.$usr_id['msg'], $controller);
		else if ($usr_id) 
		{
			$usr_id = $usr_id['userId'];
			$usr_details = $this->Admin_model->getUser($usr_id, 1);
			
			if (isset($usr_details['db_error'])) 
				redirectWithMessage('Error: '.$usr_details['msg'], $controller);
			else
			{
				$usr_roles = $this->Admin_model->selectRecords(array('usr_id' => $usr_id), 'user_type', '*');
				if (isset($usr_roles['db_error'])) 
					redirectWithMessage('Error: '.$usr_roles['msg'], $controller);
				else if ($usr_details) 
				{
					$usr_roles = array_column($usr_roles['result'], 'type_name');
					
					if (in_array('ADMIN', $usr_roles) || in_array('EXECUTIVE', $usr_roles))
						$this->cookieSetupForLogin($usr_details);
					else
						redirectWithMessage('Error: Not authorised for login!', $controller);
				}
				else
					redirectWithMessage('Error: You are not a varified user, please contact to system administrator!', $controller);
			}
		}
		else
			redirectWithMessage('Error: Wrong credential!', $controller);
	}

	public function cookieSetupForLogin($usr_details)
    {
    	//get or create user token for login
        if (!$usr_details[0]['auth_token']) 
            $token = $this->createToken($usr_details[0]['userId']);
        else
            $token = $usr_details[0]['auth_token'];
        
        //set logged in user detail in cookies 
        if ($token) 
            setcookie('token', $token, null, "/");
        else
            redirectWithMessage('Error: Token not found!', 'login');

        $name = $usr_details[0]['first_name']." ".$usr_details[0]['middle_name']." ".$usr_details[0]['last_name'];

        setcookie('user_id', $usr_details[0]['userId'], null, "/");
        setcookie('email', $usr_details[0]['email'], null, "/");
        setcookie('status', $usr_details[0]['status'], null, "/");
        setcookie('name', $name, null, "/");
        setcookie('image', $usr_details[0]['profile_image'], null, "/");

        if (isset($usr_details['merchant_id'])) 
        {
        	setcookie('merchant_id', $usr_details['merchant_id'], null, "/");
        	$_SESSION['merchant_id'] = $usr_details['merchant_id'];
        }

        $_SESSION['usr_detail'] = $usr_details[0];

        redirect('dashboard', 'refresh');
    }

	public function createToken($user_id)
	{
		if ($user_id) 
		{
			$where = array('userId' => $user_id);
			$isExistToken = $this->Admin_model->selectRecords($where, 'user', 'auth_token');

			if ($isExistToken && !empty($isExistToken['result'][0]['auth_token'])) 
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

		return false;
	}

	public function login()
	{
		if (isset($_COOKIE['site_code'])) 
			$this->load->view('admin/login');
		else
			redirect('', 'refresh');
	}

	//send to dashboard page
	public function dashboard()
	{
		$this->isLoggedIn();

		$counts['counts'] = $this->getCounts();

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/index', $counts);
		$this->load->view('admin/include/footer');
		die;
	}

	public function getCounts()
	{
		$product_count = $this->Admin_model->selectRecords('', 'product', 'COUNT(product_id) AS prd_cnt');

		if (isset($product_count['db_error'])) 
			$this->logout();

		$brand_count = $this->Admin_model->selectRecords('', 'brand', 'COUNT(brand_id) AS brand_cnt');
		if (isset($brand_count['db_error'])) 
			$this->logout();

		$consumer_count = $this->Admin_model->selectRecords('', 'consumer', 'COUNT(consumer_id) AS con_cnt');
		if (isset($consumer_count['db_error'])) 
			$this->logout();

		$varified_seller_count = $this->Admin_model->selectRecords(array('is_verified' => 1), 'merchant', 'COUNT(merchant_id) AS sel_cnt');
		if (isset($varified_seller_count['db_error'])) 
			$this->logout();

		$not_varified_seller_count = $this->Admin_model->selectRecords(array('is_verified' => 0) , 'merchant', 'COUNT(merchant_id) AS sel_cnt');
		if (isset($not_varified_seller_count['db_error'])) 
			$this->logout();

		$pending_requested_product_count = $this->Admin_model->selectRecords(array('isLinked' => 0), 'requested_product', 'COUNT(request_id) AS pen_req_prd_cnt');
		if (isset($pending_requested_product_count['db_error'])) 
			$this->logout();

		if ($_COOKIE['site_code'] == "seller") 
		{
			$where1 = array('merchant_id' => $_COOKIE['merchant_id']);
		}
		else
		{
			$where1 = "";
		}

		$listed_products_count = $this->Admin_model->selectRecords($where1, 'product_listing', 'COUNT(listing_id) AS lst_prd_cnt');
		if (isset($listed_products_count['db_error'])) 
			$this->logout();

		$where = array('link_id' => NULL, 'atch_type' => 'ZIP', 'atch_for' => 'DB_BACKUP');
		$last_db_backup_time = $this->Admin_model->selectRecords($where, 'attatchments', 'create_date', array('create_date' => 'DESC'), 1);
		if (isset($last_db_backup_time['db_error'])) 
			$this->logout();
		
		$counts['product_count'] = $product_count['result'][0]['prd_cnt'];
		$counts['brand_count'] = $brand_count['result'][0]['brand_cnt'];
		$counts['consumer_count'] = $consumer_count['result'][0]['con_cnt'];
		$counts['varified_seller_count'] = $varified_seller_count['result'][0]['sel_cnt'];
		$counts['not_varified_seller_count'] = $not_varified_seller_count['result'][0]['sel_cnt'];
		$counts['pending_requested_product_count'] = $pending_requested_product_count['result'][0]['pen_req_prd_cnt'];
		$counts['listed_products_count'] = $listed_products_count['result'][0]['lst_prd_cnt'];
		$counts['last_db_backup_time'] = $last_db_backup_time['result'][0]['create_date'];

		if (($_COOKIE['site_code'] == 'seller') && isset($_COOKIE['merchant_id'])) 
		{
			$offer_where_clause = array('merchant_id' => $_COOKIE['merchant_id'], 'current_status' => 1);
			$active_offers_count = $this->Admin_model->selectRecords($offer_where_clause, 'product_listing_offer', 'COUNT(offer_id) AS act_ofr_cnt');
			if (isset($active_offers_count['db_error'])) 
				$this->logout();

			$counts['active_offers_count'] = $active_offers_count['result'][0]['act_ofr_cnt'];

			$merchant_review_average_and_count = $this->Admin_model->selectRecords(array('merchant_id' => $_COOKIE['merchant_id']), 'merchant_review', 'COUNT(review_id) AS review_cnt, ROUND(AVG(rating), 0) AS avg_rating');
			if (isset($merchant_review_average_and_count['db_error'])) 
				$this->logout();

			$counts['merchant_review_count'] = $merchant_review_average_and_count['result'][0]['review_cnt'];
			$counts['merchant_review_average'] = $merchant_review_average_and_count['result'][0]['avg_rating'];
		}

		return $counts;
	}

	//load any kind of page
	public function pageLoad($pageName)
	{
		$this->isLoggedIn();

		$controller = 'dashboard';

		$data['status'] = false;
		$data['categories'] = array();
		
		$countries = $this->getCountry();
		if (isset($countries['db_error'])) 
			redirectWithMessage('Error: '.$countries['msg'], $controller);

		$data['countries'] = $countries['result'];

		if ($pageName == "addCategory") 
		{
			$data['status'] = true;
			
			$data['categories'] = $this->getAllCategories();
			if (isset($data['categories']['db_error'])) 
				redirectWithMessage('Error: '.$data['categories']['msg'], $controller);

			$data['attributes'] = $this->getAllAttributes();
			if (isset($data['attributes']['db_error'])) 
				redirectWithMessage('Error: '.$data['attributes']['msg'], $controller);
		}
		elseif ($pageName == "attributes") 
		{
			$data['status'] = false;

			$attributes = $this->getAllAttributes();
			if ( isset($attributes['db_error']) ) 
				redirectWithMessage('Error: '.$attributes['msg'], $controller);

			if ($attributes)
			{
				$data['status'] = true;
				$data['attributes'] = $attributes;
			}
		}
		elseif ($pageName == "countryManagement") 
		{
			if ($countries)
				$data['country'] = $countries;
			else
				$data['country'] = false;
		}
		elseif ($pageName == "productLinkingWithSeller") 
		{
			if ($this->sellers)
			{
				$data['success'] = true;
				$data['sellers'] = $this->sellers;	
			}
			else
				$data['success'] = false;
		}
		elseif ($pageName == "stateManagement") 
		{
			$country_id = isset($_GET['getStateList']) ? $_GET['getStateList'] : "";
			$states = $this->getState('', '', $country_id);
			if (isset($states['db_error'])) 
				redirectWithMessage('Error: '.$states['msg'], $controller);
			else if ($states['result']) 
				$data['states'] = $states['result'];
			else
				$data['states'] = false;

			if (isset($_GET['addNewState'])) 
			{
				if (isset($_GET['state_id']))
				{
					$state = $this->getState($_GET['state_id'], '', '');
					if (isset($state['db_error'])) 
						redirectWithMessage('Error: '.$state['msg'], $controller);
					else if ($state['result']) 
						$data['state'] = $state['result'][0];
					else
						$data['state'] = false;
				}		
			}
		}
		elseif ($pageName == "cityManagement") 
		{
			$data['states'] = false;
			$data['cities'] = false;
			$data['city'] = false;
			$data['selected_country_id'] = "";
			$data['selected_state_id'] = "";
			$state_id = "";
			$cnt_state_values = "";

			if (isset($_GET['getCityList']))
				$cnt_state_values = $_GET['getCityList'];
			else if (isset($_GET['addNewCity']))
				$cnt_state_values = $_GET['addNewCity'];

			if ($cnt_state_values) 
			{
				$cnt_state_id = explode('-', $cnt_state_values);
				$cnt_id = $cnt_state_id[0];
				$state_id = $cnt_state_id[1];

				$data['selected_country_id'] = $cnt_id;
				$data['selected_state_id'] = $state_id;

				$states = $this->getState('', '', $cnt_id);
				if (isset($states['db_error'])) 
					redirectWithMessage('Error: '.$states['msg'], $controller);
				else if ($states['result']) 
					$data['states'] = $states['result'];
			}

			$cities = $this->getcity('', $state_id, '');
			if (isset($cities['db_error'])) 
				redirectWithMessage('Error: '.$cities['msg'], $controller);
			else if ($cities['result']) 
				$data['cities'] = $cities['result'];

			if (isset($_GET['city_id'])) 
			{
				$city = $this->getcity('', '', $_GET['city_id']);	
				if ($city) 
					$data['city'] = $city['result'][0];			
			}
		}
		else if ($pageName == "areaManagement") 
		{
			$data['areas'] = false;
			$data['area']  = false;
			$data['selected_country_id'] = "";
			$data['selected_state_id'] = "";
			$data['selected_city_id'] = "";
			$city_id = "";
			$cnt_state_city_values = "";

			if (isset($_GET['getAreaList']))
				$cnt_state_city_values = $_GET['getAreaList'];
			else if (isset($_GET['addNewArea']))
				$cnt_state_city_values = $_GET['addNewArea'];

			if ($cnt_state_city_values) 
			{
				$cnt_state_city_values = explode('-', $cnt_state_city_values);
				$cnt_id = $cnt_state_city_values[0];
				$state_id = $cnt_state_city_values[1];
				$city_id = $cnt_state_city_values[2];

				$data['selected_country_id'] = $cnt_id;
				$data['selected_state_id'] = $state_id;
				$data['selected_city_id'] = $city_id;

				$states = $this->getState('', '', $cnt_id);
				if (isset($states['db_error'])) 
					redirectWithMessage('Error: '.$states['msg'], $controller);

				$cities = $this->getcity('', $state_id, '');
				if ( isset($cities['db_error']) ) 
					redirectWithMessage('Error: '.$cities['msg'], $controller);

				if ($states['result']) 
					$data['states'] = $states['result'];

				if ($cities['result']) 
					$data['cities'] = $cities['result'];
			}

			//get areas list
			$areas = $this->getArea('', $city_id, '');
			if (isset($areas['db_error'])) 
				redirectWithMessage('Error: '.$areas['msg'], $controller);
			else if ($areas['result'])
				$data['areas'] = $areas['result'];

			if (isset($_GET['area_id'])) 
			{
				$area = $this->getArea($_GET['area_id'], '', '');	
				if ( isset($area['db_error']) ) 
					redirectWithMessage('Error: '.$area['msg'], $controller);
				else if ($area['result']) 
					$data['area'] = $area['result'][0];
			}
		}
		else if ($pageName == "userManagement") 
		{
			$data = array();
			$users = $this->getUser();
			
			if ( isset($users['db_error']) ) 
				redirectWithMessage('Error: '.$users['msg'], $controller);
			else
				$data['users'] = $users;
					
			//GET FITERED USERS
			if (isset($_GET['user_type']))
			{
				$user_type = $_GET['user_type'];
				$i = 0;

				if ($user_type != "ALL") 
				{
					foreach ($data['users'] as $user) 
					{
						$found = false;

						if ( $user_type == "1" || $user_type == "0" ) 
						{
							if ($user['status'] == $user_type) 
								$found = true;
						}
						else
						{
							foreach ($user['roles'] as $role) 
							{
								if ( $role['type_name'] == $user_type ) 
									$found = true;
							}
						}	

						if (!$found) 
							unset($data['users'][$i]);

						$i++;
					}
				}
			}
		}
		else if ($pageName == "offerManagement") 
		{
			if (isset($_COOKIE['merchant_id']))
				$_SESSION['merchant_id'] = $_COOKIE	['merchant_id'];

			$data['merchant_offers'] = $this->getOffer('', $_SESSION['merchant_id']);

			if ( isset($data['merchant_offers']['db_error']) ) 
				redirectWithMessage('Error: '.$availableProducts['msg'], $controller);
		}
		else if ($pageName == "addOffer") 
		{
			if (isset($_SESSION['merchant_id'])) 
				$merchant_id = $_SESSION['merchant_id'];
			else if ( isset($_COOKIE['merchant_id']) ) 
				$merchant_id = $_COOKIE['merchant_id'];

			$availableProducts = $this->Admin_model->getAvailableProductsForOfferlink($merchant_id);

			if ( isset($availableProducts['db_error']) ) 
				redirectWithMessage('Error: '.$availableProducts['msg'], $controller);

			$data['availableProducts'] = $availableProducts;
		}
		else if ($pageName == "merchantReview") 
		{
			$merchantReviews = $this->Admin_model->merchantReviews(array('merchant_review.merchant_id' => $_SESSION['merchant_id']));

			if ( isset($merchantReviews['db_error']) ) 
				redirectWithMessage('Error: '.$merchantReviews['msg'], $controller);

			$data['merchant_review'] = $merchantReviews['result'];

			$rating_info = $this->Admin_model->selectRecords(array('merchant_id' => $_SESSION['merchant_id']), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");

			if (isset($rating_info['db_error'])) 
				redirectWithMessage('Error: '.$rating_info['msg'], $controller);

			$data['rating_info'] = $rating_info['result'][0];
		}
		else if ($pageName == "requestProduct") 
		{
			$products = $this->Admin_model->selectRecords('', 'product', 'product_name as label, product_id as id');

			if (isset($products['db_error'])) 
				redirectWithMessage('Error: '.$products['msg'], $controller);

			$data['products'] = $products['result'];
		}
		else if ($pageName == "requestedProducts") 
		{
			$req_prds = $this->Admin_model->selectRecords(array('status' => 'PENDING'), 'requested_product', '*');

			if (isset($req_prds['db_error'])) 
				redirectWithMessage('Error: '.$req_prds['msg'], $controller);

			$data['req_prds'] = $req_prds['result'];
		}
		else if ($pageName == "merchantRequestedProducts") 
		{
			$products = $this->Admin_model->getProductsForLinking($_SESSION['merchant_id']);

			if (isset($products['db_error'])) 
				redirectWithMessage('Error: '.$products['msg'], $controller);
			
			$data['products'] = $products;

			$req_prds = $this->Admin_model->getRequestedProduct(array('requested_product.merchant_id' => $_SESSION['merchant_id']));
			if (isset($req_prds['db_error'])) 
				redirectWithMessage('Error: '.$req_prds['msg'], $controller);

			$data['req_products'] = $req_prds;
		}
		else if ($pageName == "addressManagement") 
		{
			$data['address'] = array();
			$data['page_label'] = 'view';
			$merchant_id = $_GET['merchant_id'];
			$user_id = $_GET['user_id'];

			//get merchant logo and name
			$data['merchant'] = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', "IF(merchant_logo, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', merchant_logo), '') as merchant_logo, establishment_name");
			if (isset($data['merchant']['db_error'])) 
				redirectWithMessage('Error: '.$data['merchant']['msg'], $controller);

			if (isset($_GET['user_id']) && isset($_GET['merchant_id']) && isset($_GET['state_id']))
			{
				$state_id = $_GET['state_id'];
				$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';

				//get all states
				$states = $this->Admin_model->selectRecords('', 'state', '*');
				if (isset($states['db_error'])) 
					redirectWithMessage('Error: '.$states['msg'], $controller);
				$data['states'] = $states['result'];

				//get user address
				$where = array();
				$where['address.userId'] = $user_id;
				$where['address.state_id'] = $state_id;
				if ($city_id) 
					$where['address.city_id'] = $city_id;

				$address_res = $this->getUserAddress($where);
				if (isset($address_res['db_error'])) 
					redirectWithMessage('Error: '.$address_res['msg'], $controller);
				else if ($address_res) 
					$data['address'] = $address_res['result'];
			}
			else
			{
				//get user address
				$address_res = $this->getUserAddress(array('address.userId' => $_GET['user_id']));
				if (isset($address_res['db_error'])) 
					redirectWithMessage('Error: '.$address_res['msg'], $controller);
				else if ($address_res) 
				{
					$data['address'] = $address_res['result'];

					$states = $this->Admin_model->selectRecords('', 'state', '*');
					if (isset($states['db_error'])) 
						redirectWithMessage('Error: '.$states['msg'], $controller);

					$data['states'] = $states['result'];
				}
			}
		}
		else if ($pageName == "addAddress") 
		{
			$data = array();
			
			//get address detail
			if (isset($_GET['address_id'])) 
			{
				$address_res = $this->getUserAddress(array('address_id' => $_GET['address_id']));
				if (isset($address_res['db_error'])) 
					redirectWithMessage('Error: '.$address_res['msg'], $controller);
				else if ($address_res) 
					$data = $address_res['result'][0];

				$data['page_label'] = 'edit';
			}
			else
				$data['page_label'] = 'add';

			//get countries
			$data['countries'] = $this->getCountry();
			if (isset($data['countries']['db_error'])) 
				redirectWithMessage('Error: '.$data['countries']['msg'], $controller);
		}
		else if ($pageName == "default_values") 
		{
			$data = array();
			if (isset($_SESSION['merchant_id'])) 
			{
				$data = $this->Admin_model->selectRecords(array('merchant_id' => $_SESSION['merchant_id']), 'merchant', 'finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, replacement_available, replacement_terms, return_available, return_policy, seller_offering');
				if (isset($default_values['db_error'])) 
					redirectWithMessage('Error: '.$default_values['msg'], 'dashboard');
			}
			
			$pageName = 'seller_default_values';
		}
		else if ($pageName == "siteSettings")
			$data['site_settings'] = $this->site_settings();
		else if ($pageName == "claimedRequest")
			$data['claimedRequests'] = $this->Admin_model->claimedRequest();

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/'.$pageName, $data);
		$this->load->view('admin/include/footer');
		die;
	}

	public function viewRequest($req_id)
	{
		$data = array();
		$res = $this->Admin_model->claimedRequest($req_id);
		$data['data'] = $res[0];

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/viewRequest', $data);
		$this->load->view('admin/include/footer');
	}

	public function addOffer()
	{
		if (isset($_SESSION['merchant_id']))
			$merchant_id = $_SESSION['merchant_id'];
		else if (isset($_COOKIE['merchant_id'])) 
			$merchant_id = $_COOKIE['merchant_id'];
		else
			$merchant_id = $this->input->post('merchant_id');

		if ($_COOKIE['site_code'] == 'admin') 
			$controller = 'sellers/offers';
		else if ($_COOKIE['site_code'] == 'seller') 
			$controller = 'page/offerManagement';

		if ($merchant_id)
		{
			$data = array();
			$offer_id = $this->input->post('offer_id');
			$data['offer_title'] = $this->input->post('offer_title');
			$data['description'] = $this->input->post('offer_desc');
			$data['start_date'] = $this->input->post('offer_startDate');
			$data['end_date'] = $this->input->post('offer_endDate');
			$data['current_status'] = $this->input->post('offer_status');
			$data['merchant_id'] = $merchant_id;
			$data['update_date'] = $this->current_date;
			
			if ($offer_id) 
			{
				$condition = array('offer_id' => $offer_id);
				$isUpdated = $this->Admin_model->updateData('product_listing_offer', $data, $condition);

				$msg = "Offer updated successfully!!";
				
				if (isset($isUpdated['db_error'])) 
					redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
			}
			else
			{
				$data['create_date'] = $this->current_date;

				$offer_id = $this->Admin_model->insertData('product_listing_offer', $data);
				if (isset($offer_id['db_error'])) 
					redirectWithMessage('Error: '.$offer_id['msg'], $controller);

				if ($offer_id)
					$msg = "Offer inserted successfully!!";
				else
					$msg = "Error: Unable to insert offer!";
			}

			//offer folder path
			$folder = OFFER_ATTATCHMENTS_PATH.$offer_id;

			//atatchment data
			$img_data['link_id'] = $offer_id;
			$img_data['atch_type'] = "IMAGE";
			$img_data['atch_for'] = "OFFER";

			//insert offer images
			$isUploaded = $this->upload_image( $folder, $img_data );
			if (isset($isUploaded['db_error'])) 
				redirectWithMessage('Error: '.$isUploaded['msg'], $controller);
			
			$lst_ids = ($this->input->post('selected_prd_lst_ids')) ? $this->input->post('selected_prd_lst_ids') : array();

			$db_ofr_mp_prd = $this->Admin_model->selectRecords(array('ofr_id' => $offer_id), 'offer_listing_mp', '*');
			if (isset($db_ofr_mp_prd['db_error'])) 
				redirectWithMessage('Error: '.$db_ofr_mp_prd['msg'], $controller);

			$db_lst_ids = array();
			if ($db_ofr_mp_prd['result'])
			{
				foreach ($db_ofr_mp_prd['result'] as $mp_value) 
					array_push($db_lst_ids, $mp_value['lst_id']);
			}

			$delete_prd = array_diff($db_lst_ids, $lst_ids);
			$insert_prd = array_diff($lst_ids, $db_lst_ids);

			//delete user roles
			foreach ($delete_prd as $del_prd) 
			{
				$where = array('ofr_id' => $offer_id, 'lst_id' => $del_prd);
				$isDeleted = $this->Admin_model->deleteRecord('offer_listing_mp', $where);

				if ( isset($isDeleted['db_error']) ) 
					redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			}

			//insert listing mapping
			foreach ($insert_prd as $ins_prd) 
			{ 
				$prd_data = array('ofr_id' => $offer_id, 'lst_id' => $ins_prd);
				$map_id = $this->Admin_model->insertData('offer_listing_mp', $prd_data);

				if ( isset($map_id['db_error']) ) 
					redirectWithMessage('Error: '.$map_id['msg'], $controller);
			}

			$isAddedHTMLFile = $this->addHTMLFiles( $offer_id, 'OFFER' );

			if (!$isAddedHTMLFile) 
				$msg = 'Error: unable to perform action for HTML Files!';
		}
		else
		{
			$msg = 'Error: Merchant id not found';
			$controller = 'dashboard';
		}

		$this->updateTableDate('merchant', array('merchant_id' => $merchant_id));
		redirectWithMessage($msg, $controller);
	}

	public function getOffer($offer_id="", $merchant_id='')
	{
		$this->isLoggedIn();
		
		$seller_offer = $this->Admin_model->getSellerOffers($offer_id, $merchant_id);

		return $seller_offer;
	}

	public function deleteAddress($address_id, $user_id, $merchant_id)
	{
		if ($address_id && $user_id) 
		{
			$isDeleted = $this->Admin_model->deleteRecord('address', array('address_id' => $address_id));

			$msg = 'Address deleted successfully!!!';
			$controller = 'page/addressManagement?user_id='.$user_id.'&merchant_id='.$merchant_id;

			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			else 
			{
				$isDeleted = $this->saveDeleteItem($address_id, 'ADDRESS');
				if (isset($isDeleted['db_error'])) 
					redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			}
		}
		else
		{
			$msg = 'Error: user id and address is required!';
			$controller = 'dashboard';
		}

		redirectWithMessage($msg, $controller);
	}

	public function editOffer($offer_id, $type_name)
	{
		$controller = 'sellers/offers';

		$offer_detail = array();
		$offers = $this->Admin_model->selectRecords(array('offer_id' => $offer_id), 'product_listing_offer', '*');

		if ( isset($offers['db_error']) ) 
			redirectWithMessage('Error: '.$offers['msg'], $controller);

		$offer_detail = $offers['result'][0];
		$offer_detail['atch_path'] = $this->config->item('site_url').OFFER_ATTATCHMENTS_PATH;
		$attatchments = $this->Admin_model->selectRecords(array('link_id' => $offer_id, 'atch_for' => 'OFFER', 'atch_type' => 'IMAGE'), 'attatchments', '*');

		if (isset($attatchments['db_error'])) 
			redirectWithMessage('Error: '.$attatchments['msg'], $controller);

		$offer_detail['attatchments'] = $attatchments['result'];
		$offer_detail['linked_products'] = $this->Admin_model->getLinkedproductsToOffer($offer_id, $offer_detail['merchant_id']);

		if (isset($offer_detail['db_error'])) 
			redirectWithMessage('Error: '.$offer_detail['msg'], $controller);

		//get brand html files
		$offer_detail['html_files'] = $this->Admin_model->selectRecords(array('link_id' => $offer_id, 'linked_type' => 'OFFER'), 'html_files', 'html_file, html_file_id');

		if (isset($offer_detail['db_error'])) 
			redirectWithMessage('Error: '.$offer_detail['msg'], $controller);

		$offer_detail['page_label'] = $type_name;

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/addOffer', $offer_detail);
		$this->load->view('admin/include/footer');
		die;
	}

	public function editUser($usr_id)
	{
		$user = $this->getUser($usr_id);
		$controller = 'page/userManagement';

		if (isset($user['db_error'])) 
			redirectWithMessage('Error: '.$user['msg'], $controller);

		if ($_COOKIE['site_code'] == 'seller') 
		{
			$sel_id = $_COOKIE['merchant_id'];
			$seller_data['merchant'] = array();
			$sel_res = $this->Admin_model->sellers($sel_id);
			
			if (isset($sel_res['db_error'])) 
				redirectWithMessage('Error: '.$sel_res['msg'], $controller);

			if ($sel_res)
			{
				$seller_data['merchant'] = $sel_res[0];	
				$seller_data['merchant']['address'] = array();
				$seller_data['merchant']['seller_images_dir'] = $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$sel_id;

				//get user address
				$address_res = $this->getUserAddress(array('address.userId' => $sel_res[0]['userId']));
				if (isset($address_res['db_error'])) 
					redirectWithMessage('Error: '.$address_res['msg'], $controller);
				else if ($address_res) 
					$seller_data['merchant']['address'] = $address_res['result'];
				
				//get product images
				$seller_imgs = $this->attatchments($sel_id, "SELLER");
				if ($seller_imgs) 
					$seller_data['merchant']['images'] = $seller_imgs;
				else
					$seller_data['merchant']['images'] = false;

				//get countries
				$countries = $this->getCountry();
				if (isset($countries['db_error'])) 
					redirectWithMessage('Error: '.$countries['msg'], $controller);
				else if ($countries['result'])
					$seller_data['countries'] = $countries['result'];
				else
					$seller_data['countries'] = false;

				//get seller offerings
				$seller_offering = $this->Admin_model->selectRecords(array('merchant_id' => $sel_id), 'merchant_offering', 'offering_id, offering');
				if (isset($seller_offering['db_error'])) 
					redirectWithMessage('Error: '.$seller_offering['msg'], $controller);
				if ($seller_offering) 
					$seller_data['merchant']['seller_offering'] = $seller_offering['result'];
				else
					$seller_data['merchant']['seller_offering'] = false;
			}
		}

		$seller_data['user'] = $user[0];
		
		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/addUser', $seller_data);
		$this->load->view('admin/include/footer');
		die;
	}

	public function editRequestedProduct($req_id = '')
	{
		if ($req_id) 
		{
			$req_prd = $this->Admin_model->selectRecords(array('request_id' => $req_id), 'requested_product', '*');
			
			if (isset($req_prd['db_error'])) 
				redirectWithMessage('Error: '.$req_prd['msg'], 'page/merchantRequestedProducts');

			if ($req_prd)
			{
				$data = $req_prd['result'][0];			

				$this->load->view('admin/include/header');
				$this->load->view('admin/include/leftbar');
				$this->load->view('admin/requestProduct', $data);
				$this->load->view('admin/include/footer');
				die;
			}
		}

		redirectWithMessage('Error: Unable to get request product!', 'page/merchantRequestedProducts');
	}

	public function editReview($review_id = '', $review_for = '')
	{
		if ($review_id && $review_for) 
		{
			if ($review_for == 'merchant') 
				$reviews = $this->Admin_model->merchantReviews(array('review_id' => $review_id));
			else
				$reviews = $this->Admin_model->productReviews(array('review_id' => $review_id));

			$controller = 'editReview/'.$review_id.'/'.$review_for;
			if (isset($reviews['db_error'])) 
				redirectWithMessage('Error: '.$reviews['msg'], $controller);
			if ($reviews) 
			{
				$data['page_type'] = 'edit';
				$data['review_data'] = $reviews['result'][0];
				$data['page_label'] = $review_for;
				
				$this->load->view('admin/include/header');
				$this->load->view('admin/include/leftbar');
				$this->load->view('admin/addReview', $data);
				$this->load->view('admin/include/footer');
				die;
			}
			else
				$msg = 'Error: could not found review!';
		}
		else
			$msg = 'Error: Review id could not found!';

		redirectWithMessage($msg, 'review/merchant');
	}

	public function addReview()
    {
    	$review_data = array();
    	$review_result = array();

    	$review_id = $this->input->post('review_id');
    	$review_for = $this->input->post('review_for');

    	$review_data['rating'] = $this->input->post('rating');
     	$review_data['review'] = $this->input->post('review');
     	$review_data['review_title'] = $this->input->post('review_title');
     	$review_data['update_date'] = $this->current_date;
     	$controller = 'review/'.$review_for;
     	
     	if ($review_id && $review_for) 
     	{
     		if ($review_for == 'merchant') 
     			$tbl_name = 'merchant_review';
     		else
     			$tbl_name = 'product_review';

     		$condition = array('review_id' => $review_id);
			$isUpdated = $this->Admin_model->updateData($tbl_name, $review_data, $condition);

			if (isset($isUpdated['db_error'])) 
				$msg = 'Error: '.$isUpdated['msg'];
			else
				$msg = 'Review updated!';
     	}
     	else
     		$msg = 'ERROR: review id and label is required';

     	redirectWithMessage($msg, $controller);
	}

	public function getUser($usr_id = "", $status = "")
	{
		$this->isLoggedIn();

		$users = $this->Admin_model->getUser($usr_id, $status);

		if ( isset($users['db_error']) ) 
			return $users;

		$users = json_decode(json_encode($users), true);

		if ($users) 
		{	
			$i=0;
			foreach ($users as $user) 
			{
				$roles = $this->Admin_model->getUserRoles($user['userId']);

				if ( isset($roles['db_error']) ) 
					return $roles;

				$users[$i]['roles'] = $roles;

				$i++;
			}
		}
		else
			return FALSE;

		return $users;
	}

	public function addUser()
	{
		$this->isLoggedIn();

		$data = array();
		$usr_id = $this->input->post('usr_id');
		$clmd_id = $this->input->post('claimed_id');
		$data['first_name'] = $this->input->post('fname');
		$data['middle_name'] = ($this->input->post('mname')) ? $this->input->post('mname') : "";
		$data['last_name'] = ($this->input->post('lname')) ? $this->input->post('lname') : "";
		$data['update_date'] = $this->current_date;
		$data['status'] = 1;
		$controller = 'page/userManagement';

		if ($usr_id) //update user profile
		{
			$condition = array('userId' => $usr_id);
			$isUpdated = $this->Admin_model->updateData('user', $data, $condition);
			if (isset($isUpdated['db_error'])) 
				$msg = 'Error: '.$isUpdated['msg'];
			else
				$msg = "User updated successfully!!";
		}
		else //insert user profile
		{
			$review_data['create_date'] = $this->current_date;
			$data['email'] = $this->input->post('email');
			$isFound = $this->Admin_model->selectRecords(array('email' => $data['email']), 'user', 'userId');
			if (isset($isFound['db_error'])) 
				redirectWithMessage('Error: '.$isFound['msg'], $controller);

			//check email is already exist or not
			if (!$isFound) 
			{
				if ($clmd_id)
					$data['password'] = DEFAULT_PASSWORD;

				$usr_id = $this->Admin_model->insertData('user', $data);
				if (isset($usr_id['db_error'])) 
					redirectWithMessage('Error: '.$usr_id['msg'], $controller);
				else if ($usr_id)
					$msg = "User inserted successfully!!";
				else
					$msg = "Error: Unable to insert user!";
			}
			else
				$msg = "Error: Email already exist!";
		}

		if ($usr_id)
		{
			//insert user profile picture
			if (isset($_FILES['file7']['name']) && $_FILES['file7']['name'] != '')
			{
				$profile_pic = $this->single_upload(PROFILE_PIC_PATH, '', 'file7');
				if (!$profile_pic)
					$msg = "Error: Unable to upload profile picture!";
				else
				{
					$where = array('userId' => $usr_id);
					$user_profile_image = $this->Admin_model->selectRecords($where, 'user', 'picture');
					if (isset($user_profile_image['db_error'])) 
						redirectWithMessage('Error: '.$user_profile_image['msg'], $controller);

					if ($user_profile_image) 
					{
						//update user row with profile image
						$isUpdated = $this->Admin_model->updateData('user', array('picture' => $profile_pic, 'update_date' => $this->current_date), $where);
						if (isset($isUpdated['db_error'])) 
							redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

						//remove old pic from profile_pic folder
						$picture = $user_profile_image['result'][0]['picture'];
						if (is_file(PROFILE_PIC_PATH.$picture))
							unlink(PROFILE_PIC_PATH.$picture);
					}
				}
			}

			if ($_COOKIE['site_code'] == 'admin') 
			{
				//insert or delete user roles
				$user_type = ($this->input->post('user_type')) ? $this->input->post('user_type') : array();

				$usr_roles = $this->Admin_model->getUserRoles($usr_id);
				if (isset($usr_roles['db_error'])) 
					redirectWithMessage('Error: '.$usr_roles['msg'], $controller);

				$db_usr_roles = array();
				if ($usr_roles) 
				{
					foreach ($usr_roles as $usr_role) 
						array_push($db_usr_roles, $usr_role['type_name']);
				}

				$delete_roles = array_diff($db_usr_roles, $user_type);
				$insert_roles = array_diff($user_type, $db_usr_roles);

				//delete user roles
				foreach ($delete_roles as $del_role) 
				{
					$where = array('usr_id' => $usr_id, 'type_name' => $del_role);
					$isDeleted = $this->Admin_model->deleteRecord('user_type', $where);

					if (isset($isDeleted['db_error'])) 
						redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
				}

				//insert user roles
				foreach ($insert_roles as $ins_role) 
				{ 
					$role_data = array('usr_id' => $usr_id, 'type_name' => $ins_role);
					$rol_id = $this->Admin_model->insertData('user_type', $role_data);

					if (isset($rol_id['db_error'])) 
						redirectWithMessage('Error: '.$rol_id['msg'], $controller);

					//insert user id in consumer table
					if ($rol_id && $ins_role == "BUYER") 
					{
						$isExistConsumer = $this->Admin_model->selectRecords(array('userId' => $usr_id), 'consumer', 'consumer_id');
						if (isset($isExistConsumer['db_error'])) 
							redirectWithMessage('Error: '.$isExistConsumer['msg'], $controller);

						if (!$isExistConsumer) 
						{
							$isInserted = $this->Admin_model->insertData('consumer', array('userId' => $usr_id));
							if (isset($isInserted['db_error'])) 
								redirectWithMessage('Error: '.$isInserted['msg'], $controller);
						}
					}

					//insert saller detail in consumer table
					if ($rol_id && $ins_role == "SELLER") 
					{
						$isExistSeller = $this->Admin_model->selectRecords(array('userId' => $usr_id), 'merchant', 'merchant_id');
						if (isset($isExistSeller['db_error'])) 
							redirectWithMessage('Error: '.$isExistSeller['msg'], $controller);

						if (!$isExistSeller) 
						{
							if ($clmd_id) 
								return $usr_id;
							
							$isInserted = $this->Admin_model->insertData('merchant', array('userId' => $usr_id));
							if (isset($isInserted['db_error'])) 
								redirectWithMessage('Error: '.$isInserted['msg'], $controller);
						}
					}

					//set default password 123456 for executive/admin
					if ($rol_id && ($ins_role == "EXECUTIVE" || $ins_role == "ADMIN")) 
					{
						$condition = array('userId' => $usr_id);
						$isExistUser = $this->Admin_model->selectRecords($condition, 'user', 'password');
						if (isset($isExistUser['db_error'])) 
							redirectWithMessage('Error: '.$isExistUser['msg'], $controller);
						else if ($isExistUser) 
						{
							$data = array();
							$data['update_date'] = $this->current_date;
							if (!$isExistUser['result'][0]['password']) 
								$data['password'] = DEFAULT_PASSWORD;

							$isUpdated = $this->Admin_model->updateData('user', $data, $condition);
							if (isset($isUpdated['db_error'])) 
								redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
						}
						else
							redirectWithMessage('Error: could not found user as '.$ins_role, $controller);	
					}
				}
			}			
		}

		if ($_COOKIE['user_id'] == $usr_id) 
	    {
	    	$usr_details = $this->Admin_model->getUser($usr_id, 1);
	    	if (isset($usr_details['db_error'])) 
				redirectWithMessage('Error: '.$usr_details['msg'], $controller);

			$name = $usr_details[0]['first_name']." ".$usr_details[0]['middle_name']." ".$usr_details[0]['last_name'];
			setcookie('name', $name, null, "/");
			setcookie('image', $usr_details[0]['profile_image'], null, "/");
	    }
	    
	    if ($_COOKIE['site_code'] == 'seller') 
	    	$this->addSeller();

	    $this->updateTableDate('user', array('userId' => $usr_id));
	    redirectWithMessage($msg, $controller);
	}

	public function addSeller()
	{
		$merchant_id = $this->input->post('merchant_id');
		$usr_id = $this->input->post('usr_id');
		
		//user data
		$usr_data['first_name'] = $this->input->post('fname');
		$usr_data['middle_name'] = $this->input->post('mname');
		$usr_data['last_name'] = $this->input->post('lname');
		$usr_data['update_date'] = $this->current_date;

		//merchant data
		$mrchnt_data['establishment_name'] = $this->input->post('comp_name');
		$mrchnt_data['meta_keyword'] = $this->input->post('meta_keyword');
		$mrchnt_data['meta_description'] = $this->input->post('meta_description');
		$mrchnt_data['description'] = $this->input->post('description');
		$mrchnt_data['contact'] = $this->input->post('contact_no');
		$mrchnt_data['is_verified'] = 0;
		$mrchnt_data['business_days'] = $this->input->post('business_days');
		$mrchnt_data['business_hours'] = $this->input->post('business_hours');
		$mrchnt_data['update_date'] = $this->current_date;

		$email = $this->input->post('email');
		$password = $this->input->post('psw');
		$cpassword = $this->input->post('cpsw');
		$seller_offering = $this->input->post('seller_offering_values');

		if ($_COOKIE['site_code'] == 'admin') 
			$controller = 'sellers/sellersTable';
		else
			$controller = 'merchant/signup';
		
		if (!$usr_id && $email) 
		{			
			if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $mrchnt_data['contact']))
            	redirectWithMessage('Error: contact number should be in correct format', $controller);

			//match password and confirm password
			if ($cpassword && $password != $cpassword) 
			{
				$msg = "Error: Password and confirm password does not match!";
				redirectWithMessage($msg, $controller);
			}

			//check email is already exist or not
			$isFound = $this->Admin_model->selectRecords(array('email' => $email), 'user', 'userId');
			if (isset($isFound['db_error'])) 
				redirectWithMessage('Error: '.$isFound['msg'], $controller);
			else if (!$isFound) //insert new user
			{
				$usr_data['email'] = $email;
				$usr_data['status'] = 1;
				$usr_data['password'] = $password;
				$usr_data['create_date'] = $this->current_date;
			}
			else //update user detail
			{
				//Add new merchant if we have already a exist user email and password
				$usr_id = $isFound['result'][0]['userId'];
				$condition = array('userId' => $usr_id);
				$isUpdated = $this->Admin_model->updateData('user', $usr_data, $condition);
				if (isset($isUpdated['db_error'])) 
					redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

				//add user type
				$usr_type_data['usr_id'] = $usr_id;
				$usr_type_data['type_name'] = "SELLER";
				$isInserted = $this->Admin_model->insertData('user_type', $usr_type_data);
				if (isset($isInserted['db_error'])) 
					redirectWithMessage('Error: '.$isInserted['msg'], $controller);

				//add merchant detail
				$mrchnt_data['userId'] = $usr_id;
				$mrchnt_data['create_date'] = $this->current_date;
				$merchant = $this->Admin_model->insertData('merchant', $mrchnt_data);
				if (isset($merchant['db_error'])) 
					redirectWithMessage('Error: '.$merchant['msg'], $controller);

				$address_id = $this->insertAddress($usr_id, 1);
				if (!$address_id) 
					$msg = "Error: lat, long are not in correct format.";
				else
					$msg = 'Merchant added successfully!!!';

				$controller = 'login';
			}

			$mrchnt_data['is_verified'] = 1;
		}

		if (!$usr_id) 
		{
			//insert new user
			$usr_id = $this->Admin_model->insertData('user', $usr_data);
			if (isset($usr_id['db_error'])) 
				redirectWithMessage('Error: '.$usr_id['msg'], $controller);

			//add user type
			$usr_type_data['usr_id'] = $usr_id;
			$usr_type_data['type_name'] = "SELLER";
			$isInserted = $this->Admin_model->insertData('user_type', $usr_type_data);
			if (isset($isInserted['db_error'])) 
				redirectWithMessage('Error: '.$isInserted['msg'], $controller);

			//add merchant detail
			$mrchnt_data['userId'] = $usr_id;
			$mrchnt_data['create_date'] = $this->current_date;
			$merchant_id = $this->Admin_model->insertData('merchant', $mrchnt_data);
			if (isset($merchant_id['db_error'])) 
				redirectWithMessage('Error: '.$merchant_id['msg'], $controller);

			$address_id = $this->insertAddress($usr_id, 1);
			if (!$address_id) 
				$msg = "Error: lat, long are not in correct format.";
			else
				$msg = 'Merchant added successfully!!!';
		}
		else if($usr_id && $merchant_id)
		{
			$msg = 'Merchat detail update successfully!!!!';

			if ($_COOKIE['site_code'] == 'seller') 
				$controller = 'editUser/'.$usr_id.'?edit';

			//update user detail
			$condition = array('userId' => $usr_id);
			$isUpdated = $this->Admin_model->updateData('user', $usr_data, $condition);
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

			//update merchant detail
			$condition = array('merchant_id' => $merchant_id);
			$isUpdated = $this->Admin_model->updateData('merchant', $mrchnt_data, $condition);
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		}

		if ($usr_id && $merchant_id) 
		{	
			//get merchant logo and business proof
			$merchant_data = array();
			$where = array('merchant_id' => $merchant_id);
			$merchant = $this->Admin_model->selectRecords($where, 'merchant', 'merchant_logo, business_proof');
			if (isset($merchant['db_error'])) 
				redirectWithMessage('Error: '.$merchant['msg'], $controller);

			//merchant attachments path
			$folder = SELLER_ATTATCHMENTS_PATH.$merchant_id;
			
			//insert seller logo
			if (isset($_FILES['file8']) && $_FILES['file8']['name'] != '')
			{
				$merchant_logo_name = $this->single_upload($folder, '', 'file8');
				if (!$merchant_logo_name)
					$msg = "Error: Unable to upload merchant logo!";
				else if (isset($merchant['result'][0]['merchant_logo']))
				{
					$merchant_data['merchant_logo'] = $merchant_logo_name;

					//remove old pic from seller folder
					$picture = $merchant['result'][0]['merchant_logo'];
					if (is_file(SELLER_ATTATCHMENTS_PATH.$picture))
						unlink(SELLER_ATTATCHMENTS_PATH.$picture);
				}
			}

			//insert seller business proof
			if (isset($_FILES['file9']) && $_FILES['file9']['name'] != '')
			{
				$merchant_business_proof = $this->single_upload($folder, '', 'file9');
				if (!$merchant_business_proof)
					$msg = "Error: Unable to upload merchant business proof!";
				else if (isset($merchant['result'][0]['business_proof']))
				{
					$merchant_data['business_proof'] = $merchant_business_proof;

					//remove old business from from seller folder
					$picture = $merchant['result'][0]['business_proof'];
					if (is_file(SELLER_ATTATCHMENTS_PATH.$picture))
						unlink(SELLER_ATTATCHMENTS_PATH.$picture);
				}
			}

			$merchant_data['update_date'] = $this->current_date;

			//update merchant row
			$isUpdated = $this->Admin_model->updateData('merchant', $merchant_data, $where);
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

			//atatchment data
			$img_data['link_id'] = $merchant_id;
			$img_data['atch_type'] = "IMAGE";
			$img_data['atch_for'] = "SELLER";

			//insert seller images
			$isUploaded = $this->upload_seller_image($folder, $img_data);
			if (!$isUploaded) 
				redirectWithMessage('Error: unable to upload image', $controller);

			//insert product key features
			if ($seller_offering) 
			{
				$seller_offering_data = array();
				$seller_offering_data['merchant_id'] = $merchant_id;

				foreach ($seller_offering as $seller_offering_value)
				{
					$seller_offering_data['offering'] = $seller_offering_value;
					$seller_offering_id = $this->Admin_model->insertData('merchant_offering', $seller_offering_data);

					if (isset($seller_offering_id['db_error'])) 
						redirectWithMessage('Error: '.$seller_offering_id['msg'], $controller);
					else if (!$seller_offering_id)
						redirectWithMessage('Error: Unable to insert seller offering!', $controller);
				}
			}

			//update seller default values
			$default_values = array();
			$default_values['finance_available'] = $this->input->post('finance_available');
			$default_values['finance_terms'] = $this->input->post('finance_terms');
			$default_values['home_delivery_available'] = $this->input->post('home_delievery');
			$default_values['home_delivery_terms'] = $this->input->post('delievery_terms');
			$default_values['installation_available'] = $this->input->post('installation_available');
			$default_values['installation_terms'] = $this->input->post('installation_terms');
			$default_values['replacement_available'] = $this->input->post('replacement_available');
			$default_values['replacement_terms'] = $this->input->post('replacement_terms');
			$default_values['return_available'] = $this->input->post('return_available');
			$default_values['return_policy'] = $this->input->post('return_policy');
			$default_values['seller_offering'] = $this->input->post('seller_offering');
			$default_values['update_date'] = $this->current_date;

			$this->Admin_model->updateData('merchant', $default_values, array('merchant_id' => $merchant_id));
		}

		$this->updateTableDate('merchant', array('merchant_id' => $merchant_id));
		redirectWithMessage($msg, $controller);
	}

	public function deleteUser($usr_id)
	{
		$controller = 'page/userManagement';

		$isDeleted = $this->Admin_model->deleteRecord('user', array('userId' => $usr_id));
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

		if (is_file(PROFILE_PIC_PATH.$usr_id.'.png'))
			unlink(PROFILE_PIC_PATH.$usr_id.'.png');

		redirectWithMessage('User deleted successfully!!!', $controller);
	}

	public function addRequestedProduct()
	{
		$this->isLoggedIn();

		$req_prd_data = array();
		$request_id = $this->input->post('request_id');
		$product_name = $this->input->post('prd_name');
		$req_prd_data['product_name'] = $product_name;
		$req_prd_data['brand_name'] = $this->input->post('brand_name');
		$req_prd_data['description'] = $this->input->post('prd_desc');
		$req_prd_data['amazon_link'] = $this->input->post('amazon_link');
		$req_prd_data['flipkart_link'] = $this->input->post('flipkart_link');
		$req_prd_data['paytm_link'] = $this->input->post('paytm_link');
		$req_prd_data['other_link1'] = $this->input->post('other_link1');
		$req_prd_data['other_link2'] = $this->input->post('other_link2');
		$req_prd_data['update_date'] = $this->current_date;
		$req_prd_data['merchant_id'] = $_COOKIE['merchant_id'];
		
		$controller = 'page/merchantRequestedProducts';

		if ($product_name && $req_prd_data['brand_name'] && $req_prd_data['merchant_id'])
		{
			if (!$req_prd_data['amazon_link'] && !$req_prd_data['flipkart_link'] && !$req_prd_data['paytm_link'] && !$req_prd_data['other_link1'] && !$req_prd_data['other_link2']) 
				$msg = 'Error: please set atleast one referance link!';
			else
			{
				//check product name is already exist in requested product or product table
				$isExistProduct = $this->Admin_model->checkRequestedProductExistance($product_name);
				if (isset($isExistConsumer['db_error'])) 
					redirectWithMessage('Error: '.$isExistConsumer['msg'], $controller);
				else if ($isExistProduct) 
					redirectWithMessage('Error: this product is already exist', $controller);
				else if ($request_id) 
				{
					$condition = array('request_id' => $request_id);
					$isUpdated = $this->Admin_model->updateData('requested_product', $req_prd_data, $condition);

					if (isset($isUpdated['db_error'])) 
						redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

					$msg = "Requested product updated successfully!!";
				}
				else
				{
					$req_prd_data['create_date'] = $this->current_date;

					$req_prd_id = $this->Admin_model->insertData('requested_product', $req_prd_data);

					if (isset($req_prd_id['db_error'])) 
						redirectWithMessage('Error: '.$req_prd_id['msg'], $controller);
					else if ($req_prd_id)
						$msg = "Requested product inserted successfully!!";
					else
						$msg = "Error: Unable to insert requested product!";
				}
			}
		}
		else
			$msg = "Error: Product name, brand name, merchant id are required!";
		
		redirectWithMessage($msg, $controller);
	}

	public function addArea()
	{
		$this->isLoggedIn();

		$data = array();
		$area_id  = $this->input->post('area_id');
		$cnt_id = $this->input->post('cnt_id');
		$state_id = $this->input->post('state_id');
		$city_id = $this->input->post('city_id');

		$data['city_id'] = $city_id;
		$data['area_name'] = $this->input->post('area_name');
		$data['latitude'] = $this->input->post('lat');
		$data['longitude'] = $this->input->post('long');
		$data['status'] = $this->input->post('status');
		$data['update_date'] = $this->current_date;
		$controller = 'page/areaManagement?getAreaList='.$cnt_id."-".$state_id."-".$city_id.'&area_id='.$area_id;

		if (!empty($city_id))
		{
			if (!empty($area_id)) 
			{
				$condition = array('area_id' => $area_id);
				$isUpdated = $this->Admin_model->updateData('area', $data, $condition);

				$msg = "Area updated successfully!!";
				
				if (isset($isUpdated['db_error'])) 
					redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
			}
			else
			{
				$data['create_date'] = $this->current_date;
				$area_id = $this->Admin_model->insertData('area', $data);

				if ($area_id)
					$msg = "Area inserted successfully!!";
				else
					$msg = "Error: Unable to insert area!";

				if ( isset($area_id['db_error']) ) 
					redirectWithMessage('Error: '.$area_id['msg'], $controller);
			}
		}
		else
		{
			$msg = "Error: Area id not found!!";
			$controller = 'page/areaManagement';
		}

		redirectWithMessage($msg, $controller);
	}

	public function getArea($area_id='', $city_id='', $status='')
	{
		$this->isLoggedIn();
		$where = array();

		if ($area_id)
			$where['area_id'] = $area_id;

		if ($city_id)
			$where['city_id'] = $city_id;

		if (!empty($status))
			$where['status'] = $status;

		return $this->Admin_model->selectRecords($where, 'area', '*', array('area_name' => 'ASC'));
	}

	//get county from db
	public function getState($state_id, $status='', $cnt_id="")
	{
		$where = array();

		if ($state_id)
			$where['state_id'] = $state_id;

		if ($cnt_id)
			$where['country_id'] = $cnt_id;

		if (!empty($status))
			$where['status'] = $status;
		
		return $this->Admin_model->selectRecords($where, 'state', '*', array('name' => 'ASC'));
	}

	public function addCity()
	{
		$this->isLoggedIn();

		$data = array();
		$city_id = $this->input->post('city_id');
		$cnt_id = $this->input->post('cnt_id');
		$state_id = $this->input->post('state_id');
		$data['state_id'] = $state_id;
		$data['name'] = $this->input->post('city_name');
		$data['latitude'] = $this->input->post('lat');
		$data['longitude'] = $this->input->post('long');
		$data['status'] = $this->input->post('status');
		$data['update_date'] = $this->current_date;
		$controller = 'page/cityManagement?getCityList='.$cnt_id."-".$state_id;

		if (!$data['latitude'] || !$data['longitude'])
		{
			$msg = "Error: Latitude and Longitude should have valid value!";
			$controller = 'page/cityManagement?addNewCity='.$cnt_id.'-'.$state_id.'&city_id='.$city_id;	
		}
		else if (!empty($state_id))
		{
			if (!empty($city_id)) 
			{
				$condition = array('city_id' => $city_id);
				$isUpdated = $this->Admin_model->updateData('city', $data, $condition);

				$msg = "State updated successfully!!";
				
				if (isset($isUpdated['db_error'])) 
					redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
			}
			else
			{
				$data['create_date'] = $this->current_date;
				$state_id = $this->Admin_model->insertData('city', $data);

				if ($state_id)
					$msg = "City inserted successfully!!";
				else
					$msg = "Error: Unable to insert city!";

				if (isset($state_id['db_error'])) 
					redirectWithMessage('Error: '.$state_id['msg'], $controller);
			}
		}
		else
		{
			$msg = "Error: state id not found!!";
			$controller = 'page/cityManagement';
		}

		redirectWithMessage($msg, $controller);
	}

	public function addState()
	{
		$this->isLoggedIn();

		$data = array();
		$state_id = $this->input->post('state_id');
		$country_id = $this->input->post('cnt_id');
		$data['country_id'] = $country_id;
		$data['name'] = $this->input->post('state_name');
		$data['status'] = $this->input->post('status');
		$data['update_date'] = $this->current_date;
		$controller = 'page/stateManagement?getStateList='.$country_id;

		if (!empty($state_id)) 
		{
			$condition = array('state_id' => $state_id);
			$isUpdated = $this->Admin_model->updateData('state', $data, $condition);

			$msg = "State updated successfully!!";
			
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		}
		else
		{
			$data['create_date'] = $this->current_date;
			$state_id = $this->Admin_model->insertData('state', $data);

			if ($state_id)
				$msg = "State inserted successfully!!";
			else
				$msg = "Error: Unable to insert state!";

			if (isset($state_id['db_error'])) 
				redirectWithMessage('Error: '.$state_id['msg'], $controller);
		}

		redirectWithMessage($msg, $controller);
	}

	//get county from db
	public function getCity($status='', $state_id="", $city_id="")
	{
		$where = array();

		if ($state_id) 
			$where['state_id'] = $state_id;

		if (!empty($status))
			$where['status'] = $status;

		if ($city_id) 
			$where['city_id'] = $city_id;

		return $this->Admin_model->selectRecords($where, 'city', '*', array('name' => 'ASC'));
	}

	//edit country 
	public function editCountry($cnt_id)
	{
		if ($cnt_id) 
		{
			$res = $this->getCountry($cnt_id);
			if (isset($res['db_error'])) 
				redirectWithMessage('Error: '.$res['msg'], 'page/countryManagement');

			if ($res['result'])
			{
				$data['country'] = $res['result'][0];
				$data['page_label'] = 'edit';
			}
			else
				$data['country'] = false;	
		}

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/addCountry', $data);
		$this->load->view('admin/include/footer');
		die;
	}

	public function getProductsForLinking($sel_id)
	{
		$this->isLoggedIn();

		if ($sel_id) 
		{
			$res['sel_id'] = $sel_id;
			$_SESSION['merchant_id'] = $sel_id;
			$brand_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : '';
			$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

			//get all products of merchant
			$where = array();
			if ($brand_id) 
				$where['product.brand_id'] = $brand_id;

			if ($category_id) 
				$where['product.category_id'] = $category_id;

			$res['products'] = $this->Admin_model->getProductsForLinking($sel_id, $where);
			if (isset($res['products']['db_error'])) 
				redirectWithMessage('Error: '.$res['products']['msg'], $controller);

			//get all requested products by merchant
			$res['req_products'] = $this->Admin_model->getRequestedProduct(array('requested_product.merchant_id' => $sel_id));
			if (isset($res['req_products']['db_error'])) 
				redirectWithMessage('Error: '.$res['req_products']['msg'], $controller);
			
			//get all categories
			$res['categories'] = $this->Admin_model->selectRecords('', 'product_category', 'category_id, category_name', array('category_name' => 'ASC'));
			if (isset($res['categories']['db_error'])) 
				redirectWithMessage('Error: '.$res['categories']['msg'], $controller);

			//get all brands
			$res['brands'] = $this->Admin_model->selectRecords('', 'brand', 'brand_id, name', array('name' => 'ASC'));
			if (isset($res['brands']['db_error'])) 
				redirectWithMessage('Error: '.$res['brands']['msg'], $controller);

			//echo "<pre>"; print_r($res); die;
			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/productsForLink', $res);
			$this->load->view('admin/include/footer');
			die;
		}
	}

	public function verifyListing($listId, $status, $seller_id)
	{
		$this->isLoggedIn();

		if (!empty($listId)) 
		{
			$condition = array('listing_id' => $listId);
			$isUpdated = $this->Admin_model->updateData('product_listing', array('isVerified' => $status, 'update_date' => $this->current_date), $condition);

			$msg = "Successfully changed!";
			$controller = "getAllProducts/".$seller_id;
		}
		else
		{
			$msg = 'Error: Listing id not found!';
			$controller = "sellers/sellersList";
		}
		
		if (isset($isUpdated['db_error']))
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	//get cities from db
	public function citiesAJAX($state_id="")
	{
		$where = "";

		if ($state_id)
			$where = array('state_id' => $state_id);

		$res = $this->Admin_model->selectRecords($where, 'city', '*', array('name' => 'ASC'));
		if (isset($res['db_error'])) 
			redirectWithMessage('Error: '.$res['msg'], 'dashboard');

		echo json_encode($res['result']);
		die;
	}

	//get states from db
	public function statesAJAX($state_id="")
	{
		$where = "";

		if ($state_id)
			$where = array('country_id' => $state_id, 'status' => 1);

		$res = $this->Admin_model->selectRecords($where, 'state', '*', array('name' => 'ASC'));
		if (isset($res['db_error'])) 
			redirectWithMessage('Error: '.$res['msg'], 'dashboard');

		echo json_encode($res['result']);
		die;
	}

	//get county from db
	public function getCountry($cnt_id="", $staus='')
	{
		$where = "";

		if ($cnt_id)
			$where = array('country_id' => $cnt_id);

		if ($staus)
			$where['status'] = $status;

		return $this->Admin_model->selectRecords($where, 'country', '*', array('name' => 'ASC'));
	}

	//logout method
	public function logout()
	{
		session_destroy();
		$_SESSION = array();

		//unset all cookies
		setcookie('email', '', null, "/");
		setcookie('image', '', null, "/");
		setcookie('name', '', null, "/");
		setcookie('status', '', null, "/");
		setcookie('token', '', null, "/");
		setcookie('user_id', '', null, "/");
		setcookie('merchant_id', '', null, "/");

		redirect(base_url(), 'refresh');
	}

	public function addCategory()
	{
		$this->isLoggedIn();

		$data = array();
		$cat_id = $this->input->post('cat_id');
		$parent_cat_id = $this->input->post('parent_cat_id');
		$selected_att_ids = $this->input->post('selected_att_ids');
		$data['category_name'] = trim($this->input->post('cat_name'));
		$data['meta_keyword'] = trim($this->input->post('meta_keyword'));
		$data['meta_description'] = trim($this->input->post('meta_description'));
		$data['update_date'] = $this->current_date;
		$controller = 'category';

		if ($parent_cat_id != 0) 
		{
			$data['has_parent'] = 1;
			$data['parent_category_id'] = $parent_cat_id;
		}
		else
		{
			$data['has_parent'] = 0;
			$data['parent_category_id'] = 0;
		}
		
		//load form validation library
		$this->load->library('form_validation');

		//check validation
		$this->form_validation->set_rules('config');
		$this->form_validation->set_error_delimiters('<span class="alert-danger">', '</span>');

		if (!empty($cat_id) && $this->form_validation->run('edit_category')) 
		{
			$condition = array('category_id' => $cat_id);
			$isUpdated = $this->Admin_model->updateData('product_category', $data, $condition);

			$msg = "Category updated successfully!!";
			
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		}
		else if ($this->form_validation->run('add_category')) 
		{
			$data['create_date'] = $this->current_date;

			$cat_id = $this->Admin_model->insertData('product_category', $data);

			$msg = "Category inserted successfully!!";

			if (isset($cat_id['db_error'])) 
				redirectWithMessage('Error: '.$cat_id['msg'], $controller);
		}
		else
			$this->categoryView();

		if ($cat_id) 
		{
			$folder = CATEGORY_ATTACHMENT_PATH.$cat_id;

			//image data
			$img_data['link_id'] = $cat_id;
			$img_data['atch_type'] = "IMAGE";
			$img_data['atch_for'] = "CATEGORY";

			//insert category images
			$isUploaded = $this->upload_image( $folder, $img_data );
			if (isset($isUploaded['db_error'])) 
				redirectWithMessage('Error: '.$isUploaded['msg'], $controller);

			//select att_id from db
			$where = array('cat_id' => $cat_id);
			$db_att_res = $this->Admin_model->selectRecords($where, 'category_attribute_mp', 'att_id');
			if (isset($db_att_res['db_error'])) 
				redirectWithMessage('Error: '.$db_att_res['msg'], $controller);

			//db attribute result
			$db_att_ids = array();
			if ($db_att_res['result'])
			{
				foreach ($db_att_res['result'] as $att_value) 
					array_push($db_att_ids, $att_value['att_id']);
			}
			
			//compare db att_ids from checkbox att_ids
			//create an delete array
			$del_att_array = array();
			if ($selected_att_ids)
				$del_att_array = array_diff($db_att_ids, $selected_att_ids); 
			else
				$del_att_array = $db_att_ids;
			
			//create an insert array
			$ins_att_array = array();
			if ($selected_att_ids)
				$ins_att_array = array_diff($selected_att_ids, $db_att_ids); 

			//insert attribute in category attribute mappings table
			if (count($ins_att_array) > 0) 
			{
				foreach ($ins_att_array as $ins_att_value) 
					$this->insertCatAttInMpTbl($cat_id, $ins_att_value);
			}
			
			//delete attribute from category mapping table
			if(count($del_att_array) > 0)
			{
				foreach ($del_att_array as $del_att_value) 
				{
					$where = array('att_id' => $del_att_value, 'cat_id' => $cat_id);
					$isDeleted = $this->Admin_model->deleteRecord('category_attribute_mp', $where);

					if (isset($isDeleted['db_error'])) 
						redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
				}	
			}
			
			$isAddedHTMLFile = $this->addHTMLFiles($cat_id, 'CATEGORY');
			if (!$isAddedHTMLFile) 
				$msg = 'Error: unable to perform action for HTML Files!';

			redirectWithMessage($msg, $controller);
		}
		else
			redirectWithMessage('Error: Unable to insert!', $controller);
	}

	public function categoryView()
	{
		$data = array();
		$data['status'] = true;
			
		$data['categories'] = $this->getAllCategories();
		if (isset($data['categories']['db_error'])) 
			redirectWithMessage('Error: '.$data['categories']['msg'], $controller);

		$data['attributes'] = $this->getAllAttributes();
		if (isset($data['attributes']['db_error'])) 
			redirectWithMessage('Error: '.$data['attributes']['msg'], $controller);

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/addCategory', $data);
		$this->load->view('admin/include/footer');
		die;
	}

	private function upload_seller_image($path, $img_data)
	{
		//insert category images
		for ($i = 1; $i < 7; $i++) 
		{ 
			$obj_name = 'file'.$i;
			if (isset($_FILES[$obj_name]['name']) && $_FILES[$obj_name]['name'] != '')
			{
				$new_name = $obj_name.'_'.rand();

				//delete image from db and folder
				$isDeleted = $this->deleteShopImage($obj_name, $img_data['link_id']);
				if (!$isDeleted)
					return false;

				$img_data['atch_url'] = $this->common_controller->single_upload($path, $new_name, $obj_name);

				//insert images
				if ($img_data['atch_url'])
					$this->Admin_model->insertData('attatchments', $img_data);
			}
		}

		return true;
	}

	private function deleteShopImage($file_name, $merchant_id)
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
							return false;
			    	}
			    }
	     	}
	    }
	    else
	    	return false;

	    return true;
    }

	public function upload_image($path, $img_data)
	{
		//insert category images
		for ($i = 1; $i < 7; $i++) 
		{ 
			$obj_name = 'file'.$i;
			if ($_FILES[$obj_name]['name'] != '')
			{
				$img_data['atch_url'] = $this->single_upload($path, '', $obj_name);

				//insert images
				if ($img_data['atch_url']) 
				{
					$isInserted = $this->Admin_model->insertData('attatchments', $img_data);
					if (isset($isInserted['db_error'])) 
						return $isInserted;

					$remove_img = $this->input->post('remove_img'.$i);

					if ($remove_img) 
					{
						//delete from the folder
						$isDeleted = $this->Admin_model->deleteRecord('attatchments', array('atch_url' => $remove_img));
						if (isset($isDeleted['db_error'])) 
							return $isDeleted;

						//delete from the folder
						unlink($path.'/'.$remove_img);
					}
				}
			}
		}

		return true;
	}

	public function addHTMLFiles($link_id = '', $type = '')
	{
		if ($link_id && $type) 
		{
			//insert/update/delete html files for category
			for ($i = 1; $i < 5; $i++)
			{ 
				$html_id = $this->input->post('html_id'.$i);
				$html_link = $this->input->post('html_link'.$i);

				if ($html_id) 
				{
					$where = array('html_file_id' => $html_id);
					if ($html_link) //update link
						$this->Admin_model->updateData('html_files', array('html_file' => $html_link), $where);
					else //delete link
						$this->Admin_model->deleteRecord('html_files', $where);

					return true;
				}
				else if ($html_link) //insert link
				{
					$data = array(
								'link_id' => $link_id,
								'html_file' => $html_link,
								'linked_type' => $type	
							);

					$html_link_id = $this->Admin_model->insertData( 'html_files', $data );

					if ($html_link_id) 
						return true;
					else
						return false;
				}
			}

			return true;
		}
		else
			return false;
	}

	//insert attribute for category
	public function insertCatAttInMpTbl($cat_id = "", $att_id = "")
	{
		$this->isLoggedIn();
		$controller = 'page/addCategory';

		if ( $cat_id && $att_id ) 
		{
			$att_mp_data = array();
			$att_mp_data['cat_id'] = $cat_id;
			$att_mp_data['att_id'] = $att_id;

			$mp_id = $this->Admin_model->insertData('category_attribute_mp', $att_mp_data);	
			if ( isset($mp_id['db_error']) ) 
				redirectWithMessage('Error: '.$mp_id['msg'], $controller);

			if (!$mp_id) 
				redirectWithMessage('Error: Unable to add attibute!', $controller);
		}
		else
			redirectWithMessage('Error: Attibute id or category id not found!', $controller);
	}

	public function getAllAttributes($att_id = "")
	{
		$this->isLoggedIn();

		$tbl_name = 'attribute_name';
		$columns  = '*';
		$where = "";

		if ($att_id)
			$where = array('att_id' => $att_id);

		$att_res = $this->Admin_model->selectRecords($where, $tbl_name, $columns);

		if ( isset($att_res['db_error']) ) 
			return $att_res;
		else if ($att_res['result']) 
			return $att_res['result'];
		else
			return FALSE;
	}

	//add country 
	public function addCountry()
	{
		$this->isLoggedIn();

		$cnt_id = $this->input->post('cnt_id');
		$data['name'] = $this->input->post('cnt_name');
		$data['status'] = $this->input->post('cnt_status');
		$data['update_date'] = $this->current_date;
		$controller = "page/countryManagement";

		if (!empty($cnt_id)) 
		{
			$condition = array('country_id' => $cnt_id);
			$isUpdated = $this->Admin_model->updateData('country', $data, $condition);

			$msg = "Successfully updated!";
			
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		}
		else
		{
			$data['create_date'] = $this->current_date;

			$cnt_id = $this->Admin_model->insertData('country', $data);

			if ($cnt_id) 
				$msg = 'Succesfully inserted!';
			else
				$msg = 'Error: Unable to insert!';

			if (isset($cnt_id['db_error'])) 
				redirectWithMessage('Error: '.$cnt_id['msg'], $controller);
		}

		redirectWithMessage($msg, $controller);
	}

	public function changeAreaStatus($cnt_id, $state_id, $city_id, $area_id, $status)
	{
		$this->isLoggedIn();

		if (!empty($area_id)) 
		{
			$condition = array('area_id' => $area_id);
			$isUpdated = $this->Admin_model->updateData('area', array('status' => $status, 'update_date' => $this->current_date), $condition);
		
			$msg = "Successfully changed!";
		}
		else
			$msg = 'Error: Area id not found!';

		$controller = "page/areaManagement?getAreaList=".$cnt_id."-".$state_id."-".$city_id;
		
		if ( isset($isUpdated['db_error']) ) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	public function changeCountryStatus($cnt_id, $status)
	{
		$this->isLoggedIn();

		if (!empty($cnt_id)) 
		{
			$condition = array('country_id' => $cnt_id);
			$isUpdated = $this->Admin_model->updateData('country', array('status' => $status, 'update_date' => $this->current_date), $condition);

			$msg = "Successfully changed!";
		}
		else
			$msg = 'Error: Country id not found!';

		$controller = "page/countryManagement";

		if ( isset($isUpdated['db_error']) ) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	public function changeStateStatus($state_id, $cnt_id ,$status)
	{
		$this->isLoggedIn();

		if (!empty($state_id)) 
		{
			$condition = array('state_id' => $state_id);
			$isUpdated = $this->Admin_model->updateData('state', array('status' => $status, 'update_date' => $this->current_date), $condition);

			$msg = "Successfully changed!";
		}
		else
			$msg = 'Error: State id not found!';

		$controller = "page/stateManagement?getStateList=".$cnt_id;
		if ( isset($isUpdated['db_error']) ) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	public function changeUserStatus($usr_id, $status)
	{
		$this->isLoggedIn();

		if (!empty($usr_id)) 
		{
			$condition = array('userId' => $usr_id);
			$isUpdated = $this->Admin_model->updateData('user', array('status' => $status, 'update_date' => $this->current_date), $condition);

			$msg = "Successfully changed!";
		}
		else
			$msg = 'Error: User id not found!';

		$controller = "page/userManagement";
		if (isset($isUpdated['db_error'])) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	public function changeCityStatus($cnt_id, $state_id, $city_id, $status)
	{
		$this->isLoggedIn();

		if (!empty($city_id)) 
		{
			$condition = array('city_id' => $city_id);
			$isUpdated = $this->Admin_model->updateData('city', array('status' => $status, 'update_date' => $this->current_date), $condition);

			$msg = "Successfully changed!";
		}
		else
			$msg = 'Error: City id not found!';

		$controller = "page/cityManagement?getCityList=".$cnt_id."-".$state_id;
		if (isset($isUpdated['db_error'])) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	//add category method
	public function addBrand()
	{
		$this->isLoggedIn();

		$data = array();
		$brand_id = $this->input->post('brand_id');
		$data['name'] = $this->input->post('brand_name');
		$data['brand_desc'] = $this->input->post('brand_desc');
		$data['meta_keyword'] = $this->input->post('meta_keyword');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['update_date'] = $this->current_date;
		$controller = "brand";

		if (!empty($brand_id)) 
		{
			$condition = array('brand_id' => $brand_id);
			$isUpdated = $this->Admin_model->updateData('brand', $data, $condition);

			$msg = "Successfully updated!";

			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		}
		else
		{
			$data['create_date'] = $this->current_date;

			$brand_id = $this->Admin_model->insertData('brand', $data);
			
			if ($brand_id) 
				$msg = 'Succesfully inserted!';
			else
				$msg = 'Error: Unable to insert!';

			if (isset($brand_id['db_error'])) 
				redirectWithMessage('Error: '.$brand_id['msg'], $controller);
		}

		//image upload
		if ($brand_id) 
		{
			$folder = BRAND_ATTATCHMENTS_PATH.$brand_id;

			//insert logo
			if ($_FILES['file']['name'])
			{
				$logo = $this->single_upload($folder);

				//insert brand logo
				if ($logo) 
				{
					//remove image from brand folder
					$brand_logo = $this->input->post('brand_logo');
					if ($brand_logo) 
						unlink($folder.'/'.$brand_logo);

					$logo_data['update_date'] = $this->current_date;
					$logo_data['brand_logo'] = $logo;
					$isUpdated = $this->Admin_model->updateData('brand', $logo_data, array('brand_id' => $brand_id));

					if (isset($isUpdated['db_error'])) 
						redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
				}
			}

			//atatchment data
			$img_data['link_id'] = $brand_id;
			$img_data['atch_type'] = "IMAGE";
			$img_data['atch_for'] = "BRAND";

			//insert brand images
			$isUploaded = $this->upload_image($folder, $img_data);
			if (isset($isUploaded['db_error'])) 
				redirectWithMessage('Error: '.$isUploaded['msg'], $controller);

			$isAddedHTMLFile = $this->addHTMLFiles( $brand_id, 'BRAND' );

			if (!$isAddedHTMLFile) 
				$msg = 'Error: unable to perform action for HTML Files!';
		}

		redirectWithMessage($msg, $controller);
	}

	public function getAllBrands($brand_id = "")
	{
		$this->isLoggedIn();
		$tbl_name = 'brand';
		$columns  = '*';
		$where = "";

		if ($brand_id)
			$where = array('brand_id' => $brand_id);

		$brands_result = $this->Admin_model->selectRecords($where, $tbl_name, $columns);
		if (isset($brands_result['db_error'])) 
			return $brands_result;
		else if ($brands_result['result']) 
			return $brands_result['result'];
		else
			return FALSE;
	}

	public function editBrand($brand_id, $page_label)
	{
		$this->isLoggedIn();

		if ($brand_id) 
		{
			$brand_res = $this->getAllBrands($brand_id);	
			
			if (isset($brand_res['db_error'])) 
				redirectWithMessage('Error: '.$brand_res['msg'], 'brand');
			else if ( $brand_res )
			{
				$brand_data['success'] = true;
				$brand_data['data'] = $brand_res[0];
				$brand_data['page_label'] = $page_label;
				$brand_data['data']['brand_images_dir'] = $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id;

				//get brand images
				$brand_data['data']['brand_images'] = $this->attatchments($brand_id, "BRAND");

				//get brand html files
				$html_files = $this->Admin_model->selectRecords(array('link_id' => $brand_id, 'linked_type' => 'BRAND'), 'html_files', 'html_file, html_file_id');

				if ( isset($html_files['db_error']) ) 
					redirectWithMessage('Error: '.$html_files['msg'], 'brand');
				else
					$brand_data['data']['html_files'] = $html_files;
			}
			else
			{
				$brand_data['success'] = false;
				$brand_data['data'] = array();
				$brand_data['page_label'] = '';
			}
			
			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/addBrand', $brand_data);
			$this->load->view('admin/include/footer');
			die;
		}
	}

	public function getBrands()
	{
		$this->isLoggedIn();

		$brands_result = $this->getAllBrands();	
		
		if (isset($brands_result['db_error'])) 
			redirectWithMessage('Error: '.$brands_result['msg'], 'dashboard');
		else if ($brands_result)
		{
			$data['success'] = true;
			$data['data'] = $brands_result;
		}
		else
		{
			$data['success'] = false;
			$data['data'] = array();
		}
		
		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/brands', $data);
		$this->load->view('admin/include/footer');
		die;
	}

	public function addProduct()
	{
		$this->isLoggedIn();
		$data = array();
		$data['status'] = true;
		$data['categories'] = $this->getAllCategories();
		$data['brands'] = $this->getAllBrands();
		$controller = 'products';

		if (isset($data['brands']['db_error'])) 
			redirectWithMessage('Error: '.$data['brands']['msg'], 'products');

		$data['product_tags'] = array();
		$data['tags'] = array();
		$data['key_features'] = false;

		//get all tags
		$tags = $this->Admin_model->selectRecords("", "tags", "*");	

		if (isset($tags['db_error'])) 
			redirectWithMessage('Error: '.$tags['msg'], $controller);
		else if ($tags['result']) 
			$data['tags'] = $tags['result'];

		if (isset($_GET['req_prd_id'])) 
		{
			$req_prds = $this->Admin_model->selectRecords(array('request_id' => $_GET['req_prd_id']), 'requested_product', '*');
			if (isset($req_prds['db_error'])) 
				redirectWithMessage('Error: '.$req_prds['msg'], $controller);

			$data['req_prds'] = $req_prds['result'][0];
		}

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/addProduct', $data);	
		$this->load->view('admin/include/footer');
		die;
	}

	public function editCategory($cat_id, $page_label)
	{
		$this->isLoggedIn();
		$controller = 'category';

		if ($cat_id) 
		{
			$parent_category = array();
			$category = $this->getAllCategories($cat_id);
			$categories = $this->getAllCategories();
			$cat_html_links = $this->Admin_model->selectRecords(array('link_id' => $cat_id, 'linked_type' => 'CATEGORY'), 'html_files', 'html_file, html_file_id');
			if (isset($cat_html_links['db_error'])) 
				redirectWithMessage('Error: '.$cat_html_links['msg'], $controller);

			$category_attributes_res = $this->Admin_model->categoryAttribute($cat_id);
			if (isset($category_attributes_res['db_error'])) 
				redirectWithMessage('Error: '.$category_attributes_res['msg'], $controller);

			$category_attributes = array();
			if ($category_attributes_res)
				$category_attributes = $category_attributes_res;

			$data['status'] = TRUE;
			$data['category'] = $category[0];
			$data['categories'] = $categories;
			$data['attributes'] = $category_attributes;
			$data['page_label'] = $page_label;
			$data['html_files'] = $cat_html_links;
			$data['images'] = array();
			$data['category_images_dir'] = $this->config->item('site_url').CATEGORY_ATTACHMENT_PATH.$cat_id;
			
			//get category images
			$cat_imgs = $this->attatchments($cat_id, "CATEGORY");
			if ($cat_imgs) 
				$data['images'] = $cat_imgs;

			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/addCategory', $data);
			$this->load->view('admin/include/footer');
			die;
		}
		else
			redirectWithMessage('Error: Category id not found', $controller);
	}

	public function CategoryAttribtesAJAX($cat_id, $prd_id=0)
	{
		$this->isLoggedIn();

		if ($cat_id) 
		{
			if (!$prd_id) 
				$category_attributes_res = $this->Admin_model->categoryAttribute($cat_id);
			else
				$category_attributes_res = $this->Admin_model->categoryAttributes($cat_id, $prd_id);
		
			$category_attributes = array();
			if ($category_attributes_res)
				$category_attributes = $category_attributes_res;

			echo json_encode($category_attributes);
			die;
		}
	}

	public function productAttributesValueAJAX($prd_id)
	{
		$this->isLoggedIn();

		if ($prd_id) 
		{
			$tbl_name = 'category_attribute_value';
			$columns  = '*';
			$where = array('prd_id' => $prd_id);
			$prd_att_val = $this->Admin_model->selectRecords($where, $tbl_name, $columns);	

			if ($prd_att_val['result']) 
				echo json_encode($prd_att_val['result']);

			die;
		}
	}

	//get all categories method
	public function getAllCategories($cat_id = "")
	{
		$this->isLoggedIn();

		$tbl_name = 'product_category';
		$columns  = '*';
		$where = "";

		if ($cat_id)
			$where = array('category_id' => $cat_id);

		$cat_result = $this->Admin_model->selectRecords($where, $tbl_name, $columns);	

		if ( isset($cat_result['db_error']) ) 
			return $cat_result;
		if ($cat_result['result']) 
			return $cat_result['result'];
		else
			return FALSE;
	}

	public function category()
	{
		$this->isLoggedIn();

		$cat_res = $this->Admin_model->selectRecords('', 'product_category', '*');

		if ( isset($cat_res['db_error']) ) 
			redirectWithMessage('Error: '.$cat_res['msg'], 'dashboard');
		else if ($cat_res) 
		{
			$cat_res = $cat_res['result'];
			for ($i=0; $i < sizeof($cat_res) ; $i++) 
			{ 
				if ($cat_res[$i]['parent_category_id'])
				{
					$sub_cat_res = $this->Admin_model->selectRecords(array('category_id' => $cat_res[$i]['parent_category_id']), 'product_category', '*');

					$sub_cat_res = $sub_cat_res['result'];
					$cat_res[$i]['parent_cat'] = $sub_cat_res[0]['category_name'];
				}
				else
					$cat_res[$i]['parent_cat'] = '-';
			}

			if ($cat_res)
			{
				$data['success'] = true;
				$data['categories'] = $cat_res;
			}
		}
		else
		{
			$data['success'] = false;
			$data['data'] = array();
		}
		
		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/category', $data);
		$this->load->view('admin/include/footer');
		die;
	}

	//do login method
	public function changeParentCategory()
	{
		$this->isLoggedIn();

		$parent_cat_id = $this->input->post('parent_cat_id');
		$category_ids = $this->input->post('selected_sub_category_ids');

		if ($parent_cat_id != 0 && count($category_ids) > 0) 
		{
			for ($i=0; $i < sizeof($category_ids) ; $i++) 
			{ 
				if ($category_ids[$i] == $parent_cat_id) 
				{
					$data['has_parent'] = 0;
					$data['parent_category_id'] = null;
				}
				else
				{
					$data['has_parent'] = 1;
					$data['parent_category_id'] = $parent_cat_id;
				}

				$data['update_date'] = $this->update_date;
				$condition = array('category_id' => $category_ids[$i]);
				$isUpdated = $this->Admin_model->updateData('product_category', $data, $condition);

				if (isset($isUpdated['db_error'])) 
					redirectWithMessage('Error: '.$isUpdated['msg'], 'dashboard');
			}

			redirectWithMessage('Catgories updated Succesfully!', 'category');
		}
		else
			redirectWithMessage('Error: please select the category and parent category to move!', 'dashboard');
	}

	public function products()
	{
		$this->isLoggedIn();
		$where = array();

		$controller = 'dashboard';

		$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
		$brand_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : '';

		if ($category_id) 
			$where['product.category_id'] = $_GET['category_id'];

		if ($brand_id) 
			$where['product.brand_id'] = $_GET['brand_id'];

		$data['data'] = $this->Admin_model->products($where);
		if (isset($data['data']['db_error'])) 
			redirectWithMessage('Error: '.$data['data']['msg'], $controller);

		$data['category'] = $this->Admin_model->selectRecords('', 'product_category', 'category_id, category_name');
		if (isset($data['category']['db_error'])) 
			redirectWithMessage('Error: '.$data['category']['msg'], $controller);

		$data['brands'] = $this->Admin_model->selectRecords('', 'brand', 'brand_id, name');
		if (isset($data['brands']['db_error'])) 
			redirectWithMessage('Error: '.$data['brands']['msg'], $controller);
		
		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/products', $data);
		$this->load->view('admin/include/footer');
		die;
	}

	public function updateProductVarientValue()
	{
		$this->isLoggedIn();

		$vrnt_ids = $this->input->post('vrnt_ids');
		$vrnt_values = $this->input->post('vrnt_values');	
		$prd_id = $this->input->post('prd_id');

		if ($vrnt_ids && $vrnt_values && $prd_id) 
		{
			$vrnt_data = array_combine($vrnt_ids, $vrnt_values);

			foreach ($vrnt_data as $vrnt_key => $vrnt_value) 
			{
				$condition = array('vrnt_id' => $vrnt_key);
				$data['att_value'] = $vrnt_value;

				$isUpdated = $this->Admin_model->updateData('product_varient', $data, $condition);

				if (isset($updated['db_error'])) 
					redirectWithMessage('Error: '.$updated['msg'], 'products');
			}
		}
	}

	public function deleteProductVarientValue($vrnt_id, $prd_id)
	{
		$this->isLoggedIn();

		$tbl_name = 'product_varient';
		$where = array('vrnt_id' => $vrnt_id);
		$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], 'products');

		$this->updateTableDate('product', array('product_id' => $prd_id));
		redirectWithMessage('Varient deleted successfully!', 'editProduct/'.$prd_id.'/edit');
	}

	public function deleteRequestProduct($req_prd_id)
	{
		$this->isLoggedIn();

		$isDeleted = $this->Admin_model->deleteRecord('requested_product', array('request_id' => $req_prd_id));
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], 'products');

		redirectWithMessage('Requested product deleted successfully!', 'getAllProducts/'.$_SESSION['merchant_id']);
	}

	public function deleteClaimedRequest($req_clmd_id)
	{
		$this->isLoggedIn();

		$isDeleted = $this->Admin_model->deleteRecord('claimed_requests', array('clmd_id' => $req_clmd_id));
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], 'page/claimedRequest');

		redirectWithMessage('Claimed request deleted successfully!', 'page/claimedRequest');
	}

	public function deleteHTMLLink($html_link_id, $link_id, $type)
	{
		$this->isLoggedIn();

		$tbl_name = 'html_files';
		$where = array('html_file_id' => $html_link_id);
		$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);

		if ($type == 'CATEGORY') 
			$controller = 'editCategory/'.$link_id.'/edit';
		else if ($type == 'BRAND') 
			$controller = 'editBrand/'.$link_id.'/edit';
		else if ($type == 'PRODUCT') 
			$controller = 'editProduct/'.$link_id.'/edit';
		else if ($type == 'OFFER') 
			$controller = 'editOffer/'.$link_id.'/edit';

		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

		if ($type == 'CATEGORY') 
			$isUpdated = $this->updateTableDate('product_category', array('category_id' => $link_id));
		else if ($type == 'BRAND') 
			$isUpdated = $this->updateTableDate('brand', array('brand_id' => $link_id));
		else if ($type == 'PRODUCT') 
			$isUpdated = $this->updateTableDate('product', array('product_id' => $link_id));
		else if ($type == 'OFFER') 
			$isUpdated = $this->updateTableDate('product_listing_offer', array('offer_id' => $link_id));
		
		if (isset($isUpdated['db_error'])) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		else
			redirectWithMessage('HTML file deleted successfully!', $controller);
	}

	//update record in parent node
	public function updateTableDate($tbl_name, $condition)
	{
		$isUpdated = $this->Admin_model->updateData($tbl_name, array('update_date' => $this->current_date), $condition);
		if (isset($isUpdated['db_error'])) 
			return $isUpdated;
		else
			return true;
	}

	public function deleteListing($list_id, $sel_id)
	{
		$this->isLoggedIn();
		$controller = 'getAllProducts/'.$sel_id;

		$isDeleted = $this->Admin_model->deleteRecord('product_listing', array('listing_id' => $list_id));
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
		$msg = 'Product unlinked successfully!';

		$isDeleted = $this->saveDeleteItem($list_id, 'LISTING');
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

		redirectWithMessage($msg, $controller);
	}

	//delete offer
	public function deleteOffer($offer_id = '')
	{
		$this->isLoggedIn();
		if ($_COOKIE['site_code'] == 'seller') 
			$controller = 'page/offerManagement';
		else
			$controller = 'sellers/offers';

		if ($offer_id) 
		{
			$msg = 'Offer deleted successfully!!!';

			$isDeleted = $this->Admin_model->deleteRecord('product_listing_offer', array('offer_id' => $offer_id));
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

			$folder_path = OFFER_ATTATCHMENTS_PATH.$offer_id;

			if (is_dir($folder_path)) 
			{
				if (deleteFolder($folder_path))
				{
					$isDeleted = $this->Admin_model->deleteRecord('attatchments', array('link_id' => $offer_id, 'atch_for' => 'OFFER', 'atch_type' => 'IMAGE'));
					if (isset($isDeleted['db_error'])) 
						redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
				}
				else
					$msg = "Error: Unable to delete folder";
			}

			$isDeleted = $this->saveDeleteItem($offer_id, 'OFFER');
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
		}
		else
			$msg = 'Error: Offer id not found.';

		redirectWithMessage($msg, $controller);
	}

	//delete product
	public function deleteProduct($prd_id = '')
	{
		$this->isLoggedIn();
		$controller = 'products';

		if ($prd_id) 
		{
			//delete product
			$tbl_name = 'product';
			$where = array('product_id' => $prd_id);
			$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			$folder_path = PRODUCT_ATTATCHMENTS_PATH.$prd_id;
			$msg = 'Product deleted successfully!';

			if (is_dir($folder_path)) 
			{
				if (deleteFolder($folder_path))
				{
					$this->Admin_model->deleteRecord('attatchments', array('link_id' => $prd_id, 'atch_for' => 'PRODUCT', 'atch_type' => 'IMAGE'));
					if (isset($isDeleted['db_error'])) 
						redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
				}
				else
					$msg = "Error: Unable to delete folder";
			}

			$isDeleted = $this->saveDeleteItem($prd_id, 'PRODUCT');
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
		}
		else
			$msg = 'Erorr: product id not found!';

		redirectWithMessage($msg, $controller);
	}

	public function deleteMerchant( $merchant_id = '' )
	{
		$this->isLoggedIn();
		$controller = 'sellers/sellersTable';
		
		if ($merchant_id) 
		{
			//delete product
			$tbl_name = 'merchant';
			$where = array('merchant_id' => $merchant_id);
			$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			$folder_path = SELLER_ATTATCHMENTS_PATH.$merchant_id;
			$msg = 'Merchant deleted successfully!';

			if (is_dir($folder_path)) 
			{
				if (deleteFolder($folder_path))
				{
					$isDeleted = $this->Admin_model->deleteRecord('attatchments', array('link_id' => $merchant_id, 'atch_for' => 'MERCHANT', 'atch_type' => 'IMAGE'));
					if (isset($isDeleted['db_error'])) 
						redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
				}
				else
					$msg = "Error: Unable to delete folder";
			}

			$isDeleted = $this->saveDeleteItem( $merchant_id, 'MERCHANT');
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
		}
		else
			$msg = 'Erorr: merchant id not found!';

		redirectWithMessage($msg, $controller);
	}

	public function saveDeleteItem($item_id = '', $item_type = '')
	{
		if ($item_id && $item_type) 
		{
			$deleted_item_data = array(
									'item_id' => $item_id,
									'item_type' => $item_type,
									'deletion_time' => $this->current_date	
								);
			$deleted_item_id = $this->Admin_model->insertData('deleted_items', $deleted_item_data);
			
			if (isset($deleted_item_id['db_error'])) 
				return $deleted_item_id;
			else if ($deleted_item_id) 
				return true;
		}

		return false;
	}

	public function deleteCategory($cat_id = '')
	{
		$this->isLoggedIn();
		$controller = 'category';

		if ($cat_id) 
		{
			//delete category
			$cat_tbl_name = 'product_category';
			$columns = 'category_id';
			$where = array('parent_category_id' => $cat_id);
			$cat_result = $this->Admin_model->selectRecords($where, $cat_tbl_name, $columns);	

			if (isset($cat_result['db_error'])) 
				redirectWithMessage('Error: '.$cat_result['msg'], $controller);
			else if ($cat_result) 
				$msg = 'Error: Unable to delete the category!';
			else
			{
				//delete category				
				$where = 'category_id = '.$cat_id.' or parent_category_id = '.$cat_id;
				$isDeleted = $this->Admin_model->deleteRecord($cat_tbl_name, $where);
				if (isset($isDeleted['db_error'])) 
					redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
				$folder_path = CATEGORY_ATTACHMENT_PATH.$cat_id;
				$msg = 'Category deleted successfully!';

				if (is_dir($folder_path)) 
				{
					if (deleteFolder($folder_path))
						$this->Admin_model->deleteRecord('attatchments', array('link_id' => $cat_id, 'atch_for' => 'CATEGORY', 'atch_type' => 'IMAGE'));
					else
						$msg = "Error: Unable to delete folder";
				}

				$isDeleted = $this->saveDeleteItem($cat_id, 'CATEGORY');
				if (isset($isDeleted['db_error'])) 
					redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			}
		}
		else
			$msg = 'Erorr: category id not found!';

		redirectWithMessage($msg, $controller);
	}

	public function deleteBrand( $brand_id = '' )
	{
		$this->isLoggedIn();

		if ($brand_id) 
		{
			$tbl_name = 'product';
			$columns  = 'product_id';
			$where = array('brand_id' => $brand_id);
			$brand_prd_res = $this->Admin_model->selectRecords($where, $tbl_name, $columns);	
			if ($brand_prd_res)
				$msg = "Error: Can't delete this brand There are some product related to this brand!";
			else
			{
				$tbl_name = 'brand';
				$where = array('brand_id' => $brand_id);
				$this->Admin_model->deleteRecord($tbl_name, $where);
				$msg = 'Brand deleted successfully!';

				//delete brand folder if exist
				$folder_path = BRAND_ATTATCHMENTS_PATH.$brand_id;
				$msg = 'Product deleted successfully!';

				if (is_dir($folder_path)) 
				{
					if (deleteFolder($folder_path))
						$this->Admin_model->deleteRecord('attatchments', array('link_id' => $brand_id, 'atch_for' => 'BRAND', 'atch_type' => 'IMAGE'));
					else
						$msg = "Error: Unable to delete folder";
				}

				$isDeleted = $this->saveDeleteItem($brand_id, 'BRAND');
				if (isset($isDeleted['db_error'])) 
					redirectWithMessage('Error: '.$isDeleted['msg'], 'brand');
			}
		}
		else
			$msg = "Brand id not found!";

		redirectWithMessage($msg, 'brand');
	}

	//add category method
	public function insertProduct()
	{
		$this->isLoggedIn();
		
		$data = array();
		$images = array();

		$data['category_id'] = $this->input->post('parent_cat_id');
		$data['brand_id'] = $this->input->post('brand_id');
		$data['product_name'] = $this->input->post('prd_name');
		$data['amazon_prd_id'] = $this->input->post('amazon_prd_id');
		$data['flipkart_prd_id'] = $this->input->post('flipkart_prd_id');
		$data['mrp_price'] = $this->input->post('prd_price');
		$data['description'] = $this->input->post('prd_desc');
		$data['in_the_box'] = $this->input->post('in_the_box');
		$data['meta_keyword'] = $this->input->post('meta_keyword');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['notes'] = $this->input->post('notes');
		$req_prd_id = $this->input->post('req_prd_id');
		$merchant_id = $this->input->post('merchant_id');
		$data['update_date'] = $this->current_date;
		$prd_tags = $this->input->post('selected_tag_ids');
		$key_features = $this->input->post('key_feature_values');
		$old_prd_id = $this->input->post('old_prd_id');
		$prd_id = $this->input->post('prd_id');

		$controller = 'products';

		if (count(array_filter($data)) >= 5) 
		{
			if ($prd_id) //update product
			{
				$condition = array('product_id' => $prd_id);
				$isUpdated = $this->Admin_model->updateData('product', $data, $condition);

				if (isset($isUpdated['db_error'])) 
					redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

				$msg = 'Product succesfully updated!';
			}
			else //insert new product
			{
				$where = array('product_name' => $data['product_name']);
				$prd_res = $this->Admin_model->selectRecords($where, 'product', 'product_id');	
				if ($prd_res)
					redirectWithMessage('Error: Please enter new product name!', $controller);

				$data['create_date'] = $this->current_date;

				$prd_id = $this->Admin_model->insertData('product', $data);

				if (isset($prd_id['db_error'])) 
					redirectWithMessage('Error: '.$prd_id['msg'], $controller);
				else
					$msg = 'Product inserted successfully!!';
			}

			if ($prd_id) 
			{
				//atatchment data
				$img_data['link_id'] = $prd_id;
				$img_data['atch_type'] = "IMAGE";
				$img_data['atch_for'] = "PRODUCT";

				if ($old_prd_id) 
				{
					//Copy all images from one product folder to another product folder
					$from_folder = PRODUCT_ATTATCHMENTS_PATH.$old_prd_id;
					$to_folder = PRODUCT_ATTATCHMENTS_PATH.$prd_id;
					$files = $this->cloneData($from_folder, $to_folder);

					//insert images into the database
					if (!$files) 
						die('Error: Unable to copy images');
					else
					{
						foreach ($files as $file) 
						{
							$file_to_go = str_replace(PRODUCT_ATTATCHMENTS_PATH.$old_prd_id.'/', "", $file);
							$img_data['atch_url'] = $file_to_go;

							$isInserted = $this->Admin_model->insertData('attatchments', $img_data);
							if (isset($isInserted['db_error'])) 
								redirectWithMessage('Error: '.$isInserted['msg'], $controller);
						}
					}
				}
				else
				{
					//product folder attachment path
					$folder = PRODUCT_ATTATCHMENTS_PATH.$prd_id;

					//insert product images
					$isUploaded = $this->upload_image($folder, $img_data);
					if (isset($isUploaded['db_error'])) 
						redirectWithMessage('Error: '.$isUploaded['msg'], $controller);
				}

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
						
						if (isset($prd_att_res['db_error'])) 
							redirectWithMessage('Error: '.$prd_att_res['msg'], $controller);
						else if ($prd_att_res) //update attribute value
						{
							$condition = array('value_id' => $prd_att_res['result'][0]['value_id']);
							$isUpdated = $this->Admin_model->updateData($tbl_name, $att_values_data, $condition);
							if (isset($isUpdated['db_error'])) 
								redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
						}
						else //insert attribute value
							$this->Admin_model->insertData($tbl_name, $att_values_data);
					}
				}

				//update product varient values
				$this->updateProductVarientValue();

				//delete all old tags of product
				$isDeleted = $this->Admin_model->deleteRecord('product_tags', array('prd_id' => $prd_id));
				if (isset($isDeleted['db_error'])) 
					redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

				//insert product tags
				if ($prd_tags) 
				{
					foreach ($prd_tags as $prd_tag_value)
					{
						$isInserted = $this->Admin_model->insertData('product_tags', array('prd_id' => $prd_id, 'tag_id' => $prd_tag_value));

						if (isset($isInserted['db_error'])) 
							redirectWithMessage('Error: '.$isInserted['msg'], $controller);
					}
				}

				if ($req_prd_id) 
				{
					$listing_data = $this->Admin_model->selectRecords(array('req_prd_id' => $req_prd_id), 'product_listing', 'listing_id');
					
					if (isset($listing_data['db_error'])) 
						redirectWithMessage('Error: '.$listing_data['msg'], $controller);
					else if ($listing_data) 
						$this->Admin_model->updateData('product_listing', array('product_id' => $prd_id), array('req_prd_id' => $req_prd_id));
					else
						$this->Admin_model->insertData('product_listing', array('req_prd_id' => $req_prd_id, 'product_id' => $prd_id, 'merchant_id' => $merchant_id));

					$isUpdated = $this->Admin_model->updateData('requested_product', array('status' => 'CREATED'), array('request_id' => $req_prd_id));
					if (isset($isUpdated['db_error'])) 
						redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
				}

				//insert product key features
				if ($key_features) 
				{
					$key_feature_data = array();
					$key_feature_data['product_id'] = $prd_id;

					foreach ($key_features as $key_feature_value)
					{
						$key_feature_data['feature'] = $key_feature_value;
						$key_feature_id = $this->Admin_model->insertData('product_key_features', $key_feature_data);

						if (isset($key_feature_id['db_error'])) 
							redirectWithMessage('Error: '.$key_feature_id['msg'], $controller);
						else if (!$key_feature_id)
							redirectWithMessage('Error: Unable to insert product feature!', $controller);
					}
				}

				$isAddedHTMLFile = $this->addHTMLFiles($prd_id, 'PRODUCT');

				if (!$isAddedHTMLFile) 
					$msg = 'Error: unable to perform action for HTML Files!';
			}
			else
			{
				$msg = 'Error: Unable to insert!';
				$controller = 'addProduct';
			}

			redirectWithMessage($msg, $controller);
		}
		else
			redirectWithMessage('Error: All fields are required!', 'addProduct');
	}

	public function attatchments($link_id, $atch_for)
	{
		$this->isLoggedIn();

		$tbl_name = 'attatchments';
		$columns  = 'atch_id, atch_url, atch_type';
		$where = array('link_id' => $link_id, 'atch_for' => $atch_for);
		$atch_res = $this->Admin_model->selectRecords($where, $tbl_name, $columns);

		if ($atch_res['result']) 
			return $atch_res['result'];
		else
			return FALSE;
	}

	public function productDetail($prd_id)
	{
		$this->isLoggedIn();

		if ($prd_id) 
		{	
			//get product
			$result = $this->Admin_model->products(array('product_id' => $prd_id));

			$prd_res = $result[0];
			$prd_res['status'] = TRUE;
			$prd_res['images'] = array();
			$prd_res['brands'] = array();
			$prd_res['categories'] = array();
			$prd_res['product_tags'] = array();
			$prd_res['tags'] = array();
			$prd_res['product_images_dir'] = $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$prd_id;
			$prd_res['page_label'] = 'Edit product detail';

			//get product images
			$prd_imgs = $this->attatchments($prd_id, "PRODUCT");
			if ($prd_imgs) 
				$prd_res['images'] = $prd_imgs;

			//get all brands			
			$brands_result = $this->getAllBrands();	
			if (isset($brands_result['db_error'])) 
				return $brands_result;
			else if ($brands_result)
				$prd_res['brands'] = $brands_result;

			//get all categories			
			$cat_result = $this->getAllCategories();	
			if ($cat_result)
				$prd_res['categories'] = $cat_result;

			//get product varients
			$prd_res['product_varients'] = false;
			
			if ($prd_res['hasVarient'] == 1) 
			{
				//get product varients
				$vrnt_res = $this->Admin_model->productVarients($prd_id);
				if ($vrnt_res)
				{
					//create array for varient values
					$newArray = array();
					
					foreach($vrnt_res as $val)
					{
					    $newKey = $val['att_name'];
					    $newArray[$newKey][] = $val;
					}

					$prd_res['product_varients'] = $newArray;
				}
			}

			//get product tags
			$tags_res = $this->Admin_model->productTags($prd_id);
			if ($tags_res) 
				$prd_res['product_tags'] = $tags_res;

			$tags = $this->Admin_model->selectRecords("", "tags", "*");	
			if ($tags['result']) 
				$prd_res['tags'] = $tags['result'];

			return $prd_res;
		}
	}

	public function editProduct($prd_id, $page_label)
	{
		$this->isLoggedIn();
		$controller = 'products';

		if ($prd_id) 
		{
			$prd_res = $this->productDetail($prd_id);
			if (isset($prd_res['db_error'])) 
				redirectWithMessage('Error: '.$prd_res['msg'], 'products');

			$prd_res['page_label'] = $page_label;
			$prd_res['attributes'] = $this->getAllAttributes();
			if (isset($prd_res['attributes']['db_error'])) 
				redirectWithMessage('Error: '.$prd_res['attributes']['msg'], $controller);

			$prd_res['key_features'] = $this->Admin_model->selectRecords(array('product_id' => $prd_id), 'product_key_features', '*');
			if (isset($prd_res['key_features']['db_error'])) 
				redirectWithMessage('Error: '.$prd_res['key_features']['msg'], $controller);

			$prd_res['html_files'] = $this->Admin_model->selectRecords(array('link_id' => $prd_id, 'linked_type' => 'PRODUCT'), 'html_files', 'html_file, html_file_id');
			if (isset($prd_res['html_files']['db_error'])) 
				redirectWithMessage('Error: '.$prd_res['html_files']['msg'], $controller);

			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/addProduct', $prd_res);
			$this->load->view('admin/include/footer');
			die;
		}
	}

	public function getProductDetail($prd_id = '', $sel_id, $list_id)
	{
		$this->isLoggedIn();

		if ($prd_id) 
		{
			$prd_res = $this->productDetail($prd_id);
			if (isset($prd_res['db_error'])) 
				redirectWithMessage('Error: '.$prd_res['msg'], 'products');

			$prd_res['seller_id'] = $sel_id;
			$prd_res['product_listing'] = array();
			
			if ($list_id)
			{
				$product_listing = $this->Admin_model->selectRecords(array('listing_id' => $list_id), 'product_listing', '*');
				$prd_res['product_listing'] = $product_listing['result'];
			}
			else
			{
				$seller_default_values = $this->Admin_model->selectRecords(array('merchant_id' => $sel_id), 'merchant', 'finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, replacement_available, replacement_terms, return_available, return_policy, seller_offering');

				if ($seller_default_values)
					$prd_res['seller_default_values'] = $seller_default_values['result'][0];
			}
			
			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/productDetail', $prd_res);
			$this->load->view('admin/include/footer');
			die;
		}
	}

	public function fillListingDetailOfRequestedProduct($req_prd_id)
	{
		if ($req_prd_id) 
		{
			$data = array();
			$data['req_prd_id'] = $req_prd_id;

			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/fillListingDetailOfRequestedProduct', $data);
			$this->load->view('admin/include/footer');
			die;
		}
		else
			redirectWithMessage('Error: Requested product id could not found!', 'getAllProducts/'.$_SESSION['merchant_id']);
	}

	//delete attatchment
	public function deleteAttactchment( $atch_url, $controller, $id )
	{
		$this->isLoggedIn();

		if ($controller == "editUser")
		{
			$redirect_path = $controller.'/'.$id.'?edit';
			$atch_sel_id = explode('-', $atch_url);
			$atch_url = $atch_sel_id[0];
			$id = $atch_sel_id[1];
			$folder_name = SELLER_ATTATCHMENTS_PATH;
		}
		else
			$redirect_path = $controller.'/'.$id.'/edit';

		//delete from the folder
		$tbl_name = 'attatchments';
		$where = array('atch_url' => $atch_url);
		$this->Admin_model->deleteRecord($tbl_name, $where);

		if ($controller == "editProduct")
		{
			$folder_name = PRODUCT_ATTATCHMENTS_PATH;
			$this->updateTableDate('product', array('product_id' => $id));
		}
		else if ($controller == "editCategory")
		{
			$folder_name = CATEGORY_ATTACHMENT_PATH;
			$this->updateTableDate('product_category', array('category_id' => $id));
		}
		else if ($controller == "editBrand")
		{
			$folder_name = BRAND_ATTATCHMENTS_PATH;
			$this->updateTableDate('brand', array('brand_id' => $id));
		}
		else if ($controller == "seller")
		{
			$folder_name = SELLER_ATTATCHMENTS_PATH;
			$this->updateTableDate('merchant', array('merchant_id' => $id));
		}
		else if ($controller == "editOffer")
		{
			$folder_name = OFFER_ATTATCHMENTS_PATH;
			$this->updateTableDate('product_listing_offer', array('offer_id' => $id));
		}

		//delete from the folder
		unlink($folder_name.$id.'/'.$atch_url);

		//redirected function
		redirectWithMessage('Attatchment deleted successfully!', $redirect_path);
	}

	//add category method
	public function addAttribute()
	{
		$this->isLoggedIn();

		$att_id = $this->input->post('att_id');
		$data['att_name'] = $this->input->post('att_name');
		$controller = "page/attributes";

		if (!empty($att_id)) 
		{
			$condition = array('att_id' => $att_id);
			$this->Admin_model->updateData('attribute_name', $data, $condition);

			$msg = "Successfully updated!";
		}
		else
		{
			$att_id = $this->Admin_model->insertData('attribute_name', $data);

			if ($att_id['db_error'])
				$msg = 'Error: '.$att_id['msg'];
			else if ($att_id) 
				$msg = 'Succesfully inserted!';
			else
				$msg = 'Error: Unable to insert!';
		}

		redirectWithMessage($msg, $controller);
	}

	public function editAttribute($att_id)
	{
		$this->isLoggedIn();

		if ($att_id) 
		{
			$data = array();
			$data['page_label'] = 'edit';
				
			$att_res = $this->getAllAttributes($att_id);	
			if ( isset($att_res['db_error']) ) 
				redirectWithMessage('Error: '.$att_res['msg'], 'page/attributes');

			if ($att_res)
			{
				$data['success'] = true;
				$data['data'] = $att_res[0];
			}
			else
			{
				$data['success'] = false;
				$data['data'] = array();
			}
			
			$this->load->view('admin/include/header');
			$this->load->view('admin/include/leftbar');
			$this->load->view('admin/addAttribute', $data);
			$this->load->view('admin/include/footer');
			die;
		}
	}

	public function deleteAttribute( $att_id = '' )
	{
		$this->isLoggedIn();

		if ($att_id) 
		{
			$cat_ids_res = $this->Admin_model->selectRecords(array('att_id' => $att_id), 'category_attribute_mp', 'cat_id');

			$isDeleted = $this->Admin_model->deleteRecord('attribute_name', array('att_id' => $att_id));
			if ( isset($isDeleted['db_error']) ) 
				redirectWithMessage('Error: '.$isDeleted['msg'], 'page/attributes');

			//update category table row for update_date
			if ( $cat_ids_res ) 
			{
				foreach ($cat_ids_res['result'] as $cat_id) 
					$this->updateTableDate('product_category', array('category_id' => $cat_id['cat_id']));
			}

			$msg = 'Attribute deleted successfully!';
		}
		else
			$msg = 'Error: Attribute id could not found!';

		redirectWithMessage($msg, 'page/attributes');
	}

	public function deleteProductKeyFeature($feature_id = '', $prd_id = '')
	{
		$this->isLoggedIn();
			
		if ($feature_id && $prd_id) 
		{
			$controller = 'editProduct/'.$prd_id.'/edit';
			$tbl_name = 'product_key_features';
			$where = array('feature_id' => $feature_id);
			$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);
			if ( isset($isDeleted['db_error']) ) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

			$this->updateTableDate('product', array('product_id' => $prd_id));
			$msg = 'Feature deleted successfully!';
		}
		else
			$msg = 'Error: feature id or product id could not found!';

		redirectWithMessage($msg, 'products');
	}

	public function deleteSellerOffering($offering_id = '', $merchant_id = '')
	{
		$this->isLoggedIn();
			
		if ($offering_id && $merchant_id) 
		{
			$controller = 'seller/'.$merchant_id.'/edit';
			$tbl_name = 'merchant_offering';
			$where = array('offering_id' => $offering_id);
			$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);
			if (isset($isDeleted['db_error'])) 
				redirectWithMessage('Error: '.$isDeleted['msg'], $controller);

			$this->updateTableDate('merchant', array('merchant_id' => $merchant_id));
			$msg = 'Seller offering deleted successfully!';
		}
		else
			$msg = 'Error: offering id or merchant id could not found!';

		if ($_COOKIE['site_code'] == 'admin') 
			redirectWithMessage($msg, 'sellers/sellersTable');
		else
			redirectWithMessage($msg, 'seller/'.$merchant_id.'/edit');
	}

	public function addProductVarient()
	{
		$this->isLoggedIn();

		$cat_id = $this->input->post('cat_id');
		$prd_id = $this->input->post('prd_id');
		$att_id = $this->input->post('att_id');
		$page_label = $this->input->post('page_label');
		$vrnt_vals = $this->input->post('vrnt_vals');

		$tbl_name = 'category_attribute_mp';
		$columns  = 'mp_id';
		$where = array('cat_id' => $cat_id, 'att_id' => $att_id);

		$mp_res = $this->Admin_model->selectRecords($where, $tbl_name, $columns);
		
		if ($mp_res['result']) 
		{
			$tbl_name = "category_attribute_value";
			$where = array('cat_att_mp_id' => $mp_res['result'][0]['mp_id'], 'prd_id' => $prd_id);
			$this->Admin_model->deleteRecord($tbl_name, $where);
		}

		$data = array();
		$data['prd_id'] = $prd_id;
		$data['att_id'] = $att_id;

		if ($vrnt_vals) 
		{
			foreach ($vrnt_vals as $vrnt_key => $vrnt_value) 
			{
				$data['att_value'] = $vrnt_value;
				$this->Admin_model->insertData('product_varient', $data);
			}
		}

		//update product table for hasVarient
		$prd_data = array();
		$condition = array('product_id' => $prd_id);
		$prd_data['hasVarient'] = 1;
		$prd_data['update_date'] = $this->current_date;
	
		$this->Admin_model->updateData('product', $prd_data, $condition);
		
		$controller = 'admin/editProduct/'.$prd_id.'/'.$page_label;
		redirectWithMessage('Attribute varient added successfully!!!', $controller);
	}
	
	public function addAddress()
	{
		$user_id = $this->input->post('user_id');
		$merchant_id = ($this->input->post('merchant_id')) ? $this->input->post('merchant_id') : $_SESSION['merchant_id'];

		if ($user_id && $merchant_id) 
		{
			$address_id = $this->insertAddress($user_id);
			if ($address_id) 
				$msg = 'Merchat address update successfully!!!!';
			else
				$msg = "Error: lat, long are not in correct format.";

			$controller = 'page/addressManagement?user_id='.$user_id.'&merchant_id='.$merchant_id;
		}
		else
		{
			$msg = 'Error: user id and merchant id is required!';
			$controller = 'dashboard';
		}
		
		redirectWithMessage($msg, $controller);
	}

	public function addProductKeyFeature()
	{
		$feature_id = $this->input->post('feature_id');
		$product_id = $this->input->post('product_id');
		$feature = $this->input->post('feature');

		if ($feature_id && $product_id && $feature) 
		{
			$condition = array('feature_id' => $feature_id);
			$this->Admin_model->updateData('product_key_features', array('feature' => $feature), $condition);

			$msg = 'Feature updated successfully!';
			$controller = 'editProduct/'.$product_id.'/edit';
		}
		else
		{
			$msg = 'Error: feature id, product id not found!';
			$controller = 'products';
		}

		redirectWithMessage($msg, $controller);
	}

	public function addSellerOffering()
	{
		$offering_id = $this->input->post('offering_id');
		$merchant_id = $this->input->post('merchant_id');
		$offering = $this->input->post('offering');

		if ($offering_id && $merchant_id && $offering) 
		{
			$condition = array('offering_id' => $offering_id);
			$this->Admin_model->updateData('merchant_offering', array('offering' => $offering), $condition);

			$msg = 'Offering updated successfully!';
			$controller = 'seller/'.$merchant_id.'/edit';
		}
		else
		{
			$msg = 'Error: offering id, merchant id not found!';
			$controller = 'sellers/sellersTable';
		}

		redirectWithMessage($msg, $controller);
	}

	//add/update user or merchant address
	public function insertAddress($user_id)
	{
		$address_id = $this->input->post('address_id');

		//address detail
		$address_data['address_line_1'] = $this->input->post('line1');
		$address_data['address_line_2'] = $this->input->post('line2');
		$address_data['landmark'] = $this->input->post('landmark');
		$address_data['locality'] = '';
		$address_data['pin'] = $this->input->post('pin');
		$address_data['is_default_address'] = $this->input->post('is_default_address');
		$address_data['contact'] = $this->input->post('contact');
		$address_data['business_days'] = $this->input->post('business_days');
		$address_data['business_hours'] = $this->input->post('business_hours');
		$address_data['latitude'] = $this->input->post('lat');
		$address_data['longitude'] = $this->input->post('long');
		$address_data['country_id'] = $this->input->post('country_id');
		$address_data['state_id'] = $this->input->post('state_id');
		$address_data['city_id'] = $this->input->post('city_id');
		$address_data['update_date'] = $this->current_date;
		
		if($address_data['contact'] && !preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $address_data['contact']))
            return false;

		//update address detail
		if ($address_id) 
		{
			$condition = array('address_id' => $address_id);
			$this->Admin_model->updateData('address', $address_data, $condition);

			return $address_id;
		}
		else
		{
			$address_data['userId'] = $user_id;
			$address_data['create_date'] = $this->current_date;

			$address_id = $this->Admin_model->insertData('address', $address_data);

			if ($address_id) 
				return $address_id;
			else
				return false;
		}
	}

	public function sellers($type)
	{
		$this->isLoggedIn();

		$data['pageName'] = $type;
		$controller = 'dashboard';

		if ($this->sellers)
		{
			$data['success'] = true;
			$data['data'] = $this->sellers;	
			$data['merchant_offers'] = $this->getOffer();

			if (isset($data['merchant_offers']['db_error'])) 
				echo "<script>window.alert('".$data['merchant_offers']['msg']."');</script>";
			else
			{
				$i = 0;

				foreach ($this->sellers as $value) 
				{
					$address_res = $this->getUserAddress(array('address.userId' => $value['userId']));
					if (isset($address_res['db_error'])) 
						redirectWithMessage('Error: '.$address_res['msg'], $controller);
					else if ($address_res) 
					{
						$j = 0;
						$data['data'][$i]['address'] = $address_res['result'];
						foreach ($address_res['result'] as $add_value) 
						{
							$country = $this->getCountry($add_value['country_id']);
							if (isset($country['db_error'])) 
								redirectWithMessage('Error: '.$country['msg'], $controller);
							
							$state = $this->getState($add_value['state_id']);
							if ( isset($state['db_error']) ) 
								redirectWithMessage('Error: '.$state['msg'], $controller);
							
							$city = $this->getcity('', '', $add_value['city_id']);
							if ( isset($city['db_error']) ) 
								redirectWithMessage('Error: '.$city['msg'], $controller);

							$data['data'][$i]['address'][$j]['country_name'] = $country['result'][0]['name'];
							$data['data'][$i]['address'][$j]['state_name'] = $state['result'][0]['name'];
							$data['data'][$i]['address'][$j]['city_name'] = $city['result'][0]['name'];

							$j++;
						}
					}
					else
						$data['data'][$i]['address'] = array();

					$i++;
				}
			}
		}
		else
		{
			$data['success'] = false;
			$data['data'] = array();
		}

		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		
		if ($type == 'offers') 
			$this->load->view('admin/offers', $data);
		else	
			$this->load->view('admin/sellers', $data);
		
		$this->load->view('admin/include/footer');
		die;
	}

	public function updateSellerImages()
	{
		//select seller images from table
		$seller_images = $this->Admin_model->selectRecords(array('atch_type' => 'IMAGE', 'atch_for' => 'SELLER'), 'attatchments', 'atch_url, atch_id, link_id', array('link_id' => 'ASC'));
		if (isset($seller_images['db_error'])) 
		{
			echo 'Error: '.$seller_images['msg'];
			die;
		}
		else if ($seller_images) 
		{
			//echo "<pre>"; print_r($seller_images['result']); die;

			$count = 0;
			$prev_link_id = false;
			$not_found_files = array();
			foreach ($seller_images['result'] as $value) 
			{
				if ($value['link_id'] == $prev_link_id) 
					$count++;
				else
					$count = 1;

				$prev_link_id = $value['link_id'];
				$img = explode(".", $value['atch_url']);
				$new_file_name = 'file'.$count.'_'.rand().'.'.$img[1];

				//update image name in table
				$this->Admin_model->updateData('attatchments', array('atch_url' => $new_file_name), array('atch_id' => $value['atch_id']));

				if (is_file(SELLER_ATTATCHMENTS_PATH.$prev_link_id."/".$value['atch_url'])) 
					rename(SELLER_ATTATCHMENTS_PATH.$prev_link_id."/".$value['atch_url'], SELLER_ATTATCHMENTS_PATH.$prev_link_id.'/'.$new_file_name);
				else
				{
					array_push($not_found_files, $prev_link_id."/".$value['atch_url']);

					/*$isDeleted = $this->Admin_model->deleteRecord('attatchments', array('atch_id' => $value['atch_id']));

					if (isset($isDeleted['db_error'])) 
						echo 'Error: '.$isDeleted['msg'];*/
				}
			}
		}

		echo "Updated!";
	}

	public function seller($sel_id, $page_label)
	{
		$this->isLoggedIn();

		$seller_data['data'] = array();
		$sel_res = $this->Admin_model->sellers($sel_id);
		
		if ($sel_res)
		{
			$seller_data['success'] = true;
			$seller_data['data'] = $sel_res[0];	
			$seller_data['data']['address'] = array();
			$seller_data['data']['seller_images_dir'] = $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$sel_id;

			//get user address
			$address_res = $this->getUserAddress(array('address.userId' => $sel_res[0]['userId']));
			if (isset($address_res['db_error'])) 
				redirectWithMessage('Error: '.$address_res['msg'], 'sellers/sellersTable');
			else if ($address_res) 
				$seller_data['data']['address'] = $address_res['result'];
			
			//get product images
			$seller_imgs = $this->attatchments($sel_id, "SELLER");
			if ($seller_imgs) 
				$seller_data['data']['images'] = $seller_imgs;

			//get countries
			$countries = $this->getCountry();
			if (isset($countries['db_error'])) 
				redirectWithMessage('Error: '.$countries['msg'], 'sellers/sellersTable');
			else if ($countries['result'])
				$seller_data['countries'] = $countries['result'];

			//get seller offerings
			$seller_offering = $this->Admin_model->selectRecords(array('merchant_id' => $sel_id), 'merchant_offering', 'offering_id, offering');
			if (isset($seller_offering['db_error'])) 
				redirectWithMessage('Error: '.$seller_offering['msg'], $controller);
			if ($seller_offering) 
				$seller_data['data']['seller_offering'] = $seller_offering;
			else
				$seller_data['data']['seller_offering'] = false;
		}
		else
			$seller_data['success'] = false;

		$seller_data['page_label'] = $page_label;
		
		$this->load->view('admin/include/header');
		$this->load->view('admin/include/leftbar');
		$this->load->view('admin/addSeller', $seller_data);
		$this->load->view('admin/include/footer');
		die;
	}

	public function changeSellerStatus($sel_id, $status, $field)
	{
		$this->isLoggedIn();

		$controller = 'sellers/sellersTable';
		$condition = array('merchant_id' => $sel_id);
		$data = array($field => $status, 'update_date' => $this->current_date);
		$isUpdated = $this->Admin_model->updateData('merchant', $data, $condition);
		
		if (isset($isUpdated['db_error'])) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		else
			redirectWithMessage('Merchant status changed successfully!!!', $controller);
	}

	//change status of review where review for merchant/product
	public function changeReviewStatus($review_id, $status, $status_for)
	{
		$this->isLoggedIn();

		$controller = 'review/'.$status_for;
		$condition = array('review_id' => $review_id);
		$data = array('status' => $status, 'update_date' => $this->current_date);
		
		if ($status_for == 'merchant') 
			$tbl_name = 'merchant_review';
		else if ($status_for = 'product') 
			$tbl_name = 'product_review';

		$isUpdated = $this->Admin_model->updateData($tbl_name, $data, $condition);

		if (isset($isUpdated['db_error'])) 
			redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
		else
			redirectWithMessage('Review status changed successfully!!!', $controller);
	}

	//delete review where review for merchant/product
	public function deleteReview($review_id, $review_for)
	{
		$this->isLoggedIn();

		$controller = 'review/'.$review_for;
		
		if ($review_for == 'merchant') 
			$tbl_name = 'merchant_review';
		else if ($review_for = 'product') 
			$tbl_name = 'product_review';

		$where = array('review_id' => $review_id);
		$isDeleted = $this->Admin_model->deleteRecord($tbl_name, $where);
		if (isset($isDeleted['db_error'])) 
			redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
		else
			redirectWithMessage('Review deleted successfully!', $controller);
	}

	public function getUserAddress($where="")
	{
		$this->isLoggedIn();
		$address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';
		$address_res = $this->Admin_model->getUserAddress($where, $address_columns);

		if ($address_res) 
			return $address_res;
		else
			return FALSE;
	}

	public function addListing()
	{
		$this->isLoggedIn();

		$req_prd_id = $this->input->post('req_prd_id');
		$merchant_id = $this->input->post('merchant_id');
		$list_id = $this->input->post('listing_id');

		$listing_data = array();
		$listing_data['merchant_id'] = $merchant_id;
		$listing_data['list_price'] = $this->input->post('list_price');
		$listing_data['finance_available'] = $this->input->post('finance_available');
		$listing_data['finance_terms'] = $this->input->post('finance_terms');
		$listing_data['home_delivery_available'] = $this->input->post('home_delievery');
		$listing_data['home_delivery_terms'] = $this->input->post('delievery_terms');
		$listing_data['installation_available'] = $this->input->post('installation_available');
		$listing_data['installation_terms'] = $this->input->post('installation_terms');
		$listing_data['in_stock'] = $this->input->post('in_stock');
		$listing_data['will_back_in_stock_on'] = $this->input->post('back_in_stock');
		$listing_data['replacement_available'] = $this->input->post('replacement_available');
		$listing_data['replacement_terms'] = $this->input->post('replacement_terms');
		$listing_data['return_available'] = $this->input->post('return_available');
		$listing_data['return_policy'] = $this->input->post('return_policy');
		$listing_data['seller_offering'] = $this->input->post('seller_offering');
		$listing_data['meta_description'] = $this->input->post('meta_description');
		$listing_data['meta_keyword'] = $this->input->post('meta_keyword');
		$listing_data['update_date'] = $this->current_date;
		
		if ($this->input->post('prd_id'))
			$listing_data['product_id'] = $this->input->post('prd_id');
		else if($req_prd_id)
			$listing_data['req_prd_id'] = $req_prd_id;

		$controller = 'getAllProducts/'.$merchant_id;

		if ($list_id) 
		{
			if ($_COOKIE['site_code'] == "seller") 
				$listing_data['isVerified'] = 1;

			$condition = array('listing_id' => $list_id);
			$isUpdated = $this->Admin_model->updateData('product_listing', $listing_data, $condition);

			$msg = "Detail updated successfully!!";
			
			if (isset($isUpdated['db_error'])) 
				redirectWithMessage('Error: '.$isUpdated['msg'], $controller);		
		}
		else
		{
			if ($_COOKIE['site_code'] == "seller") 
				$listing_data['isVerified'] = 1;
			else
				$listing_data['isVerified'] = 0;

			$listing_data['create_date'] = $this->current_date;

			$list_id = $this->Admin_model->insertData('product_listing', $listing_data);

			if ($list_id) 
			{
				$msg = "Detail inserted successfully!!";
				
				if($req_prd_id)
				{
					$isUpdated = $this->Admin_model->updateData('requested_product', array('isLinked' => 1), array('request_id' => $req_prd_id));

					if (isset($isUpdated['db_error'])) 
						redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
				}	
			}
			else
				$msg = "Error: unable to insert detail.";
			
			if (isset($list_id['db_error'])) 
				redirectWithMessage('Error: '.$list_id['msg'], $controller);
		}

		//get product varient prices from db
		$db_vrnt_price_array = array();
		$db_vrnt_price = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'product_varient_price', '*');

		if (isset($db_vrnt_price['db_error'])) 
			redirectWithMessage('Error: '.$db_vrnt_price['msg'], $controller);

		if ($db_vrnt_price['result']) 
		{
			foreach ($db_vrnt_price['result'] as $db_vrnt_prc_value) 
				array_push($db_vrnt_price_array, $db_vrnt_prc_value['vrnt_id']);
		}

		//get param varient ids and prices
		$vrnt_ids = $this->input->post('vrnt_id');
		$vrnt_prices = $this->input->post('vrnt_price');

		if (!$vrnt_ids)
			$vrnt_ids = array();
		
		//del varient prices array
		$del_vrnt_price = array_diff($db_vrnt_price_array, $vrnt_ids);

		//insert/update varient prices
		$ins_update_vrnt_price = array_intersect($vrnt_ids, $db_vrnt_price_array);

		//array for insert and update product varient prices
		$vrnt_id_price_array = array();
		if ($vrnt_ids) 
		{
			$i = 0;
			foreach ($vrnt_ids as $vrnt_id) 
			{
				if ($vrnt_prices[$i]) 
					array_push($vrnt_id_price_array, $vrnt_id.'-'.$vrnt_prices[$i]);
				else
					array_push($del_vrnt_price, $vrnt_id);

				$i++;
			}
		}

		//delete product varient price(s)
		if (count($del_vrnt_price)>0) 
		{
			foreach ($del_vrnt_price as $del_vrnt) 
			{
				$where = array('vrnt_id' => $del_vrnt, 'merchant_id' => $merchant_id, 'prd_list_id' => $list_id);
				$isDeleted = $this->Admin_model->deleteRecord('product_varient_price', $where);

				if (isset($isDeleted['db_error'])) 
					redirectWithMessage('Error: '.$isDeleted['msg'], $controller);
			}
		}

		if (count($vrnt_id_price_array)>0) 
		{
			foreach ($vrnt_id_price_array as $vrnt_id_price_value) 
			{
				$values = explode('-', $vrnt_id_price_value);
				$vrnt_id = $values[0];
				$vrnt_price = $values[1];

				$vrnt_prc_data['vrnt_price'] = $vrnt_price;

				if (in_array($vrnt_id, $ins_update_vrnt_price)) 
				{
					$condition = array('vrnt_id' => $vrnt_id, 'merchant_id' => $merchant_id, 'prd_list_id' => $list_id);
					$isUpdated = $this->Admin_model->updateData('product_varient_price', $vrnt_prc_data, $condition);

					if (isset($isUpdated['db_error'])) 
						redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
				}
				else
				{
					$vrnt_prc_data['merchant_id'] = $merchant_id;
					$vrnt_prc_data['vrnt_id'] = $vrnt_id;
					$vrnt_prc_data['prd_list_id'] = $list_id;

					$vrnt_id = $this->Admin_model->insertData('product_varient_price', $vrnt_prc_data);

					if (isset($vrnt_id['db_error'])) 
						redirectWithMessage('Error: '.$vrnt_id['msg'], $controller);

					if (!$vrnt_id) 
					{
						$msg = "Error: unable to insert varient prices.";
						break;
					}

				}
			}
		}

		redirectWithMessage($msg, $controller);
	}

	public function review($review_for = '')
	{
		$data = array();
		$controller = 'dashboard';

		if ($review_for) 
		{
			if ($review_for == 'merchant') 
			{
				$data['page_label'] = 'merchant';
				$data['reviews'] = $this->Admin_model->merchantReviews();
			}
			else if ($review_for == 'product')
			{
				$data['page_label'] = 'product';
				$data['reviews'] = $this->Admin_model->productReviews();
			}

			if (isset($data['reviews']['db_error'])) 
				redirectWithMessage('Error: '.$data['reviews']['msg'], $controller);
			else
			{
				$this->load->view('admin/include/header');
				$this->load->view('admin/include/leftbar');
				$this->load->view('admin/review', $data);
				$this->load->view('admin/include/footer');
				die;
			}
		}
		else
			redirectWithMessage("Error: unable to get reviews.", $controller);
	}

	public function viewReview($review_id = '', $review_for = '')
	{
		$data = array();
		$controller = 'review/'.$review_for;

		if ($review_for) 
		{
			if ($review_for == 'merchant') 
			{
				$data['page_label'] = 'merchant';
				$reviews = $this->Admin_model->merchantReviews(array('review_id' => $review_id));
			}
			else if ($review_for == 'product')
			{
				$data['page_label'] = 'product';
				$reviews = $this->Admin_model->productReviews(array('review_id' => $review_id));
			}

			if (isset($reviews['db_error'])) 
				redirectWithMessage('Error: '.$reviews['msg'], $controller);
			else
			{
				$data['page_type'] = 'view';
				$data['review_data'] = $reviews['result'][0];

				$this->load->view('admin/include/header');
				$this->load->view('admin/include/leftbar');
				$this->load->view('admin/addReview', $data);
				$this->load->view('admin/include/footer');
				die;
			}
		}
		else
			redirectWithMessage("Error: unable to get reviews.", $controller);
	}

	public function merchantSignUp()
	{
		$data = array();
		$countries = $this->getCountry();
		if (isset($countries['db_error'])) 
			redirectWithMessage('Error: '.$countries['msg'], 'merchant');

		$data['countries'] = $countries['result'];

		$this->load->view('admin/merchantSignUp', $data);
	}

	public function insertSellerDefaultValues()
	{
		$data = array();
		$data['finance_available'] = $this->input->post('finance_available');
		$data['finance_terms'] = $this->input->post('finance_terms');
		$data['home_delivery_available'] = $this->input->post('home_delievery');
		$data['home_delivery_terms'] = $this->input->post('delievery_terms');
		$data['installation_available'] = $this->input->post('installation_available');
		$data['installation_terms'] = $this->input->post('installation_terms');
		$data['replacement_available'] = $this->input->post('replacement_available');
		$data['replacement_terms'] = $this->input->post('replacement_terms');
		$data['return_available'] = $this->input->post('return_available');
		$data['return_policy'] = $this->input->post('return_policy');
		$data['seller_offering'] = $this->input->post('seller_offering');
		$data['update_date'] = $this->current_date;

		$condition = array('merchant_id' => $_SESSION['merchant_id']);
		$isUpdated = $this->Admin_model->updateData('merchant', $data, $condition);

		if (isset($isUpdated['db_error'])) 
			redirectWithMessage('Error: '.$isUpdated['msg'], 'dashboard');
		else
			redirectWithMessage("Default values updated successfully.", 'dashboard');
	}

	public function isLoggedIn()
	{
		if (!$_COOKIE['site_code']) 
			redirect(base_url(), 'refresh');

		if (!isset($_COOKIE['token']))
		{
			if ($_COOKIE['site_code'] == "admin") 
			{
				$this->load->view('admin/login');
				die;
			}
			else if ($_COOKIE['site_code'] == "seller") 
				redirect('merchantLoginSignup', 'refresh');
			else
			{
				$this->load->view('welcome_message');
				die;
			}
		}
		else
			$this->isValidToken1();	

		return true;
	}

	//check token is valid or not
	public function isValidToken1()
	{
		if (isset($_COOKIE['token']) && isset($_COOKIE['user_id'])) 
		{
			$isValidToken1 = $this->Admin_model->selectRecords(array('auth_token' => $_COOKIE['token'], 'userId' => $_COOKIE['user_id']), 'user', 'userId');
			if ($isValidToken1)
				return true;
		}
		
		redirectWithMessage('Error: invalid token', 'signout');
	}

	public function acceptRequest()
	{
		$merchant_id = $this->input->post('merchant_id');
		$email = $this->input->post('email');
		$clmd_id = $this->input->post('claimed_id');
		$clmd_business_proof = $this->input->post('clmd_business_proof');
		//$usr_id = $this->addUser();

		//update merchant user id
		//$this->Admin_model->updateData('merchant', array('userId' => $usr_id), array('merchant_id' => $merchant_id));	

		//send mail to seller to confirm there username and password with seller panel login link
        $mail_data = array();
        $mail_data['name'] = $this->input->post('fname');
        $mail_data['establishment_name'] = $this->input->post('establishment_name');
        $mail_data['seller_id'] = $merchant_id;
        $mail_data['email'] = $email;
        $mail_data['code'] = MAIL_CODE_CLAIM_BUSINESS_APPROVED;
        $mail_data['url'] = str_replace("admin", "seller", base_url());
        //$isSend = $this->sendMail($mail_data);

        copy(base_url(TEMP_FOLDER_PATH).$clmd_business_proof, base_url(SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$clmd_business_proof));
        
        //update claimed request with is_clmd_approved = 1
        $merchant_data = array();
        $merchant_data['is_clmd_approved'] = 1;
        $merchant_data['is_verified'] = 1;
        $merchant_data['business_proof'] = $clmd_business_proof;
        $this->Admin_model->updateData('claimed_requests', array('is_clmd_approved' => 1), array('clmd_id' => $clmd_id));

        redirect('page/claimedRequest', 'refresh');
	}
}
