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
     * @var array
     */
    protected $errors = array();

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
    public function addError($error)
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * {@inheritdoc}
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $array = $this->toArray();

        // to be consistent with the Flowdock API
        unset($array['errors']);

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
