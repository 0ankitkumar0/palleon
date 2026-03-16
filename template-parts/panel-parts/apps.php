<div id="palleon-apps" class="palleon-icon-panel-content panel-hide">
    <?php Palleon::ad_manager('apps'); ?>
    <?php 
    $apps = Palleon::get_apps();
    $apps_list = Palleon::get_apps_list();

    echo '<div id="palleon-apps-menu">';
    foreach ( $apps_list as $item) {
        include_once($item);
    }
    echo '</div>';
    echo '<div id="palleon-apps-content">';
    foreach ( $apps as $app) {
        include_once($app);
    }
    echo '</div>';
    ?>


</div>