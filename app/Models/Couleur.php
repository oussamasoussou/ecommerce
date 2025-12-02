<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Couleur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code_hex', 'image'];

    /**
     * Variantes utilisant cette couleur
     */
    public function produitVariants()
    {
        return $this->hasMany(ProduitVariant::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_couleur');
    }
}
