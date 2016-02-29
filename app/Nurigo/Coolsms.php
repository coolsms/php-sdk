<?php
/*- coding: utf-8 -*/
/* vi:set sw=4 ts=4 expandtab: */

/**
 * Copyright (C) 2008-2015 NURIGO
 * http://www.coolsms.co.kr
 * Version 1.1
 **/

namespace Nurigo;

// check php extension "curl_init, json_decode"
if (!function_exists('curl_init')) {
  throw new CoolsmsException('Coolsms needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new CoolsmsException('Coolsms needs the JSON PHP extension.');
}

/**
 * Coolsms Rest API core class, using the Rest API
 * @author NURIGO <contact@nurigo.net>
 */
class Coolsms
{
    const HOST = "http://rest2.coolsms.co.kr";
    const VERSION = "1.5";
    const SDK_VERSION = "1.1";

    private $api_key;
    private $api_secret;
    private $resource;
    private $path;
    private $method;
    private $timestamp;
    private $salt;
    private $result;
    private $basecamp;
    private $user_agent;
    private $content;

    /**
     * @brief Construct
     */
    public function __construct($api_key, $api_secret, $basecamp = false)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        if (isset($_SERVER['HTTP_USER_AGENT'])) $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        if ($basecamp) $this->basecamp = true;
    }

    /**
     * @brief Process curl
     */
    public function curlProcess()
    {
        $ch = curl_init(); 
        // Set host. 1 = POST , 0 = GET
        if ($this->method == 1) {
            $host = sprintf("%s/%s/%s/%s", self::HOST, $this->resource, self::VERSION, $this->path);
        } else {
            $host = sprintf("%s/%s/%s/%s?%s", self::HOST, $this->resource, self::VERSION, $this->path, $this->content);
        }

        // Set curl info
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSLVERSION, 3); // SSL version (need for https connect)
        curl_setopt($ch, CURLOPT_HEADER, 0); // output header (1 = true, 0 = false) 
        curl_setopt($ch, CURLOPT_POST, $this->method); // POST GET method

        // Set POST DATA
        if ($this->method) {
            $header = array("Content-Type:multipart/form-data");

            // route가 있으면 header에 붙여준다. substr 해준 이유는 앞에 @^가 붙기 때문에 자르기 위해서.
            if (isset($this->content['route'])) $header[] = "User-Agent:" . substr($this->content['route'], 1);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->content); 
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // TimeOut value
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // curl_exec() result output (1 = true, 0 = false)

        $this->result = json_decode(curl_exec($ch));
        if (isset($this->result->code)) throw new CoolsmsException($this->result->message, $this->result->code);

        // Check connect errors
        if (isset(curl_errno($ch))) throw new CoolsmsException(curl_error($ch));
        curl_close($ch);
    }

    /**
     * @brief Set http body content
     */
    private function setContent($options)
    {
        // POST method content
        if ($this->method) {
            $this->content = array();
            foreach ($options as $key => $val) {
                if ($key != "text") $val = trim($val);
                
                if ($key == "image") {
                    $this->content[$key] = "@" . realpath("./$val");
                } else {
                    $this->content[$key] = sprintf("%s", $val);
                }
            }
            return;
        }

        // GET method content
        foreach ($options as $key => $val) {
            if ($key != "text") $val = trim($val);
            $this->content .= $key . "=" . urlencode($val) . "&";
        }
    }

    /**
     * @biref Make a signature with hash_hamac then return the signature
     */
    private function getSignature()
    {
        return hash_hmac('md5', (string)$this->timestamp . $this->salt, $this->api_secret);
    }

    /**
     * @brief Set authenticate information
     */
    protected function addInfos($options = null)
    {
        if (!isset($options)) $options = new \stdClass();

        $this->salt = uniqid();
        $this->timestamp = (string)time();
        if (!isset($options->User_Agent)) $options->User_Agent = sprintf("PHP REST API %s", self::VERSION);
        if (!isset($options->os_platform)) $options->os_platform = $this->getOS();
        if (!isset($options->dev_lang)) $options->dev_lang = sprintf("PHP %s", phpversion());
        if (!isset($options->sdk_version)) $options->sdk_version = sprintf("PHP SDK %s", self::SDK_VERSION);

        $options->salt = $this->salt;
        $options->timestamp = $this->timestamp;

        // If basecamp is true '$coolsms_user' use
        isset($this->basecamp) ? $options->coolsms_user = $this->api_key : $options->api_key = $this->api_key;

        $options->signature = $this->getSignature();
        $this->setContent($options);
        $this->curlProcess();
    }

    /**
     * $resource
     * 'sms', 'senderid', 'group'
     * $method 
     * GET = 0(default), POST, 1
     * $path
     * sms['send' 'sent' 'cancel' 'balance']
     * senderid['register' 'verify' 'delete' 'list' 'set_default' 'get_default']
     * group['new_group' 'group_list' 'delete_groups' 'groups/{group_id}' 'groups/{group_id}/add_messages' 
     *       'groups/{group_id}/message' 'groups/{group_id}/delete_messages' 'groups/{group_id}/send]
     * image['image_list' 'images/{image_id}' 'upload_image' 'delete_image']
     */
    protected function setMethod($resource, $path, $method = 0)
    {
        $this->resource = $resource;
        $this->path = $path;
        $this->method = $method;
    }

    /**
     * @brief Return result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @brief Return user's current OS
     */
    function getOS()
    {
        $user_agent = $this->user_agent;
        $os_platform = "Unknown OS Platform";
        $os_array = array(
                                '/windows nt 10/i'     =>  'Windows 10',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile'
                         );

        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }   
        return $os_platform;
    }

    /**
     * @brief Return user's current browser
     */
    function getBrowser() 
    {
        $user_agent = $this->user_agent;
        $browser = "Unknown Browser";
        $browser_array = array(
                                '/msie/i'       =>  'Internet Explorer',
                                '/firefox/i'    =>  'Firefox',
                                '/safari/i'     =>  'Safari',
                                '/chrome/i'     =>  'Chrome',
                                '/opera/i'      =>  'Opera',
                                '/netscape/i'   =>  'Netscape',
                                '/maxthon/i'    =>  'Maxthon',
                                '/konqueror/i'  =>  'Konqueror',
                                '/mobile/i'     =>  'Handheld Browser'
                         );
        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }
}
