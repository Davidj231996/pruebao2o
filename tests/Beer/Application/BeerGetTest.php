<?php

namespace App\Tests\Beer\Application;

use App\Beer\Application\BeerGet;
use App\Tests\Shared\BeerTestCase;
use function PHPUnit\Framework\assertTrue;

final class BeerGetTest extends BeerTestCase
{
    public function testGet(): void
    {
        $stub = $this->getMockBuilder(BeerGet::class)
            ->setConstructorArgs([$this->api])
            ->onlyMethods([])
            ->getMock();
        $beer = $stub->get(1);
        assertTrue(1 === $beer['id']);
    }
}