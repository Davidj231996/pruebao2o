<?php

namespace App\Controller\Beer;

use App\Beer\Application\BeerList;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsController]
final class BeerListController
{
    public function __construct(private readonly BeerList $beerList)
    {
    }

    #[Route('/beers/{filter}', name: 'beer_list')]
    public function __invoke(Request $request, string $filter = ''): Response
    {
        try {
            return new JsonResponse($this->beerList->list($filter));
        } catch (TransportExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|DecodingExceptionInterface|ClientExceptionInterface) {
            return new JsonResponse([
                'error' => 'Error en la conexión con la API de cervezas'
            ], 400);
        } catch (Exception) {
            return new JsonResponse([
                'error' => 'Error, vuelve a intentarlo más tarde'
            ], 400);
        }
    }
}