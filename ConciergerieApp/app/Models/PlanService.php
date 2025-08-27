<?php

namespace App\Models;

use App\Models\Abonnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanService extends Model
{
    /** @use HasFactory<\Database\Factories\PlanServiceFactory> */
    use HasFactory;

    protected $table = 'plan_services';
    protected $primaryKey = 'id_plan';

    protected $fillable = [
        'nom_plan',
        'prix_mensuel',
        'description',
        'niveau_service',
        'target',
        'positionnement',
        'actif'
    ];

    protected $casts = [
        'prix_mensuel' => 'decimal:2',
        'actif' => 'boolean',
        'niveau_service' => 'string'
    ];

      public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class, 'id_plan', 'id_plan');
    }
}
