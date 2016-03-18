<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Api;

use Nurigo\Coolsms;
use Nurigo\Exceptions\CoolsmsSDKException;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * @class SenderID 
 * @brief management sender id, using the Rest API
 */
class SenderID extends Coolsms
{
    /**
     * @brief change api name and api version
     * @param $api_key, $api_secret, $basecamp ($api_key, $api_secret must be entered)
     * @return object(group_id)
     */
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
     * @brief sender id registration request ( HTTP Method POST )
     * @param $phone (required), $site_user (optional)
     * @return object(handle_key, ars_number)
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
     * @brief verify sender id ( HTTP Method POST )
     * @param $handle_key (required)
     * @return none 
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
     * @brief delete sender id ( HTTP Method POST )
     * @param $handle_key (required)
     * @return none
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
     * @brief get sender id list ( HTTP Method GET )
     * @param $site_user (optional)
     * @return object(site_user, idno, phone_number, flag_default, updatetime, regdate)
     */
    public function senderidList($site_user = null)
    {
        if($site_user) $options->site_user = $site_user;

        $this->setMethod('list');
        $this->addInfos();
        return $this->getResult();
    }

    /**
     * @brief set default sender id ( HTTP Method POST )
     * @param $phone (required), $site_user (optional)
     * @return none 
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
     * @brief get default sender id ( HTTP Method GET )
     * @param $site_user (optional)
     * @return object(handle_key, phone_number)
     */
    public function getDefault($site_user = null)
    {
        if($site_user) $options->site_user = $site_user;

        $this->setMethod('get_default');
        $this->addInfos();
        return $this->getResult();
    }
}
