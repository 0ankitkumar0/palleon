<div id="palleon-flags-app" class="d-none">
    <div class="palleon-close-app palleon-btn">
        <span class="material-icons">keyboard_backspace</span>
        <?php echo esc_html__('Go Back', 'palleon'); ?>
    </div>
    <div id="palleon-flags-preview" class="palleon-app-peview"><div></div></div>
    <div class="palleon-control-wrap">
        <label class="palleon-control-label"><?php echo esc_html__('Country', 'palleon'); ?></label>
        <div class="palleon-control">
            <select id="palleon-flags-list" class="palleon-select palleon-select2" autocomplete="off"></select>
        </div>
    </div>
    <div class="palleon-control-wrap">
        <label class="palleon-control-label"><?php echo esc_html__('Style', 'palleon'); ?></label>
        <div class="palleon-control">
            <select id="palleon-flags-style" class="palleon-select" autocomplete="off">
                <option value="original" selected><?php echo esc_html__('Original', 'palleon'); ?></option>
                <option value="square"><?php echo esc_html__('Square', 'palleon'); ?></option>
            </select>
        </div>
    </div>
    <hr/>
    <div class="palleon-app-btns">
        <button id="palleon-download-flags" type="button" class="palleon-btn palleon-lg-btn palleon-app-download" data-id="flags"><span class="material-icons">download</span><?php echo esc_html__('Download', 'palleon'); ?></button>
        <button id="palleon-select-flags" type="button" class="palleon-btn primary palleon-lg-btn palleon-app-select" data-id="flags"><span class="material-icons">check</span><?php echo esc_html__('Select', 'palleon'); ?></button>
    </div>
</div>