<!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <?php
        $title = get_bloginfo( 'name' );
        if (get_bloginfo( 'description' )) {
            $title .= ' - ' . get_bloginfo( 'description' );
        }
        ?>
        <title><?php echo esc_html($title); ?></title>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <?php 
        if (!is_admin()) { 
            $desc = PalleonSettings::get_option('fe_desc','');
            $keywords = PalleonSettings::get_option('fe_keywords','');
            if (!empty($desc)) {
                echo '<meta name="description" content="' . esc_attr($desc) . '">';
            }
            if (!empty($keywords)) {
                echo '<meta name="keywords" content="' . esc_attr($keywords) . '">';
            }
        } ?>
        <?php do_action('palleon_head'); ?>
		<script>
  document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const templateId = urlParams.get('template_id');

    if (templateId !== null) {
      const button = document.getElementById('palleon-btn-templates');
      if (button) {
        button.style.display = 'none';
      }
    }
  });
</script>
    </head>
    <?php
    $bodyClasses = '';
    $default_theme = PalleonSettings::get_option('default_theme','dark');
    $custom_theme = Palleon::get_user_option('custom-theme', get_current_user_id(), $default_theme);
    if (is_user_logged_in()) {
        $bodyClasses .= 'backend ';
    } else {
        $bodyClasses .= 'frontend ';
    }
    if (isset($_GET['attachment_id']) && !empty($_GET['attachment_id'])) {
        $bodyClasses .= 'edit_attachment ';
    }
    $bodyClasses .=  $custom_theme . '-theme ';
    ?>
    <body id="palleon" class="<?php echo esc_attr($bodyClasses); ?>">
        <?php do_action('palleon_body_start'); ?>