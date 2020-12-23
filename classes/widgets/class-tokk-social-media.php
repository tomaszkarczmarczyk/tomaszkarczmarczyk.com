<?php defined('ABSPATH') or exit();

class Tokk_Social_Media extends WP_Widget
{
  public function __construct()
  {
    parent::__construct('tokk-social-media-widget', __('Social Media', 'tokk'));
  }

  public function widget($args, $instance)
  {
    if (!class_exists('Timber')) {
      return;
    }

    $context = Timber::context();
    $context['args'] = array_merge($args, [
      'before_widget' => '<article class="widget social-media social-media--is-primary">',
    ]);
    $context['instance'] = $instance;
    Timber::render('widgets/social-media.twig', $context);
  }

  public function form($instance)
  {
    $title = !empty($instance['title']) ? $instance['title'] : '';

    echo '<p>' .
      '<label for="' .
      esc_attr($this->get_field_id('title')) .
      '">' .
      esc_html__('Title:', 'tokk') .
      '</label>' .
      '<input class="widefat" id="' .
      esc_attr($this->get_field_id('title')) .
      '" name="' .
      esc_attr($this->get_field_name('title')) .
      '" type="text" value="' .
      esc_attr($title) .
      '"' .
      '/>' .
      '</p>';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = [];
    $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : null;

    return $instance;
  }
}

function tokk_register_social_media_widget()
{
  register_widget('Tokk_Social_Media');
}

add_action('widgets_init', 'tokk_register_social_media_widget');
