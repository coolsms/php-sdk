<?php
/**
 * #example_image_info
 *
 * This sample code demonstrate how to check image info through CoolSMS Rest API PHP
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

    // options(image_id) are mandatory. must be filled
    $options->image_id = ''; // image id

    $result = $rest->imageInfo($options);
	print_r($result);
} catch(Nurigo\CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getResponseCode(); // get 'api.coolsms.co.kr' response code
}
