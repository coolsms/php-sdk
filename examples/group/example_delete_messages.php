<?php
/**
 * #example_send
 *
 * This sample code demonstrate how to delete messages through CoolSMS Rest API PHP v1.0
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

// options(group_id, message_ids) are mandatory. must be filled
$options->group_id = 'GID56CC00E21C4DC'; // ex) '1GCOLS23BDG'
$options->message_ids = '2838DFJFE02EI10TM'; // ex) '2838DFJFE02EI10TM','RGGBB11545'

$result = $rest->deleteMessages($options);			
print_r($result);
