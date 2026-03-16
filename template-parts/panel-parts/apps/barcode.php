<div id="palleon-barcode-app" class="d-none">
    <div class="palleon-close-app palleon-btn">
        <span class="material-icons">keyboard_backspace</span>
        <?php echo esc_html__('Go Back', 'palleon'); ?>
    </div>
    <div id="palleon-barcode-wrap">
        <svg id="palleon-barcode-preview"></svg>
    </div>
    <div id="palleon-barcode-notice" class="notice notice-danger d-none"><?php echo esc_html__('Text value is not valid for this barcode type!', 'palleon'); ?></div>
    <hr/>
    <div id="palleon-barcode-settings">
        <div class="palleon-control-wrap">
            <label class="palleon-control-label"><?php echo esc_html__('Type', 'palleon'); ?></label>
            <div class="palleon-control">
            <select id="palleon-barcode-format" class="palleon-select" autocomplete="off">
                <option value="CODE128">CODE128 auto</option>
                <option value="CODE128A">CODE128 A</option>
                <option value="CODE128B">CODE128 B</option>
                <option value="CODE128C">CODE128 C</option>
                <option value="EAN13">EAN13</option>
                <option value="EAN8">EAN8</option>
                <option value="UPC">UPC</option>
                <option value="CODE39">CODE39</option>
                <option value="ITF14">ITF14</option>
                <option value="ITF">ITF</option>
                <option value="MSI">MSI</option>
                <option value="MSI10">MSI10</option>
                <option value="MSI11">MSI11</option>
                <option value="MSI1010">MSI1010</option>
                <option value="MSI1110">MSI1110</option>
                <option value="pharmacode">Pharmacode</option>
            </select>
            </div>
        </div>
        <div class="palleon-control-wrap">
            <label class="palleon-control-label"><?php echo esc_html__('Text', 'palleon'); ?></label>
            <div class="palleon-control">
                <input type="text" id="palleon-barcode-text" class="palleon-form-field" autocomplete="off" value="<?php echo esc_html__('Example 1234', 'palleon'); ?>" />
            </div>
        </div>
        <div class="palleon-control-wrap control-text-color">
            <label class="palleon-control-label"><?php echo esc_html__('Line Color', 'palleon'); ?></label>
            <div class="palleon-control">
                <input id="palleon-barcode-line" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#000000" />
            </div>
        </div>
        <div class="palleon-control-wrap control-text-color">
            <label class="palleon-control-label"><?php echo esc_html__('Background Color', 'palleon'); ?></label>
            <div class="palleon-control">
                <input id="palleon-barcode-back" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#FFFFFF" />
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Bar Width', 'palleon'); ?><span>2</span></label>
            <div class="palleon-control">
                <input id="palleon-barcode-bar-width" type="range" min="1" max="5" value="2" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Height', 'palleon'); ?><span>100</span></label>
            <div class="palleon-control">
                <input id="palleon-barcode-height" type="range" min="10" max="150" value="100" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
        <div class="palleon-control-wrap label-block">
            <label class="palleon-control-label slider-label"><?php echo esc_html__('Margin', 'palleon'); ?><span>20</span></label>
            <div class="palleon-control">
                <input id="palleon-barcode-margin" type="range" min="0" max="50" value="20" step="1" class="palleon-slider" autocomplete="off">
            </div>
        </div>
        <div class="palleon-control-wrap conditional">
            <label class="palleon-control-label"><?php echo esc_html__('Show Text', 'palleon'); ?></label>
            <div class="palleon-control palleon-toggle-control">
                <label class="palleon-toggle">
                    <input id="palleon-barcode-show-text" class="palleon-toggle-checkbox" data-conditional="#palleon-barcode-text-settings" type="checkbox" autocomplete="off" checked />
                    <div class="palleon-toggle-switch"></div>
                </label>
            </div>
        </div>
        <div id="palleon-barcode-text-settings" class="conditional-settings">
            <div class="palleon-control-wrap label-block">
                <div class="palleon-control">
                    <div id="palleon-barcode-text-options" class="palleon-btn-group icon-group">
                        <button id="palleon-barcode-text-bold" type="button" class="palleon-btn format-style"><span class="material-icons">format_bold</span></button>
                        <button id="palleon-barcode-text-italic" type="button" class="palleon-btn format-style"><span class="material-icons">format_italic</span></button>
                        <button id="palleon-barcode-text-align-left" type="button" class="palleon-btn format-align" data-align="left"><span class="material-icons">format_align_left</span></button>
                        <button id="palleon-barcode-text-align-center" type="button" class="palleon-btn format-align active" data-align="center"><span class="material-icons">format_align_center</span></button>
                        <button id="palleon-barcode-text-align-right" type="button" class="palleon-btn format-align" data-align="right"><span class="material-icons">format_align_right</span></button>
                    </div>
                </div>
            </div>
            <?php $websafeFonts = Palleon::get_websafe_fonts(); ?>
            <div class="palleon-control-wrap">
                <label class="palleon-control-label"><?php echo esc_html__('Font Family', 'palleon'); ?></label>
                <div class="palleon-control">
                <select id="palleon-barcode-font-family" class="palleon-select">
                    <?php foreach ($websafeFonts as $font => $fontname) {
                        if ($font == 'Georgia, serif') {
                            echo '<option value="' . $font . '" selected>' . $fontname . '</option>';
                        } else {
                            echo '<option value="' . $font . '">' . $fontname . '</option>';
                        }   
                    }
                    ?>
                </select>
                </div>
            </div>
            <div class="palleon-control-wrap label-block">
                <label class="palleon-control-label slider-label"><?php echo esc_html__('Font Size', 'palleon'); ?><span>20</span></label>
                <div class="palleon-control">
                    <input id="palleon-barcode-font-size" type="range" min="8" max="36" value="20" step="1" class="palleon-slider" autocomplete="off">
                </div>
            </div>
            <div class="palleon-control-wrap label-block">
                <label class="palleon-control-label slider-label"><?php echo esc_html__('Text Margin', 'palleon'); ?><span>8</span></label>
                <div class="palleon-control">
                    <input id="palleon-barcode-text-margin" type="range" min="-15" max="30" value="8" step="1" class="palleon-slider" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <button id="palleon-generate-barcode" type="button" class="palleon-btn primary palleon-lg-btn btn-full"><?php echo esc_html__('Generate Barcode', 'palleon'); ?></button>
</div>