<?php $ml_button =  PalleonSettings::get_option('hide_ml_btns', 'show'); ?>
<div id="palleon-image" class="palleon-icon-panel-content panel-hide">
<?php Palleon::ad_manager('image'); ?>
    <div class="palleon-tabs">
        <ul class="palleon-tabs-menu">
            <li id="palleon-img-mode" class="active" data-target="#palleon-image-mode"><?php echo esc_html__('Image', 'palleon'); ?></li>
            <li data-target="#palleon-overlay-image-mode"><?php echo esc_html__('Overlay Image', 'palleon'); ?></li>
        </ul>
        <div id="palleon-image-mode" class="palleon-tab active">
            <div id="palleon-img-upload-wrap" class="palleon-file-field">
                <input type="file" name="palleon-file" id="palleon-img-upload" class="palleon-hidden-file" accept="image/png, image/jpeg, image/webp" />
                <label for="palleon-img-upload" class="palleon-btn primary palleon-lg-btn btn-full"><span class="material-icons">upload</span><span><?php echo esc_html__('Upload from computer', 'palleon'); ?></span></label>
            </div>
            <?php if (is_user_logged_in() && ($ml_button == 'show' || current_user_can('administrator') || current_user_can('editor'))) { ?>
            <button id="palleon-img-media-library" type="button" class="palleon-btn primary palleon-lg-btn btn-full palleon-modal-open" data-target="#modal-media-library"><span class="material-icons">photo_library</span><?php echo esc_html__('Select From Media Library', 'palleon'); ?></button>
            <?php } ?>
            <div id="palleon-image-settings" class="palleon-sub-settings">
            <button id="crop-image-object" type="button" class="palleon-btn palleon-lg-btn btn-full"><span class="material-icons">crop</span><?php echo esc_html__('Crop Image', 'palleon'); ?></button> 
            <button id="crop-image-object-selection" type="button" class="palleon-btn danger palleon-lg-btn btn-full d-none"><span class="material-icons">crop</span><?php echo esc_html__('Crop Selection', 'palleon'); ?></button> 
                <div class="palleon-control-wrap">
                    <label class="palleon-control-label"><?php echo esc_html__('Image Filter', 'palleon'); ?></label>
                    <div class="palleon-control">
                        <?php 
                        $filters = Palleon::get_filters(); 
                        unset($filters['sharpen']);
                        unset($filters['emboss']);
                        unset($filters['sobelX']);
                        unset($filters['sobelY']);
                        ?>
                        <select id="image-filter" class="palleon-select" autocomplete="off">
                            <option value="none" selected><?php echo esc_html__('None', 'palleon'); ?></option>
                            <?php 
                            foreach($filters as $id => $name) {
                                echo '<option value="' . $id . '">' . $name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="palleon-control-wrap">
                    <label class="palleon-control-label"><?php echo esc_html__('Border Width', 'palleon'); ?></label>
                    <div class="palleon-control">
                        <input id="img-border-width" class="palleon-form-field" type="number" value="0" data-min="0" data-max="1000" step="1" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap">
                    <label class="palleon-control-label"><?php echo esc_html__('Border Color', 'palleon'); ?></label>
                    <div class="palleon-control">
                        <input id="img-border-color" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#ffffff" />
                    </div>
                </div>
                <div class="palleon-control-wrap conditional">
                    <label class="palleon-control-label"><?php echo esc_html__('Mask', 'palleon'); ?></label>
                    <div class="palleon-control">
                        <select id="palleon-img-mask" class="palleon-select" autocomplete="off">
                            <option value="none" selected><?php echo esc_html__('None', 'palleon'); ?></option>
                            <option value="circle"><?php echo esc_html__('Circle', 'palleon'); ?></option>
                            <option value="triangle"><?php echo esc_html__('Triangle Up', 'palleon'); ?></option>
                            <option value="triangleDown"><?php echo esc_html__('Triangle Down', 'palleon'); ?></option>
                            <option value="triangleLeft"><?php echo esc_html__('Triangle Left', 'palleon'); ?></option>
                            <option value="triangleRight"><?php echo esc_html__('Triangle Right', 'palleon'); ?></option>
                            <option value="pentagon"><?php echo esc_html__('Pentagon Up', 'palleon'); ?></option> 
                            <option value="pentagonDown"><?php echo esc_html__('Pentagon Down', 'palleon'); ?></option> 
                            <option value="pentagonLeft"><?php echo esc_html__('Pentagon Left', 'palleon'); ?></option> 
                            <option value="pentagonRight"><?php echo esc_html__('Pentagon Right', 'palleon'); ?></option> 
                            <option value="octagon"><?php echo esc_html__('Octagon', 'palleon'); ?></option>
                            <option value="star"><?php echo esc_html__('Star', 'palleon'); ?></option>
                            <option value="starReverse"><?php echo esc_html__('Star Reverse', 'palleon'); ?></option>
                            <option value="custom"><?php echo esc_html__('Rounded Corners', 'palleon'); ?></option>
                        </select>
                    </div>
                </div>
                <div id="palleon-img-radius-settings" class="d-none">
                    <div class="palleon-control-wrap label-block">
                        <label class="palleon-control-label slider-label"><?php echo esc_html__('Rounded Corners', 'palleon'); ?><span>0</span></label>
                        <div class="palleon-control">
                            <input id="img-border-radius" type="range" min="0" max="1000" value="0" step="1" class="palleon-slider" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="palleon-control-wrap conditional">
                    <label class="palleon-control-label"><?php echo esc_html__('Shadow', 'palleon'); ?></label>
                    <div class="palleon-control palleon-toggle-control">
                        <label class="palleon-toggle">
                            <input id="palleon-image-shadow" class="palleon-toggle-checkbox" data-conditional="#image-shadow-settings" type="checkbox" autocomplete="off" />
                            <div class="palleon-toggle-switch"></div>
                        </label>
                    </div>
                </div>
                <div id="image-shadow-settings" class="d-none conditional-settings">
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Shadow Color', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="image-shadow-color" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#000" />
                        </div>
                    </div>
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Shadow Blur', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="image-shadow-blur" class="palleon-form-field" type="number" value="5" step="1" autocomplete="off">
                        </div>
                    </div>
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Offset X', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="image-shadow-offset-x" class="palleon-form-field" type="number" value="5" step="1" autocomplete="off">
                        </div>
                    </div>
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Offset Y', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="image-shadow-offset-y" class="palleon-form-field" type="number" value="5" step="1" autocomplete="off">
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="palleon-control-wrap label-block">
                    <div class="palleon-control">
                        <div class="palleon-btn-group icon-group">
                            <button id="img-flip-horizontal" type="button" class="palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('Flip X', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                            <button id="img-flip-vertical" type="button" class="palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('Flip Y', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                            <button type="button" class="palleon-horizontal-center palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('H-Align Center', 'palleon'); ?>"><span class="material-icons">align_horizontal_center</span></button>
                            <button type="button" class="palleon-vertical-center palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('V-Align Center', 'palleon'); ?>"><span class="material-icons">vertical_align_center</span></button>
                        </div>
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Opacity', 'palleon'); ?><span>1</span></label>
                    <div class="palleon-control">
                        <input id="img-opacity" type="range" min="0" max="1" value="1" step="0.1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Skew X', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="img-skew-x" type="range" min="0" max="180" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Skew Y', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="img-skew-y" type="range" min="0" max="180" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Rotate', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="img-rotate" type="range" min="0" max="360" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <?php if (is_user_logged_in()) { ?>
                <hr/>
                <button id="palleon-img-replace-media-library" type="button" class="palleon-btn palleon-lg-btn btn-full palleon-modal-open" data-target="#modal-media-library"><span class="material-icons">photo_library</span><?php echo esc_html__('Replace Image', 'palleon'); ?></button>
                <?php } ?>
            </div>
        </div>
        <div id="palleon-overlay-image-mode" class="palleon-tab">
            <div class="palleon-file-field">
                <input type="file" name="palleon-file" id="palleon-overlay-img-upload" class="palleon-hidden-file" accept="image/png, image/jpeg, image/webp" />
                <label for="palleon-overlay-img-upload" class="palleon-btn primary palleon-lg-btn btn-full"><span class="material-icons">upload</span><span><?php echo esc_html__('Upload from computer', 'palleon'); ?></span></label>
            </div>
            <?php if (is_user_logged_in() && ($ml_button == 'show' || current_user_can('administrator') || current_user_can('editor'))) { ?>
            <button id="palleon-overlay-img-media-library" type="button" class="palleon-btn primary palleon-lg-btn btn-full palleon-modal-open" data-target="#modal-media-library"><span class="material-icons">photo_library</span><?php echo esc_html__('Select From Media Library', 'palleon'); ?></button>
            <?php } ?>
            <div class="notice notice-warning"><?php echo esc_html__('It is useful only if your PNG image has transparent parts and the size of the image (or the aspect ratio) is equal to the canvas. The overlay image will over all objects on the canvas and will be stretched to fit the canvas.', 'palleon'); ?></div>
            <div id="palleon-overlay-wrap">
                <img id="palleon-overlay-preview" src="" />
                <button id="palleon-overlay-delete" type="button" class="palleon-btn palleon-lg-btn btn-full"><span class="material-icons">delete</span><?php echo esc_html__('Remove Overlay Image', 'palleon'); ?></button>
            </div>
        </div>
    </div>
</div>