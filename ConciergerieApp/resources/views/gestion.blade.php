<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients - PrestigeConcierge</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Palette de couleurs harmonieuse */
            --deep-navy: #1A2E40;
            --warm-taupe: #9C8A7E;
            --soft-clay: #C4B6A9;
            --pale-sand: #E2DCD3;
            --cream: #F7F5F2;
            --dark-charcoal: #2A2A2A;
            --gold-tint: #D6C5A3;
            --sage-green: #A0A987;
            
            /* Typographie */
            --font-serif: 'Cormorant Garamond', serif;
            --font-sans: 'Plus Jakarta Sans', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-sans);
            color: var(--dark-charcoal);
            background-color: var(--cream);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Header Styles */
        .header {
            background: linear-gradient(135deg, var(--deep-navy) 0%, #243B55 100%);
            color: var(--cream);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo h1 {
            font-family: var(--font-serif);
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .logo .accent {
            color: var(--soft-clay);
        }
        
        .nav {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        
        .nav a {
            color: var(--cream);
            text-decoration: none;
            font-weight: 400;
            transition: color 0.2s ease;
        }
        
        .nav a:hover {
            color: var(--soft-clay);
        }
        
        .nav a.active {
            color: var(--soft-clay);
            font-weight: 500;
        }
        
        /* Main Content */
        .main {
            padding: 32px 0;
        }
        
        /* Page Title */
        .page-title {
            margin-bottom: 32px;
        }
        
        .page-title h2 {
            font-family: var(--font-serif);
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--deep-navy);
            margin-bottom: 12px;
        }
        
        .title-underline {
            width: 64px;
            height: 4px;
            background: linear-gradient(to right, var(--warm-taupe), var(--gold-tint));
            border-radius: 2px;
            margin-bottom: 16px;
        }
        
        .page-subtitle {
            color: var(--warm-taupe);
            font-size: 1.125rem;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid var(--pale-sand);
            overflow: hidden;
        }
        
        .card-header {
            padding: 24px;
            border-bottom: 1px solid var(--pale-sand);
        }
        
        .card-title {
            font-family: var(--font-serif);
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--deep-navy);
            margin-bottom: 16px;
        }
        
        .card-content {
            padding: 24px;
        }
        
        /* Filter Section */
        .filters {
            margin-bottom: 32px;
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--dark-charcoal);
            margin-bottom: 8px;
        }
        
        .filter-input,
        .filter-select {
            padding: 12px 16px;
            border: 1px solid var(--soft-clay);
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(247, 245, 242, 0.5);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        
        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: var(--warm-taupe);
            box-shadow: 0 0 0 3px rgba(156, 138, 126, 0.1);
        }
        
        .search-container {
            position: relative;
        }
        
        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--warm-taupe);
        }
        
        /* Sort Controls */
        .sort-controls {
            display: flex;
            gap: 16px;
            align-items: end;
            padding-top: 24px;
            border-top: 1px solid var(--pale-sand);
        }
        
        .sort-group {
            flex: 1;
        }
        
        .apply-btn {
            padding: 12px 24px;
            background: var(--deep-navy);
            color: var(--cream);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .apply-btn:hover {
            background: rgba(26, 46, 64, 0.9);
        }
        
        /* Results Summary */
        .results-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .results-count {
            color: var(--warm-taupe);
        }
        
        .per-page-control {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .per-page-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--dark-charcoal);
        }
        
        .per-page-select {
            padding: 8px 12px;
            border: 1px solid var(--soft-clay);
            border-radius: 6px;
            font-size: 0.875rem;
            background: white;
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }
        
        .clients-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-header {
            background: linear-gradient(135deg, var(--pale-sand) 0%, var(--cream) 100%);
        }
        
        .table-header th {
            padding: 16px 24px;
            text-align: left;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--deep-navy);
            border-bottom: 1px solid var(--pale-sand);
        }
        
        .table-body tr {
            border-bottom: 1px solid var(--pale-sand);
            transition: background-color 0.2s ease;
        }
        
        .table-body tr:hover {
            background: rgba(247, 245, 242, 0.5);
        }
        
        .table-body td {
            padding: 16px 24px;
            vertical-align: middle;
        }
        
        .client-name {
            font-weight: 500;
            color: var(--deep-navy);
        }
        
        .client-email {
            color: var(--dark-charcoal);
        }
        
        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-particulier {
            background: rgba(160, 169, 135, 0.2);
            color: var(--sage-green);
        }
        
        .badge-entreprise {
            background: rgba(156, 138, 126, 0.2);
            color: var(--warm-taupe);
        }
        
        .badge-active {
            background: rgba(34, 197, 94, 0.1);
            color: #059669;
        }
        
        .badge-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }
        
        /* Subscription Tags */
        .subscription-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .subscription-tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .subscription-premium {
            background: rgba(156, 138, 126, 0.2);
            color: var(--warm-taupe);
        }
        
        .subscription-business {
            background: rgba(214, 197, 163, 0.3);
            color: var(--deep-navy);
        }
        
        .subscription-standard {
            background: rgba(160, 169, 135, 0.2);
            color: var(--sage-green);
        }
        
        .subscription-none {
            background: rgba(156, 163, 175, 0.2);
            color: #6b7280;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            color: var(--warm-taupe);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: color 0.2s ease;
        }
        
        .action-btn:hover {
            color: var(--deep-navy);
        }
        
        .action-btn svg {
            width: 20px;
            height: 20px;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 32px;
        }
        
        .pagination-info {
            color: var(--warm-taupe);
            font-size: 0.875rem;
        }
        
        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .pagination-btn {
            padding: 8px 12px;
            color: var(--warm-taupe);
            border: 1px solid var(--soft-clay);
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            color: var(--deep-navy);
            border-color: var(--warm-taupe);
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination-btn.active {
            background: var(--deep-navy);
            color: var(--cream);
            border-color: var(--deep-navy);
        }
        
        .pagination-ellipsis {
            padding: 8px 12px;
            color: var(--warm-taupe);
        }
        
        /* Footer */
        .footer {
            background: var(--deep-navy);
            color: var(--cream);
            text-align: center;
            padding: 32px 0;
            margin-top: 64px;
        }
        
        .footer-logo {
            font-family: var(--font-serif);
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .footer-logo .accent {
            color: var(--soft-clay);
        }
        
        .footer-text {
            color: var(--soft-clay);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav {
                display: none;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .sort-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }
            
            .results-summary {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .pagination {
                flex-direction: column;
                gap: 16px;
            }
            
            .page-title h2 {
                font-size: 2rem;
            }
            
            .logo h1 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 640px) {
            .container {
                padding: 0 16px;
            }
            
            .card-content,
            .card-header {
                padding: 16px;
            }
            
            .table-header th,
            .table-body td {
                padding: 12px 16px;
                font-size: 0.875rem;
            }
            
            .subscription-list {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-container">
                <div class="logo">
                    <h1>Prestige<span class="accent">Concierge</span></h1>
                </div>
                <nav class="nav">
                    <a href="#">Tableau de bord</a>
                    <a href="#" class="active">Clients</a>
                    <a href="#">Propriétés</a>
                    <a href="#">Abonnements</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <!-- Page Title -->
            <div class="page-title">
                <h2>Gestion des Clients</h2>
                <div class="title-underline"></div>
                <p class="page-subtitle">Gérez votre portefeuille client avec élégance et efficacité</p>
            </div>

            <!-- Filters -->
            <div class="card filters">
                <div class="card-header">
                    <h3 class="card-title">Filtres et Recherche</h3>
                </div>
                <div class="card-content">
                    <div class="filters-grid">
                        <!-- Search Input -->
                        <div class="filter-group">
                            <label class="filter-label">Recherche globale</label>
                            <div class="search-container">
                                <input type="text" id="search" class="filter-input" placeholder="Nom, prénom, email...">
                                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Type Client Filter -->
                        <div class="filter-group">
                            <label class="filter-label">Type de client</label>
                            <select id="type_client" class="filter-select">
                                <option value="">Tous les types</option>
                                <option value="particulier">Particulier</option>
                                <option value="entreprise">Entreprise</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-group">
                            <label class="filter-label">Statut</label>
                            <select id="actif" class="filter-select">
                                <option value="">Tous les statuts</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sort Controls -->
                    <div class="sort-controls">
                        <div class="sort-group">
                            <label class="filter-label">Trier par</label>
                            <select id="sort_by" class="filter-select">
                                <option value="created_at">Date de création</option>
                                <option value="nom">Nom</option>
                                <option value="prenom">Prénom</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                        <div class="sort-group">
                            <label class="filter-label">Ordre</label>
                            <select id="sort_order" class="filter-select">
                                <option value="desc">Décroissant</option>
                                <option value="asc">Croissant</option>
                            </select>
                        </div>
                        <div>
                            <button onclick="applyFilters()" class="apply-btn">
                                Appliquer les filtres
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Summary -->
            <div class="results-summary">
                <div class="results-count" id="results-count">247 clients trouvés</div>
                <div class="per-page-control">
                    <label class="per-page-label">Éléments par page:</label>
                    <select id="per_page" class="per-page-select">
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <!-- Clients Table -->
            <div class="card">
                <div class="table-container">
                    <table class="clients-table">
                        <thead class="table-header">
                            <tr>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Abonnements</th>
                                <th>Créé le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-body" id="clients-tbody">
                            <tr>
                                <td>
                                    <div class="client-name">Marie Dubois</div>
                                </td>
                                <td class="client-email">marie.dubois@email.com</td>
                                <td>
                                    <span class="badge badge-particulier">Particulier</span>
                                </td>
                                <td>
                                    <span class="badge badge-active">Actif</span>
                                </td>
                                <td>
                                    <div class="subscription-list">
                                        <span class="subscription-tag subscription-premium">Premium</span>
                                    </div>
                                </td>
                                <td>15 Jan 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="client-name">Jean Martin</div>
                                </td>
                                <td class="client-email">jean.martin@entreprise.fr</td>
                                <td>
                                    <span class="badge badge-entreprise">Entreprise</span>
                                </td>
                                <td>
                                    <span class="badge badge-active">Actif</span>
                                </td>
                                <td>
                                    <div class="subscription-list">
                                        <span class="subscription-tag subscription-business">Business</span>
                                        <span class="subscription-tag subscription-standard">Standard</span>
                                    </div>
                                </td>
                                <td>12 Jan 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="client-name">Sophie Laurent</div>
                                </td>
                                <td class="client-email">sophie.laurent@gmail.com</td>
                                <td>
                                    <span class="badge badge-particulier">Particulier</span>
                                </td>
                                <td>
                                    <span class="badge badge-inactive">Inactif</span>
                                </td>
                                <td>
                                    <div class="subscription-list">
                                        <span class="subscription-tag subscription-none">Aucun</span>
                                    </div>
                                </td>
                                <td>08 Jan 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info">
                    Affichage de 1 à 15 sur 247 résultats
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" disabled>Précédent</button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <span class="pagination-ellipsis">...</span>
                    <button class="pagination-btn">17</button>
                    <button class="pagination-btn">Suivant</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-logo">
                Prestige<span class="accent">Concierge</span>
            </div>
            <p class="footer-text">© 2024 PrestigeConcierge - Service de Gestion Immobilière d'Exception</p>
        </div>
    </footer>

    <script>
        // Fonction pour appliquer les filtres
        function applyFilters() {
            const search = document.getElementById('search').value;
            const typeClient = document.getElementById('type_client').value;
            const actif = document.getElementById('actif').value;
            const sortBy = document.getElementById('sort_by').value;
            const sortOrder = document.getElementById('sort_order').value;
            const perPage = document.getElementById('per_page').value;

            // Construction des paramètres de requête
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (typeClient) params.append('type_client', typeClient);
            if (actif) params.append('actif', actif);
            if (sortBy) params.append('sort_by', sortBy);
            if (sortOrder) params.append('sort_order', sortOrder);
            if (perPage) params.append('per_page', perPage);

            console.log('Filtres appliqués:', {
                search,
                typeClient,
                actif,
                sortBy,
                sortOrder,
                perPage
            });

            // Ici vous feriez l'appel AJAX à votre endpoint
            // fetch(`/api/clients?${params.toString()}`)
            //     .then(response => response.json())
            //     .then(data => updateTable(data));
        }

        // Fonction pour mettre à jour le tableau
        function updateTable(data) {
            // Implémentation de la mise à jour du tableau avec les nouvelles données
            console.log('Données reçues:', data);
        }

        // Event listeners pour les filtres en temps réel
        document.getElementById('search').addEventListener('input', debounce(applyFilters, 500));
        document.getElementById('type_client').addEventListener('change', applyFilters);
        document.getElementById('actif').addEventListener('change', applyFilters);
        document.getElementById('per_page').addEventListener('change', applyFilters);

        // Fonction debounce pour optimiser les requêtes
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Fonction pour gérer la pagination
        function goToPage(page) {
            console.log('Navigation vers la page:', page);
            // Ici vous ajouteriez la logique pour charger les données de la page spécifique
            // fetch(`/api/clients?page=${page}&${getCurrentFilters()}`)
            //     .then(response => response.json())
            //     .then(data => updateTable(data));
        }

        // Fonction pour obtenir les filtres actuels
        function getCurrentFilters() {
            const search = document.getElementById('search').value;
            const typeClient = document.getElementById('type_client').value;
            const actif = document.getElementById('actif').value;
            const sortBy = document.getElementById('sort_by').value;
            const sortOrder = document.getElementById('sort_order').value;
            const perPage = document.getElementById('per_page').value;

            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (typeClient) params.append('type_client', typeClient);
            if (actif) params.append('actif', actif);
            if (sortBy) params.append('sort_by', sortBy);
            if (sortOrder) params.append('sort_order', sortOrder);
            if (perPage) params.append('per_page', perPage);

            return params.toString();
        }

        // Fonction pour mettre à jour l'affichage des résultats
        function updateResultsDisplay(totalResults, currentPage, perPage, totalPages) {
            const start = (currentPage - 1) * perPage + 1;
            const end = Math.min(currentPage * perPage, totalResults);
            
            document.getElementById('results-count').textContent = 
                `${totalResults} clients trouvés`;
            
            document.querySelector('.pagination-info').textContent = 
                `Affichage de ${start} à ${end} sur ${totalResults} résultats`;
        }

        // Fonction pour créer les éléments du tableau dynamiquement
        function renderTableRow(client) {
            const statusBadge = client.actif 
                ? '<span class="badge badge-active">Actif</span>'
                : '<span class="badge badge-inactive">Inactif</span>';

            const typeBadge = client.type_client === 'particulier' 
                ? '<span class="badge badge-particulier">Particulier</span>'
                : '<span class="badge badge-entreprise">Entreprise</span>';

            const subscriptions = client.abonnements && client.abonnements.length > 0 
                ? client.abonnements.map(sub => 
                    `<span class="subscription-tag subscription-${sub.plan.nom.toLowerCase()}">${sub.plan.nom}</span>`
                  ).join('')
                : '<span class="subscription-tag subscription-none">Aucun</span>';

            const createdDate = new Date(client.created_at).toLocaleDateString('fr-FR');

            return `
                <tr>
                    <td>
                        <div class="client-name">${client.prenom} ${client.nom}</div>
                    </td>
                    <td class="client-email">${client.email}</td>
                    <td>${typeBadge}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="subscription-list">
                            ${subscriptions}
                        </div>
                    </td>
                    <td>${createdDate}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn" onclick="viewClient(${client.id})" title="Voir le détail">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button class="action-btn" onclick="editClient(${client.id})" title="Modifier">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }

        // Fonctions d'action pour les clients
        function viewClient(clientId) {
            console.log('Voir le client:', clientId);
            // Redirection vers la page de détail du client
            // window.location.href = `/clients/${clientId}`;
        }

        function editClient(clientId) {
            console.log('Modifier le client:', clientId);
            // Redirection vers la page d'édition du client
            // window.location.href = `/clients/${clientId}/edit`;
        }

        // Fonction complète pour mettre à jour le tableau avec les nouvelles données
        function updateTable(data) {
            const tbody = document.getElementById('clients-tbody');
            
            if (data.data && data.data.data && data.data.data.length > 0) {
                // Construire les lignes du tableau
                const rows = data.data.data.map(client => renderTableRow(client)).join('');
                tbody.innerHTML = rows;
                
                // Mettre à jour les informations de pagination
                updateResultsDisplay(
                    data.data.total,
                    data.data.current_page,
                    data.data.per_page,
                    data.data.last_page
                );
                
                // Mettre à jour les contrôles de pagination
                updatePaginationControls(data.data);
            } else {
                // Aucun résultat trouvé
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--warm-taupe);">
                            <div>
                                <svg style="width: 48px; height: 48px; margin: 0 auto 16px; display: block; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 3.515A9.962 9.962 0 0012 3c-5.523 0-10 4.477-10 10a10.017 10.017 0 00.315 2.44"></path>
                                </svg>
                                <p><strong>Aucun client trouvé</strong></p>
                                <p>Essayez d'ajuster vos filtres de recherche</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Fonction pour mettre à jour les contrôles de pagination
        function updatePaginationControls(paginationData) {
            const controls = document.querySelector('.pagination-controls');
            let html = '';
            
            // Bouton Précédent
            const prevDisabled = paginationData.current_page === 1 ? 'disabled' : '';
            html += `<button class="pagination-btn" onclick="goToPage(${paginationData.current_page - 1})" ${prevDisabled}>Précédent</button>`;
            
            // Pages numériques
            const currentPage = paginationData.current_page;
            const lastPage = paginationData.last_page;
            
            // Logique pour afficher les numéros de page
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(lastPage, currentPage + 2);
            
            // Première page
            if (startPage > 1) {
                html += `<button class="pagination-btn" onclick="goToPage(1)">1</button>`;
                if (startPage > 2) {
                    html += `<span class="pagination-ellipsis">...</span>`;
                }
            }
            
            // Pages autour de la page courante
            for (let i = startPage; i <= endPage; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                html += `<button class="pagination-btn ${activeClass}" onclick="goToPage(${i})">${i}</button>`;
            }
            
            // Dernière page
            if (endPage < lastPage) {
                if (endPage < lastPage - 1) {
                    html += `<span class="pagination-ellipsis">...</span>`;
                }
                html += `<button class="pagination-btn" onclick="goToPage(${lastPage})">${lastPage}</button>`;
            }
            
            // Bouton Suivant
            const nextDisabled = currentPage === lastPage ? 'disabled' : '';
            html += `<button class="pagination-btn" onclick="goToPage(${currentPage + 1})" ${nextDisabled}>Suivant</button>`;
            
            controls.innerHTML = html;
        }

        // Initialisation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Charger les données initiales
            applyFilters();
            
            // Ajouter les event listeners pour le tri des colonnes
            addSortListeners();
        });

        // Fonction pour ajouter la fonctionnalité de tri sur les colonnes
        function addSortListeners() {
            const headers = document.querySelectorAll('.table-header th');
            const sortableColumns = {
                0: 'nom',
                1: 'email',
                2: 'type_client',
                3: 'actif',
                5: 'created_at'
            };

            headers.forEach((header, index) => {
                if (sortableColumns[index]) {
                    header.style.cursor = 'pointer';
                    header.addEventListener('click', function() {
                        const sortField = sortableColumns[index];
                        const currentSortBy = document.getElementById('sort_by').value;
                        const currentSortOrder = document.getElementById('sort_order').value;
                        
                        // Inverser l'ordre si on clique sur la même colonne
                        if (currentSortBy === sortField) {
                            document.getElementById('sort_order').value = currentSortOrder === 'asc' ? 'desc' : 'asc';
                        } else {
                            document.getElementById('sort_by').value = sortField;
                            document.getElementById('sort_order').value = 'asc';
                        }
                        
                        applyFilters();
                    });
                }
            });
        }
    </script>
</body>
</html>