<?php
/**
 * #example_image_info
 *
 * This sample code demonstrate how to check image info through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Coolsms\SenderID;
use Nurigo\Coolsms\CoolsmsException;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

try {
    // initiate rest api sdk object
    $rest = new SenderID($api_key, $api_secret);

    // image_id are mandatory. must be filled
    $image_id = ''; // image id

    $result = $rest->imageInfo($image_id);
    print_r($result);
} catch(CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getCode(); // get error code
}
