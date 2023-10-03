<?php

namespace App\Tests\Shared;

use App\Tests\Beer\Domain\BeerMother;
use Closure;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;

final class AbstractApiMock extends MockHttpClient
{
    private string $baseUri = 'https://api.punkapi.com/v2/beers';

    public function __construct()
    {
        $callback = Closure::fromCallable([$this, 'handleRequests']);

        parent::__construct($callback, $this->baseUri);
    }

    private function handleRequests(string $method, string $url): MockResponse
    {
        if ($method === 'GET' && str_starts_with($url, $this->baseUri.'/')) {
            $string = explode('/', $url);
            return $this->getMock(end($string));
        } else if($method === 'GET' && str_starts_with($url, $this->baseUri)) {
            if (str_contains($url, '?')) {
                $string = explode('=', $url);
                return $this->listMock(end($string));
            } else {
                return $this->listMock('');
            }
        }

        throw new \UnexpectedValueException("Mock not implemented: $method/$url");
    }

    private function getMock(int $id): MockResponse
    {
        $mock = [
            BeerMother::create($id)->toArray()
        ];

        return new MockResponse(
            json_encode($mock, JSON_THROW_ON_ERROR),
            ['http_code' => Response::HTTP_OK]
        );
    }

    private function listMock(string $filter): MockResponse
    {
        if ('' === $filter) {
            $mock = [
                BeerMother::create()->toArray(),
                BeerMother::create()->toArray(),
                BeerMother::create()->toArray(),
                BeerMother::create()->toArray()
            ];
        } else {
            $mock = [
                BeerMother::create()->toArray()
            ];
        }

        return new MockResponse(
            json_encode($mock, JSON_THROW_ON_ERROR),
            ['http_code' => Response::HTTP_OK]
        );
    }
}