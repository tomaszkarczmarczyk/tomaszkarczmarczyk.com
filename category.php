<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['term'] = new Timber\Term();
$context['posts_per_page'] = get_option('posts_per_page');
$context['sidebar'] = Timber::get_sidebar('sidebar-category.php');
Timber::render('pages/category.twig', $context);
