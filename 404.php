<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['sidebar'] = Timber::get_sidebar('sidebar-404.php');
Timber::render('pages/404.twig', $context);
