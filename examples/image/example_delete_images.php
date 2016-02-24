<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to delete images through CoolSMS Rest API PHP v1.0
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

// options(image_ids) are mandatory. must be filled
$options->image_ids = ''; // image ids. ex)'IM34BWIDJ12','IMG2559GBB'

$result = $rest->deleteImages($options);			
print_r($result);
