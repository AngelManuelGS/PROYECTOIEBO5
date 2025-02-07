<?php

return [
    // Configuración del título del panel administrativo
    'title' => 'Sales',
    'title_prefix' => '',
    'title_postfix' => '',

    // Configuración del favicon
    'use_ico_only' => false,
    'use_full_favicon' => false,

    // Configuración de fuentes de Google
    'google_fonts' => ['allowed' => true],

    // Configuración del logo del panel administrativo
    'logo' => '<b>IEBO</b>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.JPG',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_alt' => 'Admin Logo',

    // Configuración del logo de autenticación (opcional)
    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    // Configuración del preloader (carga animada)
    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    // Configuración del menú de usuario
    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    // Configuración del diseño (layout) del panel
    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    // Clases CSS aplicadas a diferentes elementos del panel
    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',

    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    // Configuración de la barra lateral (sidebar)
    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    // Configuración del menú del panel
    'menu' => [
        // Widgets superiores
        ['type' => 'fullscreen-widget', 'topnav_right' => true],

        // Opciones para clientes
        ['text' => 'Mis Pedidos', 'url' => '/pedidos', 'icon' => 'fas fa-fw fa-box', 'can' => 'is-client'],
        ['text' => 'Productos Disponibles', 'url' => '/productosVenta', 'icon' => 'fas fa-fw fa-store', 'can' => 'is-client'],
        ['text' => 'Mi Carrito', 'url' => '/carrito', 'icon' => 'fas fa-fw fa-shopping-cart', 'can' => 'is-client'],
        ['text' => 'Mi Perfil', 'url' => '/profile', 'icon' => 'fas fa-fw fa-user', 'can' => 'is-client'],
        // Opciones para administradores
        ['text' => 'Tablero', 'url' => 'dashboard', 'icon' => 'fas fa-fw fa-chart-pie', 'can' => 'is-admin'],
        [
            'text' => 'Administración',
            'icon' => 'fas fa-fw fa-list',
            'can' => 'is-admin',
            'submenu' => [
                ['text' => 'Usuarios', 'url' => '/usuarios'],
                //['text' => 'Plantel', 'url' => '/compania'],
            ],
        ],
        ['text' => 'Clientes', 'url' => 'clientes', 'icon' => 'fas fa-fw fa-users', 'can' => 'is-admin'],
        [
            'text' => 'Artículos',
            'icon' => 'fas fa-fw fa-list',
            'can' => 'is-admin',
            'submenu' => [
                ['text' => 'Categorias', 'url' => '/categorias'],
                ['text' => 'Libros', 'url' => '/productos'],
            ],
        ],
        [
            'text' => 'Ventas',
            'icon' => 'fas fa-fw fa-shopping-cart',
            'can' => 'is-admin',
            'submenu' => [
                ['text' => 'Nueva venta', 'url' => '/venta'],
                ['text' => 'Listar ventas', 'url' => '/venta/show'],
            ],
        ],
        ['text' => 'Mi Perfil', 'url' => '/profile', 'icon' => 'fas fa-fw fa-user', 'can' => 'is-admin'],
    ],

    // Filtros del menú para personalizar su comportamiento
    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    // Plugins utilizados en el panel
    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css'],
            ],
        ],
    ],

    // Configuración del modo IFrame
    'iframe' => [
        'default_tab' => ['url' => null, 'title' => null],
        'buttons' => [
            'close' => true, 'close_all' => true, 'close_all_other' => true,
            'scroll_left' => true, 'scroll_right' => true, 'fullscreen' => true,
        ],
        'options' => ['loading_screen' => 1000, 'auto_show_new_tab' => true, 'use_navbar_items' => true],
    ],

    // Configuración de Livewire (opcional)
    'livewire' => false,
];
