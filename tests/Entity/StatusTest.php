<?php

namespace App\Tests\Entity;

use App\Entity\Status;

use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class StatusTest extends KernelTestCase
{

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->statusEnt = new Status();
    }

    public function testSetDescription()
    {
        $descTest = 'test description';
        $this->statusEnt->setDescription($descTest);
        $descResult = $this->statusEnt->getDescription();
        $this->assertEquals($descTest, $descResult);
    }

}
