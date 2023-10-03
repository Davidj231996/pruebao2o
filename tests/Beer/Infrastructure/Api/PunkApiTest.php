<?php

namespace App\Tests\Beer\Infrastructure\Api;

use App\Beer\Infrastructure\Api\PunkApi;
use App\Tests\Shared\AbstractApiMock;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertTrue;

final class PunkApiTest extends KernelTestCase
{
    public function testGet(): void
    {
        $httpClient = new AbstractApiMock();
        $stub = $this->getMockBuilder(PunkApi::class)
            ->setConstructorArgs([$httpClient])
            ->onlyMethods([])
            ->getMock();
        $beer = $stub->get(1);
        assertTrue(1 === $beer[0]['id']);
    }

    public function testList(): void
    {
        $httpClient = new AbstractApiMock();
        $stub = $this->getMockBuilder(PunkApi::class)
            ->setConstructorArgs([$httpClient])
            ->onlyMethods([])
            ->getMock();
        $beers = $stub->list('');

        self::assertIsArray($beers);
        self::assertCount(4, $beers);
    }
}