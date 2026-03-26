<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Carte principale -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold">
                        Bonjour {{ auth()->user()->name }}

                        {{-- Badge ADMIN --}}
                        @if(auth()->user()->role === 'admin')
                            <span class="ml-2 px-2 py-1 text-xs bg-blue-500 text-white rounded">
                                ADMIN
                            </span>
                        @endif
                    </h3>

                    <p class="mt-2 text-gray-600">
                        Bienvenue sur votre espace BiblioTek 📚
                    </p>

                </div>
            </div>

            <!-- Actions rapides -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Catalogue -->
                <div class="bg-white shadow rounded p-6">
                    <h4 class="font-bold mb-2">📚 Catalogue</h4>
                    <p class="text-gray-600 mb-3">
                        Consulter les livres disponibles
                    </p>
                    <a href="/" class="text-blue-500 hover:underline">
                        Accéder au catalogue →
                    </a>
                </div>

                <!-- Profil -->
                <div class="bg-white shadow rounded p-6">
                    <h4 class="font-bold mb-2">👤 Mon profil</h4>
                    <p class="text-gray-600 mb-3">
                        Voir mes emprunts et informations
                    </p>
                    <a href="/profil/{{ auth()->id() }}" class="text-blue-500 hover:underline">
                        Voir mon profil →
                    </a>
                </div>

                <!-- Scanner -->
                <div class="bg-white shadow rounded p-6">
                    <h4 class="font-bold mb-2">📱 Scanner</h4>
                    <p class="text-gray-600 mb-3">
                        Scanner un QR code pour emprunter
                    </p>
                    <a href="/bo/scanner" class="text-blue-500 hover:underline">
                        Ouvrir le scanner →
                    </a>
                </div>

                <!-- Admin uniquement -->
                @if(auth()->user()->role === 'admin')

                <div class="bg-white shadow rounded p-6">
                    <h4 class="font-bold mb-2">⚙️ Back-office</h4>
                    <p class="text-gray-600 mb-3">
                        Gérer les utilisateurs et statistiques
                    </p>
                    <a href="/bo/dashboard" class="text-blue-500 hover:underline">
                        Accéder à l'admin →
                    </a>
                </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>