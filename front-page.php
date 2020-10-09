<?php defined('ABSPATH') or exit();

$context = Timber::context();
Timber::render('front-page.twig', $context);
