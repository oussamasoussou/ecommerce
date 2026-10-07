<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'phone',
        'password',
        'role_id',
        'is_active',
        'address',
        'city',
        'country',
        'last_login_at',
        'email_verified_at',
        'provider',
        'provider_id',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relation vers le rôle de l'utilisateur.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /** Rôles ayant accès au back-office */
    public const ADMIN_ROLES = [1, 2]; // 1 = super-admin, 2 = admin

    public function isAdmin(): bool
    {
        return in_array((int) $this->role_id, self::ADMIN_ROLES, true);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistProducts()
    {
        return $this->belongsToMany(Produit::class, 'wishlists', 'user_id', 'produit_id')
            ->withTimestamps();
    }

    public function wishlistCount()
    {
        return $this->wishlists()->count();
    }

    /**
     * Normalise un numéro de téléphone pour la comparaison :
     * chiffres uniquement, sans l'indicatif tunisien (+216 / 00216).
     */
    public static function normalizePhone(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if (strlen($digits) > 8) {
            $digits = preg_replace('/^(00216|216)/', '', $digits);
        }

        return $digits;
    }

    /**
     * Retrouve les utilisateurs dont le téléphone correspond, quel que soit le format saisi.
     */
    public static function findByPhone(?string $phone)
    {
        $normalized = self::normalizePhone($phone);

        if (strlen($normalized) < 6) {
            return collect();
        }

        // Pré-filtre SQL sur les 2 derniers chiffres (jamais séparés par un espace),
        // puis comparaison exacte des numéros normalisés en PHP
        return self::whereNotNull('phone')
            ->where('phone', 'like', '%' . substr($normalized, -2))
            ->get()
            ->filter(fn ($user) => self::normalizePhone($user->phone) === $normalized)
            ->values();
    }

}
