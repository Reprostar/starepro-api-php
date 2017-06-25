<?php
/**
 * Created by PhpStorm.
 * User: pfcode
 * Date: 20.06.17
 * Time: 23:30
 */

namespace Reprostar\StareproApi;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;
use Reprostar\StareproApi\Exceptions\StareproApiFtpException;

class StareproApi
{
    const CLIENT_VERSION = "0.1";
    const BASE_URL = "http://api.stare.pro";
    const TIMEOUT = 5.0;

    private $client;

    /**
     * StareproApi constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout' => self::TIMEOUT,
        ]);
    }

    /**
     * @throws StareproApiException
     */
    public function ping(){
        try{
            $response = $this->client->get("/ping");

            return \GuzzleHttp\json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        } catch (\HttpException $httpException){
            throw StareproApiException::httpFailed($httpException);
        } catch (\InvalidArgumentException $invalidArgumentException){
            throw StareproApiException::invalidResponse();
        }
    }

    public function ftpAuth($username, $password){
        try {
            $response = $this->client->post("/ftp/auth", [
                'form_params' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);

            return \GuzzleHttp\json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        } catch (ClientException $e){
            if($e->getResponse()->getStatusCode() === 403){
                throw StareproApiException::resourceNotPermittedException();
            } else if($e->getResponse()->getStatusCode() === 401){
                throw StareproApiFtpException::notAuthorized();
            } else{
                throw StareproApiException::invalidResponse();
            }
        } catch (TransferException $exception) {
            throw StareproApiException::httpFailed($exception);
        }
    }
}
