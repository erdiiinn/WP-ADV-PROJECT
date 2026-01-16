<?php
function wp_adv_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'wp_adv_theme_support');

function wp_adv_menus()
{
    $locations = [
        'primary' => 'Desktop Primary Left Sidebar',
        'footer'  => 'Footer Menu Items',
    ];
    register_nav_menus($locations);
}

add_action('init', 'wp_adv_menus');

function wp_adv_register_styles()
{
    wp_enqueue_style(
        'wp-adv-bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
        [],
        '5.0.2',
        'all'
    );
    wp_enqueue_style(
        'wp-adv-style',
        get_stylesheet_uri(),
        ['wp-adv-bootstrap'],
        '1.0',
        'all'
    );
    wp_enqueue_style(
        'wp-adv-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css',
        [],
        '7.0.1',
        'all'
    );
}

add_action('wp_enqueue_scripts', 'wp_adv_register_styles');

function wp_adv_register_scripts()
{
    wp_enqueue_script(
        'wp-adv-bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',
        ['jquery'],
        '5.0.2',
        true
    );
    wp_enqueue_script(
        'wp-adv-js',
        get_template_directory_uri() . '/assests/js/main.js',
        [],
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'wp_adv_register_scripts');

function wp_adv_nav_menu_li_class($classes, $item, $args, $depth)
{
    if (isset($args->menu_class) && strpos($args->menu_class, 'navbar-nav') !== false) {
        $classes[] = 'nav-item text-decoration-none';
        if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
            $classes[] = 'active';
        }
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'wp_adv_nav_menu_li_class', 10, 4);

function wp_adv_nav_menu_link_atts($atts, $item, $args, $depth)
{
    if (isset($args->menu_class) && strpos($args->menu_class, 'navbar-nav') !== false) {
        $existing      = isset($atts['class']) ? $atts['class'] . ' ' : '';
        $atts['class'] = trim($existing . 'nav-link');

        $title = strtolower(trim($item->title));
        if (strpos($title, 'contact') !== false || in_array('contact', $item->classes)) {
            $atts['class'] .= ' btn btn-primary';
        }
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'wp_adv_nav_menu_link_atts', 10, 4);

function wp_adv_nav_menu_item_title($title, $item, $args, $depth)
{
    if (isset($args->menu_class) && strpos($args->menu_class, 'navbar-nav') !== false) {
        $icon_class = '';
        foreach ($item->classes as $c) {
            if (strpos($c, 'fa-') === 0 || strpos($c, 'fab-') === 0 || strpos($c, 'fas-') === 0 || strpos($c, 'far-') === 0) {
                $icon_class = $c;
                break;
            }
        }

        if ($icon_class) {
            $title = '<i class="' . esc_attr($icon_class) . ' fa-fw mr-2"></i>' . $title;
        }
    }

    return $title;
}
add_filter('nav_menu_item_title', 'wp_adv_nav_menu_item_title', 10, 4);

function wp_adv_nav_menu_item_title($title, $item, $args, $depth){
    $icon_class = '';
    foreach($item->classes as $c){
        if(strpos($c, 'fa-') === 0 || strpos($c, 'fab-') === 0 || strpos($c, 'fas-') === 0 || strpos($c, 'far   -') === 0){
            $icon_class = $c;
            break;
        }
    }
    if ($icon_class){
        $title = '<i class"' . esc_attr($icon_class) . 'fa-fw mr-2"></i>' . $title;
    }
    return $title;
}

add_filter('nav_menu_item_title', 'wp_adv_nav_menu_item_title', 10, 4);

function wp_adv_widget_areas(){
    register_sidebar(
        [
        'name' => 'Sidebar Area',
        'id' => 'sidebar-1',
        'description' => 'Sidebar Widget Area'
        'before_widget' => '<div class="widget %2s mb-3">'
        'after_widget' => '</div>',
        'before_widget' => '<h3 class="widget-title mb-3">',
        'after_widget' => '</h3'
        ]
    );
}
add_action('widgets_init', 'wp_adv_widget_areas');