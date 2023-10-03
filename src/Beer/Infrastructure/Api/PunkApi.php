<?php

namespace App\Beer\Infrastructure\Api;

use App\Beer\Domain\BeerApiInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PunkApi implements BeerApiInterface
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function get(int $id): array
    {
        $response = $this->client->request('GET', 'https://api.punkapi.com/v2/beers/' . $id);
        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function list(string $filter): array
    {
        $url = 'https://api.punkapi.com/v2/beers';
        if ('' != $filter) {
            $filter = str_replace(' ', '_' ,$filter);
            $url = $url . '?food=' . $filter;
        }
        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }
}