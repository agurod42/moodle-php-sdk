<?php 

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;

use PHPUnit\Framework\TestCase;

/**
 * @covers RestApiCall
 */
class RestApiCallTest extends TestCase {

    private $context;

    public function callProvider() {
        if (!$this->context) {
            $this->context = (new RestApiContext())
                                ->setUrl('fusionar.ddns.net:2118/moodle')
                                ->setCredential(new AuthTokenCredential('fd47e3a65abc8e45464296bd062aa001'));
        }

        $call = $this->context->newCall('core_webservice_get_site_info', []);

        return [[$call]];
    }

    /**
    * @dataProvider callProvider
    */
    public function testExecute($call) {
        $this->assertInternalType('string', $call->execute());
    }

}