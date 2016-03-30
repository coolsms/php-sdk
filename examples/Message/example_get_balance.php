<?php
/**
 * #example_balance
 *
 * This sample code demonstrate how to check cash & point balance through CoolSMS Rest API PHP
 * for more info, visit
 * www.coolsms.co.kr
 */

use Nurigo\Api\Message;
use Nurigo\Exceptions\CoolsmsException;

require_once __DIR__ . "/../../bootstrap.php";


// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$api_key = 'CS558104628ADED';
$api_secret = '983C21FB95000DCBD2A1C4FE25F14883';

try {
    // initiate rest api sdk object
    $rest = new Message($api_key, $api_secret);

    $result = $rest->getBalance();
    print_r($result);
} catch (CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getCode(); // get error code
}
