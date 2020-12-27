<?php
/*
 * Template Name: Confirm e-mail
 */
defined('ABSPATH') or exit();

$submit = isset($_POST['submit']) ? sanitize_text_field($_POST['submit']) : false;
$name = isset($_POST['newsletter_friend_name'])
  ? sanitize_text_field($_POST['newsletter_friend_name'])
  : false;
$email = isset($_POST['newsletter_friend_email'])
  ? sanitize_email($_POST['newsletter_friend_email'])
  : false;
$wpnonce = isset($_POST['_wpnonce']) ? wp_verify_nonce($_POST['_wpnonce'], 'send') : false;
$referer = wp_get_referer();

if ($submit && $wpnonce && $referer && $name && $email && tokk_newsletter($email, $name)):
  $context = Timber::context();
  $context['post'] = new Timber\Post();
  Timber::render('pages/confirm.twig', $context);
else:
  status_header(404);
  nocache_headers();
  get_template_part(404);
  exit();
endif;
