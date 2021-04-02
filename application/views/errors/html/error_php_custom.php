<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$msg['Severity'] = $severity;
$msg['Message'] = $message;
$msg['Filename'] = $filepath;
$msg['Line Number'] = $line;

if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
{
	$i = 0;
	foreach (debug_backtrace() as $error)
	{
		if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0)
		{
			$backtrace[$i]['file'] = $error['file'];
			$backtrace[$i]['line'] = $error['line'];
			$backtrace[$i]['function'] = $error['function'];

			$i++;
		}
	}

	$msg['backtrace'] = $backtrace;
}

$arrayResponse = array();
$arrayResponse['code'] = CODE_ERROR_PHP_NOTICE;
$arrayResponse['msg'] = $msg;
$arrayResponse['response_date_time'] = date("Y-m-d H:i:s");

echo json_encode($arrayResponse);
?>