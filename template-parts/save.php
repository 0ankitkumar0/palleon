<?php 
$templates = PalleonSettings::get_option('module_templates', 'enable'); 
$mytemplates = PalleonSettings::get_option('allow_json','enable');
$share = PalleonSettings::get_option('share','enable');
$allow_img = PalleonSettings::get_option('allow_img','enable'); 
$allow_save = PalleonSettings::get_option('allow_save','enable'); 
?>
<div id="modal-save" class="palleon-modal">
    <div class="palleon-modal-close" data-target="#modal-save"><span class="material-icons">close</span></div>
    <div class="palleon-modal-wrap">
        <div class="palleon-modal-inner">
            <div class="palleon-tabs">
                <ul class="palleon-tabs-menu">
                    <?php if (is_user_logged_in() && ($allow_save == 'enable' || current_user_can('administrator'))) { ?>
                    <li class="active" data-target="#modal-tab-save"><span class="material-icons">save</span><?php echo esc_html__('Save', 'palleon'); ?></li>
                    <?php } ?>
                    <li <?php if (!is_user_logged_in() || (is_user_logged_in() && ($allow_save == 'disable' && !current_user_can('administrator')))) { echo 'class="active"'; } ?> data-target="#modal-tab-download"><span class="material-icons">download</span><?php echo esc_html__('Download', 'palleon'); ?></li>
                </ul>
                <?php if (is_user_logged_in() && ($allow_save == 'enable' || current_user_can('administrator'))) { ?>
                <div id="modal-tab-save" class="palleon-tab active">
                    <?php if ($allow_img == 'enable' || current_user_can('administrator')) { ?>
                    <div id="palleon-save-as-img">
                        <div class="palleon-block-50">
                            <div>
                                <label><?php echo esc_html__('File Name', 'palleon'); ?></label>
                                <input id="palleon-save-img-name" class="palleon-form-field palleon-file-name" type="text" value="" autocomplete="off" data-default="">
                            </div>
                            <button id="palleon-save-img" type="button" class="palleon-btn primary"><span class="material-icons">save</span><?php echo esc_html__('Save As Image', 'palleon'); ?></button>
                        </div>
                        <div class="palleon-block-33">
                            <div>
                                <label><?php echo esc_html__('DPI', 'palleon'); ?></label>
                                <select id="palleon-save-img-dpi" class="palleon-select" autocomplete="off">
                                    <option selected value="72">72 DPI - <?php echo esc_html__('Monitor Resolution', 'palleon'); ?></option>
                                    <option value="96">96 DPI</option>
                                    <option value="144">144 DPI</option>
                                    <option value="300">300 DPI - <?php echo esc_html__('Printer Resolution', 'palleon'); ?></option>
                                    <option value="600">600 DPI</option>
                                </select>
                            </div>
                            <div>
                                <label><?php echo esc_html__('Image Quality', 'palleon'); ?></label>
                                <select id="palleon-save-img-quality" class="palleon-select" autocomplete="off">
                                    <option selected value="1">100%</option>
                                    <option value="0.9">90%</option>
                                    <option value="0.8">80%</option>
                                    <option value="0.7">70%</option>
                                    <option value="0.6">60%</option>
                                    <option value="0.5">50%</option>
                                    <option value="0.4">40%</option>
                                    <option value="0.3">30%</option>
                                    <option value="0.2">20%</option>
                                    <option value="0.1">10%</option>
                                </select>
                            </div>
                            <div>
                                <label><?php echo esc_html__('File Format', 'palleon'); ?></label>
                                <select id="palleon-save-img-format" class="palleon-select palleon-save-img-format" autocomplete="off">
                                    <option selected value="jpeg">JPEG</option>
                                    <option value="png">PNG</option>
                                    <?php 
                                    $allowSVG =  PalleonSettings::get_option('allow_svg', 'enable');
                                    if ($allowSVG == 'enable') { 
                                        echo '<option value="svg">SVG</option>';
                                    } 
                                    ?>
                                    <option value="webp">WEBP</option>
                                    <?php 
                                    $allowTIFF =  PalleonSettings::get_option('allow_tiff', 'disable');
                                    if ($allowTIFF == 'enable') { 
                                        echo '<option value="tiff">TIFF</option>';
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php do_action('palleon_before_save_template'); ?>
                    <?php if ($templates == 'enable' && $mytemplates == 'enable') { ?>
                    <div id="palleon-save-as-json">
                        <div class="palleon-block-50">
                            <div>
                                <label><?php echo esc_html__('File Name', 'palleon'); ?></label>
                                <input id="palleon-json-save-name" class="palleon-form-field palleon-file-name" type="text" value="" autocomplete="off" data-default="">
                            </div>
                            <button id="palleon-json-save" type="button" class="palleon-btn primary"><span class="material-icons">save</span><?php echo esc_html__('Save As Template', 'palleon'); ?></button>
                        </div>
                    </div>
                    <?php } ?>
                    <?php do_action('palleon_after_save'); ?>
                    </ul>
                </div>
                <?php } ?>
                <div id="modal-tab-download" class="palleon-tab <?php if (!is_user_logged_in() || (is_user_logged_in() && ($allow_save == 'disable' && !current_user_can('administrator')))) { echo 'active'; } ?>">
                    <div id="palleon-download-as-img">
                        <div class="palleon-block-50">
                            <div>
                                <label><?php echo esc_html__('File Name', 'palleon'); ?></label>
                                <input id="palleon-download-name" class="palleon-form-field palleon-file-name" type="text" value="" autocomplete="off" data-default="">
                            </div>
                            <button id="palleon-download" type="button" class="palleon-btn primary"><span class="material-icons">download</span><?php echo esc_html__('Download As Image', 'palleon'); ?></button>
                        </div>
                        <div class="palleon-block-33">
                            <div>
                                <label><?php echo esc_html__('DPI', 'palleon'); ?></label>
                                <select id="palleon-download-img-dpi" class="palleon-select" autocomplete="off">
                                    <option selected value="72">72 DPI - <?php echo esc_html__('Monitor Resolution', 'palleon'); ?></option>
                                    <option value="96">96 DPI</option>
                                    <option value="144">144 DPI</option>
                                    <option value="300">300 DPI - <?php echo esc_html__('Printer Resolution', 'palleon'); ?></option>
                                    <option value="600">600 DPI</option>
                                </select>
                            </div>
                            <div>
                                <label><?php echo esc_html__('Image Quality', 'palleon'); ?></label>
                                <select id="palleon-download-quality" class="palleon-select" autocomplete="off">
                                    <option selected value="1">100%</option>
                                    <option value="0.9">90%</option>
                                    <option value="0.8">80%</option>
                                    <option value="0.7">70%</option>
                                    <option value="0.6">60%</option>
                                    <option value="0.5">50%</option>
                                    <option value="0.4">40%</option>
                                    <option value="0.3">30%</option>
                                    <option value="0.2">20%</option>
                                    <option value="0.1">10%</option>
                                </select>
                            </div>
                            <div>
                                <label><?php echo esc_html__('File Format', 'palleon'); ?></label>
                                <select id="palleon-download-format" class="palleon-select" autocomplete="off">
                                    <option selected value="jpeg">JPEG</option>
                                    <option value="png">PNG</option>
                                    <option value="svg">SVG</option>
                                    <option value="webp">WEBP</option>
                                    <option value="tiff">TIFF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php if ($templates == 'enable') { ?>
                    <div id="palleon-download-as-json">
                        <div class="palleon-block-50">
                            <div>
                                <label><?php echo esc_html__('File Name', 'palleon'); ?></label>
                                <input id="palleon-json-download-name" class="palleon-form-field palleon-file-name" type="text" value="" autocomplete="off" data-default="">
                            </div>
                            <button id="palleon-json-download" type="button" class="palleon-btn primary"><span class="material-icons">download</span><?php echo esc_html__('Download As Template', 'palleon'); ?></button>
                        </div>
                    </div>
                    <?php } ?>
                    <?php do_action('palleon_after_download'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (is_user_logged_in() && $share == 'enable') { ?>
<div id="modal-share" class="palleon-modal">
    <div class="palleon-modal-close" data-target="#modal-share"><span class="material-icons">close</span></div>
    <div class="palleon-modal-wrap">
        <div class="palleon-modal-inner small">
            <div class="palleon-modal-bg">
                <h3 id="modal-share-title"><?php echo esc_html__( 'Share', 'palleon' ); ?></h3>
                <div class="modal-share-copy">
                    <input type="text" id="palleon-share-url" class="palleon-form-field" autocomplete="off" value="" readonly />
                    <button id="modal-share-copy" type="button" class="palleon-btn primary"><?php echo esc_html__('Copy URL', 'palleon'); ?></button>
                </div>
                <div class="palleon-share-icons">
                <ul class="rrssb-buttons">
                    <li class="rrssb-facebook">
                    <a href="" class="popup" data-title="<?php echo esc_html__( 'Facebook', 'palleon' ); ?>">
                        <span class="rrssb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg>
                        </span>
                    </a>
                    </li>
                    <li class="rrssb-twitter">
                    <a href=""
                    class="popup" data-title="<?php echo esc_html__( 'Twitter', 'palleon' ); ?>">
                        <span class="rrssb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg>
                        </span>
                    </a>
                    </li>
                    <li class="rrssb-reddit">
                    <a href="" target="_blank">
                        <span class="rrssb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M11.794 15.316c0-1.03-.835-1.895-1.866-1.895-1.03 0-1.893.866-1.893 1.896s.863 1.9 1.9 1.9c1.023-.016 1.865-.916 1.865-1.9zM18.1 13.422c-1.03 0-1.895.864-1.895 1.895 0 1 .9 1.9 1.9 1.865 1.03 0 1.87-.836 1.87-1.865-.006-1.017-.875-1.917-1.875-1.895zM17.527 19.79c-.678.68-1.826 1.007-3.514 1.007h-.03c-1.686 0-2.834-.328-3.51-1.005a.677.677 0 0 0-.958 0c-.264.265-.264.7 0 1 .943.9 2.4 1.4 4.5 1.402.005 0 0 0 0 0 .005 0 0 0 0 0 2.066 0 3.527-.46 4.47-1.402a.678.678 0 0 0 .002-.958c-.267-.334-.688-.334-.988-.043z"/><path d="M27.707 13.267a3.24 3.24 0 0 0-3.236-3.237c-.792 0-1.517.287-2.08.76-2.04-1.294-4.647-2.068-7.44-2.218l1.484-4.69 4.062.955c.07 1.4 1.3 2.6 2.7 2.555a2.696 2.696 0 0 0 2.695-2.695C25.88 3.2 24.7 2 23.2 2c-1.06 0-1.98.616-2.42 1.508l-4.633-1.09a.683.683 0 0 0-.803.454l-1.793 5.7C10.55 8.6 7.7 9.4 5.6 10.75c-.594-.45-1.3-.75-2.1-.72-1.785 0-3.237 1.45-3.237 3.2 0 1.1.6 2.1 1.4 2.69-.04.27-.06.55-.06.83 0 2.3 1.3 4.4 3.7 5.9 2.298 1.5 5.3 2.3 8.6 2.325 3.227 0 6.27-.825 8.57-2.325 2.387-1.56 3.7-3.66 3.7-5.917 0-.26-.016-.514-.05-.768.965-.465 1.577-1.565 1.577-2.698zm-4.52-9.912c.74 0 1.3.6 1.3 1.3a1.34 1.34 0 0 1-2.683 0c.04-.655.596-1.255 1.396-1.3zM1.646 13.3c0-1.038.845-1.882 1.883-1.882.31 0 .6.1.9.21-1.05.867-1.813 1.86-2.26 2.9-.338-.328-.57-.728-.57-1.26zm20.126 8.27c-2.082 1.357-4.863 2.105-7.83 2.105-2.968 0-5.748-.748-7.83-2.105-1.99-1.3-3.087-3-3.087-4.782 0-1.784 1.097-3.484 3.088-4.784 2.08-1.358 4.86-2.106 7.828-2.106 2.967 0 5.7.7 7.8 2.106 1.99 1.3 3.1 3 3.1 4.784C24.86 18.6 23.8 20.3 21.8 21.57zm4.014-6.97c-.432-1.084-1.19-2.095-2.244-2.977.273-.156.59-.245.928-.245 1.036 0 1.9.8 1.9 1.9a2.073 2.073 0 0 1-.57 1.327z"/></svg>
                        </span>
                    </a>
                    </li>
                    <li class="rrssb-pinterest">
                    <a href="" class="popup" data-title="<?php echo esc_html__( 'Pinterest', 'palleon' ); ?>">
                        <span class="rrssb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M14.02 1.57c-7.06 0-12.784 5.723-12.784 12.785S6.96 27.14 14.02 27.14c7.062 0 12.786-5.725 12.786-12.785 0-7.06-5.724-12.785-12.785-12.785zm1.24 17.085c-1.16-.09-1.648-.666-2.558-1.22-.5 2.627-1.113 5.146-2.925 6.46-.56-3.972.822-6.952 1.462-10.117-1.094-1.84.13-5.545 2.437-4.632 2.837 1.123-2.458 6.842 1.1 7.557 3.71.744 5.226-6.44 2.924-8.775-3.324-3.374-9.677-.077-8.896 4.754.19 1.178 1.408 1.538.49 3.168-2.13-.472-2.764-2.15-2.683-4.388.132-3.662 3.292-6.227 6.46-6.582 4.008-.448 7.772 1.474 8.29 5.24.58 4.254-1.815 8.864-6.1 8.532v.003z"/></svg>
                        </span>
                    </a>
                    </li>
                    <li class="rrssb-linkedin">
                    <a href="" class="popup" data-title="<?php echo esc_html__( 'Linkedin', 'palleon' ); ?>">
                        <span class="rrssb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z"/></svg>
                        </span>
                    </a>
                    </li>
                    <li class="rrssb-whatsapp">
                    <a href="" data-action="share/whatsapp/share">
                        <span class="rrssb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90"><path d="M90 43.84c0 24.214-19.78 43.842-44.182 43.842a44.256 44.256 0 0 1-21.357-5.455L0 90l7.975-23.522a43.38 43.38 0 0 1-6.34-22.637C1.635 19.63 21.415 0 45.818 0 70.223 0 90 19.628 90 43.84zM45.818 6.983c-20.484 0-37.146 16.535-37.146 36.86 0 8.064 2.63 15.533 7.076 21.61l-4.64 13.688 14.274-4.537A37.122 37.122 0 0 0 45.82 80.7c20.48 0 37.145-16.533 37.145-36.857S66.3 6.983 45.818 6.983zm22.31 46.956c-.272-.447-.993-.717-2.075-1.254-1.084-.537-6.41-3.138-7.4-3.495-.993-.36-1.717-.54-2.438.536-.72 1.076-2.797 3.495-3.43 4.212-.632.72-1.263.81-2.347.27-1.082-.536-4.57-1.672-8.708-5.332-3.22-2.848-5.393-6.364-6.025-7.44-.63-1.076-.066-1.657.475-2.192.488-.482 1.084-1.255 1.625-1.882.543-.628.723-1.075 1.082-1.793.363-.718.182-1.345-.09-1.884-.27-.537-2.438-5.825-3.34-7.977-.902-2.15-1.803-1.793-2.436-1.793-.63 0-1.353-.09-2.075-.09-.722 0-1.896.27-2.89 1.344-.99 1.077-3.788 3.677-3.788 8.964 0 5.288 3.88 10.397 4.422 11.113.54.716 7.49 11.92 18.5 16.223 11.01 4.3 11.01 2.866 12.996 2.686 1.984-.18 6.406-2.6 7.312-5.107.9-2.513.9-4.664.63-5.112z"/></svg>
                        </span>
                    </a>
                    </li>
                    </ul>
                </div>    
            </div>
        </div>
    </div>
</div>
<?php } ?>