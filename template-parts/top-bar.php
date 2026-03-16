<?php
$logo = PalleonSettings::get_option('logo', PALLEON_PLUGIN_URL . 'assets/logo.png');
$logo_small = PalleonSettings::get_option('logo_small', PALLEON_PLUGIN_URL . 'assets/logo-small.png');
$history = PalleonSettings::get_option('history', 'enable');
$allow_save = PalleonSettings::get_option('allow_save','enable'); 
$button_text = esc_html__('Save or Download', 'palleon');
if (!is_user_logged_in() || (is_user_logged_in() && ($allow_save == 'disable' && !current_user_can('administrator')))) {
    $button_text = esc_html__('Download', 'palleon');
}
?>
<div id="palleon-top-bar">
    <div class="palleon-logo">
        <a href="<?php echo esc_url(home_url( '/' )); ?>">
            <img class="logo-desktop" src="<?php echo esc_url($logo); ?>" />
            <img class="logo-mobile" src="<?php echo esc_url($logo_small); ?>" />
        </a>
    </div>
    <div class="palleon-top-bar-menu">
        <?php if ($history == 'enable') { ?>
        <div class="palleon-undo">
            <button id="palleon-undo" type="button" class="palleon-btn-simple tooltip" data-title="<?php echo esc_attr__('Undo', 'palleon'); ?>" autocomplete="off" disabled><span class="material-icons">undo</span></button>
        </div>
        <div class="palleon-redo">
            <button id="palleon-redo" type="button" class="palleon-btn-simple tooltip" data-title="<?php echo esc_attr__('Redo', 'palleon'); ?>" autocomplete="off" disabled><span class="material-icons">redo</span></button>
        </div>
        <div class="palleon-history">
            <button id="palleon-history" type="button" class="palleon-btn-simple palleon-modal-open tooltip" data-title="<?php echo esc_attr__('History', 'palleon'); ?>" autocomplete="off" data-target="#modal-history" disabled><span class="material-icons">history</span></button>
        </div>
        <?php } ?>
        <?php do_action('palleon_top_bar'); ?>
        <div class="palleon-new">
            <button id="palleon-new" type="button" class="palleon-btn primary palleon-modal-open" autocomplete="off" data-target="#modal-add-new"><span class="material-icons">add_circle</span><span class="palleon-btn-text"><?php echo esc_html__('New', 'palleon'); ?></span></button>
        </div>
        <div class="palleon-save">
            <button id="palleon-save" type="button" class="palleon-btn primary palleon-modal-open" autocomplete="off" data-target="#modal-save" disabled><span class="material-icons">save</span><span class="palleon-btn-text"><?php echo $button_text; ?></span></button>
        </div>
        <?php if (is_user_logged_in() && has_nav_menu( 'palleon-be-menu' )) { ?>
        <div class="palleon-user-menu">
            <div id="palleon-user-menu" class="palleon-dropdown-wrap">
                <?php echo get_avatar( get_current_user_id(), 64 ); ?>
                <span class="material-icons">arrow_drop_down</span>
                <?php wp_nav_menu( array(
                    'theme_location' => 'palleon-be-menu',
                    'menu_id'        => 'palleon-be-menu',
                    'menu_class'     => 'palleon-dropdown',
	                'depth'          => 1
                ) ); ?>
            </div>
        </div>
        <?php 
        if (!is_admin()) {
        $slug =  PalleonSettings::get_option('fe_slug', 'palleon'); 
        $redirect = get_home_url() . '?page=' . $slug;
        ?>
        <div id="palleon-login" class="logout">
            <a id="palleon-logout-link" href="<?php echo esc_url(wp_logout_url($redirect)); ?>" title="<?php echo esc_attr__('Logout', 'palleon'); ?>"><span class="material-icons">logout</span></a>
        </div>
        <?php } ?>
        <?php } else if (!is_user_logged_in() && has_nav_menu( 'palleon-fe-menu' )) { ?>
        <div class="palleon-user-menu">
            <div id="palleon-user-menu" class="palleon-dropdown-wrap">
                <span class="material-icons">menu</span>
                <?php wp_nav_menu( array(
                    'theme_location' => 'palleon-fe-menu',
                    'menu_id'        => 'palleon-fe-menu',
                    'menu_class'     => 'palleon-dropdown',
	                'depth'          => 1
                ) ); ?>
            </div>
        </div>   
        <div id="palleon-login">
            <?php 
            $slug =  PalleonSettings::get_option('fe_slug', 'palleon'); 
            $redirect = get_home_url() . '?page=' . $slug;
            ?>
            <a id="palleon-login-link" href="<?php echo esc_url(wp_login_url($redirect)); ?>" title="<?php echo esc_attr__('Login', 'palleon'); ?>"><span class="material-icons">login</span></a>
        </div> 
        <?php } ?>
    </div>
</div>