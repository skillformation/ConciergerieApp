<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use App\Models\PlanService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Clients';

    protected static ?string $pluralLabel = 'Clients';

    protected static ?string $label = 'Client';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du client')
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('prenom')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('adresse')
                            ->label('Adresse')
                            ->rows(3),

                        Forms\Components\Select::make('type_client')
                            ->label('Type de client')
                            ->options([
                                'particulier' => 'Particulier',
                                'entreprise' => 'Entreprise',
                            ])
                            ->required(),

                        Forms\Components\Toggle::make('actif')
                            ->label('Client actif')
                            ->default(true),

                        Forms\Components\DateTimePicker::make('date_inscription')
                            ->label('Date d\'inscription')
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Abonnements')
                    ->schema([
                        Forms\Components\Repeater::make('abonnements')
                            ->label('Abonnements')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('id_plan')
                                    ->label('Plan de service')
                                    ->options(PlanService::where('actif', true)->pluck('nom_plan', 'id_plan'))
                                    ->required()
                                    ->preload(),

                                Forms\Components\DatePicker::make('date_debut')
                                    ->label('Date de début')
                                    ->required()
                                    ->default(now()),

                                Forms\Components\DatePicker::make('date_fin')
                                    ->label('Date de fin'),

                                Forms\Components\Select::make('statut')
                                    ->label('Statut')
                                    ->options([
                                        'actif' => 'Actif',
                                        'suspendu' => 'Suspendu',
                                        'expiré' => 'Expiré',
                                        'annulé' => 'Annulé',
                                    ])
                                    ->required()
                                    ->default('actif'),

                                Forms\Components\TextInput::make('prix_actuel')
                                    ->label('Prix actuel')
                                    ->numeric()
                                    ->prefix('€')
                                    ->step(0.01),

                                Forms\Components\Select::make('mode_paiement')
                                    ->label('Mode de paiement')
                                    ->options([
                                        'carte_credit' => 'Carte de crédit',
                                        'virement' => 'Virement bancaire',
                                        'paypal' => 'PayPal',
                                        'cheque' => 'Chèque',
                                    ]),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->addActionLabel('Ajouter un abonnement')
                            ->deleteActionLabel('Supprimer')
                            ->reorderActionLabel('Réorganiser'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\SelectColumn::make('type_client')
                    ->label('Type')
                    ->options([
                        'particulier' => 'Particulier',
                        'entreprise' => 'Entreprise',
                    ])
                    ->sortable(),

                Tables\Columns\IconColumn::make('actif')
                    ->label('Actif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('abonnements_count')
                    ->label('Abonnements')
                    ->counts('abonnements')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('abonnements.plan.nom_plan')
                    ->label('Plans')
                    ->badge()
                    ->separator(', ')
                    ->limit(50),

                Tables\Columns\TextColumn::make('date_inscription')
                    ->label('Date d\'inscription')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type_client')
                    ->label('Type de client')
                    ->options([
                        'particulier' => 'Particulier',
                        'entreprise' => 'Entreprise',
                    ]),

                Tables\Filters\TernaryFilter::make('actif')
                    ->label('Statut actif')
                    ->boolean()
                    ->trueLabel('Clients actifs')
                    ->falseLabel('Clients inactifs')
                    ->native(false),

                Tables\Filters\Filter::make('has_abonnements')
                    ->label('Avec abonnements')
                    ->query(fn (Builder $query): Builder => $query->has('abonnements'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('nom')
            ->searchOnBlur()
            ->striped()
            ->paginated([15, 25, 50, 100]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['abonnements.plan']);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['abonnements.plan']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nom', 'prenom', 'email'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Email' => $record->email,
            'Type' => $record->type_client,
            'Actif' => $record->actif ? 'Oui' : 'Non',
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}