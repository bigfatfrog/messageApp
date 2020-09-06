<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use DateTime;
use PHPUnit\Framework\TestCase;


class ContactTest extends TestCase
{

    public function testSetPhone()
    {
        $phoneTest = 12345;
        $this->contact->setPhone($phoneTest);
        $phoneResult = $this->contact->getPhone();
        $this->assertEquals($phoneTest, $phoneResult);
    }

    public function testSetMessage()
    {
        $messageTest = 'hello';
        $this->contact->setMessage($messageTest);
        $messageResult = $this->contact->getMessage();
        $this->assertEquals($messageTest, $messageResult);
    }

    public function testSetUser()
    {
        $userTest = 'jim';
        $this->contact->setUser($userTest);
        $userResult = $this->contact->getUser();
        $this->assertEquals($userTest, $userResult);
    }

    public function testSetStatus()
    {
        $statusTest = 1;
        $this->contact->setStatus($statusTest);
        $statusResult = $this->contact->getStatus();
        $this->assertEquals($statusTest, $statusResult);
    }

    public function testSetUpdatedAt()
    {
        $updatedAtTest = new DateTime(sprintf('-%d days', rand(1, 100)));
        $this->contact->setUpdatedAt($updatedAtTest);
        $updatedAtResult = $this->contact->getUpdatedAt();
        $this->assertEquals($updatedAtTest, $updatedAtResult);
    }

    protected function setUp(): void
    {
        $this->contact = new Contact();
    }
}
