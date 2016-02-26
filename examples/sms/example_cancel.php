<?php
/** 
 * #example_cancel
 *
 * This sample code demonstrate how to cancel reserved sms through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Coolsms\Message as Message;
use Nurigo\CoolsmsException as CoolsmsException;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

try {
	// initiate rest api sdk object 
	$rest = new Nurigo\Coolsms\Message($api_key, $api_secret);

	// Either mid or gid must be entered. 
	$options->mid = 'M52CB443257C61'; // message id. 
	// $options->gid = 'G52CB4432576C8'; // group id. 

	$result = $rest->cancel($options); // cancel does not return any.
} catch(Nurigo\CoolsmsException $e) {
	echo $e->getMessage(); // get error message
	echo $e->getResponseCode(); // get 'api.coolsms.co.kr' response code
}
