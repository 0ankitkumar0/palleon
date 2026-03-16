<div id="palleon-elements" class="palleon-icon-panel-content panel-hide">
<?php Palleon::ad_manager('elements'); ?>
    <div class="palleon-tabs">
        <ul class="palleon-tabs-menu">
            <li id="palleon-all-elements-open" class="active" data-target="#palleon-all-elements"><?php echo esc_html__('All', 'palleon'); ?></li>
            <li id="palleon-illustrations-open" data-target="#palleon-illustrations"><?php echo esc_html__('Illustrations', 'palleon'); ?></li>
            <li id="palleon-custom-svg-open" data-target="#palleon-customsvg-upload"><?php echo esc_html__('Custom', 'palleon'); ?></li>
        </ul>
        <div id="palleon-all-elements" class="palleon-tab active">
            <div class="palleon-search-wrap">
                <input id="palleon-element-search" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search Category...', 'palleon'); ?>" autocomplete="off" />
                <span id="palleon-element-search-icon" class="material-icons">search</span>
            </div>
            <div id="palleon-noelements" class="notice notice-warning"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
            <ul id="palleon-elements-wrap" class="palleon-accordion">
                <?php 
                $default_elements = PalleonSettings::get_option('default_elements', 'enable');
                $perpage =  PalleonSettings::get_option('el_pagination',12);
                $user_fav = get_user_meta(get_current_user_id(), 'palleon_element_fav',true);
                if (empty($user_fav)) {
                    $user_fav = array();
                }
                if (is_user_logged_in()) { 
                ?>
                <li>
                    <a><span class="material-icons my-favorites-star">star</span><?php echo esc_html__('My Favorites', 'palleon'); ?><span id="elements-favorites-count" class="data-count"><?php echo count($user_fav); ?></span><span class="material-icons arrow">keyboard_arrow_down</span></a>
                    <div id="palleon-my-favorites">
                    <?php
                    echo '<div class="palleon-grid palleon-elements-grid four-column">';
                    if (!empty($user_fav)) {
                        foreach($user_fav as $slug) {
                            if (substr( $slug, 0, 4 ) === "http") {  
                                $url_query = parse_url($slug, PHP_URL_QUERY);
                                if (!empty($url_query)) {
                                    parse_str($url_query, $output);
                                } else {
                                    $output = array("bg"=>"dark","loader"=>"yes");
                                }
                                ?>
                                <div class="palleon-element <?php echo esc_attr($output['bg']); ?>" data-elsource="<?php echo esc_url($slug); ?>" data-loader="<?php echo esc_attr($output['loader']); ?>">
                                <img class="lazy" data-src="<?php echo esc_url($slug); ?>" />
                                <div class="element-favorite"><button type="button" class="palleon-btn-simple star favorited" data-elementid="<?php echo esc_attr($slug); ?>"><span class="material-icons">star</span></button></div>
                                </div>
                            <?php } else {
                                $elementTags = palleon_get_element_tags();
                                $tag = strtok($slug, '/');
                                echo '<div class="palleon-element ' . $elementTags[$tag][2] . '" data-elsource="' . PALLEON_SOURCE_URL . 'elements/' . $slug . '.svg" data-loader="' . $elementTags[$tag][3] . '">';
                                echo '<img class="lazy" data-src="' . PALLEON_SOURCE_URL . 'elements/' . $slug . '.svg" />';
                                echo '<div class="element-favorite"><button type="button" class="palleon-btn-simple star favorited" data-elementid="' . $slug . '"><span class="material-icons">star</span></button></div>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo '<div class="notice notice-info"><h6>' . esc_html__( 'No favorites yet', 'palleon' ) . '</h6>' . esc_html__('Click the star icon on any element, and you will see it here next time you visit.', 'palleon') . '</div>';
                    }
                    echo '</div>';
                    ?>
                </div>
                </li>
                <?php } ?>
                <?php
                $post_list = get_posts( array(
                    'post_type'    => 'palleonelements',
                    'post_status' => 'publish',
                    'numberposts' => 99
                ) );
                
                if (!empty($post_list) && is_array($post_list)) {
                    foreach ( $post_list as $post ) {
                        $c_elements = get_post_meta( $post->ID, 'palleon_cmb2_custom_elements', true );
                        $c_element_bg = get_post_meta( $post->ID, 'palleon_cmb2_custom_elements_bg', true );
                        $c_element_loader = get_post_meta( $post->ID, 'palleon_cmb2_custom_elements_loader', true );

                        if (empty($c_elements)) {
                            $c_elements = array();
                        }

                        echo '<li data-keyword="' . esc_attr($post->post_name) . '"><a>' . esc_html($post->post_title) . '<span class="data-count">' . count($c_elements) . '</span><span class="material-icons arrow">keyboard_arrow_down</span></a><div><div id="palleon-custom-elements-grid-' . esc_attr($post->post_name) . '" class="palleon-grid palleon-elements-grid four-column paginated" data-perpage="' . esc_attr($perpage) . '">';

                        foreach ( (array) $c_elements as $attachment_id => $attachment_url ) {
                            $c_btn_class = '';
                            $c_icon = 'star_border';
                            if (in_array($attachment_url, $user_fav)) {
                                $c_btn_class = 'favorited';
                                $c_icon = 'star';
                            }
                            echo '<div class="palleon-element ' . $c_element_bg . '" data-elsource="' . $attachment_url . '" data-loader="' . $c_element_loader . '">';
                            echo '<img class="lazy" data-src="' . $attachment_url . '" />';
                            echo '<div class="element-favorite"><button type="button" class="palleon-btn-simple star ' . $c_btn_class . '" data-elementid="' . $attachment_url . '?bg=' . $c_element_bg .'&loader=' . $c_element_loader . '"><span class="material-icons">' . $c_icon . '</span></button></div>';
                            echo '</div>';
                        }

                        echo '</div></div></li>';
                    }
                }

                if ($default_elements == 'enable') {
                    $elementTags = palleon_get_element_tags();
                    foreach($elementTags as $slug => $data) {
                        echo '<li data-keyword="' . $slug . '"><a>' . $data[0] . '<span class="data-count">' . $data[1] . '</span><span class="material-icons arrow">keyboard_arrow_down</span></a><div><div id="palleon-elements-grid-' . $slug . '" class="palleon-grid palleon-elements-grid four-column paginated" data-perpage="' . esc_attr($perpage) . '">';
                        for ($i = 1; $i <= $data[1]; ++$i) {
                            $elementid = $slug . '/' . $i;
                            $btn_class = '';
                            $icon = 'star_border';
                            if (in_array($elementid, $user_fav)) {
                                $btn_class = 'favorited';
                                $icon = 'star';
                            }
                            echo '<div class="palleon-element ' . $data[2] . '" data-elsource="' . PALLEON_SOURCE_URL . 'elements/' . $elementid . '.svg" data-loader="' . $data[3] . '">';
                            echo '<img class="lazy" data-src="' . PALLEON_SOURCE_URL . 'elements/' . $elementid . '.svg" />';
                            echo '<div class="element-favorite"><button type="button" class="palleon-btn-simple star ' . $btn_class . '" data-elementid="' . $elementid . '"><span class="material-icons">' . $icon . '</span></button></div>';
                            echo '</div>';
                        }
                        echo '</div></div></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div id="palleon-illustrations" class="palleon-tab">
            <div class="palleon-search-wrap">
                <input id="palleon-illustration-search" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search illustration...', 'palleon'); ?>" autocomplete="off" />
                <span id="palleon-illustration-search-icon" class="material-icons">search</span>
            </div>
            <div id="palleon-noillustrations" class="notice notice-warning"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
            <div id="palleon-illustrations-grid" class="palleon-grid palleon-elements-grid two-column">
                <?php
                $illustrations = palleon_get_illustrations();
                foreach($illustrations as $illustration) { 
                    $img_url = PALLEON_SOURCE_URL . 'illustrations/' . $illustration . '.svg';
                ?>
                <div class="palleon-element light tooltip tooltip-top" data-elsource="<?php echo esc_url($img_url); ?>" data-loader="yes" data-keyword="<?php echo esc_attr($illustration); ?>" data-title="<?php echo esc_attr(str_replace("-"," ",$illustration)); ?>">
                    <div class="palleon-img-wrap">
                        <div class="palleon-img-loader"></div>
                        <img class="lazy" data-src="<?php echo esc_url($img_url); ?>" />
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div id="palleon-customsvg-upload" class="palleon-tab">
            <div id="palleon-element-upload-wrap" class="palleon-file-field">
                <input type="file" name="palleon-element-upload" id="palleon-element-upload" class="palleon-hidden-file" accept="image/svg+xml" />
                <label for="palleon-element-upload" class="palleon-btn primary palleon-lg-btn btn-full"><span class="material-icons">upload</span><span><?php echo esc_html__('Upload SVG from computer', 'palleon'); ?></span></label>
            </div>
            <?php $allowSVG =  PalleonSettings::get_option('allow_svg', 'enable');
            if ($allowSVG == 'enable' && is_user_logged_in()) {
            ?>
            <button id="palleon-svg-media-library" type="button" class="palleon-btn primary palleon-lg-btn btn-full palleon-modal-open" data-target="#modal-svg-library"><span class="material-icons">photo_library</span><?php echo esc_html__('Select From Media Library', 'palleon'); ?></button>
            <?php } ?>
            <div id="palleon-custom-svg-options">
                <hr/>
                <div id="customsvg-colors"></div>
                <hr/>
                <div class="palleon-control-wrap label-block">
                    <div class="palleon-control">
                        <div class="palleon-btn-group icon-group">
                            <button id="customsvg-flip-horizontal" type="button" class="palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('Flip X', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                            <button id="customsvg-flip-vertical" type="button" class="palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('Flip Y', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                            <button type="button" class="palleon-horizontal-center palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('H-Align Center', 'palleon'); ?>"><span class="material-icons">align_horizontal_center</span></button>
                            <button type="button" class="palleon-vertical-center palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('V-Align Center', 'palleon'); ?>"><span class="material-icons">vertical_align_center</span></button>
                        </div>
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Opacity', 'palleon'); ?><span>1</span></label>
                    <div class="palleon-control">
                        <input id="customsvg-opacity" type="range" min="0" max="1" value="1" step="0.1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Skew X', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="customsvg-skew-x" type="range" min="0" max="180" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Skew Y', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="customsvg-skew-y" type="range" min="0" max="180" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Rotate', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="customsvg-rotate" type="range" min="0" max="360" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
            </div>
            <div id="palleon-custom-element-options">
                <hr/>
                <div class="palleon-control-wrap">
                    <label class="palleon-control-label"><?php echo esc_html__('Fill Style', 'palleon'); ?></label>
                    <div class="palleon-control">
                        <select id="palleon-element-gradient" class="palleon-select" autocomplete="off">
                            <option value="none" selected><?php echo esc_html__('Solid Color', 'palleon'); ?></option>
                            <option value="vertical"><?php echo esc_html__('Vertical Gradient', 'palleon'); ?></option>
                            <option value="horizontal"><?php echo esc_html__('Horizontal Gradient', 'palleon'); ?></option>
                            <option value="diagonal"><?php echo esc_html__('Diagonal Gradient', 'palleon'); ?></option>
                        </select>
                    </div>
                </div>
                <div id="element-gradient-settings">
                    <div class="palleon-control-wrap control-text-color">
                        <label class="palleon-control-label"><?php echo esc_html__('Color 1', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-gradient-color-1" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#9C27B0" />
                        </div>
                    </div>
                    <div class="palleon-control-wrap control-text-color">
                        <label class="palleon-control-label"><?php echo esc_html__('Color 2', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-gradient-color-2" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#000000" />
                        </div>
                    </div>
                    <div class="palleon-control-wrap control-text-color">
                        <label class="palleon-control-label"><?php echo esc_html__('Color 3', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-gradient-color-3" type="text" class="palleon-colorpicker allow-empty" autocomplete="off" value="" />
                        </div>
                    </div>
                    <div class="palleon-control-wrap control-text-color">
                        <label class="palleon-control-label"><?php echo esc_html__('Color 4', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-gradient-color-4" type="text" class="palleon-colorpicker allow-empty" autocomplete="off" value="" />
                        </div>
                    </div>
                </div>
                <div id="element-fill-color" class="palleon-control-wrap">
                    <label class="palleon-control-label"><?php echo esc_html__('Fill Color', 'palleon'); ?></label>
                    <div class="palleon-control">
                        <input id="palleon-element-color" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="" />
                    </div>
                </div>
                <div class="palleon-control-wrap conditional">
                    <label class="palleon-control-label"><?php echo esc_html__('Shadow', 'palleon'); ?></label>
                    <div class="palleon-control palleon-toggle-control">
                        <label class="palleon-toggle">
                            <input id="palleon-element-shadow" class="palleon-toggle-checkbox" data-conditional="#element-shadow-settings" type="checkbox" autocomplete="off" />
                            <div class="palleon-toggle-switch"></div>
                        </label>
                    </div>
                </div>
                <div id="element-shadow-settings" class="d-none conditional-settings">
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Shadow Color', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-shadow-color" type="text" class="palleon-colorpicker disallow-empty" autocomplete="off" value="#000" />
                        </div>
                    </div>
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Shadow Blur', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-shadow-blur" class="palleon-form-field" type="number" value="5" step="1" autocomplete="off">
                        </div>
                    </div>
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Offset X', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-shadow-offset-x" class="palleon-form-field" type="number" value="5" step="1" autocomplete="off">
                        </div>
                    </div>
                    <div class="palleon-control-wrap">
                        <label class="palleon-control-label"><?php echo esc_html__('Offset Y', 'palleon'); ?></label>
                        <div class="palleon-control">
                            <input id="element-shadow-offset-y" class="palleon-form-field" type="number" value="5" step="1" autocomplete="off">
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="palleon-control-wrap label-block">
                    <div class="palleon-control">
                        <div class="palleon-btn-group icon-group">
                            <button id="element-flip-horizontal" type="button" class="palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('Flip X', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                            <button id="element-flip-vertical" type="button" class="palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('Flip Y', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                            <button type="button" class="palleon-horizontal-center palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('H-Align Center', 'palleon'); ?>"><span class="material-icons">align_horizontal_center</span></button>
                            <button type="button" class="palleon-vertical-center palleon-btn tooltip tooltip-top" data-title="<?php echo esc_attr__('V-Align Center', 'palleon'); ?>"><span class="material-icons">vertical_align_center</span></button>
                        </div>
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Opacity', 'palleon'); ?><span>1</span></label>
                    <div class="palleon-control">
                        <input id="element-opacity" type="range" min="0" max="1" value="1" step="0.1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Skew X', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="element-skew-x" type="range" min="0" max="180" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Skew Y', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="element-skew-y" type="range" min="0" max="180" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
                <div class="palleon-control-wrap label-block">
                    <label class="palleon-control-label slider-label"><?php echo esc_html__('Rotate', 'palleon'); ?><span>0</span></label>
                    <div class="palleon-control">
                        <input id="element-rotate" type="range" min="0" max="360" value="0" step="1" class="palleon-slider" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>