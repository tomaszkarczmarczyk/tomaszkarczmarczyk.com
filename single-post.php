<?php defined('ABSPATH') or exit();

$context = Timber::context();
$context['post'] = new Timber\Post();
$context['sidebar'] = Timber::get_sidebar('sidebar-single-post.php');
Timber::render('pages/single-post.twig', $context);
