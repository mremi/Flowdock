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

        $this->assertTrue(is_array($this->message->getErrors()));
        $this->assertCount(0, $this->message->getErrors());
        $this->assertFalse($this->message->hasErrors());
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
    }

    /**
     * Tests to add some errors to a message
     */
    public function testAddErrors()
    {
        $this->message->addError('Error #1');
        $this->assertCount(1, $this->message->getErrors());
        $this->assertEquals(array('Error #1'), $this->message->getErrors());
        $this->assertTrue($this->message->hasErrors());

        $this->message->addError('Error #2');
        $this->assertCount(2, $this->message->getErrors());
        $this->assertEquals(array('Error #1', 'Error #2'), $this->message->getErrors());
        $this->assertTrue($this->message->hasErrors());
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
