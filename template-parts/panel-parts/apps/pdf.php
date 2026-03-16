<div id="palleon-pdf-app" class="d-none">
    <div class="palleon-close-app palleon-btn">
        <span class="material-icons">keyboard_backspace</span>
        <?php echo esc_html__('Go Back', 'palleon'); ?>
    </div>
    <div class="palleon-control-wrap label-block">
        <label class="palleon-control-label"><?php echo esc_html__('Orientation', 'palleon'); ?></label>
        <div class="palleon-control">
            <select id="palleon-pdf-orientation" class="palleon-select" autocomplete="off">
                <option value="portrait" selected><?php echo esc_html__('Portrait (Vertical)', 'palleon'); ?></option>
                <option value="landscape"><?php echo esc_html__('Landscape (Horizontal)', 'palleon'); ?></option>
            </select>
        </div>
    </div>
    <div class="palleon-control-wrap label-block">
        <label class="palleon-control-label"><?php echo esc_html__('Format', 'palleon'); ?></label>
        <div class="palleon-control">
            <select id="palleon-pdf-format" class="palleon-select" autocomplete="off">
                <option value="a0"><?php echo esc_html__('A0 (3370x4755 px)', 'palleon'); ?></option>
                <option value="a1"><?php echo esc_html__('A1 (2378x3370 px)', 'palleon'); ?></option>
                <option value="a2"><?php echo esc_html__('A2 (1685x2378 px)', 'palleon'); ?></option>
                <option value="a3"><?php echo esc_html__('A3 (1189x1685 px)', 'palleon'); ?></option>
                <option value="a4" selected><?php echo esc_html__('A4 (841x1189 px)', 'palleon'); ?></option>
                <option value="a5"><?php echo esc_html__('A5 (594x841 px)', 'palleon'); ?></option>
                <option value="a6"><?php echo esc_html__('A6 (420x594 px)', 'palleon'); ?></option>
                <option value="a7"><?php echo esc_html__('A7 (297x420 px)', 'palleon'); ?></option>
                <option value="a8"><?php echo esc_html__('A8 (210x297 px)', 'palleon'); ?></option>
                <option value="a9"><?php echo esc_html__('A9 (148x210 px)', 'palleon'); ?></option>
                <option value="a10"><?php echo esc_html__('A10 (105x148 px)', 'palleon'); ?></option>
                <option value="letter"><?php echo esc_html__('Letter (794x1123 px)', 'palleon'); ?></option>
                <option value="legal"><?php echo esc_html__('Legal (794x1240 px)', 'palleon'); ?></option>
                <option value="executive"><?php echo esc_html__('Executive (612x787 px)', 'palleon'); ?></option>
                <option value="tabloid"><?php echo esc_html__('Tabloid (1123x1746 px)', 'palleon'); ?></option>
                <option value="ledger"><?php echo esc_html__('Ledger (1746x1123 px)', 'palleon'); ?></option>
                <option value="custom"><?php echo esc_html__('Custom Size', 'palleon'); ?></option>
            </select>
            <div id="palleon-pdf-format-desc" class="palleon-control-desc"><?php echo esc_html__('FORMAT (Recommended Image Size)', 'palleon'); ?></div>
        </div>
        <div id="palleon-pdf-custom" class="palleon-resize-wrap d-none"> 
            <input id="palleon-pdf-custom-width" class="palleon-form-field" type="number" placeholder="100" autocomplete="off"> <span class="material-icons">clear</span> <input id="palleon-pdf-custom-height" class="palleon-form-field" type="number" placeholder="100" autocomplete="off"> 
        </div>
    </div>
    <hr/>
    <div id="palleon-selected-pdf-list"></div>
    <button id="palleon-pdf-media-library" type="button" class="palleon-btn palleon-lg-btn btn-full palleon-modal-open" data-target="#modal-media-library"><span class="material-icons">add_circle</span><?php echo esc_html__('Add Image', 'palleon'); ?></button>
    <hr/>
    <button id="palleon-generate-pdf" type="button" class="palleon-btn primary palleon-lg-btn btn-full" disabled><?php echo esc_html__('Generate PDF', 'palleon'); ?></button>
</div>