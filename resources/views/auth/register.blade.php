<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Prénom -->
        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Nom -->
        <div class="mt-4">
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="mot_de_passe" :value="__('Mot de passe')" />

            <x-text-input id="mot_de_passe" class="block mt-1 w-full"
                            type="password"
                            name="mot_de_passe"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('mot_de_passe')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="mot_de_passe_confirmation" :value="__('Confirmer le mot de passe')" />

            <x-text-input id="mot_de_passe_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="mot_de_passe_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('mot_de_passe_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
