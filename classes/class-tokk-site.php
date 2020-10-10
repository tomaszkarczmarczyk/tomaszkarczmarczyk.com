<?php defined('ABSPATH') or exit();

if (!class_exists('Tokk_Site')) {
  class Tokk_Site extends Timber\Site
  {
    public function __construct()
    {
      add_filter('timber/context', [$this, 'add_to_context']);
      add_filter('timber/twig', [$this, 'add_to_twig']);

      parent::__construct();
    }

    public function add_to_context($context)
    {
      $context['menu_1'] = new Timber\Menu('menu_1');
      $context['site'] = $this;

      return $context;
    }

    public function add_to_twig($twig)
    {
      $twig->addFunction(new Timber\Twig_Function('wp_head', 'wp_head'));
      $twig->addFunction(new Timber\Twig_Function('wp_body_open', 'wp_body_open'));
      $twig->addFunction(new Timber\Twig_Function('wp_footer', 'wp_footer'));
      $twig->addFunction(new Timber\Twig_Function('get_permalink', 'get_permalink'));
      $twig->addFunction(new Timber\Twig_Function('tokk_logo_url', 'tokk_logo_url'));

      return $twig;
    }
  }
}

new Tokk_Site();
