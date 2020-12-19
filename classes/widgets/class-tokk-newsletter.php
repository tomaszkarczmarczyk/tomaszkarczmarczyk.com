<?php defined('ABSPATH') or exit();

class Tokk_Newsletter extends WP_Widget
{
  public function __construct()
  {
    parent::__construct('tokk-widget-newsletter', __('Newsletter', 'tokk'));

    add_action('widgets_init', function () {
      register_widget('Tokk_Newsletter');
    });
  }

  public function widget($args, $instance)
  {
    if (!class_exists('Timber')) {
      return;
    }

    $context = Timber::context();
    $context['args'] = array_merge($args, [
      'before_widget' => '<article class="widget newsletter">',
    ]);
    $context['instance'] = $instance;
    Timber::render('widgets/newsletter.twig', $context);
  }

  public function form($instance)
  {
    $title = !empty($instance['title']) ? $instance['title'] : '';
    $text = !empty($instance['text']) ? $instance['text'] : '';

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

    echo '<p>' .
      '<label for="' .
      esc_attr($this->get_field_id('text')) .
      '">' .
      esc_html__('Text:', 'tokk') .
      '</label>' .
      '<textarea class="widefat" id="' .
      esc_attr($this->get_field_id('text')) .
      '" name="' .
      esc_attr($this->get_field_name('text')) .
      '">' .
      esc_html($text) .
      '</textarea>' .
      '</p>';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = [];
    $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : null;
    $instance['text'] = !empty($new_instance['text']) ? $new_instance['text'] : null;

    return $instance;
  }
}

new Tokk_Newsletter();
