<div id="palleon-icon-panel">
    <div id="palleon-icon-panel-inner">
    <?php
    do_action('palleon_before_panels');
    $panel_parts = Palleon::get_panel_parts();
    foreach ( $panel_parts as $part => $part_url) {
        include_once($part_url);
    }
    do_action('palleon_after_panels');
    ?>
    </div>
</div>
<div id="palleon-toggle-left"><span class="material-icons">chevron_left</span></div>