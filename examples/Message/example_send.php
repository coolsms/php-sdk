<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to send sms through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Api\Message;
use Nurigo\Exceptions\CoolsmsException;

require_once __DIR__ . "/../../bootstrap.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = '#ENTER_YOUR_OWN#';
$api_secret = '#ENTER_YOUR_OWN#';

try {
    // initiate rest api sdk object
    $rest = new Message($api_key, $api_secret);

    // 4 options(to, from, type, text) are mandatory. must be filled
    $options = new stdClass();
    $options->to = '01000000000';
    $options->from = '01000000000';
    $options->type = 'MMS';
    $options->text = '안녕하세요. 10000건을 20초안에 발송하는 빠르고 저렴한 CoolSMS의 테스팅 문자입니다. ';
    $options->app_version = 'test app 1.2';  //application name and version     

    // Optional parameters for your own needs
    // $options->image = '../Image/images/test.jpg'; // image for MMS. type must be set as 'MMS'
    // $options->refname = '';                       // Reference name 
    // $options->country = 'KR';                     // Korea(KR) Japan(JP) America(USA) China(CN) Default is Korea
    // $options->datetime = '20140106153000';        // Format must be(YYYYMMDDHHMISS) 2014 01 06 15 30 00 (2014 Jan 06th 3pm 30 00)
    // $options->mid = 'mymsgid01';                  // set message id. Server creates automatically if empty
    // $options->gid = 'mymsg_group_id01';           // set group id. Server creates automatically if empty
    // $options->subject = 'Hello World';            // set msg title for LMS and MMS
    // $options->charset = 'euckr';                  // For Korean language, set euckr or utf-8

    $result = $rest->send($options);            
    print_r($result);
} catch(CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getCode(); // get error code
}
