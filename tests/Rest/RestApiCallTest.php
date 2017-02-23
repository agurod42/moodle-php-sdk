<?php namespace MoodleSDK\Tests\Rest;

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

/**
 * @covers RestApiCall
 */
class RestApiCallTest extends ContextTestCase {

    public function callProvider() {
        return [[$this->getContext()->newCall('core_webservice_get_site_info', [])]];
    }

    /**
    * @dataProvider callProvider
    */
    public function testExecute($call) {
        $this->assertInternalType('string', $call->execute());
    }

}