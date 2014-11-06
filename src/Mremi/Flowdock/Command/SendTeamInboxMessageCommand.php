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

use Mremi\Flowdock\Api\Push\Push;
use Mremi\Flowdock\Api\Push\TeamInboxMessage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Sends a mail-like message to the team inbox of a flow
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class SendTeamInboxMessageCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('send-team-inbox-message')
            ->setDescription('Sends a mail-like message to the team inbox of a flow')

            ->addArgument('flow-api-token', InputArgument::REQUIRED, 'The flow API token')
            ->addArgument('source',         InputArgument::REQUIRED, 'The human readable identifier of the application that uses the Flowdock Push API')
            ->addArgument('from-address',   InputArgument::REQUIRED, 'The email address of the message sender')
            ->addArgument('subject',        InputArgument::REQUIRED, 'The subject line of the message')
            ->addArgument('content',        InputArgument::REQUIRED, 'The content of the message')

            ->addOption('from-name', null, InputOption::VALUE_REQUIRED,                               'The name of the message sender')
            ->addOption('reply-to',  null, InputOption::VALUE_REQUIRED,                               'The email address for replies')
            ->addOption('project',   null, InputOption::VALUE_REQUIRED,                               'The human readable identifier for more detailed message categorization')
            ->addOption('format',    null, InputOption::VALUE_REQUIRED,                               'The format of the message content')
            ->addOption('link',      null, InputOption::VALUE_REQUIRED,                               'The link associated with the message')
            ->addOption('tags',      null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'The message tags')
            ->addOption('options',   null, InputOption::VALUE_REQUIRED,                               'An array of options used by request');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $push = new Push($input->getArgument('flow-api-token'));

        $message = TeamInboxMessage::create()
            ->setSource($input->getArgument('source'))
            ->setFromAddress($input->getArgument('from-address'))
            ->setSubject($input->getArgument('subject'))
            ->setContent($input->getArgument('content'))
            ->setFromName($input->getOption('from-name'))
            ->setReplyTo($input->getOption('reply-to'))
            ->setProject($input->getOption('project'))
            ->setFormat($input->getOption('format'))
            ->setLink($input->getOption('link'))
            ->setTags($input->getOption('tags'));

        $options = $input->getOption('options') ? json_decode($input->getOption('options'), true) : array();

        if ($push->sendTeamInboxMessage($message, $options)) {
            $output->writeln('<info>Success:</info> the message has been sent');

            return;
        }

        $output->writeln(sprintf('<error>Failure:</error> %s', $message->getResponseMessage()));
        $output->writeln(var_export($message->getResponseErrors(), true));
    }
}
