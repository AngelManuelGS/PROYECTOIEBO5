@props(['status'])  <!-- Define una propiedad llamada 'status' que se pasa como parámetro al componente -->

@if ($status)
    <!-- Si la variable 'status' tiene un valor, se muestra el siguiente bloque de código -->
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
        <!-- Muestra el mensaje de estado con estilos adicionales, y permite combinar clases personalizadas -->
        {{ $status }}
    </div>
@endif
