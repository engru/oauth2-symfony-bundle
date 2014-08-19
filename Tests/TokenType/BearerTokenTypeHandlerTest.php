<?php

/**
 * This file is part of the authbucket/oauth2-bundle package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AuthBucket\Bundle\OAuth2Bundle\Tests\TokenType;

use AuthBucket\Bundle\OAuth2Bundle\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class BearerTokenTypeHandlerTest extends WebTestCase
{
    public function testExceptionNoToken()
    {
        $parameters = array();
        $server = array();
        $client = $this->createClient();
        $crawler = $client->request('GET', '/oauth2/debug', $parameters, array(), $server);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertNotNull(json_decode($client->getResponse()->getContent()));
        $tokenResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('invalid_request', $tokenResponse['error']);
    }

    public function testExceptionDuplicateToken()
    {
        $parameters = array(
            'access_token' => 'eeb5aa92bbb4b56373b9e0d00bc02d93',
        );
        $server = array(
            'HTTP_Authorization' => 'Bearer eeb5aa92bbb4b56373b9e0d00bc02d93',
        );
        $client = $this->createClient();
        $crawler = $client->request('GET', '/oauth2/debug', $parameters, array(), $server);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertNotNull(json_decode($client->getResponse()->getContent()));
        $tokenResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('invalid_request', $tokenResponse['error']);
    }

    public function testAuthorizationHeader()
    {
        $parameters = array();
        $server = array(
            'HTTP_Authorization' => 'Bearer eeb5aa92bbb4b56373b9e0d00bc02d93',
        );
        $client = $this->createClient();
        $crawler = $client->request('GET', '/oauth2/debug', $parameters, array(), $server);
        $resourceResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('demousername1', $resourceResponse['username']);

        $parameters = array();
        $server = array(
            'HTTP_Authorization' => 'Bearer eeb5aa92bbb4b56373b9e0d00bc02d93',
        );
        $client = $this->createClient();
        $crawler = $client->request('POST', '/oauth2/debug', $parameters, array(), $server);
        $resourceResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('demousername1', $resourceResponse['username']);
    }

    public function testGet()
    {
        $parameters = array(
            'access_token' => 'eeb5aa92bbb4b56373b9e0d00bc02d93',
        );
        $server = array();
        $client = $this->createClient();
        $crawler = $client->request('GET', '/oauth2/debug', $parameters, array(), $server);
        $resourceResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('demousername1', $resourceResponse['username']);
    }

    public function testPost()
    {
        $parameters = array(
            'access_token' => 'eeb5aa92bbb4b56373b9e0d00bc02d93',
        );
        $server = array();
        $client = $this->createClient();
        $crawler = $client->request('POST', '/oauth2/debug', $parameters, array(), $server);
        $resourceResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('demousername1', $resourceResponse['username']);
    }
}
