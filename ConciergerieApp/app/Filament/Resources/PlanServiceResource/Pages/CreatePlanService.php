<?php

namespace App\Filament\Resources\PlanServiceResource\Pages;

use App\Filament\Resources\PlanServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlanService extends CreateRecord
{
    protected static string $resource = PlanServiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Plan de service créé avec succès';
    }
}