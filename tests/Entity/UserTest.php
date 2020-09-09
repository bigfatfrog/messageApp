<?php

namespace App\Tests\Entity;

use App\Entity\User;

use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->user = new User();
    }

    public function testSetName()
    {
        $nameTest = 'test name';
        $this->user->setName($nameTest);
        $nameResult = $this->user->getName();
        $this->assertEquals($nameTest, $nameResult);
    }

    public function testSetPassword()
    {
        $passTest = 'test password';
        $this->user->setPassword($passTest);
        $passResult = $this->user->getPassword();
        $this->assertEquals($passTest, $passResult);
    }

    public function testSetUsername()
    {
        $userTest = 'test username';
        $this->user->setUsername($userTest);
        $userResult = $this->user->getUsername();
        $this->assertEquals($userTest, $userResult);
    }

}
