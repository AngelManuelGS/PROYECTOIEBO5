@props(['value'])  <!-- Define una propiedad llamada 'value', que se usa para el texto de la etiqueta -->

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    <!-- Muestra una etiqueta (<label>) que permite añadir clases adicionales a través de 'attributes' -->
    {{ $value ?? $slot }}
    <!-- Muestra el texto de la etiqueta:
         - Si se proporciona un valor para 'value', este se muestra.
         - Si no, se muestra el contenido del slot, que permite personalizar el texto cuando se usa el componente. -->
</label>
