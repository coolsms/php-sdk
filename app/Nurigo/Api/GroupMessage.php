<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Api;

use Nurigo\Coolsms;
use Nurigo\Exceptions\CoolsmsSDKException;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * @class GroupMessage
 * @brief management group message, using Rest API
 */
class GroupMessage extends Coolsms
{
    /**
     * @brief create new group ( HTTP Method GET )
     * @param object $options {
     *   @param string  charset     [optional]
     *   @param string  srk         [optional]
     *   @param string  mode        [optional]
     *   @param string  delay       [optional]
     *   @param boolean force_sms   [optional]
     *   @param string  os_platform [optional]
     *   @param string  dev_lang    [optional]
     *   @param string  sdk_version [optional]
     *   @param string  app_version [optional] }
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
     * @param None
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
     * @param string $group_ids [required]
     * @return object(count)
     */
    public function deleteGroups($group_ids) 
    {
        if (!$group_ids) throw new CoolsmsSDKException('group_ids is required', 202);

        $options = new \stdClass();
        $options->group_ids = $group_ids;
        $this->setMethod('delete_groups', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief get group info ( HTTP Method GET )
     * @param string $group_id [required]
     * @return object(group_id, message_count)
     */
    public function groupInfo($group_id) 
    {
        if (!$group_id) throw new CoolsmsSDKException('group_id is required', 202);

        $options = new \stdClass();
        $options->group_id = $group_id;
        $this->setMethod(sprintf('groups/%s', $group_id));
        $this->addInfos($options);    
        return $this->getResult();
    }
    

    /**
     * @brief add message to group ( HTTP Method POST )
     * @param object $options {
     *   @param string  group_id [required]
     *   @param string  to       [required]
     *   @param string  from     [required]
     *   @param string  text     [required]
     *   @param string  image_id [optional]
     *   @param string  refname  [optional]
     *   @param string  country  [optional]
     *   @param string  datetime [optional]
     *   @param string  subject  [optional]
     *   @param integer delay    [optional] }
     * @return object(success_count, error_count, error_list['messageid':'code', 'messageid', 'code'])
     */
    public function addMessages($options) 
    {
        if (!isset($options->group_id) || !isset($options->to) || !isset($options->text) || !isset($options->from)) {
            throw new CoolsmsSDKException('group_id, to, text, from is required', 202);
        }

        $this->setMethod(sprintf('groups/%s/add_messages', $options->group_id), 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief get message list ( HTTP Method GET )
     * @param string  $group_id [required]
     * @param integer $offset   [optional]
     * @param integer $limit    [optional]
     * @return object(total_count, offset, limit, list['message_id', 'message_id' ...])
     */
    public function messageList($group_id, $offset = null, $limit = null)
    {
        if (!$group_id) throw new CoolsmsSDKException('group_id is required', 202);

        $this->setMethod(sprintf('groups/%s/message_list', $options->group_id));
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief delete message from group ( HTTP Method POST )
     * @param string $group_id    [required]
     * @param string $message_ids [required]
     * @return object(success_count)
     */
    public function deleteMessages($group_id, $message_ids) 
    {
        if (!$group_id || !$message_ids) throw new CoolsmsSDKException('group_id and message_ids are required', 202);

        $options = new \stdClass();
        $options->group_id = $group_id;
        $options->message_ids = $message_ids;
        $this->setMethod(sprintf('groups/%s/delete_messages', $options->group_id), 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief send group message ( HTTP Method POST )
     * @param string $group_id [required]
     * @return object(group_id)
     */
    public function sendGroupMessage($group_id) 
    {
        if (!$group_id) throw new CoolsmsSDKException('group_id is required', 202);

        $options = new \stdClass();
        $options->group_id = $group_id;
        $this->setMethod(sprintf('groups/%s/send', $group_id), 1);
        $this->addInfos($options);    
        return $this->getResult();
    }
}
