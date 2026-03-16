<div id="palleon-frames" class="palleon-icon-panel-content panel-hide">
<?php Palleon::ad_manager('frames'); ?>
    <div class="palleon-tabs">
        <ul class="palleon-tabs-menu">
            <li class="active" data-target="#palleon-all-frames"><?php echo esc_html__('All', 'palleon'); ?></li>
            <li id="palleon-frame-setting-tab" data-target="#palleon-frame-options"><?php echo esc_html__('Settings', 'palleon'); ?></li>
        </ul>
        <div id="palleon-all-frames" class="palleon-tab active">
            <div class="palleon-search-wrap">
                <input id="palleon-frame-search" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search Category...', 'palleon'); ?>" autocomplete="off" />
                <span id="palleon-frame-search-icon" class="material-icons">search</span>
            </div>
            <ul id="palleon-frames-wrap" class="palleon-accordion">
                <?php
                $default_frames = PalleonSettings::get_option('default_frames', 'enable');
                $perpage =  PalleonSettings::get_option('fr_pagination',4);
                $user_fav = get_user_meta(get_current_user_id(), 'palleon_frame_fav',true);
                if (empty($user_fav)) {
                    $user_fav = array();
                }
                if (is_user_logged_in()) { 
                ?>
                <li>
                    <a><span class="material-icons my-favorites-star">star</span><?php echo esc_html__('My Favorites', 'palleon'); ?><span id="frames-favorites-count" class="data-count"><?php echo count($user_fav); ?></span><span class="material-icons arrow">keyboard_arrow_down</span></a>
                    <div id="palleon-frame-favorites">
                        <div class="palleon-frames-grid">
                            <?php
                            if (!empty($user_fav)) {
                                foreach($user_fav as $slug) {
                                    echo '<div class="palleon-frame" data-elsource="' . PALLEON_SOURCE_URL . 'frames/' . $slug . '.svg">';
                                    echo '<div class="palleon-img-wrap"><div class="palleon-img-loader"></div><img class="lazy" data-src="' . PALLEON_SOURCE_URL . 'frames/' . $slug . '.jpg" /></div>';
                                    echo '<div class="frame-favorite"><button type="button" class="palleon-btn-simple star favorited" data-frameid="' . $slug . '"><span class="material-icons">star</span></button></div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="notice notice-info"><h6>' . esc_html__( 'No favorites yet', 'palleon' ) . '</h6>' . esc_html__('Click the star icon on any frame, and you will see it here next time you visit.', 'palleon') . '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </li>
                <?php } ?>
                <?php
                $post_list = get_posts( array(
                    'post_type'    => 'palleonframes',
                    'post_status' => 'publish',
                    'numberposts' => 99
                ) );
                
                if (!empty($post_list) && is_array($post_list)) {
                    foreach ( $post_list as $post ) {
                        $c_frames = get_post_meta( $post->ID, 'palleon_cmb2_custom_frames', true );
                        $featured_img_url = get_the_post_thumbnail_url($post->ID,'large'); 

                        if (empty($c_frames)) {
                            $c_frames = array();
                        }

                        echo '<li data-keyword="' . esc_attr($post->post_name) . '"><a>' . esc_html($post->post_title) . '<span class="data-count">' . count($c_frames) . '</span><span class="material-icons arrow">keyboard_arrow_down</span></a><div><div id="palleon-custom-frames-grid-' . esc_attr($post->post_name) . '" class="palleon-frames-grid paginated" data-perpage="' . esc_attr($perpage) . '">';

                        foreach ( (array) $c_frames as $attachment_id => $attachment_url ) {
                            $c_btn_class = '';
                            $c_icon = 'star_border';
                            if (in_array($attachment_url, $user_fav)) {
                                $c_btn_class = 'favorited';
                                $c_icon = 'star';
                            }
                            echo '<div class="palleon-frame" data-elsource="' . $attachment_url . '">';
                            echo '<div class="palleon-img-wrap"><img class="lazy" data-src="' . $attachment_url . '" /></div>';
                            echo '<div class="frame-favorite"><button type="button" class="palleon-btn-simple star ' . $c_btn_class . '" data-frameid="' . $attachment_url . '"><span class="material-icons">' . $c_icon . '</span></button></div>';
                            echo '</div>';
                        }

                        echo '</div></div></li>';
                    }
                }
                if ($default_frames == 'enable') {
                    $frameTags = palleon_get_frame_tags();
                    foreach($frameTags as $slug => $data) {
                        echo '<li data-keyword="' . $slug . '"><a href="#">' . $data[0] . '<span class="data-count">' . $data[1] . '</span><span class="material-icons arrow">keyboard_arrow_down</span></a><div><div id="palleon-frames-grid-' . $slug . '" class="palleon-frames-grid paginated" data-perpage="' . esc_attr($perpage) . '">';
                        for ($i = 1; $i <= $data[1]; ++$i) {
                            $frameid = $slug . '/' . $i;
                            $btn_class = '';
                            $icon = 'star_border';
                            if (in_array($frameid, $user_fav)) {
                                $btn_class = 'favorited';
                                $icon = 'star';
                            }
                            echo '<div class="palleon-frame" data-elsource="' . PALLEON_SOURCE_URL . 'frames/' . $frameid . '.svg">';
                            echo '<div class="palleon-img-wrap"><div class="palleon-img-loader"></div><img class="lazy" data-src="' . PALLEON_SOURCE_URL . 'frames/' . $frameid . '.jpg" /></div>';
                            echo '<div class="frame-favorite"><button type="button" class="palleon-btn-simple star ' . $btn_class . '" data-frameid="' . $frameid . '"><span class="material-icons">' . $icon . '</span></button></div>';
                            echo '</div>';
                        }
                        echo '</div></div></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div id="palleon-frame-options" class="palleon-tab">
            <div class="palleon-control-wrap label-block">
                <div class="palleon-control">
                    <div class="palleon-btn-group icon-group">
                        <button id="palleon-rotate-right-frame" type="button" class="palleon-btn tooltip" data-title="<?php echo esc_attr__('Rotate Right', 'palleon'); ?>"><span class="material-icons">rotate_right</span></button>
                        <button id="palleon-rotate-left-frame" type="button" class="palleon-btn tooltip" data-title="<?php echo esc_attr__('Rotate Left', 'palleon'); ?>"><span class="material-icons">rotate_left</span></button>
                        <button id="palleon-flip-horizontal-frame" type="button" class="palleon-btn tooltip" data-title="<?php echo esc_attr__('Flip X', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                        <button id="palleon-flip-vertical-frame" type="button" class="palleon-btn tooltip" data-title="<?php echo esc_attr__('Flip Y', 'palleon'); ?>"><span class="material-icons">flip</span></button>
                    </div>
                </div>
            </div>
            <div id="palleon-frame-single-color" class="palleon-control-wrap label-block">
                <label class="palleon-control-label"><?php echo esc_html__('Fill Color', 'palleon'); ?></label>
                <div class="palleon-control">
                    <input id="palleon-frame-color" type="text" class="palleon-colorpicker allow-empty" autocomplete="off" value="" />
                    <div class="palleon-control-desc"><?php echo esc_html__('For single color frames only.', 'palleon'); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div id="palleon-noframes" class="notice notice-warning"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
</div>