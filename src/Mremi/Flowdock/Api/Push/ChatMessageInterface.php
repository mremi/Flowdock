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
 * Chat message interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface ChatMessageInterface extends BaseMessageInterface
{
    /**
     * Sets the name of the user sending the message
     *
     * @param string $externalUserName
     *
     * @return ChatMessageInterface
     */
    public function setExternalUserName($externalUserName);

    /**
     * Gets the name of the user sending the message
     *
     * @return string
     */
    public function getExternalUserName();

    /**
     * Sets the identifier of an another message to comment
     *
     * @param integer $messageId
     *
     * @return ChatMessageInterface
     */
    public function setMessageId($messageId);

    /**
     * Gets the identifier of an another message to comment
     *
     * @return integer
     */
    public function getMessageId();
}
