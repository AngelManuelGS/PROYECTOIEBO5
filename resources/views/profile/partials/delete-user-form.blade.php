<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>
        <!-- Título de la sección para eliminar la cuenta del usuario, con soporte para temas claro y oscuro -->

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
        <!-- Mensaje de advertencia que informa al usuario sobre las consecuencias de eliminar su cuenta -->
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>
    <!-- Botón de color rojo para iniciar el proceso de eliminación de cuenta. Utiliza Alpine.js para abrir el modal -->

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <!-- Modal para confirmar la eliminación de la cuenta. Se abre automáticamente si hay errores de validación -->

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')
            <!-- Formulario que envía una solicitud DELETE a la ruta 'profile.destroy' para eliminar la cuenta -->

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <!-- Título del modal que pide confirmación al usuario -->

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>
            <!-- Mensaje de advertencia dentro del modal, solicitando que se ingrese la contraseña como confirmación -->

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <!-- Etiqueta invisible para el campo de contraseña -->

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />
                <!-- Campo de entrada para la contraseña, que se usa para confirmar la eliminación -->

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                <!-- Muestra mensajes de error específicos si la validación del campo de contraseña falla -->
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <!-- Botón secundario que cierra el modal sin eliminar la cuenta -->

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
                <!-- Botón final para confirmar la eliminación de la cuenta -->
            </div>
        </form>
    </x-modal>
</section>
