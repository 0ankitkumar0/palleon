<?php 
$perpage = PalleonSettings::get_option('tp_pagination',21);  
$myperpage = PalleonSettings::get_option('mytp_pagination',10);
$templates = PalleonSettings::get_option('module_templates', 'enable'); 
$mytemplates = PalleonSettings::get_option('allow_json','enable');  
$frontend =  PalleonSettings::get_option('fe_editor', 'disable');
$fe_slug =  PalleonSettings::get_option('fe_slug', 'palleon');
$share =  PalleonSettings::get_option('share', 'enable');
$canvas_sizes =  PalleonSettings::get_option('blank_canvas_sizes', '');
$ml_button =  PalleonSettings::get_option('hide_ml_btns', 'show');
?>
<div id="modal-add-new" class="palleon-modal">
    <div class="palleon-modal-close" data-target="#modal-add-new"><span class="material-icons">close</span></div>
    <div class="palleon-modal-wrap">
        <div class="palleon-modal-inner large">
            <div class="palleon-tabs">
                <ul class="palleon-tabs-menu">
                    <li class="active" data-target="#modal-blank-canvas"><span class="material-icons">texture</span><?php echo esc_html__('Blank Canvas', 'palleon'); ?></li>
                   
                </ul>
                <div id="modal-blank-canvas" class="palleon-tab active">

                    

                    <div class="palleon-control-group" style="display: none;">
                        <!-- <div>
                            <label><?php echo esc_html__('Size', 'palleon'); ?></label>
                            <select id="palleon-canvas-size-select" class="palleon-select" autocomplete="off">
                                <option selected value="custom" data-width="800" data-height="800"><?php echo esc_html__('Custom', 'palleon'); ?></option>
                                <?php if (empty($canvas_sizes)) { ?>
                                <option value="" data-width="2240" data-height="1260"><?php echo esc_html__('Blog Banner', 'palleon'); ?></option>
                                <option value="" data-width="851" data-height="315"><?php echo esc_html__('Facebook Cover', 'palleon'); ?></option>
                                <option value="" data-width="1200" data-height="628"><?php echo esc_html__('Facebook Ad', 'palleon'); ?></option>
                                <option value="" data-width="1080" data-height="1080"><?php echo esc_html__('Instagram Post', 'palleon'); ?></option>
                                <option value="" data-width="750" data-height="1120"><?php echo esc_html__('Pinterest Post', 'palleon'); ?></option>
                                <option value="" data-width="940" data-height="788"><?php echo esc_html__('Facebook Post', 'palleon'); ?></option>
                                <option value="" data-width="1600" data-height="900"><?php echo esc_html__('Twitter Post', 'palleon'); ?></option>
                                <option value="" data-width="1280" data-height="720"><?php echo esc_html__('Youtube Thumbnail', 'palleon'); ?></option>
                                <option value="" data-width="1920" data-height="1080"><?php echo esc_html__('Wallpaper', 'palleon'); ?></option>
                                <?php } else if (!empty($canvas_sizes) && is_array($canvas_sizes)) {
                                    foreach ( $canvas_sizes as $key => $entry ) {
                                        $name = $width = $height = '';
                                        if ( isset( $entry['name'] ) ) {
                                            $name = esc_html( $entry['name'] );
                                        }
                                        if ( isset( $entry['width'] ) ) {
                                            $width = esc_attr( $entry['width'] );
                                        }
                                        if ( isset( $entry['height'] ) ) {
                                            $height = esc_attr( $entry['height'] );
                                        }
                                        echo '<option value="" data-width="' . $width . '" data-height="' . $height . '">' . $name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div> -->
                        <div>
                            <label><?php echo esc_html__('Width', 'palleon'); ?></label>
                            <input id="palleon-canvas-width" class="palleon-form-field" type="number" value="800" data-min="1" data-max="10000" autocomplete="off">
                        </div>
                        <div>
                            <label><?php echo esc_html__('Height', 'palleon'); ?></label>
                            <input id="palleon-canvas-height" class="palleon-form-field" type="number" value="800" data-min="1" data-max="10000" autocomplete="off">
                        </div>
                        <div>
                            <label><?php echo esc_html__('Background', 'palleon'); ?></label>
                            <input id="palleon-canvas-color" type="text" class="palleon-colorpicker allow-empty" autocomplete="off" value="" />
                        </div>
                        <div>
                            <button id="palleon-canvas-create" type="button" class="palleon-btn primary"><span class="material-icons">done</span><?php echo esc_html__('Create', 'palleon'); ?></button>
                        </div>
                    </div>


                    <div class="palleon-grid-wrap">
                        <div id="palleon-canvas-size-grid" class="palleon-grid canvas-size-grid">
                            <!--<div class="grid-item" data-width="800" data-height="800">
                                <div class="canvas-card">
                                    <span class="canvas-title"><?php //echo esc_html__('Custom', 'palleon'); ?></span>
                                    <span class="canvas-size">800x800px</span>
                                </div>
                            </div>-->
                            <?php if (empty($canvas_sizes)) { ?>
                                <div class="grid-item" data-width="2240" data-height="1260">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Blog Banner', 'palleon'); ?></span>
                                        <span class="canvas-size">2240x1260px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="851" data-height="315">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Facebook Cover', 'palleon'); ?></span>
                                        <span class="canvas-size">851x315px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="1200" data-height="628">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Facebook Ad', 'palleon'); ?></span>
                                        <span class="canvas-size">1200x628px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="1080" data-height="1080">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Instagram Post', 'palleon'); ?></span>
                                        <span class="canvas-size">1080x1080px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="750" data-height="1120">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Pinterest Post', 'palleon'); ?></span>
                                        <span class="canvas-size">750x1120px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="940" data-height="788">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Facebook Post', 'palleon'); ?></span>
                                        <span class="canvas-size">940x788px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="1600" data-height="900">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Twitter Post', 'palleon'); ?></span>
                                        <span class="canvas-size">1600x900px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="1280" data-height="720">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Youtube Thumbnail', 'palleon'); ?></span>
                                        <span class="canvas-size">1280x720px</span>
                                    </div>
                                </div>
                                <div class="grid-item" data-width="1920" data-height="1080">
                                    <div class="canvas-card">
                                        <span class="canvas-title"><?php echo esc_html__('Wallpaper', 'palleon'); ?></span>
                                        <span class="canvas-size">1920x1080px</span>
                                    </div>
                                </div>
                            <?php } else if (!empty($canvas_sizes) && is_array($canvas_sizes)) {
                                foreach ( $canvas_sizes as $key => $entry ) {
                                    $name = $width = $height = '';
                                    if ( isset( $entry['name'] ) ) {
                                        $name = esc_html( $entry['name'] );
                                    }
                                    if ( isset( $entry['width'] ) ) {
                                        $width = esc_attr( $entry['width'] );
                                    }
                                    if ( isset( $entry['height'] ) ) {
                                        $height = esc_attr( $entry['height'] );
                                    }
                                    echo '<div class="grid-item" data-width="' . $width . '" data-height="' . $height . '"><div class="canvas-card"><span class="canvas-title">' . $name . '</span><span class="canvas-size">' . $width . 'x' . $height . 'px</span></div></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php Palleon::ad_manager('blank-canvas'); ?>
                </div>
                <?php if ($templates == 'enable') { ?>
                <div id="modal-template-library" class="palleon-tab" style="display:none;">
                    <div class="palleon-templates-wrap">
                        <div class="palleon-tabs">
                            <ul class="palleon-tabs-menu">
                                <li class="active" data-target="#palleon-all-templates"><?php echo esc_html__('All', 'palleon'); ?></li>
                                <?php if (is_user_logged_in()) { ?>
                                <li data-target="#palleon-templates-favorites"><?php echo esc_html__('My Favorites', 'palleon'); ?></li>
                                <?php } ?>
                                <?php if ($mytemplates == 'enable' && is_user_logged_in()) { ?>
                                <li data-target="#palleon-my-templates-tab"><?php echo esc_html__('My Templates', 'palleon'); ?></li>
                                <?php } ?>
                            </ul>
                            <div id="palleon-all-templates" class="palleon-tab active">
                                <div class="palleon-templates-menu-wrap">
                                    <input id="palleon-template-search-keyword" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search by keyword...', 'palleon'); ?>" autocomplete="off" />
                                    <select id="palleon-templates-menu" class="palleon-select palleon-select2" autocomplete="off">
                                        <option value="all" selected><?php echo esc_html__('All Tags', 'palleon') . ' (' . palleon_get_template_count() . ')'; ?></option>
                                        <?php 
                                        $getTags = palleon_get_template_tags();
                                        foreach($getTags as $slug => $name) {
                                            echo '<option value="' . esc_attr($slug) . '">' . esc_html($name) . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <button id="palleon-template-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                                </div>
                                <div class="palleon-templates-content">
                                    <div class="palleon-grid-wrap">
                                        <div id="palleon-templates-grid" class="palleon-grid template-grid template-selection paginated" data-perpage="<?php echo esc_attr($perpage); ?>">
                                            <?php 
                                            $user_fav = get_user_meta(get_current_user_id(), 'palleon_template_fav',true);
                                            if (empty($user_fav)) {
                                                $user_fav = array();
                                            }
                                            $getTemplates = palleon_get_templates(false);
                                            foreach($getTemplates as $template) { 
                                            $btn_class = '';
                                            $icon = 'star_border';
                                            if (in_array($template[0], $user_fav)) {
                                                $btn_class = 'favorited';
                                                $icon = 'star';
                                            }
                                            $template_version = 'free';
                                            if (isset($template[5])) {
                                                $template_version = $template[5]; 
                                            }
                                            ?>
                                            <div class="grid-item">
                                                <?php if ($template_version == 'pro') { ?>
                                                <div class="template-pro"><span class="material-icons">workspace_premium</span></div>
                                                <?php } ?>
                                                <div class="template-favorite"><button type="button" class="palleon-btn-simple star <?php echo esc_attr($btn_class); ?>" data-templateid="<?php echo esc_attr($template[0]); ?>"><span class="material-icons"><?php echo esc_html($icon); ?></span></button></div>
                                                <div class="palleon-masonry-item-inner palleon-select-template" data-json="<?php echo esc_url($template[3]); ?>" data-version="<?php echo esc_attr($template_version); ?>">
                                                    <div class="palleon-img-wrap">
                                                        <div class="palleon-img-loader"></div>
                                                        <img class="lazy" data-src="<?php echo esc_url($template[2]); ?>" data-title="<?php echo esc_attr($template[1]); ?>" data-preview="<?php echo esc_url($template[6]); ?>" />
                                                    </div>
                                                    <div class="palleon-masonry-item-desc">
                                                    <?php echo esc_html($template[1]); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        
                                        <!-- Contenedor de paginación -->
                                        <div id="palleon-pagination-container" class="palleon-pagination-wrap" style="display: none;">
                                            <div class="palleon-pagination">
                                                <!-- La paginación se generará dinámicamente aquí -->
                                            </div>
                                            <div class="palleon-pagination-info">
                                                <!-- La información de paginación se mostrará aquí -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (is_user_logged_in()) { ?>
                            <div id="palleon-templates-favorites" class="palleon-tab">
                                <div id="palleon-templates-favorites-grid" class="palleon-grid template-grid template-selection paginated" data-perpage="<?php echo esc_attr($perpage); ?>">
                                    <?php 
                                    $templates = palleon_get_templates(false);
                                    $user_fav = get_user_meta(get_current_user_id(), 'palleon_template_fav',true);
                                    if (!empty($user_fav)) {
                                        foreach($templates as $template) { 
                                            if (in_array($template[0], $user_fav)) { 
                                                $template_version = 'free';
                                                if (isset($template[5])) {
                                                    $template_version = $template[5]; 
                                                }
                                            ?>
                                            <div class="grid-item">
                                                <?php if ($template_version == 'pro') { ?>
                                                <div class="template-pro"><span class="material-icons">workspace_premium</span></div>
                                                <?php } ?>
                                                <div class="template-favorite"><button type="button" class="palleon-btn-simple star favorited" data-templateid="<?php echo esc_url($template[0]); ?>"><span class="material-icons">star</span></button></div>
                                                <div class="palleon-masonry-item-inner palleon-select-template" data-json="<?php echo esc_url($template[3]); ?>" data-version="<?php echo esc_attr($template_version); ?>">
                                                    <div class="palleon-img-wrap">
                                                        <div class="palleon-img-loader"></div>
                                                        <img class="lazy" data-src="<?php echo esc_url($template[2]); ?>" data-title="<?php echo esc_attr($template[1]); ?>" data-preview="<?php echo esc_url($template[6]); ?>" />
                                                    </div>
                                                    <div class="palleon-masonry-item-desc">
                                                    <?php echo esc_html($template[1]); ?>
                                                    </div>
                                                </div>
                                            </div>  
                                        <?php }
                                        }
                                    } else {
                                        echo '<div class="notice notice-info"><h6>' . esc_html__( 'No favorites yet', 'palleon' ) . '</h6>' . esc_html__('Click the star icon on any template, and you will see it here next time you visit.', 'palleon') . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php } ?>
                    <?php if ($mytemplates == 'enable' && is_user_logged_in()) { ?>
                    <div id="palleon-my-templates-tab" class="palleon-tab">
                    <div id="palleon-my-templates-menu">
                        <div class="palleon-search-box">
                            <input type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Search by title...', 'palleon'); ?>" autocomplete="off" />
                            <button id="palleon-my-templates-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                        </div>
                    </div>
                    <ul id="palleon-my-templates" class="palleon-template-list template-selection paginated" data-perpage="<?php echo esc_attr($myperpage); ?>"></ul>
                    <div id="palleon-my-templates-noimg" class="notice notice-warning d-none"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
                </div>    
                <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php do_action('palleon_add_new_tab'); ?>
            </div>
        </div>
    </div>
</div>
<!-- Grid visual de medidas debajo del selector -->
<div class="palleon-grid-wrap" style="margin-top:16px;">
    <div id="palleon-canvas-size-grid" class="palleon-grid canvas-size-grid">
        <?php
        // Recorrer las opciones del selector y mostrarlas como cards
        // Esto asegura que todas las opciones del selector estén reflejadas en las cards
        if (empty($canvas_sizes)) {
            $preset = [
                ['name' => esc_html__('Custom', 'palleon'), 'width' => 800, 'height' => 800],
                ['name' => esc_html__('Blog Banner', 'palleon'), 'width' => 2240, 'height' => 1260],
                ['name' => esc_html__('Facebook Cover', 'palleon'), 'width' => 851, 'height' => 315],
                ['name' => esc_html__('Facebook Ad', 'palleon'), 'width' => 1200, 'height' => 628],
                ['name' => esc_html__('Instagram Post', 'palleon'), 'width' => 1080, 'height' => 1080],
                ['name' => esc_html__('Pinterest Post', 'palleon'), 'width' => 750, 'height' => 1120],
                ['name' => esc_html__('Facebook Post', 'palleon'), 'width' => 940, 'height' => 788],
                ['name' => esc_html__('Twitter Post', 'palleon'), 'width' => 1600, 'height' => 900],
                ['name' => esc_html__('Youtube Thumbnail', 'palleon'), 'width' => 1280, 'height' => 720],
                ['name' => esc_html__('Wallpaper', 'palleon'), 'width' => 1920, 'height' => 1080],
            ];
            foreach ($preset as $opt) {
                echo '<div class="grid-item" data-width="' . esc_attr($opt['width']) . '" data-height="' . esc_attr($opt['height']) . '"><div class="canvas-card"><span class="canvas-title">' . $opt['name'] . '</span><span class="canvas-size">' . esc_html($opt['width']) . 'x' . esc_html($opt['height']) . 'px</span></div></div>';
            }
        } else if (!empty($canvas_sizes) && is_array($canvas_sizes)) {
            // Custom dinámico
            echo '<div class="grid-item" data-width="800" data-height="800"><div class="canvas-card"><span class="canvas-title">' . esc_html__('Custom', 'palleon') . '</span><span class="canvas-size">800x800px</span></div></div>';
            foreach ($canvas_sizes as $entry) {
                $name = isset($entry['name']) ? esc_html($entry['name']) : '';
                $width = isset($entry['width']) ? esc_attr($entry['width']) : '';
                $height = isset($entry['height']) ? esc_attr($entry['height']) : '';
                echo '<div class="grid-item" data-width="' . $width . '" data-height="' . $height . '"><div class="canvas-card"><span class="canvas-title">' . $name . '</span><span class="canvas-size">' . $width . 'x' . $height . 'px</span></div></div>';
            }
        }
        ?>
    </div>
</div>
<script>
;(function(){
    'use strict';

    function adjustCardHeight(element) {
        if (!element.isConnected || !element.parentElement) return;
        const currentWidth = element.offsetWidth;
        const aspectRatio = parseFloat(element.dataset.aspectRatio);
        if (currentWidth > 0 && aspectRatio > 0 && !isNaN(aspectRatio)) {
            element.style.height = `${currentWidth / aspectRatio}px`;
        } else if (currentWidth > 0) {
            element.style.height = `${currentWidth}px`;
        }
    }

    const cardResizeObserver = new ResizeObserver(entries => {
        for (const entry of entries) {
            requestAnimationFrame(() => adjustCardHeight(entry.target));
        }
    });

    function initializeCard(cardElement) {
        const w = parseInt(cardElement.dataset.width, 10);
        const h = parseInt(cardElement.dataset.height, 10);
        if (isNaN(w) || isNaN(h) || w <= 0 || h <= 0) {
            return;
        }
        cardElement.dataset.aspectRatio = w / h;
        cardResizeObserver.observe(cardElement);
        requestAnimationFrame(() => adjustCardHeight(cardElement));
    }

    function attemptGridInitialization() {
        const gridItems = document.querySelectorAll('#palleon-canvas-size-grid .grid-item');
        if (gridItems.length === 0) {
            requestAnimationFrame(attemptGridInitialization);
            return;
        }
        gridItems.forEach(item => initializeCard(item));
    }

    function initOnReady() {
        attemptGridInitialization();

        document.querySelectorAll('#palleon-canvas-size-grid .grid-item').forEach(item => {
            item.addEventListener('click', function() {
                const width = this.getAttribute('data-width');
                const height = this.getAttribute('data-height');
                document.getElementById('palleon-canvas-width').value = width;
                document.getElementById('palleon-canvas-height').value = height;
                document.querySelectorAll('#palleon-canvas-size-grid .grid-item')
                    .forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');

                loadAllTemplatesAjax(width, height);
                document.getElementById('palleon-canvas-selected').value = width + 'x' + height;
                document.getElementById('palleon-canvas-create').click()
            });
        });

        window.addEventListener('load', () => {
            document.querySelectorAll('#palleon-canvas-size-grid .grid-item')
                .forEach(item => requestAnimationFrame(() => adjustCardHeight(item)));
        });
    }

    function loadAllTemplatesAjax(width, height, page = 1) {
        const templatesGrid = document.getElementById('palleon-templates-grid');
        if (!templatesGrid) return;
        
        templatesGrid.innerHTML = '<div class="palleon-templates-loader"><div class="palleon-loader"></div><p>Cargando templates...</p></div>';
        
        const formData = new FormData();
        formData.append('action', 'templateSearch');
        formData.append('nonce', '<?php echo wp_create_nonce('palleon-nonce'); ?>');
        formData.append('dimensions', width + 'x' + height);
        formData.append('keyword', '');
        formData.append('category', 'all');
        formData.append('page', page);

        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (templatesGrid && data.success) {
                templatesGrid.innerHTML = data.html;
                
                updatePaginationControls(data.pagination, width, height);
            } 
            else {
                templatesGrid.innerHTML = '<div class="notice notice-warning"><h6>No se encontraron templates</h6></div>';
                const paginationContainer = document.getElementById('templates-pagination');
                if (paginationContainer) {
                    paginationContainer.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error cargando templates:', error);
            if (templatesGrid) {
                templatesGrid.innerHTML = '<div class="notice notice-error"><h6>Error cargando templates</h6></div>';
            }
        });
    }

    function generatePaginationRange(current, total, delta = 2) {
        const range = [];
        
        if (total <= 7) {
            for (let i = 1; i <= total; i++) {
                range.push(i);
            }
            return range;
        }
        
        let start = Math.max(1, current - delta);
        let end = Math.min(total, current + delta);
        
        if (end - start < 4) {
            if (start === 1) {
                end = Math.min(total, start + 4);
            } else if (end === total) {
                start = Math.max(1, end - 4);
            }
        }
        
        if (start > 2) {
            range.push(1);
            if (start > 3) range.push('...');
        }
        
        for (let i = start; i <= end; i++) {
            range.push(i);
        }
        
        if (end < total - 1) {
            if (end < total - 2) range.push('...');
            range.push(total);
        }
        
        return range;
    }

    function updatePaginationControls(pagination, width, height) {
        let paginationContainer = document.getElementById('templates-pagination');
        if (!paginationContainer) {
            paginationContainer = document.createElement('div');
            paginationContainer.id = 'templates-pagination';
            paginationContainer.className = 'palleon-pagination-wrap';
            paginationContainer.style.display = 'none';
            
            const templatesGrid = document.getElementById('palleon-templates-grid');
            if (templatesGrid && templatesGrid.parentNode) {
                templatesGrid.parentNode.insertBefore(paginationContainer, templatesGrid.nextSibling);
            }
        }

        if (pagination.total_pages <= 1) {
            paginationContainer.style.display = 'none';
            return;
        }

        let paginationHTML = '<div class="palleon-pagination">';
        
        paginationHTML += '<div class="palleon-pagination-numbers">';
        
        const pageRange = generatePaginationRange(pagination.current_page, pagination.total_pages);
        
        pageRange.forEach(item => {
            if (item === '...') {
                paginationHTML += '<span class="palleon-pagination-dots">...</span>';
            } else {
                const activeClass = item === pagination.current_page ? ' active' : '';
                paginationHTML += '<button class="palleon-btn palleon-pagination-number' + activeClass + '" data-page="' + item + '">' + item + '</button>';
            }
        });
        
        paginationHTML += '</div>';
        
        paginationHTML += '<div class="palleon-pagination-navigation">';
        
        const prevDisabled = !pagination.has_prev ? ' disabled' : '';
        paginationHTML += '<button class="palleon-btn palleon-pagination-btn" data-page="prev" data-target-page="' + (pagination.current_page - 1) + '"' + prevDisabled + '>';
        paginationHTML += '<span class="material-icons">chevron_left</span>Anterior</button>';
        
        const nextDisabled = !pagination.has_next ? ' disabled' : '';
        paginationHTML += '<button class="palleon-btn palleon-pagination-btn" data-page="next" data-target-page="' + (pagination.current_page + 1) + '"' + nextDisabled + '>';
        paginationHTML += 'Siguiente<span class="material-icons">chevron_right</span></button>';
        
        paginationHTML += '</div>';
        
        paginationHTML += '</div>';
        
        const startItem = ((pagination.current_page - 1) * pagination.per_page) + 1;
        const endItem = Math.min(pagination.current_page * pagination.per_page, pagination.total_items);
        paginationHTML += '<div class="palleon-pagination-info">Mostrando ' + startItem + '-' + endItem + ' de ' + pagination.total_items + ' templates</div>';
        
        paginationContainer.innerHTML = paginationHTML;
        paginationContainer.style.display = 'block';
        
        paginationContainer.dataset.currentWidth = width;
        paginationContainer.dataset.currentHeight = height;
    }

    window.loadAllTemplatesAjax = loadAllTemplatesAjax;

    document.addEventListener('click', function(e) {
        if (e.target.matches('.palleon-pagination-number, .palleon-pagination-btn')) {
            e.preventDefault();
            
            if (e.target.classList.contains('disabled')) {
                return;
            }
            
            const paginationContainer = document.getElementById('templates-pagination');
            if (!paginationContainer) return;
            
            const width = paginationContainer.dataset.currentWidth;
            const height = paginationContainer.dataset.currentHeight;
            
            if (!width || !height) return;
            
            let targetPage;
            if (e.target.dataset.page === 'prev' || e.target.dataset.page === 'next') {
                targetPage = e.target.dataset.targetPage;
            } else {
                targetPage = e.target.dataset.page;
            }
            
            if (targetPage) {
                loadAllTemplatesAjax(parseInt(width), parseInt(height), parseInt(targetPage));
            }
        }
    });


    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initOnReady);
    } else {
        initOnReady();
    }
})();
</script>