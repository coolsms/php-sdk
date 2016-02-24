<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to verify sender number through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$apikey = '#ENTER_YOUR_OWN#';
$apisecret = '#ENTER_YOUR_OWN#';

// initiate rest api sdk object
$rest = new Nurigo\Coolsms($apikey, $apisecret);

// options(handle_key) are mandatory. must be filled
$options->handle_key = 'C29CE02IOE9'; // after register call. return value

$result = $rest->verify($options);			
print_r($result);
