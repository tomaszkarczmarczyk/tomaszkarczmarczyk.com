<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_setup')) {
  function tokk_setup()
  {
    load_theme_textdomain('tokk');

    register_nav_menus([
      'menu_1' => __('Primary', 'tokk'),
    ]);

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', [
      'comment-list',
      'comment-form',
      'search-form',
      'gallery',
      'caption',
      'style',
      'script',
    ]);
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('post-formats', [
      'aside',
      'gallery',
      'link',
      'image',
      'quote',
      'status',
      'video',
      'audio',
      'chat',
    ]);
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('custom-logo');
  }
}

add_action('after_setup_theme', 'tokk_setup');

if (!function_exists('tokk_content_width')) {
  function tokk_content_width()
  {
    $GLOBALS['content_width'] = apply_filters('tokk_content_width', 700);
  }
}

add_action('after_setup_theme', 'tokk_content_width', 0);

if (!function_exists('tokk_styles')) {
  function tokk_styles()
  {
    wp_dequeue_style('wp-block-library');

    wp_enqueue_style(
      'main',
      get_template_directory_uri() . '/assets/css/main.css',
      [],
      wp_get_theme()->get('Version'),
    );
  }
}

add_action('wp_enqueue_scripts', 'tokk_styles');

if (!function_exists('tokk_scripts')) {
  function tokk_scripts()
  {
    wp_deregister_script('jquery');
  }
}

add_action('wp_enqueue_scripts', 'tokk_scripts');

require get_template_directory() . '/classes/class-tokk-site.php';

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/gutenberg.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
