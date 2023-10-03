<?php

namespace App\Controller\Beer;

use App\Beer\Application\BeerGet;
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
final class BeerGetController
{
    public function __construct(private readonly BeerGet $beerGet)
    {
    }

    /**
     * Mostrar los datos de una cerveza específica según el id especificado
     *
     * Los campos a mostrar de la cerveza serán: id, name, tagline, first_brewed, description, image
     *
     * @OA\Response(
     *      response=200,
     *      description="Devuelve los datos de la cerveza específica",
     *      @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=Beer::class, groups={"full"}))
     *      )
     *  )
     *
     * @OA\Response(
     *      response=400,
     *      description="Devuelve un mensaje de error controlado"
     *  )
     *
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="El identificador de la cerveza a buscar",
     *      @OA\Schema(type="integer")
     *  )
     *
     * @param int $id
     * @return Response
     */
    #[Route('/beer/{id}', name: 'beer_get', methods: ['GET'])]
    public function getBeer(int $id): Response
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