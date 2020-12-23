<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['post'] = new Timber\Post();
$context['posts'] = Timber::get_posts(['posts_per_page' => get_option('posts_per_page')]);
$context['sidebar'] = Timber::get_sidebar('sidebar-front-page.php');
Timber::render('pages/front-page.twig', $context);
