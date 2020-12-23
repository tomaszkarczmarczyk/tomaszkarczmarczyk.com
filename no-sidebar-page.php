<?php
/*
 * Template Name: No sidebar
 */
defined('ABSPATH') or exit();

$context = Timber::context();
$context['post'] = new Timber\Post();
Timber::render('pages/no-sidebar-page.twig', $context);
