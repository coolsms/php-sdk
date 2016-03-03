<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Exceptions;

/**
 * Thrown when an Server call returns an exception.
 */
class CoolsmsServerException extends CoolsmsException
{
    /**
     * Coolsms API Response data
     */
    protected $response;
    protected $response_data;

    /**
     * Make a new SDK Exception with the given result.
     *
     * @param String $result The result from the API server & SDK Client
     */
    public function __construct($response, $code) {
        $this->response = $response;
        $response_data = $response;
        parent::__construct(json_encode($response), $code);
    }

    /**
     * Return json decoded response data 
     */
    public function getResponseData() {
        return $this->response_data;
    }
}
