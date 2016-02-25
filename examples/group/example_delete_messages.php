<?php
/**
 * #example_delete_messages
 *
 * This sample code demonstrate how to delete messages through CoolSMS Rest API PHP
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

// options(group_id, message_ids) are mandatory. must be filled
$options->group_id = 'GID56CC00E21C4DC'; // ex) '1GCOLS23BDG'
$options->message_ids = '2838DFJFE02EI10TM'; // ex) '2838DFJFE02EI10TM','RGGBB11545'

$result = $rest->deleteMessages($options);			
print_r($result);
