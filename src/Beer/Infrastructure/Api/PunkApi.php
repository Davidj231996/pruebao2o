<?php

namespace App\Beer\Infrastructure\Api;

use App\Beer\Domain\BeerApiInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
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
        $url = 'https://api.punkapi.com/v2/beers/' . $id;
        $cache = new FilesystemAdapter();
        $value = $cache->getItem('beer_get_' . $id);
        if (!$value->isHit()) {
            $response = $this->client->request('GET', $url);
            $value->set($response->toArray());
            $cache->save($value);
        }

        return $value->get();
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
        $key = 'beer_list';
        if ('' != $filter) {
            $filter = str_replace(' ', '_', $filter);
            $key = $key . $filter;
            $url = $url . '?food=' . $filter;
        }
        $cache = new FilesystemAdapter();
        $value = $cache->getItem($key);
        if (!$value->isHit()) {
            $response = $this->client->request('GET', $url);
            $value->set($response->toArray());
            $cache->save($value);
        }
        return $value->get();
    }
}