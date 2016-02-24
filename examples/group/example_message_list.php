<?php
/**
 * #example_send
 *
 * This sample code demonstrate check message list through CoolSMS Rest API PHP v1.0
 * for more info, visit
 * www.coolsms.co.kr
 */

use CS;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$apikey = '#ENTER_YOUR_OWN#';
$apisecret = '#ENTER_YOUR_OWN#';

// initiate rest api sdk object
$rest = new CS\Coolsms($apikey, $apisecret);
$options->timestamp = (string)time();

// Optional parameters for your own needs
// $options->offset = 0; // default 0
// $options->limit = 20; // default 20

$result = $rest->messageList($options);
print_r($result);
