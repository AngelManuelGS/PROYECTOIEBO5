<x-guest-layout>
    <!-- Formulario para registrarse en la aplicación -->
    <form method="POST" action="{{ route('register') }}">
        <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->
        @csrf

        <!-- Campo de nombre -->
        <div>
            <!-- Etiqueta para el campo de nombre -->
            <x-input-label for="name" :value="__('Name')" />

            <!-- Campo de entrada para el nombre. Toma el valor anterior si hubo un error, y el autocompletado está activado para "name" -->
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

            <!-- Muestra errores de validación relacionados con el nombre, si los hay -->
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Campo de correo electrónico -->
        <div class="mt-4">
            <!-- Etiqueta para el campo de correo electrónico -->
            <x-input-label for="email" :value="__('Email')" />

            <!-- Campo de entrada para el correo electrónico, configurado para autocompletar el "username" -->
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />

            <!-- Muestra errores de validación relacionados con el correo electrónico, si los hay -->
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Campo de contraseña -->
        <div class="mt-4">
            <!-- Etiqueta para el campo de contraseña -->
            <x-input-label for="password" :value="__('Password')" />

            <!-- Campo de entrada para la contraseña, configurado para ocultar los caracteres ingresados y autocompletar la "nueva contraseña" -->
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            <!-- Muestra errores de validación relacionados con la contraseña, si los hay -->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Campo para confirmar la contraseña -->
        <div class="mt-4">
            <!-- Etiqueta para el campo de confirmación de contraseña -->
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <!-- Campo de entrada para confirmar la contraseña -->
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <!-- Muestra errores de validación para la confirmación de la contraseña, si los hay -->
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Enlace a la página de inicio de sesión y botón de registro -->
        <div class="flex items-center justify-end mt-4">
            <!-- Enlace a la página de inicio de sesión si el usuario ya está registrado -->
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <!-- Botón principal para enviar el formulario y registrar al usuario -->
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
