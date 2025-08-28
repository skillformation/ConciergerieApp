# Guide Technique - ConciergerieApp

## 🔧 Architecture Technique

### Stack Technologique
- **Framework :** Laravel 12
- **UI Admin :** Filament v3  
- **Base de données :** MySQL 8.0+
- **Authentication :** Laravel Sanctum
- **Frontend :** Livewire + Alpine.js (via Filament)

### Patterns Utilisés
- **Repository Pattern :** Via les Resources Filament
- **Factory Pattern :** Pour la génération de données de test
- **Middleware Pattern :** Contrôle d'accès basé sur les rôles
- **Observer Pattern :** Events Laravel pour les notifications

---

## 📊 Modèle de Données

### Relations Entre Modèles

```php
User (1) -----> (*) Roles [enum dans users]

Client (1) -----> (*) Abonnement
Abonnement (*) -----> (1) PlanService

// Futures relations possibles
Service (*) -----> (1) CategorieService
Client (*) -----> (*) Service [via table pivot]
```

### Clés Primaires Personnalisées
```php
Client: id_client
PlanService: id_plan  
Abonnement: id_abonnement
Service: id_service (détecté dans votre code)
```

---

## 🛠️ Configuration Filament

### Panel Provider Configuration

```php
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->registration()  // Page inscription activée
        ->registrationRouteSlug('register')
        ->colors(['primary' => Color::Amber])
        ->discoverResources(in: app_path('Filament/Resources'))
        ->authMiddleware([
            Authenticate::class,
            CheckRole::class . ':admin,manager,employee',  // Rôles autorisés
        ]);
}
```

### Middleware Personnalisé

```php
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    // 1. Vérification authentification
    // 2. Vérification compte actif  
    // 3. Validation des rôles requis
    // 4. Redirection ou accès autorisé
}
```

---

## 🎨 Personnalisation des Resources

### Structure Type d'une Resource

```php
class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 1;

    // Contrôle d'accès
    public static function canAccess(): bool
    {
        return auth()->user()?->canAccessAdmin();
    }

    // Formulaire
    public static function form(Form $form): Form { }

    // Table avec colonnes, filtres, actions
    public static function table(Table $table): Table { }

    // Query personnalisée
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['relations']);
    }

    // Recherche globale
    public static function getGloballySearchableAttributes(): array { }
}
```

### Composants Filament Utilisés

**Forms Components:**
```php
Forms\Components\TextInput::make('nom')
Forms\Components\Select::make('type_client')  
Forms\Components\Toggle::make('actif')
Forms\Components\DatePicker::make('date_debut')
Forms\Components\Repeater::make('abonnements')  // Gestion relations
Forms\Components\Section::make('titre')         // Groupement
```

**Table Components:**
```php
Tables\Columns\TextColumn::make('nom')
Tables\Columns\SelectColumn::make('type_client')  // Édition inline
Tables\Columns\IconColumn::make('actif')          // Boolean
Tables\Columns\BadgeColumn::make('statut')        // Avec couleurs
```

**Filters:**
```php
Tables\Filters\SelectFilter::make('type_client')
Tables\Filters\TernaryFilter::make('actif')      // Oui/Non/Tous
Tables\Filters\Filter::make('custom')            // Filtre personnalisé
```

---

## 🏭 Système de Factories

### Factory Pattern Avancé

```php
// database/factories/AbonnementFactory.php
public function definition(): array
{
    $dateDebut = $this->faker->dateTimeBetween('-6 months', 'now');
    $dateFin = $this->faker->dateTimeBetween(
        $dateDebut->format('Y-m-d') . ' +1 month',
        $dateDebut->format('Y-m-d') . ' +2 years'
    );
    
    return [
        'date_debut' => $dateDebut,
        'date_fin' => $dateFin,
        // Logique de dates cohérentes
    ];
}

// States pour différents scénarios
public function actif(): static
{
    return $this->state(fn (array $attributes) => [
        'statut' => 'actif',
        'date_fin' => $this->faker->dateTimeBetween('now + 1 month', 'now + 2 years'),
    ]);
}
```

### Relations dans les Factories

```php
// Relation automatique
'id_client' => Client::factory(),

// Relation vers modèle existant  
public function forClient(Client $client): static
{
    return $this->state(fn (array $attributes) => [
        'id_client' => $client->id_client,
    ]);
}
```

---

## 🌱 Système de Seeders

### Seeder Orchestré

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    // Ordre critique : dépendances d'abord
    $this->call([
        UserSeeder::class,           // Utilisateurs
        PlanServiceSeeder::class,    // Plans (référencés par abonnements)
        ClientAbonnementSeeder::class, // Clients + abonnements
    ]);
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}
```

### Distribution Statistique Réaliste

```php
// Probabilités dans ClientAbonnementSeeder
private function determineNombreAbonnements(): int
{
    $rand = rand(1, 100);
    
    if ($rand <= 60) return 1;      // 60% ont 1 abonnement
    elseif ($rand <= 85) return 2;  // 25% ont 2 abonnements  
    else return 3;                  // 15% ont 3 abonnements
}
```

---

## 🔒 Sécurité Implémentée

### Contrôle d'Accès Multi-Niveaux

1. **Middleware CheckRole**
   ```php
   Route::middleware(['auth', CheckRole::class . ':admin,manager'])
   ```

2. **Filament canAccess()**
   ```php
   public static function canAccess(): bool
   {
       return auth()->user()?->hasAnyRole(['admin', 'manager']);
   }
   ```

3. **Actions conditionnelles**
   ```php
   Tables\Actions\EditAction::make()
       ->visible(fn ($record) => auth()->user()->canEdit($record))
   ```

### Protection des Données Sensibles

```php
// Model User.php
protected $hidden = [
    'password',
    'remember_token',
];

protected function casts(): array
{
    return [
        'password' => 'hashed',  // Auto-hashing
    ];
}
```

---

## 📈 Optimisations Performances

### Eager Loading

```php
// Dans les Resources
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with(['abonnements.plan']);  // Évite les requêtes N+1
}
```

### Index Base de Données

```php
// Dans les migrations
$table->index(['niveau_service']);
$table->index(['statut']);
$table->index(['type_client']);
```

### Pagination Optimisée

```php
// Filament table configuration  
->paginated([15, 25, 50, 100])  // Options de pagination
->defaultSort('created_at', 'desc')
```

---

## 🐛 Debugging et Logs

### Logs Personnalisés

```php
// Dans vos controllers ou resources
Log::info('User accessed clients list', [
    'user_id' => auth()->id(),
    'role' => auth()->user()->role,
]);
```

### Debug Queries

```php
// Dans tinker ou temporairement
DB::enableQueryLog();
// ... votre code
dd(DB::getQueryLog());
```

---

## 🧪 Testing Recommandé

### Tests Feature pour Resources

```php
// tests/Feature/ClientResourceTest.php
public function test_admin_can_access_clients_page()
{
    $admin = User::factory()->admin()->create();
    
    $response = $this->actingAs($admin)
                     ->get('/admin/clients');
                     
    $response->assertStatus(200);
}

public function test_client_cannot_access_admin_panel()
{
    $client = User::factory()->client()->create();
    
    $response = $this->actingAs($client)
                     ->get('/admin');
                     
    $response->assertStatus(403);
}
```

### Tests de Factories

```php
public function test_client_factory_creates_valid_data()
{
    $client = Client::factory()->create();
    
    $this->assertInstanceOf(Client::class, $client);
    $this->assertContains($client->type_client, ['particulier', 'entreprise']);
    $this->assertIsBoolean($client->actif);
}
```

---

## 🔄 Commandes Artisan Utiles

### Développement

```bash
# Recréer les données de test
php artisan migrate:fresh --seed

# Créer une nouvelle resource Filament
php artisan make:filament-resource ModelName

# Optimiser Filament
php artisan filament:optimize

# Nettoyer les caches
php artisan route:clear && php artisan config:clear
```

### Production

```bash
# Optimiser l'application
php artisan optimize
php artisan config:cache  
php artisan route:cache
php artisan view:cache

# Migrations production
php artisan migrate --force
```

---

## 📚 Extensions Possibles

### Fonctionnalités Avancées

1. **Dashboard Widgets**
   ```php
   php artisan make:filament-widget ClientsOverview --stats-overview
   ```

2. **Notifications**
   ```php
   Notification::make()
       ->title('Client créé')
       ->success()
       ->send();
   ```

3. **Actions personnalisées**
   ```php
   Tables\Actions\Action::make('activate')
       ->action(fn ($record) => $record->update(['actif' => true]))
   ```

4. **Relations Manager**
   ```php
   php artisan make:filament-relation-manager ClientResource abonnements AbonnementsRelationManager
   ```

### Intégrations Tierces

- **Spatie Laravel Permission** : Système de permissions plus granulaire
- **Laravel Telescope** : Debugging avancé
- **Laravel Horizon** : Queue monitoring
- **Spatie MediaLibrary** : Gestion de fichiers

---

## 📋 Checklist Maintenance

### Quotidien
- [ ] Vérifier les logs d'erreur
- [ ] Monitorer les performances des requêtes
- [ ] Contrôler l'espace disque

### Hebdomadaire  
- [ ] Backup de la base de données
- [ ] Mise à jour des dépendances (composer update)
- [ ] Tests de non-régression

### Mensuel
- [ ] Audit de sécurité
- [ ] Nettoyage des données anciennes
- [ ] Analyse des performances

---

*Guide technique maintenu à jour avec les modifications de l'application*