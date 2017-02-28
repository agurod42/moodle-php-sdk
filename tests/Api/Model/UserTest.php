<?php namespace MoodleSDK\Tests\Api\Model;

use MoodleSDK\Api\Model\CourseList;
use MoodleSDK\Api\Model\User;
use MoodleSDK\Api\Model\UserList;
use MoodleSDK\Auth\AuthTokenCredential;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

define(TEST_USERNAME, 'test'.md5('agurz/Moodle-PHP-SDK'));

/**
 * @covers User
 */
class UserTest extends ContextTestCase {

    private $user;

    public function setUp() {
        $this->user = new User();
    }

    /**
    * @dataProvider contextProvider
    */
    public function testGet($context) {
        $this->user
                ->setUsername('admin')
                ->get($context);

        $this->assertNotEmpty($this->user->getId());
    }

    /**
    * @dataProvider contextProvider
    * @depends testGet
    */
    public function testCreate($context) {
        $this->user
            ->setUsername(TEST_USERNAME)
            ->setPassword('Test..01')
            ->setFirstName('TestFirstName')
            ->setLastName('TestLastName')
            ->setFullName('TestFullName')
            ->setEmail('test@example.com')
            ->create($context);
        
        $this->assertNotEmpty(User::instance()->setUsername(TEST_USERNAME)->get($context)->getId());
    }

    /**
    * @dataProvider contextProvider
    * @depends testCreate
    * @depends testGet
    */
    public function testUpdate($context) {
        $this->user
            ->setUsername(TEST_USERNAME)
            ->get($context)
            ->setPassword('Test..01')
            ->setFirstName('TestFirstNameUpdated')
            ->setLastName('TestLastNameUpdated')
            ->setFullName('TestFullName')
            ->setEmail('test@example.com')
            ->update($context);

        $this->assertEquals(
            'TestFirstNameUpdated', 
            User::instance()->setUsername(TEST_USERNAME)->get($context)->getFirstName()
        );
    }

    /**
    * @dataProvider contextProvider
    * @depends testCreate
    * @depends testUpdate
    */
    public function testDelete($context) {
        $this->user
            ->setUsername(TEST_USERNAME)
            ->get($context)
            ->delete($context);
        
        $this->assertEmpty(User::instance()->setUsername(TEST_USERNAME)->get($context)->getId());
    }

    /**
    * @dataProvider contextProvider
    */
    public function testAllCourses($context) {
        $courseList = $this->user
                            ->setUsername(TEST_USERNAME)
                            ->get($context)
                            ->allCourses($context);
        
        $this->assertInstanceOf(CourseList::class, $courseList);
        $this->assertGreaterThan(0, count($courseList));
    }

}