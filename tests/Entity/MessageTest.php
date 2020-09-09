<?php

namespace App\Tests\Entity;

use App\Entity\Message;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;

use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class MessageTest extends KernelTestCase
{

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->statusRepository = $kernel->getContainer()->get(StatusRepository::class);
        $this->userRepository = $kernel->getContainer()->get(UserRepository::class);

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
        $userTest = $this->userRepository->findOneBy(array('username' => 'jim'));
        $this->message->setUser($userTest);
        $userResult = $this->message->getUser();
        $this->assertEquals($userTest, $userResult);
    }

    public function testSetStatus()
    {
        $statusTest = $this->statusRepository->findOneBy(array('description' => 'failed'));
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

    public function testSid()
    {
        $sidTest = "123456789";
        $this->message->setSid($sidTest);
        $sidResult = $this->message->getSid();
        $this->assertEquals($sidTest, $sidResult);
    }
}
