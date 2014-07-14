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

use Mremi\Flowdock\Api\Push\Chat\Message;

/**
 * Tests the Message class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Message
     */
    private $message;

    /**
     * Tests a fresh message
     */
    public function testFreshMessage()
    {
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
     * Tests the toArray method
     */
    public function testToArray()
    {
        $this->message
            ->setContent('Hello world!')
            ->setExternalUserName('mremi')
            ->addTag('tag1')
            ->addTag('tag2')
            ->setMessageId(1);

        $expected = array(
            'content'            => $this->message->getContent(),
            'external_user_name' => $this->message->getExternalUserName(),
            'tags'               => $this->message->getTags(),
            'message_id'         => $this->message->getMessageId(),
        );

        $this->assertEquals($expected, $this->message->toArray());
    }

    /**
     * Initializes message used by tests
     */
    protected function setUp()
    {
        $this->message = new Message;
    }

    /**
     * Cleanups message
     */
    protected function tearDown()
    {
        $this->message = null;
    }
}
