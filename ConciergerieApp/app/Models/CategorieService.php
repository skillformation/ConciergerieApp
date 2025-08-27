<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieService extends Model
{
    /** @use HasFactory<\Database\Factories\CategorieServiceFactory> */
    use HasFactory;

    protected $table = 'categorie_service';
    protected $primaryKey = 'id_categorie';
    
    public $timestamps = false; // Only created_at in migration

    protected $fillable = [
        'nom_categorie',
        'description',
        'icone',
        'ordre_affichage',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
        'ordre_affichage' => 'integer',
        'created_at' => 'timestamp'
    ];

    
}
