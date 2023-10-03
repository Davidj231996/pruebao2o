<?php

namespace App\Beer\Domain\ValueObject;

class Beer
{
    private function __construct(
        private int $id,
        private string $name,
        private string $tagline,
        private string $firstBrewed,
        private string $description,
        private ?string $image
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['tagline'],
            $data['first_brewed'],
            $data['description'],
            $data['image_url']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tagline' => $this->tagline,
            'first_brewed' => $this->firstBrewed,
            'description' => $this->description,
            'image_url' => $this->image
        ];
    }
}