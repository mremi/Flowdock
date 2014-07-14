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

use Guzzle\Http\Client;

/**
 * Base push class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
abstract class BasePush
{
    /**
     * @var string
     */
    protected $flowApiToken;

    /**
     * Constructor
     *
     * @param string $flowApiToken A flow API token
     */
    public function __construct($flowApiToken)
    {
        $this->flowApiToken = $flowApiToken;
    }

    /**
     * Creates a client to interact with Flowdock API
     *
     * @return Client
     */
    protected function createClient()
    {
        return new Client($this->getApiUrl());
    }

    /**
     * Gets the API URL
     *
     * @return string
     */
    abstract protected function getApiUrl();
}
