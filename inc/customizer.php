<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_get_all_pages')) {
  function tokk_get_all_pages()
  {
    $data['0'] = __('&mdash; Select &mdash;', 'tokk');

    $the_query = new WP_Query([
      'post_type' => 'page',
      'posts_per_page' => -1,
      'suppress_filters' => false,
    ]);

    if ($the_query->have_posts()) {
      while ($the_query->have_posts()) {
        $the_query->the_post();
        $data[get_the_ID()] = get_the_title();
      }
    }

    wp_reset_postdata();

    return $data;
  }
}

if (!function_exists('tokk_customize_blog')) {
  function tokk_customize_blog($wp_customize)
  {
    $wp_customize->add_section('blog', [
      'title' => __('Blog', 'tokk'),
    ]);

    $wp_customize->add_setting('blog_description', [
      'default' => '',
      'type' => 'theme_mod',
    ]);

    $wp_customize->add_control(
      new WP_Customize_Control($wp_customize, 'blog_description', [
        'label' => __('Description', 'tokk'),
        'section' => 'blog',
        'type' => 'textarea',
      ]),
    );
  }
}

add_action('customize_register', 'tokk_customize_blog');

if (!function_exists('tokk_customize_404')) {
  function tokk_customize_404($wp_customize)
  {
    $wp_customize->add_section('page_not_found', [
      'title' => '404',
    ]);

    $wp_customize->add_setting('page_not_found_description', [
      'default' => '',
      'type' => 'theme_mod',
    ]);

    $wp_customize->add_control(
      new WP_Customize_Control($wp_customize, 'page_not_found_description', [
        'label' => __('Description', 'tokk'),
        'section' => 'page_not_found',
        'type' => 'textarea',
      ]),
    );
  }
}

add_action('customize_register', 'tokk_customize_404');

if (!function_exists('tokk_customize_newsletter')) {
  function tokk_customize_newsletter($wp_customize)
  {
    $wp_customize->add_section('newsletter', [
      'title' => __('Newsletter', 'tokk'),
    ]);

    $wp_customize->add_setting('newsletter_page', [
      'default' => '0',
      'type' => 'theme_mod',
    ]);

    $wp_customize->add_control(
      new WP_Customize_Control($wp_customize, 'newsletter_page', [
        'label' => __('Page', 'tokk'),
        'section' => 'newsletter',
        'type' => 'select',
        'choices' => tokk_get_all_pages(),
      ]),
    );
  }
}

add_action('customize_register', 'tokk_customize_newsletter');
