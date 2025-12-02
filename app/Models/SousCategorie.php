<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SousCategorie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'categorie_id', 'logo', 'image'];

    /**
     * Relation vers la catégorie parente
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    /**
     * Relation vers les produits de cette sous-catégorie
     */
    public function produits()
    {
        return $this->hasMany(Produit::class, 'sous_categorie_id');
    }

}
