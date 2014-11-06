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

/**
 * Tests the common methods
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
abstract class BaseMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseMessageInterface
     */
    protected $message;

    /**
     * Initializes message used by tests
     */
    protected function setUp()
    {
        throw new \RuntimeException('You must define a setUp method to initialize the message.');
    }

    /**
     * Cleanups message
     */
    protected function tearDown()
    {
        $this->message = null;
    }

    /**
     * Tests a fresh message
     */
    public function testFreshMessage()
    {
        $this->assertInstanceOf(get_class($this->message), call_user_func(array(get_class($this->message), 'create')));

        $this->assertTrue(is_array($this->message->getTags()));
        $this->assertCount(0, $this->message->getTags());

        $this->assertTrue(is_array($this->message->getResponseBody()));
        $this->assertCount(0, $this->message->getResponseBody());

        $this->assertNull($this->message->getResponseMessage());

        $this->assertTrue(is_array($this->message->getResponseErrors()));
        $this->assertCount(0, $this->message->getResponseErrors());
        $this->assertFalse($this->message->hasResponseErrors());
    }

    /**
     * Tests to add some tags to a message
     */
    public function testAddTags()
    {
        $this->message->addTag('#hello');
        $this->assertCount(1, $this->message->getTags());
        $this->assertEquals(array('#hello'), $this->message->getTags());

        $this->message->addTag('#world');
        $this->assertCount(2, $this->message->getTags());
        $this->assertEquals(array('#hello', '#world'), $this->message->getTags());

        $this->message->clearTags();
        $this->assertTrue(is_array($this->message->getTags()));
        $this->assertCount(0, $this->message->getTags());

        $this->message->setTags(array('#foo', '#bar'));
        $this->assertCount(2, $this->message->getTags());
        $this->assertEquals(array('#foo', '#bar'), $this->message->getTags());
    }

    /**
     * Tests a valid response
     */
    public function testValidResponse()
    {
        $this->message->setResponse(new Response(200, null, '{"dummy": "ok"}'));

        $this->assertEquals(array('dummy' => 'ok'), $this->message->getResponseBody());

        $this->assertNull($this->message->getResponseMessage());

        $this->assertTrue(is_array($this->message->getResponseErrors()));
        $this->assertCount(0, $this->message->getResponseErrors());
        $this->assertFalse($this->message->hasResponseErrors());
    }

    /**
     * Tests an invalid response
     */
    public function testInvalidResponse()
    {
        $this->message->setResponse(new Response(400, null, '{"message": "Validation error", "errors": {"content": ["can\'t be blank"]}}'));

        $this->assertEquals(array('message' => 'Validation error', 'errors' => array('content' => array('can\'t be blank'))), $this->message->getResponseBody());

        $this->assertEquals('Validation error', $this->message->getResponseMessage());

        $this->assertTrue(is_array($this->message->getResponseErrors()));
        $this->assertEquals(array('content' => array('can\'t be blank')), $this->message->getResponseErrors());
        $this->assertTrue($this->message->hasResponseErrors());
    }

    /**
     * Tests the getData method
     */
    abstract public function testGetData();

    /**
     * Tests the toArray method
     */
    abstract public function testToArray();
}
