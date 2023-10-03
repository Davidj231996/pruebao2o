<?php

namespace App\Tests\Beer\Application;

use App\Beer\Application\BeerList;
use App\Tests\Shared\BeerTestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertTrue;

final class BeerListTest extends BeerTestCase
{
    public function testListNoFilter(): void
    {
        $stub = $this->getMockBuilder(BeerList::class)
            ->setConstructorArgs([$this->api])
            ->onlyMethods([])
            ->getMock();
        $beer = $stub->list('');
        assertCount(4, $beer);
    }

    public function testListFilter(): void
    {
        $stub = $this->getMockBuilder(BeerList::class)
            ->setConstructorArgs([$this->api])
            ->onlyMethods([])
            ->getMock();
        $beer = $stub->list('rice');
        assertCount(1, $beer);
    }
}