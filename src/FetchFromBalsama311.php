<?php

namespace Balsama\Query311;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

class FetchFromBalsama311 {

    /**
     * @param string $url
     * @param array $params
     * @param int $retryOnError
     * @return mixed
     * @throws GuzzleException
     */
    public static function fetch(string $url, array $params, int $retryOnError = 5)
    {
        $client = new Client();
        try {
            $response = $client->request('POST', $url, $params);
            return json_decode($response->getBody());
        } catch (ServerException $e) {
            if ($retryOnError) {
                $retryOnError--;
                usleep(250000);
                return self::fetch($retryOnError, $params);
            }
            throw $e;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}
