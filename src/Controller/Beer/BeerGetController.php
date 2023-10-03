<?php

namespace App\Controller\Beer;

use App\Beer\Application\BeerGet;
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
final class BeerGetController
{
    public function __construct(private readonly BeerGet $beerGet)
    {
    }

    #[Route('/beer/{id}', name: 'beer_get')]
    public function __invoke(Request $request, int $id): Response
    {
        try {
            return new JsonResponse($this->beerGet->get($id));
        } catch (TransportExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|DecodingExceptionInterface|ClientExceptionInterface) {
            return new JsonResponse([
                'error' => 'Error en la conexión con la API de cervezas'
            ], 400);
        } catch (Exception $exception) {
            return new JsonResponse([
                'error' => 'Error, vuelve a intentarlo más tarde: ' . $exception->getMessage()
            ], 400);
        }
    }
}