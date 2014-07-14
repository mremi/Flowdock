<?php

/*
 * This file is part of the Mremi\Flowdock library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\Flowdock\Api\Push\Chat;

use Mremi\Flowdock\Api\Push\BaseMessage;

/**
 * Chat message class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class Message extends BaseMessage implements MessageInterface
{
    /**
     * @var string
     */
    private $externalUserName;

    /**
     * @var integer
     */
    private $messageId;

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

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), array(
            'external_user_name' => $this->externalUserName,
            'message_id'         => $this->messageId,
        ));
    }
}
