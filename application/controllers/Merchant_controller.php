<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_controller.php';
require_once 'Common_controller.php';

class Merchant_controller extends Admin_controller 
{
    function __construct()
    {
        parent::__construct();

        //common controller
        $this->common_controller = new Common_controller();

        //current date
        $this->current_date = date("Y-m-d H:i:s");
    }

    public function loginSignupPage()
    {
        $data['meta_data']['title'] = 'Seller Login';
        $data['meta_data']['keywords'] = '';
        $data['meta_data']['description'] = 'Ropo Shop Seller login';

        //load user register view
        $this->load->view('user/include/header', $data);
        $this->load->view('merchant/login_signup');
        $this->load->view('user/include/footer');
    }

    public function insertSeller()
    {
        $user_data = array();
        
        //user data
        $user_data['status'] = 1;
        $user_data['first_name'] = $this->input->post('first_name');    
        $user_data['last_name'] = $this->input->post('last_name');    
        $user_data['email'] = $this->input->post('email');
        $user_data['password'] = $this->input->post('password');
        $user_contact = $this->input->post('contact_number');
        $user_data['create_date'] = $this->current_date;
        $user_data['update_date'] = $this->current_date;
        $confirm_password = $this->input->post('confirm_password');
        
        if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $user_contact))
            redirectWithMessage('Error: contact number should be in correct format', 'merchantLoginSignup');

        if ($confirm_password != $user_data['password']) 
            redirectWithMessage('Error: password and confirm password should be same', 'merchantLoginSignup');
        
        //check email is already exist or not
        $isEmailExist = $this->Admin_model->selectRecords(array('email' => $user_data['email']), 'user', 'userId');
        if ($isEmailExist) 
            redirectWithMessage('Error: email already exist!', 'merchantLoginSignup');
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
                   redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
                else
                {
                    //insert seller data
                    $seller_data = array();

                    //seller data
                    $seller_data['userId'] = $user_id;
                    $seller_data['contact'] = $this->input->post('contact_number');
                    $seller_data['is_verified'] = 0;
                    $seller_data['status'] = 0;
                    $seller_data['create_date'] = $this->current_date;
                    $seller_data['update_date'] = $this->current_date;

                    //insert data in db
                    $seller_id = $this->Admin_model->insertData('merchant', $seller_data);

                    if (!$seller_id)
                       redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
                    else
                    {
                        //send mail to company
                        $mail_data = array();
                        $mail_data['first_name'] = $user_data['first_name'];
                        $mail_data['last_name'] = $user_data['last_name'];
                        $mail_data['seller_id'] = $seller_id;
                        $mail_data['email'] = $user_data['email'];
                        $mail_data['contact_number'] = $user_contact;
                        $mail_data['code'] = MAIL_CODE_SELLER_SIGNUP;
                        $mail_data['url'] = str_replace("seller", "admin", base_url()).'seller/'.$seller_id.'/view';
                        $this->common_controller->sendMail($mail_data);

                        redirect('merchantSignupStep2/'.$user_id.'/'.$seller_id, 'refresh');
                    }
                }
            }           
            else
                redirectWithMessage('Error: unable to add you', 'login');
        }
    }

    public function merchantSignupStep2($user_id, $merchant_id)
    {
        if (isset($_SESSION['user_detail'])) 
            redirect('', 'refresh');
        else
        {
            //get countries
            $countries = $this->Admin_model->selectRecords('', 'country', '*', array('name' => 'ASC'));
            if ($countries)
                $data['countries'] = $countries['result'];
            else
                $data['countries'] = false;

            //get user detail
            $user = $this->Admin_model->sellers($merchant_id);
            if ($user)
                $data['user'] = $user[0];
            else
                redirectWithMessage('Error: No Such User Found!', 'merchantLoginSignup');

            $data['meta_data']['title'] = 'Seller signup';
            $data['meta_data']['keywords'] = '';
            $data['meta_data']['description'] = 'Ropo Shop signup step 2';

            //load user register view
            $this->load->view('user/include/header', $data);
            $this->load->view('merchant/signupStep2', $data);
            $this->load->view('user/include/footer');
        }
    }

    public function updateMerchant()
    {
        $user_id = $this->input->post('user_id');
        $merchant_id = $this->input->post('merchant_id');
        
        if ($user_id && $merchant_id) 
        {
            $controller = 'merchantSignupStep2/'.$user_id.'/'.$merchant_id;

            //seller data
            $seller_data = array();
            $seller_data['establishment_name'] = $this->input->post('comp_name');
            $seller_data['description'] = $this->input->post('description');
            $seller_data['contact'] = $this->input->post('contact');
            $seller_data['is_verified'] = 1;
            $seller_data['status'] = 1;
            $seller_data['is_completed'] = 1;
            $seller_data['update_date'] = $this->current_date;

            //user data
            $user_data = array();
            $user_data['first_name'] = $this->input->post('first_name');
            $user_data['last_name'] = $this->input->post('last_name');
            $user_data['update_date'] = $this->current_date;

            //merchant attachments path
            $folder = SELLER_ATTATCHMENTS_PATH.$merchant_id;
            
            //insert user profile picture
            if (isset($_FILES['file7']) && $_FILES['file7']['name'] != '')
            {
                $profile_pic = $this->common_controller->single_upload($folder = PROFILE_PIC_PATH, '', 'file7');
                if (!$profile_pic)
                    redirectWithMessage('Error: Unable to upload profile picture!', $controller);
                else
                    $user_data['picture'] = $profile_pic;
            }

            //update user data
            $isUpdated = $this->Admin_model->updateData('user', $user_data, array('userId' => $user_id));
            if (isset($isUpdated['db_error'])) 
                redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

            //insert shop logo
            if (isset($_FILES['file9']) && $_FILES['file9']['name'] != '')
            {
                $merchant_logo = $this->common_controller->single_upload($folder, '', 'file9');
                if (!$merchant_logo)
                    redirectWithMessage('Error: Unable to upload merchant logo!', $controller);
                else
                    $seller_data['merchant_logo'] = $merchant_logo;
            }

            //insert seller proof
            $business_proof = $this->common_controller->single_upload($folder, '', 'file8');
            if (!$business_proof)
                $msg = "Error: Unable to upload merchant business proof!";
            else
            {
                $where = array('merchant_id' => $merchant_id);
                $seller_data['business_proof'] = $business_proof;

                //update user row with profile image
                $isUpdated = $this->Admin_model->updateData('merchant', $seller_data, $where);
                if (isset($isUpdated['db_error'])) 
                    redirectWithMessage('Error: '.$isUpdated['msg'], $controller);
            }

            //atatchment data
            $img_data['link_id'] = $merchant_id;
            $img_data['atch_type'] = "IMAGE";
            $img_data['atch_for'] = "SELLER";

            //insert seller images
            $isUploaded = $this->upload_image($folder, $img_data);
            if (isset($isUploaded['db_error'])) 
                redirectWithMessage('Error: '.$isUploaded['msg'], $controller);
            else
            {
                //insert merchant address
                $address_id = $this->insertAddress($user_id, 1);
                if (!$address_id) 
                    redirectWithMessage('Error: lat, long are not in correct format.', $controller);
                else
                {
                    //get user detail
                    $usr_details = $this->Admin_model->getUser($user_id, 1);
                    if (isset($usr_details['db_error'])) 
                        redirectWithMessage('Error: '.$usr_details['msg'], $controller);
                    else
                    {
                        $usr_details['merchant_id'] = $merchant_id;
                        $this->cookieSetupForLogin($usr_details);
                    }
                }
            }
        }
        else
            redirectWithMessage('Error: User id or merchant id not found!', 'merchantLoginSignup');
    }

    //login method
    public function login()
    {
        if (!isset($_COOKIE['site_code'])) 
        {
            redirect('', 'refresh');
            die;
        }

        //get controller
        $controller = 'merchantLoginSignup';

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
                    $isValidUser = false;
                    $usr_roles = array_column($usr_roles['result'], 'type_name');

                    if (in_array('SELLER', $usr_roles))
                    {
                        $merchant = $this->Admin_model->selectRecords(array('userId' => $usr_id), 'merchant', 'merchant_id, is_verified');
                        if (isset($merchant['db_error'])) 
                            redirectWithMessage('Error: '.$merchant['msg'], $controller);
                        else if ($merchant)
                        {
                            $is_verified = $merchant['result'][0]['is_verified'];
                            $merchant_id = $merchant['result'][0]['merchant_id'];
                            $usr_details['merchant_id'] = $merchant_id;

                            if (!$is_verified) 
                                redirect('merchantSignupStep2/'.$usr_id.'/'.$merchant_id, 'refresh');
                        }
                        
                        $this->cookieSetupForLogin($usr_details);
                    }
                    else
                    {
                        //insert seller role
                        $type_data['usr_id'] = $usr_id;
                        $type_data['type_name'] = "SELLER";

                        $type_id = $this->Admin_model->insertData('user_type', $type_data);
                        if (!$type_id)
                           redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
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
                               redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
                            else
                                redirect('merchantSignupStep2/'.$usr_id.'/'.$seller_id, 'refresh');
                        }
                    }
                }
                else
                    redirectWithMessage('Error: You are not a varified user, please contact to system administrator!', $controller);
            }
        }
        else
            redirectWithMessage('Error: Wrong credential!', 'merchantLoginSignup');
    }
}
