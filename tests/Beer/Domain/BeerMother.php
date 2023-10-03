<?php

namespace App\Tests\Beer\Domain;

use App\Beer\Domain\ValueObject\Beer;
use App\Tests\Shared\MotherCreator;

final class BeerMother
{
    public static function create(?int $id = null): Beer
    {
        return Beer::fromArray([
            'id' => $id ?? MotherCreator::random()->numberBetween(0, 100),
            'name' => MotherCreator::random()->name,
            'tagline' => MotherCreator::random()->words(50, true),
            'first_brewed' => MotherCreator::random()->date(),
            'description' => MotherCreator::random()->words(200, true),
            'image_url' => MotherCreator::random()->imageUrl()
        ]);
    }
}