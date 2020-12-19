<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_body_classes')) {
  function tokk_body_classes($classes)
  {
    global $wp_query;
    $classes = ['body'];

    if (is_front_page()) {
      $classes[] = 'body--is-front-page';
    }

    if (is_home()) {
      $classes[] = 'body--is-blog';
    }

    if (is_category()) {
      $classes[] = 'body--is-category';
    }

    if (is_privacy_policy()) {
      $classes[] = 'body--is-privacy-policy';
    }

    if (is_singular()) {
      $classes[] = 'body--is-singular';
    }

    if (is_single()) {
      $post_id = $wp_query->get_queried_object_id();
      $post = $wp_query->get_queried_object();
      $post_type = $post->post_type;
      $classes[] = 'body--is-single-' . sanitize_html_class($post->post_type, $post_id);
    }

    if (is_page()) {
      $classes[] = 'body--is-page';
    }

    if (is_404()) {
      $classes[] = 'body--is-404';
    }

    if (wp_is_mobile()) {
      $classes[] = 'body--is-mobile';
    } else {
      $classes[] = 'body--is-desktop';
    }

    return $classes;
  }
}

add_filter('body_class', 'tokk_body_classes');

if (!function_exists('tokk_login_url')) {
  function tokk_login_url($url)
  {
    return home_url();
  }
}

add_filter('login_headerurl', 'tokk_login_url');
