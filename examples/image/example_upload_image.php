<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to upload image through CoolSMS Rest API PHP v1.0
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

// options(image) are mandatory. must be filled
$options->image = 'images/test.jpg'; // image

// Optional parameters for your own needs
// $options->encoding = 'binary'; // image encoding type (base64, binary) default binary

$result = $rest->uploadImage($options);			
print_r($result);
