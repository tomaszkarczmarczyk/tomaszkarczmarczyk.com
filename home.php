<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['post'] = new Timber\Post();
$context['posts'] = Timber::get_posts(['posts_per_page' => -1]);
$context['categories'] = Timber::get_terms([
  'taxonomy' => 'category',
  'hide_empty' => false,
]);
$context['sidebar'] = Timber::get_sidebar('sidebar-blog.php');
Timber::render('pages/blog.twig', $context);
