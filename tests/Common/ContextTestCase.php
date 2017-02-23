<?php namespace MoodleSDK\Tests\Common;

use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiContext;

use PHPUnit\Framework\TestCase;

abstract class ContextTestCase extends TestCase {

    private $context;

    public function contextProvider() {
        return [[$this->getContext()]];
    }

    protected function getContext() {
        if (!$this->context) {
            $this->context = (new RestApiContext())
                                ->setUrl(getenv('MOODLE_API_URL'))
                                ->setCredential(new AuthTokenCredential(getenv('MOODLE_API_TOKEN')));
        }

        return $this->context;
    }

}