<div id="palleon-multiavatar-app" class="d-none">
    <div class="palleon-close-app palleon-btn">
        <span class="material-icons">keyboard_backspace</span>
        <?php echo esc_html__('Go Back', 'palleon'); ?>
    </div>
    <div id="palleon-multiavatar-preview" class="palleon-app-peview"></div>
    <input type="text" id="palleon-multiavatar-name" class="palleon-form-field" autocomplete="off" placeholder="<?php echo esc_attr__('Type something...', 'palleon'); ?>" value="" />
    <button id="palleon-generate-multiavatar" type="button" class="palleon-btn primary palleon-lg-btn btn-full"><span class="material-icons">refresh</span><?php echo esc_html__('Random', 'palleon'); ?></button>
    <hr/>
    <div class="palleon-app-btns">
        <button id="palleon-download-multiavatar" type="button" class="palleon-btn palleon-lg-btn palleon-app-download" data-id="multiavatar"><span class="material-icons">download</span><?php echo esc_html__('Download', 'palleon'); ?></button>
        <button id="palleon-select-multiavatar" type="button" class="palleon-btn primary palleon-lg-btn palleon-app-select" data-id="multiavatar"><span class="material-icons">check</span><?php echo esc_html__('Select', 'palleon'); ?></button>
    </div>
</div>