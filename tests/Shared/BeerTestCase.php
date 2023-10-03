<?php

namespace App\Tests\Shared;

use App\Beer\Infrastructure\Api\PunkApi;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BeerTestCase extends KernelTestCase
{
    protected MockObject $api;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->api = $this->getMockBuilder(PunkApi::class)
        ->setConstructorArgs([new AbstractApiMock()])
        ->onlyMethods([])
        ->getMock();
    }
}