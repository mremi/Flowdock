Flowdock library
================

This library allows you to interact with the Flowdock API.

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

if (!$chat->sendMessage($message)) {
    // handle errors...
    $message->getErrors();
}
```

<a name="contribution"></a>

## Contribution

Any question or feedback? Open an issue and I will try to reply quickly.

A feature is missing here? Feel free to create a pull request to solve it!

I hope this has been useful and has helped you. If so, share it and recommend
it! :)

[@mremitsme](https://twitter.com/mremitsme)
