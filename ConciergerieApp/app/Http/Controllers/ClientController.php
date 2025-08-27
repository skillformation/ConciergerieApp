<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    //Recuperation de la liste de clients (Query Builder)
    public function index(Request $request): JsonResponse
    {
        //Chargement des relations des abonnements du clients 
        //Pour chaque abonnement,chargement de sont plan.
        $query = Client::with(['abonnements.plan']);

        // Filtre par type de client
        //Vérifier si le paramétre existe et n'est pas vide
        if ($request->filled('type_client')) {
            $query->byType($request->type_client);
            //byType est un scope defini dans le modele Client
            //Filtre par particulier ,entreprise
        }

        //Fitre par statut actif convertit la valeur en booléen
        if ($request->filled('actif')) {
            $query->where('actif', $request->boolean('actif'));
        }

        //Filtre de recherche textuelle par nom,prenom,email(ex requete sql associé WHERE (nom LIKE '%toto%' OR prenom LIKE '%tata%' OR email LIKE '%tata.toto@gmail.com%')).
        if ($request->filled('search')) {
            $search = $request->search;
            //Création d'une sous-requete groupée.
            $query->where(function ($q) use ($search) {
                //recherche partielle %{$search}%
                $q->where('nom', 'like', "%{$search}%")
                  //OU logique entre champs
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Tri(Recupere la valeur created_at et tri du plus récent sur n'importe quel champs)
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination(diviser le resultat en page de 15 clients)
        $perPage = $request->get('per_page', 15);
        $clients = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $clients,
            'message' => 'Clients retrieved successfully'
        ]);
    }
}
