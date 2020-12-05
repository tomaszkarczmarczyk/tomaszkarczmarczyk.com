<?php defined('ABSPATH') or exit();

add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('template_redirect', 'rest_output_link_header');
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');

if (!function_exists('tokk_disable_emojis_tinymce')) {
  function tokk_disable_emojis_tinymce($plugins)
  {
    if (is_array($plugins)) {
      return array_diff($plugins, ['wpemoji']);
    } else {
      return [];
    }
  }
}

if (!function_exists('tokk_disable_emojis_remove_dns_prefetch')) {
  function tokk_disable_emojis_remove_dns_prefetch($urls, $relation_type)
  {
    if ('dns-prefetch' === $relation_type) {
      $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
      $urls = array_diff($urls, [$emoji_svg_url]);
    }

    return $urls;
  }
}

if (!function_exists('tokk_disable_embeds_tiny_mce_plugin')) {
  function tokk_disable_embeds_tiny_mce_plugin($plugins)
  {
    return array_diff($plugins, ['wpembed']);
  }
}

if (!function_exists('tokk_disable_embeds_rewrites')) {
  function tokk_disable_embeds_rewrites($rules)
  {
    foreach ($rules as $rule => $rewrite) {
      if (strpos($rewrite, 'embed=true') !== false) {
        unset($rules[$rule]);
      }
    }
    return $rules;
  }
}

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

if (!function_exists('tokk_remove_image_sizes')) {
  function tokk_remove_image_sizes($sizes)
  {
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
  }
}

add_filter('intermediate_image_sizes_advanced', 'tokk_remove_image_sizes');

if (!function_exists('tokk_disable_embeds_code_init')) {
  function tokk_disable_embeds_code_init()
  {
    add_filter('tiny_mce_plugins', 'tokk_disable_embeds_tiny_mce_plugin');
    add_filter('rewrite_rules_array', 'tokk_disable_embeds_rewrites');
    add_filter('embed_oembed_discover', '__return_false');
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result');
    remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result');
  }
}

add_action('init', 'tokk_disable_embeds_code_init');

if (!function_exists('tokk_disable_emojis')) {
  function tokk_disable_emojis()
  {
    add_filter('tiny_mce_plugins', 'tokk_disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'tokk_disable_emojis_remove_dns_prefetch', 10, 2);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  }
}

add_action('init', 'tokk_disable_emojis');

if (!function_exists('tokk_disable_wp_rest_api')) {
  function tokk_disable_wp_rest_api($access)
  {
    if (!is_user_logged_in()) {
      $message = apply_filters(
        'disable_wp_rest_api_error',
        __('REST API nie jest dla Ciebie :-)', 'tokk'),
      );

      return new WP_Error('rest_login_required', $message, [
        'status' => rest_authorization_required_code(),
      ]);
    }

    return $access;
  }
}

add_filter('rest_authentication_errors', 'tokk_disable_wp_rest_api');

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
  }
}

add_action('wp_enqueue_scripts', 'tokk_scripts');

require get_template_directory() . '/classes/class-tokk-site.php';

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/gutenberg.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
