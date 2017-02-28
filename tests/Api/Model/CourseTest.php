<?php namespace MoodleSDK\Tests\Api\Model;

use Carbon\Carbon;
use MoodleSDK\Api\Model\Course;
use MoodleSDK\Api\Model\Enum\CourseFormat;
use MoodleSDK\Api\Model\Enum\CourseSummaryFormat;
use MoodleSDK\Rest\RestApiCall;
use MoodleSDK\Rest\RestApiContext;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

define(TEST_COURSE_SHORTNAME, 'test'.md5('agurz/Moodle-PHP-SDK'));

/**
 * @covers User
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
    * @depends testCreate
    * @depends testUpdate
    */
    public function testDelete($context) {
        $this->course
            ->setShortName(TEST_COURSE_SHORTNAME)
            ->get($context)
            ->delete($context);
        
        $this->assertEmpty(Course::instance()->setShortName(TEST_COURSE_SHORTNAME)->get($context)->getId());
    }

}