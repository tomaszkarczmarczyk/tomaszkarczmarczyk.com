<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['sidebar'] = Timber::get_sidebar('sidebar-404.php');
$context['description'] = get_theme_mod('page_not_found_description');
Timber::render('pages/404.twig', $context);
