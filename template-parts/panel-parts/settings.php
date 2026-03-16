<?php $ruler = PalleonSettings::get_option('module_ruler', 'enable'); ?>
<div id="palleon-settings" class="palleon-icon-panel-content panel-hide">
    <?php do_action('palleon_user_settings_start'); ?>
    <div class="palleon-control-wrap control-text-color">
        <label class="palleon-control-label"><?php echo esc_html__('Canvas Background', 'palleon'); ?></label>
        <div class="palleon-control">
            <input id="custom-image-background" type="text" class="palleon-colorpicker allow-empty" autocomplete="off" value="" />
        </div>
    </div>
    <hr/>
    <h5><?php echo esc_html__('Preferences', 'palleon'); ?></h5>
    <div id="palleon-preferences">
        <div class="palleon-control-wrap label-block">
            <?php $font_size = Palleon::get_user_option('custom-font-size', get_current_user_id(), 14); ?>
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Font Size', 'palleon'); ?><span><?php echo esc_html($font_size); ?></span></label>
            <div class="palleon-control">
                <input id="custom-font-size" type="range" min="10" max="18" value="<?php echo esc_html($font_size); ?>" step="1" class="palleon-slider preference" autocomplete="off">
            </div>
        </div>
        <div class="palleon-control-wrap">
        <?php 
        $default_theme = PalleonSettings::get_option('default_theme','dark');
        $custom_theme = Palleon::get_user_option('custom-theme', get_current_user_id(), $default_theme);
        ?>
            <label class="palleon-control-label"><?php echo esc_html__('Theme', 'palleon'); ?></label>
            <div class="palleon-control">
                <select id="custom-theme" class="palleon-select preference" autocomplete="off">
                    <option value="dark" <?php if ($custom_theme == 'dark') { echo 'selected'; } ?>><?php echo esc_html__('Dark', 'palleon'); ?></option>
                    <option value="light" <?php if ($custom_theme == 'light') { echo 'selected'; } ?>><?php echo esc_html__('Light', 'palleon'); ?></option>
                </select>
            </div>
        </div>
        <?php if ($ruler == 'enable') {  ?>
        <div class="palleon-control-wrap control-text-color">
        <?php $guide_color = Palleon::get_user_option('ruler-guide-color', get_current_user_id(), '#4affff'); ?>
            <label class="palleon-control-label"><?php echo esc_html__('Ruler Guide Color', 'palleon'); ?></label>
            <div class="palleon-control">
                <input id="ruler-guide-color" type="text" class="palleon-colorpicker allow-empty preference" autocomplete="off" value="<?php echo esc_html($guide_color); ?>" />
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <?php $guide_size = Palleon::get_user_option('ruler-guide-size', get_current_user_id(), '1'); ?>
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Ruler Guide Size', 'palleon'); ?><span><?php echo esc_html($guide_size); ?></span></label>
            <div class="palleon-control">
                <input id="ruler-guide-size" type="range" min="1" max="10" value="<?php echo esc_html($guide_size); ?>" step="1" class="palleon-slider preference" autocomplete="off">
            </div>
        </div>
        <?php } ?>
    </div>
    <?php if (get_current_user_id()) { ?>
    <div class="palleon-control-wrap label-block">
        <div class="palleon-control">
            <button id="palleon-preferences-save" type="button" class="palleon-btn palleon-lg-btn btn-full primary"><?php echo esc_html__('Save Preferences', 'palleon'); ?></button>
        </div>
    </div>
    <?php } ?>
    <?php do_action('palleon_user_settings_end'); ?>
</div>