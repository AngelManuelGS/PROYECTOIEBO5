<x-guest-layout>
    <!-- Mensaje de confirmación de registro y solicitud de verificación de correo electrónico -->
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        <!-- Instrucción para que el usuario verifique su correo electrónico -->
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    <!-- Mensaje de estado cuando se ha enviado un nuevo enlace de verificación -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            <!-- Mensaje que confirma que se ha enviado un nuevo enlace de verificación al correo electrónico del usuario -->
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <!-- Opciones de reenviar correo de verificación y cerrar sesión -->
    <div class="mt-4 flex items-center justify-between">
        <!-- Formulario para reenviar el correo de verificación -->
        <form method="POST" action="{{ route('verification.send') }}">
            <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->
            @csrf

            <div>
                <!-- Botón para enviar la solicitud de reenvío del enlace de verificación -->
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Formulario para cerrar sesión -->
        <form method="POST" action="{{ route('logout') }}">
            <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->
            @csrf

            <!-- Botón de cierre de sesión -->
            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
