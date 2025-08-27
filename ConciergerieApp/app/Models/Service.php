<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'id_service';

    protected $fillable = [
        'id_categorie',
        'nom_service',
        'description',
        'disponible_24h',
        'niveau_requis',
        'duree_moyenne',
        'prix_unitaire',
        'actif'
    ];

    protected $casts = [
        'disponible_24h' => 'boolean',
        'actif' => 'boolean',
        'duree_moyenne' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'niveau_requis' => 'string'
    ];
}
