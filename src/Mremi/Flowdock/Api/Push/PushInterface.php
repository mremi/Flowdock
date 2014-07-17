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
 * Push interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface PushInterface
{
    /**
     * Sends a message to a flow's chat
     *
     * @param ChatMessageInterface $message A message instance to send
     * @param array                $options An array of options used by request
     *
     * @return boolean
     */
    public function sendChatMessage(ChatMessageInterface $message, array $options = array());

    /**
     * Sends a mail-like message to the team inbox of a flow
     *
     * @param TeamInboxMessageInterface $message A message instance to send
     * @param array                     $options An array of options used by request
     *
     * @return boolean
     */
    public function sendTeamInboxMessage(TeamInboxMessageInterface $message, array $options = array());
}
