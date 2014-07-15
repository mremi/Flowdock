<?php

/*
 * This file is part of the Mremi\Flowdock library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\Flowdock\Tests\Api\Push\Chat;

use Guzzle\Http\Message\Response;
use Mremi\Flowdock\Api\Push\Chat\Chat;
use Mremi\Flowdock\Api\Push\Chat\Message;

/**
 * Tests the Chat class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ChatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the sendMessage method
     */
    public function testSendMessage()
    {
        $message = $this->createMessage();

        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();

        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->exactly(2))->method('send')->will($this->returnValue($response));

        $client = $this->getMock('Guzzle\Http\ClientInterface');
        $client
            ->expects($this->exactly(2))
            ->method('post')
            ->with($this->equalTo(null), $this->equalTo(array('Content-Type' => 'application/json')), $this->equalTo(json_encode($message->getData())), $this->equalTo(array()))
            ->will($this->returnValue($request));

        $chat = $this->getMockBuilder('Mremi\Flowdock\Api\Push\Chat\Chat')
            ->disableOriginalConstructor()
            ->setMethods(array('createClient', 'isValid'))
            ->getMock();

        $chat->expects($this->exactly(2))->method('createClient')->will($this->returnValue($client));

        $chat
            ->expects($this->exactly(2))
            ->method('isValid')
            ->with($this->equalTo($message), $this->equalTo($response))
            ->will($this->onConsecutiveCalls(true, false));

        $this->assertTrue($chat->sendMessage($message));
        $this->assertFalse($chat->sendMessage($message));
    }

    /**
     * Tests the getApiUrl method
     */
    public function testGetApiUrl()
    {
        $chat = new Chat('flow_api_token');

        $method = new \ReflectionMethod($chat, 'getApiUrl');
        $method->setAccessible(true);

        $url = $method->invoke($chat);

        $this->assertEquals('https://api.flowdock.com/v1/messages/chat/flow_api_token', $url);
    }

    /**
     * Tests the isValid method return TRUE
     */
    public function testIsValid()
    {
        $message = $this->createMessage();
        $response = new Response(200, array(
            'Content-Type' => 'application/json; charset=utf-8',
        ), '{}');

        $chat = new Chat('flow_api_token');

        $method = new \ReflectionMethod($chat, 'isValid');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($chat, $message, $response));
        $this->assertFalse($message->hasErrors());
    }

    /**
     * Provides invalid responses and associated errors
     *
     * @return array
     */
    public function getInvalidResponses()
    {
        $errors1 = array(
            'Status code of response is wrong, expected 200, got 500',
            'Could not find header "content-type" in response, got []',
            'Response body is wrong, expected "{}", got ""',
        );
        $errors2 = array(
            'Could not find header "content-type" in response, got []',
            'Response body is wrong, expected "{}", got ""',
        );
        $errors3 = array(
            'Content type of response is wrong, expected "application/json; charset=utf-8", got ["text\/html"]',
            'Response body is wrong, expected "{}", got ""',
        );
        $errors4 = array(
            'Response body is wrong, expected "{}", got ""',
        );
        $errors5 = array(
            'Response body is wrong, expected "{}", got "[]"',
        );

        return array(
            array(new Response(500), $errors1),
            array(new Response(200), $errors2),
            array(new Response(200, array('Content-Type' => 'text/html')), $errors3),
            array(new Response(200, array('Content-Type' => 'application/json; charset=utf-8')), $errors4),
            array(new Response(200, array('Content-Type' => 'application/json; charset=utf-8'), '[]'), $errors5),
        );
    }

    /**
     * Tests the isValid method return FALSE
     *
     * @param Response $response Invalid response
     * @param array    $errors   Errors associated to response
     *
     * @dataProvider getInvalidResponses
     */
    public function testIsNotValid(Response $response, array $errors)
    {
        $message = $this->createMessage();

        $chat = new Chat('flow_api_token');

        $method = new \ReflectionMethod($chat, 'isValid');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($chat, $message, $response));
        $this->assertTrue($message->hasErrors());
        $this->assertEquals($errors, $message->getErrors());
    }

    /**
     * Creates a message
     *
     * @return Message
     */
    private function createMessage()
    {
        $message = new Message;
        $message->setContent('Hello world!');
        $message->setExternalUserName('mremi');

        return $message;
    }
}
