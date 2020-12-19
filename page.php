<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['post'] = new Timber\Post();
$context['sidebar'] = Timber::get_sidebar('sidebar-page.php');
Timber::render('pages/page.twig', $context);
