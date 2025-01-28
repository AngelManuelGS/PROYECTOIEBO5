@props(['messages'])  <!-- Define una propiedad llamada 'messages' que se pasa al componente y contiene los mensajes a mostrar -->

@if ($messages)
    <!-- Comprueba si hay mensajes para mostrar -->
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        <!-- Si hay mensajes, crea una lista desordenada (<ul>) con clases para estilizar el texto en rojo,
             especialmente útil para mensajes de error. Las clases aplican estilos tanto para modo claro como oscuro. -->

        @foreach ((array) $messages as $message)
            <!-- Itera sobre cada mensaje en la propiedad 'messages', forzándolo a un array en caso de ser un solo mensaje -->
            <li>{{ $message }}</li>  <!-- Muestra cada mensaje como un elemento de lista (<li>) -->
        @endforeach
    </ul>
@endif
