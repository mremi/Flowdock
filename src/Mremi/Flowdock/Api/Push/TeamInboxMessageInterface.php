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
 * Team inbox message interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface TeamInboxMessageInterface extends BaseMessageInterface
{
    /**
     * Sets the format of the message content
     *
     * @param string $format
     *
     * @return TeamInboxMessageInterface
     */
    public function setFormat($format);

    /**
     * Gets the format of the message content
     *
     * @return string
     */
    public function getFormat();

    /**
     * Sets the email address of the message sender
     *
     * @param string $fromAddress
     *
     * @return TeamInboxMessageInterface
     */
    public function setFromAddress($fromAddress);

    /**
     * Gets the email address of the message sender
     *
     * @return string
     */
    public function getFromAddress();

    /**
     * Sets the name of the message sender
     *
     * @param string $fromName
     *
     * @return TeamInboxMessageInterface
     */
    public function setFromName($fromName);

    /**
     * Gets the name of the message sender
     *
     * @return string
     */
    public function getFromName();

    /**
     * Sets the link associated with the message
     *
     * @param string $link
     *
     * @return TeamInboxMessageInterface
     */
    public function setLink($link);

    /**
     * Gets the link associated with the message
     *
     * @return string
     */
    public function getLink();

    /**
     * Sets the human readable identifier for more detailed message categorization
     *
     * @param string $project
     *
     * @return TeamInboxMessageInterface
     */
    public function setProject($project);

    /**
     * Gets the human readable identifier for more detailed message categorization
     *
     * @return string
     */
    public function getProject();

    /**
     * Sets the email address for replies
     *
     * @param string $replyTo
     *
     * @return TeamInboxMessageInterface
     */
    public function setReplyTo($replyTo);

    /**
     * Gets the email address for replies
     *
     * @return string
     */
    public function getReplyTo();

    /**
     * Sets the human readable identifier of the application that uses the Flowdock Push API
     *
     * @param string $source
     *
     * @return TeamInboxMessageInterface
     */
    public function setSource($source);

    /**
     * Gets the human readable identifier of the application that uses the Flowdock Push API
     *
     * @return string
     */
    public function getSource();

    /**
     * Sets the subject line of the message
     *
     * @param string $subject
     *
     * @return TeamInboxMessageInterface
     */
    public function setSubject($subject);

    /**
     * Gets the subject line of the message
     *
     * @return string
     */
    public function getSubject();
}
