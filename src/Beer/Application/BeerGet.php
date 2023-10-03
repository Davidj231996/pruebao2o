<?php

namespace App\Beer\Application;

use App\Beer\Domain\BeerApiInterface;
use App\Beer\Domain\ValueObject\Beer;

class BeerGet
{
    public function __construct(public BeerApiInterface $beerApi)
    {
    }

    public function get(int $id): array
    {
        $beer = Beer::fromArray($this->beerApi->get($id)[0]);
        return  $beer->toArray();
    }
}