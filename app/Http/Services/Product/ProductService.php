<?php

namespace App\Http\Services\Product;

use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function createProduct(array $data): Product
    {
        $dto = ProductDTO::fromRequest($data);
        return $this->productRepository->createProduct((array) $dto);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $dto = ProductDTO::fromRequest($data);
        return $this->productRepository->updateProduct($product, (array) $dto);
    }

    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return $this->productRepository->getFeaturedProducts($limit);
    }

    public function getProductBySlug(string $slug): Product
    {
        return $this->productRepository->getProductBySlug($slug);
    }

    public function searchProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        return $this->productRepository->searchProducts($filters, $perPage);
    }

    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return $this->productRepository->query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function updateStock(Product $product, int $quantity, string $action = 'decrement'): bool
    {
        return $action === 'increment' 
            ? $product->incrementStock($quantity)
            : $product->decrementStock($quantity);
    }
}
