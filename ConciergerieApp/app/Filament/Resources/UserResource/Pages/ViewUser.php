<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn (User $record): bool => 
                    auth()->user()?->isAdmin() || 
                    (!$record->isAdmin() && auth()->user()?->hasAnyRole(['admin', 'manager']))
                ),
            Actions\DeleteAction::make()
                ->visible(fn (User $record): bool => 
                    auth()->user()?->isAdmin() && 
                    $record->id !== auth()->id()
                ),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informations de l\'utilisateur')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nom complet'),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('role')
                            ->label('Rôle')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'admin' => 'Administrateur',
                                'manager' => 'Manager',
                                'employee' => 'Employé',
                                'client' => 'Client',
                                default => $state,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'admin' => 'danger',
                                'manager' => 'warning',
                                'employee' => 'success',
                                'client' => 'primary',
                                default => 'secondary',
                            }),

                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Utilisateur actif')
                            ->boolean(),

                        Infolists\Components\IconEntry::make('email_verified_at')
                            ->label('Email vérifié')
                            ->boolean(),

                        Infolists\Components\TextEntry::make('email_verified_at')
                            ->label('Email vérifié le')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Non vérifié'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y H:i'),
                    ])->columns(2),
            ]);
    }
}