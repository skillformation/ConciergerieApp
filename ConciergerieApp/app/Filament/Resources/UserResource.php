<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?string $pluralLabel = 'Utilisateurs';

    protected static ?string $label = 'Utilisateur';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'manager']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de l\'utilisateur')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom complet')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Rôle')
                            ->options([
                                'admin' => 'Administrateur',
                                'manager' => 'Manager',
                                'employee' => 'Employé',
                                'client' => 'Client',
                            ])
                            ->required()
                            ->helperText('Détermine les permissions d\'accès de l\'utilisateur'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Utilisateur actif')
                            ->default(true)
                            ->helperText('Les utilisateurs inactifs ne peuvent pas se connecter'),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email vérifié le')
                            ->helperText('Laissez vide si l\'email n\'est pas encore vérifié'),
                    ])->columns(2),

                Forms\Components\Section::make('Mot de passe')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->helperText('Laissez vide pour conserver le mot de passe actuel (modification uniquement)'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirmer le mot de passe')
                            ->password()
                            ->same('password')
                            ->dehydrated(false)
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])
                    ->visible(fn (string $context): bool => $context === 'create' || auth()->user()?->isAdmin()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\SelectColumn::make('role')
                    ->label('Rôle')
                    ->options([
                        'admin' => 'Administrateur',
                        'manager' => 'Manager',
                        'employee' => 'Employé',
                        'client' => 'Client',
                    ])
                    ->disabled(fn (User $record): bool => 
                        !auth()->user()?->isAdmin() && $record->isAdmin()
                    )
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Email vérifié')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Rôle')
                    ->options([
                        'admin' => 'Administrateur',
                        'manager' => 'Manager',
                        'employee' => 'Employé',
                        'client' => 'Client',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Statut')
                    ->boolean()
                    ->trueLabel('Utilisateurs actifs')
                    ->falseLabel('Utilisateurs inactifs')
                    ->native(false),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email vérifié')
                    ->attribute('email_verified_at')
                    ->nullable()
                    ->trueLabel('Emails vérifiés')
                    ->falseLabel('Emails non vérifiés')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (User $record): bool => 
                        auth()->user()?->isAdmin() || 
                        (!$record->isAdmin() && auth()->user()?->hasAnyRole(['admin', 'manager']))
                    ),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (User $record): bool => 
                        auth()->user()?->isAdmin() && 
                        $record->id !== auth()->id()
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->isAdmin()),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('name')
            ->searchOnBlur()
            ->striped()
            ->paginated([15, 25, 50, 100]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Les managers ne peuvent voir que les employés et clients
        if (auth()->user()?->isManager() && !auth()->user()?->isAdmin()) {
            $query->whereIn('role', ['employee', 'client']);
        }

        return $query;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Email' => $record->email,
            'Rôle' => match($record->role) {
                'admin' => 'Administrateur',
                'manager' => 'Manager',
                'employee' => 'Employé',
                'client' => 'Client',
                default => $record->role,
            },
            'Actif' => $record->is_active ? 'Oui' : 'Non',
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}