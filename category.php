<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['term'] = new Timber\Term();
$context['sidebar'] = Timber::get_sidebar('sidebar-category.php');
Timber::render('pages/category.twig', $context);
