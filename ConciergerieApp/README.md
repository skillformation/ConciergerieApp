# ConciergerieApp - Dashboard Administratif

Une application Laravel 12 avec interface d'administration Filament pour la gestion d'une conciergerie.

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel" alt="Laravel 12">
<img src="https://img.shields.io/badge/Filament-v3-yellow?style=for-the-badge" alt="Filament v3">
<img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP 8.2+">
</p>

## 🚀 Démarrage Rapide

```bash
# Installation
composer install
php artisan migrate
php artisan db:seed

# Accès
Dashboard: http://localhost/admin
Login: admin@conciergerie.com / password123
```

## 📚 Documentation

| Document | Description |
|----------|-------------|
| [**MODIFICATIONS_DOCUMENTATION.md**](MODIFICATIONS_DOCUMENTATION.md) | Documentation complète de toutes les modifications |
| [**GUIDE_TECHNIQUE.md**](GUIDE_TECHNIQUE.md) | Guide technique pour les développeurs |
| [**GUIDE_UTILISATEUR.md**](GUIDE_UTILISATEUR.md) | Manuel d'utilisation du dashboard |

## ✨ Fonctionnalités

- 🖥️ **Dashboard Filament** complet avec gestion clients, plans, utilisateurs
- 🔐 **Système de rôles** (Admin, Manager, Employee, Client)
- 📝 **Page d'inscription** avec sélection de rôle
- 🔍 **Recherche et filtres** avancés
- 📊 **Données de test** réalistes (50 clients, 41 plans, 72 abonnements)
- 🛡️ **Sécurité** avec contrôle d'accès granulaire

## 👥 Comptes de Test

| Rôle | Email | Mot de passe | Permissions |
|------|-------|--------------|-------------|
| **Admin** | admin@conciergerie.com | password123 | Accès complet |
| **Manager** | manager@conciergerie.com | password123 | Gestion équipe |
| **Employee** | employee@conciergerie.com | password123 | Consultation |

## 🏗️ Stack Technique

- **Backend :** Laravel 12
- **Interface Admin :** Filament v3
- **Base de données :** MySQL 8.0+
- **Frontend :** Livewire + Alpine.js
- **Authentication :** Laravel Sanctum

## 📁 Structure

```
app/Filament/Resources/     # Resources Filament
├── ClientResource.php      # Gestion clients
├── PlanServiceResource.php # Gestion plans
└── UserResource.php        # Gestion utilisateurs

app/Http/Middleware/        
└── CheckRole.php           # Contrôle d'accès

database/seeders/           # Génération données test
├── UserSeeder.php          # 5 utilisateurs
├── PlanServiceSeeder.php   # 41 plans
└── ClientAbonnementSeeder.php # 50 clients + abonnements
```

## 🔧 Commandes Utiles

```bash
# Régénérer les données de test
php artisan migrate:fresh --seed

# Optimiser Filament
php artisan filament:optimize

# Nettoyer les caches
php artisan route:clear && php artisan config:clear

# Créer une nouvelle resource
php artisan make:filament-resource ModelName
```

## 📈 Statistiques des Données Générées

- **👥 5 utilisateurs** avec rôles différents (4 actifs)
- **👤 50 clients** (35 particuliers, 15 entreprises, 38 actifs)
- **📋 41 plans de service** (37 actifs) répartis sur 4 niveaux
- **📝 72 abonnements** (59 actifs) avec statuts variés
- **💰 Revenus mensuels potentiels :** 7 950,60€
- **📊 Prix moyen des plans :** 332,95€

## 🎯 Fonctionnalités Détaillées

### Gestion des Clients
- Liste paginée avec recherche globale (nom, prénom, email)
- Filtres : type de client, statut actif, abonnements
- Formulaire complet avec gestion des abonnements
- Tri personnalisable sur toutes les colonnes

### Gestion des Plans
- 4 niveaux : Basique (9-39€), Standard (39-119€), Premium (119-499€), Entreprise (499-1999€)
- 3 cibles : Particulier, Entreprise, Mixte
- Descriptions et positionnements automatiques

### Système de Rôles
- **Admin :** Accès complet à toutes les fonctions
- **Manager :** Gestion des employés et clients
- **Employee :** Consultation et gestion des clients
- **Client :** Aucun accès au panel admin

## 🛡️ Sécurité

- **Middleware personnalisé** pour le contrôle d'accès
- **Hashage automatique** des mots de passe
- **Protection CSRF** sur tous les formulaires
- **Validation** complète des données
- **Comptes inactifs** automatiquement bloqués

## 🚀 Mise en Production

1. **Changez les mots de passe par défaut**
2. **Configurez votre domaine** dans `.env`
3. **Activez les caches** de production
4. **Configurez les sauvegardes** automatiques

```bash
# Production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📝 Prochaines Étapes

- [ ] Ajouter des widgets dashboard
- [ ] Implémenter les notifications
- [ ] Export de données (CSV, PDF)
- [ ] API REST complète
- [ ] Interface client séparée

## 🤝 Contribution

Cette application a été développée avec **Claude Code Assistant**. Pour toute question ou amélioration :

1. Consultez la documentation technique
2. Vérifiez les logs d'erreur
3. Testez avec les comptes fournis

---

## 📄 License

Ce projet utilise le framework Laravel sous [licence MIT](https://opensource.org/licenses/MIT).

**Développé avec ❤️ et Claude Code Assistant - Août 2025**
