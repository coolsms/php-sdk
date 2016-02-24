<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to add messages into group through CoolSMS Rest API PHP
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

// Optional parameters for your own needs
// $options->to = '01000000000';
// $options->from = '01000000000';
// $options->type = 'SMS';
// $options->text = '안녕하세요. 10000건을 20초안에 발송하는 빠르고 저렴한 CoolSMS의 테스팅 문자입니다. ';
// $options->image_id = 'IM289E9CISNWIC'					// image_id. type must be set as 'MMS'
// $options->refname = '';					// Reference name 
// $options->country = 82;					// Korea(82) Japan(81) America(1) China(86) Default is Korea
// $options->datetime = '20140106153000';	// Format must be(YYYYMMDDHHMISS) 2014 01 06 15 30 00 (2014 Jan 06th 3pm 30 00)
// $options->subject = 'Hello World';		// set msg title for LMS and MMS
// $options->delay = 10;					// '0~20' delay messages

$result = $rest->addMessages($options);			
print_r($result);
