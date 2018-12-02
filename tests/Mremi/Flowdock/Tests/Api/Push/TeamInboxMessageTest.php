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

use Mremi\Flowdock\Api\Push\TeamInboxMessage;

/**
 * Tests the TeamInboxMessage class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class TeamInboxMessageTest extends BaseMessageTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->message = new TeamInboxMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function testGetData()
    {
        $this->message
            ->setSource('source')
            ->setFromAddress('from.mremi@test.com')
            ->setSubject('subject')
            ->setContent('Hello world!')
            ->setFromName('mremi')
            ->setReplyTo('to.mremi@test.com')
            ->setProject('project')
            ->setFormat('html')
            ->addTag('tag1')
            ->addTag('tag2')
            ->setLink('http://www.flowdock.com/')
            ->setResponse(new Response(200));

        $expected = array(
            'source'       => $this->message->getSource(),
            'from_address' => $this->message->getFromAddress(),
            'subject'      => $this->message->getSubject(),
            'content'      => $this->message->getContent(),
            'from_name'    => $this->message->getFromName(),
            'reply_to'     => $this->message->getReplyTo(),
            'project'      => $this->message->getProject(),
            'format'       => $this->message->getFormat(),
            'tags'         => $this->message->getTags(),
            'link'         => $this->message->getLink(),
        );

        $this->assertEquals($expected, $this->message->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function testToArray()
    {
        $this->message
            ->setSource('source')
            ->setFromAddress('from.mremi@test.com')
            ->setSubject('subject')
            ->setContent('Hello world!')
            ->setFromName('mremi')
            ->setReplyTo('to.mremi@test.com')
            ->setProject('project')
            ->setFormat('html')
            ->addTag('tag1')
            ->addTag('tag2')
            ->setLink('http://www.flowdock.com/')
            ->setResponse(new Response(200));

        $expected = array(
            'source'       => $this->message->getSource(),
            'from_address' => $this->message->getFromAddress(),
            'subject'      => $this->message->getSubject(),
            'content'      => $this->message->getContent(),
            'from_name'    => $this->message->getFromName(),
            'reply_to'     => $this->message->getReplyTo(),
            'project'      => $this->message->getProject(),
            'format'       => $this->message->getFormat(),
            'tags'         => $this->message->getTags(),
            'link'         => $this->message->getLink(),
            'response'     => $this->message->getResponse(),
        );

        $this->assertEquals($expected, $this->message->toArray());
    }
}
