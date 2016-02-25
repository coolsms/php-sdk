<?php
/**
 * #example_delete_group
 *
 * This sample code demonstrate how to delete sms group through CoolSMS Rest API PHP
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

// options(group_ids) are mandatory. must be filled
$options->group_ids = 'GID56CC00E21C4DC'; // ex) '1GCOLS23BDG','RGGBB11545'

$result = $rest->deleteGroups($options);			
print_r($result);
