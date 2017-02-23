<?php 

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Log\ConsoleLog;
use MoodleSDK\Rest\RestApiContext;

use PHPUnit\Framework\TestCase;

/**
 * @covers RestApiContext
 */
class RestApiContextTest extends TestCase {

    public function newAvailableContext() {
        return [
            [
                (new RestApiContext())
                    ->setUrl('fusionar.ddns.net:2118/moodle')
                    ->setCredential(new AuthTokenCredential('fd47e3a65abc8e45464296bd062aa001'))
            ]
        ];
    }

    public function newUnavailableContext() {
        return [
            [
                (new RestApiContext())
                    ->setUrl('unavailable-host')
            ]
        ];
    }

    /**
    * @dataProvider newAvailableContext
    */
    public function testTestApiAvailability($context) {
        $this->assertTrue($context->testApiAvailability());
    }

    /**
    * @dataProvider newUnavailableContext
    * @expectedException PHPUnit_Framework_Error
    */
    public function testTestApiAvailabilityWithUnavailableApi($context) {
        $context->testApiAvailability();
    }

}