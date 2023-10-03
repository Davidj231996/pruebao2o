<?php

namespace App\Beer\Domain;

interface BeerApiInterface
{
    public function get(int $id): array;

    public function list(string $filter): array;
}