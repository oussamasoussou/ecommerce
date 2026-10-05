<?php

namespace App\Repositories;

use App\Models\Produit;
use App\Models\ProduitImage;
use App\Models\ProduitVariant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductRepository
{
    /**
     * Retourne les produits en vedette actifs avec stock disponible.
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return $this->query()
            ->with(['sousCategorie.category', 'images', 'variants'])
            ->where('est_actif', true)
            ->where('quantite', '>', 0)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Retourne un produit par sa référence.
     */
    public function getProductByReference(string $reference): ?Produit
    {
        return $this->query()
            ->with(['sousCategorie.category', 'images', 'variants.couleur', 'variants.taille'])
            ->where('reference', $reference)
            ->firstOrFail();
    }

    /**
     * Recherche de produits avec filtres.
     */
    public function searchProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->query()
            ->with(['sousCategorie.category', 'images', 'marque'])
            ->where('est_actif', true);

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($builder) use ($q) {
                $builder->where('nom', 'LIKE', "%{$q}%")
                    ->orWhere('description', 'LIKE', "%{$q}%")
                    ->orWhere('reference', 'LIKE', "%{$q}%")
                    ->orWhereHas('marque', fn($b) => $b->where('name', 'LIKE', "%{$q}%"))
                    ->orWhereHas('sousCategorie', fn($b) => $b->where('name', 'LIKE', "%{$q}%"));
            });
        }

        if (!empty($filters['sous_categorie_id'])) {
            $query->where('sous_categorie_id', $filters['sous_categorie_id']);
        }

        if (!empty($filters['marque_id'])) {
            $query->where('marque_id', $filters['marque_id']);
        }

        if (!empty($filters['prix_min'])) {
            $query->where('prix_ttc', '>=', $filters['prix_min']);
        }

        if (!empty($filters['prix_max'])) {
            $query->where('prix_ttc', '<=', $filters['prix_max']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Base query builder.
     */
    protected function query(): Builder
    {
        return Produit::query();
    }
}
