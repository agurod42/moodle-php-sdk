# Moodle-PHP-SDK
PHP SDK for Moodle RESTful APIs

[![Build Status](https://travis-ci.org/agurodriguez/moodle-php-sdk.svg?branch=master)](https://travis-ci.org/agurodriguez/moodle-php-sdk)

## Getting Started

1. Install MoodleSDK

    ```
    php composer.phar require agurz/moodle-php-sdk
    ```

2. Create a `RestApiContext` instance

    ```php
    $context = new RestApiContext();
    $context->setUrl('example.com/moodle')
            ->setCredential(new AuthTokenCredential('token'))
    ```
                
3. Create a model object instance, set it's properties and call `get`, `create`, `update`, or `delete` operations

    ```php
    $user = new User();
    $user->setUsername('username')
         ->setPassword('Password..01')
         ->setFirstName('first')
         ->setLastName('last')
         ->setFullName('first last')
         ->setEmail('test@example.com')
         ->create($context)
    ```

4. That's all!

## Usage example

### Creating a user and enrolling him into 'test-course' course

```php
<?php

require_once 'vendor/autoload.php';

use MoodleSDK\Api\Model\Course;
use MoodleSDK\Api\Model\User;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiContext;

$context = RestApiContext::instance()
                         ->setUrl('example.com/moodle')
                         ->setCredential(new AuthTokenCredential('token'))

$user = User::instance()
            ->setUsername('agurz')
            ->setPassword('Password..01')
            ->setFirstName('Agustn')
            ->setLastName('Rodríguez')
            ->setFullName('Agustn Rodríguez')
            ->setEmail('test@example.com')
            ->create($context);

$course = Course::instance()
                ->setShortName('test-course')
                ->get($context)
                ->enrolUser($context, $user);
```
    
