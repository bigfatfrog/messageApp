<?php

namespace App\Tests\Services;

use App\Services\PredisService;
use Predis\Client;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PredisServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->predisService = $kernel->getContainer()->get(PredisService::class);
    }

    public function testClient()
    {
        $this->assertEquals(true, PredisService::client() instanceof Client);
    }

    public function testGet()
    {
        $value = "test " . date("Y-m-d H:i:s");
        $this->predisService->set('test', $value );
        $result =  $this->predisService->get('test');
        $this->assertEquals($value, $result, "Value: $value Result: $result");
    }
}
