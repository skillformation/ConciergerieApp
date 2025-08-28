<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;

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
                Infolists\Components\Section::make('Informations du client')
                    ->schema([
                        Infolists\Components\TextEntry::make('nom')
                            ->label('Nom'),

                        Infolists\Components\TextEntry::make('prenom')
                            ->label('Prénom'),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('telephone')
                            ->label('Téléphone')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('adresse')
                            ->label('Adresse'),

                        Infolists\Components\TextEntry::make('type_client')
                            ->label('Type de client')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'particulier' => 'primary',
                                'entreprise' => 'success',
                                default => 'secondary',
                            }),

                        Infolists\Components\IconEntry::make('actif')
                            ->label('Client actif')
                            ->boolean(),

                        Infolists\Components\TextEntry::make('date_inscription')
                            ->label('Date d\'inscription')
                            ->dateTime('d/m/Y H:i'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y H:i'),
                    ])->columns(2),

                Infolists\Components\Section::make('Abonnements')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('abonnements')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('plan.nom_plan')
                                    ->label('Plan de service')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('date_debut')
                                    ->label('Date de début')
                                    ->date('d/m/Y'),

                                Infolists\Components\TextEntry::make('date_fin')
                                    ->label('Date de fin')
                                    ->date('d/m/Y')
                                    ->placeholder('Non définie'),

                                Infolists\Components\TextEntry::make('statut')
                                    ->label('Statut')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'actif' => 'success',
                                        'suspendu' => 'warning',
                                        'expiré' => 'danger',
                                        'annulé' => 'gray',
                                        default => 'secondary',
                                    }),

                                Infolists\Components\TextEntry::make('prix_actuel')
                                    ->label('Prix actuel')
                                    ->money('EUR'),

                                Infolists\Components\TextEntry::make('mode_paiement')
                                    ->label('Mode de paiement')
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'carte_credit' => 'Carte de crédit',
                                        'virement' => 'Virement bancaire',
                                        'paypal' => 'PayPal',
                                        'cheque' => 'Chèque',
                                        default => $state,
                                    }),
                            ])
                            ->columns(2)
                            ->contained(false),
                    ])
                    ->collapsible(),
            ]);
    }
}