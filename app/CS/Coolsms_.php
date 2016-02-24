<?php

/**
 * Copyright (C) 2008-2015 NURIGO
 * http://www.coolsms.co.kr
 * Version 1.1
 **/

// check php extension "curl_init, json_decode"
if (!function_exists('curl_init')) {
  throw new Exception('Coolsms needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Coolsms needs the JSON PHP extension.');
}

/**
 * Message management class, using the Rest API
 * @author NURIGO <contact@nurigo.net>
 */
class Coolsms
{
    const HOST = "http://api.coolsms.co.kr";
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

    /**
     * @brief Construct
     */
    public function __construct($api_key, $api_secret, $basecamp=false)
	{
		$this->api_key = $api_key;
        $this->api_secret = $api_secret;
		$this->user_agent = $_SERVER['HTTP_USER_AGENT'];

		if ($basecamp) $this->basecamp = true;
    }

    /**
     * @brief Process curl
     */
    public function curlProcess()
    {
        $ch = curl_init(); 
        // Set host. 1 = POST , 0 = GET
        $host = sprintf("%s/%s/%s/%s?%s", self::HOST, $this->resource, self::VERSION, $this->path, $this->content);
        if ($this->method==1) $host = sprintf("%s/%s/%s/%s", self::HOST, $this->resource, self::VERSION, $this->path);

		// Set curl info
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSLVERSION,3); // SSL version (need for https connect)
        curl_setopt($ch, CURLOPT_HEADER, 0); // output header (1 = true, 0 = false) 
        curl_setopt($ch, CURLOPT_POST, $this->method); // POST GET method

        // Set POST DATA
        if ($this->method) {
            $header = array("Content-Type:multipart/form-data");

            // route가 있으면 header에 붙여준다. substr 해준 이유는 앞에 @^가 붙기 때문에 자르기 위해서.
            if ($this->content['route']) $header[] = "User-Agent:" . substr($this->content['route'], 1);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->content); 
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // TimeOut value
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // curl_exec() result output (1 = true, 0 = false)
        
        $this->result = json_decode(curl_exec($ch));

        // Check connect errors
        if (curl_errno($ch)) $this->result = curl_error($ch);
        curl_close ($ch);
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
                $this->content[$key] = sprintf("\0%s", $val);
                if ($key == "image") $this->content[$key] = "@".realpath("./$val");
			}
			return;
		}

		// GET method content
		foreach ($options as $key => $val) {
			$this->content .= $key."=".urlencode($val)."&";
		}
    }

    /**
     * @biref Make a signature with hash_hamac then return the signature
     */
    private function getSignature()
    {
        return hash_hmac('md5', (string)$this->timestamp.$this->salt, $this->api_secret);
    }

    /**
     * @brief Set authenticate information
     */
    private function addInfos($options = null)
	{
		if (!$options) $options = new stdClass();

        $this->salt = uniqid();
        $this->timestamp = (string)time();
        if (!$options->User_Agent) $options->User_Agent = sprintf("PHP REST API %s", self::VERSION);
        if (!$options->os_platform) $options->os_platform = $this->getOS();
        if (!$options->dev_lang) $options->dev_lang = sprintf("PHP %s", phpversion());
        if (!$options->sdk_version) $options->sdk_version = sprintf("PHP SDK %s", self::SDK_VERSION);

        $options->salt = $this->salt;
		$options->timestamp = $this->timestamp;

	    // If basecamp is true '$coolsms_user' use
        if ($this->basecamp) {
            $options->coolsms_user = $this->api_key;
        } else {
            $options->api_key = $this->api_key;
		}

        $options->signature = $this->getSignature();
        $this->setContent($options);
        $this->curlProcess();
    }

    /**
     * $resource
     * 'sms', 'senderid', 'group'
     * $method 
     * GET = 0, POST, 1
     * $path
	 * sms['send' 'sent' 'cancel' 'balance']
	 * senderid['register' 'verify' 'delete' 'list' 'set_default' 'get_default']
	 * group['new_group' 'group_list' 'delete_groups' 'groups/{group_id}' 'groups/{group_id}/add_messages' 
	 *       'groups/{group_id}/message' 'groups/{group_id}/delete_messages']
	 * image['image_list' 'images/{image_id}' 'upload_image' 'delete_image']
     */
    private function setMethod($resource, $path, $method, $version=self::VERSION)
    {
        $this->resource = $resource;
        $this->path = $path;
        $this->method = $method;
        $this->version = $version;
    }

    /**
     * @brief Return result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @POST send method
     * @param $options (options must contain api_key, salt, signature, to, from, text)
     * @type, image, refname, country, datetime, mid, gid, subject, charset (optional)
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
     * @count,  page, s_rcpt, s_start, s_end, mid, gid (optional)
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
     * @options must contain api_key, salt, signature
     * @mid, gid (either one must be entered.)
     */
    public function cancel($options) 
    {
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
     * @options must contain api_key, salt, signature
     * @return an object(registdate, sms_average, sms_sk_average, sms_kt_average, sms_lg_average, mms_average, mms_sk_average, mms_kt_average, mms_lg_average)
     * this method is made for Coolsms inc. internal use
     */
    public function status($options) 
    {
        $this->setMethod('sms', 'status', 0);
        $this->addInfos();    
        return $this->result;
    }

    /**
     * @POST register method
     * @options must contains api_key, salt, signature, phone, site_user(optional)
     * @return json object(handle_key, ars_number)
     */
    public function register($options)
    {
        $this->setMethod('senderid', 'register', 1, "1.1");
        $this->addInfos($options);
        return $this->result;
    }

    /**
     * @POST verify method
     * @options must contains api_key, salt, signature, handle_key
     * return nothing
     */
    public function verify($options)
    {
        $this->setMethod('senderid', 'verify', 1, "1.1");
        $this->addInfos($options);
        return $this->result;
    }

    /**
     * POST delete method
     * $options must contains api_key, salt, signature, handle_key
     * return nothing
     */
    public function delete($options)
    {
        $this->setMethod('senderid', 'delete', 1, "1.1");
        $this->addInfos($options);
        return $this->result;
    }

    /**
     * GET list method
     * $options must conatins api_key, salt, signature, site_user(optional)
     * return json object(idno, phone_number, flag_default, updatetime, regdate)
     */
    public function senderidList($options)
    {
        $this->setMethod('senderid', 'list', 0, "1.1");
        $this->addInfos();
        return $this->result;
    }

    /**
     * POST set_default
     * $options must contains api_key, salt, signature, handle_key, site_user(optional)
     * return nothing
     */
    public function setDefault($options)
    {
        $this->setMethod('senderid', 'set_default', 1, "1.1");
        $this->addInfos($options);
        return $this->result;
    }

    /**
     * GET get_default
     * $options must conatins api_key, salt, signature, site_user(optional)
     * return json object(handle_key, phone_number)
     */
    public function getDefault($options)
    {
        $this->setMethod('senderid', 'get_default', 0, "1.1");
        $this->addInfos();
        return $this->result;
    }

    /**
     * @GET new_group method
     * @param $options (options can be optional)
     * @charset, srk, mode, delay, force_sms, os_platform, dev_lang, sdk_version, app_version (optional)
     * @returns an object(group_id)
     */
    public function newGroup($options) 
    {
        $this->setMethod('sms', 'new_group', 0);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
	 * @GET group_list method
	 * $options (none)
     * @returns an array['groupid', 'groupid'...]
     */
    public function groupList() 
    {
        $this->setMethod('sms', 'group_list', 0);
        $this->addInfos();
        return $this->result;
    }

    /**
     * @POST delete_groups method
     * @param $options (options must contain group_ids)
     * @returns an object(count)
     */
    public function deleteGroups($options) 
    {
        $this->setMethod('sms', 'delete', 1);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @GET groups/{group_id} method
     * @param $options (options must contain group_id)
     * @returns an object(group_id, message_count)
     */
    public function groupInfo($options) 
    {
        $this->setMethod('sms', 'groups/' . $options->group_id, 0);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @POST groups/{group_id}/add_messages method
     * @param $options (options must contain group_id)
     * @to, from, text, type, image_id, refname, country, datetime, subject, delay, extension (optional)
     * @returns an object(success_count, error_count, error_list['messageid':'code', 'messageid', 'code'])
     */
    public function addMessages($options) 
    {
        $this->setMethod('sms', 'groups/' . $options->group_id . '/add_messages' , 1);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @GET groups/{group_id}/message_list method
     * @param $options (options must contain group_id)
     * @offset, limit (optional)
     * @returns an object(total_count, offset, limit, list['message_id', 'message_id' ...])
     */
    public function messageList($options) 
    {
        $this->setMethod('sms', 'groups/' . $options->group_id . '/message_list', 0);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @POST groups/{group_id}/delete_messages method
     * @param $options (options must contain group_id, message_ids)
     * @returns an object(success_count)
     */
    public function deleteMessages($options) 
    {
        $this->setMethod('sms', 'groups/' . $options->group_id . '/delete_messages', 1);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @GET image_list method
     * @param $options (options can be optional)
     * @offset, limit (optional)
     * @returns an object(total_count, offset, limit, list['image_id', 'image_id' ...])
     */
    public function imageList($options) 
    {
        $this->setMethod('sms', 'image_list', 0);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @GET images/{image_id} method
     * @param $options (options must contain image_id)
     * @returns an object(image_id, file_name, original_name, file_size, width, height)
     */
    public function imageInfo($options) 
    {
        $this->setMethod('sms', 'images/' . $options->image_id, 0);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @POST upload_image method
     * @param $options (options must contain image)
     * @encoding (optional)
     * @returns an object(image_id)
     */
    public function uploadImage($options) 
    {
        $this->setMethod('sms', 'groups/' . $options->group_id . '/delete_messages', 1);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @POST delete_images method
     * @param $options (options must contain image_ids)
     * @returns an object(success_count)
     */
    public function deleteImages($options) 
    {
        $this->setMethod('sms', 'groups/' . $options->group_id . '/delete_messages', 1);
        $this->addInfos($options);    
        return $this->result;
    }

    /**
     * @brief Return user's current OS
     */
    function getOS() { 
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
    function getBrowser() {
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
