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
 * Chat message class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ChatMessage extends BaseMessage implements ChatMessageInterface
{
    /**
     * @var string
     */
    protected $externalUserName;

    /**
     * @var integer
     */
    protected $messageId;

    /**
     * {@inheritdoc}
     */
    public function setExternalUserName($externalUserName)
    {
        $this->externalUserName = $externalUserName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExternalUserName()
    {
        return $this->externalUserName;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageId()
    {
        return $this->messageId;
    }
}
