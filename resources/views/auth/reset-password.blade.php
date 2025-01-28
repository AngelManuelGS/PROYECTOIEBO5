<x-guest-layout>
    <!-- Formulario para restablecer la contraseña -->
    <form method="POST" action="{{ route('password.store') }}">
        <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->
        @csrf

        <!-- Token de restablecimiento de contraseña -->
        <!-- Campo oculto que contiene el token de restablecimiento, necesario para la validación del enlace -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Campo de correo electrónico -->
        <div>
            <!-- Etiqueta para el campo de correo electrónico -->
            <x-input-label for="email" :value="__('Email')" />

            <!-- Campo de entrada para el correo electrónico, configurado para autocompletar el "username".
                 Se llena automáticamente con el email anterior en caso de error, o el email del enlace de restablecimiento -->
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />

            <!-- Muestra errores de validación relacionados con el correo electrónico, si los hay -->
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Campo de nueva contraseña -->
        <div class="mt-4">
            <!-- Etiqueta para el campo de contraseña -->
            <x-input-label for="password" :value="__('Password')" />

            <!-- Campo de entrada para la nueva contraseña, configurado para ocultar los caracteres ingresados -->
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <!-- Muestra errores de validación relacionados con la contraseña, si los hay -->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Campo para confirmar la nueva contraseña -->
        <div class="mt-4">
            <!-- Etiqueta para el campo de confirmación de contraseña -->
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <!-- Campo de entrada para confirmar la nueva contraseña -->
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <!-- Muestra errores de validación para la confirmación de la contraseña, si los hay -->
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botón de restablecimiento de contraseña -->
        <div class="flex items-center justify-end mt-4">
            <!-- Botón principal que envía el formulario para actualizar la contraseña -->
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
