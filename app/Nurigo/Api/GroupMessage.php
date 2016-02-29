<?php
/*- coding: utf-8 -*/
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo;

use Nurigo\Coolsms as Coolsms;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * Group Message management class, using the Rest API
 * @author NURIGO <contact@nurigo.net>
 */
class GroupMessage extends Coolsms
{
    /**
     * @GET new_group method
     * @param $options (options can be optional)
     * @charset, srk, mode, delay, force_sms, os_platform, dev_lang, sdk_version, app_version (optional)
     * @returns an object(group_id)
     */
    public function newGroup($options) 
    {
        $this->setMethod('sms', 'new_group');
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @GET group_list method
     * $options (none)
     * @returns an array['groupid', 'groupid'...]
     */
    public function groupList() 
    {
        $this->setMethod('sms', 'group_list');
        $this->addInfos();
        return $this->getResult();
    }

    /**
     * @POST delete_groups method
     * @param $group_ids (required)
     * @returns an object(count)
     */
    public function deleteGroups($group_ids) 
    {
        if (!isset($group_ids)) throw new CoolsmsException('group_ids is required');

        $options->group_ids = $group_ids;
        $this->setMethod('sms', 'delete_groups', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @GET groups/{group_id} method
     * @param $group_id (required)
     * @returns an object(group_id, message_count)
     */
    public function groupInfo($group_id) 
    {
        if (!isset($group_id)) throw new CoolsmsException('group_id is required');

        $options->group_id = $group_id;
        $this->setMethod('sms', 'groups/' . $group_id);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @POST groups/{group_id}/add_messages method
     * @param $options (options must contain group_id, to, from, text)
     * @type, image_id, refname, country, datetime, subject, delay, extension (optional)
     * @returns an object(success_count, error_count, error_list['messageid':'code', 'messageid', 'code'])
     */
    public function addMessages($options) 
    {
        if (!isset($options->group_id) || !isset($options->to) || !isset($options->text) || !isset($options->from)) {
            throw new CoolsmsException('group_id, to, text, from is required');
        }

        $this->setMethod('sms', 'groups/' . $options->group_id . '/add_messages' , 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @GET groups/{group_id}/message_list method
     * @param $options (options must contain group_id)
     * @offset, limit (optional)
     * @returns an object(total_count, offset, limit, list['message_id', 'message_id' ...])
     */
    public function messageList($options) 
    {
        if (!isset($options->group_id)) throw new CoolsmsException('group_id is required');

        $this->setMethod('sms', 'groups/' . $options->group_id . '/message_list');
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @POST groups/{group_id}/delete_messages method
     * @param $group_id, $message_ids (required)
     * @returns an object(success_count)
     */
    public function deleteMessages($group_id, $message_ids) 
    {
        if (!isset($group_id) || !isset($message_ids)) throw new CoolsmsException('"group_id and message_ids" is required');

        $options->group_id = $group_id;
        $options->message_ids = $message_ids;
        $this->setMethod('sms', 'groups/' . $options->group_id . '/delete_messages', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @POST groups/{group_id}/send method
     * @param $group_id (required)
     * @returns an object(group_id)
     */
    public function sendGroupMessage($group_id) 
    {
        if (!isset($group_id)) throw new CoolsmsException('group_id is required');

        $options->group_id = $group_id;
        $this->setMethod('sms', 'groups/' . $group_id . '/send', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }
}
