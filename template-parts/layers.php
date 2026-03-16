<div id="palleon-toggle-right"><span class="material-icons">chevron_right</span></div>
<div id="palleon-right-col">
    <h6 class="palleon-layers-title"><span class="material-icons">layers</span><?php echo esc_html__('Layers', 'palleon'); ?></h6>
    <?php Palleon::ad_manager('layers'); ?>
    <div id="palleon-no-layer">
        <?php echo esc_html__('No layers found. You can add text, element, image etc. to the canvas to create a layer.', 'palleon'); ?>
        <a href="#" class="palleon-toggle-right"><?php echo esc_html__('Close Panel', 'palleon'); ?></a>
    </div>
    <ul id="palleon-layers"></ul>
    <?php do_action('palleon_after_layers'); ?>
    <div id="palleon-layer-delete-wrap">
        <select id="palleon-layer-select" class="palleon-select" autocomplete="off">
            <option value="all" selected><?php echo esc_html__('All Layers', 'palleon'); ?></option>
            <option value="textbox"><?php echo esc_html__('Texts', 'palleon'); ?></option>
            <option value="image"><?php echo esc_html__('Images', 'palleon'); ?></option>
            <option value="frame"><?php echo esc_html__('Frames', 'palleon'); ?></option>
            <option value="element"><?php echo esc_html__('Elements', 'palleon'); ?></option>
            <option value="circle"><?php echo esc_html__('Circles', 'palleon'); ?></option>
            <option value="ellipse"><?php echo esc_html__('Ellipses', 'palleon'); ?></option>
            <option value="square"><?php echo esc_html__('Squares', 'palleon'); ?></option>
            <option value="rectangle"><?php echo esc_html__('Rectangles', 'palleon'); ?></option>
            <option value="triangle"><?php echo esc_html__('Triangles', 'palleon'); ?></option>
            <option value="trapezoid"><?php echo esc_html__('Trapezoids', 'palleon'); ?></option>
            <option value="pentagon"><?php echo esc_html__('Pentagons', 'palleon'); ?></option>
            <option value="octagon"><?php echo esc_html__('Octagons', 'palleon'); ?></option>
            <option value="emerald"><?php echo esc_html__('Emeralds', 'palleon'); ?></option>
            <option value="star"><?php echo esc_html__('Stars', 'palleon'); ?></option>
            <option value="diamonds"><?php echo esc_html__('Diamonds', 'palleon'); ?></option>
            <option value="parallelogram"><?php echo esc_html__('Parallelograms', 'palleon'); ?></option>
            <option value="customShape"><?php echo esc_html__('Custom Shapes', 'palleon'); ?></option>
        </select>
        <button id="palleon-layer-delete" class="palleon-btn primary"><span class="material-icons">delete</span></button>
    </div>
</div>