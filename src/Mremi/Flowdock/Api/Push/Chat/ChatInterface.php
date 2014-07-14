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

/**
 * Chat interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface ChatInterface
{
    /**
     * Sends a message to a flow's chat
     *
     * @param MessageInterface $message A message instance to send
     * @param array            $options An array of options used by request
     *
     * @return boolean
     */
    public function sendMessage(MessageInterface $message, array $options = array());
}
