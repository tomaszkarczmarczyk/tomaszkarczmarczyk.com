<?php defined('ABSPATH') or exit();

add_filter('xmlrpc_enabled', '__return_false');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

Timber::$dirname = ['templates/components', 'templates/layouts', 'templates/pages'];

class Site extends Timber\Site
{
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'theme_supports']);
    add_filter('timber/context', [$this, 'add_to_context']);
    add_filter('timber/twig', [$this, 'add_to_twig']);
    parent::__construct();
  }

  public function theme_supports()
  {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', [
      'comment-list',
      'comment-form',
      'search-form',
      'gallery',
      'caption',
      'style',
      'script',
    ]);
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('post-formats', [
      'aside',
      'gallery',
      'link',
      'image',
      'quote',
      'status',
      'video',
      'audio',
      'chat',
    ]);
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('custom-logo');
  }

  public function add_to_context($context)
  {
    $context['menu'] = new Timber\Menu();
    $context['site'] = $this;
    return $context;
  }

  public function add_to_twig($twig)
  {
    $twig->addFunction(new Timber\Twig_Function('wp_head', 'wp_head'));
    $twig->addFunction(new Timber\Twig_Function('wp_body_open', 'wp_body_open'));
    $twig->addFunction(new Timber\Twig_Function('wp_footer', 'wp_footer'));
    return $twig;
  }
}

new Site();
