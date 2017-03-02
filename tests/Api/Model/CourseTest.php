<?php namespace MoodleSDK\Tests\Api\Model;

use Carbon\Carbon;
use MoodleSDK\Api\Model\Course;
use MoodleSDK\Api\Model\Enum\CourseFormat;
use MoodleSDK\Api\Model\Enum\CourseSummaryFormat;
use MoodleSDK\Api\Model\User;
use MoodleSDK\Api\Model\UserList;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

define(TEST_COURSE_ENROL_ROLE_ID, 1);
define(TEST_COURSE_SHORTNAME, 'test'.md5('agurz/Moodle-PHP-SDK'));
define(TEST_DEFAULT_COURSE_SHORTNAME, 'test-course');

/**
 * @covers Course
 */
class CourseTest extends ContextTestCase {

    private $course;

    public function setUp() {
        $this->course = new Course();
    }

    /**
    * @dataProvider contextProvider
    */
    public function testCreate($context) {
        $this->course
            ->setShortName(TEST_COURSE_SHORTNAME)
            ->setDisplayName('Course DisplayName')
            ->setFullName('Course FullName')
            ->setFormat(CourseFormat::Topics)
            ->setSummary('Summary Test')
            ->setSummaryFormat(CourseSummaryFormat::Plain)
            ->setCategoryId(1)
            ->setStartDate(Carbon::now())
            ->setEndDate(Carbon::now()->addYear())
            ->create($context);

        $this->assertNotEmpty(Course::instance()->setShortName(TEST_COURSE_SHORTNAME)->get($context)->getId());
    }

    /**
    * @dataProvider contextProvider
    * @depends testCreate
    */
    public function testGet($context) {
        $this->course
                ->setShortName(TEST_COURSE_SHORTNAME)
                ->get($context);

        $this->assertNotEmpty($this->course->getId());
    }

    /**
    * @dataProvider contextProvider
    * @depends testCreate
    * @depends testGet
    */
    public function testUpdate($context) {
        $this->course
            ->setShortName(TEST_COURSE_SHORTNAME)
            ->get($context)
            ->setFullName('Course FullName Edited')
            ->update($context);

        $this->assertEquals(
            'Course FullName Edited', 
            Course::instance()->setShortName(TEST_COURSE_SHORTNAME)->get($context)->getFullName()
        );
    }

    /**
    * @dataProvider contextProvider
    * @depends testUpdate
    */
    public function testEnrolledUsers($context) {
        $enrolledUsers = $this->course
                                ->setShortName(TEST_DEFAULT_COURSE_SHORTNAME)
                                ->get($context)
                                ->enrolledUsers($context);
        
        $this->assertInstanceOf(UserList::class, $enrolledUsers);
        $this->assertGreaterThan(0, count($enrolledUsers));
    }

    /**
    * @dataProvider contextProvider
    * @depends testEnrolledUsers
    */
    public function testEnrolUser($context) {
        $this->course
            ->setShortName(TEST_COURSE_SHORTNAME)
            ->get($context)
            ->enrolUser($context, User::instance()->setUsername('admin')->get($context), TEST_COURSE_ENROL_ROLE_ID);
        
        $this->assertGreaterThan(0, count($this->course->enrolledUsers($context)));
    }

    /**
    * @dataProvider contextProvider
    * @depends testEnrolUser
    */
    public function testUnenrolUser($context) {
        $this->course
            ->setShortName(TEST_COURSE_SHORTNAME)
            ->get($context)
            ->unenrolUser($context, User::instance()->setUsername('admin')->get($context), TEST_COURSE_ENROL_ROLE_ID);
        
        $this->assertEquals(0, count($this->course->enrolledUsers($context)));
    }

    /**
    * @dataProvider contextProvider
    * @depends testUnenrolUser
    */
    public function testDelete($context) {
        $this->course
            ->setShortName(TEST_COURSE_SHORTNAME)
            ->get($context)
            ->delete($context);
        
        $this->assertEmpty(Course::instance()->setShortName(TEST_COURSE_SHORTNAME)->get($context)->getId());
    }

}