<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

   
    public function scopeByType($query, $type)
    {
        return $query->where('type_client', $type);
    }
}
