<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banniere extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'image', 'lien', 'texte_bouton', 'position', 'est_actif'
    ];

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeParPosition($query, $position)
    {
        return $query->where('position', $position);
    }
}