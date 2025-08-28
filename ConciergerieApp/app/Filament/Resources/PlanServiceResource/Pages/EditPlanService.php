<?php

namespace App\Filament\Resources\PlanServiceResource\Pages;

use App\Filament\Resources\PlanServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanService extends EditRecord
{
    protected static string $resource = PlanServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Plan de service modifié avec succès';
    }
}