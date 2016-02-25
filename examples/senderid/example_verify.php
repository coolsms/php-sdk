<?php
/**
 * #example_verify
 *
 * This sample code demonstrate how to verify sender number through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

// initiate rest api sdk object
$rest = new Nurigo\Coolsms($api_key, $api_secret);

// options(handle_key) are mandatory. must be filled
$options->handle_key = 'C29CE02IOE9'; // after register call. return value

$result = $rest->verify($options);			
print_r($result);
