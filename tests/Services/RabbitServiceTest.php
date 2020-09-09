<?php

namespace App\Tests\Services;

use App\Entity\Message;
use App\Entity\Status;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use App\Services\RabbitService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RabbitServiceTest extends KernelTestCase
{

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->rabbitService = $kernel->getContainer()->get(RabbitService::class);
        $this->statusRepository = $kernel->getContainer()->get(StatusRepository::class);
        $this->userRepository = $kernel->getContainer()->get(UserRepository::class);
    }

    public function testReceive()
    {
        $exception = false;
        try {
            $this->rabbitService->receive(false);
        } catch (Exception $e) {
            $exception = true;
        }
        $this->assertEquals(false, $exception);
    }

    public function testSend()
    {
        $exception = false;
        try {
            $this->rabbitService->send('hello world');
        } catch (Exception $e) {
            $exception = true;
        }
        $this->assertEquals(false, $exception);
    }

    public function testSendSMS()
    {
        $result = $this->rabbitService->sendSMS($_ENV['TWILLO_TEST_NO'], 'hello ' . date('Y-m-d H:i:s'));
        $status = $this->statusRepository->findOneBy(array('description' => $result->status));
        $this->assertEquals(true, $status instanceof Status, "Result returned: $result");
    }

    public function testProcessMessage()
    {

        $message = new Message();
        $message->setPhone($_ENV['TWILLO_TEST_NO']);
        $message->setText('Hello');
        $user = $this->userRepository->findOneBy(array('username' => 'jim'));
        $message->setUser($user);

        $result = $this->rabbitService->processMessage($message);
        $this->assertEquals(true, $message instanceof Message);
    }

    public function testGetSMS()
    {
        $result = $this->rabbitService->getSMS();
    }
}
