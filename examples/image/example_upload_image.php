<?php
/**
 * #example_upload_image
 *
 * This sample code demonstrate how to upload image through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Coolsms\SenderID as SenderID;
use Nurigo\CoolsmsException as CoolsmsException;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

try {
    // initiate rest api sdk object
    $rest = new Nurigo\Coolsms\SenderID($api_key, $api_secret);

    // image are mandatory. must be filled
    $image = 'images/test.jpg'; // image

    // Optional parameters for your own needs
    // $encoding = 'binary'; // image encoding type (base64, binary) default binary

    $result = $rest->uploadImage($image); // or $rest->uploadImage($image, $encoding)
	print_r($result);
} catch(Nurigo\CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getResponseCode(); // get 'api.coolsms.co.kr' response code
}
