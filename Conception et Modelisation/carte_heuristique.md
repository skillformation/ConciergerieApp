# Dictionnaire de Données - Service de Conciergerie

## 1. Entité : PLAN_ABONNEMENT

| Champ | Type | Contraintes | Description |
|-------|------|-------------|-------------|
| id_plan | INT | PRIMARY KEY, NOT NULL | Identifiant unique du plan |
| nom_plan | VARCHAR(50) | NOT NULL | Nom du plan (Essentiel, Prestige, Excellence) |
| prix_mensuel | DECIMAL(10,2) | NOT NULL, CHECK > 0 | Prix mensuel en euros |
| description | TEXT | NULL | Description générale du plan |
| statut_actif | BOOLEAN | DEFAULT TRUE | Plan disponible à la souscription |

## 2. Entité : SERVICE

| Champ | Type | Contraintes | Description |
|-------|------|-------------|-------------|
| id_service | INT | PRIMARY KEY, NOT NULL | Identifiant unique du service |
| nom_service | VARCHAR(100) | NOT NULL | Nom du service |
| description_service | TEXT | NULL | Description détaillée du service |
| categorie | VARCHAR(50) | NULL | Catégorie de service (surveillance, gestion, etc.) |

## 3. Entité : PLAN_SERVICE (Table de liaison)

| Champ | Type | Contraintes | Description |
|-------|------|-------------|-------------|
| id_plan | INT | FOREIGN KEY, NOT NULL | Référence vers PLAN_ABONNEMENT |
| id_service | INT | FOREIGN KEY, NOT NULL | Référence vers SERVICE |
| inclus | BOOLEAN | DEFAULT FALSE | Service inclus dans le plan |

## 4. Liste des Plans

### Plan Essentiel (299€/mois)
- **Target** : Gestion quotidienne de base
- **Positionnement** : Service d'entrée de gamme

### Plan Prestige (599€/mois)
- **Target** : Gestion complète avec service personnalisé
- **Positionnement** : Service intermédiaire premium
- **Badge** : "RECOMMANDÉ"

### Plan Excellence (999€/mois)
- **Target** : Service ultra-premium pour patrimoines d'exception
- **Positionnement** : Haut de gamme

## 5. Services par Plan

### Services Plan Essentiel
- Surveillance régulière des biens
- Coordination des interventions de maintenance
- Rapport mensuel détaillé
- Disponibilité 6j/7 (9h-18h)
- Gestion administrative de base
- Service client dédié
- Réseau d'artisans qualifiés

### Services Plan Prestige (inclut Essentiel +)
- Tout du plan Essentiel
- Conciergerie 7j/7 - 24h/24
- Gestion complète des travaux et rénovations
- Services de jardinage et d'entretien extérieur
- Gestion des locations et des locataires
- Rapport hebdomadaire + bilan trimestriel
- Accès prioritaire aux artisans partenaires
- Conseils personnalisés en investissement

### Services Plan Excellence (inclut Prestige +)
- Tout du plan Prestige
- Gestionnaire personnel dédié
- Services de luxe (majordome, chef à domicile)
- Gestion des événements privés
- Sécurité renforcée et surveillance 24h/24
- Optimisation fiscale et juridique
- Réseau d'artisans de luxe exclusif
- Assistance voyage et déplacements
- Bilan mensuel personnalisé

## 6. Entité : DEMANDE_PERSONNALISEE

| Champ | Type | Contraintes | Description |
|-------|------|-------------|-------------|
| id_demande | INT | PRIMARY KEY, NOT NULL | Identifiant unique de la demande |
| date_demande | DATETIME | DEFAULT NOW() | Date de la demande |
| statut_demande | ENUM | ('en_attente', 'en_cours', 'terminée') | Statut de traitement |
| besoins_specifiques | TEXT | NULL | Description des besoins particuliers |
| budget_estime | DECIMAL(10,2) | NULL | Budget estimé pour le service personnalisé |

## 7. Contraintes Métier

- **Règle tarifaire** : Prestige = 2x Essentiel, Excellence = 3.33x Essentiel
- **Inclusion hiérarchique** : Chaque plan supérieur inclut tous les services du plan inférieur
- **Disponibilité** : Service client variable selon le plan (6j/7 à 24h/24)
- **Personnalisation** : Possibilité de devis sur mesure pour besoins spécifiques

## 8. Types d'Utilisateurs Cibles

| Profil | Plan Recommandé | Caractéristiques |
|--------|----------------|------------------|
| Propriétaire simple | Essentiel | Gestion de base, maintenance courante |
| Investisseur multiple | Prestige | Gestion locative, travaux réguliers |
| Patrimoine de luxe | Excellence | Services premium, gestion complète |