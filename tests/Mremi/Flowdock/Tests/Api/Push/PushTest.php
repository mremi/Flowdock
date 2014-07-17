<?php

/*
 * This file is part of the Mremi\Flowdock library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\Flowdock\Tests\Api\Push;

use Guzzle\Http\Message\Response;

use Mremi\Flowdock\Api\Push\BaseMessageInterface;
use Mremi\Flowdock\Api\Push\ChatMessage;
use Mremi\Flowdock\Api\Push\Push;
use Mremi\Flowdock\Api\Push\TeamInboxMessage;

/**
 * Tests the Push class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class PushTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides arguments for sendMessage test
     *
     * @return array
     */
    public function getSendMessageArgs()
    {
        return array(
            array($this->createChatMessage(), Push::BASE_CHAT_URL, array('connect_timeout' => 1, 'timeout' => 1)),
            array($this->createTeamInboxMessage(), Push::BASE_TEAM_INBOX_URL, array('connect_timeout' => 1, 'timeout' => 1)),
        );
    }

    /**
     * Tests the sendChatMessage and sendTeamInboxMessage methods
     *
     * @param BaseMessageInterface $message A message instance
     * @param string               $baseUrl A base URL
     * @param array                $options An array of options used by request
     *
     * @dataProvider getSendMessageArgs
     */
    public function testSendMixedMessage(BaseMessageInterface $message, $baseUrl, array $options)
    {
        $push = $this->getMockBuilder('Mremi\Flowdock\Api\Push\Push')
            ->disableOriginalConstructor()
            ->setMethods(array('sendMessage'))
            ->getMock();

        $push
            ->expects($this->exactly(2))
            ->method('sendMessage')
            ->with($this->equalTo($message), $this->equalTo($baseUrl), $this->equalTo($options))
            ->will($this->onConsecutiveCalls(true, false));

        $method = $message instanceof ChatMessage ? 'sendChatMessage' : 'sendTeamInboxMessage';

        $this->assertTrue($push->$method($message, $options));
        $this->assertFalse($push->$method($message, $options));
    }

    /**
     * Tests the sendMessage method
     *
     * @param BaseMessageInterface $message A message instance
     * @param string               $baseUrl A base URL
     * @param array                $options An array of options used by request
     *
     * @dataProvider getSendMessageArgs
     */
    public function testSendMessage(BaseMessageInterface $message, $baseUrl, array $options)
    {
        $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();

        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->exactly(2))->method('send')->will($this->returnValue($response));

        $client = $this->getMock('Guzzle\Http\ClientInterface');
        $client
            ->expects($this->exactly(2))
            ->method('post')
            ->with($this->equalTo(null), $this->equalTo(array('Content-Type' => 'application/json')), $this->equalTo(json_encode($message->getData())), $this->equalTo($options))
            ->will($this->returnValue($request));

        $push = $this->getMockBuilder('Mremi\Flowdock\Api\Push\Push')
            ->setConstructorArgs(array('flow_api_token'))
            ->setMethods(array('createClient', 'isValid'))
            ->getMock();

        $push
            ->expects($this->exactly(2))
            ->method('createClient')
            ->with($this->equalTo(sprintf('%s/flow_api_token', $baseUrl)))
            ->will($this->returnValue($client));

        $push
            ->expects($this->exactly(2))
            ->method('isValid')
            ->with($this->equalTo($message), $this->equalTo($response))
            ->will($this->onConsecutiveCalls(true, false));

        $method = new \ReflectionMethod($push, 'sendMessage');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($push, $message, $baseUrl, $options));
        $this->assertFalse($method->invoke($push, $message, $baseUrl, $options));
    }

    /**
     * Tests the isValid method return TRUE
     *
     * @param BaseMessageInterface $message A message instance
     * @param string               $baseUrl A base URL
     * @param array                $options An array of options used by request
     *
     * @dataProvider getSendMessageArgs
     */
    public function testIsValid(BaseMessageInterface $message, $baseUrl, array $options)
    {
        $response = new Response(200, array(
            'Content-Type' => 'application/json; charset=utf-8',
        ), '{}');

        $chat = new Push('flow_api_token');

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
        foreach ($this->getSendMessageArgs() as $args) {
            $message = $args[0];

            $push = new Push('flow_api_token');

            $method = new \ReflectionMethod($push, 'isValid');
            $method->setAccessible(true);

            $this->assertFalse($method->invoke($push, $message, $response));
            $this->assertTrue($message->hasErrors());
            $this->assertEquals($errors, $message->getErrors());
        }
    }

    /**
     * Creates a chat message
     *
     * @return ChatMessage
     */
    private function createChatMessage()
    {
        return ChatMessage::create()
            ->setContent('Hello world!')
            ->setExternalUserName('mremi');
    }

    /**
     * Creates a team inbox message
     *
     * @return TeamInboxMessage
     */
    private function createTeamInboxMessage()
    {
        return TeamInboxMessage::create()
            ->setSource('source')
            ->setFromAddress('from.mremi@test.com')
            ->setSubject('subject')
            ->setContent('Hello world!');
    }
}
