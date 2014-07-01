<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 27/06/14
 * Time: 23:57
 */

namespace Debril\RssAtomBundle\Driver;


use DateTime;
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;

class HttpGuzzle3Driver implements HttpDriver
{
    /**
     * @var \Guzzle\Http\Client;
     */
    protected $client;

    /**
     * @param Client $client
     */
    function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     *
     * @param string $url
     * @param DateTime $lastModified
     *
     * @return HttpDriverResponse
     */
    public function getResponse($url, DateTime $lastModified)
    {
        $this->client->setDefaultOption('headers/Last-Modified', $lastModified->format(\DateTime::ATOM));
        $request = $this->client->get($url);

        $response = $request->send();
        return $this->getHttpDriverResponse($response);
    }

    /**
     * @param Response $response
     * @return HttpDriverResponse
     */
    public function getHttpDriverResponse(Response $response)
    {
        $httpResponse = new HttpDriverResponse();
        $httpResponse
            ->setBody($response->getBody(true))
            ->setHttpCode($response->getStatusCode())
            ->setHttpMessage($response->getMessage())
            ->setHttpVersion($response->getProtocolVersion());

        $headers = array();
        foreach( $response->getHeaders()->getAll() as $header => $value ) {
            $headers[$header] = $value->__toString();
        }
        $httpResponse->setHeaders($headers);

        return $httpResponse;
    }

} 