<?php defined('ABSPATH') or exit();

function logo_url()
{
  $custom_logo_id = get_theme_mod('custom_logo');
  $image = wp_get_attachment_image_src($custom_logo_id, 'full');
  return esc_url($image[0]);
}
