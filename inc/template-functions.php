<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_body_classes')) {
  function tokk_body_classes($classes)
  {
    $classes = ['body'];

    if (is_front_page()) {
      $classes[] = 'body--is-front-page';
    }

    if (is_home()) {
      $classes[] = 'body--is-blog';
    }

    if (is_privacy_policy()) {
      $classes[] = 'body--is-privacy-policy';
    }

    if (is_page()) {
      $classes[] = 'body--is-page';
    }

    if (is_404()) {
      $classes[] = 'body--is-404';
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
