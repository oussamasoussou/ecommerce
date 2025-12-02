<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'produit_id', 'variant_id', 'prix_unitaire', 'quantite', 'total'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function produit() {
        return $this->belongsTo(Produit::class);
    }

    public function variant() {
        return $this->belongsTo(ProduitVariant::class, 'variant_id');
    }
}
