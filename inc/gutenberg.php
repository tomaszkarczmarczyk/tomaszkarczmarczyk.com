<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_font_sizes')) {
  function tokk_font_sizes()
  {
    return [
      [
        'name' => '3xS',
        'size' => 4,
        'slug' => 'xxx-small',
      ],
      [
        'name' => '2xS',
        'size' => 8,
        'slug' => 'xx-small',
      ],
      [
        'name' => '1xS',
        'size' => 12,
        'slug' => 'x-small',
      ],
      [
        'name' => 'S',
        'size' => 16,
        'slug' => 'small',
      ],
      [
        'name' => 'M',
        'size' => 20,
        'slug' => 'medium',
      ],
      [
        'name' => 'L',
        'size' => 24,
        'slug' => 'large',
      ],
      [
        'name' => '1xL',
        'size' => 28,
        'slug' => 'x-large',
      ],
      [
        'name' => '2xL',
        'size' => 32,
        'slug' => 'xx-large',
      ],
      [
        'name' => '3xL',
        'size' => 36,
        'slug' => 'xxx-large',
      ],
    ];
  }
}

if (!function_exists('tokk_color_palette')) {
  function tokk_color_palette()
  {
    return [
      [
        'name' => __('Black', 'tokk'),
        'slug' => 'black',
        'color' => 'hsl(0, 0%, 0%)',
      ],
      [
        'name' => __('White', 'tokk'),
        'slug' => 'white',
        'color' => 'hsl(0, 0%, 100%)',
      ],
      [
        'name' => __('Primary', 'tokk'),
        'slug' => 'primary',
        'color' => 'hsl(220, 100%, 50%)',
      ],
      [
        'name' => __('Danger', 'tokk'),
        'slug' => 'danger',
        'color' => 'hsl(0, 75%, 50%)',
      ],
      [
        'name' => __('Warning', 'tokk'),
        'slug' => 'warning',
        'color' => 'hsl(50, 90%, 50%)',
      ],
      [
        'name' => __('Gray 100', 'tokk'),
        'slug' => 'gray-100',
        'color' => 'hsl(0, 0%, 97%)',
      ],
      [
        'name' => __('Gray 200', 'tokk'),
        'slug' => 'gray-200',
        'color' => 'hsl(0, 0%, 87%)',
      ],
      [
        'name' => __('Gray 300', 'tokk'),
        'slug' => 'gray-300',
        'color' => 'hsl(0, 0%, 77%)',
      ],
    ];
  }
}

if (!function_exists('tokk_gutenberg_setup')) {
  function tokk_gutenberg_setup()
  {
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-gradients');
    add_theme_support('editor-gradient-presets');
    add_theme_support('editor-font-sizes', tokk_font_sizes());
    add_theme_support('editor-color-palette', tokk_color_palette());
    add_theme_support('editor-styles');

    remove_theme_support('core-block-patterns');

    add_editor_style('./assets/css/gutenberg.css');
  }
}

add_action('after_setup_theme', 'tokk_gutenberg_setup');

if (!function_exists('tokk_allowed_block_types')) {
  function tokk_allowed_block_types($allowed_block_types)
  {
    return [
      'core/paragraph',
      'core/image',
      'core/heading',
      'core/list',
      'core/quote',
      'core/shortcode',
      'core/code',
      'core/columns',
      'core/html',
      'core/preformatted',
      'core/separator',
      'core/spacer',
    ];
  }
}

add_filter('allowed_block_types', 'tokk_allowed_block_types');

if (!function_exists('tokk_gutenberg_enqueue_scripts')) {
  function tokk_gutenberg_enqueue_scripts()
  {
    wp_enqueue_script(
      'gutenberg',
      get_template_directory_uri() . '/assets/js/gutenberg.js',
      ['wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'wp-rich-text'],
      wp_get_theme()->get('Version'),
    );
  }
}

add_action('enqueue_block_editor_assets', 'tokk_gutenberg_enqueue_scripts');

if (!function_exists('tokk_sanitize_image')) {
  function tokk_sanitize_image($content)
  {
    preg_match_all('/srcset="(.*?)"/i', $content, $test);

    // <source></source>

    // return preg_replace(
    //   '/(<img(.*?)\/>)/i',
    //   '<picture><source srcset="' . $test[1][0] . '"/>$1</picture>',
    //   $content,
    // );

    // echo '<pre>' . print_r(str_replace('.jpg', '.jpg.webp', $test[1])) . '</pre>';
    // echo '<pre>' . print_r($test) . '</pre>';

    return preg_replace('/wp-image-(\d+)/i', 'content__image content__image--is-$1', $content);
  }
}

add_action('tokk_content_sanitize', 'tokk_sanitize_image');

if (!function_exists('tokk_block_custom_classes')) {
  function tokk_block_custom_classes($content, $block)
  {
    $prefix = preg_replace('/\w+\/(\w+)/', 'content__$1', $block['blockName']);

    if ($block['blockName'] === 'core/heading') {
      $lvl = isset($block['attrs']['level']) ? $block['attrs']['level'] : 2;

      $lvls = [
        1 => 'special',
        2 => 'primary',
        3 => 'secondary',
        4 => 'tertiary',
        5 => 'tertiary',
        6 => 'tertiary',
      ];

      $content = str_replace('wp-block-heading', "$prefix $prefix--is-$lvls[$lvl]", $content);
    }

    if ($block['blockName'] === 'core/paragraph') {
      $content = str_replace(
        ['wp-block-paragraph', 'has-drop-cap'],
        [$prefix, "$prefix--is-drop-cap"],
        $content,
      );
    }

    if ($block['blockName'] === 'core/image') {
      $content = preg_replace(
        '/<div\s+class="(.*?)"><figure\s+class="(.*?)">(.*?)<\/figure><\/div>/i',
        '<figure class="$1 $2">$3</figure>',
        $content,
      );

      $content = str_replace(
        [
          'wp-block-image',
          'size-thumbnail',
          'size-medium_large',
          'size-medium',
          'size-large',
          'size-full',
          'is-resized',
          'size-1600x1600',
          'size-1920x1920',
          'size-2240x2240',
          'is-style-default',
          'alignleft',
          'aligncenter',
          'alignright',
        ],
        [
          "$prefix-wrapper",
          "$prefix-wrapper--is-thumbnail",
          "$prefix-wrapper--is-medium-large",
          "$prefix-wrapper--is-medium",
          "$prefix-wrapper--is-large",
          "$prefix-wrapper--is-full",
          "$prefix-wrapper--is-resized",
          "$prefix-wrapper--is-1600",
          "$prefix-wrapper--is-1920",
          "$prefix-wrapper--is-2240",
          "$prefix-wrapper--is-style-default",
          "$prefix-wrapper--is-align-left",
          "$prefix-wrapper--is-align-center",
          "$prefix-wrapper--is-align-right",
        ],
        $content,
      );
    }

    if ($block['blockName'] === 'core/list') {
      $type = isset($block['attrs']['ordered']) ? "$prefix--is-ordered" : "$prefix--is-unordered";

      $content = str_replace(
        ['wp-block-list', '<li>', '<ul>', '<ol>'],
        [
          "$prefix $type",
          "<li class=\"$prefix-item\">",
          "<ul class=\"$prefix $prefix--is-unordered\">",
          "<ol class=\"$prefix $prefix--is-ordered\">",
        ],
        $content,
      );
    }

    if ($block['blockName'] === 'core/quote') {
      $content = str_replace(
        ['wp-block-quote', 'is-style-default', 'is-style-warning'],
        [$prefix, "$prefix--is-style-default", "$prefix--is-style-warning"],
        $content,
      );
    }

    if ($block['blockName'] === 'core/code') {
      $content = str_replace('wp-block-code', "$prefix-wrapper", $content);
    }

    if ($block['blockName'] === 'core/columns') {
      $content = str_replace(
        [
          'wp-block-columns',
          'wp-block-column',
          'are-vertically-aligned-top',
          'are-vertically-aligned-center',
          'are-vertically-aligned-bottom',
          'is-vertically-aligned-top',
          'is-vertically-aligned-center',
          'is-vertically-aligned-bottom',
        ],
        [
          $prefix,
          'content__column',
          "$prefix--is-vertically-align-top",
          "$prefix--is-vertically-align-center",
          "$prefix--is-vertically-align-bottom",
          'content__column--is-vertically-align-top',
          'content__column--is-vertically-align-center',
          'content__column--is-vertically-align-bottom',
        ],
        $content,
      );
    }

    if ($block['blockName'] === 'core/preformatted') {
      $content = str_replace('wp-block-preformatted', $prefix, $content);
    }

    if ($block['blockName'] === 'core/separator') {
      $content = str_replace(
        ['wp-block-separator', 'is-style-default'],
        [$prefix, "$prefix--is-style-default"],
        $content,
      );
    }

    if ($block['blockName'] === 'core/spacer') {
      $content = str_replace('wp-block-spacer', $prefix, $content);
    }

    if ($block['blockName'] === 'core/shortcode') {
      $content = preg_replace('/<p(.*?)*>(.*?)<\/p>/i', '$2', $content);
    }

    $font_slugs_before = [];
    $font_slugs_after = [];
    $text_color_before = [];
    $text_color_after = [];
    $background_color_before = [];
    $background_color_after = [];
    $font_sizes = tokk_font_sizes();
    $color_palette = tokk_color_palette();

    foreach ($font_sizes as $value) {
      $font_slugs_before[] = "has-$value[slug]-font-size";
      $font_slugs_after[] = "content__custom-font-size content__custom-font-size--is-$value[slug]";
    }

    foreach ($color_palette as $value) {
      $text_color_before[] = "has-$value[slug]-color";
      $background_color_before[] = "has-$value[slug]-background-color";
      $text_color_after[] = "content__custom-text-color--is-$value[slug]";
      $background_color_after[] = "content__custom-background-color--is-$value[slug]";
    }

    $content = preg_replace(
      '/<a\s+(.*?)\s*>/i',
      '<a class="content__link" aria-label="More" $1>',
      $content,
    );

    return empty($prefix)
      ? $content
      : str_replace(
        [
          'has-text-color',
          ...$text_color_before,
          'has-background',
          ...$background_color_before,
          'has-text-align-left',
          'has-text-align-right',
          'has-text-align-center',
          ...$font_slugs_before,
          'has-inline-color',
          '<code>',
          '<s>',
          '<strong>',
          '<em>',
          '<sub>',
          '<sup>',
          '<p>',
          '<figcaption>',
          '<cite>',
        ],
        [
          'content__custom-text-color',
          ...$text_color_after,
          'content__custom-background-color',
          ...$background_color_after,
          'content__text-align content__text-align--is-left',
          'content__text-align content__text-align--is-right',
          'content__text-align content__text-align--is-center',
          ...$font_slugs_after,
          'content__custom-text-color',
          '<code class="content__code">',
          '<s class="content__strikethrough">',
          '<strong class="content__strong">',
          '<em class="content__emphasis">',
          '<sub class="content__subscript">',
          '<sup class="content__superscript">',
          '<p class="content__paragraph">',
          '<figcaption class="content__caption">',
          '<cite class="content__cite">',
        ],
        $content,
      );
  }
}

add_filter('render_block', 'tokk_block_custom_classes', 10, 2);
