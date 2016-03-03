<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Coolsms;

use Nurigo\Coolsms as Coolsms;
use Nurigo\Exceptions\CoolsmsSDKException;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * Sender ID management class, using the Rest API
 * @author NURIGO <contact@nurigo.net>
 */
class SenderID extends Coolsms
{
    function __construct($api_key, $api_secret, $basecamp = false)
    {
        // set api_key and api_secret
        parent::__construct($api_key, $api_secret, $basecamp = false);

        // set API and version
        $api = "senderid";
        $version = "1.1";
        $this->setResource($api, $version);
    }

    /**
     * @POST register method
     * @param $phone (required)
     * @param $site_user (optional)
     * @return json object(handle_key, ars_number)
     */
    public function register($phone, $site_user = null)
    {
        if (!isset($phone)) throw new CoolsmsSDKException('phone number is required',202);

        $options = new \stdClass();
        $options->phone = $phone;
        $options->site_user = $site_user;
        $this->setMethod('register', 1);
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
        if (!isset($handle_key)) throw new CoolsmsSDKException('handle_key is required',202);

        $options = new \stdClass();
        $options->handle_key = $handle_key;
        $this->setMethod('verify', 1);
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
        if (!isset($handle_key)) throw new CoolsmsSDKException('handle_key is required',202);

        $options = new \stdClass();
        $options->handle_key = $handle_key;
        $this->setMethod('delete', 1);
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * GET list method
     * @param $site_user (optional)
     * return json object(site_user, idno, phone_number, flag_default, updatetime, regdate)
     */
    public function senderidList($site_user = null)
    {
        if($site_user) $options->site_user = $site_user;

        $this->setMethod('list');
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
        if (!isset($handle_key)) throw new CoolsmsSDKException('handle_key is required',202);

        $options = new \stdClass();
        $options->handle_key = $handle_key;
        $options->site_user = $site_user;
        $this->setMethod('set_default', 1);
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * GET get_default
     * @param $site_user (optional)
     * return json object(handle_key, phone_number)
     */
    public function getDefault($site_user = null)
    {
        if($site_user) $options->site_user = $site_user;

        $this->setMethod('get_default');
        $this->addInfos();
        return $this->getResult();
    }
}
