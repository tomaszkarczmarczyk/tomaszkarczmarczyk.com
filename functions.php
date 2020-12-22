<?php defined('ABSPATH') or exit();

add_filter('max_srcset_image_width', '__return_false');
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
remove_filter('term_description', 'wpautop');

if (!function_exists('tokk_setup')) {
  function tokk_setup()
  {
    load_theme_textdomain('tokk');

    register_nav_menus([
      'menu_1' => __('Primary', 'tokk'),
    ]);

    update_option('medium_large_size_w', 960);
    update_option('medium_large_size_h', 960);

    add_image_size('1600x1600', 1600, 1600);
    add_image_size('1920x1920', 1920, 1920);
    add_image_size('2240x2240', 2240, 2240);

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

    remove_image_size('1536x1536');
    remove_image_size('2048x2048');
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

if (!function_exists('tokk_custom_image_sizes')) {
  function tokk_custom_image_sizes($sizes)
  {
    return array_merge($sizes, [
      'medium_large' => __('Medium Large', 'tokk'),
      '1600x1600' => '1600x1600',
      '1920x1920' => '1920x1920',
      '2240x2240' => '2240x2240',
    ]);
  }
}

add_filter('image_size_names_choose', 'tokk_custom_image_sizes');

if (!function_exists('tokk_remove_image_sizes')) {
  function tokk_remove_image_sizes($sizes)
  {
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
  }
}

add_filter('intermediate_image_sizes_advanced', 'tokk_remove_image_sizes');

if (!function_exists('tokk_unregister_default_widgets')) {
  function tokk_unregister_default_widgets()
  {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_Media_Gallery');
    unregister_widget('WP_Widget_Media_Audio');
    unregister_widget('WP_Widget_Media_Image');
    unregister_widget('WP_Widget_Media_Video');
    unregister_widget('WP_Widget_Custom_HTML');
  }
}

add_action('widgets_init', 'tokk_unregister_default_widgets');

if (!function_exists('tokk_widgets_init')) {
  function tokk_widgets_init()
  {
    register_sidebar([
      'name' => __('Front Page', 'tokk'),
      'id' => 'sidebar-front-page',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);

    register_sidebar([
      'name' => __('Single Post', 'tokk'),
      'id' => 'sidebar-single-post',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);

    register_sidebar([
      'name' => __('Page', 'tokk'),
      'id' => 'sidebar-page',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);

    register_sidebar([
      'name' => __('Privacy Policy', 'tokk'),
      'id' => 'sidebar-privacy-policy',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);

    register_sidebar([
      'name' => __('Blog', 'tokk'),
      'id' => 'sidebar-blog',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);

    register_sidebar([
      'name' => __('Category', 'tokk'),
      'id' => 'sidebar-category',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);

    register_sidebar([
      'name' => '404',
      'id' => 'sidebar-404',
      'before_widget' => '<article class="widget">',
      'after_widget' => '</article>',
      'before_title' => '<h2 class="widget__title">',
      'after_title' => '</h2>',
    ]);
  }
}

add_action('widgets_init', 'tokk_widgets_init');

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

    wp_enqueue_script(
      'main',
      get_template_directory_uri() . '/assets/js/main.js',
      [],
      wp_get_theme()->get('Version'),
      true,
    );

    if (is_singular('post')) {
      wp_enqueue_script(
        'post',
        get_template_directory_uri() . '/assets/js/post.js',
        [],
        wp_get_theme()->get('Version'),
        true,
      );
    }
  }
}

add_action('wp_enqueue_scripts', 'tokk_scripts');

require get_template_directory() . '/classes/class-tokk-site.php';

require get_template_directory() . '/classes/widgets/class-tokk-email-me.php';
require get_template_directory() . '/classes/widgets/class-tokk-social-media.php';
require get_template_directory() . '/classes/widgets/class-tokk-newsletter.php';

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/gutenberg.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-shortcodes.php';
