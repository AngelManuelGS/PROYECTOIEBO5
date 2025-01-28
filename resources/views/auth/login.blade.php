<x-guest-layout>
    <div class="bg-customGreen p-6 rounded-md shadow-md max-w-md mx-auto text-white">

    <!-- Contenedor principal -->
        <!-- Encabezado -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold">Inicio de Sesión</h2>
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Correo Electrónico -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">Correo Electrónico</label>
                <input id="email" name="email" type="email" class="block w-full mt-1 p-2 rounded bg-gray-100 text-gray-900 focus:ring-2 focus:ring-[#B38E5D] focus:outline-none" required autofocus>
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white">Contraseña</label>
                <input id="password" name="password" type="password" class="block w-full mt-1 p-2 rounded bg-gray-100 text-gray-900 focus:ring-2 focus:ring-[#B38E5D] focus:outline-none" required>
            </div>

            <!-- Recuérdame -->
            <div class="mb-4 flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-[#B38E5D] focus:ring-2 focus:ring-[#B38E5D] rounded">
                <label for="remember_me" class="ms-2 text-sm text-white">Recuérdame</label>
            </div>

            <!-- Enlace y botón -->
            <div class="flex items-center justify-between">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-200 underline hover:text-[#B38E5D]">
                    ¿Olvidaste tu contraseña?
                </a>
                <button type="submit" class="!bg-[#B38E5D] text-white px-4 py-2 rounded shadow hover:!bg-[#a77b4d] focus:outline-none">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
