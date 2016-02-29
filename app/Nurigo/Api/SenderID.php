<?php
/*- coding: utf-8 -*/
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo;

use Nurigo\Coolsms as Coolsms;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * Sender ID management class, using the Rest API
 * @author NURIGO <contact@nurigo.net>
 */
class SenderID extends Coolsms
{
    /**
     * @POST register method
     * @param $phone (required)
     * @param $site_user (optional)
     * @return json object(handle_key, ars_number)
     */
    public function register($phone, $site_user = null)
    {
        if (!isset($phone)) throw new CoolsmsException('phone number is required');

        $options->phone = $phone;
        $options->site_user = $site_user;
        $this->setMethod('senderid', 'register', 1);
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * @POST verify method
     * @param $handle_key (required)
     * return nothing
     */
    public function verify($handle_key)
    {
        if (!isset($handle_key)) throw new CoolsmsException('handle_key is required');

        $options->handle_key = $handle_key;
        $this->setMethod('senderid', 'verify', 1);
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * POST delete method
     * @param $handle_key (required)
     * return nothing
     */
    public function delete($handle_key)
    {
        if (!isset($handle_key)) throw new CoolsmsException('handle_key is required');

        $options->handle_key = $handle_key;
        $this->setMethod('senderid', 'delete', 1);
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * GET list method
     * @param $site_user (optional)
     * return json object(site_user, idno, phone_number, flag_default, updatetime, regdate)
     */
    public function senderidList($site_user)
    {
        if(isset($site_user)) $options->site_user = $site_user;

        $this->setMethod('senderid', 'list');
        $this->addInfos();
        return $this->getResult();
    }

    /**
     * POST set_default
     * @param $phone (required)
     * @param $site_user (optional)
     * return nothing
     */
    public function setDefault($handle_key, $site_user = null)
    {
        if (!isset($handle_key)) throw new CoolsmsException('handle_key is required');

        $options->handle_key = $handle_key;
        $options->site_user = $site_user;
        $this->setMethod('senderid', 'set_default', 1);
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * GET get_default
     * @param $site_user (optional)
     * return json object(handle_key, phone_number)
     */
    public function getDefault($site_user)
    {
        if(isset($site_user)) $options->site_user = $site_user;

        $this->setMethod('senderid', 'get_default');
        $this->addInfos();
        return $this->getResult();
    }
}
