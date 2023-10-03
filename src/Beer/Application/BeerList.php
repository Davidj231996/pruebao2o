<?php

namespace App\Beer\Application;

use App\Beer\Domain\BeerApiInterface;
use App\Beer\Domain\ValueObject\Beer;

class BeerList
{
    public function __construct(public BeerApiInterface $beerApi)
    {
    }

    public function list(string $filter): array
    {
        $beers = $this->beerApi->list($filter);
        $beersReturn = [];
        foreach ($beers as $beer) {
            $beersReturn[] = (Beer::fromArray($beer))->toArray();
        }
        return $beersReturn;
    }
}