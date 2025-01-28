<x-guest-layout>
    <!-- Sección de mensaje informativo -->
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        <!-- Mensaje informativo que le indica al usuario que esta es un área segura
             y que debe confirmar su contraseña para continuar -->
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <!-- Formulario para confirmar la contraseña -->
    <form method="POST" action="{{ route('password.confirm') }}">
        <!-- Token CSRF para proteger contra ataques de falsificación de solicitudes -->
        @csrf

        <!-- Campo de entrada de contraseña -->
        <div>
            <!-- Etiqueta para el campo de contraseña -->
            <x-input-label for="password" :value="__('Password')" />

            <!-- Campo de entrada para la contraseña, configurado para ocultar los caracteres ingresados -->
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <!-- Muestra errores de validación relacionados con la contraseña, si los hay -->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Botón de confirmación -->
        <div class="flex justify-end mt-4">
            <!-- Botón principal para enviar el formulario y confirmar la contraseña -->
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
