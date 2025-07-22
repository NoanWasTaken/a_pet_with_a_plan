@extends('layouts.public')

@section('title', 'FAQ - A Pet with a Plan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Questions Fréquemment Posées
                </h1>
                <p class="text-gray-600 text-lg mb-8">
                    Trouvez rapidement les réponses à vos questions sur nos produits et services
                </p>
                
                <!-- Recherche -->
                <form method="GET" action="{{ route('faq.index') }}" class="max-w-md mx-auto">
                    <div class="relative flex">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Rechercher dans la FAQ..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <button type="submit" class="ml-2 right-2 top-2 bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                @if(request('search'))
                    <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-blue-800">
                            <strong>{{ $questions->count() }}</strong> résultat{{ $questions->count() > 1 ? 's' : '' }} 
                            pour "<em>{{ request('search') }}</em>"
                        </p>
                        <a href="{{ route('faq.index') }}" class="text-blue-600 hover:text-blue-700 underline">
                            Voir toutes les questions
                        </a>
                    </div>
                @endif

                @if($questions->count() > 0)
                    <!-- FAQ Accordion -->
                    <div class="space-y-4">
                        @foreach($questions as $index => $question)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <button class="faq-toggle w-full px-6 py-4 text-left focus:outline-none focus:ring-2 focus:ring-gray-500" 
                                        type="button" 
                                        data-target="faq-{{ $index }}">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800 pr-4">
                                            {{ $question->question }}
                                        </h3>
                                        <svg class="faq-icon w-5 h-5 text-gray-500 transform transition-transform duration-200" 
                                             fill="none" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>
                                <div id="faq-{{ $index }}" class="faq-content hidden px-6 pb-4">
                                    <div class="prose prose-gray max-w-none">
                                        {!! nl2br(e($question->reponse)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Aucun résultat -->
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">❓</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">
                            @if(request('search'))
                                Aucune question trouvée
                            @else
                                Aucune question disponible
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-6">
                            @if(request('search'))
                                Essayez d'autres mots-clés ou consultez toutes nos questions.
                            @else
                                Les questions fréquemment posées seront bientôt disponibles.
                            @endif
                        </p>
                        @if(request('search'))
                            <a href="{{ route('faq.index') }}" 
                               class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-300">
                                Voir toutes les questions
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Sections d'aide supplémentaires -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Besoin d'aide ?</h3>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Vous ne trouvez pas la réponse à votre question ? Notre équipe est là pour vous aider.
                        </p>
                        <a href="mailto:contact@apetwithaplan.com" 
                           class="inline-flex items-center text-gray-600 hover:text-gray-700 font-medium">
                            Nous contacter
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Guide -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Guides et conseils</h3>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Découvrez nos articles et guides pour prendre soin de vos animaux de compagnie.
                        </p>
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                            Voir le blog
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .prose {
        color: #374151;
        line-height: 1.75;
    }
    
    .prose p {
        margin-bottom: 1em;
    }
    
    .prose strong {
        font-weight: 600;
        color: #1f2937;
    }
    
    .prose ul, .prose ol {
        margin-top: 1em;
        margin-bottom: 1em;
        padding-left: 1.5em;
    }
    
    .prose li {
        margin-top: 0.25em;
        margin-bottom: 0.25em;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.faq-toggle');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const icon = this.querySelector('.faq-icon');
            
            if (content.classList.contains('hidden')) {
                // Fermer tous les autres FAQ
                document.querySelectorAll('.faq-content').forEach(item => {
                    if (item !== content) {
                        item.classList.add('hidden');
                    }
                });
                document.querySelectorAll('.faq-icon').forEach(item => {
                    if (item !== icon) {
                        item.classList.remove('rotate-180');
                    }
                });
                
                // Ouvrir celui-ci
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                // Fermer celui-ci
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        });
    });
});
</script>
@endpush
