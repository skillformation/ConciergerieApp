<?php

namespace App\Filament\Resources\PlanServiceResource\Pages;

use App\Filament\Resources\PlanServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewPlanService extends ViewRecord
{
    protected static string $resource = PlanServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informations du plan')
                    ->schema([
                        Infolists\Components\TextEntry::make('nom_plan')
                            ->label('Nom du plan'),

                        Infolists\Components\TextEntry::make('prix_mensuel')
                            ->label('Prix mensuel')
                            ->money('EUR'),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Description'),

                        Infolists\Components\TextEntry::make('niveau_service')
                            ->label('Niveau de service')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'basique' => 'gray',
                                'standard' => 'primary',
                                'premium' => 'warning',
                                'entreprise' => 'success',
                                default => 'secondary',
                            }),

                        Infolists\Components\TextEntry::make('target')
                            ->label('Cible')
                            ->badge(),

                        Infolists\Components\TextEntry::make('positionnement')
                            ->label('Positionnement'),

                        Infolists\Components\IconEntry::make('actif')
                            ->label('Plan actif')
                            ->boolean(),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y H:i'),
                    ])->columns(2),

                Infolists\Components\Section::make('Statistiques')
                    ->schema([
                        Infolists\Components\TextEntry::make('abonnements_count')
                            ->label('Nombre d\'abonnements')
                            ->state(fn ($record) => $record->abonnements()->count())
                            ->badge()
                            ->color('primary'),
                    ]),
            ]);
    }
}