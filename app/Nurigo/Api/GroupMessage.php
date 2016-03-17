<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Coolsms;

use Nurigo\Coolsms;
use Nurigo\Exceptions\CoolsmsSDKException;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * @class Group Message
 * @brief Coolsms Rest API core class, using the Rest API
 */
class GroupMessage extends Coolsms
{
    /**
     * @brief create new group ( HTTP Method GET )
     * @param $options (options can be optional)
     * @param charset, srk, mode, delay, force_sms, os_platform, dev_lang, sdk_version, app_version (optional)
     * @return object(group_id)
     */
    public function newGroup($options) 
    {
        $this->setMethod('new_group');
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief group_list ( HTTP Method GET )
     * @param $options (none)
     * @return array['groupid', 'groupid'...]
     */
    public function groupList() 
    {
        $this->setMethod('group_list');
        $this->addInfos();
        return $this->getResult();
    }

    /**
     * @brief delete groups ( HTTP Method POST )
     * @param $group_ids (required)
     * @return object(count)
     */
    public function deleteGroups($group_ids) 
    {
        if (!isset($group_ids)) throw new CoolsmsSDKException('group_ids is required',202);

        $options = new \stdClass();
        $options->group_ids = $group_ids;
        $this->setMethod('delete_groups', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief get group info ( HTTP Method GET )
     * @param $group_id (required)
     * @return object(group_id, message_count)
     */
    public function groupInfo($group_id) 
    {
        if (!isset($group_id)) throw new CoolsmsSDKException('group_id is required',202);

        $options = new \stdClass();
        $options->group_id = $group_id;
        $this->setMethod('groups/' . $group_id);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief add message to group ( HTTP Method POST )
     * @param $options (options must contain group_id, to, from, text)
     * @param type, image_id, refname, country, datetime, subject, delay, extension (optional)
     * @return object(success_count, error_count, error_list['messageid':'code', 'messageid', 'code'])
     */
    public function addMessages($options) 
    {
        if (!isset($options->group_id) || !isset($options->to) || !isset($options->text) || !isset($options->from)) {
            throw new CoolsmsSDKException('group_id, to, text, from is required',202);
        }

        $this->setMethod('groups/' . $options->group_id . '/add_messages' , 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief get message list ( HTTP Method GET )
     * @param $options (options must contain group_id)
     * @offset, limit (optional)
     * @return object(total_count, offset, limit, list['message_id', 'message_id' ...])
     */
    public function messageList($options) 
    {
        if (!isset($options->group_id)) throw new CoolsmsSDKException('group_id is required',202);

        $this->setMethod('groups/' . $options->group_id . '/message_list');
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief delete message from group ( HTTP Method POST )
     * @param $group_id, $message_ids (required)
     * @return object(success_count)
     */
    public function deleteMessages($group_id, $message_ids) 
    {
        if (!isset($group_id) || !isset($message_ids)) throw new CoolsmsSDKException('"group_id and message_ids" is required',202);

        $options = new \stdClass();
        $options->group_id = $group_id;
        $options->message_ids = $message_ids;
        $this->setMethod('groups/' . $options->group_id . '/delete_messages', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief send group message ( HTTP Method POST )
     * @param $group_id (required)
     * @return object(group_id)
     */
    public function sendGroupMessage($group_id) 
    {
        if (!isset($group_id)) throw new CoolsmsSDKException('group_id is required',202);

        $options = new \stdClass();
        $options->group_id = $group_id;
        $this->setMethod('groups/' . $group_id . '/send', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }
}
