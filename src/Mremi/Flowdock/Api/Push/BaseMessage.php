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
 * Base push message class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
abstract class BaseMessage implements BaseMessageInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $tags = array();

    /**
     * @var Response
     */
    protected $response;

    /**
     * {@inheritdoc}
     */
    public static function create()
    {
        return new static;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function clearTags()
    {
        $this->tags = array();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTags(array $tags)
    {
        $this->clearTags();

        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $array = $this->toArray();

        // to be consistent with the Flowdock API
        unset($array['response']);

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = get_object_vars($this);

        $keys = array_map(array($this, 'underscore'), array_keys($array));

        return array_combine($keys, array_values($array));
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseBody()
    {
        if (null === $this->response) {
            return array();
        }

        $body = json_decode($this->response->getBody(true), true);

        return is_array($body) ? $body : array();
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseMessage()
    {
        $body = $this->getResponseBody();

        return array_key_exists('message', $body) ? $body['message'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseErrors()
    {
        $body = $this->getResponseBody();

        return array_key_exists('errors', $body) ? $body['errors'] : array();
    }

    /**
     * {@inheritdoc}
     */
    public function hasResponseErrors()
    {
        return count($this->getResponseErrors()) > 0;
    }

    /**
     * A string to underscore.
     *
     * This has been copied from the DependencyInjection Symfony component.
     *
     * @param string $string The string to underscore
     *
     * @return string The underscored string
     */
    private function underscore($string)
    {
        return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), strtr($string, '_', '.')));
    }
}
