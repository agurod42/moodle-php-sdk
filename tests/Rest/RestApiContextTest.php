<?php namespace MoodleSDK\Tests\Rest;

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

/**
 * @covers RestApiContext
 */
class RestApiContextTest extends ContextTestCase {

    public function availableContextProvider() {
        return [[$this->getContext()]];
    }

    public function unavailableContextProvider() {
        return [[RestApiContext::instance()->setUrl('unavailable-host')]];
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