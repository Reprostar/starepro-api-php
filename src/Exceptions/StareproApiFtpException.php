<?php
/**
 * Created by PhpStorm.
 * User: pfcode
 * Date: 21.06.17
 * Time: 20:15
 */

namespace Reprostar\StareproApi\Exceptions;


use Reprostar\StareproApi\StareproApiException;

class StareproApiFtpException extends StareproApiException
{
    public static function notAuthorized()
    {
        return new self("FTP access not authorized");
    }
}