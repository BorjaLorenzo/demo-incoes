<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus />
            </div>
            <!-- Surname -->
            <div class="mt-4">
                <x-label for="surname" :value="__('Surname')" />

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')"
                    required autofocus />
            </div>
            <!-- Telephone -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Phone')" />

                <x-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"
                    required autofocus />
            </div>
            <!-- Identification -->
            <div class="mt-4">
                <x-label for="identification" :value="__('Identification')" />

                {{-- <x-input id="identification" class="block mt-1 w-full" type="text" name="identification" :value="old('identification')"
                    required autofocus /> --}}
                    <select name="identification" id="identification" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                        <option value="" disabled selected>Select an option</option>
                        <option value="dni">DNI</option>
                        <option value="nie">NIE</option>
                        <option value="passport">PASSPORT</option>
                    </select>
            </div>

            <!-- DNI -->
            <div class="mt-4">
                <x-label for="dni" :value="__('Identification Number')" />

                <x-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')"
                    required autofocus />
            </div>
            <!-- Country -->
            <div class="mt-4">
                <x-label for="country" :value="__('Country')" />

                {{-- <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"
                    required autofocus /> --}}
                    <select name="country" id="country" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                        <option value="" disabled selected>Select an option</option>
                        <option value="spain">España</option>
                        <option value="germany">Alemania</option>
                        <option value="england">Inglaterra</option>
                    </select>
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-between mt-4">
                <a href="/" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Back') }}
                </a>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
