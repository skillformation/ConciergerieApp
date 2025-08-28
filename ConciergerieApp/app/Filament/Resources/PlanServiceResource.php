<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanServiceResource\Pages;
use App\Models\PlanService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PlanServiceResource extends Resource
{
    protected static ?string $model = PlanService::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationLabel = 'Plans de service';

    protected static ?string $pluralLabel = 'Plans de service';

    protected static ?string $label = 'Plan de service';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du plan')
                    ->schema([
                        Forms\Components\TextInput::make('nom_plan')
                            ->label('Nom du plan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('prix_mensuel')
                            ->label('Prix mensuel')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01)
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3),

                        Forms\Components\Select::make('niveau_service')
                            ->label('Niveau de service')
                            ->options([
                                'basique' => 'Basique',
                                'standard' => 'Standard',
                                'premium' => 'Premium',
                                'entreprise' => 'Entreprise',
                            ])
                            ->required(),

                        Forms\Components\Select::make('target')
                            ->label('Cible')
                            ->options([
                                'particulier' => 'Particulier',
                                'entreprise' => 'Entreprise',
                                'mixte' => 'Mixte',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('positionnement')
                            ->label('Positionnement')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('actif')
                            ->label('Plan actif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom_plan')
                    ->label('Nom du plan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('prix_mensuel')
                    ->label('Prix mensuel')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\SelectColumn::make('niveau_service')
                    ->label('Niveau')
                    ->options([
                        'basique' => 'Basique',
                        'standard' => 'Standard',
                        'premium' => 'Premium',
                        'entreprise' => 'Entreprise',
                    ])
                    ->sortable(),

                Tables\Columns\SelectColumn::make('target')
                    ->label('Cible')
                    ->options([
                        'particulier' => 'Particulier',
                        'entreprise' => 'Entreprise',
                        'mixte' => 'Mixte',
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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('niveau_service')
                    ->label('Niveau de service')
                    ->options([
                        'basique' => 'Basique',
                        'standard' => 'Standard',
                        'premium' => 'Premium',
                        'entreprise' => 'Entreprise',
                    ]),

                Tables\Filters\SelectFilter::make('target')
                    ->label('Cible')
                    ->options([
                        'particulier' => 'Particulier',
                        'entreprise' => 'Entreprise',
                        'mixte' => 'Mixte',
                    ]),

                Tables\Filters\TernaryFilter::make('actif')
                    ->label('Statut actif')
                    ->boolean()
                    ->trueLabel('Plans actifs')
                    ->falseLabel('Plans inactifs')
                    ->native(false),
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
            ->recordTitleAttribute('nom_plan')
            ->searchOnBlur()
            ->striped()
            ->paginated([15, 25, 50, 100]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['abonnements']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nom_plan', 'description'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Prix mensuel' => number_format($record->prix_mensuel, 2) . ' €',
            'Niveau' => $record->niveau_service,
            'Cible' => $record->target,
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
            'index' => Pages\ListPlanServices::route('/'),
            'create' => Pages\CreatePlanService::route('/create'),
            'view' => Pages\ViewPlanService::route('/{record}'),
            'edit' => Pages\EditPlanService::route('/{record}/edit'),
        ];
    }
}