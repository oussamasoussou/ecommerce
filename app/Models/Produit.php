<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'sous_categorie_id',
        'marque_id',
        'nom',
        'description',
        'quantite',
        'prix_ht',
        'prix_tva',
        'prix_ttc',
        'prix_promotionnel',
        'poids',
        'est_actif',
        'avec_variant',
        'reference',
        'image',
    ];

    /**
     * Les attributs qui doivent être castés en types natifs.
     */
    protected $casts = [
        'est_actif' => 'boolean',
        'prix_ht' => 'decimal:2',
        'prix_tva' => 'decimal:2',
        'prix_ttc' => 'decimal:2',
        'prix_promotionnel' => 'decimal:2',
        'poids' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($produit) {
            // Génère une référence du type "PRD-A9F2C3"
            $produit->reference = 'PRD-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

            // Vérifie l'unicité dans la base (au cas rare d'une collision)
            while (Produit::where('reference', $produit->reference)->exists()) {
                $produit->reference = 'PRD-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            }
        });
    }

    // --- Relations Eloquent ---

    /**
     * Un produit appartient à une SousCatégorie.
     */
    public function sousCategorie(): BelongsTo
    {
        return $this->belongsTo(SousCategorie::class, 'sous_categorie_id');
    }

    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class, 'marque_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProduitVariant::class, 'produit_id');
    }

    public function getStockAttribute()
    {
        if ($this->avec_variant) {
            return $this->variants->sum('quantite_variant');
        }
        return $this->quantite;
    }

    /**
     * Relation avec la wishlist
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'produit_id');
    }

    /**
     * Vérifie si le produit est dans la wishlist de l'utilisateur connecté
     */
    public function isInWishlist(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->wishlists()
            ->where('user_id', auth()->id())
            ->exists();
    }

    // --- Accessors et Mutators ---

    /**
     * Accessor pour obtenir le prix final (promotionnel ou normal).
     */
    public function getPrixFinalAttribute(): float
    {
        return $this->prix_promotionnel ?? $this->prix_ttc;
    }

    /**
     * Mutator pour s'assurer que le nom est toujours stocké avec la première lettre en majuscule.
     */
    public function setNomAttribute(string $value): void
    {
        $this->attributes['nom'] = ucfirst($value);
    }

    public function images()
    {
        return $this->hasMany(ProduitImage::class);
    }

    public function produitsAssocies()
    {
        return $this->belongsToMany(
            Produit::class,
            'produit_associes',
            'produit_id',
            'produit_associe_id'
        )->where('est_actif', true);
    }

}