<?php $iconfinder = PalleonSettings::get_option('iconfinder',''); ?>
<div id="palleon-icons" class="palleon-icon-panel-content panel-hide">
<?php Palleon::ad_manager('icons'); ?>
    <div class="palleon-tabs">
    <?php if (!empty($iconfinder) && is_user_logged_in()) { ?>
        <ul class="palleon-tabs-menu">
            <li id="palleon-all-icons-open" class="active" data-target="#palleon-all-icons"><?php echo esc_html__('Icons', 'palleon'); ?></li>
            <li id="palleon-iconfinder-open" data-target="#palleon-iconfinder"><?php echo esc_html__('Iconfinder', 'palleon'); ?></li>
        </ul>
        <?php } ?>
        <div id="palleon-all-icons" class="palleon-tab active">
            <div class="palleon-control-wrap" style="margin:0px;">
                <label class="palleon-control-label"><?php echo esc_html__('Icon Style', 'palleon'); ?></label>
                <div class="palleon-control">
                    <select id="palleon-icon-style" class="palleon-select" autocomplete="off">
                        <option selected value="materialicons"><?php echo esc_html__('Filled', 'palleon'); ?></option>
                        <option value="materialiconsoutlined"><?php echo esc_html__('Outlined', 'palleon'); ?></option>
                        <option value="materialiconsround"><?php echo esc_html__('Round', 'palleon'); ?></option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="palleon-search-wrap">
                <input id="palleon-icon-search" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Enter a keyword...', 'palleon'); ?>" autocomplete="off" />
                <span id="palleon-icon-search-icon" class="material-icons">search</span>
            </div>
            <div id="palleon-icons-grid" class="palleon-grid palleon-elements-grid four-column">
            </div>
            <div id="palleon-noicons" class="notice notice-warning"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
        </div>
        <?php 
        if (!empty($iconfinder) && is_user_logged_in()) {
            $iconfinder_categories = PalleonIconfinder::get_categories();
            $iconfinder_styles = PalleonIconfinder::get_styles();
        ?>
        <div id="palleon-iconfinder" class="palleon-tab">
            <div class="palleon-search-box">
                <input id="palleon-iconfinder-keyword" type="search" class="palleon-form-field" placeholder="<?php echo esc_html__('Enter a keyword...', 'palleon'); ?>" autocomplete="off" value="" />
                <button id="palleon-iconfinder-search" type="button" class="palleon-btn primary" disabled><span class="material-icons">search</span></button>
            </div>
            <div class="iconfinder-search-settings">
                <div class="iconfinder-search-settings-left">
                    <select id="iconfinder-style" class="palleon-select" autocomplete="off">
                        <?php
                        foreach( $iconfinder_styles as $id => $key ) {
                            echo '<option value="' . esc_attr($id) . '">' . esc_html($key) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="iconfinder-search-settings-right">
                    <select id="iconfinder-category" class="palleon-select" autocomplete="off">
                        <?php
                        foreach( $iconfinder_categories as $id => $key ) {
                            echo '<option value="' . esc_attr($id) . '">' . esc_html($key) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="iconfinder-wrap">
            <?php PalleonIconfinder::curated(); ?>
            </div>
            <div id="palleon-noiconfinder" class="notice notice-warning"><?php echo esc_html__('Nothing found.', 'palleon'); ?></div>
            <a id="iconfinder-credit" href="https://www.iconfinder.com/" target="_blank"><?php echo esc_html__('Icons provided by Iconfinder', 'palleon'); ?></a>
        </div>
        <?php } ?>
    </div>
</div>