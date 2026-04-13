@extends("layout")

@section("content")
    <div class="space-y-16">
        <!-- Hero Section -->
        <div class="min-h-screen flex items-center justify-center py-12 px-4">
            <div class="max-w-2xl w-full space-y-8">
                <!-- Hero Header -->
                <div class="text-center space-y-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl">
                        <span class="text-5xl">📚</span>
                    </div>
                    
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold text-slate-900 mb-4">
                            BiblioJocs
                        </h1>
                        <p class="text-xl text-slate-600 max-w-xl mx-auto">
                            La teva plataforma per gestionar i organitzar la teva colència personal de videojuegos. 
                            Manté un registre detallat dels teus jocs, el seu estat i més.
                        </p>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-8">
                    <div class="bg-white rounded-lg p-6 border border-slate-200 hover:shadow-md transition">
                        <div class="text-3xl mb-3">🎮</div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Organitza els teus jocs</h3>
                        <p class="text-slate-600 text-sm">Manté un registre complet de tots els teus videojuegos amb detalls sobre plataforma, any de registre i preu.</p>
                    </div>

                    <div class="bg-white rounded-lg p-6 border border-slate-200 hover:shadow-md transition">
                        <div class="text-3xl mb-3">📊</div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Seguiment d'estat</h3>
                        <p class="text-slate-600 text-sm">Marca els teus jocs com jugant, pendents o completats. Visualitza estadístiques d'un sol cop d'ull.</p>
                    </div>

                    <div class="bg-white rounded-lg p-6 border border-slate-200 hover:shadow-md transition">
                        <div class="text-3xl mb-3">🏷️</div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Categoritzar</h3>
                        <p class="text-slate-600 text-sm">Crea categories personalitzades per organitzar els teus jocs per gènere, sèrie o qualsevol altra criteri.</p>
                    </div>

                    <div class="bg-white rounded-lg p-6 border border-slate-200 hover:shadow-md transition">
                        <div class="text-3xl mb-3">🔐</div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Accés segur</h3>
                        <p class="text-slate-600 text-sm">La teva colència és privada. Inicia sesió de forma segura per accedir a tota la teva informació.</p>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                    <a 
                        href="{{ route("login") }}" 
                        class="btn-primary px-8 py-4 text-lg"
                    >
                        Iniciar sesió
                    </a>
                    <a 
                        href="{{ route("register") }}" 
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-600 border-2 border-primary-600 rounded-lg hover:bg-primary-50 transition font-semibold text-lg"
                    >
                        Crear compte
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center py-12 border-t border-slate-200">
            <p class="text-slate-600 text-sm">
                Desenvolupat amb ❤️ amb Laravel i Tailwind CSS | Dades de <a href="https://rawg.io" target="_blank" class="text-primary-600 hover:text-primary-700 font-semibold">RAWG.io</a>
            </p>
        </div>
    </div>
@endsection
