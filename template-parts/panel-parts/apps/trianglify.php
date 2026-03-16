<div id="palleon-trianglify-app" class="d-none">
    <div class="palleon-close-app palleon-btn">
        <span class="material-icons">keyboard_backspace</span>
        <?php echo esc_html__('Go Back', 'palleon'); ?>
    </div>
    <div id="palleon-trianglify-preview" class="palleon-app-peview"><div></div></div>
    <ul class="palleon-accordion">
        <li>
            <a href="#"><span class="material-icons accordion-icon">palette</span><?php echo esc_html__('Color Scheme', 'palleon'); ?><span class="material-icons arrow">keyboard_arrow_down</span></a>
            <div>
                <div id="palleon-colorbrewer"></div>
            </div>
        </li>
    </ul>
    <div class="palleon-control-wrap label-block">
        <label class="palleon-control-label slider-label"><?php echo esc_html__('Width', 'palleon'); ?><span>1440</span></label>
        <div class="palleon-control">
            <input id="palleon-trianglify-width" type="range" min="100" max="4000" value="1440" step="1" class="palleon-slider" autocomplete="off">
        </div>
    </div>
    <div class="palleon-control-wrap label-block">
        <label class="palleon-control-label slider-label"><?php echo esc_html__('Height', 'palleon'); ?><span>900</span></label>
        <div class="palleon-control">
            <input id="palleon-trianglify-height" type="range" min="100" max="4000" value="900" step="1" class="palleon-slider" autocomplete="off">
        </div>
    </div>
    <div class="palleon-control-wrap label-block">
        <label class="palleon-control-label slider-label"><?php echo esc_html__('Cell Size', 'palleon'); ?><span>75</span></label>
        <div class="palleon-control">
            <input id="palleon-trianglify-cell-size" type="range" min="10" max="1000" value="75" step="1" class="palleon-slider" autocomplete="off">
        </div>
    </div>
    <div class="palleon-control-wrap label-block">
        <label class="palleon-control-label slider-label"><?php echo esc_html__('Variance', 'palleon'); ?><span>0.5</span></label>
        <div class="palleon-control">
            <input id="palleon-trianglify-variance" type="range" min="0" max="1" value="0.5" step="0.05" class="palleon-slider" autocomplete="off">
        </div>
    </div>
    <hr/>
    <div class="palleon-app-btns">
        <button id="palleon-download-trianglify" type="button" class="palleon-btn palleon-lg-btn palleon-app-download-png" data-id="trianglify"><span class="material-icons">download</span><?php echo esc_html__('Download', 'palleon'); ?></button>
        <button id="palleon-select-trianglify" type="button" class="palleon-btn primary palleon-lg-btn palleon-app-select-png" data-id="trianglify"><span class="material-icons">check</span><?php echo esc_html__('Select', 'palleon'); ?></button>
    </div>
</div>