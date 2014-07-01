<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 01/07/14
 * Time: 21:43
 */

namespace Debril\RssAtomBundle\Tests\Driver;

use Debril\RssAtomBundle\Driver\HttpGuzzle3Driver;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;

class HttpGuzzle3DriverTest extends \PHPUnit_Framework_TestCase
{

    const URL = 'https://raw.githubusercontent.com/alexdebril/rss-atom-bundle/master/Resources/sample-atom.xml';

    /**
     * @var \Debril\RssAtomBundle\Driver\HttpGuzzle3Driver
     */
    protected $object;

    public function setUp()
    {
        if (! class_exists('Guzzle\Http\Client') ) {
            $this->markTestSkipped('Guzzle 3 is not installed');
        }
        $this->object = new HttpGuzzle3Driver(
            new Client()
        );
    }

    public function testGetResponse()
    {
        $date = \DateTime::createFromFormat('j-M-Y', '10-Feb-2002');
        try
        {
            $response = $this->object->getResponse(self::URL, $date);

            $this->assertInstanceOf("Debril\RssAtomBundle\Driver\HttpDriverResponse", $response);
            $this->assertInternalType("integer", $response->getHttpCode());

            $this->assertInternalType("string", $response->getBody());
            $this->assertGreaterThan(0, strlen($response->getBody()));
        } catch (DriverUnreachableResourceException $e)
        {
            $this->markTestIncomplete(
                'This test cannot be run.'
            );
        }
    }

    public function testGetHttpResponse()
    {
        $date = new \DateTime();

        $body = file_get_contents(dirname(__FILE__) . '/../../Resources/sample-atom.xml');
        $headers = array('last-modified' => $date->format(\DateTime::RFC2822));
        $response = new Response(
            200,
            $headers,
            $body
        );

        $httpResponse = $this->object->getHttpDriverResponse($response);
        $this->assertInstanceOf("\Debril\RssAtomBundle\Driver\HttpDriverResponse", $httpResponse);
        $this->assertEquals($body, $httpResponse->getBody());
        $this->assertEquals($headers, $httpResponse->getHeaders());
    }
}
 