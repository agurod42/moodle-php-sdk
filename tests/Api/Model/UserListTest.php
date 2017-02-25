<?php namespace MoodleSDK\Tests\Api\Model;

use MoodleSDK\Api\Model\User;
use MoodleSDK\Api\Model\UserList;
use MoodleSDK\Tests\Common\ContextTestCase;

use PHPUnit\Framework\TestCase;

/**
 * @covers User
 */
class UserListTest extends ContextTestCase {

    /**
    * @dataProvider contextProvider
    */
    public function testAll($context) {
        $userList = new UserList();
        $userList->all($context);
        
        $this->assertGreaterThan(0, count($userList));
        $this->assertInstanceOf(User::class, $userList[0]);
    }

}