<x-guest-layout>
    <!-- Sección de mensaje informativo -->
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        <!-- Mensaje informativo que le indica al usuario que puede recuperar su contraseña.
             Explica que debe proporcionar su correo electrónico para recibir un enlace de restablecimiento -->
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Estado de sesión para mostrar mensajes de éxito o estado, si los hay -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulario para solicitar un enlace de restablecimiento de contraseña -->
    <form method="POST" action="{{ route('password.email') }}">
        <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->
        @csrf

        <!-- Campo para ingresar la dirección de correo electrónico -->
        <div>
            <!-- Etiqueta para el campo de correo electrónico -->
            <x-input-label for="email" :value="__('Email')" />

            <!-- Campo de entrada para el correo electrónico, configurado para requerir un email y con
                 el valor previo ingresado en caso de que hubiera un error -->
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />

            <!-- Muestra errores de validación relacionados con el campo de correo electrónico, si los hay -->
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Botón para enviar el formulario -->
        <div class="flex items-center justify-end mt-4">
            <!-- Botón principal que envía la solicitud para enviar el enlace de restablecimiento de contraseña -->
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
