<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'sous_titre', 'image', 'ordre', 'est_actif', 'lien', 'texte_bouton'
    ];

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeOrdonne($query)
    {
        return $query->orderBy('ordre');
    }
}