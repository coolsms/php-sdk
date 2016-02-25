<?php
/*- coding: utf-8 -*/
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo;

/**
 * Thrown when an SDK call returns an exception.
 */
class CoolsmsException extends \Exception
{
    /**
     * The result from the API server & SDK
     */
    protected $result;

    /**
     * Make a new SDK Exception with the given result.
     *
     * @param String $result The result from the API server & SDK Client
     */
    public function __construct($result) {
        $this->result = $result;
        parent::__construct($result);
    }

    /**
     * Return result
     */
    public function getResult() {
        return $this->result;
    }
}
