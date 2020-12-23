<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_shortcode_email_me')) {
  function tokk_shortcode_email_me($atts)
  {
    $context = Timber::context();
    $context['title'] = isset($atts['title']) ? sanitize_text_field($atts['title']) : null;
    $context['text'] = isset($atts['text']) ? sanitize_text_field($atts['text']) : null;
    $context['email'] = isset($atts['email']) ? sanitize_email($atts['email']) : null;

    return Timber::compile('shortcodes/email-me.twig', $context);
  }
}

add_shortcode('email-me', 'tokk_shortcode_email_me');

if (!function_exists('tokk_shortcode_newsletter')) {
  function tokk_shortcode_newsletter($atts)
  {
    $context = Timber::context();
    $context['title'] = isset($atts['title']) ? sanitize_text_field($atts['title']) : null;
    $context['text'] = isset($atts['text']) ? sanitize_text_field($atts['text']) : null;
    $context['id'] = isset($atts['id']) ? sanitize_title($atts['id']) : 'shortcode';

    return Timber::compile('shortcodes/newsletter.twig', $context);
  }
}

add_shortcode('newsletter', 'tokk_shortcode_newsletter');
