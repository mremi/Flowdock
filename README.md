Flowdock library
================

This library allows you to interact with the [Flowdock](https://www.flowdock.com/) API.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e7e69bdb-dce1-4189-b3d8-ae3ee661dbc9/big.png)](https://insight.sensiolabs.com/projects/e7e69bdb-dce1-4189-b3d8-ae3ee661dbc9)

[![Build Status](https://travis-ci.org/mremi/Flowdock.svg?branch=master)](https://travis-ci.org/mremi/Flowdock)
[![Total Downloads](https://poser.pugx.org/mremi/flowdock/downloads.svg)](https://packagist.org/packages/mremi/flowdock)
[![Latest Stable Version](https://poser.pugx.org/mremi/flowdock/v/stable.svg)](https://packagist.org/packages/mremi/flowdock)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mremi/Flowdock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mremi/Flowdock/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mremi/Flowdock/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mremi/Flowdock/?branch=master)

**Basic Docs**

* [Installation](#installation)
* [Push API](#push-api)
* [Contribution](#contribution)

<a name="installation"></a>

## Installation

Only 1 step:

### Download Flowdock using composer

Add Flowdock in your composer.json:

```js
{
    "require": {
        "mremi/flowdock": "dev-master"
    }
}
```

Now tell composer to download the library by running the command:

``` bash
$ php composer.phar update mremi/flowdock
```

Composer will install the library to your project's `vendor/mremi` directory.

<a name="push-api"></a>

## Push API

### Chat

```php
<?php

use Mremi\Flowdock\Api\Push\Chat\Chat;
use Mremi\Flowdock\Api\Push\Chat\Message;

$message = new Message;
$message
    ->setContent('This message has been sent with mremi/flowdock PHP library')
    ->setExternalUserName('mremi')
    ->addTag('#hello-world');

$chat = new Chat('your_flow_api_token');

if (!$chat->sendMessage($message, array('connect_timeout' => 1, 'timeout' => 1))) {
    // handle errors...
    $message->getErrors();
}
```

...and more features coming soon...

<a name="contribution"></a>

## Contribution

Any question or feedback? Open an issue and I will try to reply quickly.

A feature is missing here? Feel free to create a pull request to solve it!

I hope this has been useful and has helped you. If so, share it and recommend
it! :)

[@mremitsme](https://twitter.com/mremitsme)
