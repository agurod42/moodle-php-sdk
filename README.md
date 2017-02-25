# Moodle-PHP-SDK
PHP SDK for Moodle RESTful APIs

[![Build Status](https://travis-ci.org/agurz/Moodle-PHP-SDK.svg?branch=master)](https://travis-ci.org/agurz/Moodle-PHP-SDK)

*NOTE: This is still in development*

## Getting Started

1. Create a `RestApiContext` instance

        $context = new RestApiContext();
        $context
              ->setUrl('example.com/moodle')
              ->setCredential(new AuthTokenCredential('token'))
                
2. Create a model object instance, set it's properties and call `get`, `create`, `update`, or `delete` operations

        $user = new User();
        $user
            ->setUsername('username')
            ->setPassword('Password..01')
            ->setFirstName('first')
            ->setLastName('last')
            ->setFullName('first last')
            ->setEmail('test@example.com')
            ->create($context)

3. That's all!
