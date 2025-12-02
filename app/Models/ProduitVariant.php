<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduitVariant extends Model
{
    // Indique le nom de la table si elle n'est pas la version plurielle du nom du modèle (optionnel, mais clair)
    protected $table = 'produit_variants';

    use HasFactory;
    use SoftDeletes;

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'produit_id',
        'couleur_id',
        'taille_id',
        'quantite_variant',
        'prix_ht_variant',
        'prix_tva_variant',
        'prix_ttc_variant',
        'prix_promotionnel_variant',
        'image_variant',
    ];

    /**
     * Les attributs qui doivent être castés en types natifs.
     */
    protected $casts = [
        'quantite_variant' => 'integer',
        'prix_ht_variant' => 'decimal:2',
        'prix_tva_variant' => 'decimal:2',
        'prix_ttc_variant' => 'decimal:2',
        'prix_promotionnel_variant' => 'decimal:2',
    ];

    // --- Relations Eloquent ---

    /**
     * Une variante appartient à un Produit.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * Une variante peut avoir une Couleur.
     * Assurez-vous d'avoir un modèle Couleur.php.
     */
    public function couleur(): BelongsTo
    {
        return $this->belongsTo(Couleur::class, 'couleur_id');
    }

    /**
     * Une variante peut avoir une Taille.
     * Assurez-vous d'avoir un modèle Taille.php.
     */
    public function taille(): BelongsTo
    {
        return $this->belongsTo(Taille::class, 'taille_id');
    }

    // --- Accessor (Optionnel) ---

    /**
     * Accesseur pour obtenir le prix final (promotionnel ou normal) de cette variante.
     */
    public function getPrixFinalAttribute(): float
    {
        // Retourne le prix promotionnel s'il est défini et non nul, sinon retourne le prix TTC
        return $this->prix_promotionnel_variant ?? $this->prix_ttc;
    }
}