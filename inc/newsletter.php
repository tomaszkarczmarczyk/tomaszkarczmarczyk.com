<?php defined('ABSPATH') or exit();

if (!function_exists('tokk_newsletter')) {
  function tokk_newsletter($email, $name)
  {
    if (!get_theme_mod('newsletter_api') || !get_theme_mod('newsletter_group')) {
      return false;
    }

    require get_template_directory() . '/mailerlite/vendor/autoload.php';
    $mailerliteClient = new \MailerLiteApi\MailerLite(get_theme_mod('newsletter_api'));
    $groupsApi = $mailerliteClient->groups();

    return $groupsApi->addSubscriber(get_theme_mod('newsletter_group'), [
      'email' => $email,
      'name' => $name,
    ]);
  }
}
