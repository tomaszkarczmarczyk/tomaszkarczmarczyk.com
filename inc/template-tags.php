<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_logo_url')) {
  function tokk_logo_url()
  {
    $custom_logo_id = get_theme_mod('custom_logo');
    $image = wp_get_attachment_image_src($custom_logo_id, 'full');

    return $image[0];
  }
}
