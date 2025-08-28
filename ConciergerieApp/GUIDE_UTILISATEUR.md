# Guide Utilisateur - ConciergerieApp Dashboard

## 🚀 Démarrage Rapide

### Accès au Dashboard
1. Ouvrez votre navigateur
2. Allez sur `http://localhost/admin` (ou votre domaine)
3. Connectez-vous avec un des comptes fournis

### Comptes de Test Disponibles

| Rôle | Email | Mot de passe | Accès |
|------|-------|--------------|-------|
| **Administrateur** | admin@conciergerie.com | password123 | Complet |
| **Manager** | manager@conciergerie.com | password123 | Gestion équipe |
| **Employé** | employee@conciergerie.com | password123 | Consultation |

---

## 👥 Gestion des Clients

### Consulter la Liste des Clients

1. **Navigation** : Cliquez sur "Clients" dans le menu latéral
2. **Vue d'ensemble** : Vous voyez tous les clients avec :
   - Nom et prénom
   - Adresse email
   - Type (Particulier/Entreprise)
   - Statut actif/inactif
   - Nombre d'abonnements

### Rechercher un Client

**Recherche globale :**
- Tapez dans le champ de recherche en haut
- Recherche dans : nom, prénom, email

**Filtres avancés :**
- **Type de client** : Particulier ou Entreprise
- **Statut** : Actifs, Inactifs, ou Tous
- **Abonnements** : Clients avec ou sans abonnements

### Créer un Nouveau Client

1. Cliquez sur **"Nouveau Client"**
2. Remplissez le formulaire :
   - **Informations obligatoires** : Nom, prénom, email, type
   - **Informations optionnelles** : Téléphone, adresse
3. **Gestion des abonnements** :
   - Cliquez sur "Ajouter un abonnement"
   - Sélectionnez un plan de service
   - Définissez les dates et le mode de paiement
4. Cliquez sur **"Créer"**

### Modifier un Client

1. Cliquez sur l'icône "crayon" dans la ligne du client
2. Modifiez les informations nécessaires
3. **Gérer les abonnements** :
   - Ajouter : Bouton "Ajouter un abonnement"
   - Modifier : Cliquez sur un abonnement existant
   - Supprimer : Icône "corbeille" sur l'abonnement
4. Cliquez sur **"Sauvegarder"**

### Consulter les Détails

1. Cliquez sur l'icône "œil" pour voir tous les détails
2. Informations affichées :
   - Données personnelles complètes
   - Historique des abonnements
   - Statuts et dates
   - Modes de paiement

---

## 📋 Gestion des Plans de Service

### Consulter les Plans

1. **Navigation** : "Plans de service" dans le menu
2. **Informations visibles** :
   - Nom du plan et prix mensuel
   - Niveau (Basique, Standard, Premium, Entreprise)
   - Cible (Particulier, Entreprise, Mixte)
   - Nombre d'abonnements actifs

### Créer un Plan

1. Cliquez sur **"Nouveau Plan"**
2. Remplissez :
   - **Nom du plan** (ex: "Premium Pro")
   - **Prix mensuel** (ex: 49.99)
   - **Description** complète
   - **Niveau de service** (liste déroulante)
   - **Cible** (qui peut souscrire)
   - **Positionnement** marketing
3. Activez/désactivez avec le bouton toggle
4. **"Créer"**

### Filtrer les Plans

- **Niveau** : Basique, Standard, Premium, Entreprise
- **Cible** : Particulier, Entreprise, Mixte
- **Statut** : Actifs ou inactifs

---

## 👤 Gestion des Utilisateurs (Admin/Manager)

### Voir les Utilisateurs

1. **Navigation** : "Utilisateurs" dans le menu
2. **Colonnes affichées** :
   - Nom complet et email
   - Rôle avec badge coloré
   - Statut actif/inactif
   - Email vérifié ou non

### Créer un Utilisateur

1. **"Nouvel Utilisateur"**
2. **Informations requises** :
   - Nom complet
   - Adresse email (unique)
   - Rôle (Admin, Manager, Employee, Client)
   - Mot de passe
   - Statut actif
3. **"Créer"**

### Permissions par Rôle

| Rôle | Voir | Créer | Modifier | Supprimer |
|------|------|-------|----------|-----------|
| **Admin** | Tout | Tout | Tout | Tout |
| **Manager** | Employees, Clients | Employees, Clients | Employees, Clients | Employees, Clients |
| **Employee** | Clients, Plans | Clients | Clients | Non |
| **Client** | Aucun accès au dashboard admin | | | |

---

## 🔍 Fonctionnalités Avancées

### Recherche Globale

- **Icône loupe** en haut à droite
- Recherche dans toutes les resources
- Résultats avec détails contextuels

### Tri des Colonnes

- Cliquez sur l'en-tête de n'importe quelle colonne
- Flèche vers le haut : ordre croissant
- Flèche vers le bas : ordre décroissant

### Pagination

- **Options** : 15, 25, 50, 100 éléments par page
- **Navigation** : Première, précédente, suivante, dernière
- **Indicateur** : "Affichage de X à Y sur Z éléments"

### Actions en Lot

1. **Sélection** : Cases à cocher dans la première colonne
2. **Actions disponibles** : Suppression groupée
3. **Confirmation** : Dialog de confirmation avant action

---

## 📱 Interface Mobile

Le dashboard est entièrement responsive :
- **Menu hamburger** sur mobile
- **Colonnes adaptatives** : masquage automatique sur petit écran
- **Formulaires optimisés** pour le tactile
- **Navigation simplifiée**

---

## 🚨 Gestion des Erreurs

### Messages de Validation

- **Champs obligatoires** : Bordure rouge + message
- **Format invalide** : Email mal formaté, etc.
- **Doublons** : Email déjà existant

### Notifications

- **Succès** : Message vert en haut à droite
- **Erreurs** : Message rouge avec détails
- **Informations** : Messages bleus pour les actions

### Codes d'Erreur Courants

| Erreur | Cause | Solution |
|--------|-------|----------|
| 403 | Accès refusé | Vérifiez vos permissions |
| 422 | Données invalides | Corrigez les champs en erreur |
| 500 | Erreur serveur | Contactez l'administrateur |

---

## 🔐 Sécurité et Bonnes Pratiques

### Mots de Passe

- **Minimum** 8 caractères
- **Changement** recommandé tous les 3 mois
- **Déconnexion** automatique après inactivité

### Protection des Données

- **Comptes inactifs** : Ne peuvent pas se connecter
- **Logs d'activité** : Toutes les actions sont enregistrées
- **Sauvegarde** : Données sauvegardées automatiquement

### Sessions

- **Durée** : 2 heures d'inactivité
- **Déconnexion** : Bouton en haut à droite
- **Multi-sessions** : Possibles sur différents appareils

---

## 💡 Conseils d'Utilisation

### Workflow Recommandé

1. **Commencer par les plans** : Créez vos offres de service
2. **Ajouter les clients** : Importez ou créez votre base client
3. **Attribuer les abonnements** : Liez clients et plans
4. **Suivre l'activité** : Utilisez les filtres et recherches

### Raccourcis Clavier

| Raccourci | Action |
|-----------|--------|
| `Ctrl + K` | Recherche globale |
| `Tab` | Navigation dans les formulaires |
| `Esc` | Fermer les modals |

### Organisation des Données

- **Nommage cohérent** : Plans avec noms explicites
- **Catégorisation** : Utilisez les types et niveaux
- **Documentation** : Descriptions détaillées
- **Maintenance** : Désactivez au lieu de supprimer

---

## 🆘 Support et Aide

### Problèmes Fréquents

**Je n'arrive pas à me connecter**
- Vérifiez email/mot de passe
- Votre compte est-il actif ?
- Avez-vous les bonnes permissions ?

**Les données ne s'affichent pas**
- Vérifiez les filtres appliqués
- Rechargez la page (F5)
- Votre rôle permet-il l'accès ?

**Je ne peux pas modifier/supprimer**
- Permissions insuffisantes
- Élément protégé (ex: votre propre compte admin)
- Données liées à d'autres éléments

### Contacts

- **Support technique** : Consultez les logs d'erreur
- **Formation** : Cette documentation
- **Suggestions** : Feedback via l'interface

---

## 📊 Rapports et Statistiques

### Informations Disponibles

- **Clients** : Total, actifs, par type
- **Abonnements** : Distribution par statut
- **Plans** : Popularité, revenus
- **Utilisateurs** : Activité par rôle

### Données Exportables

- **Format** : CSV (prévu dans future version)
- **Contenu** : Listes filtrées
- **Usage** : Analyses externes, rapports

---

*Guide mis à jour le 28 août 2025 - Version 1.0*