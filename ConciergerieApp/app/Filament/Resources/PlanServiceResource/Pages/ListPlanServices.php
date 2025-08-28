<?php

namespace App\Filament\Resources\PlanServiceResource\Pages;

use App\Filament\Resources\PlanServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanServices extends ListRecords
{
    protected static string $resource = PlanServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}