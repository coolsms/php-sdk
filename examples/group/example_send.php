<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to send group sms through CoolSMS Rest API PHP v1.0
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
$options->group_id = 'GID56CC00E21C4DC'; // ex) '1GCOLS23BDG'

$result = $rest->sendGroupMessage($options);			
print_r($result);
