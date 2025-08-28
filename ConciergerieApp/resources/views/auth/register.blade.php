<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Inscription</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="{{ url('/') }}" class="text-2xl font-bold text-primary-600">
                {{ config('app.name', 'ConciergerieApp') }}
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Créer un compte</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                    <div class="text-sm text-red-600">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet
                    </label>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-300 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="username"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-300 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Rôle
                    </label>
                    <select id="role" 
                            name="role" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('role') border-red-300 @enderror">
                        <option value="">Sélectionner un rôle</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                            Administrateur - Accès complet au système
                        </option>
                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>
                            Manager - Gestion des équipes et supervision
                        </option>
                        <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>
                            Employé - Accès aux fonctions opérationnelles
                        </option>
                        <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>
                            Client - Accès aux services de conciergerie
                        </option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-300 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Minimum 8 caractères</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="flex items-center justify-between">
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('filament.admin.auth.login') }}">
                        Déjà inscrit ? Se connecter
                    </a>

                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        S'inscrire
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                En vous inscrivant, vous acceptez nos 
                <a href="#" class="text-primary-600 hover:text-primary-500">conditions d'utilisation</a> 
                et notre 
                <a href="#" class="text-primary-600 hover:text-primary-500">politique de confidentialité</a>.
            </p>
        </div>
    </div>

    <style>
        :root {
            --color-primary-50: #fffbeb;
            --color-primary-500: #f59e0b;
            --color-primary-600: #d97706;
            --color-primary-700: #b45309;
        }

        .text-primary-600 {
            color: var(--color-primary-600);
        }

        .text-primary-500 {
            color: var(--color-primary-500);
        }

        .bg-primary-600 {
            background-color: var(--color-primary-600);
        }

        .bg-primary-700 {
            background-color: var(--color-primary-700);
        }

        .hover\:bg-primary-700:hover {
            background-color: var(--color-primary-700);
        }

        .focus\:ring-primary-500:focus {
            --tw-ring-color: var(--color-primary-500);
        }

        .focus\:border-primary-500:focus {
            border-color: var(--color-primary-500);
        }

        .hover\:text-primary-500:hover {
            color: var(--color-primary-500);
        }

        .hover\:text-primary-900:hover {
            color: #1f2937;
        }
    </style>
</body>
</html>