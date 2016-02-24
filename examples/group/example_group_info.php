<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to check group info CoolSMS Rest API PHP
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

// options(group_id) are mandatory. must be filled
$options->group_id = ''; // group id

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

$result = $rest->groupInfo($options);			
print_r($result);
