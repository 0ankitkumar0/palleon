<?php
defined( 'ABSPATH' ) || exit;

class PalleonSettings {
    /* The single instance of the class */
	protected static $_instance = null;

    /* Main Instance */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    /* Constructor */
    public function __construct() {
        add_action( 'cmb2_admin_init', array($this, 'register_metabox') );
        add_action( 'admin_enqueue_scripts',array($this, 'colorpicker_labels'), 99 );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts') );
        add_filter( 'cmb2_override_meta_value', array($this, 'cmb2_override'), 10, 4 );
    }

    /* Admin Scripts */
    public function admin_scripts($hook){
        $suffix = ( defined( 'PALLEON_SCRIPT_DEBUG' ) && PALLEON_SCRIPT_DEBUG ) ? '' : '.min';
        if ('palleon_page_palleon_options' == $hook)  {
            wp_enqueue_style('palleon-admin', PALLEON_PLUGIN_URL . 'css/admin' . $suffix . '.css', false, PALLEON_VERSION);
            wp_enqueue_script('palleon-admin', PALLEON_PLUGIN_URL . 'js/admin' . $suffix . '.js', array( 'jquery' ), PALLEON_VERSION, true);
        } else {
            wp_enqueue_style('palleon-admin-general', PALLEON_PLUGIN_URL . 'css/admin-general' . $suffix . '.css', false, PALLEON_VERSION);
        }
    }

    /**
    * Hook in and register a metabox to handle a plugin options page and adds a menu item.
    */
    public function register_metabox() {
        $args = array(
            'id'           => 'palleon_options',
            'title'        => esc_html__('Palleon Settings', 'palleon') . '<span> <a href="https://palleon.website/documentation/" target="_blank">' . esc_html__( 'Help Docs', 'palleon' ) . ' - v' . PALLEON_VERSION . '<span class="dashicons dashicons-external"></span></a></span>',
            'menu_title'   => esc_html__('Settings', 'palleon'),
            'object_types' => array( 'options-page' ),
            'option_key'   => 'palleon_options',
            'parent_slug'     => 'palleon',
            'capability'      => 'manage_options',
            'save_button'     => esc_html__( 'Save Settings', 'palleon' )
        );

        $options = new_cmb2_box( $args );

        /* TABS */
        $options->add_field( array(
            'name' => esc_html__( 'General', 'palleon' ),
            'id'   => 'general_title',
            'classes'   => array('active'),
            'type' => 'title',
            'before_row' => '<div id="palleon-tabs">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Logged In Users', 'palleon' ),
            'id'   => 'be_editor_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Front-end Version', 'palleon' ),
            'id'   => 'fe_editor_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Modules', 'palleon' ),
            'id'   => 'modules_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Apps', 'palleon' ),
            'id'   => 'apps_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Pagination', 'palleon' ),
            'id'   => 'pagination_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Watermark', 'palleon' ),
            'id'   => 'watermark_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Blank Canvas Sizes', 'palleon' ),
            'id'   => 'blank_canvas_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Image Banners', 'palleon' ),
            'id'   => 'img_banners_title',
            'type' => 'title'
        ) );

        if (defined('IHC_PATH') || function_exists('ihc_initiate_plugin')){
            $options->add_field( array(
                'name' => esc_html__( 'Ultimate Membership Pro', 'palleon' ) . '<span class="dashicons dashicons-admin-users"></span>',
                'id'   => 'umpro_title',
                'type' => 'title'
            ) );
        } 

        if (function_exists('pmpro_getAllLevels')) {
            $options->add_field( array(
                'name' => esc_html__( 'Paid Memberships Pro', 'palleon' ) . '<span class="dashicons dashicons-admin-users"></span>',
                'id'   => 'pmpro_title',
                'type' => 'title'
            ) );
        }

        if (class_exists('SwpmMembershipLevelUtils')) {
            $options->add_field( array(
                'name' => esc_html__( 'Simple Membership', 'palleon' ) . '<span class="dashicons dashicons-admin-users"></span>',
                'id'   => 'swpm_title',
                'type' => 'title'
            ) );
        }

        if (function_exists('rcp_get_membership_levels')) {
            $options->add_field( array(
                'name' => esc_html__( 'Restrict Content PRO', 'palleon' ) . '<span class="dashicons dashicons-admin-users"></span>',
                'id'   => 'rcpro_title',
                'type' => 'title'
            ) );
        }

        do_action('palleon_add_setting_tab', $options);

        $options->add_field( array(
            'name' => esc_html__( 'Iconfinder', 'palleon' ) . '<span class="palleon-api">' . esc_html__( 'API', 'palleon' ) . '</span>',
            'id'   => 'iconfinder_title',
            'type' => 'title',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Pixabay', 'palleon' ) . '<span class="palleon-api">' . esc_html__( 'API', 'palleon' ) . '</span>',
            'id'   => 'pixabay_title',
            'type' => 'title'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Pexels', 'palleon' ) . '<span class="palleon-api">' . esc_html__( 'API', 'palleon' ) . '</span>',
            'id'   => 'pexels_title',
            'type' => 'title',
            'after_row' => '</div><div id="palleon-tab-boxes">',
        ) );

        /* GENERAL */
        $options->add_field( array(
            'name'    => esc_html__( 'Logo', 'palleon' ),
            'id'      => 'logo',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                    'image/jpeg',
                    'image/png',
                ),
            ),
            'preview_size' => 'medium',
            'default' => PALLEON_PLUGIN_URL . 'assets/logo.png',
            'before_row' => '<div class="palleon-tab-content active" data-id="general-title">',
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Mobile Logo', 'palleon' ),
            'id'      => 'logo_small',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                    'image/jpeg',
                    'image/png',
                ),
            ),
            'preview_size' => 'medium',
            'default' => PALLEON_PLUGIN_URL . 'assets/logo-small.png'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Default Theme', 'palleon' ),
            'id'   => 'default_theme',
            'type' => 'radio_inline',
            'options' => array(
                'dark' => esc_html__( 'Dark', 'palleon' ),
                'light'   => esc_html__( 'Light', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'dark'
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Primary Color', 'palleon' ),
            'id'      => 'primary_color',
            'type'    => 'colorpicker',
            'default' => '#6658ea'
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Secondary Color', 'palleon' ),
            'id'      => 'secondary_color',
            'type'    => 'colorpicker',
            'default' => '#5546e8'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Allow Transparency', 'palleon' ),
            'description' => esc_html__( 'Alpha transparency selection on the color pickers.', 'palleon' ),
            'id'   => 'alpha_color',
            'type' => 'radio_inline',
            'options' => array(
                'true' => esc_html__( 'Enable', 'palleon' ),
                'false'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'true'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Share Image', 'palleon' ),
            'description' => esc_html__( 'Allow users to share saved images and templates (Front-end version must be enabled for the templates) on social media easily.', 'palleon' ),
            'id'   => 'share',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field(
            array(
                'name' => esc_html__( 'WEBGL Filtering', 'palleon'),
                'description'    => esc_html__( 'Image filtering engine can work on both WEBGL or plain CPU javascript. WEBGL may not work properly on older browsers or hardware. If you are experiencing issues on image filters, you can disable WEBGL.', 'palleon'),
                'id' => 'webgl_filtering',
                'type' => 'radio_inline',
                'options' => array(
                    'true' => esc_html__( 'Enable', 'palleon' ),
                    'false'   => esc_html__( 'Disable', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'true'
            )
        );

        $options->add_field( array(
            'name' => esc_html__( 'Max. Texture Size (WEBGL)', 'palleon' ),
            'id'   => 'texture_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 4096
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Custom CSS', 'palleon' ),
            'id' => 'custom_css',
            'type' => 'textarea_code',
            'attributes' => array(
                'data-codeeditor' => json_encode( array(
                    'codemirror' => array(
                        'mode' => 'css'
                    ),
                ) ),
            ),
            'after_row' => '</div>',
        ) );
        
        /* BACK-END VERSION */

        if ( ! function_exists( 'get_editable_roles' ) ) {
            require_once ABSPATH . 'wp-admin/includes/user.php';
        }

        $user_roles = get_editable_roles();
        $user_roles_array = array();

        foreach ($user_roles as $role_name => $role_info) {
            if ($role_name != 'administrator') {
                $user_roles_array[$role_name] = $role_name;
            }
        }

        $options->add_field( array(
            'name'    => esc_html__( 'Restrict Access', 'palleon' ),
            'desc'    => esc_html__( 'Select the user roles that are NOT granted access to the back-end photo editor. Admins are always allowed.', 'palleon' ),
            'id'      => 'user_roles',
            'type'    => 'multicheck_inline',
            'options' => $user_roles_array,
            'before_row' => '<div class="palleon-tab-content" data-id="be-editor-title">'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Access Denied Message', 'palleon' ),
            'description' => esc_html__( 'Message to be displayed to user roles that have been denied access.', 'palleon' ),
            'id'   => 'user_roles_info',
            'type'    => 'wysiwyg',
            'options' => array(
                'wpautop' => true,
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => false,
                'textarea_rows' => 2
            ),
            'default' => esc_html__( 'Access denied. You are not allowed to use the editor.', 'palleon' ),
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Allow SVG Upload', 'palleon' ),
            'description' => esc_html__( 'Allow users to upload SVG files to the media library.', 'palleon' ),
            'id'   => 'allow_svg',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Allow TIFF Upload', 'palleon' ),
            'description' => esc_html__( 'Allow users to upload TIFF files to the media library. Please note that TIFF files are large and not web-friendly files. If you try to save large images as TIFF, you may encounter a content length error. We recommend you to use download button instead.', 'palleon' ),
            'id'   => 'allow_tiff',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'disable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Allow JSON Upload', 'palleon' ),
            'description' => esc_html__( 'Allow users to upload JSON files (templates) to the media library.', 'palleon' ),
            'id'   => 'allow_json',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Media Library', 'palleon' ),
            'description' => esc_html__( 'Allow or disallow users to access WordPress media library. Admins are always allowed.', 'palleon' ),
            'id'   => 'allow_img',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Other Images', 'palleon' ),
            'description' => esc_html__( 'Allow users to use all images in the media library. If you disable it, users will only able to use their own images.', 'palleon' ),
            'id'   => 'other_images',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Media Library Buttons', 'palleon' ),
            'description' => esc_html__( 'If you disable the media library and are not using any APIs, you may want to hide the media library buttons.', 'palleon' ),
            'id'   => 'hide_ml_btns',
            'type' => 'radio_inline',
            'options' => array(
                'show' => esc_html__( 'Show', 'palleon' ),
                'hide'   => esc_html__( 'Hide', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'show'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Save Tab', 'palleon' ),
            'description' => esc_html__( 'If you disable the media library and are not using any APIs, you may want to hide the save tab.', 'palleon' ),
            'id'   => 'allow_save',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Show', 'palleon' ),
                'disable'   => esc_html__( 'Hide', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Max. number of files allowed', 'palleon' ),
            'description' => esc_html__( 'Set the maximum number of files (image and template files) allowed to be stored in your media library per user (admins and editors always allowed). Leave blank for unlimited use.', 'palleon' ),
            'id'      => 'max_files_num',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => ''
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'PRO Template Title', 'palleon' ),
            'id'   => 'be_pro_info_title',
            'type' => 'text',
            'default' => esc_html__( 'Premium Content', 'palleon' )
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'PRO Template Info', 'palleon' ),
            'description' => esc_html__( 'If you are using one of the supported Memberships plugins, Members which are not allowed to use the template, will see this message.', 'palleon' ),
            'id'   => 'be_pro_info',
            'type'    => 'wysiwyg',
            'options' => array(
                'wpautop' => true,
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => false,
                'textarea_rows' => 2
            ),
            'default' => esc_html__( 'You need to upgrade your membership level to use this template.', 'palleon' ),
            'after_row' => '</div>',
        ) );

        /* FRONT-END VERSION */
        $slug =  PalleonSettings::get_option('fe_slug', 'palleon');

        $options->add_field( array(
            'name' => esc_html__( 'Front-end Version', 'palleon' ),
            'description' => esc_html__( 'If you enable it, the image editor will be accessible to everyone via this link;', 'palleon' ) . '<br><a href="' . get_site_url() . '?page=' . $slug . '" target="_blank">' . get_site_url() . '?page=' . $slug . '</a>',
            'id'   => 'fe_editor',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'disable',
            'before_row' => '<div class="palleon-tab-content" data-id="fe-editor-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Login required', 'palleon' ),
            'description' => esc_html__( 'Do users have to sign in to access the image editor?', 'palleon' ),
            'id'   => 'fe_login_required',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Yes', 'palleon' ),
                'disable'   => esc_html__( 'No', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'disable',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Custom URL Slug', 'palleon' ),
            'description' => esc_html__( 'Custom URL slug for the front-end version. Default slug is "palleon".', 'palleon' ),
            'id'   => 'fe_slug',
            'type' => 'text',
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => ''
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Description (Meta tag)', 'palleon' ),
            'id'   => 'fe_desc',
            'type' => 'textarea_small',
            'default' => ''
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Keywords (Meta tag)', 'palleon' ),
            'id'   => 'fe_keywords',
            'type' => 'textarea_small',
            'default' => ''
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'PRO Template Title', 'palleon' ),
            'id'   => 'fe_pro_info_title',
            'type' => 'text',
            'default' => esc_html__( 'Login Required', 'palleon' )
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'PRO Template Info', 'palleon' ),
            'description' => esc_html__( 'The info for PRO templates which are not accessible on frontend version.', 'palleon' ),
            'id'   => 'fe_pro_info',
            'type'    => 'wysiwyg',
            'options' => array(
                'wpautop' => true,
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => false,
                'textarea_rows' => 2
            ),
            'default' => esc_html__( 'You must login to use PRO templates.', 'palleon' ),
            'after_row' => '</div>',
        ) );

        /* MODULES */
        $options->add_field( array(
            'name' => esc_html__( 'Basic Adjusts', 'palleon' ),
            'id'   => 'module_basic_adjust',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable',
            'before_row' => '<div class="palleon-tab-content" data-id="modules-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Image Filters', 'palleon' ),
            'id'   => 'module_filters',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Frames', 'palleon' ),
            'id'   => 'module_frames',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Default Frames', 'palleon' ),
            'description' => esc_html__( 'If you want to show only your own frames, disable.', 'palleon' ),
            'id'   => 'default_frames',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );


        $options->add_field( array(
            'name' => esc_html__( 'Text', 'palleon' ),
            'id'   => 'module_text',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Image', 'palleon' ),
            'id'   => 'module_image',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Shapes', 'palleon' ),
            'id'   => 'module_shapes',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Elements & Icons', 'palleon' ),
            'id'   => 'module_elements',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Default Elements', 'palleon' ),
            'description' => esc_html__( 'If you want to show only your own elements, disable.', 'palleon' ),
            'id'   => 'default_elements',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Brushes', 'palleon' ),
            'id'   => 'module_brushes',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Templates', 'palleon' ),
            'id'   => 'module_templates',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Default Templates', 'palleon' ),
            'description' => esc_html__( 'If you want to show only your own templates and tags on template library, disable.', 'palleon' ),
            'id'   => 'default_temp',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Template Order', 'palleon' ),
            'id'   => 'template_order',
            'type' => 'select',
            'options' => array(
                'random' => esc_html__( 'Random', 'palleon' ),
                'new' => esc_html__( 'Newest First', 'palleon' ),
                'old' => esc_html__( 'Oldest First', 'palleon' ),
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'new'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Canvas Ruler', 'palleon' ),
            'id'   => 'module_ruler',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'History', 'palleon' ),
            'id'   => 'history',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Max. history log', 'palleon' ),
            'description'    => esc_html__( 'Maximum history log to store. Big numbers may slow down your browser.', 'palleon' ),
            'id'      => 'max_history_log',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 20,
            'after_row' => '</div>'
        ) );

        /* APPS */

        $options->add_field( array(
            'name' => esc_html__( 'Apps', 'palleon' ),
            'description'    => esc_html__( 'Select the disable option to completely disable the Apps section.', 'palleon' ),
            'id'   => 'module_apps',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable',
            'before_row' => '<div class="palleon-tab-content" data-id="apps-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'QR Code', 'palleon' ),
            'id'   => 'qrcode_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Barcode', 'palleon' ),
            'id'   => 'barcode_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'PDF Converter', 'palleon' ),
            'id'   => 'pdf_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Color Thief', 'palleon' ),
            'id'   => 'color_thief_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Triangle Art', 'palleon' ),
            'id'   => 'art_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Brands', 'palleon' ),
            'id'   => 'brands_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Country Flags', 'palleon' ),
            'id'   => 'flags_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Cryptocurrency', 'palleon' ),
            'id'   => 'crypto_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Multiavatar', 'palleon' ),
            'id'   => 'multiavatar_app',
            'type' => 'radio_inline',
            'options' => array(
                'enable' => esc_html__( 'Enable', 'palleon' ),
                'disable'   => esc_html__( 'Disable', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'enable',
            'after_row' => '</div>'
        ) );

        /* PAGINATION */
        $options->add_field( array(
            'name' => esc_html__( 'Media Library', 'palleon' ),
            'description' => esc_html__( 'Max. number of images to show.', 'palleon' ),
            'id'   => 'ml_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 18,
            'before_row' => '<div class="palleon-tab-content" data-id="pagination-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Templates', 'palleon' ),
            'description' => esc_html__( 'Max. number of templates to show.', 'palleon' ),
            'id'   => 'tp_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 21
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'My Templates', 'palleon' ),
            'description' => esc_html__( 'Max. number of my templates to show.', 'palleon' ),
            'id'   => 'mytp_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 10
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Elements', 'palleon' ),
            'description' => esc_html__( 'Max. number of elements to show in a category.', 'palleon' ),
            'id'   => 'el_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 12
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Frames', 'palleon' ),
            'description' => esc_html__( 'Max. number of frames to show in a category.', 'palleon' ),
            'id'   => 'fr_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 4,
            'after_row' => '</div>',
        ) );

        /* WATERMARK */
        $options->add_field(
            array(
                'name' => esc_html__( 'Watermark', 'palleon'),
                'description'    => esc_html__( 'If enabled, watermark is added to the image when user clicks save or download.', 'palleon'),
                'id' => 'watermark',
                'type' => 'radio_inline',
                'options' => array(
                    'none' => esc_html__( 'Disable', 'palleon' ),
                    'frontend'   => esc_html__( 'Front-end only', 'palleon' ),
                    'both'   => esc_html__( 'Front-end & Back-end', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'none',
                'before_row' => '<div class="palleon-tab-content" data-id="watermark-title">',
            )
        );

        $options->add_field(
            array(
                'name' => esc_html__( 'Location', 'palleon'),
                'id' => 'watermark_location',
                'type' => 'radio_inline',
                'options' => array(
                    'top-left' => esc_html__( 'Top Left', 'palleon' ),
                    'top-right'   => esc_html__( 'Top Right', 'palleon' ),
                    'bottom-left'   => esc_html__( 'Bottom Left', 'palleon' ),
                    'bottom-right'   => esc_html__( 'Bottom Right', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'bottom-right',
            )
        );

        $options->add_field( array(
            'name'    => esc_html__( 'Watermark Text', 'palleon' ),
            'id'      => 'watermark_text',
            'type'    => 'text',
            'default' => esc_html__( 'palleon.website', 'palleon' )
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Font Family', 'palleon' ),
            'id'   => 'watermark_font_family',
            'type' => 'select',
            'options' => Palleon::get_websafe_fonts(),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'Georgia, serif'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Font Size', 'palleon' ),
            'id'   => 'watermark_font_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 40
        ) );

        $options->add_field(
            array(
                'name' => esc_html__( 'Font Style', 'palleon'),
                'id' => 'watermark_font_style',
                'type' => 'radio_inline',
                'options' => array(
                    'normal' => esc_html__( 'Normal', 'palleon' ),
                    'italic'   => esc_html__( 'Italic', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'normal'
            )
        );

        $options->add_field(
            array(
                'name' => esc_html__( 'Font Weight', 'palleon'),
                'id' => 'watermark_font_weight',
                'type' => 'radio_inline',
                'options' => array(
                    'normal' => esc_html__( 'Normal', 'palleon' ),
                    'bold'   => esc_html__( 'Bold', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'bold'
            )
        );

        $options->add_field( array(
            'name'    => esc_html__( 'Font Color', 'palleon' ),
            'id'      => 'watermark_font_color',
            'type'    => 'colorpicker',
            'default' => '#000000'
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Background Color', 'palleon' ),
            'id'      => 'watermark_stroke_color',
            'type'    => 'colorpicker',
            'default' => '#FFFFFF',
            'after_row' => '</div>'
        ) );

        /* BLANK CANVAS */

        $blank_canvas_sizes = $options->add_field( array(
            'id'          => 'blank_canvas_sizes',
            'type'        => 'group',
            'before_group' => '<div id="blank-canvas-wrap" class="palleon-tab-content" data-id="blank-canvas-title">',
            'after_group' => '</div>',
            'options'     => array(
                'group_title'       => esc_html__( '{#}', 'palleon' ),
                'add_button'        => esc_html__( 'Add Another Size', 'palleon' ),
                'remove_button'     => esc_html__( 'Remove Size', 'palleon' ),
                'sortable'          => true,
                'closed'         => false,
            )
        ) );
        
        $options->add_group_field( $blank_canvas_sizes, array(
            'name' => esc_html__('Name', 'palleon'),
            'id'   => 'name',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );

        $options->add_group_field( $blank_canvas_sizes, array(
            'name' => esc_html__( 'Width (px)', 'palleon' ),
            'id'   => 'width',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 800
        ) );

        $options->add_group_field( $blank_canvas_sizes, array(
            'name' => esc_html__( 'Height (px)', 'palleon' ),
            'id'   => 'height',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 800
        ) );

        /* IMAGE BANNERS */

        $options->add_field(
            array(
                'name' => esc_html__( 'Image Banners', 'palleon'),
                'id' => 'show_img_banners',
                'type' => 'select',
                'options' => array(
                    'enable' => esc_html__( 'Enable for everyone', 'palleon' ),
                    'enable-nonlogin' => esc_html__( 'Enable for only non-login users', 'palleon' ),
                    'disable'   => esc_html__( 'Disable for everyone', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'disable',
                'before_row' => '<div id="img-banners-wrap" class="palleon-tab-content" data-id="img-banners-title">',
            )
        );

        $img_banners = $options->add_field( array(
            'id'          => 'img_banners',
            'type'        => 'group',
            'after_group' => '</div>',
            'options'     => array(
                'group_title'       => esc_html__( '{#}', 'palleon' ),
                'add_button'        => esc_html__( 'Add Another Banner', 'palleon' ),
                'remove_button'     => esc_html__( 'Remove Banner', 'palleon' ),
                'sortable'          => true,
                'closed'         => false,
            )
        ) );

        $options->add_group_field( $img_banners, array(
            'name' => esc_html__( 'Placements', 'palleon' ),
            'id'   => 'placements',
            'type' => 'multicheck_inline',
            'select_all_button' => false,
            'options' => array(
                'add-new-img' => esc_html__( 'Add new image', 'palleon' ),
                'blank-canvas'   => esc_html__( 'Blank canvas', 'palleon' ),
                'adjust'   => esc_html__( 'Adjust', 'palleon' ),
                'text'   => esc_html__( 'Text', 'palleon' ),
                'image'   => esc_html__( 'Image', 'palleon' ),
                'frames'   => esc_html__( 'Frames', 'palleon' ),
                'shapes'   => esc_html__( 'Shapes', 'palleon' ),
                'elements'   => esc_html__( 'Elements', 'palleon' ),
                'icons'   => esc_html__( 'Icons', 'palleon' ),
                'apps'   => esc_html__( 'Apps', 'palleon' ),
                'brushes'   => esc_html__( 'Brushes', 'palleon' ),
                'layers'   => esc_html__( 'Layers', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'add-new-img'
        ) );

        $options->add_group_field( $img_banners, array(
            'name' => esc_html__( 'Image URL', 'palleon' ),
            'id'   => 'image',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ),
            )
        ) );

        $options->add_group_field( $img_banners, array(
            'name' => esc_html__( 'Destination URL', 'palleon' ),
            'id'   => 'url',
            'type'    => 'text'
        ) );

        $options->add_group_field( $img_banners, array(
            'name' => esc_html__('Title', 'palleon'),
            'id'   => 'title',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );

        /* ULTIMATE MEMBERSHIP PRO */
        if (defined('IHC_PATH') || function_exists('ihc_initiate_plugin')){

            $umpro_levels = \Indeed\Ihc\Db\Memberships::getAll();

            $umpro_levels = ihc_reorder_arr($umpro_levels);
            $umpro_levels = ihc_check_show($umpro_levels); /// SHOW/HIDE
            $umpro_levels = ihc_check_level_restricted_conditions($umpro_levels); /// MAGIC FEAT.

            $umpro_levels = apply_filters( 'ihc_public_subscription_plan_list_levels', $umpro_levels );

            $umpro_levels_array = array();
            foreach ( $umpro_levels as $id => $levelData ){
                $umpro_levels_array[ $id ] = $levelData['label'];
            }

            $options->add_field( array(
                'name'    => esc_html__( 'Membership Levels', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access backend photo editor.', 'palleon' ),
                'id'      => 'umpro_levels',
                'type'    => 'multicheck',
                'options' => $umpro_levels_array,
                'before_row' => '<div class="palleon-tab-content" data-id="umpro-title">',
            ) );

            $options->add_field( array(
                'name' => esc_html__( 'Redirect URL', 'palleon' ),
                'desc'   => esc_html__( 'As default, non-memberships redirect to the homepage if they try to access backend photo editor.', 'palleon' ),
                'id'      => 'umpro_redirect',
                'type' => 'text_url'
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'PRO Templates', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access PRO templates.', 'palleon' ),
                'id'      => 'umpro_template_levels',
                'type'    => 'multicheck',
                'options' => $umpro_levels_array,
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'Remove Ads', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will use Palleon without ads.', 'palleon' ),
                'id'      => 'umpro_remove_ads_levels',
                'type'    => 'multicheck',
                'options' => $umpro_levels_array,
                'after_row' => '</div>',
            ) );

        }

        /* PAID MEMBERSHIPS PRO */
        if (function_exists('pmpro_getAllLevels')) {

            $pmpro_levels = pmpro_getAllLevels( true, true );
            $pmpro_levels = pmpro_sort_levels_by_order( $pmpro_levels );

            $pmpro_levels_array = array();
            foreach( $pmpro_levels as $level ) {
                $pmpro_levels_array[ $level->id ] = $level->name;
            }

            $options->add_field( array(
                'name'    => esc_html__( 'Membership Levels', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access backend photo editor.', 'palleon' ),
                'id'      => 'pmpro_levels',
                'type'    => 'multicheck',
                'options' => $pmpro_levels_array,
                'before_row' => '<div class="palleon-tab-content" data-id="pmpro-title">',
            ) );

            $options->add_field( array(
                'name' => esc_html__( 'Redirect URL', 'palleon' ),
                'desc'   => esc_html__( 'As default, non-memberships redirect to the homepage if they try to access backend photo editor.', 'palleon' ),
                'id'      => 'pmpro_redirect',
                'type' => 'text_url'
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'PRO Templates', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access PRO templates.', 'palleon' ),
                'id'      => 'pmpro_template_levels',
                'type'    => 'multicheck',
                'options' => $pmpro_levels_array,
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'Remove Ads', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will use Palleon without ads.', 'palleon' ),
                'id'      => 'pmpro_remove_ads_levels',
                'type'    => 'multicheck',
                'options' => $pmpro_levels_array,
                'after_row' => '</div>',
            ) );

        }

        /* SIMPLE MEMBERSHIP */
        if (class_exists('SwpmMembershipLevelUtils')) {
            $swpm_levels = SwpmMembershipLevelUtils::get_all_membership_levels_in_array();

            $options->add_field( array(
                'name'    => esc_html__( 'Membership Levels', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access backend photo editor.', 'palleon' ),
                'id'      => 'swpm_levels',
                'type'    => 'multicheck',
                'options' => $swpm_levels,
                'before_row' => '<div class="palleon-tab-content" data-id="swpm-title">',
            ) );

            $options->add_field( array(
                'name' => esc_html__( 'Redirect URL', 'palleon' ),
                'desc'   => esc_html__( 'As default, non-memberships redirect to the homepage if they try to access backend photo editor.', 'palleon' ),
                'id'      => 'swpm_redirect',
                'type' => 'text_url'
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'PRO Templates', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access PRO templates.', 'palleon' ),
                'id'      => 'swpm_template_levels',
                'type'    => 'multicheck',
                'options' => $swpm_levels
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'Remove Ads', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will use Palleon without ads.', 'palleon' ),
                'id'      => 'swpm_remove_ads_levels',
                'type'    => 'multicheck',
                'options' => $swpm_levels,
                'after_row' => '</div>',
            ) );
        }

        /* RESTRICT CONTENT PRO */
        if (function_exists('rcp_get_membership_levels')) {

            $rcpro_levels = rcp_get_membership_levels(array('status' => 'active','number' => 999));
            $rcpro_array = array();
            foreach ( $rcpro_levels as $level ) {
                $rcpro_array[$level->get_id()] = $level->get_name();
            }

            $options->add_field( array(
                'name'    => esc_html__( 'Membership Levels', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access backend photo editor.', 'palleon' ),
                'id'      => 'rcpro_levels',
                'type'    => 'multicheck',
                'options' => $rcpro_array,
                'before_row' => '<div class="palleon-tab-content" data-id="rcpro-title">',
            ) );

            $options->add_field( array(
                'name' => esc_html__( 'Redirect URL', 'palleon' ),
                'desc'   => esc_html__( 'As default, non-memberships redirect to the homepage if they try to access backend photo editor.', 'palleon' ),
                'id'      => 'rcpro_redirect',
                'type' => 'text_url'
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'PRO Templates', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will be able to access PRO templates.', 'palleon' ),
                'id'      => 'rcpro_template_levels',
                'type'    => 'multicheck',
                'options' => $rcpro_array
            ) );

            $options->add_field( array(
                'name'    => esc_html__( 'Remove Ads', 'palleon' ),
                'desc'    => esc_html__( 'Select membership levels which will use Palleon without ads.', 'palleon' ),
                'id'      => 'rcpro_remove_ads_levels',
                'type'    => 'multicheck',
                'options' => $rcpro_array,
                'after_row' => '</div>',
            ) );
        }

        do_action('palleon_add_settings', $options);

        /* ICONFINDER */
        $options->add_field( array(
            'name'    => esc_html__( 'API Key (Required)', 'palleon' ),
            'description' => esc_html__( 'You must get a free API key from Iconfinder to use this feature. For more information, please read the documentation.', 'palleon' ),
            'id'      => 'iconfinder',
            'type'    => 'text',
            'before_row' => '<div class="palleon-tab-content" data-id="iconfinder-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'License', 'palleon' ),
            'description' => esc_html__( 'All - Include all icons no matter the license. Commercial - Only include icons that can be used commercially, but may require attribution or be restricted by other licensing concerns. Commercial (No Attribution) - Only include icons that be used commercially without any attribution requirements.', 'palleon' ),
            'id'   => 'iconfinder_license',
            'type' => 'select',
            'options' => array(
                'none' => esc_html__( 'Include All Icons', 'palleon' ),
                'commercial' => esc_html__( 'Commercial', 'palleon' ),
                'commercial-nonattribution' => esc_html__( 'Commercial (No Attribution)', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'none'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Explicit Content', 'palleon' ),
            'description' => esc_html__( 'If false, it will exclude all explicit content (icons depicting mature content which are unsuitable for educational purposes, younger viewers, or common work-place settings). If true, it will only return explicit content.', 'palleon' ),
            'id'   => 'iconfinder_exp',
            'type' => 'radio_inline',
            'options' => array(
                '1' => esc_html__( 'True', 'palleon' ),
                '0' => esc_html__( 'False', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => '1'
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Default Keyword', 'palleon' ),
            'description' => esc_html__( 'Enter a keyword to display default icons.', 'palleon' ),
            'id'      => 'iconfinder_default_keyword',
            'type'    => 'text',
        ) );

        $getApiKey =  PalleonSettings::get_option('iconfinder', '');

        if (!empty($getApiKey)) {
            $iconfinder_categories = PalleonIconfinder::get_categories();
            $options->add_field( array(
                'name'    => esc_html__( 'Default Category', 'palleon' ),
                'id'      => 'iconfinder_default_cat',
                'type'    => 'select',
                'options' => $iconfinder_categories,
                'default' => 'none'
            ) );

            $iconfinder_styles = PalleonIconfinder::get_styles();
            $options->add_field( array(
                'name'    => esc_html__( 'Default Style', 'palleon' ),
                'id'      => 'iconfinder_default_style',
                'type'    => 'select',
                'options' => $iconfinder_styles,
                'default' => 'none'
            ) );
        }

        $options->add_field( array(
            'name'    => esc_html__( 'Caching (hour)', 'palleon' ),
            'description' => esc_html__( 'Minimum 24 hours is recommended.', 'palleon' ),
            'id'      => 'icondinder_caching',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 24,
            'after_row' => '</div>',
        ) );

        /* PIXABAY */
        $options->add_field( array(
            'name'    => esc_html__( 'API Key (Required)', 'palleon' ),
            'description' => esc_html__( 'You must get a free API key from Pixabay to use this feature. For more information, please read the documentation.', 'palleon' ),
            'id'      => 'pixabay',
            'type'    => 'text',
            'before_row' => '<div class="palleon-tab-content" data-id="pixabay-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Language', 'palleon' ),
            'description' => esc_html__( 'The language of the search you are performing.', 'palleon' ),
            'id'   => 'pixabay_lang',
            'type' => 'select',
            'options' => array(
                'en' => esc_html__( 'English', 'palleon' ),
                'pt' => esc_html__( 'Portuguese', 'palleon' ),
                'es' => esc_html__( 'Spanish', 'palleon' ),
                'de' => esc_html__( 'German', 'palleon' ),
                'it' => esc_html__( 'Italian', 'palleon' ),
                'fr' => esc_html__( 'French', 'palleon' ),
                'sv' => esc_html__( 'Swedish', 'palleon' ),
                'pl' => esc_html__( 'Polish', 'palleon' ),
                'nl' => esc_html__( 'Dutch', 'palleon' ),
                'hu' => esc_html__( 'Hungarian', 'palleon' ),
                'cs' => esc_html__( 'Czech', 'palleon' ),
                'da' => esc_html__( 'Danish', 'palleon' ),
                'fi' => esc_html__( 'Finnish', 'palleon' ),
                'no' => esc_html__( 'Norwegian', 'palleon' ),
                'tr' => esc_html__( 'Turkish', 'palleon' ),
                'bg' => esc_html__( 'Bulgarian', 'palleon' ),
                'el' => esc_html__( 'Greek', 'palleon' ),
                'ro' => esc_html__( 'Romanian', 'palleon' ),
                'sk' => esc_html__( 'Slovak', 'palleon' ),
                'ru' => esc_html__( 'Russian', 'palleon' ),
                'ja' => esc_html__( 'Japanese', 'palleon' ),
                'zh' => esc_html__( 'Chinese', 'palleon' ),
                'ko' => esc_html__( 'Korean', 'palleon' ),
                'th' => esc_html__( 'Thai', 'palleon' ),
                'id' => esc_html__( 'Indonesian', 'palleon' ),
                'vi' => esc_html__( 'Vietnamese', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'en'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Pagination', 'palleon' ),
            'description' => esc_html__( 'Max. number of images to show.', 'palleon' ),
            'id'   => 'pixabay_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 16
        ) );

        $options->add_field(
            array(
                'name' => esc_html__( 'Editors Choice', 'palleon'),
                'description'    => esc_html__( 'If enabled, only images that have received an Editors Choice award will be returned.', 'palleon'),
                'id' => 'pixabay_editors_choice',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'palleon' ),
                    'disable'   => esc_html__( 'Disable', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'disable',
            )
        );

        $options->add_field(
            array(
                'name' => esc_html__( 'Safe Search', 'palleon'),
                'description'    => esc_html__( 'If enabled, only images suitable for all ages will be returned.', 'palleon'),
                'id' => 'pixabay_safe',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'palleon' ),
                    'disable'   => esc_html__( 'Disable', 'palleon' )
                ),
                'attributes' => array(
                    'autocomplete' => 'off'
                ),
                'default' => 'disable',
            )
        );

        $options->add_field( array(
            'name'    => esc_html__( 'Caching (hour)', 'palleon' ),
            'description'    => esc_html__( 'Pixabay API requests must be cached for minimum 24 hours.', 'palleon'),
            'id'      => 'pixabay_caching',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 24,
            'after_row' => '</div>',
        ) );

        /* PEXELS */
        $options->add_field( array(
            'name'    => esc_html__( 'API Key (Required)', 'palleon' ),
            'description' => esc_html__( 'You must get a free API key from Pexels to use this feature. For more information, please read the documentation.', 'palleon' ),
            'id'      => 'pexels',
            'type'    => 'text',
            'before_row' => '<div class="palleon-tab-content" data-id="pexels-title">',
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Language', 'palleon' ),
            'description' => esc_html__( 'The language of the search you are performing.', 'palleon' ),
            'id'   => 'pexels_lang',
            'type' => 'select',
            'options' => array(
                'en-US' => esc_html__( 'English', 'palleon' ),
                'pt-BR' => esc_html__( 'Portuguese (Brazil)', 'palleon' ),
                'es-ES' => esc_html__( 'Spanish', 'palleon' ),
                'ca-ES' => esc_html__( 'Catalan (Spanish)', 'palleon' ),
                'de-DE' => esc_html__( 'German', 'palleon' ),
                'it-IT' => esc_html__( 'Italian', 'palleon' ),
                'fr-FR' => esc_html__( 'French', 'palleon' ),
                'sv-SE' => esc_html__( 'Swedish', 'palleon' ),
                'pl-PL' => esc_html__( 'Polish', 'palleon' ),
                'nl-NL' => esc_html__( 'Dutch', 'palleon' ),
                'hu-HU' => esc_html__( 'Hungarian', 'palleon' ),
                'cs-CZ' => esc_html__( 'Czech', 'palleon' ),
                'da-DK' => esc_html__( 'Danish', 'palleon' ),
                'fi-FI' => esc_html__( 'Finnish', 'palleon' ),
                'nb-NO' => esc_html__( 'Norwegian', 'palleon' ),
                'uk-UA' => esc_html__( 'Ukrainian', 'palleon' ),
                'tr-TR' => esc_html__( 'Turkish', 'palleon' ),
                'el-GR' => esc_html__( 'Greek', 'palleon' ),
                'ro-RO' => esc_html__( 'Romanian', 'palleon' ),
                'sk-SK' => esc_html__( 'Slovak', 'palleon' ),
                'ru-RU' => esc_html__( 'Russian', 'palleon' ),
                'ja-JP' => esc_html__( 'Japanese', 'palleon' ),
                'zh-TW' => esc_html__( 'Chinese (T)', 'palleon' ),
                'zh-CN' => esc_html__( 'Chinese (S)', 'palleon' ),
                'ko-KR' => esc_html__( 'Korean', 'palleon' ),
                'th-TH' => esc_html__( 'Thai', 'palleon' ),
                'id-ID' => esc_html__( 'Indonesian', 'palleon' ),
                'vi-VN' => esc_html__( 'Vietnamese', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'en-US'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Image Size', 'palleon' ),
            'description' => esc_html__( 'Original is not recommended. By default WordPress does not allow images bigger than 2500px to save.', 'palleon' ),
            'id'   => 'pexels_img_size',
            'type' => 'select',
            'options' => array(
                'large2x' => esc_html__( 'Large 2x', 'palleon' ),
                'large' => esc_html__( 'Large', 'palleon' ),
                'medium' => esc_html__( 'Medium', 'palleon' ),
                'portrait' => esc_html__( 'Portrait', 'palleon' ),
                'landscape' => esc_html__( 'Landscape', 'palleon' ),
                'tiny' => esc_html__( 'Tiny', 'palleon' ),
                'original' => esc_html__( 'Original', 'palleon' ),
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'large2x'
        ) );

        $options->add_field( array(
            'name' => esc_html__( 'Pagination', 'palleon' ),
            'description' => esc_html__( 'Max. number of images to show.', 'palleon' ),
            'id'   => 'pexels_pagination',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 20
        ) );

        $options->add_field( array(
            'name'    => esc_html__( 'Caching (hour)', 'palleon' ),
            'description' => esc_html__( 'Minimum 24 hours is recommended.', 'palleon' ),
            'id'      => 'pexels_caching',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => 24,
            'after_row' => '</div></div>',
        ) );
    }
    /**
    * Colorpicker Labels
    */
    public function colorpicker_labels( $hook ) {
        global $wp_version;
        if( version_compare( $wp_version, '5.4.2' , '>=' ) ) {
            wp_localize_script(
            'wp-color-picker',
            'wpColorPickerL10n',
            array(
                'clear'            => esc_html__( 'Clear', 'palleon' ),
                'clearAriaLabel'   => esc_html__( 'Clear color', 'palleon' ),
                'defaultString'    => esc_html__( 'Default', 'palleon' ),
                'defaultAriaLabel' => esc_html__( 'Select default color', 'palleon' ),
                'pick'             => esc_html__( 'Select Color', 'palleon' ),
                'defaultLabel'     => esc_html__( 'Color value', 'palleon' )
            )
            );
        }
    }

    /**
    * Set default blank canvas field values
    */
    public function cmb2_override( $value, $object_id, $args, $field ) {
        static $defaults = null;
        if ( 'cmb2_field_no_override_val' !== $value ) {
            return $value;
        }
        // Get the value for the field.
        $data = 'options-page' === $args['type']
        ? cmb2_options( $args['id'] )->get( $args['field_id'] )
        : get_metadata( $args['type'], $args['id'], $args['field_id'], ( $args['single'] || $args['repeat'] ) );

        if ( empty( $data ) ) {
            if ( $field->group || 'group' === $field->type() ) {
                if ( null === $defaults && $args["field_id"] == 'blank_canvas_sizes') {
                    $json = '[{"name":"Blog Banner","width":"2240","height":"1260"},{"name":"Facebook Cover","width":"851","height":"315"},{"name":"Facebook Ad","width":"1200","height":"628"},{"name":"Instagram Post","width":"1080","height":"1080"},{"name":"Pinterest Post","width":"750","height":"1120"},{"name":"Facebook Post","width":"940","height":"788"},{"name":"Twitter Post","width":"1600","height":"900"},{"name":"Youtube Thumbnail","width":"1280","height":"720"}]';
                    $defaults = json_decode( $json, 1 );
                }
                $value = $defaults;
            }
        }
    
        return $value;
    }

    /**
    * Palleon get option
    */
    static function get_option( $key = '', $default = false ) {
        if ( function_exists( 'cmb2_get_option' ) ) {
            return cmb2_get_option( 'palleon_options', $key, $default );
        }
        $opts = get_option( 'palleon_options', $default );
        $val = $default;
        if ( 'all' == $key ) {
            $val = $opts;
        } elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
            $val = $opts[ $key ];
        }
        return $val;
    }

}

/**
 * Returns the main instance of the class.
 */
function PalleonSettings() {  
	return PalleonSettings::instance();
}
// Global for backwards compatibility.
$GLOBALS['PalleonSettings'] = PalleonSettings();