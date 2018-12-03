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

use GuzzleHttp\Psr7\Response;

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
     * Tests the sendMessage method succeed and failed
     *
     * @param BaseMessageInterface $message A message instance
     * @param string               $baseUrl A base URL
     * @param array                $options An array of options used by request
     *
     * @dataProvider getSendMessageArgs
     */
    public function testSendMessage(BaseMessageInterface $message, $baseUrl, array $options)
    {
        $responseOk = new Response(200, array(
            'Content-Type' => 'application/json; charset=utf-8',
        ), '{}');

        $responseKo = new Response(400, array(
            'Content-Type' => 'application/json; charset=utf-8',
        ), '{"message": "Validation error", "errors": {"content": ["can\'t be blank"]}}');

        $clientOptions = $options;
        $clientOptions['headers'] = array('Content-Type' => 'application/json');
        $clientOptions['json'] = $message->getData();
        
        $client = $this->getMock('GuzzleHttp\Client');
        $client
            ->expects($this->exactly(2))
            ->method('__call')
            ->with($this->equalTo('post'), $this->equalTo([null, $clientOptions]))
            ->willReturnOnConsecutiveCalls($responseOk, $responseKo);

        $push = $this->getMockBuilder('Mremi\Flowdock\Api\Push\Push')
            ->setConstructorArgs(array('flow_api_token'))
            ->setMethods(array('createClient'))
            ->getMock();

        $push
            ->expects($this->exactly(2))
            ->method('createClient')
            ->with($this->equalTo(sprintf('%s/flow_api_token', $baseUrl)))
            ->will($this->returnValue($client));

        $method = new \ReflectionMethod($push, 'sendMessage');
        $method->setAccessible(true);

        $this->assertNull($message->getResponse());
        $this->assertFalse($message->hasResponseErrors());

        $this->assertTrue($method->invoke($push, $message, $baseUrl, $options));
        $this->assertSame($responseOk, $message->getResponse());
        $this->assertFalse($message->hasResponseErrors());

        $this->assertFalse($method->invoke($push, $message, $baseUrl, $options));
        $this->assertSame($responseKo, $message->getResponse());
        $this->assertTrue($message->hasResponseErrors());
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
