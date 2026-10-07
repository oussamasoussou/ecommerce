<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'total', 'tva',
        'nom_client', 'adresse_livraison', 'telephone'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    /** Statuts possibles, dans l'ordre du cycle de vie d'une commande */
    public const STATUSES = [
        'pending' => 'En attente',
        'confirmed' => 'Confirmée',
        'shipped' => 'Expédiée',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée',
    ];

    /** Statuts définitifs : la commande ne peut plus changer de statut */
    public const FINAL_STATUSES = ['delivered', 'cancelled'];

    /** Classe de badge Bootstrap par statut (back-office) */
    public const STATUS_BADGES = [
        'pending' => 'bg-warning text-dark',
        'confirmed' => 'bg-info text-dark',
        'shipped' => 'bg-primary',
        'delivered' => 'bg-success',
        'cancelled' => 'bg-secondary',
    ];

    /** Libellé du statut affiché au client */
    public function statusLabel(): string
    {
        return self::STATUSES[$this->status]
            ?? ($this->status === 'paid' ? 'Payée' : ucfirst((string) $this->status));
    }

    public function statusBadge(): string
    {
        return self::STATUS_BADGES[$this->status] ?? 'bg-light text-dark';
    }

    public function isFinal(): bool
    {
        return in_array($this->status, self::FINAL_STATUSES, true);
    }
}
