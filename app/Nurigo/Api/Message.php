<?php
/*- coding: utf-8 -*/
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Coolsms;

use Nurigo\Coolsms as Coolsms;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * Message management class, using the Rest API
 * @author NURIGO <contact@nurigo.net>
 */
class Message extends Coolsms
{
    /**
     * @POST send method
     * @param $options (options can be optional)
     * @to, from, text, type, image, refname, country, datetime, mid, gid, subject, charset (optional)
     * @returns an object(recipient_number, group_id, message_id, result_code, result_message)
     */
    public function send($options) 
    {
        $this->setMethod('sms', 'send', 1);
        $this->addInfos($options);    
        return $this->result;
    }
    
    /**
     * @GET sent method
     * @param $options (options can be optional)
     * @count, page, s_rcpt, s_start, s_end, mid, gid (optional)
     * @returns an object(total count, list_count, page, data['type', 'accepted_time', 'recipient_number', 'group_id', 'message_id', 'status', 'result_code', 'result_message', 'sent_time', 'text'])
     */
    public function sent($options) 
    {
        $this->setMethod('sms', 'sent', 0);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @POST cancel method
     * @param $options (options can be optional)
     * @mid, gid (either one must be entered.)
     */
    public function cancel($options) 
    {
        if (!$options->mid && !$options->gid) throw new CoolsmsException('"mid or gid" either one must be entered');
        $this->setMethod('sms', 'cancel', 1);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @GET balance method
     * @options(none)
     * @return an object(cash, point)
     */
    public function balance() 
    {
        $this->setMethod('sms', 'balance', 0);
        $this->addInfos();    
        return $this->result;
    }

    /**
     * @GET status method
     * @param $options (options can be optional)
     * @return an object(registdate, sms_average, sms_sk_average, sms_kt_average, sms_lg_average, mms_average, mms_sk_average, mms_kt_average, mms_lg_average)
     * this method is made for Coolsms inc. internal use
     */
    public function status($options) 
    {
        $this->setMethod('sms', 'status', 0);
        $this->addInfos();    
        return $this->result;
    }
}
