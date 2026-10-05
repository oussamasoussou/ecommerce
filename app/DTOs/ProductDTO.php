<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class ProductDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,
        public float $price,
        public ?float $compare_price = null,
        public int $category_id,
        public bool $is_featured = false,
        public bool $is_active = true,
        public ?array $images = null,
        public ?array $variants = null,
        public ?int $stock_quantity = 0
    ) {
        $this->compare_price = $this->compare_price ?? $this->price;
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: \Illuminate\Support\Str::slug($data['name']),
            description: $data['description'] ?? '',
            price: (float) $data['price'],
            compare_price: isset($data['compare_price']) ? (float) $data['compare_price'] : null,
            category_id: (int) $data['category_id'],
            is_featured: (bool) ($data['is_featured'] ?? false),
            is_active: (bool) ($data['is_active'] ?? true),
            images: $data['images'] ?? null,
            variants: $data['variants'] ?? null,
            stock_quantity: (int) ($data['stock_quantity'] ?? 0)
        );
    }
}
