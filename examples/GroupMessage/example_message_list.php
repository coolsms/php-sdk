<?php
/**
 * #example_message_list
 *
 * This sample code demonstrate check message list through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Api\GroupMessage;
use Nurigo\Exceptions\CoolsmsException;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

try {
    // initiate rest api sdk object
    $rest = new GroupMessage($api_key, $api_secret);

    // Optional parameters for your own needs
	$options = new stdClass();
	$options->group_id = 'GID56CC00E21C4DC'; // group id
    // $options->offset = 0; // default 0
    // $options->limit = 20; // default 20

    $result = $rest->messageList($options);
    print_r($result);
} catch(CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getCode(); // get error code
}
