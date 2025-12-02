<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'variant_id', 
        'image_path',
        'is_main',
    ];

    // Relations
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProduitVariant::class);
    }

    
}