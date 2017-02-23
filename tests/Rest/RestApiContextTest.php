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
                    ->setUrl(getenv('MOODLE_API_URL'))
                    ->setCredential(new AuthTokenCredential(getenv('MOODLE_API_TOKEN')))
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