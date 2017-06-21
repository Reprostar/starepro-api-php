<?php
/**
 * Created by PhpStorm.
 * User: pfcode
 * Date: 21.06.17
 * Time: 19:48
 */

namespace Reprostar\StareproApi;


use GuzzleHttp\Exception\TransferException;

class StareproApiException extends \Exception
{
    private $guzzleTransferException;

    /**
     * @return StareproApiException
     */
    public static function invalidResponse()
    {
        return new self("Invalid response received from server");
    }

    /**
     * @param TransferException $transferException
     * @return StareproApiException
     */
    public static function httpFailed(TransferException $transferException)
    {
        $e = new self("Failed to perform HTTP request");
        $e->setGuzzleTransferException($transferException);

        return $e;
    }

    /**
     * @return StareproApiException
     */
    public static function resourceNotPermittedException()
    {
        return new self("Not permitted to access this resource");
    }

    /**
     * @param TransferException $transferException
     * @return $this
     */
    protected function setGuzzleTransferException(TransferException $transferException)
    {
        $this->guzzleTransferException = $transferException;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuzzleTransferException()
    {
        return $this->guzzleTransferException;
    }

    /**
     * @return bool
     */
    public function hasGuzzleException()
    {
        return $this->guzzleTransferException !== null;
    }
}