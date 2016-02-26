<?php
/**
 * #example_new_group
 *
 * This sample code demonstrate how to create sms group through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Coolsms as Coolsms;
use Nurigo\CoolsmsException as CoolsmsException;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

try {
    // initiate rest api sdk object
    $rest = new Nurigo\Coolsms($api_key, $api_secret);

    // Optional parameters for your own needs
    // $options->charset = 'utf8'; 				// utf8, euckr default value is utf8
    // $options->srk = '';						// Solution key
    // $options->mode = 'test';					// If 'test' value. refund cash to point
    // $options->delay = 10;					// '0~20' delay messages
    // $options->force_sms = true;				// 'true or false' always send sms 
    // $options->os_platform = '';				// Client OS
    // $options->dev_lang = '';					// Development language 
    // $options->sdk_version = '';				// SDK version ex) PHP SDK 1.2
    // $options->app_version = '';				// App version

    $result = $rest->newGroup($options);			
	print_r($result);
} catch(Nurigo\CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getResponseCode(); // get 'api.coolsms.co.kr' response code
}
