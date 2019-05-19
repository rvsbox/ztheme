<?php

require_once 'Ztheme_Menu.php';


// подключение скриптов и стилей
// ======================================================================

function ztheme_scripts() {
    wp_enqueue_style('ztheme-bootstrapcss', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('ztheme-style', get_stylesheet_uri());

    wp_deregister_script('jquery'); // WP имеет в комплекте jquery, соответственно необходимо удалить базовую регистрацию jquery
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), false, true); // подключаем свой jquery

    wp_enqueue_script('ztheme-popper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), false, true); // jquery - установка зависимости
    wp_enqueue_script('ztheme-bootstrapjs', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), false, true);
}

add_action('wp_enqueue_scripts', 'ztheme_scripts');


// функция add_theme_support() для возможности добавления миниатюр в посты
// ======================================================================

function ztheme_setup() {
    add_theme_support('post-thumbnails');
    add_image_size('my-thumb', 100, 100);
    register_nav_menus(array( // в wp-admin появится Appearance - Menus
        'header_menu1' => 'Меню в шапке 1',
        'footer_menu2' => 'Меню в футере 2',
    ));
}

add_action('after_setup_theme', 'ztheme_setup');


// удаляет H2 из шаблона пагинации
// ======================================================================

add_filter('navigation_markup_template', 'my_navigation_template', 10, 2);
function my_navigation_template($template, $class) {
    return '
    <nav class="navigation" role="navigation">
        <div class="nav-links">%3$s</div>
    </nav>    
    ';
}

// выводим пагинацию
the_posts_pagination(array(
    'end_size' => 2,
));


// добавление sidebar. В админке WP будет добавлен раздел Appearance - Widgets
// ======================================================================

function ztheme_widgets_init() {
    register_sidebar( array(
       'name' => 'Сайдбар справа',
        'id' => 'right-sidebar',
        'description' => 'Область для виджетов в сайдбаре справа',
    ));
}

add_action('widgets_init', 'ztheme_widgets_init');