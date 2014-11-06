<?php

/*
 * This file is part of the Mremi\Flowdock library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\Flowdock\Command;

use Mremi\Flowdock\Api\Push\ChatMessage;
use Mremi\Flowdock\Api\Push\Push;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Sends a message to a flow's chat
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class SendChatMessageCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('send-chat-message')
            ->setDescription('Sends a message to a flow\'s chat')

            ->addArgument('flow-api-token',     InputArgument::REQUIRED, 'The flow API token')
            ->addArgument('content',            InputArgument::REQUIRED, 'The content of the message')
            ->addArgument('external-user-name', InputArgument::REQUIRED, 'The name of the user sending the message')

            ->addOption('message-id', null, InputOption::VALUE_REQUIRED,                               'The identifier of an another message to comment')
            ->addOption('tags',       null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'The message tags')
            ->addOption('options',    null, InputOption::VALUE_REQUIRED,                               'An array of options used by request');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $push = new Push($input->getArgument('flow-api-token'));

        $message = ChatMessage::create()
            ->setContent($input->getArgument('content'))
            ->setExternalUserName($input->getArgument('external-user-name'))
            ->setTags($input->getOption('tags'))
            ->setMessageId($input->getOption('message-id'));

        $options = $input->getOption('options') ? json_decode($input->getOption('options'), true) : array();

        if ($push->sendChatMessage($message, $options)) {
            $output->writeln('<info>Success:</info> the message has been sent');

            return;
        }

        $output->writeln(sprintf('<error>Failure:</error> %s', $message->getResponseMessage()));
        $output->writeln(var_export($message->getResponseErrors(), true));
    }
}
