<?php defined('ABSPATH') or exit();

$context = Timber::context();
Timber::render('page.twig', $context);
