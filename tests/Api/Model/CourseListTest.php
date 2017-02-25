<?php namespace MoodleSDK\Tests\Api\Model;

use Carbon\Carbon;
use MoodleSDK\Api\Model\Course;
use MoodleSDK\Api\Model\CourseList;
use MoodleSDK\Api\Model\Enum\CourseFormat;
use MoodleSDK\Api\Model\Enum\CourseSummaryFormat;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

/**
 * @covers User
 */
class CourseListTest extends ContextTestCase {

    /**
    * @dataProvider contextProvider
    */
    public function testAll($context) {
        $courseList = new CourseList();
        $courseList->all($context);
        
        //$this->assertGreaterThan(0, count($courseList));
        //$this->assertInstanceOf(Course::class, $courseList[0]);
    }

}