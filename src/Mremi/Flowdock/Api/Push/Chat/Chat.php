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

use Guzzle\Http\Message\Response;

use Mremi\Flowdock\Api\Push\BasePush;

/**
 * Chat class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class Chat extends BasePush implements ChatInterface
{
    /**
     * {@inheritdoc}
     */
    public function sendMessage(MessageInterface $message, array $options = array())
    {
        $client = $this->createClient();

        $request = $client->post(null, array(
            'Content-Type' => 'application/json'
        ), json_encode(
            $message->toArray()
        ), $options);

        $response = $request->send();

        return $this->isValid($message, $response);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiUrl()
    {
        return sprintf('https://api.flowdock.com/v1/messages/chat/%s', $this->flowApiToken);
    }

    /**
     * Returns TRUE whether the response is valid
     *
     * @param MessageInterface $message  A message instance
     * @param Response         $response A response instance
     *
     * @return boolean
     */
    protected function isValid(MessageInterface $message, Response $response)
    {
        if (200 !== $response->getStatusCode()) {
            $message->addError(sprintf('Status code of response is wrong, expected 200, got %s', $response->getStatusCode()));
        }

        if ($response->hasHeader('content-type')) {
            if (array('application/json; charset=utf-8') !== $response->getHeader('content-type')->toArray()) {
                $message->addError(sprintf('Content type of response is wrong, expected "application/json; charset=utf-8", got %s',
                    json_encode($response->getHeader('content-type')->toArray())
                ));
            }
        } else {
            $message->addError(sprintf('Could not find header "content-type" in response, got %s', json_encode($response->getHeaderLines())));
        }

        if ('{}' !== $response->getBody(true)) {
            $message->addError(sprintf('Response body is wrong, expected "{}", got "%s"', $response->getBody(true)));
        }

        return !$message->hasErrors();
    }
}
