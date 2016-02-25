<?php
/**
 * #example_sent
 *
 * This sample code demonstrate how to check sms result through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

// initiate rest api sdk object
$rest = new Nurigo\Coolsms($api_key, $api_secret);

// set necessary options
$options->mid = 'M52CB443257C61';			//message id 
// $options->gid = 'G52CB4432576C8';		//group id
// $options->count = '40';					//result return counts. default is 20
// $options->page = '1';					//page 
// $options->rcpt = '01012345678';			//search sent result by recipient number
// $options->start = '201401070915';		//set search start date  ex) 201401070915
// $options->end = '201401071230';			//set search end date	 ex) 201401071230

$result = $rest->sent($options);
print_r($result);
