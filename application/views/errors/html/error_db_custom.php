<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//custom error message
$arrayResponse = array();
$arrayResponse['code'] = CODE_ERROR_DB;
$arrayResponse['msg'] = $message;
$arrayResponse['response_date_time'] = date("Y-m-d H:i:s");

echo json_encode($arrayResponse);
?>