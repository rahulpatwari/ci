<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_controller.php';

class User_controller extends Admin_controller 
{
	function __construct()
    {
        parent::__construct();

        //get categories
        $this->categories = $this->Admin_model->selectRecords('', 'product_category', '*');

        //get categories in tree format
        $parent_categories = $this->Admin_model->selectRecords(array('has_parent' => 0), 'product_category', '*');
        $categories = $parent_categories['result'];

        $i = 0;
        foreach ($categories as $category) 
        {
            $where = array('has_parent' => 1, 'parent_category_id' => $category['category_id']);
            $child_categories = $this->Admin_model->selectRecords($where, 'product_category', '*');

            if ($child_categories) 
                $categories[$i]['child_category'] = $child_categories['result'];
            else
                $categories[$i]['child_category'] = false;

            $i++;
        }
            
        $this->tree_list = $categories;

        //pagination
        $this->limit = 9;
        $this->start = 0;
        $this->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        
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

        //common controller
        $this->common_controller = new Common_controller();

        //site settings
        $this->site_settings = $this->site_settings();
    }
    
    public function Error404()
    {
        $this->output->set_status_header('404');
        
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        
        $this->load->view('user/include/header', $data);
        $this->load->view('error404');
        $this->load->view('user/include/footer');
    }

    public function privacypolicy()
    {
        $this->load->view('user/privacypolicy');
    }

    //load home page
    public function index()
    {
        $data = array();
        $where['current_status'] = 1;
        $where['start_date <= '] = date("Y-m-d h:i:s");
        $where['end_date >= '] = date("Y-m-d h:i:s");
        $data = $this->getOffers($where); //get offers

        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $this->limit = '';
        
        //get latest products
        $data['products'] = $this->getProducts();
        
        //get brands
        $data['brands'] = $this->Admin_model->selectRecords('', 'brand', 'brand_id, name, brand_logo');

        //get sellers
        $data['merchants'] = $this->Admin_model->selectRecords(array('status' => 1, 'establishment_name != ' =>''), 'merchant', 'merchant_id, establishment_name, merchant_logo');
        
        $data['meta_data']['title'] = $this->site_settings['home_page_title'];
        $data['meta_data']['keywords'] = $this->site_settings['home_page_key_words'];
        $data['meta_data']['description'] = $this->site_settings['home_page_meta_description'];

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/index');
        $this->load->view('user/include/footer');
    }

    //load products page
    public function product()
    {
        $data = array();
        $product_ids = array();
        $search_val = $this->input->post('search_val');
        $category_id = isset($_GET['category']) ? $_GET['category'] : $this->input->post('selected_category');
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['merchant_id'])) //get perticular merchant products
        {
            //get products id
            $where = array('merchant_id' => $_GET['merchant_id']);
            $prd_ids = $this->Admin_model->selectRecords($where, 'product_listing', 'product_id');

            if ($prd_ids) 
            {
                foreach ($prd_ids['result'] as $prd_id) 
                {
                    if ($prd_id['product_id'])
                        array_push($product_ids, $prd_id['product_id']);
                }

                //get products
                $where_in['where_column_name'] = 'product_id';
                $where_in['ids'] = $product_ids;
                $data['products'] = $this->getProducts('', $where_in);    
            }
            else
                $data['products'] = false;
        }
        else if (isset($_GET['brand_id'])) //get perticular brand based product 
            $data['products'] = $this->getProducts(array('brand_id' => $_GET['brand_id']));
        else if (!$search_val && $category_id == '') 
            $data['products'] = $this->getProducts();
        else //get search based products
        {
            //get category ids in tree format
            $cat_ids = $this->Admin_model->fetchCategoryIdList($category_id);
            array_push($cat_ids, $category_id);
            
            //get products
            $where_in['where_column_name'] = 'category_id';
            $where_in['ids'] = $cat_ids;
            $data['products'] = $this->getProducts('', $where_in);
        }

        //products meta tag
        $data['meta_data']['title'] = ($this->site_settings['products_meta_title']) ? $this->site_settings['products_meta_title'] : "Products";
        $data['meta_data']['keywords'] = $this->site_settings['products_meta_keywords'];
        $data['meta_data']['description'] = ($this->site_settings['products_meta_description']) ? $this->site_settings['products_meta_description'] : implode(",", array_column($data['products']['result'], 'product_name'));

        //load products view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/products');
        $this->load->view('user/include/footer');
    }

    public function location_setting()
    {
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['city'] = $this->Admin_model->selectRecords('', 'city', 'name, latitude, longitude'); //get all cities
        $data['area'] = $this->Admin_model->selectRecords('', 'area', 'area_name, latitude, longitude'); //get all areas
        
        //location meta tag
        $data['meta_data']['title'] = ($this->site_settings['products_meta_title']) ? $this->site_settings['products_meta_title'] : "";
        $data['meta_data']['keywords'] = $this->site_settings['products_meta_keywords'];
        $data['meta_data']['description'] = ($this->site_settings['products_meta_description']) ? $this->site_settings['products_meta_description'] : '';

        //load products view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/location_setting');
        $this->load->view('user/include/footer');
    }

    public function help_support()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $body = "Name: ".$name."<br />
                Email: ".$email."<br />
                Message: ".$message;
        $isSend = $this->common_controller->sendEmail('', $subject, $body);

        if ($isSend) 
            echo "<script>window.alert('Mail has been sent');</script>";
        else
            echo "<script>window.alert('Unable to send mail');</script>";

        redirect(base_url(), 'refresh');
    } 

    //get products
    public function getProducts($where='', $where_in='')
    {
        $data = false;
        $products = $this->Admin_model->selectRecords($where, 'product', 'SQL_CALC_FOUND_ROWS product_id, product_name, mrp_price, description', array(), $this->limit, $this->start, array(), false, $where_in);
        
        if ($products) 
        {
            $data = $products;

            $i = 0;
            foreach ($products['result'] as $product) 
            {
                $attatchments = array();

                //get product images
                $product_id = $product['product_id'];
                $product_imgs = $this->attatchments($product_id, "PRODUCT");

                if ($product_imgs['result']) 
                {
                    foreach ($product_imgs['result'] as $atch_value) 
                        array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                    
                    if ($attatchments)
                        $data['result'][$i]['products_images'] = $attatchments;
                }
                else
                    $data['result'][$i]['products_images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

                $i++;
            }

            if (isset($products['count']))
                $data['paging'] = $this->createPagingArray($products['count']);
        }

        return $data;
    }

    public function product_detail()
    {
        if (isset($_GET['category']) && !isset($_GET['prd_id'])) 
        {
            $this->product();
            die;
        }
        
        $data = array();
        $attatchments = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['product'] = false;
        $key_features = array();

        if (isset($_GET['prd_id'])) 
        {
            $product_id = $_GET['prd_id']; // product id

            //get product detail
            $where = array('product_id' => $product_id);
            $product_detail = $this->Admin_model->selectRecords($where, 'product', 'category_id, product_id, product_name, mrp_price, description, brand_id, in_the_box, meta_keyword, meta_description');

            //product detail
            $data['product'] = $product_detail['result'][0];

            //product meta data
            $data['meta_data']['title'] = $data['product']['product_name']." | ".$this->site_settings['product_title_suffix'];
            $data['meta_data']['keywords'] = $data['product']['meta_keyword'];
            $data['meta_data']['description'] = ($data['product']['meta_description']) ? $data['product']['meta_description'] : $data['product']['description'];

            //get brand name
            $where = array('brand_id' => $product_detail['result'][0]['brand_id']);
            $brand = $this->Admin_model->selectRecords($where, 'brand', 'name');
            $data['product']['brand_name'] = $brand['result'][0]['name'];

            //get product attributes
            $prd_att_res = $this->Admin_model->productAttributes($product_id);
            if ($prd_att_res) 
                $data['product']['specifications'] = $prd_att_res;
            else
                $data['product']['specifications'] = false;

            //get product varients
            $prd_att_res = $this->Admin_model->productVarients($product_id);
            if ($prd_att_res) 
            {
                //create grouped array for varients
                $newArray = array();
                foreach($prd_att_res as $val){
                    $newKey = $val['att_name'];
                    $newArray[$newKey][] = $val['att_value'];
                }

                $data['product']['varients'] = $newArray;
            }
            else
                $data['product']['varients'] = false;

            //get product key features
            $prd_feature = $this->Admin_model->selectRecords(array('product_id' => $product_id), 'product_key_features', 'feature');
            if ($prd_feature) 
            {
                foreach ($prd_feature['result'] as $feature_value) 
                    array_push($key_features, $feature_value['feature']);
            }

            $data['product']['key_features'] = $key_features;

            //get product images
            $product_imgs = $this->attatchments($product_id, "PRODUCT");
            if ($product_imgs['result']) 
            {
                foreach ($product_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                
                if ($attatchments)
                    $data['product']['images'] = $attatchments;
            }
            else
                $data['product']['images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

            //get product reviews
            $product_reviews = $this->Admin_model->productReviews(array('product_review.product_id' => $product_id), $this->limit, $this->start);
            if ($product_reviews)
                $data['product']['reviews'] = $product_reviews['result'];
            else
                $data['product']['reviews'] = false;

            //average rating information
            $rating_info = $this->Admin_model->selectRecords(array('product_id' => $product_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $data['product']['rating_info'] = $rating_info['result'][0];

            //get product listing information
            $sold_by_merchants = $this->Admin_model->getProductListings(array('product_listing.product_id' => $product_id));
            $data['product']['sold_by_merchants'] = $sold_by_merchants;

            if ($sold_by_merchants) 
            {
                $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';

                $i = 0;
                foreach ($sold_by_merchants as $merchant) 
                {
                    if (isset($_COOKIE['lat']) && isset($_COOKIE['long'])) 
                    {
                        $getNearestAddressId = $this->Admin_model->getNearestAddress('Where userId = '.$merchant['userId']);
                        $getAddress = $this->Admin_model->getUserAddress(array('address_id' => $getNearestAddressId[0]['address_id']), $address_columns);
                    }
                    else
                        $getAddress = $this->Admin_model->getUserAddress(array('address.userId' => $merchant['userId']), $address_columns);

                    $data['product']['sold_by_merchants'][$i]['nearest_address'] = $getAddress['result'][0];
                }
            }

            //get similar product
            $where = array('product_id !=' => $product_id, 'category_id' => $data['product']['category_id']);
            $similar_products = $this->Admin_model->selectRecords($where, 'product', 'product_id, product_name');
            
            if ($similar_products) 
            {
                $data['product']['similar_products'] = $similar_products['result'];

                //get product images
                $i = 0;
                foreach ($similar_products['result'] as $product) 
                {
                    $attatchments = array();
                    $product_id = $product['product_id'];

                    $product_imgs = $this->attatchments($product_id, "PRODUCT");
                    if ($product_imgs['result']) 
                    {
                        foreach ($product_imgs['result'] as $atch_value) 
                            array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                        
                        if ($attatchments)
                            $data['product']['similar_products'][$i]['images'] = $attatchments;
                    }
                    else
                        $data['product']['similar_products'][$i] = false;

                    $i++;
                }
            }
        }

        //load product detail view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/product_details');
        $this->load->view('user/include/footer');
    }

    public function listing_detail()
    {
        $data = array();
        
        if (isset($_GET['list_id'])) 
        {
            $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';

            $data['categories'] = $this->categories['result']; //get categories
            $data['tree_list'] = $this->tree_list; //get categories in tree format

            $listing_id = $_GET['list_id']; // listing id
            $product_id = $_GET['prd_id']; // product id

            //get product listing information
            $data['listing_detail'] = $this->Admin_model->getProductListings(array('listing_id' => $listing_id));

            //get listing offers
            $data['listing_offers'] = $this->Admin_model->getListingOffers(array('lst_id' => $listing_id));    

            //get merchant(user) addresses
            $data['merchant_addresses'] = $this->Admin_model->getUserAddress(array('address.userId' => $data['listing_detail'][0]['userId']), $address_columns);    

            //average rating information
            $rating_info = $this->Admin_model->selectRecords(array('product_id' => $product_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $data['listing_detail']['rating_info'] = $rating_info['result'][0];

            //get product images
            $attatchments = array();
            $product_imgs = $this->attatchments($product_id, "PRODUCT");
            if ($product_imgs['result']) 
            {
                foreach ($product_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                
                if ($attatchments)
                    $data['listing_detail']['images'] = $attatchments;
            }
            else
                $data['listing_detail']['images'] = false;

            //listing meta tag
            $data['meta_data']['title'] = $data['listing_detail'][0]['product_name'] ." | ".$this->site_settings['listing_title_suffix'];
            $data['meta_data']['keywords'] = $data['listing_detail'][0]['meta_keyword'];
            $data['meta_data']['description'] = ($data['listing_detail'][0]['meta_description']) ? $data['listing_detail'][0]['meta_description'] : implode(",", array_column($data['merchant_addresses'], 'address_line_1'));
        }

        //load product detail view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/listing_details');
        $this->load->view('user/include/footer');
    }

    public function login_page()
    {
        if (isset($_SESSION['user_detail'])) 
            redirect('', 'refresh');
        else
        {
            $data['categories'] = $this->categories['result']; //get categories
            $data['tree_list'] = $this->tree_list; //get categories in tree format
            
            //remaining
            //login pagge meta tag
            $data['meta_data']['title'] = 'Login';
            $data['meta_data']['keywords'] = '';
            $data['meta_data']['description'] = "Roposhop user login";

            //load user register view
            $this->load->view('user/include/header', $data);
            $this->load->view('user/include/sidebar', $data);
            $this->load->view('user/login');
            $this->load->view('user/include/footer');
        }
    }

    //get seller offers
    public function getOffers($where='')
    {
        $columns = 'offer_id, offer_title, description, start_date, end_date, meta_keyword, meta_description';
        $mer_offers = $this->Admin_model->selectRecords($where, 'product_listing_offer', $columns);

        if ($mer_offers)
        {
            $res['offers'] = $mer_offers['result'];

            $i = 0;
            foreach ($mer_offers['result'] as $mer_offer) 
            {
                $attatchments = array();

                //get offer images
                $offer_id = $mer_offer['offer_id'];
                $offer_imgs = $this->attatchments($offer_id, "OFFER");

                if ($offer_imgs['result']) 
                {
                    foreach ($offer_imgs['result'] as $atch_value) 
                        array_push($attatchments, $this->config->item('site_url').OFFER_ATTATCHMENTS_PATH.$offer_id.'/'.$atch_value['atch_url']);
                    
                    if ($attatchments)
                        $res['offers'][$i]['offer_images'] = $attatchments;
                }
                else
                    $res['offers'][$i]['offer_images'] = false;

                $i++;
            }
        }
        else
            $res['offers'] = false;

        return $res;
    }

    //get attatchments
    public function attatchments($link_id, $atch_for)
    {
        $where = array('link_id' => $link_id, 'atch_for' => $atch_for);
        $atch_res = $this->Admin_model->selectRecords($where, 'attatchments', 'atch_url');

        if ($atch_res) 
            return $atch_res;
        else
            return FALSE;
    }
    
    public function insertUser()
    {
        $user_id = $this->input->post('user_id');
        
        $user_data = array();
        $consumer_data = array();

        //user data
        $consumer_data['gender'] = $this->input->post('gender');
        $dob = $this->input->post('dob');
        $consumer_data['phone'] = $this->input->post('phone');

        if ($dob) 
            $consumer_data['birthday'] = date("d-m-Y", strtotime($dob));

        $user_data['status'] = 1;
        $user_data['first_name'] = $this->input->post('full_name');    

        if ($user_id) 
        {
            if ($_FILES['file']['name'] != '')
                $user_data['picture'] = $this->common_controller->single_upload(PROFILE_PIC_PATH);

            $condition = array('userId' => $user_id);
            $this->Admin_model->updateData('user', $user_data, $condition);

            //check consumer detail is already exist or not
            $isConsumerExist = $this->Admin_model->selectRecords(array('userId' => $user_id), 'consumer', 'userId');
            if ($isConsumerExist) 
                $this->Admin_model->updateData('consumer', $consumer_data, $condition);
            else
            {
                $consumer_data['userId'] = $user_id;
                $this->Admin_model->insertData('consumer', $consumer_data);
            }

            //get user detail
            $usr_details = $this->Admin_model->getUser($user_id, 1);
            $_SESSION['user_detail'] = $usr_details[0];

            $this->redirect('Profile updated successfully', 'userProfile?profile=view');
        }
        else
        {
            $user_data['email'] = $this->input->post('email');
            $user_data['password'] = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            
            if ($confirm_password != $user_data['password']) 
                $this->redirect('Error: password and confirm password should be same', 'login');
            
            //check email is already exist or not
            $isEmailExist = $this->Admin_model->selectRecords(array('email' => $user_data['email']), 'user', 'userId');

            if ($isEmailExist) 
                $this->redirect('Error: email already exist!', 'login');
            else
            {
                $user_id = $this->Admin_model->insertData('user', $user_data);

                if ($user_id)
                {
                    //insert user role
                    $type_data['usr_id'] = $user_id;
                    $type_data['type_name'] = 'BUYER';

                    $type_id = $this->Admin_model->insertData('user_type', $type_data);

                    if (!$type_id)
                       $this->redirect('Error: unable to add you as a consumer', 'login');
                   else
                   {
                        $usr_details = $this->Admin_model->getUser($user_id, 1);
            
                        if (isset($usr_details['db_error'])) 
                            $this->redirect('Error: '.$usr_details['msg'], 'login');

                        $usr_roles = $this->Admin_model->selectRecords(array('usr_id' => $user_id), 'user_type', 'type_name');
                        if (isset($usr_roles['db_error'])) 
                            $this->redirect('Error: '.$usr_roles['msg'], 'login');

                        if ($usr_details) 
                        {
                            $isValidUser = false;
                            foreach ($usr_roles['result'] as $role) 
                            {
                                if ($role['type_name'] == 'BUYER') 
                                {
                                    $isValidUser = true;
                                    break;
                                }
                            }

                            if ($isValidUser) 
                            {
                                $_SESSION['user_detail'] = $usr_details[0];
                                
                                $consumer = $this->Admin_model->selectRecords(array('userId' => $user_id), 'consumer', 'consumer_id');
                                if (isset($consumer['db_error'])) 
                                    $this->redirect('Error: '.$consumer['msg'], $controller);

                                $_SESSION['user_detail']['consumer_id'] = $consumer['result'][0]['consumer_id'];
                                redirect('userProfile?profile=view', 'refresh');
                            }
                            else
                                $this->redirect('Error: Not authorised for login!', $controller);
                        }
                        else
                            $this->redirect('Error: You are not a varified user, please contact to system administrator!', $controller);
                   }
                }           
                else
                    $this->redirect('Error: unable to add you', 'login');
            }
        }
    }

    //login method
    public function userLogin()
    {
        $usr_roles = array(); 
        $usr_details = array();
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $controller = 'login';

        $usr_id = $this->Admin_model->doLogin($username, $password);
        if (isset($usr_id['db_error'])) 
            $this->redirect('Error: '.$usr_id['msg'], $controller);
        
        if ($usr_id) 
        {
            $usr_id = $usr_id['userId'];
            $usr_details = $this->Admin_model->getUser($usr_id, 1);
            
            if (isset($usr_details['db_error'])) 
                $this->redirect('Error: '.$usr_details['msg'], $controller);

            $usr_roles = $this->Admin_model->selectRecords(array('usr_id' => $usr_id), 'user_type', 'type_name');

            if (isset($usr_roles['db_error'])) 
                $this->redirect('Error: '.$usr_roles['msg'], $controller);

            if ($usr_details) 
            {
                $isValidUser = false;
                foreach ($usr_roles['result'] as $role) 
                {
                    if ($role['type_name'] == 'BUYER') 
                    {
                        $isValidUser = true;
                        break;
                    }
                }

                if (!$isValidUser) 
                {
                    $this->Admin_model->insertData('consumer', array('userId' => $usr_id));
                    $this->Admin_model->insertData('user_type', array('usr_id' => $usr_id, 'type_name' => 'BUYER'));   
                }

                $_SESSION['user_detail'] = $usr_details[0];
                    
                $consumer = $this->Admin_model->selectRecords(array('userId' => $usr_id), 'consumer', 'consumer_id');
                if (isset($consumer['db_error'])) 
                    $this->redirect('Error: '.$consumer['msg'], $controller);

                $_SESSION['user_detail']['consumer_id'] = $consumer['result'][0]['consumer_id'];

                redirect('', 'refresh');
            }
            else
                $this->redirect('Error: You are not a varified user, please contact to system administrator!', $controller);
        }
        else
            $this->redirect('Error: Wrong credential!', $controller);
    }

    public function userLogout()
    {
        if (isset($_SESSION['user_detail'])) 
        {
            $_SESSION['user_detail'] = array();
            session_destroy();
        }

        redirect('', 'refresh');
    }

    public function userProfile()
    {
        $user = false;
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['profile']) && isset($_SESSION['user_detail']['userId'])) 
        {
            $user_id = $_SESSION['user_detail']['userId']; 
            $user = $this->Admin_model->getConsumer($user_id);
        }

        //remaining
        //login pagge meta tag
        $data['meta_data']['title'] = 'User profile';
        $data['meta_data']['keywords'] = '';
        $data['meta_data']['description'] = "Roposhop user profile";

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/userProfile', $user[0]);
        $this->load->view('user/include/footer');
    }

    public function merchants()
    {
        $merchants = false;
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['merchant_id'])) 
        {
            $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';

            $merchants = array();
            $merchant_id = $_GET['merchant_id'];

            //merchant detail
            $where = array('merchant_id' => $merchant_id);
            $merchant_detail = $this->Admin_model->selectRecords($where, 'merchant', '*');
            $merchants['merchant_detail'] = $merchant_detail['result'][0];

            //merchant address
            $where = array('address.userId' => $merchant_detail['result'][0]['userId']);
            $merchant_address = $this->Admin_model->getUserAddress($where, $address_columns);
            $merchants['address'] = $merchant_address;

            //get product reviews
            $merchant_reviews = $this->Admin_model->merchantReviews(array('merchant_review.merchant_id' => $merchant_id));
            if ($merchant_reviews)
                $merchants['reviews'] = $merchant_reviews['result'];
            else
                $merchants['reviews'] = false;

            //average rating information
            $rating_info = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $merchants['rating_info'] = $rating_info['result'][0];

            //get product listing information
            $merchants['listing_products'] = $this->Admin_model->listingProducts(array('merchant_id' => $merchant_id, 'product_listing.product_id != ' => 'null'));
            if ($merchants['listing_products']) 
            {
                $i = 0;
                foreach ($merchants['listing_products'] as $product) 
                {
                    $attatchments = array();

                    //get product images
                    $product_id = $product['product_id'];
                    $product_imgs = $this->attatchments($product_id, "PRODUCT");

                    if ($product_imgs['result']) 
                    {
                        foreach ($product_imgs['result'] as $atch_value) 
                            array_push($attatchments, base_url(PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']));
                        
                        if ($attatchments)
                            $merchants['listing_products'][$i]['products_images'] = $attatchments;
                    }
                    else
                        $merchants['listing_products'][$i]['products_images'] = false;

                    $i++;
                }
            }

            //merchant page meta tag
            $data['meta_data']['title'] = $merchants['merchant_detail']['establishment_name']." | ".$this->site_settings['merchant_title_suffix'];
            $data['meta_data']['keywords'] = $merchants['merchant_detail']['meta_keyword'];
            $data['meta_data']['description'] = ($merchants['merchant_detail']['meta_description']) ? $merchants['merchant_detail']['meta_description'] : implode(",", array_column($merchants['address'], 'address_line_1'));
        }
        else //get all merchants
        {
            $merchants = $this->Admin_model->selectRecords(array('status' => 1), 'merchant', '*');

            //merchants page meta tag
            $data['meta_data']['title'] = ($this->site_settings['merchants_meta_title']) ? $this->site_settings['merchants_meta_title'] : "Merchants";
            $data['meta_data']['keywords'] = $this->site_settings['merchants_meta_keywords'];
            $data['meta_data']['description'] = ($this->site_settings['merchants_meta_description']) ? $this->site_settings['merchants_meta_description'] : implode(",", array_column($merchants['result'], 'establishment_name'));
        }

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/merchant', $merchants);
        $this->load->view('user/include/footer');
    }

    public function brands()
    {
        $brands = false;
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['brand_id'])) 
        {
            $brand = $this->Admin_model->selectRecords(array('brand_id' => $_GET['brand_id']), 'brand', 'brand_id, name, brand_logo, brand_desc, meta_keyword, meta_description');
            $brands['brand'] = $brand['result'][0];

            $attatchments = array();

            //get product images
            $brand_id = $brand['result'][0]['brand_id'];
            $brand_imgs = $this->attatchments($brand_id, "BRAND");

            if ($brand_imgs['result']) 
            {
                foreach ($brand_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$atch_value['atch_url']);
                
                if ($attatchments)
                    $brands['brand_images'] = $attatchments;
            }
            else
                $brands['brand_images'] = false;

            //get brand products
            $brands['products'] = $this->getProducts(array('brand_id' => $brand_id));
            
            //brand page meta tag
            $data['meta_data']['title'] = $brands['brand']['name']." | ".$this->site_settings['brand_title_suffix'];
            $data['meta_data']['keywords'] = $brands['brand']['meta_keyword'];
            $data['meta_data']['description'] = ($brands['brand']['meta_description']) ? $brands['brand']['meta_description'] : $brands['brand']['brand_desc'].'-'.$brands['brand']['name'];
        }
        else //get all brands
        {
            $brands = $this->Admin_model->selectRecords('', 'brand', 'brand_id, name, brand_logo, brand_desc');
            
            //brand page meta tag
            $data['meta_data']['title'] = ($this->site_settings['brands_meta_title']) ? $this->site_settings['brands_meta_title'] : "Brands";
            $data['meta_data']['keywords'] = $this->site_settings['brands_meta_keywords'];
            $data['meta_data']['description'] = ($this->site_settings['brands_meta_description']) ? $this->site_settings['brands_meta_description'] : implode(",", array_column($brands['result'], 'name'));
        }

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/brand', $brands);
        $this->load->view('user/include/footer');
    }

    public function insertReview()
    {
        $review_for = $this->input->post('review_for');
        $consumer_id = $_SESSION['user_detail']['consumer_id'];;
        $merchant_id = $this->input->post('merchant_id');
        $product_id = $this->input->post('product_id');

        $review_data['review'] = $this->input->post('review');
        $review_data['rating'] = $this->input->post('star');
        $review_data['consumer_id'] = $consumer_id;
        $review_data['update_date'] = date("Y-m-d H:i:s");

        if ($review_for == "merchant") 
        {
            $review_data['merchant_id'] = $merchant_id;
            $condition = array('consumer_id' => $consumer_id, 'merchant_id' => $merchant_id);
            $isExistMerchantReview = $this->Admin_model->selectRecords($condition, 'merchant_review', 'review_id');
            if ($isExistMerchantReview) 
            {
                $review_id = $isExistMerchantReview['result'][0]['review_id'];
                $condition = array('review_id' => $review_id);
                $this->Admin_model->updateData('merchant_review', $review_data, $condition);
            }
            else
            {
                $review_data['create_date'] = date("Y-m-d H:i:s");
                $this->Admin_model->insertData('merchant_review', $review_data);
            }

            redirect('merchants?merchant_id='.$merchant_id, 'refresh');
        }
        else if ($review_for == "product") 
        {
            $review_data['product_id'] = $product_id;
            $condition = array('consumer_id' => $consumer_id, 'product_id' => $product_id);
            $isExistProductReview = $this->Admin_model->selectRecords($condition, 'product_review', 'review_id');
            if ($isExistProductReview) 
            {
                $review_id = $isExistProductReview['result'][0]['review_id'];
                $condition = array('review_id' => $review_id);
                $this->Admin_model->updateData('product_review', $review_data, $condition);
            }
            else
            {
                $review_data['create_date'] = date("Y-m-d H:i:s");
                $this->Admin_model->insertData('product_review', $review_data);
            }

            redirect('product_detail?prd_id='.$product_id, 'refresh');
        }
    }

    public function offer()
    {
        $offer_id = $_GET['offer_id'];

        //get offer
        $data = $this->getOffers(array('offer_id' => $offer_id, 'current_status' => 1));

        //get offer listing products
        $data['offer_listing_products'] = $this->Admin_model->getListingOffers(array('ofr_id' => $offer_id));
        if ($data['offer_listing_products']) 
        {
            $i = 0;
            foreach ($data['offer_listing_products'] as $product) 
            {
                $attatchments = array();

                //get product images
                $product_id = $product['product_id'];
                $product_imgs = $this->attatchments($product_id, "PRODUCT");

                if ($product_imgs['result']) 
                {
                    foreach ($product_imgs['result'] as $atch_value) 
                        array_push($attatchments, base_url(PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']));
                    
                    if ($attatchments)
                        $data['offer_listing_products'][$i]['products_images'] = $attatchments;
                }
                else
                    $data['offer_listing_products'][$i]['products_images'] = false;

                $i++;
            }
        }

        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        //offer page meta tag
        $data['meta_data']['title'] = $data['offers'][0]['offer_title']." | ".$this->site_settings['offer_title_suffix'];
        $data['meta_data']['keywords'] = $data['offers'][0]['meta_keyword'];
        $data['meta_data']['description'] = ($data['offers'][0]['meta_description']) ? $data['offers'][0]['meta_description'] : (($data['offer_listing_products']) ? implode(",", array_column($data['offer_listing_products'], 'product_name')) : '');

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/offer');
        $this->load->view('user/include/footer');
    }

    public function search()
    {
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['str'])) 
        {
            $string = $_GET['str'];
            $res = array();
            $res['search_term'] = $string;

            //search categories
            $columns = 'SQL_CALC_FOUND_ROWS category_id';
            $cat_result = $this->Admin_model->selectRecords('', 'product_category', $columns, array(), $this->limit, $this->start, array('category_name', $string), true);
            if ($cat_result)
                $res['categories'] = $cat_result['count'];
            else
                $res['categories'] = 0;

            //search products
            $columns = 'SQL_CALC_FOUND_ROWS product_id';
            $prd_result = $this->Admin_model->selectRecords('', 'product', $columns, array(), $this->limit, $this->start, array('product_name', $string), true);
            if ($prd_result)
                $res['products'] = $prd_result['count'];
            else
                $res['products'] = 0;

            //search brand
            $columns = 'SQL_CALC_FOUND_ROWS brand_id';
            $brands = $this->Admin_model->selectRecords('', 'brand', $columns, array(), $this->limit, $this->start, array('name', $string), true);
            if ($brands)
                $res['brands'] = $brands['count'];
            else
                $res['brands'] = 0;

            //search merchants
            $columns = "SQL_CALC_FOUND_ROWS merchant_id";
            $merchants = $this->Admin_model->selectRecords('', 'merchant', $columns, array(), $this->limit, $this->start, array('establishment_name', $string), true);
            if ($merchants)
                $res['merchants'] = $merchants['count'];
            else
                $res['merchants'] = 0;
        }

        //remaining
        //login pagge meta tag
        $data['meta_data']['title'] = 'Search';
        $data['meta_data']['keywords'] = '';
        $data['meta_data']['description'] = "";

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/search', $res);
        $this->load->view('user/include/footer');
    }

    public function claimBusiness($value='')
    {
        $claimed_data = array();
        $controller = 'merchants/viveks-the-unlimited-shop?merchant_id=13';
        $claimed_data['clmd_email'] = $this->input->post('email');
        $claimed_data['clmd_name'] = $this->input->post('name');
        $claimed_data['clmd_contact'] = $this->input->post('contact_number');
        $claimed_data['clmd_merchant_id'] = $this->input->post('merchant_id');
        $claimed_data['clmd_message'] = ($this->input->post('message')) ? $this->input->post('message') : "";

        if ($_FILES['file']['name'] != '')
            $claimed_data['clmd_business_proof'] = $this->common_controller->single_upload(TEMP_FOLDER_PATH);

        $clmd_id = $this->Admin_model->insertData('claimed_requests', $claimed_data);
        if ($clmd_id) 
        {
            $claimed_data['establishment_name'] = $this->input->post('establishment_name');
            $claimed_data['request_id'] = $clmd_id;
            $claimed_data['request_url'] = base_url();
            $claimed_data['code'] = MAIL_CODE_CLAIM_BUSINESS;
            $claimed_data['atch'] = base_url().TEMP_FOLDER_PATH.$claimed_data['clmd_business_proof'];

            $isSend = $this->common_controller->sendMail($claimed_data);
        }

        if ($isSend) 
            $this->redirect('Mail has been sent! We will review your request.', $controller);
        else
            $this->redirect('Error: Unable to send mail!', $controller);
    }

    public function redirect($msg, $controller)
    {
        echo "<script>window.alert('".$msg."');</script>";
        redirect($controller, 'refresh');
    }

    //add paging array
    public function createPagingArray($count = "")
    {
        $paging = array();
        $paging['total_results'] = $count;
        $paging['total_pages'] = ceil($count/$this->limit);
        $paging['page'] = $this->current_page;
        $paging['limit'] = $this->limit;

        return $paging;
    }
}
