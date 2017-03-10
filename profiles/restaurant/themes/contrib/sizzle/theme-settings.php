<?php
/**
 * @file
 * Theme settings.
 */

/**
 * Implements theme_settings().
 */
function sizzle_form_system_theme_settings_alter(&$form, &$form_state) {
  $theme_path = drupal_get_path('theme', 'sizzle');

  // Ensure this include file is loaded when the form is rebuilt from the cache.
  $form_state['build_info']['files']['form'] = $theme_path . '/theme-settings.php';

  // Hide all theme settings
  $form['theme_settings']['#access'] = FALSE;

  // Add theme settings here.
  $form['default_theme_settings'] = array(
    '#title' => t('Theme Settings'),
    '#type' => 'vertical_tabs',
  );

  $form['layout'] = array(
    '#type' => 'fieldset',
    '#title' => t('Layout'),
    '#collapsible' => TRUE,
    '#group' => 'default_theme_settings'
  );
  $form['layout']['site_width'] = array(
    '#title' => t('Width'),
    '#type' => 'radios',
    '#options' => array(
      'full' => t('Full width'),
      'boxed' => t('Boxed'),
    ),
    '#default_value' => theme_get_setting('site_width'),
  );
  // Site background image.
  $form['layout']['site_background_image'] = array(
    '#title' => t('Background image'),
    '#type' => 'managed_file',
    '#description' => t('The background image to use for the site.'),
    '#upload_location' => 'public://',
    '#theme' => 'restaurant_admin_thumbnail',
    '#default_value' => theme_get_setting('site_background_image'),
  );

  // Create a branding group and move logo and favicon to it.
  $form['branding'] = array(
    '#type' => 'fieldset',
    '#title' => t('Branding'),
    '#collapsible' => TRUE,
    '#group' => 'default_theme_settings'
  );
  $form['logo']['#group'] = 'branding';
  $form['favicon']['#group'] = 'branding';

  // Footer.
  $form['footer'] = array(
    '#type' => 'fieldset',
    '#title' => t('Footer'),
    '#collapsible' => TRUE,
    '#group' => 'default_theme_settings'
  );

  // Footer background image.
  $form['footer']['footer_background_image'] = array(
    '#title' => t('Background image'),
    '#type' => 'managed_file',
    '#description' => t('The background image to use for the site footer.'),
    '#upload_location' => 'public://',
    '#theme' => 'restaurant_admin_thumbnail',
    '#default_value' => theme_get_setting('footer_background_image'),
  );

  // Footer text.
  $footer_text = theme_get_setting('footer_text');
  $form['footer']['footer_text'] = array(
    '#title' => t('Footer text'),
    '#type' => 'text_format',
    '#format' => $footer_text['format'],
    '#default_value' => $footer_text['value'],
  );

  $form['footer']['show_footer_nav'] = array(
    '#title' => t('Show the footer nav?'),
    '#type' => 'checkbox',
    '#default_value' => theme_get_setting('show_footer_nav'),
  );

  // Copyright.
  $copyright = theme_get_setting('copyright');
  $form['footer']['copyright'] = array(
    '#title' => t('Copyright'),
    '#type' => 'text_format',
    '#format' => $copyright['format'],
    '#default_value' => $copyright['value'],
  );

  // Mobile.
  $form['mobile'] = array(
    '#type' => 'fieldset',
    '#title' => t('Mobile'),
    '#collapsible' => TRUE,
    '#group' => 'default_theme_settings'
  );

  $mobile_menu_links = theme_get_setting('mobile_menu_links');
  $form['mobile']['mobile_menu_links'] = array(
    '#title' => t('Additional navigation links'),
    '#description' => t('Select additional links to display for mobile navigation.'),
    '#type' => 'checkboxes',
    '#options' => array(
      'menu' => t('Menu link'),
      'reservation' => t('Reservation link'),
    ),
    '#default_value' => $mobile_menu_links,
  );

  // Add a custom submit handler.
  $form['#submit'][] = 'sizzle_form_variable_realm_variable_theme_form_submit';

  // Return the additional form widgets.
  return $form;
}

/**
 * Implement THEME_form_variable_realm_variable_theme_form_submit().
 */
function sizzle_form_variable_realm_variable_theme_form_submit($form, &$form_state) {
  // Load variable_realm.form.inc if available.
  if (module_exists('variable_realm')) {
    module_load_include('form.inc', 'variable_realm');
  }

  // Save images.
  $values = $form_state['values'];
  foreach ($values as $name => $value) {
    if (preg_match('/_image$/', $name)) {
      if (!empty($values[$name])) {
        $file = file_load($values[$name]);
        $file->status = FILE_STATUS_PERMANENT;
        file_save($file);
        file_usage_add($file, 'sizzle', 'theme', 1);
        variable_set($name, $file->fid);
      }
    }
  }
}
