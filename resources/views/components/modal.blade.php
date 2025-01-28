@props([
    'name',         // Nombre único del modal, usado para identificarlo cuando se abre desde otro script
    'show' => false, // Controla si el modal se muestra por defecto
    'maxWidth' => '2xl' // Controla el ancho máximo del modal, con un valor por defecto de '2xl'
])

@php
// Configura la clase de ancho máximo en función de la propiedad 'maxWidth'
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="{
        show: @js($show), // Controla si el modal está visible
        focusables() {
            // Encuentra todos los elementos que pueden recibir enfoque dentro del modal
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                .filter(el => ! el.hasAttribute('disabled')) // Filtra solo los elementos que no están deshabilitados
        },
        firstFocusable() { return this.focusables()[0] }, // Primer elemento con enfoque
        lastFocusable() { return this.focusables().slice(-1)[0] }, // Último elemento con enfoque
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden'); // Evita el desplazamiento en la página cuando el modal está abierto
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }} // Enfoca el primer elemento si es necesario
        } else {
            document.body.classList.remove('overflow-y-hidden'); // Permite el desplazamiento al cerrar el modal
        }
    })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null" // Abre el modal al recibir un evento
    x-on:close.stop="show = false" // Cierra el modal
    x-on:keydown.escape.window="show = false" // Cierra el modal al presionar Escape
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()" // Mueve el enfoque al siguiente elemento
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" // Mueve el enfoque al elemento anterior
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" // Posición y estilo del modal
    style="display: {{ $show ? 'block' : 'none' }};" // Controla la visibilidad inicial
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false" // Cierra el modal al hacer clic fuera del contenido
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div> <!-- Fondo oscuro detrás del modal -->
    </div>

    <div
        x-show="show"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        {{ $slot }} <!-- Contenido del modal -->
    </div>
</div>
