<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Relation vers les utilisateurs ayant ce rôle.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
