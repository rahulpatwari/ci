<?php
//CURRANCY FORMAT
function currency_format($val, $symbol='&#x20b9;&nbsp;', $r=2)
{
	error_reporting(0);
	
	$n = $val; 
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n = number_format(abs($n),$r); 
    $j = (($j = strlen($i)) > 3) ? $j % 3 : 0; 

   	$a = $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;

   return $a;
}

//PRINT RATING STAR
function printRatingStars($rating)
{
	if (isset($_SESSION['merchant_id'])) 
		$star = "glyphicon glyphicon-star";
	else
		$star = "icon-star";

	for ($i=0; $i < 5; $i++) 
	{ 
		if ($i < round($rating)) 
			echo '<button class="btn btn-warning btn-sm" aria-label="Left Align">
					<span class="'.$star.'" aria-hidden="true"></span>
				</button>&nbsp;';
		else
			echo '<button class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
				  	<span class="'.$star.'" aria-hidden="true"></span>
				</button>&nbsp;';
	}
}

//GET TIME IN AGO FORMAT
function time_elapsed_string($ptime) 
{
    $ptime = strtotime($ptime);
    $estimate_time = time() - $ptime;

    if($estimate_time < 1)
        return 'less than 1 second ago';

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
            );

    foreach($condition as $secs => $str)
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

//CALCULATE DISTANCE
function distance($lat1, $lon1, $unit=KILOMETERS) 
{
    if (!isset($_COOKIE['latitude']) && !isset($_COOKIE['longitude'])) 
        return "";
    else
    {
        $lat2 = $_COOKIE['latitude'];
        $lon2 = $_COOKIE['longitude'];
    }

    if (($lat1 == $lat2) && ($lon1 == $lon2))
        return 0;
    else 
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K")
            $dist = $miles * 1.609344;
        else if ($unit == "N")
            $dist = $miles * 0.8684;
        else
            $dist = $miles;

        return round($dist, 2).' KM';
    }
}

//CALCULATE OFF
function calculatePercentage($oldFigure, $newFigure)
{
    $percentChange = (($oldFigure - $newFigure) / $oldFigure) * 100;
    return round(abs($percentChange), 2);
}

//-- function for converting time according to timezone
function convert_to_user_date($date, $format = 'j-n-Y g:i:s A', $serverTimeZone = 'UTC')
{
    $userTimeZone = isset($_COOKIE['timezone']) ? $_COOKIE['timezone'] : $serverTimeZone;
    
    try 
    {
        $dateTime = new DateTime ($date, new DateTimeZone($serverTimeZone));
        $dateTime->setTimezone(new DateTimeZone($userTimeZone));

        return $dateTime->format($format);
    } 
    catch (Exception $e) 
    {
        return '';
    }
}

//show fixed(limited) character
function showLimitedCharacter($string, $total=100)
{
    if (strlen($string) > $total) 
        return substr($string, 0, $total)."....";
    else
        return $string;
}

//get lat long from address
function getLAtLongFromAddress($address_data)
{
    $ci = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $ci->load->model('Admin_model', 'am');

    // get country name from databse
    $country_result = $ci->am->selectRecords(array('country_id' => $address_data['country_id']), 'country', 'name');
    if (isset($country_result['db_error'])) 
        return $country_result;
    else if ($country_result) 
        $country_name = $country_result['result'][0]['name'];
    else
        $country_name = '';

    // get state name from databse
    $state_result = $ci->am->selectRecords(array('state_id' => $address_data['state_id']), 'state', 'name');
    if (isset($state_result['db_error'])) 
        return $state_result;
    else if ($state_result) 
        $state_name = $state_result['result'][0]['name'];
    else
        $state_name = '';

    // get city name records from databse
    $city_result = $ci->am->selectRecords(array('city_id' => $address_data['city_id']), 'city', 'name');
    if (isset($city_result['db_error'])) 
        return $city_result;
    else if ($city_result) 
        $city_name = $city_result['result'][0]['name'];
    else
        $city_name = '';

    $address_line_1 = isset($address_data['address_line_1']) ? $address_data['address_line_1'] : "";
    $address_line_2 = isset($address_data['address_line_2']) ? $address_data['address_line_2'] : "";
    $landmark = isset($address_data['landmark']) ? $address_data['landmark'] : "";
    $pin = isset($address_data['pin']) ? $address_data['pin'] : "";

    $address = $address_line_1.'+'.$address_line_2.'+'.$landmark.'+'.$city_name.'+'.$pin.'+'.$state_name.'+'.$country_name;

    if ($address) 
    {
        $address = preg_replace('/\s+/', '+', $address);

        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false&key='.GOOGLE_MAP_API_KEY);

        $output = json_decode($geocode);
        if($output->status == "OK")
            return $output;
    }

    return false;
}

function getLatLongFromCity($address_data)
{
    $state_name = '';
    $country_name = '';
    $ci = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $ci->load->model('Admin_model', 'am');

    // get state name from databse
    $state_result = $ci->am->selectRecords(array('state_id' => $address_data['state_id']), 'state', 'name, country_id');
    if (isset($state_result['db_error'])) 
        return $state_result;
    else if ($state_result) 
    {
        $state_name = $state_result['result'][0]['name'];
        $country_id = $state_result['result'][0]['country_id'];

        // get country name from databse
        $country_result = $ci->am->selectRecords(array('country_id' => $country_id), 'country', 'name');
        if (isset($country_result['db_error'])) 
            return $country_result;
        else if ($country_result) 
            $country_name = $country_result['result'][0]['name'];
    }

    $address = $address_data['city_name'].'+'.$state_name.'+'.$country_name;

    if ($address) 
    {
        $address = preg_replace('/\s+/', '+', $address);

        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false&key='.GOOGLE_MAP_API_KEY);

        $output = json_decode($geocode);
        if($output->status == "OK")
        {
            $output = json_decode(json_encode($output), True);

            return $output;
        }
    }

    return false;
}

//redirect page with message
function redirectWithMessage($msg, $controller)
{
    echo "<script>
            window.alert('".$msg."');
            window.location.href = '".base_url($controller)."';
        </script>";
    die;
}

//delete folder with files
function deleteFolder($folder_path='', $delete_folder_with_files=true)
{
    if ($folder_path) 
    {
        $files = glob($folder_path.'/{,.}*', GLOB_BRACE); // get all file names
        foreach($files as $file)
        {
            if(is_file($file))
                unlink($file); // delete file
        }

        if ($delete_folder_with_files)
            rmdir($folder_path);

        return true;
    }
    else
        return false;
}

//-- function for send email
function sendEmail($to='', $subject='', $message='', $atch='')
{
    if (!$to || !$subject || !$message) 
        return false;
    
    $ci = get_instance();
    $ci->load->library('email');

    $config['protocol']  = EMAIL_PROTOCOL;
    $config['smtp_host'] = EMAIL_HOST;
    $config['smtp_port'] = EMAIL_PORT;
    $config['smtp_user'] = EMAIL_USERNAME;
    $config['smtp_pass'] = EMAIL_PASSWORD;
    $config['charset']   = "utf-8";
    $config['mailtype']  = "html";
    $config['newline']   = "\r\n";

    $ci->email->initialize($config);
    $ci->email->from(EMAIL_ID, EMAIL_NAME);
    $ci->email->to($to);
    $ci->email->reply_to(EMAIL_ID, EMAIL_NAME);
    $ci->email->subject(ucfirst($subject));
    $ci->email->message($message);

    if ($atch)
        $ci->email->attach($atch);

    if($ci->email->send())
        return true;
    else
        return false;
}
