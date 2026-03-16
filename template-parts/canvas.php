<?php
$img_url = '';
$filename = '';
$attachment_id = '';
$template = '';
if (isset($_GET['attachment_id']) && !empty($_GET['attachment_id'])) {
    $attachment_id = esc_attr($_GET['attachment_id']);
    $attachment_url = wp_get_attachment_url($attachment_id);
    if (!empty($attachment_url)) {
        $attachment_mime_type = get_post_mime_type($attachment_id);
        if ($attachment_mime_type == 'application/json') {
            $template = esc_url($attachment_url);
        } else {
            $img_url = esc_url($attachment_url);
        }
        $filename = esc_attr(get_the_title( $_GET['attachment_id'] ));
    }
} else if (isset($_GET['item_id']) && !empty($_GET['item_id'])) {
    $attachment_url = wp_get_attachment_url($_GET['item_id']);
    if (!empty($attachment_url)) {
        $attachment_mime_type = get_post_mime_type($_GET['item_id']);
        if ($attachment_mime_type == 'application/json') {
            $template = esc_url($attachment_url);
        } else {
            $img_url = esc_url($attachment_url);
        }
        $filename = esc_attr(get_the_title( $_GET['item_id'] ));
    }
} else if (isset($_GET['template_id']) && !empty($_GET['template_id'])) {
    $templates = palleon_templates();
    foreach($templates as $template) {
        if ($template[0] == $_GET['template_id']) {
            $template = $template[3];
            break;
        }
    }
} else if (isset($_GET['template_url']) && !empty($_GET['template_url'])) {
    $template = esc_url($_GET['template_url']);
} else if (isset($_GET['url']) && !empty($_GET['url'])) {
    $img_url = esc_url($_GET['url']);
}
$ruler = PalleonSettings::get_option('module_ruler', 'enable');
?>
<div id="palleon-body">
    <div class="palleon-wrap">
        <?php if (!isset($_GET['attachment_id'])) { ?>
        <div id="palleon-pages"></div>
        <?php } ?>
        <div id="palleon-ruler" class="palleon-inner-wrap">
            <?php if ($ruler == 'enable') { ?>
            <div id="palleon-ruler-icon" class="closed" title="<?php echo esc_attr__('Ruler Menu', 'palleon'); ?>"></div>
            <?php } ?>
            <div id="palleon-content">
                <div id="palleon-canvas-img-wrap">
                    <img id="palleon-canvas-img" src="<?php echo $img_url; ?>" data-filename="<?php echo $filename; ?>" data-id="<?php echo $attachment_id; ?>" data-template="<?php echo $template; ?>" />
                </div>
                <div id="palleon-canvas-wrap">
                    <div id="palleon-canvas-overlay"></div>
                    <div id="palleon-canvas-loader">
                        <div class="palleon-loader"></div>
                    </div>
                    <canvas id="palleon-canvas"></canvas>
                </div>
                <div class="palleon-content-bar">
                    <div class="palleon-img-size"><span id="palleon-img-width">0</span>px<span class="material-icons">clear</span><span id="palleon-img-height">0</span>px</div>
                    <button id="palleon-img-drag" class="palleon-btn"><span class="material-icons">pan_tool</span></button>
                    <div id="palleon-img-zoom-counter" class="palleon-counter">
                        <button id="palleon-img-zoom-out" class="counter-minus palleon-btn"><span class="material-icons">remove</span></button>
                        <input id="palleon-img-zoom" class="palleon-form-field numeric-field" type="text" value="100" autocomplete="off" data-min="10" data-max="200" data-step="5">
                        <button id="palleon-img-zoom-in" class="counter-plus palleon-btn"><span class="material-icons">add</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="palleon-canvas-selected" value="">