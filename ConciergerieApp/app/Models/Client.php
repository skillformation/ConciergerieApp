<?php

namespace App\Models;

use App\Models\Abonnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'date_inscription',
        'type_client',
        'actif'
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
        'actif' => 'boolean',
        'type_client' => 'string'
    ];

     public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class, 'id_client', 'id_client');
    }
    
    public function scopeByType($query, $type)
    {
        return $query->where('type_client', $type);
    }
}
