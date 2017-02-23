<?php 

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;

use PHPUnit\Framework\TestCase;

/**
 * @covers RestApiContext
 */
class RestApiContextTest extends TestCase {

    public function availableContextProvider() {
        return [
            [
                (new RestApiContext())
                    ->setUrl('fusionar.ddns.net:2118/moodle')
                    ->setCredential(new AuthTokenCredential('fd47e3a65abc8e45464296bd062aa001'))
            ]
        ];
    }

    public function unavailableContextProvider() {
        return [
            [
                (new RestApiContext())
                    ->setUrl('unavailable-host')
            ]
        ];
    }

    /**
    * @dataProvider availableContextProvider
    */
    public function testTestApiAvailability($context) {
        $this->assertTrue($context->testApiAvailability());
    }

    /**
    * @dataProvider unavailableContextProvider
    * @expectedException PHPUnit_Framework_Error
    */
    public function testTestApiAvailabilityWithUnavailableApi($context) {
        $context->testApiAvailability();
    }

    /**
    * @dataProvider availableContextProvider
    */
    public function testNewCall($context) {
        $this->assertInstanceOf(
            RestApiCall::class,
            $context->newCall('test', [])
        );
    }

}