<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_controller extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        //load db model
        $this->load->model('Admin_model');
        $this->load->model('Excel_model');

        //load excel library
        $this->load->library('Excel');

        //excel sheet object
        $this->objPHPExcel = '';
        $this->objPHPExcel = new PHPExcel();

        //current date
        $this->current_date = date("Y-m-d H:i:s");
    }

    //load address page
    public function loadAddressExcelPage($message="", $error=array())
    {
        $data = array();
        
        $states = $this->Admin_model->selectRecords('', 'state', '*');
        if (isset($states['db_error'])) 
            redirectWithMessage('Error: '.$states['msg'], $controller);
        else if ($states)
            $data['states'] = $states['result'];
        else
            $data['states'] = false;

        $sallers = $this->Admin_model->sellers();
        if (isset($sallers['db_error'])) 
            redirectWithMessage('Error: '.$sallers['msg'], $controller);
        else if ($sallers)
            $data['sallers'] = $sallers;
        else
            $data['sallers'] = false;

        //get address
        $where = array();   

        //get user id from merchant id
        if (isset($_GET['merchant_id']) && $_GET['merchant_id']) 
        {
            // get country records from databse
            $user_result = $this->Admin_model->selectRecords(array('merchant_id' => $_GET['merchant_id']), 'merchant', 'userId');
            if (isset($user_result['db_error'])) 
                redirectWithMessage('Error: '.$user_result['msg'], 'addressExcel');
            else if ($user_result)
                $user_id = $user_result['result'][0]['userId'];
            else
                redirectWithMessage('Error: unable to get user id from given merchant id', 'addressExcel');

            $where['address.userId'] = $user_id;
        }

        if (isset($_GET['state_id']) && $_GET['state_id'])
        {
            $where['address.state_id'] = $_GET['state_id'];

            if (isset($_GET['city_id']) && $_GET['city_id'])
                $where['address.city_id'] = $_GET['city_id'];
        }

        // get data from databse
        $address_columns = 'establishment_name, merchant_id, country.name as country_name, address.country_id, state.name as state_name, address.state_id, city.name as city_name, address.city_id, address_line_1, address_line_2, landmark, pin, address.contact, address.business_days, address.business_hours, address.latitude, address.longitude, address_id';
        $address_result = $this->Admin_model->getUserAddress($where, $address_columns);
        
        if (isset($address_result['db_error'])) 
            redirectWithMessage('Error: '.$address_result['msg'], 'addressExcel');
        else if ($address_result) 
            $data['address'] = $address_result['result'];

        //load address view
        $data['message'] = $message;
        $data['error'] = $error;

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/address', $data);
        $this->load->view('admin/include/footer');
    }

    //load merchant page
    public function loadMerchantExcelPage()
    {
        $data = array();
        
        $states = $this->Admin_model->selectRecords('', 'state', '*');
        if (isset($states['db_error'])) 
            redirectWithMessage('Error: '.$states['msg'], $controller);
        else if ($states)
            $data['states'] = $states['result'];
        else
            $data['states'] = false;

        $merchant_id = (isset($_GET['merchant_id']) && $_GET['merchant_id']) ? $_GET['merchant_id'] : '';
        $state_id = (isset($_GET['state_id']) && $_GET['state_id']) ? $_GET['state_id'] : '';
        $city_id = (isset($_GET['city_id']) && $_GET['city_id']) ? $_GET['city_id'] : '';

        $seller_result = $this->Excel_model->merchant($merchant_id, $state_id, $city_id);
        if (isset($seller_result['db_error'])) 
            redirectWithMessage('Error: '.$seller_result['msg'], 'merchantExcel');
        else if ($seller_result) 
            $data['merchants'] = $seller_result;

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/merchant', $data);
        $this->load->view('admin/include/footer');
    }

    //load state page
    public function loadStateExcelPage()
    {
        $data = array();
        $controller = 'loadStateExcelPage';
        $country_id = isset($_GET['getStateList']) ? $_GET['getStateList'] : "";
        $states = $this->getState('', '', $country_id);
        //echo "<pre>"; print_r($states); die;

        if (isset($states['db_error'])) 
            redirectWithMessage('Error: '.$states['msg'], $controller);
        else if ($states['result']) 
            $data['states'] = $states['result'];
        else
            $data['states'] = false;

        $country = $this->getCountry();
        $data['countries'] = $country['result'];

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/state', $data);
        $this->load->view('admin/include/footer');
    }

    //get county from db
    private function getState($state_id, $status='', $cnt_id="")
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

    //load product page
    public function loadProductExcelPage()
    {
        $data = array();
        
        $brands = $this->Admin_model->selectRecords('', 'brand', 'brand_id, name');
        if (isset($brands['db_error'])) 
            redirectWithMessage('Error: '.$brands['msg'], $controller);
        else if ($brands)
            $data['brands'] = $brands['result'];
        else
            $data['brands'] = false;

        $category = $this->Admin_model->selectRecords('', 'product_category', 'category_id, category_name');
        if (isset($category['db_error'])) 
            redirectWithMessage('Error: '.$category['msg'], $controller);
        else if ($category)
            $data['categories'] = $category['result'];
        else
            $data['categories'] = false;

        //get product detail
        $category_id = (isset($_GET['category_id']) && $_GET['category_id']) ? $_GET['category_id'] : '';
        $brand_id = (isset($_GET['brand_id']) && $_GET['brand_id']) ? $_GET['brand_id'] : '';

        $product_result = $this->Excel_model->product($category_id, $brand_id);
        if (isset($product_result['db_error'])) 
            redirectWithMessage('Error: '.$product_result['msg'], 'productExcel');
        else if ($product_result) 
            $data['products'] = $product_result;

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/product', $data);
        $this->load->view('admin/include/footer');
    }

    //load listing page
    public function loadListingExcelPage()
    {
        $data = array();
        $controller = 'listingExcel';

        $product = $this->Admin_model->selectRecords('', 'product', 'product_id, product_name');
        if (isset($product['db_error'])) 
            redirectWithMessage('Error: '.$product['msg'], $controller);
        else if ($product)
            $data['products'] = $product['result'];
        else
            $data['products'] = false;

        $seller = $this->Admin_model->selectRecords('', 'merchant', 'merchant_id, establishment_name');
        if (isset($seller['db_error'])) 
            redirectWithMessage('Error: '.$seller['msg'], $controller);
        else if ($seller)
            $data['sellers'] = $seller['result'];
        else
            $data['sellers'] = false;

        //get listing details
        $where = array();
        if (isset($_GET['merchant_id']) && $_GET['merchant_id']) 
            $where['product_listing.merchant_id'] = $_GET['merchant_id'];

        if (isset($_GET['product_id']) && $_GET['product_id'])
            $where['product_listing.product_id'] = $_GET['product_id'];

        // get data from databse
        $listing_result = $this->Excel_model->listing($where);
        //echo "<pre>"; print_r($listing_result); die;
        if (isset($listing_result['db_error'])) 
            redirectWithMessage('Error: '.$listing_result['msg'], $controller);
        else if ($listing_result) 
            $data['listings'] = $listing_result;

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/listing', $data);
        $this->load->view('admin/include/footer');
    }

    //get county from db
    private function getCountry($cnt_id="", $staus='')
    {
        $where = "";

        if ($cnt_id)
            $where = array('country_id' => $cnt_id);

        if ($staus)
            $where['status'] = $status;

        return $this->Admin_model->selectRecords($where, 'country', '*', array('name' => 'ASC'));
    }

    public function loadCountryExcelPage()
    {
        $countries = $this->getCountry();
        if (isset($countries['db_error'])) 
            redirectWithMessage('Error: '.$countries['msg'], $controller);

        $data['countries'] = $countries['result'];

        if ($countries)
            $data['country'] = $countries;
        else
            $data['country'] = false;

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/country', $data);
        $this->load->view('admin/include/footer');
    }

    //export xls sheet with out data (create template)
    /*public function generateXlsTemplate()
    {
        $file_name = $this->input->post('file_name');
        $column_name = explode(',', $this->input->post('column_name'));

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        // Rename worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle($file_name);
        $this->objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }*/

    //export xls sheet with data
    /*public function generateSimpleXlsReport()
    {
        $table_name = $this->input->post('table_name');
        $column_name = explode(',', $this->input->post('column_name'));

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }
        
        // get data from databse
        $result = $this->Admin_model->selectRecords('', $table_name, $column_name);
        if (isset($result['db_error'])) 
            redirectWithMessage('Error: '.$result['msg'], 'dashboard');
        else if ($result) 
        {
            //insert data in excel sheet from database
            $i = 2;
            foreach($result['result'] as $row)
            {
                $char = 'A';
                
                //insert data in cell for perticular column
                foreach ($column_name as $column) 
                {
                    $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                    $cell->setCellValue($char.$i, $row[trim($column)]);
                    
                    $char++;
                }

                $i++;
            }
        }
        else
            redirectWithMessage('Error: no record found', 'dashboard');

        // Rename worksheet
        $this->objPHPExcel->getActiveSheet()->setTitle($table_name);
        $this->objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$table_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }*/

    //export address xls sheet
    public function exportTemplateForAddress()
    {
        //create template for address
        $fields = 'Seller, Seller ID, Country, Country ID, State, State ID, City, City ID, Address Line 1, Address Line 2, Landmark, Pin, Contact, Business Days, Business Hours, Latitude, Longitude, Address ID';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        if (isset($_GET['merchant_id']) || isset($_GET['state_id']) || isset($_GET['city_id'])) 
        {
            $where = array();   

            //get user id from merchant id
            if (isset($_GET['merchant_id']) && $_GET['merchant_id']) 
            {
                // get country records from databse
                $user_result = $this->Admin_model->selectRecords(array('merchant_id' => $_GET['merchant_id']), 'merchant', 'userId');
                if (isset($user_result['db_error'])) 
                    redirectWithMessage('Error: '.$user_result['msg'], 'addressExcel');
                else if ($user_result)
                    $user_id = $user_result['result'][0]['userId'];
                else
                    redirectWithMessage('Error: unable to get user id from given merchant id', 'addressExcel');

                $where['address.userId'] = $user_id;
            }

            if (isset($_GET['state_id']) && $_GET['state_id'])
            {
                $where['address.state_id'] = $_GET['state_id'];

                if (isset($_GET['city_id']) && $_GET['city_id'])
                    $where['address.city_id'] = $_GET['city_id'];
            }

            //sheet column name
            $cell_column_name = array('establishment_name', 'merchant_id', 'country_name', 'country_id', 'state_name', 'state_id', 'city_name', 'city_id', 'address_line_1', 'address_line_2', 'landmark', 'pin', 'contact', 'business_days', 'business_hours', 'latitude', 'longitude', 'address_id');

            // get data from databse
            $address_columns = 'establishment_name, merchant_id, country.name as country_name, address.country_id, state.name as state_name, address.state_id, city.name as city_name, address.city_id, address_line_1, address_line_2, landmark, pin, address.contact, address.business_days, address.business_hours, address.latitude, address.longitude, address_id';
            $address_result = $this->Admin_model->getUserAddress($where, $address_columns);
            if (isset($address_result['db_error'])) 
                redirectWithMessage('Error: '.$address_result['msg'], 'addressExcel');
            else if ($address_result) 
            {
                //insert data in excel sheet from database
                $i = 2;
                foreach($address_result['result'] as $row)
                {
                    $char = 'A';
                    
                    //insert data in cell for perticular column
                    foreach ($cell_column_name as $column) 
                    {
                        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                        $cell->setCellValue($char.$i, $row[trim($column)]);
                        
                        $char++;
                    }

                    $i++;
                }
            }
            else
                redirectWithMessage('Error: no record found', 'dashboard');
        }

        $this->objPHPExcel->getActiveSheet()->setTitle('Address');
        $this->objPHPExcel->setActiveSheetIndex(0);

        $where = array('status' => 1);
        for ($i=1; $i <= 3; $i++) 
        { 
            switch ($i) 
            {
                case 1:
                    $table_name = 'country';
                    $country_column = 'country_id, name';
                    $column_name = explode(',', $country_column);

                    // get country records from databse
                    $country_result = $this->Admin_model->selectRecords($where, $table_name, $country_column);
                    if (isset($country_result['db_error'])) 
                        redirectWithMessage('Error: '.$country_result['msg'], 'dashboard');
                    else if ($country_result)
                        $result = $country_result['result'];
                    else
                        $result = false;

                    break;
                
                case 2:
                    $table_name = 'state';
                    $state_column = 'state_id, name, country_id';
                    $column_name = explode(',', $state_column);

                    // get state records from databse
                    $state_result = $this->Admin_model->selectRecords($where, $table_name, $state_column);
                    if (isset($state_result['db_error'])) 
                        redirectWithMessage('Error: '.$state_result['msg'], 'dashboard');
                    else if ($state_result) 
                        $result = $state_result['result'];
                    else
                        $result = false;

                    break;

                case 3:
                    $table_name = 'city';
                    $city_column = 'city_id, name, state_id, latitude, longitude';
                    $column_name = explode(',', $city_column);

                    // get city records from databse
                    $city_result = $this->Admin_model->selectRecords($where, $table_name, $city_column);
                    if (isset($city_result['db_error'])) 
                        redirectWithMessage('Error: '.$city_result['msg'], 'dashboard');
                    else if ($city_result) 
                        $result = $city_result['result'];
                    else
                        $result = false;

                    break;

                default: return;
            }

            $objWorkSheet = $this->objPHPExcel->createSheet($i); //Setting index when creating

            //Write column name in cells
            $char = 'A';
            foreach ($column_name as $column) 
            {
                if ($char == 'Z') 
                    break;

                $objWorkSheet->setCellValue($char.'1', $column);
                $char++;
            }

            
            // get records from databse
            if ($result) 
            {
                //insert data in address excel tab from database
                $j = 2;
                foreach($result as $row)
                {
                    $char = 'A';
                    
                    //insert data in cell for perticular column
                    foreach ($column_name as $column) 
                    {
                        $cell = $this->objPHPExcel->setActiveSheetIndex($i);
                        $cell->setCellValue($char.$j, $row[trim($column)]);
                        
                        $char++;
                    }

                    $j++;
                }
            }
            
            // Rename sheet
            $objWorkSheet->setTitle($table_name);
        }
        
        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="address.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //export address xls sheet
    public function exportTemplateForListing()
    {
        //create template for address
        $fields = 'Seller, Seller ID, Product Name, Product ID, Brand, Category, Price, Finance Available, Finance Term, Home Delivery Available, Home Delivery Terms, Installation Available, Installation Terms, In Stock, Will Back In Stock On, Replacement Available, Replacement Terms, Return Available, Return Policy, Seller Offering, Listing ID';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        if (isset($_GET['merchant_id']) || isset($_GET['product_id'])) 
        {
            $where = array();   
            $controller = 'addressExcel';

            if (isset($_GET['merchant_id']) && $_GET['merchant_id']) 
                $where['product_listing.merchant_id'] = $_GET['merchant_id'];

            if (isset($_GET['product_id']) && $_GET['product_id'])
                $where['product_listing.product_id'] = $_GET['product_id'];

            //sheet column name
            $cell_column_name = array('establishment_name', 'merchant_id', 'product_name', 'product_id', 'brand_name', 'category_name', 'price', 'finance_available', 'finance_terms', 'home_delivery_available', 'home_delivery_terms', 'installation_available', 'installation_terms', 'in_stock', 'will_back_in_stock_on', 'replacement_available', 'replacement_terms', 'return_available', 'return_policy', 'seller_offering', 'listing_id');

            // get data from databse
            $listing_result = $this->Excel_model->listing($where);
            
            if (isset($listing_result['db_error'])) 
                redirectWithMessage('Error: '.$listing_result['msg'], $controller);
            else if ($listing_result) 
            {
                //insert data in excel sheet from database
                $i = 2;
                foreach($listing_result as $row)
                {
                    $char = 'A';
                    
                    //insert data in cell for perticular column
                    foreach ($cell_column_name as $column) 
                    {
                        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                        $cell->setCellValue($char.$i, $row[trim($column)]);
                        
                        $char++;
                    }

                    $i++;
                }
            }
            else
                redirectWithMessage('Error: no record found', $controller);
        }

        $this->objPHPExcel->getActiveSheet()->setTitle('Listing');
        $this->objPHPExcel->setActiveSheetIndex(0);
        
        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="listing.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //export address xls sheet
    public function exportTemplateForMerchant()
    {
        //create template for address
        $fields = 'Seller, Seller ID, Finance Available, Finance Terms, Home Delivery Available, Home Delivery Terms, Installation Available, Installation Terms, Replacement Available, Replacement Terms, Return Available, Return Policy, Seller Offering';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        // get data from databse
        $cell_column_name = array('establishment_name', 'merchant_id', 'finance_available', 'finance_terms', 'home_delivery_available', 'home_delivery_terms', 'installation_available', 'installation_terms', 'replacement_available', 'replacement_terms', 'return_available', 'return_policy', 'seller_offering');

        $merchant_id = (isset($_GET['merchant_id']) && $_GET['merchant_id']) ? $_GET['merchant_id'] : '';
        $state_id = (isset($_GET['state_id']) && $_GET['state_id']) ? $_GET['state_id'] : '';
        $city_id = (isset($_GET['city_id']) && $_GET['city_id']) ? $_GET['city_id'] : '';

        $seller_result = $this->Excel_model->merchant($merchant_id, $state_id, $city_id);
        if (isset($seller_result['db_error'])) 
            redirectWithMessage('Error: '.$seller_result['msg'], 'merchantExcel');
        else if ($seller_result) 
        {
            //insert data in excel sheet from database
            $i = 2;
            foreach($seller_result as $row)
            {
                $char = 'A';
                
                //insert data in cell for perticular column
                foreach ($cell_column_name as $column) 
                {
                    $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                    $cell->setCellValue($char.$i, $row[trim($column)]);
                    
                    $char++;
                }

                $i++;
            }
        }
        else
            redirectWithMessage('Error: no record found', 'dashboard');

        $this->objPHPExcel->getActiveSheet()->setTitle('Merchant');
        $this->objPHPExcel->setActiveSheetIndex(0);

        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="merchant.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //export country xls sheet
    public function exportTemplateForCountry($withData)
    {
        //create template for address
        $fields = 'Country Name, Country ID, Status';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        if ($withData) 
        {
            // get data from databse
            $cell_column_name = array('name', 'country_id', 'status');

            $country_result = $this->Admin_model->selectRecords("", 'country', 'name,country_id,status');
            if (isset($country_result['db_error'])) 
                redirectWithMessage('Error: '.$country_result['msg'], 'countryExcel');
            else if ($country_result) 
            {
                //insert data in excel sheet from database
                $i = 2;
                foreach($country_result['result'] as $row)
                {
                    $char = 'A';
                    
                    //insert data in cell for perticular column
                    foreach ($cell_column_name as $column) 
                    {
                        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                        $cell->setCellValue($char.$i, $row[trim($column)]);
                        
                        $char++;
                    }

                    $i++;
                }
            }
            else
                redirectWithMessage('Error: no record found', 'countryExcel');
        }

        $this->objPHPExcel->getActiveSheet()->setTitle('Country');
        $this->objPHPExcel->setActiveSheetIndex(0);

        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="country.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //export country xls sheet
    public function exportTemplateForState($withData)
    {
        $controller = (isset($withData)) ? 'stateExcel?getStateList='.$withData: "stateExcel";

        //create template for address
        $fields = 'State Name, State ID, Status, Country ID';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        if ($withData) 
        {
            // get data from databse
            $cell_column_name = array('name', 'state_id', 'status', 'country_id');

            $where = ($withData != "ALL") ? array('country_id' => $withData) : "";
            $state_result = $this->Admin_model->selectRecords($where, 'state', 'name,state_id,status,country_id');
            if (isset($state_result['db_error'])) 
                redirectWithMessage('Error: '.$state_result['msg'], $controller);
            else if ($state_result) 
            {
                //insert data in excel sheet from database
                $i = 2;
                foreach($state_result['result'] as $row)
                {
                    $char = 'A';
                    
                    //insert data in cell for perticular column
                    foreach ($cell_column_name as $column) 
                    {
                        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                        $cell->setCellValue($char.$i, $row[trim($column)]);
                        
                        $char++;
                    }

                    $i++;
                }
            }
            else
                redirectWithMessage('Error: no record found', $controller);
        }

        $this->objPHPExcel->getActiveSheet()->setTitle('Country');
        $this->objPHPExcel->setActiveSheetIndex(0);

        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="state.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //export address xls sheet
    public function exportTemplateForProduct()
    {
        //create template for address
        $fields = 'Product Name, Product ID, Category Name, Category ID, Brand Name, Brand ID, Price';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        // get data from databse
        $cell_column_name = array('product_name', 'product_id', 'category_name', 'category_id', 'brand_name', 'brand_id', 'mrp_price');

        $category_id = (isset($_GET['category_id']) && $_GET['category_id']) ? $_GET['category_id'] : '';
        $brand_id = (isset($_GET['brand_id']) && $_GET['brand_id']) ? $_GET['brand_id'] : '';

        $product_result = $this->Excel_model->product($category_id, $brand_id);
        if (isset($product_result['db_error'])) 
            redirectWithMessage('Error: '.$product_result['msg'], 'productExcel');
        else if ($product_result) 
        {
            //insert data in excel sheet from database
            $i = 2;
            foreach($product_result as $row)
            {
                $char = 'A';
                
                //insert data in cell for perticular column
                foreach ($cell_column_name as $column) 
                {
                    $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                    $cell->setCellValue($char.$i, $row[trim($column)]);
                    
                    $char++;
                }

                $i++;
            }
        }
        else
            redirectWithMessage('Error: no record found', 'productExcel');

        $this->objPHPExcel->getActiveSheet()->setTitle('Product');
        $this->objPHPExcel->setActiveSheetIndex(0);

        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="product.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //import and insert excel sheet data in db(Address table)
    public function importAddressXls()
    {
        $file_info = pathinfo($_FILES["result_file"]["name"]);
        $new_file_name = date("d-m-Y H:i:s A").".". $file_info["extension"];

        if(move_uploaded_file($_FILES["result_file"]["tmp_name"], TEMP_FOLDER_PATH.$new_file_name))
        {   
            $file_type = PHPExcel_IOFactory::identify(TEMP_FOLDER_PATH.$new_file_name);
            $objReader = PHPExcel_IOFactory::createReader($file_type);
            $this->objPHPExcel = $objReader->load(TEMP_FOLDER_PATH.$new_file_name);
            $this->objPHPExcel->setActiveSheetIndex(0);
            $sheet_data = $this->objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            
            $i = 0;
            $insert_db_data = array();
            $update_db_data = array();
            $controller = 'addressExcel';
            $isInserted = false;
            $isUpdated = false;
            $not_found_address = array();

            //validate sheet
            foreach($sheet_data as $data)
            {
                //sheet row
                $seller_id = ($data['B']) ? $data['B'] : '';
                $country_id = ($data['D']) ? $data['D'] : '';
                $state_id = ($data['F']) ? $data['F'] : '';
                $city_id = ($data['H']) ? $data['H'] : '';
                $address_line_1 = ($data['I']) ? $data['I'] : '';
                
                if (!$seller_id || !$country_id || !$state_id || !$city_id || !$address_line_1) 
                    redirectWithMessage('Error: Seller ID, Address Line 1, City Id, State ID and Country ID not found, please check all the information is correct', $controller);
            }

            //insert of update records in db
            foreach($sheet_data as $data)
            {
                if ($i > 0) 
                {
                    if($this->isEmptyRow($data)) 
                        continue;
                    
                    //sheet row
                    $seller_id = ($data['B']) ? $data['B'] : '';
                    $country_id = ($data['D']) ? $data['D'] : '';
                    $state_id = ($data['F']) ? $data['F'] : '';
                    $city_id = ($data['H']) ? $data['H'] : '';
                    $address_line_1 = ($data['I']) ? $data['I'] : '';
                    $address_line_2 = ($data['J']) ? $data['J'] : '';
                    $landmark = ($data['K']) ? $data['K'] : '';
                    $pin = ($data['L']) ? $data['L'] : '';
                    $contact = ($data['M']) ? $data['M'] : '';
                    $business_days = ($data['N']) ? $data['N'] : '';
                    $business_hours = ($data['O']) ? $data['O'] : '';
                    $latitude = ($data['P']) ? $data['P'] : '';
                    $longitude = ($data['Q']) ? $data['Q'] : '';
                    $address_id = ($data['R']) ? $data['R'] : '';

                    if (!$seller_id || !$country_id || !$state_id || !$city_id || !$address_line_1) 
                        redirectWithMessage('Error: Seller ID, Address Line 1, City Id, State ID and Country ID not found for seller id: '.$seller_id, $controller);
                    else
                    {
                        // get country name from databse
                        $country_result = $this->Admin_model->selectRecords(array('country_id' => $country_id), 'country', 'name');
                        if (isset($country_result['db_error'])) 
                            redirectWithMessage('Error: '.$country_result['msg'], $controller);
                        else if ($country_result) 
                            $country_name = $country_result['result'][0]['name'];
                        else
                            $country_name = '';

                        // get state name from databse
                        $state_result = $this->Admin_model->selectRecords(array('state_id' => $state_id), 'state', 'name');
                        if (isset($state_result['db_error'])) 
                            redirectWithMessage('Error: '.$state_result['msg'], $controller);
                        else if ($state_result) 
                            $state_name = $state_result['result'][0]['name'];
                        else
                            $state_name = '';

                        // get city name records from databse
                        $city_result = $this->Admin_model->selectRecords(array('city_id' => $city_id), 'city', 'name');
                        if (isset($city_result['db_error'])) 
                            redirectWithMessage('Error: '.$city_result['msg'], $controller);
                        else if ($city_result) 
                            $city_name = $city_result['result'][0]['name'];
                        else
                            $city_name = '';

                        $address = $address_line_1.'+'.$address_line_2.'+'.$landmark.'+'.$city_name.'+'.$pin.'+'.$state_name.'+'.$country_name;

                        if (!$latitude || !$longitude) 
                        {
                            //get lat long from address
                            $address_values = getLAtLongFromAddress($address);   
                            if ($address_values) 
                            {
                                $latitude = $address_values->results[0]->geometry->location->lat;
                                $longitude = $address_values->results[0]->geometry->location->lng;
                            }
                            else
                            {
                                $address = $address_line_1.','.$address_line_2.','.$landmark.','.$city_name.'-'.$pin.','.$state_name.','.$country_name;
                                array_push($not_found_address, $address);
                            }
                        }
                        
                        //get user id from seller id
                        $seller = $this->Admin_model->selectRecords(array('merchant_id' => $seller_id), 'merchant', 'userId');
                        if (isset($seller['db_error'])) 
                            redirectWithMessage('Error: '.$seller['msg'], $controller);
                        else if ($seller) 
                        {
                            $userId = $seller['result'][0]['userId'];

                            $data = array(
                                'userId' => $userId,
                                'contact' => $contact,
                                'business_days' => $business_days,
                                'business_hours' => $business_hours,
                                'address_line_1' => $address_line_1,
                                'address_line_2' => $address_line_2,
                                'landmark' => $landmark,
                                'pin' => $pin,
                                'state_id' => $state_id,
                                'country_id' => $country_id,
                                'city_id' => $city_id,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                                'update_date' => $this->current_date
                            );

                            //create data array
                            if ($address_id) //for update
                            {
                                $data['address_id'] = $address_id;
                                $update_db_data[] = $data;
                            }
                            else //for insert
                            {
                                $data['create_date'] = $this->current_date;
                                $insert_db_data[] = $data; 
                            }
                        }
                        else
                            redirectWithMessage('Error: unable to get user id for seller_id: '.$seller_id, $controller);
                    }
                }

                $i++;
            }

            //insert data in batch
            if (count($insert_db_data)>0)
                $isInserted = $this->Admin_model->insert_batch('address', $insert_db_data);

            //update data in batch
            if (count($update_db_data)>0)
                $isUpdated = $this->Admin_model->update_batch('address', $update_db_data, 'address_id');

            if (!$isInserted || !$isUpdated) 
            {
                //delete all temporary files from system after use
                deleteFolder(TEMP_FOLDER_PATH, false);

                //load address excel page
                $this->loadAddressExcelPage('File uploaded successfully', $not_found_address);
            }
        }
        else
            redirectWithMessage('Error: something wrong with the excel uploading', $controller);
    }

    public function isEmptyRow($row) 
    {
        foreach($row as $cell)
        {
            if (null !== $cell) 
                return false;
        }
        
        return true;
    }

    //import product listing detail
    public function importListingXls()
    {
        $file_info = pathinfo($_FILES["result_file"]["name"]);
        $new_file_name = date("d-m-Y H:i:s A").".". $file_info["extension"];
        $controller = 'listingExcel';

        if(move_uploaded_file($_FILES["result_file"]["tmp_name"], TEMP_FOLDER_PATH.$new_file_name))
        {   
            $file_type = PHPExcel_IOFactory::identify(TEMP_FOLDER_PATH.$new_file_name);
            $objReader = PHPExcel_IOFactory::createReader($file_type);
            $this->objPHPExcel = $objReader->load(TEMP_FOLDER_PATH.$new_file_name);
            $sheet_data = $this->objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            
            $i = 1;
            $update_db_data = array();
            $insert_db_data = array();
            $isInserted = false;
            $isUpdated = false;
            
            foreach($sheet_data as $data)
            {
                if ($i > 1) 
                {
                    if($this->isEmptyRow($data)) 
                        continue;

                    //sheet row
                    $merchant_id = ($data['B']) ? $data['B'] : '';
                    $product_id = ($data['D']) ? $data['D'] : '';
                    $list_price = ($data['G']) ? $data['G'] : '';
                    $will_back_in_stock_on = ($data['O']) ? $data['O'] : '';
                    $seller_offering = ($data['T']) ? $data['T'] : '';
                    $listing_id = ($data['U']) ? $data['U'] : '';

                    if (!$product_id || !$merchant_id || !$list_price) 
                        redirectWithMessage('Error: product id, merchant id, list price required', $controller);
                    else
                    {
                        //get merchant default values
                        $merchant_default_values = $this->Admin_model->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, replacement_available, replacement_terms, return_available, return_policy');
                        
                        if (isset($merchant_default_values['db_error'])) 
                            redirectWithMessage('Error: '.$merchant_default_values['msg'], $controller);
                        else
                        {
                            $in_stock = ($data['N'] == "NO") ? 0 : 1;
                            $finance_available = ($data['H'] == "") ? $merchant_default_values['result'][0]['finance_available'] : ((strtolower($data['H']) == "yes") ? 1 : 0);
                            $finance_terms = ($data['I'] == "") ? $merchant_default_values['result'][0]['finance_terms'] : $data['I'];
                            $home_delivery_available = ($data['J'] == "") ? $merchant_default_values['result'][0]['home_delivery_available'] : ((strtolower($data['J']) == "yes") ? 1 : 0);
                            $home_delivery_terms = ($data['K'] == "") ? $merchant_default_values['result'][0]['home_delivery_terms'] : $data['K'];
                            $installation_available = ($data['L'] == "") ? $merchant_default_values['result'][0]['installation_available'] : ((strtolower($data['L']) == "yes") ? 1 : 0);
                            $installation_terms = ($data['M'] == "") ? $merchant_default_values['result'][0]['installation_terms'] : $data['M'];
                            $replacement_available = ($data['P'] == "") ? $merchant_default_values['result'][0]['replacement_available'] : ((strtolower($data['L']) == "yes") ? 1 : 0);
                            $replacement_terms = ($data['Q'] == "") ? $merchant_default_values['result'][0]['replacement_terms'] : $data['Q'];
                            $return_available = ($data['R'] == "") ? $merchant_default_values['result'][0]['return_available'] : ((strtolower($data['L']) == "yes") ? 1 : 0);
                            $return_policy = ($data['S'] == "") ? $merchant_default_values['result'][0]['return_policy'] : $data['S'];

                            //create data array for insert address
                            $data = array(
                                'merchant_id' => $merchant_id,
                                'product_id' => $product_id,
                                'list_price' => $list_price,
                                'finance_available' => $finance_available,
                                'finance_terms' => $finance_terms,
                                'home_delivery_available' => $home_delivery_available,
                                'home_delivery_terms' => $home_delivery_terms,
                                'installation_available' => $installation_available,
                                'installation_terms' => $installation_terms,
                                'in_stock' => $in_stock,
                                'will_back_in_stock_on' => $will_back_in_stock_on,
                                'replacement_available' => $replacement_available,
                                'replacement_terms' => $replacement_terms,
                                'return_available' => $return_available,
                                'return_policy' => $return_policy,
                                'seller_offering' => $seller_offering,
                                'update_date' => $this->current_date
                            );
                            
                            //check merchant id and product id is correct for given listing id
                            if (!$listing_id) //for listing insertion
                            {
                                $where = array();
                                $where['merchant_id'] = $merchant_id;
                                $where['product_id'] = $product_id;

                                $is_listing_exist = $this->Admin_model->selectRecords($where, 'product_listing', 'listing_id');
                                if (isset($is_listing_exist['db_error'])) 
                                    redirectWithMessage('Error: '.$is_listing_exist['msg'], $controller);
                                else if ($is_listing_exist) 
                                    $listing_id = $is_listing_exist['result'][0]['listing_id'];
                                else
                                {
                                    $data['create_date'] = $this->current_date;
                                    $insert_db_data[] = $data; 
                                }
                            }

                            if ($listing_id) //for update
                            {
                                $where = array();
                                $where['listing_id'] = $listing_id;
                                $where['merchant_id'] = $merchant_id;
                                $where['product_id'] = $product_id;

                                $is_listing_exist = $this->Admin_model->selectRecords($where, 'product_listing', 'listing_id');
                                if (isset($is_listing_exist['db_error'])) 
                                    redirectWithMessage('Error: '.$is_listing_exist['msg'], $controller);
                                else if (!$is_listing_exist) 
                                    redirectWithMessage('Error: Wrong combination of Listing ID, Merchant ID AND Product ID', $controller);
                                else
                                {
                                    $data['listing_id'] = $listing_id;
                                    $update_db_data[] = $data;
                                }
                            }
                        }
                    }
                }

                $i++;
            }

            //insert data in batch
            if (count($insert_db_data)>0)
                $isInserted = $this->Admin_model->insert_batch('product_listing', $insert_db_data);

            //update data in batch
            if (count($update_db_data)>0)
                $isUpdated = $this->Admin_model->update_batch('product_listing', $update_db_data, 'listing_id');

            if (!$isInserted && !$isUpdated) 
            {
                //delete all temporary files from system after use
                deleteFolder(TEMP_FOLDER_PATH, false);

                //redirect to current page
                redirectWithMessage('Excel file uploaded successfully!', $controller);
            }
        }

        redirectWithMessage('Error: something wrong with the excel uploading', $controller);
    }

    //import product listing detail
    public function importCountryXls()
    {
        $file_info = pathinfo($_FILES["result_file"]["name"]);
        $new_file_name = date("d-m-Y H:i:s A").".". $file_info["extension"];
        $controller = 'countryExcel';

        if(move_uploaded_file($_FILES["result_file"]["tmp_name"], TEMP_FOLDER_PATH.$new_file_name))
        {   
            $file_type = PHPExcel_IOFactory::identify(TEMP_FOLDER_PATH.$new_file_name);
            $objReader = PHPExcel_IOFactory::createReader($file_type);
            $this->objPHPExcel = $objReader->load(TEMP_FOLDER_PATH.$new_file_name);
            $sheet_data = $this->objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            
            $i = 1;
            $update_db_data = array();
            $insert_db_data = array();
            $isInserted = false;
            $isUpdated = false;
            
            //echo "<pre>"; print_r($sheet_data); die;
            foreach($sheet_data as $data)
            {
                if ($i > 1) 
                {
                    if($this->isEmptyRow($data)) 
                        continue;

                    //sheet row
                    $name = ($data['A']) ? $data['A'] : '';
                    $country_id = ($data['B']) ? $data['B'] : '';
                    $status = ($data['C']) ? $data['C'] : '';

                    if (!$name) 
                        redirectWithMessage('Error: name, status required', $controller);
                    else
                    {
                        //create data array for insert address
                        $data = array(
                            'name' => $name,
                            'status' => $status,
                            'update_date' => $this->current_date
                        );
                        
                        if ($country_id) //for update
                        {
                            $data['country_id'] = $country_id;
                            $update_db_data[] = $data;
                        }
                        else
                        {
                            $data['create_date'] = $this->current_date;
                            $insert_db_data[] = $data; 
                        }
                    }
                }

                $i++;
            }

            //insert data in batch
            if (count($insert_db_data)>0)
                $isInserted = $this->Admin_model->insert_batch('country', $insert_db_data);

            //update data in batch
            if (count($update_db_data)>0)
                $isUpdated = $this->Admin_model->update_batch('country', $update_db_data, 'country_id');

            if (!$isInserted && !$isUpdated) 
            {
                //delete all temporary files from system after use
                deleteFolder(TEMP_FOLDER_PATH, false);

                //redirect to current page
                redirectWithMessage('Excel file uploaded successfully!', $controller);
            }
        }

        redirectWithMessage('Error: something wrong with the excel uploading', $controller);
    }

    //import product listing detail
    public function importCityXls()
    {
        $file_info = pathinfo($_FILES["result_file"]["name"]);
        $new_file_name = date("d-m-Y H:i:s A").".". $file_info["extension"];
        $controller = 'cityExcel';

        if(move_uploaded_file($_FILES["result_file"]["tmp_name"], TEMP_FOLDER_PATH.$new_file_name))
        {   
            $file_type = PHPExcel_IOFactory::identify(TEMP_FOLDER_PATH.$new_file_name);
            $objReader = PHPExcel_IOFactory::createReader($file_type);
            $this->objPHPExcel = $objReader->load(TEMP_FOLDER_PATH.$new_file_name);
            $sheet_data = $this->objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            
            $i = 1;
            $update_db_data = array();
            $insert_db_data = array();
            $isInserted = false;
            $isUpdated = false;
            
            //echo "<pre>"; print_r($sheet_data); die;
            foreach($sheet_data as $data)
            {
                if ($i > 1) 
                {
                    if($this->isEmptyRow($data)) 
                        continue;

                    //sheet row
                    $name = ($data['A']) ? $data['A'] : '';
                    $city_id = ($data['B']) ? $data['B'] : '';
                    $lat = ($data['C']) ? $data['C'] : '';
                    $long = ($data['D']) ? $data['D'] : '';
                    $status = ($data['E']) ? $data['E'] : '';
                    $state_id = ($data['F']) ? $data['F'] : '';

                    if (!$name || !$state_id) 
                        redirectWithMessage('Error: name, state_id required', $controller);
                    else
                    {
                        if (!$lat || !$long) 
                        {
                            $address_data = array();
                            $address_data['state_id'] = $state_id;
                            $address_data['city_name'] = $name;
                            $address_values = getLatLongFromCity($address_data);

                            if (isset($address_values['msg'])) 
                                redirectWithMessage('Error: '.$address_values['msg'], $controller);

                            if ($address_values) 
                            {
                                $lat = $address_values['results'][0]['geometry']['location']['lat'];
                                $long = $address_values['results'][0]['geometry']['location']['lng'];
                            }
                        }

                        //create data array for insert address
                        $data = array(
                            'name' => $name,
                            'latitude' => $lat,
                            'longitude' => $long,
                            'state_id' => $state_id,
                            'status' => $status,
                            'update_date' => $this->current_date
                        );
                        
                        if ($city_id) //for update
                        {
                            $data['city_id'] = $city_id;
                            $update_db_data[] = $data;
                        }
                        else
                        {
                            $data['create_date'] = $this->current_date;
                            $insert_db_data[] = $data; 
                        }
                    }
                }

                $i++;
            }

            //insert data in batch
            if (count($insert_db_data)>0)
                $isInserted = $this->Admin_model->insert_batch('city', $insert_db_data);

            //update data in batch
            if (count($update_db_data)>0)
                $isUpdated = $this->Admin_model->update_batch('city', $update_db_data, 'city_id');

            if (!$isInserted && !$isUpdated) 
            {
                //delete all temporary files from system after use
                deleteFolder(TEMP_FOLDER_PATH, false);

                //redirect to current page
                redirectWithMessage('Excel file uploaded successfully!', $controller);
            }
        }

        redirectWithMessage('Error: something wrong with the excel uploading', $controller);
    }

    public function loadCityExcelPage()
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

        $country = $this->getCountry();
        $data['countries'] = $country['result'];

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/city', $data);
        $this->load->view('admin/include/footer');
    }

    private function getCity($status='', $state_id="", $city_id="")
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

    //export city xls sheet
    public function exportTemplateForCity($withData)
    {
        $controller = (isset($_GET['getCityList'])) ? 'cityExcel?getCityList='.$_GET['getCityList']: "cityExcel";

        //create template for address
        $fields = 'City Name, City ID, Latitude, Longitude, Status, State ID';
        $column_name = explode(',', $fields);

        // create cell columns same as defined in input file
        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
        $char = 'A';
        foreach ($column_name as $column) 
        {
            if ($char == 'Z') 
                break;

            $cell->setCellValue($char.'1', $column);
            $char++;
        }

        if ($withData) 
        {
            // get data from databse
            $cell_column_name = array('name', 'city_id', 'latitude', 'longitude', 'status', 'state_id');

            if (isset($_GET['getCityList']))
            {
                $ids = explode("-", $_GET['getCityList']);
                $stateId = $ids[1];

                $where = array('state_id' => $stateId);
            }
            else
                $where = "";

            $state_result = $this->Admin_model->selectRecords($where, 'city', 'name, city_id, latitude, longitude, status, state_id');
            if (isset($state_result['db_error'])) 
                redirectWithMessage('Error: '.$state_result['msg'], $controller);
            else if ($state_result) 
            {
                //insert data in excel sheet from database
                $i = 2;
                foreach($state_result['result'] as $row)
                {
                    $char = 'A';
                    
                    //insert data in cell for perticular column
                    foreach ($cell_column_name as $column) 
                    {
                        $cell = $this->objPHPExcel->setActiveSheetIndex(0);
                        $cell->setCellValue($char.$i, $row[trim($column)]);
                        
                        $char++;
                    }

                    $i++;
                }
            }
            else
                redirectWithMessage('Error: no record found', $controller);
        }

        $this->objPHPExcel->getActiveSheet()->setTitle('City');
        $this->objPHPExcel->setActiveSheetIndex(0);

        //create and download excel sheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="city.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function loadAreaExcelPage()
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
        if ( isset($areas['db_error']) ) 
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

        $country = $this->getCountry();
        $data['countries'] = $country['result'];

        $this->load->view('admin/include/header');
        $this->load->view('admin/include/leftbar');
        $this->load->view('excel/area', $data);
        $this->load->view('admin/include/footer');
    }

    public function getArea($area_id='', $city_id='', $status='')
    {
        $where = array();

        if ($area_id)
            $where['area_id'] = $area_id;

        if ($city_id)
            $where['city_id'] = $city_id;

        if (!empty($status))
            $where['status'] = $status;

        return $this->Admin_model->selectRecords($where, 'area', '*', array('area_name' => 'ASC'));
    }
}