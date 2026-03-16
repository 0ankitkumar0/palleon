<?php
$frames = PalleonSettings::get_option('module_frames', 'enable');
$text = PalleonSettings::get_option('module_text', 'enable');
$image = PalleonSettings::get_option('module_image', 'enable');
$shapes = PalleonSettings::get_option('module_shapes', 'enable');
$elements = PalleonSettings::get_option('module_elements', 'enable');
$brushes = PalleonSettings::get_option('module_brushes', 'enable');
$menu_icons = Palleon::palleon_get_menu_icons();
$i = 0;
$last_key = array_search(end($menu_icons), $menu_icons);
?>
<div id="palleon-icon-menu">
    <?php
    foreach($menu_icons as $slug => $data) {
        $active = '';
        $stick = '';
        if ($i === 0) {
            $active = 'active';
        }
        if ($slug == $last_key) {
            $stick = 'stick-to-bottom';
          }
        echo '<button id="palleon-btn-' . $slug . '" type="button" class="palleon-icon-menu-btn ' . $active . ' ' . $stick . '" data-target="#palleon-' . $slug . '"><span class="material-icons">' . $data[0] . '</span><span class="palleon-icon-menu-title">' . $data[1] . '</span></button>';
        $i++;
    }
    ?>
</div>