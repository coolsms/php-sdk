<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Api;

use Nurigo\Coolsms;
use Nurigo\Exceptions\CoolsmsSDKException;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * @class Message
 * @brief management message, using Rest API
 */
class Message extends Coolsms
{
    /**
     * @brief send message ( HTTP Method POST )
     * @param $options (options can be optional)
     * @param to, from, text, type, image, refname, country, datetime, mid, gid, subject, charset (optional)
     * @return object(recipient_number, group_id, message_id, result_code, result_message)
     */
    public function send($options) 
    {
        // require field 'to', 'from', 'text' check
        if (!isset($options->to) || !isset($options->from) || !isset($options->text)) throw new CoolsmsSDKException('"to, from, text" is must be entered',202);
        $this->setMethod('send', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }
    
    /**
     * @brief sent message list ( HTTP Method GET )
     * @param $options (options can be optional)
     * @param count, page, s_rcpt, s_start, s_end, mid, gid (optional)
     * @return object(total count, list_count, page, data['type', 'accepted_time', 'recipient_number', 'group_id', 'message_id', 'status', 'result_code', 'result_message', 'sent_time', 'text'])
     */
    public function sent($options) 
    {
        $this->setMethod('sent');
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief cancel reserve message ( HTTP Method POST )
     * @param $options (options can be optional)
     * @param mid, gid (either one must be entered.)
     * @return none
     */
    public function cancel($mid = null, $gid = null) 
    {
        // mid or gid is empty. throw exception
        if (!$mid && !$gid) throw new CoolsmsSDKException('mid or gid either one must be entered',202);
        $this->setMethod('cancel', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief get remaining balance ( HTTP Method GET )
     * @param $options(none)
     * @return object(cash, point)
     */
    public function balance() 
    {
        $this->setMethod('balance');
        $this->addInfos();    
        return $this->getResult();
    }

    /**
     * @brief status ( HTTP Method GET )
     * @param $options (options can be optional)
     * @return object(registdate, sms_average, sms_sk_average, sms_kt_average, sms_lg_average, mms_average, mms_sk_average, mms_kt_average, mms_lg_average)
     */
    public function status($options) 
    {
        $this->setMethod('status');
        $this->addInfos($options);
        return $this->getResult();
    }
}
