<div id="palleon-qrcode-app" class="d-none">
    <div class="palleon-close-app palleon-btn">
        <span class="material-icons">keyboard_backspace</span>
        <?php echo esc_html__('Go Back', 'palleon'); ?>
    </div>
    <div id="palleon-qrcode-settings">
        <div class="palleon-control-wrap">
            <label class="palleon-control-label"><?php echo esc_html__('Preview', 'palleon'); ?></label>
            <div class="palleon-control">
                <div id="qrcode-preview"></div>
            </div>
        </div>
        <hr/>
        <div class="palleon-control-wrap">
            <label class="palleon-control-label"><?php echo esc_html__('Text', 'palleon'); ?></label>
            <div class="palleon-control">
                <input type="text" id="palleon-qrcode-text" class="palleon-form-field" autocomplete="off" value="<?php echo esc_html__('https://mysite.com', 'palleon'); ?>" />
            </div>
        </div>
        <div class="palleon-control-wrap control-text-color">
            <label class="palleon-control-label"><?php echo esc_html__('Fill Color', 'palleon'); ?></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-fill" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#333333" />
            </div>
        </div>
        <div class="palleon-control-wrap control-text-color">
            <label class="palleon-control-label"><?php echo esc_html__('Background Color', 'palleon'); ?></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-back" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#FFFFFF" />
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Rounded Corners', 'palleon'); ?><span>0</span></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-rounded" type="range" min="0" max="100" value="0" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
        <hr/>
        <div class="palleon-control-wrap">
            <label class="palleon-control-label"><?php echo esc_html__('Label', 'palleon'); ?></label>
            <div class="palleon-control">
                <input type="text" id="palleon-qrcode-label" class="palleon-form-field" autocomplete="off" value="" />
            </div>
        </div>
        <div class="palleon-control-wrap control-text-color">
            <label class="palleon-control-label"><?php echo esc_html__('Label Color', 'palleon'); ?></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-label-color" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#333333" />
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Label Size', 'palleon'); ?><span>30</span></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-label-size" type="range" min="0" max="100" value="30" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Label Position X', 'palleon'); ?><span>50</span></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-label-position-x" type="range" min="0" max="100" value="50" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Label Position Y', 'palleon'); ?><span>50</span></label>
            <div class="palleon-control">
                <input id="palleon-qrcode-label-position-y" type="range" min="0" max="100" value="50" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
    </div>
    <hr/>
    <button id="palleon-generate-qr-code" type="button" class="palleon-btn primary palleon-lg-btn btn-full"><?php echo esc_html__('Generate QR Code', 'palleon'); ?></button>
</div>