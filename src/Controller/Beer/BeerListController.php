<?php

namespace App\Controller\Beer;

use App\Beer\Application\BeerList;
use App\Beer\Domain\ValueObject\Beer;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * Búsqueda mediante una cadena de caracteres
     *
     * Se podrá no añadir una cadena de caracteres para obtener una búsqueda más completa. El filtrado se realizará por
     * el campo "food" de cerveza que en la API PunkAPI se corresponde con "food_pairing"
     *
     * @OA\Response(
     *      response=200,
     *      description="Devuelve un listado de cervezas filtradas o no",
     *      @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=Beer::class, groups={"full"}))
     *      )
     *  )
     *
     * @OA\Response(
     *     response=400,
     *     description="Devuelve un mensaje de error controlado"
     * )
     *
     * @OA\Parameter(
     *      name="filter",
     *      in="path",
     *      description="La cadena de carácteres por la que filtrar",
     *      allowEmptyValue=true,
     *      @OA\Schema(type="string")
     *  )
     *
     * @param string $filter
     * @return Response
     */
    #[Route('/beers/{filter}', name: 'beer_list', methods: ['GET'])]
    public function listBeers(string $filter = ''): Response
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