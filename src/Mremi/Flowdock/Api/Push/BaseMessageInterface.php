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
 * Base push message interface
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
interface BaseMessageInterface
{
    /**
     * Sets the content of the message
     *
     * @param string $content
     *
     * @return BaseMessageInterface
     */
    public function setContent($content);

    /**
     * Gets the content of the message
     *
     * @return string
     */
    public function getContent();

    /**
     * Adds a tag to the message
     *
     * @param string $tag
     *
     * @return BaseMessageInterface
     */
    public function addTag($tag);

    /**
     * Gets the message tags
     *
     * @return array
     */
    public function getTags();

    /**
     * Adds an error to the message
     *
     * @param string $error
     *
     * @return BaseMessageInterface
     */
    public function addError($error);

    /**
     * Gets the message errors
     *
     * @return array
     */
    public function getErrors();

    /**
     * Returns TRUE whether the message has some errors
     *
     * @return boolean
     */
    public function hasErrors();

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
}
