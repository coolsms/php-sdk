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
     * The result, message, code from the API server & SDK
     */
    protected $responseCode;

    /**
     * Make a new SDK Exception with the given result.
     *
     * @param String $result The result from the API server & SDK Client
     */
    public function __construct($message, $code=null) {
        $this->responseCode = $code;
        parent::__construct($message);
    }

    /**
     * Return response code
     */
    public function getResponseCode() {
        return $this->responseCode;
    }

    public function __toString() {
        return parent::__toString();
    }
}
