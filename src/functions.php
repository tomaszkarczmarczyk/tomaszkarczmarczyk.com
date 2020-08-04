<?php defined('ABSPATH') or exit();

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

Timber::$dirname = ['templates/components', 'templates/layouts', 'templates/macros', 'templates/pages'];

class Site extends Timber\Site
{
  private $theme_version = '';

  public function __construct()
  {
    $this->theme_version = wp_get_theme()->get('Version');
    add_action('init', [$this, 'menus']);
    add_action('after_setup_theme', [$this, 'theme_supports']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    add_action('login_enqueue_scripts', [$this, 'login_logo']);
    add_filter('timber/context', [$this, 'add_to_context']);
    add_filter('timber/twig', [$this, 'add_to_twig']);
    add_filter('body_class', [$this, 'body_class']);
    add_filter('login_headerurl', [$this, 'login_url']);
    parent::__construct();
  }

  public function menus()
  {
    register_nav_menu('primary', 'Main menu');
  }

  public function theme_supports()
  {
    global $content_width;

    if (!isset($content_width)) {
      $content_width = 700;
    }

    load_theme_textdomain('tk');

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
    add_theme_support('custom-header', ['header-text' => false]);
    add_theme_support('custom-logo');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('dark-editor-style');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-gradients');
  }

  public function add_to_context($context)
  {
    $context['menu'] = new Timber\Menu('primary');
    $context['site'] = $this;
    return $context;
  }

  public function add_to_twig($twig)
  {
    $twig->addFunction(new Timber\Twig_Function('wp_head', 'wp_head'));
    $twig->addFunction(new Timber\Twig_Function('wp_body_open', 'wp_body_open'));
    $twig->addFunction(new Timber\Twig_Function('wp_footer', 'wp_footer'));
    $twig->addFunction(new Timber\Twig_Function('logo_url', 'logo_url'));
    $twig->addFunction(new Timber\Twig_Function('get_permalink', 'get_permalink'));
    return $twig;
  }

  public function enqueue_styles()
  {
    wp_dequeue_style('wp-block-library');

    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', [], $this->theme_version);
  }

  public function enqueue_scripts()
  {
    wp_deregister_script('jquery');
  }

  public function body_class($classes)
  {
    $classes = ['body'];

    $include = [
      'body--chrome' => $GLOBALS['is_chrome'],
      'body--edge' => $GLOBALS['is_edge'],
      'body--gecko' => $GLOBALS['is_gecko'],
      'body--ie' => $GLOBALS['is_IE'],
      'body--iphone' => $GLOBALS['is_iphone'],
      'body--lynx' => $GLOBALS['is_lynx'],
      'body--mac-ie' => $GLOBALS['is_macIE'],
      'body--ns4' => $GLOBALS['is_NS4'],
      'body--opera' => $GLOBALS['is_opera'],
      'body--safari' => $GLOBALS['is_safari'],
      'body--win-ie' => $GLOBALS['is_winIE'],
      'body--archive' => is_archive(),
      'body--post-type-archive' => is_post_type_archive(),
      'body--category' => is_category(),
      'body--tag' => is_tag(),
      'body--tax' => is_tax(),
      'body--home' => is_front_page(),
      'body--blog' => is_home(),
      'body--privacy-policy' => is_privacy_policy(),
      'body--page' => is_page(),
      'body--paged' => is_paged(),
      'body--preview' => is_preview(),
      'body--search' => is_search(),
      'body--single' => is_single(),
      'body--singular' => is_singular(),
      'body--robots' => is_robots(),
      'body--embed' => is_embed(),
      'body--404' => is_404(),
      'body--mobile' => wp_is_mobile(),
      'body--desktop' => !wp_is_mobile(),
    ];

    foreach ($include as $class => $do_include) {
      if ($do_include) {
        $classes[$class] = $class;
      }
    }

    return $classes;
  }

  public function login_logo()
  {
    $logo = logo_url();

    echo "
    <style>
      .login h1 a {
        background-image: url($logo) !important;
        background-size: contain !important;
        width: 100% !important;
      }
    </style>
  ";
  }

  public function login_url($url)
  {
    return home_url();
  }
}

new Site();

require get_template_directory() . '/inc/helpers.php';
