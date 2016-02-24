<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to delete sms group through CoolSMS Rest API PHP v1.0
 * for more info, visit
 * www.coolsms.co.kr
 */

use CS;

require_once __DIR__ . "/../../vendor/autoload.php";

// api_key and api_secret can be obtained from www.coolsms.co.kr/credentials
$apikey = '#ENTER_YOUR_OWN#';
$apisecret = '#ENTER_YOUR_OWN#';

// initiate rest api sdk object
$rest = new CS\Coolsms($apikey, $apisecret);
$options->timestamp = (string)time();

// options(group_ids) are mandatory. must be filled
$options->group_ids = 'GID56CC00E21C4DC'; // ex) '1GCOLS23BDG','RGGBB11545'

$result = $rest->deleteGroups($options);			
print_r($result);
