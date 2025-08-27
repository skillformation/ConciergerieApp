<?php

namespace App\Models;

use App\Models\PlanService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abonnement extends Model
{
    /** @use HasFactory<\Database\Factories\AbonnementFactory> */
    use HasFactory;

    protected $table = 'abonnements';
    protected $primaryKey = 'id_abonnement';

    protected $fillable = [
        'id_client',
        'id_plan',
        'date_debut',
        'date_fin',
        'statut',
        'prix_actuel',
        'mode_paiement'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'prix_actuel' => 'decimal:2',
        'statut' => 'string'
    ];

       public function plan(): BelongsTo
    {
        return $this->belongsTo(PlanService::class, 'id_plan', 'id_plan');
    }
}
