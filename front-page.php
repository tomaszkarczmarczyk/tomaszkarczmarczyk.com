<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['post'] = new Timber\Post();
$context['posts'] = Timber::get_posts(['posts_per_page' => 3]);
$context['sidebar'] = Timber::get_sidebar('sidebar-front-page.php');
Timber::render('pages/front-page.twig', $context);
