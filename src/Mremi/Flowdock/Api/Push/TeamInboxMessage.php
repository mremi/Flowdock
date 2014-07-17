<?php

/*
 * This file is part of the Mremi\Flowdock library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\Flowdock\Api\Push;

/**
 * Team inbox message class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class TeamInboxMessage extends BaseMessage implements TeamInboxMessageInterface
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $fromAddress;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $fromName;

    /**
     * @var string
     */
    protected $replyTo;

    /**
     * @var string
     */
    protected $project;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $link;

    /**
     * {@inheritdoc}
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function setFromAddress($fromAddress)
    {
        $this->fromAddress = $fromAddress;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromAddress()
    {
        return $this->fromAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
