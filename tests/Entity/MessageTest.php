<?php

namespace App\Tests\Entity;

use App\Entity\Message;
use DateTime;
use PHPUnit\Framework\TestCase;


class MessageTest extends TestCase
{
    protected function setUp(): void
    {
        $this->message = new Message();
    }

    public function testSetPhone()
    {
        $phoneTest = 12345;
        $this->message->setPhone($phoneTest);
        $phoneResult = $this->message->getPhone();
        $this->assertEquals($phoneTest, $phoneResult);
    }

    public function testSetMessage()
    {
        $messageTest = 'hello';
        $this->message->setText($messageTest);
        $messageResult = $this->message->getText();
        $this->assertEquals($messageTest, $messageResult);
    }

    public function testSetUser()
    {
        $userTest = 'jim';
        $this->message->setUser($userTest);
        $userResult = $this->message->getUser();
        $this->assertEquals($userTest, $userResult);
    }

    public function testSetStatus()
    {
        $statusTest = 1;
        $this->message->setStatus($statusTest);
        $statusResult = $this->message->getStatus();
        $this->assertEquals($statusTest, $statusResult);
    }

    public function testSetUpdatedAt()
    {
        $updatedAtTest = new DateTime(sprintf('-%d days', rand(1, 100)));
        $this->message->setUpdatedAt($updatedAtTest);
        $updatedAtResult = $this->message->getUpdatedAt();
        $this->assertEquals($updatedAtTest, $updatedAtResult);
    }
}
