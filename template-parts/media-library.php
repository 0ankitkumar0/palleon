<?php
$perpage = PalleonSettings::get_option('ml_pagination',18); 
$other_images = PalleonSettings::get_option('other_images','enable'); 
$pexels = PalleonSettings::get_option('pexels','');
$pixabay = PalleonSettings::get_option('pixabay','');
$share = PalleonSettings::get_option('share','enable');
$allow_img = PalleonSettings::get_option('allow_img','enable');  
?>
<div id="modal-media-library" class="palleon-modal">
    <div class="palleon-modal-close" data-target="#modal-media-library"><span class="material-icons">close</span></div>
    <div id="palleon-modal-onstart"><span class="material-icons">keyboard_return</span></div>
    <div class="palleon-modal-wrap">
        <div class="palleon-modal-inner">
            <div class="palleon-tabs">
                <ul id="palleon-media-library-main-menu" class="palleon-tabs-menu">
                    <?php if ($allow_img == 'enable' || current_user_can('administrator')) { ?>
                    <li data-target="#media-library-images"><?php echo esc_html__('Media Library', 'palleon'); ?></li>
                    <?php } ?>
                    <?php do_action('palleon_media_library_tab'); ?>
                    <?php if (!empty($pexels)) { ?>
                    <li data-target="#pexels"><?php echo esc_html__('Pexels', 'palleon'); ?></li>
                    <?php } ?>
                    <?php if (!empty($pixabay)) { ?>
                    <li data-target="#pixabay"><?php echo esc_html__('Pixabay', 'palleon'); ?></li>
                    <?php } ?>
                </ul>
                <?php if ($allow_img == 'enable' || current_user_can('administrator')) { ?>
                <div id="media-library-images" class="palleon-tab">
                    <div class="palleon-tabs">
                        <?php if ($other_images != 'disable') { ?>
                        <ul class="palleon-tabs-menu">
                            <li data-target="#library-my-images" class="active"><?php echo esc_html__('My Images', 'palleon'); ?></li>
                            <li data-target="#library-all-images"><?php echo esc_html__('Other Images', 'palleon'); ?></li>
                        </ul>
                        <?php } ?>
                        <div id="library-my-images" class="palleon-tab active">
                            <div id="palleon-library-my-menu">
                                <div>
                                    <form id="palleon-library-upload-img-wrap" class="uploadImgToLibrary" enctype="multipart/form-data">
                                        <div class="palleon-file-field">
                                            <input type="file" name="palleon-library-upload-img" id="palleon-library-upload-img" class="palleon-hidden-file" accept="image/png, image/jpeg, image/webp" />
                                            <label for="palleon-library-upload-img" class="palleon-btn primary"><span class="material-icons">upload</span><span><?php echo esc_html__('Upload Image', 'palleon'); ?></span></label>
                                        </div>
                                    </form>
                                    <button id="palleon-library-my-refresh" type="button" class="palleon-btn primary"><span class="material-icons">refresh</span><?php echo esc_html__('Refresh', 'palleon'); ?></button>
                                </div>
                                <div class="palleon-search-box">
                                    <input type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search by title...', 'palleon'); ?>" autocomplete="off" />
                                    <button id="palleon-library-my-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                                </div>
                            </div>
                            <div id="palleon-library-my" class="palleon-grid media-library-grid paginated" data-perpage="<?php echo esc_attr($perpage); ?>">
                                <?php 
                                $my_images_args = array(
                                    'post_type'      => 'attachment',
                                    'post_mime_type' => 'image/png, image/jpeg, image/webp',
                                    'post_status'    => 'inherit',
                                    'posts_per_page' => - 1,
                                    'author' => get_current_user_id(),
                                    'relation' => 'OR',
                                    'meta_query' => array(
                                        array(
                                        'key' => 'palleon_hide',
                                        'compare' => 'NOT EXISTS'
                                        ),
                                    )
                                );  
                                $my_images = new WP_Query( $my_images_args );
                                if($my_images->have_posts()) {
                                foreach ( $my_images->posts as $image ) { 
                                    $id = $image->ID;
                                    $thumb = wp_get_attachment_image_url($id, 'thumbnail', false);
                                    $full = wp_get_attachment_image_url($id, 'full', false);
                                    $title = get_the_title($id);
                                ?>
                                <div class="palleon-masonry-item" data-keyword="<?php echo esc_attr(strtolower($title)); ?>">
                                    <?php if ($share == 'enable') { ?>
                                    <div class="palleon-library-share" data-url="<?php echo esc_url($full); ?>"><span class="material-icons">share</span></div>
                                    <?php } ?>
                                    <div class="palleon-library-delete" data-target="<?php echo esc_attr($id); ?>"><span class="material-icons">remove</span></div>
                                    <div class="palleon-masonry-item-inner">
                                        <div class="palleon-img-wrap">
                                            <div class="palleon-img-loader"></div>
                                            <img class="lazy" data-src="<?php echo esc_url($thumb); ?>" data-full="<?php echo esc_url($full); ?>" data-id="<?php echo esc_attr($id); ?>" data-filename="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" />
                                        </div>
                                        <?php if (!empty($title)) { ?>
                                        <div class="palleon-masonry-item-desc">
                                            <?php echo esc_html($title); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php }} ?>
                            </div>
                            <div id="palleon-library-my-noimg" class="notice notice-warning <?php if($my_images->have_posts()) { echo 'd-none'; } ?>"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
                            <script>
                            /* <![CDATA[ */
                            var libraryMyRefresh = {
                                'posts':'<?php echo json_encode( $my_images->query_vars ); ?>'
                            };
                            /* ]]> */
                            </script>
                            <?php wp_reset_postdata(); ?>
                        </div>
                        <?php if ($other_images != 'disable') { ?>
                        <div id="library-all-images" class="palleon-tab">
                            <div id="palleon-library-all-menu">
                                <div>
                                    <button id="palleon-library-all-refresh" type="button" class="palleon-btn primary"><span class="material-icons">refresh</span><?php echo esc_html__('Refresh', 'palleon'); ?></button>
                                </div>
                                <div class="palleon-search-box">
                                    <input type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search by title...', 'palleon'); ?>" autocomplete="off" />
                                    <button id="palleon-library-all-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                                </div>
                            </div>
                            <div id="palleon-library-all" class="palleon-grid media-library-grid paginated" data-perpage="<?php echo esc_attr($perpage); ?>">
                                <?php 
                                $query_images_args = array(
                                    'post_type'      => 'attachment',
                                    'post_mime_type' => 'image/png, image/jpeg, image/webp',
                                    'post_status'    => 'inherit',
                                    'posts_per_page' => - 1,
                                    'author__not_in' => get_current_user_id(),
                                    'relation' => 'OR',
                                    'meta_query' => array(
                                        array(
                                        'key' => 'palleon_hide',
                                        'compare' => 'NOT EXISTS'
                                        ),
                                    )
                                );  
                                $query_images = new WP_Query( $query_images_args );
                                if($query_images->have_posts()) {
                                foreach ( $query_images->posts as $image ) { 
                                    $id = $image->ID;
                                    $thumb = wp_get_attachment_image_url($id, 'thumbnail', false);
                                    $full = wp_get_attachment_image_url($id, 'full', false);
                                    $title = get_the_title($id);
                                ?>
                                <div class="palleon-masonry-item" data-keyword="<?php echo esc_attr(strtolower($title)); ?>">
                                    <?php if ($share == 'enable') { ?>
                                    <div class="palleon-library-share" data-url="<?php echo esc_url($full); ?>"><span class="material-icons">share</span></div>
                                    <?php } ?>
                                    <div class="palleon-masonry-item-inner">
                                        <div class="palleon-img-wrap">
                                            <div class="palleon-img-loader"></div>
                                            <img class="lazy" data-src="<?php echo esc_url($thumb); ?>" data-full="<?php echo esc_url($full); ?>" data-id="<?php echo esc_attr($id); ?>" data-filename="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" />
                                        </div>
                                        <?php if (!empty($title)) { ?>
                                        <div class="palleon-masonry-item-desc">
                                            <?php echo esc_html($title); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php }} ?>
                            </div>
                            <div id="palleon-library-all-noimg" class="notice notice-warning <?php if($query_images->have_posts()) { echo 'd-none'; } ?>"><strong><?php echo esc_html__('Nothing found.', 'palleon'); ?></strong></div>
                            <script>
                            /* <![CDATA[ */
                            var libraryAllRefresh = {
                                'posts':'<?php echo json_encode( $query_images->query_vars ); ?>'
                            };
                            /* ]]> */
                            </script>
                            <?php wp_reset_postdata(); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <?php do_action('palleon_media_library_tab_content'); ?>
                <?php if (!empty($pexels)) { ?>
                <div id="pexels" class="palleon-tab">
                    <div id="pexels-menu">
                        <div id="pexels-search-options">
                            <select id="pexels-orientation" class="palleon-select" autocomplete="off" disabled>
                                <option value="" selected><?php echo esc_html__('All Orientations', 'palleon'); ?></option>
                                <option value="landscape"><?php echo esc_html__('Landscape', 'palleon'); ?></option>
                                <option value="portrait"><?php echo esc_html__('Portrait', 'palleon'); ?></option>
                                <option value="square"><?php echo esc_html__('Square', 'palleon'); ?></option>
                            </select>
                            <select id="pexels-color" class="palleon-select" autocomplete="off" disabled>
                                <option value="" selected><?php echo esc_html__('All Colors', 'palleon'); ?></option>
                                <option value="white"><?php echo esc_html__('White', 'palleon'); ?></option>
                                <option value="black"><?php echo esc_html__('Black', 'palleon'); ?></option>
                                <option value="gray"><?php echo esc_html__('Gray', 'palleon'); ?></option>
                                <option value="brown"><?php echo esc_html__('Brown', 'palleon'); ?></option>
                                <option value="blue"><?php echo esc_html__('Blue', 'palleon'); ?></option>
                                <option value="turquoise"><?php echo esc_html__('Turquoise', 'palleon'); ?></option>
                                <option value="red"><?php echo esc_html__('Red', 'palleon'); ?></option>
                                <option value="violet"><?php echo esc_html__('Violet', 'palleon'); ?></option>
                                <option value="pink"><?php echo esc_html__('Pink', 'palleon'); ?></option>
                                <option value="orange"><?php echo esc_html__('Orange', 'palleon'); ?></option>
                                <option value="yellow"><?php echo esc_html__('Yellow', 'palleon'); ?></option>
                                <option value="green"><?php echo esc_html__('Green', 'palleon'); ?></option>
                            </select>
                        </div>
                        <div class="palleon-search-box">
                            <input id="palleon-pexels-keyword" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Enter a keyword...', 'palleon'); ?>" autocomplete="off" />
                            <button id="palleon-pexels-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                        </div>
                    </div>
                    <div id="pexels-output">
                        <?php PalleonPexels::curated(); ?>
                    </div>
                    <a id="pexels-credit" href="https://www.pexels.com/" target="_blank"><?php echo esc_html__('Photos provided by Pexels', 'palleon'); ?></a>
                </div>
                <?php } ?>
                <?php if (!empty($pixabay)) { ?>
                <div id="pixabay" class="palleon-tab">
                    <div id="pixabay-menu">
                        <div id="pixabay-search-options">
                            <select id="pixabay-orientation" class="palleon-select" autocomplete="off">
                                <option value="" selected><?php echo esc_html__('All Orientations', 'palleon'); ?></option>
                                <option value="horizontal"><?php echo esc_html__('Horizontal', 'palleon'); ?></option>
                                <option value="vertical"><?php echo esc_html__('Vertical', 'palleon'); ?></option>
                            </select>
                            <select id="pixabay-color" class="palleon-select" autocomplete="off">
                                <option value="" selected><?php echo esc_html__('All Colors', 'palleon'); ?></option>
                                <option value="white"><?php echo esc_html__('White', 'palleon'); ?></option>
                                <option value="black"><?php echo esc_html__('Black', 'palleon'); ?></option>
                                <option value="gray"><?php echo esc_html__('Gray', 'palleon'); ?></option>
                                <option value="grayscale"><?php echo esc_html__('Grayscale', 'palleon'); ?></option>
                                <option value="brown"><?php echo esc_html__('Brown', 'palleon'); ?></option>
                                <option value="blue"><?php echo esc_html__('Blue', 'palleon'); ?></option>
                                <option value="turquoise"><?php echo esc_html__('Turquoise', 'palleon'); ?></option>
                                <option value="red"><?php echo esc_html__('Red', 'palleon'); ?></option>
                                <option value="lilac"><?php echo esc_html__('Lilac', 'palleon'); ?></option>
                                <option value="pink"><?php echo esc_html__('Pink', 'palleon'); ?></option>
                                <option value="orange"><?php echo esc_html__('Orange', 'palleon'); ?></option>
                                <option value="yellow"><?php echo esc_html__('Yellow', 'palleon'); ?></option>
                                <option value="green"><?php echo esc_html__('Green', 'palleon'); ?></option>
                            </select>
                            <select id="pixabay-category" class="palleon-select" autocomplete="off">
                                <option value="" selected><?php echo esc_html__('All Categories', 'palleon'); ?></option>
                                <option value="backgrounds"><?php echo esc_html__('Backgrounds', 'palleon'); ?></option>
                                <option value="fashion"><?php echo esc_html__('Fashion', 'palleon'); ?></option>
                                <option value="nature"><?php echo esc_html__('Nature', 'palleon'); ?></option>
                                <option value="science"><?php echo esc_html__('Science', 'palleon'); ?></option>
                                <option value="education"><?php echo esc_html__('Education', 'palleon'); ?></option>
                                <option value="feelings"><?php echo esc_html__('Feelings', 'palleon'); ?></option>
                                <option value="health"><?php echo esc_html__('Health', 'palleon'); ?></option>
                                <option value="people"><?php echo esc_html__('People', 'palleon'); ?></option>
                                <option value="religion"><?php echo esc_html__('Religion', 'palleon'); ?></option>
                                <option value="places"><?php echo esc_html__('Places', 'palleon'); ?></option>
                                <option value="animals"><?php echo esc_html__('Animals', 'palleon'); ?></option>
                                <option value="industry"><?php echo esc_html__('Industry', 'palleon'); ?></option>
                                <option value="computer"><?php echo esc_html__('Computer', 'palleon'); ?></option>
                                <option value="food"><?php echo esc_html__('Food', 'palleon'); ?></option>
                                <option value="sports"><?php echo esc_html__('Sports', 'palleon'); ?></option>
                                <option value="transportation"><?php echo esc_html__('Transportation', 'palleon'); ?></option>
                                <option value="travel"><?php echo esc_html__('Travel', 'palleon'); ?></option>
                                <option value="buildings"><?php echo esc_html__('Buildings', 'palleon'); ?></option>
                                <option value="business"><?php echo esc_html__('Business', 'palleon'); ?></option>
                                <option value="music"><?php echo esc_html__('Music', 'palleon'); ?></option>
                            </select>
                        </div>
                        <div class="palleon-search-box">
                            <input id="palleon-pixabay-keyword" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Enter a keyword...', 'palleon'); ?>" autocomplete="off" />
                            <button id="palleon-pixabay-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                        </div>
                    </div>
                    <div id="pixabay-output">
                        <?php PalleonPixabay::curated(); ?>
                    </div>
                    <a id="pixabay-credit" href="https://www.pixabay.com/" target="_blank"><?php echo esc_html__('Photos provided by Pixabay', 'palleon'); ?></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>    