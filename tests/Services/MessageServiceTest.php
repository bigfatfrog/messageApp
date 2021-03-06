<?php

namespace App\Tests\Services;

use App\Entity\Message;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use App\Services\MessageService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->messageService = $kernel->getContainer()->get(MessageService::class);
        $this->statusRepository = $kernel->getContainer()->get(StatusRepository::class);
        $this->userRepository = $kernel->getContainer()->get(UserRepository::class);
    }

    public function testCreateMessage()
    {
        /*
         *  Test create a standard message
         */
        $user = $this->userRepository->findOneBy(array('username' => 'jim'));
        $phone = $_ENV['TWILLO_TEST_NO'];
        $text = 'hello';
        $message = $this->messageService->createMessage($user, $phone, $text);
        $this->assertEquals(true, $message instanceof Message);

        sleep(16);

        $text = null;
        $exception = false;
        try {
            $message = $this->messageService->createMessage($user, $phone, $text);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertEquals(true, $exception, "No text should have thrown an exception");

        /*
         *  Test min and max text validation
         */
        sleep(16);

        $text = "11111111111111111111" . "11111111111111111111" . "11111111111111111111" .
            "11111111111111111111" . "11111111111111111111" . "11111111111111111111" .
            "11111111111111111111";
        $exception = false;
        try {
            $message = $this->messageService->createMessage($user, $phone, $text);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertEquals(false, $exception, "140 chr text should NOT have thrown an exception");

        sleep(16);

        $text .= "X";
        $exception = false;
        try {
            $message = $this->messageService->createMessage($user, $phone, $text);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertEquals(true, $exception, "140 chr text should have thrown an exception");

        /*
         *  Test phone number validation
         */
        sleep(16);

        $text = "hello";
        $phone = 'rubbish';
        $exception = false;
        try {
            $message = $this->messageService->createMessage($user, $phone, $text);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertEquals(true, $exception, "rubbish phone should have thrown an exception");

        /*
         *  Test 15 second message delay is working
         */

        $phone = $_ENV['TWILLO_TEST_NO'];
        $text = 'hello';
        $message = $this->messageService->createMessage($user, $phone, $text);
        $this->assertEquals(true, $message instanceof Message);

        sleep(16);

        $text = null;
        $exception = false;
        try {
            $message = $this->messageService->createMessage($user, $phone, $text);
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertEquals(true, $exception,
            "An exception should be thrown if the delay is less than 15 sec");
    }
}
