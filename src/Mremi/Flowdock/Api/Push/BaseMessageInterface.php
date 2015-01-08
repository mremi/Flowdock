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

use Guzzle\Http\Message\Response;

/**
 * Base push message interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface BaseMessageInterface
{
    /**
     * Creates a new message instance
     *
     * @return static
     */
    public static function create();

    /**
     * Sets the content of the message
     *
     * @param string $content
     *
     * @return static
     */
    public function setContent($content);

    /**
     * Gets the content of the message
     *
     * @return string
     */
    public function getContent();

    /**
     * Removes all tags from the message
     *
     * @return static
     */
    public function clearTags();

    /**
     * Adds multiple tags to the message
     *
     * @param string[] $tags
     *
     * @return static
     */
    public function setTags(array $tags);

    /**
     * Adds a tag to the message
     *
     * @param string $tag
     *
     * @return static
     */
    public function addTag($tag);

    /**
     * Gets the message tags
     *
     * @return array
     */
    public function getTags();

    /**
     * Sets the Flowdock response
     *
     * @param Response $response
     *
     * @return static
     */
    public function setResponse(Response $response);

    /**
     * Gets the Flowdock response
     *
     * @return Response
     */
    public function getResponse();

    /**
     * Returns an array representation of the message data
     *
     * @return array
     */
    public function getData();

    /**
     * Returns an array representation of the message
     *
     * @return array
     */
    public function toArray();

    /**
     * Gets the Flowdock response body
     *
     * @return array
     */
    public function getResponseBody();

    /**
     * Gets the Flowdock response message
     *
     * @return string|null
     */
    public function getResponseMessage();

    /**
     * Gets the Flowdock response errors
     *
     * @return array
     */
    public function getResponseErrors();

    /**
     * Returns TRUE whether the Flowdock response has some errors
     *
     * @return boolean
     */
    public function hasResponseErrors();
}
