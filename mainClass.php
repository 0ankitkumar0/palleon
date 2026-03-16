<?php
defined( 'ABSPATH' ) || exit;

class Palleon {
    /**
	 * The single instance of the class
	 */
	protected static $_instance = null;

    /**
	 * Main Instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    /**
	 * Palleon Constructor
	 */
    public function __construct() {
        add_action('admin_init', array($this, 'page_check'), 1);
        add_action('cmb2_admin_init', array($this, 'max_files_num_metabox'));
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
        add_action('init', array($this, 'init'), 1);
        add_action('init', array($this, 'page_check_frontend'), 2);
        add_action('admin_menu', array($this, 'register_page'));
        add_filter('wp_mime_type_icon', array($this, 'mime_type_icons'), 10, 2 );
        add_filter('media_row_actions', array($this, 'edit_links'), 10, 2);
        add_action('cmb2_admin_init', array($this, 'attachment_metabox'));
        add_action('restrict_manage_posts', array($this, 'media_add_author_dropdown'));
        add_action('pre_get_posts',array($this, 'author_filter'));
        add_action('wp_ajax_loadmyimgs', array($this, 'load_my_images'));
        add_action('wp_ajax_loadmytemplates', array($this, 'load_my_templates'));
        add_action('wp_ajax_loadallimgs', array($this, 'load_all_images'));
        add_action('wp_ajax_uploadImgToLibrary', array($this, 'upload_img_to_library'));
        add_action('wp_ajax_uploadSVGToLibrary', array($this, 'upload_svg_to_library'));
        add_action('wp_ajax_deleteImgFromLibrary', array($this, 'delete_file_from_library'));
        add_action('wp_ajax_deleteJsonFromLibrary', array($this, 'delete_file_from_library'));
        add_action('wp_ajax_favElement', array($this, 'favorite_element'));
        add_action('wp_ajax_favframe', array($this, 'favorite_frame'));
        add_action('wp_ajax_favTemplate', array($this, 'favorite_template'));
        add_action('wp_ajax_savePreferences', array($this, 'save_preferences'));
        add_action('wp_ajax_saveImage', array($this, 'save_image'));
        add_action('palleon_head', array($this, 'styles'));
        add_action('palleon_head', 'wp_site_icon');
        add_action('palleon_body_end', array($this, 'scripts'));
        add_filter('upload_mimes', array($this, 'mime_types'));
        add_filter('post_mime_types',array($this, 'modify_post_mime_types'));
        add_filter('plugin_row_meta', array($this, 'plugin_links'), 10, 4 );
        add_action('wp_ajax_templateSearch', array($this, 'template_search'));
        add_action('wp_ajax_nopriv_templateSearch', array($this, 'template_search'));
        add_action('wp_ajax_templateSearchJson', array($this, 'template_search_json'));
        add_action('wp_ajax_nopriv_templateSearchJson', array($this, 'template_search_json'));
        add_action('wp_ajax_loadAllTemplates', array($this, 'load_all_templates'));
        add_action('wp_ajax_nopriv_loadAllTemplates', array($this, 'load_all_templates'));
        add_action('palleon_backend', array($this, 'user_roles'));
        add_action('palleon_backend', array($this, 'pmpro'));
        add_action('palleon_backend', array($this, 'umpro'));
        add_action('palleon_backend', array($this, 'swpm'));
        add_action('palleon_backend', array($this, 'rcpro'));
        add_action('palleon_frontend', array($this, 'user_roles'));
        add_action('palleon_frontend', array($this, 'pmpro'));
        add_action('palleon_frontend', array($this, 'umpro'));
        add_action('palleon_frontend', array($this, 'swpm'));
        add_action('palleon_frontend', array($this, 'rcpro'));
    }

    /**
	 * Init
	 */
    public function init() {
        load_plugin_textdomain( 'palleon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        register_nav_menus(
            array(
                'palleon-be-menu' => esc_html__( 'Palleon Back-end Menu', 'palleon' ),
                'palleon-fe-menu' => esc_html__( 'Palleon Front-end Menu', 'palleon' )
            )
        );
    }

    /**
	 * Add plugin links to plugins page on the admin dashboard
	 */
    public function plugin_links($links_array, $plugin_file_name, $plugin_data, $status) {
        if ( strpos( $plugin_file_name, 'palleon.php' ) !== false ) {
            $links_array[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=palleon_options') ) .'">' . esc_html__( 'Settings', 'palleon' ) . '</a>';
            $links_array[] = '<a href="https://palleon.website/documentation/" target="_blank">' . esc_html__( 'Documentation', 'palleon' ) . '</a>';
            $links_array[] = '<a href="https://palleon.website/update-history/palleon.html" target="_blank">' . esc_html__( 'Changelog', 'palleon' ) . '</a>';
        }
        return $links_array;
    }

    /**
	 * Add dashboard widget
	 */

    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'palleon_dashboard_widget',
            esc_html__( 'Palleon', 'palleon' ) . ' v' . PALLEON_VERSION,
            array($this, 'add_dashboard_widget_content')
        );	
    }

    public function add_dashboard_widget_content() {
        echo '<div id="palleon-dashboard-widget">';
        include_once( ABSPATH . WPINC . '/feed.php' );
        $rss = fetch_feed( 'https://blog.palleon.website/feed/' );   
        if ( ! is_wp_error( $rss ) ) {
            $rss_items = $rss->get_items();
            $i = 0;
            // shuffle ( $rss_items );
            echo '<ul>';
            foreach ( $rss_items as $item ) {
                if ($i <= 4) {
                    echo '<li>';
                    echo '<a href="' . esc_url( $item->get_permalink() ) . '" target="_blank">' . esc_html( $item->get_title() ) . '</a>';
                    echo '</li>';
                    $i++;
                } else {
                    break;
                }
            }
            echo '</ul>';
            echo '<p class="community-events-footer">';
            echo '<a href="https://blog.palleon.website/" target="_blank">' . esc_html__( 'Blog', 'palleon' ). ' <span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
            echo ' | ';
            echo '<a href="https://palleon.website/documentation/" target="_blank">' . esc_html__( 'Documentation', 'palleon' ). ' <span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
            echo ' | ';
            echo '<a href="https://palleon.website/update-history/palleon.html" target="_blank">' . esc_html__( 'Update History', 'palleon' ). ' <span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
            echo '</p>';
            echo '</div>';
        }
    }

    /**
	 * Allowed additional mime types (Optional)
	 */
    public function mime_types($mimes) {
        $allowSVG =  PalleonSettings::get_option('allow_svg', 'enable');
        $allowJSON =  PalleonSettings::get_option('allow_json', 'enable');
        if ($allowSVG == 'enable') {
            $mimes['svg'] = 'image/svg+xml';
        }
        if ($allowJSON == 'enable') {
            $mimes['json'] = 'application/json';
        }
        return $mimes;
    }

    function modify_post_mime_types( $post_mime_types ) {
        $post_mime_types['image/svg+xml'] = array(esc_html__('SVG Images','palleon'));
        $post_mime_types['image/tiff'] = array(esc_html__('TIFF Images','palleon'));
        $post_mime_types['application/json'] = array(esc_html__('JSON Files','palleon'));
        return $post_mime_types;
    }

    /**
	 * Add author filter to media library
	 */
    public function media_add_author_dropdown() {
        $scr = get_current_screen();
        if ( $scr->base !== 'upload' ) return;

        $author   = filter_input(INPUT_GET, 'author', FILTER_SANITIZE_STRING );
        $selected = (int)$author > 0 ? $author : '-1';
        $args = array(
            'show_option_none'   => esc_html__( 'All Authors', 'palleon' ),
            'name'               => 'author',
            'selected'           => $selected
        );
        wp_dropdown_users( $args );
    }

    public function author_filter($query) {
        if ( is_admin() && $query->is_main_query() ) {
            if (isset($_GET['author']) && $_GET['author'] == -1) {
                $query->set('author', '');
            }
        }
    }

    public function mime_type_icons( $icon, $mime) { 
        if ('application/json' === $mime) {
            $icon = PALLEON_PLUGIN_URL . 'assets/default.svg';
        }
        return $icon;
    }

    /**
	 * Register Admin Page
	 */
    public function register_page(){
        add_menu_page( 
            esc_html__( 'Palleon', 'palleon' ),
            esc_html__( 'Palleon', 'palleon' ),
            'read',
            'palleon',
            array($this, 'page_output'),
            'dashicons-format-image',
            10
        ); 
    }

    /**
	 * Get Template Parts
	 */
    public static function get_template_parts(){
        $template_parts = apply_filters('palleonTemplateParts',array(
            "header" => "template-parts/header.php",
            "main-loader" => "template-parts/main-loader.php",
            "top-bar" => "template-parts/top-bar.php",
            "icon-menu" => "template-parts/icon-menu.php",
            "panel" => "template-parts/panel.php",
            "canvas" => "template-parts/canvas.php",
            "layers" => "template-parts/layers.php",
            "add-new" => "template-parts/add-new.php",
            "save" => "template-parts/save.php",
            "media-library" => "template-parts/media-library.php",
            "svg-library" => "template-parts/svg-library.php",
            "history" => "template-parts/history.php",
            "footer" => "template-parts/footer.php"
        ));
        return $template_parts;
    }

    /**
	 * Get Panel Parts
	 */
    public static function get_panel_parts(){
        $frames = PalleonSettings::get_option('module_frames', 'enable');
        $text = PalleonSettings::get_option('module_text', 'enable');
        $image = PalleonSettings::get_option('module_image', 'enable');
        $shapes = PalleonSettings::get_option('module_shapes', 'enable');
        $elements = PalleonSettings::get_option('module_elements', 'enable');
        $apps = PalleonSettings::get_option('module_apps', 'enable');
        $brushes = PalleonSettings::get_option('module_brushes', 'enable');

        $panel_parts = apply_filters('palleonPanelParts',array(
            "adjust" => "panel-parts/adjust.php",
            "templates" => "panel-parts/templates.php",
            "text" => "panel-parts/text.php",
            "image" => "panel-parts/image.php",
            "frames" => "panel-parts/frames.php",
            "shapes" => "panel-parts/shapes.php",
            "elements" => "panel-parts/elements.php",
            "icons" => "panel-parts/icons.php",
            "apps" => "panel-parts/apps.php",
            
            "brushes" => "panel-parts/brushes.php",
            "settings" => "panel-parts/settings.php"
        ));

        if ($frames != 'enable') {
            unset($panel_parts['frames']);
        }
        if ($text != 'enable') {
            unset($panel_parts['text']);
        }
        if ($image != 'enable') {
            unset($panel_parts['image']);
        }
        if ($shapes != 'enable') {
            unset($panel_parts['shapes']);
        }
        if ($elements != 'enable') {
            unset($panel_parts['elements']);
            unset($panel_parts['icons']);
        }
        if ($apps != 'enable') {
            unset($panel_parts['apps']);
        }
        if ($brushes != 'enable') {
            unset($panel_parts['brushes']);
        }

        return $panel_parts;
    }

    /**
	 * Get Menu Icons
	 */
    public static function palleon_get_menu_icons(){
        $frames = PalleonSettings::get_option('module_frames', 'enable');
        $text = PalleonSettings::get_option('module_text', 'enable');
        $image = PalleonSettings::get_option('module_image', 'enable');
        $shapes = PalleonSettings::get_option('module_shapes', 'enable');
        $elements = PalleonSettings::get_option('module_elements', 'enable');
        $apps = PalleonSettings::get_option('module_apps', 'enable');
        $brushes = PalleonSettings::get_option('module_brushes', 'enable');

        $icons = apply_filters('palleonMenuIcons',array(
            'adjust' => array('tune', esc_html__('Adjust', 'palleon')),
            'templates' => array('view_module', esc_html__('Templates', 'palleon')),
            'text' => array('title', esc_html__('Text', 'palleon')),
            'image' => array('add_photo_alternate', esc_html__('Image', 'palleon')),
            'frames' => array('wallpaper', esc_html__('Frames', 'palleon')),
            'shapes' => array('category', esc_html__('Shapes', 'palleon')),
            'elements' => array('star', esc_html__('Elements', 'palleon')),
            'icons' => array('emoji_emotions', esc_html__('Icons', 'palleon')),
            'apps' => array('apps', esc_html__('Apps', 'palleon')),
            
            'draw' => array('brush', esc_html__('Brushes', 'palleon')),
            'settings' => array('settings', esc_html__('Settings', 'palleon'))
        ));

        if ($frames != 'enable') {
            unset($icons['frames']);
        }
        if ($text != 'enable') {
            unset($icons['text']);
        }
        if ($image != 'enable') {
            unset($icons['image']);
        }
        if ($shapes != 'enable') {
            unset($icons['shapes']);
        }
        if ($elements != 'enable') {
            unset($icons['elements']);
            unset($icons['icons']);
        }
        if ($apps != 'enable') {
            unset($icons['apps']);
        }
        if ($brushes != 'enable') {
            unset($icons['draw']);
        }

        return $icons;
    }

    /**
	 * Get Apps Content
	 */
    public static function get_apps(){
        $apps =  PalleonSettings::get_option('module_apps', 'enable');
        $qrcode =  PalleonSettings::get_option('qrcode_app', 'enable');
        $barcode =  PalleonSettings::get_option('barcode_app', 'enable');
        $pdf =  PalleonSettings::get_option('pdf_app', 'enable');
        $color_thief =  PalleonSettings::get_option('color_thief_app', 'enable');
        $ml_button =  PalleonSettings::get_option('hide_ml_btns', 'show');
        $art =  PalleonSettings::get_option('art_app', 'enable');
        $brands =  PalleonSettings::get_option('brands_app', 'enable');
        $flags =  PalleonSettings::get_option('flags_app', 'enable');
        $crypto =  PalleonSettings::get_option('crypto_app', 'enable');
        $multiavatar =  PalleonSettings::get_option('multiavatar_app', 'enable');

        $get_apps = apply_filters('palleonApps',array(
            "qrcode" => "apps/qrcode.php",
            "barcode" => "apps/barcode.php",
            "pdf" => "apps/pdf.php",
            "color-thief" => "apps/color-thief.php",
            "trianglify" => "apps/trianglify.php",
            "brands" => "apps/brands.php",
            "flags" => "apps/flags.php",
            "crypto" => "apps/crypto.php",
            "multiavatar" => "apps/multiavatar.php",
        ));
        if ($qrcode == 'disable') {
            unset($get_apps['qrcode']);
        }
        if ($barcode == 'disable') {
            unset($get_apps['barcode']);
        }
        if ($pdf == 'disable') {
            unset($get_apps['pdf']);
        } else if (is_user_logged_in() && ($ml_button == 'show' || current_user_can('administrator') || current_user_can('editor'))) { 
        } else {
            unset($get_apps['pdf']);
        }
        if ($color_thief == 'disable') {
            unset($get_apps['color-thief']);
        }
        if ($art == 'disable') {
            unset($get_apps['trianglify']);
        }
        if ($brands == 'disable') {
            unset($get_apps['brands']);
        }
        if ($flags == 'disable') {
            unset($get_apps['flags']);
        }
        if ($crypto == 'disable') {
            unset($get_apps['crypto']);
        }
        if ($multiavatar == 'disable') {
            unset($get_apps['multiavatar']);
        }
        if ($apps == 'disable') {
            unset($get_apps['qrcode']);
            unset($get_apps['barcode']);
            unset($get_apps['pdf']);
            unset($get_apps['trianglify']);
            unset($get_apps['brands']);
            unset($get_apps['flags']);
            unset($get_apps['crypto']);
            unset($get_apps['multiavatar']);
        }
        return $get_apps;
    }

    /**
	 * Get List Of Apps
	 */
    public static function get_apps_list(){
        $apps =  PalleonSettings::get_option('module_apps', 'enable');
        $qrcode =  PalleonSettings::get_option('qrcode_app', 'enable');
        $barcode =  PalleonSettings::get_option('barcode_app', 'enable');
        $pdf =  PalleonSettings::get_option('pdf_app', 'enable');
        $color_thief =  PalleonSettings::get_option('color_thief_app', 'enable');
        $ml_button =  PalleonSettings::get_option('hide_ml_btns', 'show');
        $art =  PalleonSettings::get_option('art_app', 'enable');
        $brands =  PalleonSettings::get_option('brands_app', 'enable');
        $flags =  PalleonSettings::get_option('flags_app', 'enable');
        $crypto =  PalleonSettings::get_option('crypto_app', 'enable');
        $multiavatar =  PalleonSettings::get_option('multiavatar_app', 'enable');
        $get_apps = apply_filters('palleonAppsList',array(
            "qrcode" => "apps/qrcode-list.php",
            "barcode" => "apps/barcode-list.php",
            "pdf" => "apps/pdf-list.php",
            "color-thief" => "apps/color-thief-list.php",
            "trianglify" => "apps/trianglify-list.php",
            "brands" => "apps/brands-list.php",
            "flags" => "apps/flags-list.php",
            "crypto" => "apps/crypto-list.php",
            "multiavatar" => "apps/multiavatar-list.php",
        ));
        if ($qrcode == 'disable') {
            unset($get_apps['qrcode']);
        }
        if ($barcode == 'disable') {
            unset($get_apps['barcode']);
        }
        if ($pdf == 'disable') {
            unset($get_apps['pdf']);
        } else if (is_user_logged_in() && ($ml_button == 'show' || current_user_can('administrator') || current_user_can('editor'))) { 
        } else {
            unset($get_apps['pdf']);
        }
        if ($color_thief == 'disable') {
            unset($get_apps['color-thief']);
        }
        if ($art == 'disable') {
            unset($get_apps['trianglify']);
        }
        if ($brands == 'disable') {
            unset($get_apps['brands']);
        }
        if ($flags == 'disable') {
            unset($get_apps['flags']);
        }
        if ($crypto == 'disable') {
            unset($get_apps['crypto']);
        }
        if ($multiavatar == 'disable') {
            unset($get_apps['multiavatar']);
        }
        if ($apps == 'disable') {
            unset($get_apps['qrcode']);
            unset($get_apps['barcode']);
            unset($get_apps['pdf']);
            unset($get_apps['trianglify']);
            unset($get_apps['brands']);
            unset($get_apps['flags']);
            unset($get_apps['crypto']);
            unset($get_apps['multiavatar']);
        }
        return $get_apps;
    }

    /**
	 * HTML Compress
	 */
    public static function ob_html_compress($buf){
        return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$buf));
    }

    /**
	 * Page Output
	 */
    public static function page_output(){
        $template_parts = self::get_template_parts();

        if (!is_user_logged_in()) {
            unset($template_parts["media-library"]);
            unset($template_parts["svg-library"]);
        }

        foreach ( $template_parts as $template) {
            include_once($template);
        }
    }

    /**
     * Backend
     * Catches our query variable. If it’s there, we’ll stop the
     * rest of WordPress from loading and load the photo editor
     */
    public function page_check() {
        do_action('palleon_init_hook');
        global $pagenow;
        $slug =  'palleon';
        if(!isset($_GET['page']) || empty($_GET['page']) || $pagenow != 'admin.php' || wp_doing_ajax()) {
            return;
        } else {
            if($_GET['page'] == $slug && isset($_GET['attachment_id'])) {
                do_action('palleon_backend');
                if (empty($_GET['attachment_id'])) {
                    wp_die(esc_html__('Attachment ID is required.', 'palleon'));
                } else {
                    $author = get_post_field('post_author', $_GET['attachment_id']);
                    if (current_user_can('administrator') || current_user_can('editor') || $author == get_current_user_id()) {
                        ob_start(array($this,'ob_html_compress'));
                        $this->page_output();
                        ob_end_flush();
                        exit();
                    } else {
                        wp_die(esc_html__('You are not allowed to edit this image.', 'palleon'));
                    }
                }
            } else if($_GET['page'] == $slug) {
                do_action('palleon_backend');
                ob_start(array($this,'ob_html_compress'));
                $this->page_output();
                ob_end_flush();
                exit();
            } else {
                return;
            }
        }
    }

    /**
     * Frontend
     * Catches our query variable. If it’s there, we’ll stop the
     * rest of WordPress from loading and load the photo editor
     */
    public function page_check_frontend() {
        do_action('palleon_init_hook');
        $editor = PalleonSettings::get_option('fe_editor','disable');
        $slug =  PalleonSettings::get_option('fe_slug', 'palleon');
        $login_required = PalleonSettings::get_option('fe_login_required','disable');
        $redirect_url = get_site_url() . '?page=' . $slug;
        if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] == $slug && !is_admin() && !wp_doing_ajax()) {
            if ($editor == 'enable') {
                do_action('palleon_frontend');
                if ($login_required == 'enable' && !is_user_logged_in()) {
                    wp_redirect(wp_login_url($redirect_url));
                    exit();
                }
                if(isset($_GET['attachment_id'])) {
                    if (empty($_GET['attachment_id'])) {
                        wp_die(esc_html__('Attachment ID is required.', 'palleon'));
                    } else {
                        if (is_user_logged_in()) {
                            $author = get_post_field('post_author', $_GET['attachment_id']);
                            if (current_user_can('administrator') || current_user_can('editor') || $author == get_current_user_id()) {
                                ob_start(array($this,'ob_html_compress'));
                                $this->page_output();
                                ob_end_flush();
                                exit();
                            } else {
                                wp_die(esc_html__('You are not allowed to edit this image.', 'palleon'));
                            }
                        } else {
                            wp_die(esc_html__('You are not allowed to edit this image.', 'palleon'));
                        }
                    }
                } else {
                    ob_start(array($this,'ob_html_compress'));
                    $this->page_output();
                    ob_end_flush();
                    exit();
                }
            } else {
                wp_die(esc_html__('Front-end photo editor is disabled.', 'palleon'));
            }
        } else {
            return;
        }
    }

    /**
	 * Scripts and Styles.
     * Since we've created a bare-bones separate admin page for the photo editor, there is no point to use "admin_enqueue_scripts".
     * Please see "page_check" function above.
	 */

    /**
	 * Get Stylesheets
	 */
    public static function get_stylesheets(){
        $suffix = ( defined( 'PALLEON_SCRIPT_DEBUG' ) && PALLEON_SCRIPT_DEBUG ) ? '' : '.min';
        $default_theme = PalleonSettings::get_option('default_theme','dark');
        $custom_theme = Palleon::get_user_option('custom-theme', get_current_user_id(), $default_theme);

        $styles = apply_filters('palleonStylesheets',array(
            'material-icons' => array('https://fonts.googleapis.com/icon?family=Material+Icons', ''),
            'plugins-css' => array(PALLEON_PLUGIN_URL . 'css/plugins.min.css', PALLEON_VERSION),
            'style' => array(PALLEON_PLUGIN_URL . 'css/style'. $suffix . '.css', PALLEON_VERSION),
            'theme-link' => array(PALLEON_PLUGIN_URL . 'css/' . $custom_theme  . $suffix . '.css', PALLEON_VERSION)
        ));

        return $styles;
    }

    /**
	 * Print Styles
	 */
    public function styles(){
        $stylesheets = self::get_stylesheets();
        foreach($stylesheets as $id => $key) { 
            $ver = '';
            if (!empty($key[1])) {
                $ver = '?ver=' . $key[1];
            }
            echo '<link id="palleon-' . esc_attr($id) . '" href="' . esc_url($key[0] . $ver) . '" rel="stylesheet" type="text/css">';
        }
        $primary_color = PalleonSettings::get_option('primary_color','#6658ea');
        $secondary_color = PalleonSettings::get_option('secondary_color','#5546e8');
        $custom_css = PalleonSettings::get_option('custom_css','');
        $font_size = $this->get_user_option('custom-font-size', get_current_user_id(), 14);
        $guide_color = $this->get_user_option('ruler-guide-color', get_current_user_id(), '#6658ea');
        $guide_size = $this->get_user_option('ruler-guide-size', get_current_user_id(), '1');
        $allow_img = PalleonSettings::get_option('allow_img','enable'); 
        $inline_style = '';

        if ($allow_img != 'enable' && !current_user_can('administrator')) { 
            $inline_style .= '.antimena-img-save {display:none !important;}';
        }
        if (!empty($font_size)) {
            $inline_style .= 'html {font-size:' . $font_size . 'px;}';
        }
        if (!empty($guide_color) && $guide_color != '#6658ea') {
            $inline_style .= '.guide.h, .guide.v {border-color:' . $guide_color . ';}';
        }
        if (!empty($guide_size) && $guide_size != '1') {
            $inline_style .= '.guide.h, .guide.v {border-width:' . $guide_size . 'px;}';
        }
        if (!empty($primary_color) && $primary_color != '#6658ea') {
            $inline_style .= '.palleon-loader {border-top-color: ' . $primary_color . ';}';
            $inline_style .= '.notice {border-left-color: ' . $primary_color . ';}';
            $inline_style .= '.palleon-img-loader {border-top-color: ' . $primary_color . ';}';
            $inline_style .= '#palleon-toggle-left:hover .material-icons,#palleon-toggle-right:hover .material-icons {color: ' . $primary_color . ';}';
            $inline_style .= 'ul.palleon-dropdown li a .material-icons {color: ' . $primary_color . ';}';
            $inline_style .= '#palleon-layers>li>.material-icons {color: ' . $primary_color . ';}';
            $inline_style .= '#palleon-no-layer a {color: ' . $primary_color . ';}';
            $inline_style .= '.palleon-frame:hover,.palleon-element:hover {color: ' . $primary_color . ';}';
            $inline_style .= '.grid-icon-item:hover {border-color: ' . $primary_color . ';}';
            $inline_style .= '.grid-icon-item .material-icons {color: ' . $primary_color . ';}';
            $inline_style .= '.palleon-btn.active,.palleon-btn.active:hover,.palleon-btn.primary {background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-pagination ul li.active,.palleon-pagination ul li.active:hover {border-color: ' . $primary_color . ';background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-pagination ul li:hover {border-color: ' . $primary_color . ';}';
            $inline_style .= '.palleon-accordion .palleon-pagination ul li.active,.palleon-accordion .palleon-pagination ul li.active:hover {background: ' . $primary_color . ';}';
            $inline_style .= 'ul.palleon-accordion > li.opened {border-color: ' . $primary_color . ';}';
            $inline_style .= 'ul.palleon-accordion > li > a >.data-count {background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-slider::-webkit-slider-thumb{background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-slider::-moz-range-thumb {background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-form-field:focus {border-color: ' . $primary_color . ';}';
            $inline_style .= '.sp-container button.sp-choose {background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-select:focus {border-color: ' . $primary_color . ';}';
            $inline_style .= '.select2-container--dark .select2-results__option--highlighted[aria-selected] {background: ' . $primary_color . ' !important;}';
            $inline_style .= '.select2-container--dark .select2-results__option[aria-selected=true] {background: ' . $primary_color . ';}';
            $inline_style .= '.select2-container--dark .select2-search input:focus {border-color: ' . $primary_color . ';}';
            $inline_style .= '.palleon-tabs-menu li.active {background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-toggle-checkbox:checked+.palleon-toggle-switch,.imgur-edit-icon {background: ' . $primary_color . ';}';
            $inline_style .= '.palleon-checkbox input:checked~.palleon-checkmark {background-color: ' . $primary_color . ';border-color: ' . $primary_color . ';}';
            $inline_style .= '#palleon-history-list li .info .material-icons {color: ' . $primary_color . ';}';
            $inline_style .= 'a.pexels-url,a.pixabay-url,#palleon-dummy-text:hover {color: ' . $primary_color . ';}';
            $inline_style .= '.menu-btn {background-color: ' . $primary_color . ';}';
            $inline_style .= 'body.dark-theme #commentform select:focus, body.dark-theme #comment:focus, body.dark-theme #author:focus, body.dark-theme #email:focus, body.light-theme #commentform select:focus {border: 1px solid ' . $primary_color . ';}';
            $inline_style .= '.palleon-shape:hover,.note-btn-primary {background: ' . $primary_color . ';}';
        }
        if (!empty($secondary_color) && $secondary_color != '#5546e8') {
            $inline_style .= '.palleon-btn:hover,.palleon-btn.primary:hover,.note-btn-primary:hover,.imgur-edit-icon:hover {background: ' . $secondary_color . ';}';
            $inline_style .= '.sp-container button.sp-choose:hover,.sp-container button.sp-choose:focus {background: ' . $secondary_color . ';}';
        }

        if (!empty($custom_css)) {
            $inline_style .= $custom_css;
        }
        echo '<style>' . $inline_style . '</style>';
    }

    /**
	 * Get Scripts
	 */
    public static function get_scripts(){
        $suffix = ( defined( 'PALLEON_SCRIPT_DEBUG' ) && PALLEON_SCRIPT_DEBUG ) ? '' : '.min';
        $slug =  PalleonSettings::get_option('fe_slug', 'palleon');
        $be_slug =  'palleon';
        $apps =  PalleonSettings::get_option('module_apps', 'enable');
        $qrcode =  PalleonSettings::get_option('qrcode_app', 'enable');
        $barcode =  PalleonSettings::get_option('barcode_app', 'enable');
        $pdf =  PalleonSettings::get_option('pdf_app', 'enable');
        $color_thief =  PalleonSettings::get_option('color_thief_app', 'enable');
        $ml_button =  PalleonSettings::get_option('hide_ml_btns', 'show');
        $art =  PalleonSettings::get_option('art_app', 'enable');
        $multiavatar =  PalleonSettings::get_option('multiavatar_app', 'enable');

        $scripts = array(
            'jquery' => array(PALLEON_PLUGIN_URL . 'js/jquery.min.js', '3.6.3'),
            'jquery-ui' => array(PALLEON_PLUGIN_URL . 'js/jquery-ui.min.js', '1.13.2'),
            'fabric' => array(PALLEON_PLUGIN_URL . 'js/fabric.min.js', '5.3.0'),
            'plugins-js' => array(PALLEON_PLUGIN_URL . 'js/plugins.min.js', PALLEON_VERSION),
            'ruler' => array(PALLEON_PLUGIN_URL . 'js/rulers-guides'.$suffix.'.js', PALLEON_VERSION),
            'qrcode' => array(PALLEON_PLUGIN_URL . 'js/qrcode.min.js', PALLEON_VERSION),
            'barcode' => array(PALLEON_PLUGIN_URL . 'js/barcode.min.js', PALLEON_VERSION),
            'jspdf' => array(PALLEON_PLUGIN_URL . 'js/jspdf.min.js', '2.5.2'),
            'color-thief' => array(PALLEON_PLUGIN_URL . 'js/color-thief.min.js', PALLEON_VERSION),
            'trianglify' => array(PALLEON_PLUGIN_URL . 'js/trianglify.min.js', PALLEON_VERSION),
            'multiavatar' => array(PALLEON_PLUGIN_URL . 'js/multiavatar.min.js', PALLEON_VERSION),
            //'palleon-js' => array(PALLEON_PLUGIN_URL . 'js/palleon' . $suffix . '.js', PALLEON_VERSION),
            // For development debugging, use: 
            'palleon-js' => array(PALLEON_PLUGIN_URL . 'js/palleon.js', PALLEON_VERSION),
        );

        if ($qrcode == 'disable') {
            unset($scripts['qrcode']);
        }
        if ($barcode == 'disable') {
            unset($scripts['barcode']);
        }
        if ($pdf == 'disable') {
            unset($scripts['jspdf']);
        } else if (is_user_logged_in() && ($ml_button == 'show' || current_user_can('administrator') || current_user_can('editor'))) { 
        } else {
            unset($scripts['jspdf']);
        }
        if ($color_thief == 'disable') {
            unset($scripts['color-thief']);
        }
        if ($art == 'disable') {
            unset($scripts['trianglify']);
        }
        if ($multiavatar == 'disable') {
            unset($scripts['multiavatar']);
        }
        if ($apps == 'disable') {
            unset($scripts['qrcode']);
            unset($scripts['barcode']);
            unset($scripts['jspdf']);
            unset($scripts['trianglify']);
            unset($scripts['multiavatar']);
        }

        if(isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == $slug || $_GET['page'] == $be_slug) && !wp_doing_ajax()) { 
            $scripts['init'] = array(PALLEON_PLUGIN_URL . 'js/init'.$suffix.'.js', PALLEON_VERSION);
            // For development debugging, use: $scripts['init'] = array(PALLEON_PLUGIN_URL . 'js/init.js', PALLEON_VERSION);
        }

        $scripts = apply_filters('palleonScripts', $scripts);

        return $scripts;
    }

    /**
	 * Print Scripts
	 */
    public function scripts(){
        $version = (is_user_logged_in()) ? 'backend' : 'frontend';
        $proCheck = ( Palleon::can_use_template()) ? 'yes' : 'no';
        $proTemplate = 'free';
        if (isset($_GET['template_id']) && !empty($_GET['template_id'])) {
            $proTemplate = ( Palleon::is_pro_template($_GET['template_id'])) ? 'pro' : 'free';
        }
        $suffix = ( defined( 'PALLEON_SCRIPT_DEBUG' ) && PALLEON_SCRIPT_DEBUG ) ? '' : '.min';
        $enableGLFiltering = PalleonSettings::get_option('webgl_filtering','true');  
        $textureSize = PalleonSettings::get_option('texture_size',4096);
        $proInfoTitle = PalleonSettings::get_option('fe_pro_info_title',esc_html__( 'Login Required', 'palleon' ));
        $proInfo = PalleonSettings::get_option('fe_pro_info',esc_html__( 'You must login to use PRO templates.', 'palleon' ));
        $upgradeInfoTitle = PalleonSettings::get_option('be_pro_info_title',esc_html__( 'Login Required', 'palleon' ));
        $upgradeInfo = PalleonSettings::get_option('be_pro_info',esc_html__( 'You need to upgrade your membership level to use this template.', 'palleon' ));
        $alpha_color = PalleonSettings::get_option('alpha_color','true');
        $watermark = PalleonSettings::get_option('watermark','none');
        $watermarkText = PalleonSettings::get_option('watermark_text',esc_html__( 'palleon.website', 'palleon' ));
        $watermarkFontFamily = PalleonSettings::get_option('watermark_font_family','Georgia, serif');
        $watermarkFontColor = PalleonSettings::get_option('watermark_font_color','#000000');
        $watermarkFontSize = PalleonSettings::get_option('watermark_font_size',40);
        $watermarkFontWeight = PalleonSettings::get_option('watermark_font_weight','normal');
        $watermarkStrokeColor = PalleonSettings::get_option('watermark_stroke_color','#FFFFFF');
        $watermarkFontStyle = PalleonSettings::get_option('watermark_font_style','normal');
        $watermarkLocation = PalleonSettings::get_option('watermark_location','bottom-right');
        $share = PalleonSettings::get_option('share','enable');
        ?>
        <script>
        /* <![CDATA[ */
        var palleonParams = {
            "baseURL": "<?php echo PALLEON_PLUGIN_URL; ?>",
            "sourceURL": "<?php echo PALLEON_SOURCE_URL; ?>",
            "suffix": "<?php echo esc_js($suffix); ?>",
            "version": "<?php echo esc_js($version); ?>",
            "userid": "<?php echo esc_js(get_current_user_id()); ?>",
            "ajaxurl":"<?php echo admin_url( 'admin-ajax.php' ); ?>",
            "nonce":"<?php echo wp_create_nonce('palleon-nonce'); ?>",
            "textbox":"<?php echo esc_html__('Enter Your Text Here.', 'palleon'); ?>",
            "object":"<?php echo esc_html__('Object', 'palleon'); ?>",
            "loading":"<?php echo esc_html__('Loading...', 'palleon'); ?>",
            "loadmore":"<?php echo esc_html__('Load More', 'palleon'); ?>",
            "refresh":"<?php echo esc_html__('Refresh', 'palleon'); ?>",
            "wrong":"<?php echo esc_html__('Something went wrong.', 'palleon'); ?>",
            "settingsaved":"<?php echo esc_html__('Settings Saved!', 'palleon'); ?>",
            "saved":"<?php echo esc_html__('Saved!', 'palleon'); ?>",
            "imgsaved":"<?php echo esc_html__('Image is saved.', 'palleon'); ?>",
            "tempsaved":"<?php echo esc_html__('Template is saved.', 'palleon'); ?>",
            "freeDrawing":"<?php echo esc_html__('Free drawing', 'palleon'); ?>",
            "frame":"<?php echo esc_html__('Frame', 'palleon'); ?>",
            "image":"<?php echo esc_html__('Image', 'palleon'); ?>",
            "circle":"<?php echo esc_html__('Circle', 'palleon'); ?>",
            "square":"<?php echo esc_html__('Square', 'palleon'); ?>",
            "rectangle":"<?php echo esc_html__('Rectangle', 'palleon'); ?>",
            "triangle":"<?php echo esc_html__('Triangle', 'palleon'); ?>",
            "ellipse":"<?php echo esc_html__('Ellipse', 'palleon'); ?>",
            "trapezoid":"<?php echo esc_html__('Trapezoid', 'palleon'); ?>",
            "pentagon":"<?php echo esc_html__('Pentagon', 'palleon'); ?>",
            "octagon":"<?php echo esc_html__('Octagon', 'palleon'); ?>",
            "emerald":"<?php echo esc_html__('Emerald', 'palleon'); ?>",
            "star":"<?php echo esc_html__('Star', 'palleon'); ?>",
            "element":"<?php echo esc_html__('Element', 'palleon'); ?>",
            "customSvg":"<?php echo esc_html__('Custom SVG', 'palleon'); ?>",
            "success":"<?php echo esc_html__('Success', 'palleon'); ?>",
            "error":"<?php echo esc_html__('Error', 'palleon'); ?>",
            "uploaded":"<?php echo esc_html__('The file is uploaded.', 'palleon'); ?>",
            "deleted":"<?php echo esc_html__('The file is deleted.', 'palleon'); ?>",
            "favorited":"<?php echo esc_html__('The item has been favorited.', 'palleon'); ?>",
            "unfavorited":"<?php echo esc_html__('The item has been unfavorited.', 'palleon'); ?>",
            "delete":"<?php echo esc_html__('Delete', 'palleon'); ?>",
            "duplicate":"<?php echo esc_html__('Duplicate', 'palleon'); ?>",
            "showhide":"<?php echo esc_html__('Show/Hide', 'palleon'); ?>",
            "lockunlock":"<?php echo esc_html__('Lock/Unlock', 'palleon'); ?>",
            "enableGLFiltering": <?php echo esc_js($enableGLFiltering); ?>,
            "textureSize": <?php echo esc_js($textureSize); ?>,
            "nothing":"<?php echo esc_html__('Nothing Found.', 'palleon'); ?>",
            "text":"<?php echo esc_html__('Text', 'palleon'); ?>",
            "started":"<?php echo esc_html__('Editing started.', 'palleon'); ?>",
            "added":"<?php echo esc_html__('added.', 'palleon'); ?>",
            "removed":"<?php echo esc_html__('removed.', 'palleon'); ?>",
            "resized":"<?php echo esc_html__('resized.', 'palleon'); ?>",
            "edited":"<?php echo esc_html__('edited.', 'palleon'); ?>",
            "replaced":"<?php echo esc_html__('replaced.', 'palleon'); ?>",
            "rotated":"<?php echo esc_html__('rotated.', 'palleon'); ?>",
            "moved":"<?php echo esc_html__('moved.', 'palleon'); ?>",
            "scaled":"<?php echo esc_html__('scaled.', 'palleon'); ?>",
            "flipped":"<?php echo esc_html__('flipped.', 'palleon'); ?>",
            "cropped":"<?php echo esc_html__('cropped.', 'palleon'); ?>",
            "bg":"<?php echo esc_html__('Canvas', 'palleon'); ?>",
            "filter":"<?php echo esc_html__('filter', 'palleon'); ?>",
            "answer1":"<?php echo esc_html__('Are you sure you want to delete the template permanently?', 'palleon'); ?>",
            "answer2":"<?php echo esc_html__('Are you sure you want to delete the image permanently?', 'palleon'); ?>",
            "answer3":"<?php echo esc_html__('Are you sure you want clear the history?', 'palleon'); ?>",
            "answer4":"<?php echo esc_html__('Are you sure you want to delete the layers?', 'palleon'); ?>",
            "watermark": "<?php echo esc_js($watermark); ?>",
            "watermarkText": "<?php echo esc_js($watermarkText); ?>",
            "watermarkFontFamily": "<?php echo esc_js($watermarkFontFamily); ?>",
            "watermarkFontColor": "<?php echo esc_js($watermarkFontColor); ?>",
            "watermarkFontSize": "<?php echo esc_js($watermarkFontSize); ?>",
            "watermarkStrokeColor": "<?php echo esc_js($watermarkStrokeColor); ?>",
            "watermarkFontStyle": "<?php echo esc_js($watermarkFontStyle); ?>",
            "watermarkLocation": "<?php echo esc_js($watermarkLocation); ?>",
            "watermarkFontWeight": "<?php echo esc_js($watermarkFontWeight); ?>",
            "proInfoTitle": "<?php echo esc_js($proInfoTitle); ?>",
            "upgradeInfoTitle": "<?php echo esc_js($upgradeInfoTitle); ?>",
            "proInfo": '<?php echo addcslashes(wp_kses_post($proInfo), "'"); ?>',
            "upgradeInfo": '<?php echo addcslashes(wp_kses_post($upgradeInfo), "'"); ?>',
            "proCheck": "<?php echo esc_js($proCheck); ?>",
            "proTemplate": "<?php echo esc_js($proTemplate); ?>",
            "showRulers": "<?php echo esc_html__('Show rulers', 'palleon'); ?>",
            "hideRulers": "<?php echo esc_html__('Hide rulers', 'palleon'); ?>",
            "showGuides": "<?php echo esc_html__('Show guides', 'palleon'); ?>",
            "hideGuides": "<?php echo esc_html__('Hide guides', 'palleon'); ?>",
            "clearAllGuides": "<?php echo esc_html__('Clear all guides', 'palleon'); ?>",
            "printArea": "<?php echo esc_html__('Print Area', 'palleon'); ?>",
            "alphaColor": "<?php echo esc_js($alpha_color); ?>",
            "maxUploadSize":"<?php echo esc_html__('File is too big! Maximum image size allowed is', 'palleon'); ?>",
            "noDuplicate":"<?php echo esc_html__('You can not duplicate multiple objects. Please select single object to duplicate.', 'palleon'); ?>",
            "warning": "<?php echo esc_html__('Warning', 'palleon'); ?>",
            "app": "<?php echo esc_html__('App', 'palleon'); ?>",
            "startDrawing": "<?php echo esc_html__('Start Drawing', 'palleon'); ?>",
            "stopDrawing": "<?php echo esc_html__('Stop Drawing', 'palleon'); ?>",
            "erased": "<?php echo esc_html__('Pixels erased.', 'palleon'); ?>",
            "share": "<?php echo esc_js($share); ?>",
            "shareImage": "<?php echo esc_html__('Share Image', 'palleon'); ?>",
            "shareTemplate": "<?php echo esc_html__('Share Template', 'palleon'); ?>",
            "copied": "<?php echo esc_html__('Copied!', 'palleon'); ?>",
            "copyURL": "<?php echo esc_html__('Copy URL', 'palleon'); ?>",
            "fileLimit": "<?php echo esc_html__('You have reached the maximum number of files allowed. Delete some files to save new ones.', 'palleon'); ?>",
            "fillColor": "<?php echo esc_html__('Fill Color', 'palleon'); ?>",
            "mask": "<?php echo esc_html__('mask', 'palleon'); ?>",
            "parallelogram": "<?php echo esc_html__('Parallelogram', 'palleon'); ?>",
            "diamond": "<?php echo esc_html__('Diamond', 'palleon'); ?>",
            "customShape":"<?php echo esc_html__('Custom Shape', 'palleon'); ?>",
            "easyAccessTemplate": "<?php echo esc_html__('Your saved templates will show up here for easy access.', 'palleon'); ?>",
            "select": "<?php echo esc_html__('Select', 'palleon'); ?>",
            "notitle": "<?php echo esc_html__('(No Title)', 'palleon'); ?>",
            "nocolor": "<?php echo esc_html__('No colors found.', 'palleon'); ?>",
            "wrongFormat":"<?php echo esc_html__('Only JPG, JPEG, PNG and WEBP file formats are supported.', 'palleon'); ?>",
            "group": "<?php echo esc_html__('Group', 'palleon'); ?>",
            "grouped": "<?php echo esc_html__('Objects grouped.', 'palleon'); ?>",
            "ungrouped": "<?php echo esc_html__('Objects ungrouped.', 'palleon'); ?>"
        };
        /* ]]> */
        </script>
        <?php
        $scripts = self::get_scripts();
        foreach($scripts as $id => $key) { 
            $ver = '';
            if (!empty($key[1])) {
                $ver = '?ver=' . $key[1];
            }
            echo '<script id="palleon-' . esc_attr($id) . '" type="text/javascript" src="' . esc_url($key[0] . $ver) . '"></script>';
        }
    }

    /**
	 * Add custom edit links to the media library
	 */
    public function edit_links($actions, $post) {
        $be_slug =  'palleon';
        if (current_user_can('administrator') || current_user_can('editor') || (get_the_author_meta( 'ID' ) == get_current_user_id())) {
            if ( 'image/png' == $post->post_mime_type || 'image/jpeg' == $post->post_mime_type || 'image/jpg' == $post->post_mime_type || 'image/webp' == $post->post_mime_type || 'application/json' == $post->post_mime_type) {
                $actions['palleon'] = '<a href="' . admin_url('admin.php?page=' . $be_slug . '&attachment_id=' . $post->ID) . '">' . esc_html__('Edit with Palleon', 'palleon') . '</a>';
            }
        }
        return $actions;    
    }

    /**
	 * Attachment Metabox
	 */
    public function attachment_metabox() {
        function palleon_attachment_metabox_before_row( $field_args, $field ) {
            $be_slug =  'palleon';
            $post = get_post();
            if ( 'image/png' == $post->post_mime_type || 'image/jpeg' == $post->post_mime_type || 'image/jpg' == $post->post_mime_type || 'image/webp' == $post->post_mime_type || 'application/json' == $post->post_mime_type) {
                echo '<a href="' . admin_url('admin.php?page=' . $be_slug . '&attachment_id=' . $post->ID) . '" class="button">' . esc_html__( 'Edit with Palleon', 'palleon' ) . '</a>';
            } else {
                echo '<style>#palleon_attachment_btns {display: none !important}</style>';
            }
        }

        $metabox = new_cmb2_box( array(
            'id'      => 'palleon_attachment_btns',
            'title'   => esc_html__( 'Edit with Palleon', 'palleon' ),
            'object_types'  => array( 'attachment' ),
            'context' => 'side',
            'show_names' => true,
        ));
        
        $metabox->add_field( array(
            'id'      => 'palleon_attachment_buttons',
            'type' => 'title',
            'after_row' => 'palleon_attachment_metabox_before_row'
        ) );
    }

    /**
	 * Upload Img to media library
	 */
    public function upload_img_to_library(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/webp');
        if (in_array($_FILES['file']['type'], $arr_img_ext)) {
            $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $post_title = $path_parts['filename'];
            $info = wp_check_filetype( $upload['file'] );
            $post = [
                'post_title' => $post_title,
                'guid' => $upload['url'],
                'post_mime_type' => $info['type']
            ];
            $post_id = wp_insert_attachment( $post, $upload['file'] );
            wp_update_attachment_metadata(
                $post_id,
                wp_generate_attachment_metadata( $post_id, $upload['file'] )
            );
        } else {
            wp_send_json_error(esc_html__('This file type is not allowed.', 'palleon'));
        }
        wp_die();
    }

    /**
	 * Upload SVG to media library
	 */
    public function upload_svg_to_library(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $arr_img_ext = array('image/svg+xml');
        if (in_array($_FILES['file']['type'], $arr_img_ext)) {
            $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $post_title = $path_parts['filename'];
            $info = wp_check_filetype( $upload['file'] );
            $post = [
                'post_title' => $post_title,
                'guid' => $upload['url'],
                'post_mime_type' => $info['type']
            ];
            $post_id = wp_insert_attachment( $post, $upload['file'] );
            wp_update_attachment_metadata(
                $post_id,
                wp_generate_attachment_metadata( $post_id, $upload['file'] )
            );
        } else {
            wp_send_json_error(esc_html__('This file type is not allowed.', 'palleon'));
        }
        wp_die();
    }

    /**
    * Register User Metabox
    */
    public function max_files_num_metabox() {
        $user_credits = new_cmb2_box( array(
            'id'      => 'palleon_max_files_num_metabox',
            'title'   => esc_html__( 'Max. number of files allowed', 'palleon' ),
            'object_types'  => array( 'user' ),
            'cmb_styles' => true,
            'show_names' => true,
            'show_on_cb' => array($this, 'max_files_num_capability')
        ));
        
        $user_credits->add_field( array(
            'id'      => 'palleon_max_files_num',
            'name'   => esc_html__( 'Max. number of files allowed', 'palleon' ),
            'description'   => esc_html__( 'Set the maximum number of files (image and template files) allowed to be stored in your media library for this user.', 'palleon' ),
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'autocomplete' => 'off'
            ),
            'default' => ''
        ) );
    }

    public function max_files_num_capability( $cmb ) {
        return current_user_can( 'manage_options' );
    }

    /**
	 * Save Image
	 */
    public function save_image(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $allow_img = PalleonSettings::get_option('allow_img','enable'); 
        if ($allow_img != 'enable' && !current_user_can('administrator')) { 
            echo '404';
            wp_die();
        }
        $user_id = get_current_user_id();
        $max_files_num = PalleonSettings::get_option('max_files_num', '');
        $max_files_num_user = get_user_meta($user_id, 'palleon_max_files_num', true);
        if (!empty($max_files_num_user)) {
            $max_files_num = $max_files_num_user;
        }

        if (!empty($max_files_num) && !current_user_can('administrator') && !current_user_can('editor')) {
            $max_files_num = intval($max_files_num);
            $my_images_args = array(
                'post_type'      => 'attachment',
                'post_mime_type' => 'image/png, image/jpeg, image/webp, image/svg+xml, application/json',
                'post_status'    => 'inherit',
                'posts_per_page' => - 1,
                'author' => $user_id,
                'relation' => 'OR',
                'meta_query' => array(
                    array(
                    'key' => 'palleon_hide',
                    'compare' => 'NOT EXISTS'
                    ),
                )
            );  
            $my_images = new WP_Query( $my_images_args );
            $my_images_num = $my_images->found_posts;

            if ($my_images_num >= $max_files_num) {
                echo '404';
                wp_die();
            }
        }

        // Upload dir.
        $upload_dir  = wp_upload_dir();
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

        $img = '';
        $format = $_POST['format'];

        if ($format == 'svg') {
            $img = str_replace('\"', '"', $_POST['url']);
            $img = str_replace("\'", "'", $img);
        } else {
            $img = str_replace( 'data:' . $_POST['type'] . ';base64,', '', $_POST['url'] );
            $img = str_replace( ' ', '+', $img );
            $img = base64_decode( $img );
        }

        if ($format == 'base64') {
            $format = 'png';
        }
        
        $filename  = $_POST['filename'] . '.' . $format;

        // Save the image in the uploads directory.
        $upload_file = file_put_contents( $upload_path . $filename, $img );

        $attachment = array(
            'post_mime_type' => $_POST['type'],
            'post_title'     => esc_html($_POST['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => $upload_dir['url'] . '/' . basename( $filename )
        );

        if (!empty($_POST['id']) && $_POST['mode'] == 'image' && get_post_mime_type($_POST['id']) != 'application/json') {
            update_attached_file( $_POST['id'], $upload_dir['path'] . '/' . $filename );
            wp_update_attachment_metadata(
                $_POST['id'],
                wp_generate_attachment_metadata( $_POST['id'], $upload_dir['path'] . '/' . $filename )
            );
            echo esc_url(wp_get_attachment_url($_POST['id']));
        } else {
            $attachment_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $filename );
            wp_update_attachment_metadata(
                $attachment_id,
                wp_generate_attachment_metadata( $attachment_id, $upload_dir['path'] . '/' . $filename )
            );
            echo esc_url(wp_get_attachment_url($attachment_id));
        }

        wp_die();
    }

    /**
	 * Load My Templates
	 */
    public function load_my_templates(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $frontend =  PalleonSettings::get_option('fe_editor', 'disable');
        $slug =  PalleonSettings::get_option('fe_slug', 'palleon');
        $share =  PalleonSettings::get_option('share', 'enable');
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        $my_temps = new WP_Query( $args );
        foreach ( $my_temps->posts as $temp ) {
            $temp_ID = $temp->ID;
            $temp_url = wp_get_attachment_url($temp_ID);
            $temp_title = get_the_title($temp_ID);
            ?>
            <li data-keyword="<?php echo esc_attr($temp_title); ?>">
                <div><?php echo esc_html($temp_title); ?></div>
                <div>
                    <button type="button" class="palleon-btn primary palleon-select-template" data-json="<?php echo esc_url($temp_url); ?>"><span class="material-icons">check</span><?php echo esc_html__('Select', 'palleon'); ?></button>
                    <?php if ($frontend == 'enable' && $share == 'enable') { ?>
                    <button type="button" class="palleon-btn success palleon-share-template" data-json="<?php echo esc_url(get_site_url() . '?page=' . $slug . '&item_id=' . $temp_ID); ?>"><span class="material-icons">share</span><?php echo esc_html__('Share', 'palleon'); ?></button>
                    <?php } ?>
                    <button type="button" class="palleon-btn danger palleon-template-delete" data-target="<?php echo esc_attr($temp_ID); ?>"><span class="material-icons">clear</span><?php echo esc_html__('Delete', 'palleon'); ?></button>
                </div>
            </li>
            <?php
        }
        wp_die();
    }

    /**
	 * Load My Images
	 */
    public function load_my_images(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $share = PalleonSettings::get_option('share','enable');
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        $my_images = new WP_Query( $args );
        if ($my_images->have_posts()) {
            foreach ( $my_images->posts as $image ) { 
                $id = $image->ID;
                $thumb = wp_get_attachment_image_url($id, 'thumbnail', false);
                $full = wp_get_attachment_image_url($id, 'full', false);
                $title = get_the_title($id);
            ?>
            <div class="palleon-masonry-item" data-keyword="<?php echo esc_attr($title); ?>">
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
            <?php }
        }
        wp_die();
    }

    /**
	 * Load All Images
	 */
    public function load_all_images(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $share = PalleonSettings::get_option('share','enable');
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        $all_images = new WP_Query( $args );
        foreach ( $all_images->posts as $image ) { 
            $id = $image->ID;
            $thumb = wp_get_attachment_image_url($id, 'thumbnail', false);
            $full = wp_get_attachment_image_url($id, 'full', false);
            $title = get_the_title($id);
        ?>
        <div class="palleon-masonry-item" data-keyword="<?php echo esc_attr($title); ?>">
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
        <?php }
        wp_die();
    }

    /**
	 * Delete File from media library
	 */
    public function delete_file_from_library(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        wp_delete_attachment($_POST['target'], true);
    }

    /**
	 * Favorite Frame
	 */
    public function favorite_frame(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $output = '';
        $source_url = PALLEON_SOURCE_URL . 'frames/';
        $frames = get_user_meta(get_current_user_id(), 'palleon_frame_fav',true);
        if (empty($frames)) {
            add_user_meta(get_current_user_id(), 'palleon_frame_fav', array(), true);
            $frames = array();
        }
        if ($_POST['mode'] == 'remove') {
            $remove = array($_POST['frameid']);
            $frames = array_diff( $frames, $remove);
        } else {
            array_unshift($frames, $_POST['frameid']); 
        }
        update_user_meta(get_current_user_id(),'palleon_frame_fav', $frames, false);
        if ($frames == array()) {
            echo '<div class="notice notice-info"><h6>' . esc_html__( 'No favorites yet', 'palleon' ) . '</h6>' . esc_html__('Click the star icon on any frame, and you will see it here next time you visit.', 'palleon') . '</div>';
        } else {
            foreach($frames as $frame) { ?>
                <div class="palleon-frame" data-elsource="<?php echo esc_url($source_url . $frame . '.svg'); ?>">
                <div class="palleon-img-wrap">
                    <div class="palleon-img-loader"></div>
                    <img class="lazy" data-src="<?php echo esc_url($source_url . $frame . '.jpg'); ?>" />
                    <div class="frame-favorite"><button type="button" class="palleon-btn-simple star favorited" data-frameid="<?php echo esc_attr($frame); ?>"><span class="material-icons">star</span></button></div>
                </div>
                </div>
            <?php }
            }
        wp_die();
    }

    /**
	 * Favorite Element
	 */
    public function favorite_element(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $output = '';
        $source_url = PALLEON_SOURCE_URL . 'elements/';
        $elements = get_user_meta(get_current_user_id(), 'palleon_element_fav',true);
        if (empty($elements)) {
            add_user_meta(get_current_user_id(), 'palleon_element_fav', array(), true);
            $elements = array();
        }
        if ($_POST['mode'] == 'remove') {
            $remove = array($_POST['elementid']);
            $elements = array_diff( $elements, $remove);
        } else {
            array_unshift($elements, $_POST['elementid']); 
        }
        update_user_meta(get_current_user_id(),'palleon_element_fav', $elements, false); 
        if ($elements == array()) {
            echo '<div class="notice notice-info"><h6>' . esc_html__( 'No favorites yet', 'palleon' ) . '</h6>' . esc_html__('Click the star icon on any element, and you will see it here next time you visit.', 'palleon') . '</div>';
        } else {
            foreach($elements as $element) { 
                if (substr( $element, 0, 4 ) === "http") {  
                    $url_query = parse_url($element, PHP_URL_QUERY);
                    if (!empty($url_query)) {
                        parse_str($url_query, $output);
                    } else {
                        $output = array("bg"=>"dark","loader"=>"yes");
                    }
                    ?>
                    <div class="palleon-element <?php echo esc_attr($output['bg']); ?>" data-elsource="<?php echo esc_url($element); ?>" data-loader="<?php echo esc_attr($output['loader']); ?>">
                    <img class="lazy" data-src="<?php echo esc_url($element); ?>" />
                    <div class="element-favorite"><button type="button" class="palleon-btn-simple star favorited" data-elementid="<?php echo esc_attr($element); ?>"><span class="material-icons">star</span></button></div>
                    </div>
                <?php } else {
                    $tag = strtok($element, '/');
                    $elementTags = palleon_get_element_tags();
                    ?>
                    <div class="palleon-element <?php echo esc_attr($elementTags[$tag][2]); ?>" data-elsource="<?php echo esc_url($source_url . $element . '.svg'); ?>" data-loader="<?php echo esc_attr($elementTags[$tag][3]); ?>">
                    <img class="lazy" data-src="<?php echo esc_url($source_url . $element . '.svg'); ?>" />
                    <div class="element-favorite"><button type="button" class="palleon-btn-simple star favorited" data-elementid="<?php echo esc_attr($element); ?>"><span class="material-icons">star</span></button></div>
                    </div>
                    <?php
                }
            }
        }
        wp_die();
    }

   /**
	 * Favorite Template
	 */
    public function favorite_template(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $output = '';
        $templates = palleon_get_templates(false);
        $selected_templates = get_user_meta(get_current_user_id(), 'palleon_template_fav',true);
        if (empty($selected_templates)) {
            add_user_meta(get_current_user_id(), 'palleon_template_fav', array(), true);
            $selected_templates = array();
        }
        if ($_POST['mode'] == 'remove') {
            $remove = array($_POST['templateid']);
            $selected_templates = array_diff( $selected_templates, $remove);
        } else {
            array_unshift($selected_templates, $_POST['templateid']); 
        }
        update_user_meta(get_current_user_id(),'palleon_template_fav', $selected_templates, false); 
        
        
        if ($selected_templates == array()) {
            echo '<div class="notice notice-info"><h6>' . esc_html__( 'No favorites yet', 'palleon' ) . '</h6>' . esc_html__('Click the star icon on any template, and you will see it here next time you visit.', 'palleon') . '</div>';
        } else {
            foreach($templates as $template) { 
                if (in_array($template[0], $selected_templates)) { 
                    $template_version = 'free';
                    if (isset($template[5])) {
                        $template_version = $template[5]; 
                    }
                    ?>
                <div class="grid-item">
                    <?php if ($template_version == 'pro') { ?>
                    <div class="template-pro"><span class="material-icons">workspace_premium</span></div>
                    <?php } ?>
                    <div class="template-favorite"><button type="button" class="palleon-btn-simple star favorited" data-templateid="<?php echo esc_attr($template[0]); ?>"><span class="material-icons">star</span></button></div>
                    <div class="palleon-masonry-item-inner palleon-select-template" data-json="<?php echo esc_url($template[3]); ?>" data-version="<?php echo esc_attr($template_version); ?>">
                        <div class="palleon-img-wrap">
                            <div class="palleon-img-loader"></div>
                            <img class="lazy" data-src="<?php echo esc_url($template[2]); ?>" alt="<?php echo esc_attr($template[1]); ?>" />
                        </div>
                        <div class="palleon-masonry-item-desc">
                        <?php echo esc_html($template[1]); ?>
                        </div>
                    </div>
                </div>  
            <?php }
            }
        }
        wp_die();
    }

    /**
	 * Template Search
	 */
    public function template_search(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(json_encode(array('success' => false, 'error' => esc_html__('Security Error!', 'palleon'))));
        }
        
        $user_fav = get_user_meta(get_current_user_id(), 'palleon_template_fav',true);
        if (empty($user_fav)) {
            $user_fav = array();
        }
        
        $keyword = $_POST['keyword'];
        $category = $_POST['category'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $per_page = 10; // Templates por página
        
        // Obtener dimensiones si se proporcionan
        $dimensions = isset($_POST['dimensions']) ? sanitize_text_field($_POST['dimensions']) : '';
        
        // Si hay dimensiones, usar filtrado por dimensiones, sino usar el método tradicional
        if (!empty($dimensions)) {
            $result = $this->get_templates_by_dimensions($dimensions, $page, $per_page);
            $templates = $result['templates'];
            $total_items = $result['total'];
        } else {
            // Método tradicional con paginación manual
            $random = PalleonSettings::get_option('template_order', 'random');
            $all_templates = palleon_templates();
            if ($random == 'random') {
                shuffle($all_templates);
            } else if ($random == 'new') {
                $all_templates = array_reverse($all_templates);
            }
            
            // Aplicar filtros antes de paginar
            $filtered_templates = $all_templates;
            
            // Aplicar filtro por categoría
            if (!empty($category) && $category != 'all') {
                $filteredArray = array();
                foreach($filtered_templates as $template) {
                    if (in_array($category, $template[4])) {
                        $filteredArray[] = $template;
                    }
                }
                $filtered_templates = $filteredArray;
            }
            
            // Aplicar filtro por keyword
            if (!empty($keyword)) {
                $filteredArray = array();
                foreach($filtered_templates as $template) {
                    if (stripos($template[1], $keyword) !== false) {
                        $filteredArray[] = $template;
                    }
                }
                $filtered_templates = $filteredArray;
            }
            
            $total_items = count($filtered_templates);
            $offset = ($page - 1) * $per_page;
            $templates = array_slice($filtered_templates, $offset, $per_page);
        }
        
        // Aplicar filtros adicionales si no usamos dimensiones
        if (!empty($dimensions)) {
            // Aplicar filtro por categoría
            if (!empty($category) && $category != 'all') {
                $filteredArray = array();
                foreach($templates as $template) {
                    if (in_array($category, $template[4])) {
                        $filteredArray[] = $template;
                    }
                }
                $templates = $filteredArray;
                $total_items = count($templates); // Recalcular total después del filtro
            }
            
            // Aplicar filtro por keyword
            if (!empty($keyword)) {
                $filteredArray = array();
                foreach($templates as $template) {
                    if (stripos($template[1], $keyword) !== false) {
                        $filteredArray[] = $template;
                    }
                }
                $templates = $filteredArray;
                $total_items = count($templates); // Recalcular total después del filtro
            }
        }
        
        // Capturar HTML en buffer
        ob_start();
        
        if (empty($templates)) {
            echo '<div class="notice notice-warning">' . esc_html__( 'No results found.', 'palleon' ) . '</div>';
        } else {
            foreach($templates as $template) { 
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
                <?php 
            }
        }
        
        $html_content = ob_get_clean();
        
        // Calcular datos de paginación
        $total_pages = ceil($total_items / $per_page);
        
        // Preparar respuesta JSON
        $response = array(
            'success' => true,
            'html' => $html_content,
            'pagination' => array(
                'current_page' => $page,
                'total_pages' => $total_pages,
                'per_page' => $per_page,
                'total_items' => $total_items,
                'has_prev' => $page > 1,
                'has_next' => $page < $total_pages
            )
        );
        
        // Enviar respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        wp_die();
    }

    /**
     * Template Search JSON - Endpoint para devolver templates en formato JSON
     */
    public function template_search_json(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(json_encode(array('error' => esc_html__('Security Error!', 'palleon'))));
        }
        
        $user_fav = get_user_meta(get_current_user_id(), 'palleon_template_fav',true);
        if (empty($user_fav)) {
            $user_fav = array();
        }
        
        // Obtener parámetros de la petición
        $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
        $width = isset($_POST['width']) ? intval($_POST['width']) : 0;
        $height = isset($_POST['height']) ? intval($_POST['height']) : 0;
        
        // Obtener templates usando el método apropiado
        if ($width > 0 && $height > 0) {
            $dimensions = $width . 'x' . $height;
            $result = $this->get_templates_by_dimensions($dimensions);
            $templates = $result['templates'];
            
            // Si no hay templates personalizados para estas dimensiones, usar templates generales
            if (empty($templates)) {
                error_log("Palleon: No custom templates found for dimensions {$dimensions}, using general templates");
                $random = PalleonSettings::get_option('template_order', 'random');
                $templates = palleon_templates();
                if ($random == 'random') {
                    shuffle($templates);
                } else if ($random == 'new') {
                    $templates = array_reverse($templates);
                }
            } else {
                error_log("Palleon: Found " . count($templates) . " custom templates for dimensions {$dimensions}");
            }
        } else {
            // Método tradicional usando library.php
            error_log("Palleon: No dimensions specified, using general templates");
            $random = PalleonSettings::get_option('template_order', 'random');
            $templates = palleon_templates();
            if ($random == 'random') {
                shuffle($templates);
            } else if ($random == 'new') {
                $templates = array_reverse($templates);
            }
        }
        
        // Aplicar filtro por query si se especificó
        if (!empty($query)) {
            $filteredArray = array();
            foreach($templates as $template) {
                // Buscar en título y tags
                if (stripos($template[1], $query) !== false || 
                    (is_array($template[4]) && implode(' ', $template[4]) && stripos(implode(' ', $template[4]), $query) !== false)) {
                    $filteredArray[] = $template;
                }
            }
            $templates = $filteredArray;
        }
        
        // Contar total antes de limitar
        $total = count($templates);
        
        // LIMITAR A 6 RESULTADOS
        $templates = array_slice($templates, 0, 6);
        
        error_log("Palleon: Total templates before limit: {$total}, after limit: " . count($templates));
        
        // Preparar respuesta JSON con estructura compatible
        $response = array(
            'success' => true,
            'data' => array(
                'total' => $total,
                'limited' => count($templates),
                'templates' => array()
            )
        );
        
        if (empty($templates)) {
            error_log("Palleon: No templates to return, sending error response");
            $response['success'] = false;
            $response['message'] = esc_html__('No results found.', 'palleon');
        } else {
            foreach($templates as $template) {
                $is_favorited = in_array($template[0], $user_fav);
                $template_version = isset($template[5]) ? $template[5] : 'free';
                $tags_string = is_array($template[4]) ? implode(',', $template[4]) : $template[4];
                
                $response['data']['templates'][] = array(
                    'id' => $template[0],
                    'title' => $template[1],
                    'preview' => $template[2],
                    'json' => $template[3],
                    'tags' => $tags_string,
                    'version' => $template_version,
                    'favorited' => $is_favorited
                );
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        wp_die();
    }

    /**
     * Save Preferences
     */
    public function save_preferences(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        $preferences = $_POST['preferences'];
        $meta = get_user_meta(get_current_user_id(), 'palleon_preferences',true);
        if (empty($meta)) {
            add_user_meta(get_current_user_id(), 'palleon_preferences', $preferences, true);
        } else {
            update_user_meta(get_current_user_id(),'palleon_preferences', $preferences, false);
        }
        wp_die();
    }

    /**
     * Load All Templates via AJAX
     */
    public function load_all_templates(){
        // Verificar nonce de seguridad
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        
        // Recibir las dimensiones enviadas desde el frontend
        $dimensions = isset($_POST['dimensions']) ? sanitize_text_field($_POST['dimensions']) : '';
      
        // Obtener templates filtrados por dimensiones
        $result = $this->get_templates_by_dimensions($dimensions);
        $templates = $result['templates'];
        
        if (empty($templates)) {
            echo '<div class="notice notice-warning"><h6>' . esc_html__( 'No templates found', 'palleon' ) . '</h6></div>';
        } else {
            foreach($templates as $template) { 
                $template_version = 'free';
                if (isset($template[5])) {
                    $template_version = $template[5]; 
                }
                ?>
                <div class="grid-item">
                    <?php if ($template_version == 'pro') { ?>
                    <div class="template-pro"><span class="material-icons">workspace_premium</span></div>
                    <?php } ?>
                    <div class="template-favorite">
                        <button type="button" class="palleon-btn-simple star" data-templateid="<?php echo esc_attr($template[0]); ?>">
                            <span class="material-icons">star_border</span>
                        </button>
                    </div>
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
                <?php 
            }
        }
        wp_die();
    }

    /* ---------------------------------------------------------
    INTEGRATIONS
    ----------------------------------------------------------- */

    /**
     * Ultimate Membership Pro
     */
    public function umpro(){
        if (is_user_logged_in() && (defined('IHC_PATH') || function_exists('ihc_initiate_plugin'))){
            $levels = PalleonSettings::get_option('umpro_levels','');
            $redirect = PalleonSettings::get_option('umpro_redirect', get_home_url());
            if(!empty($levels) && !current_user_can('administrator')) {
                $check = false;
                foreach($levels as $level) {
                    if(ihc_user_has_level(get_current_user_id(), $level)) {
                        $check = true;
                        break;
                    }
                }
                if (!$check) {
                    wp_redirect($redirect);
                    exit;
                }
            }
        }
    }

    /**
     * Restrict Access By User Roles
     */
    public function user_roles(){
        if (is_user_logged_in() && !current_user_can('administrator')) {
            $user_id = get_current_user_id();
            $user_meta = get_userdata($user_id);
            $user_roles = $user_meta->roles;
            $banned_user_roles = PalleonSettings::get_option('user_roles','');
            $message = PalleonSettings::get_option('user_roles_info',esc_html__( 'Access denied. You are not allowed to use the editor.', 'palleon' ));
            if(!empty($banned_user_roles) && is_array($banned_user_roles) && is_array($user_roles)) {
                foreach ($user_roles as $role_name) {
                    if (in_array($role_name, $banned_user_roles)) {
                        wp_die(wpautop($message));
                    }
                }
            }
        }
    }

    /**
     * Paid Membership Pro
     */
    public function pmpro(){
        if (function_exists('pmpro_hasMembershipLevel') && is_user_logged_in()) {
            $levels = PalleonSettings::get_option('pmpro_levels','');
            $redirect = PalleonSettings::get_option('pmpro_redirect', get_home_url());
            if(!empty($levels) && !pmpro_hasMembershipLevel($levels) && !current_user_can('administrator')) {
                wp_redirect($redirect);
                exit;
            }
        }
    }

    /**
     * Simple Membership
     */
    public function swpm(){
        if (class_exists('SwpmMemberUtils') && is_user_logged_in()) {
            $member_level = SwpmMemberUtils::get_logged_in_members_level();
            $levels = PalleonSettings::get_option('swpm_levels','');
            $redirect = PalleonSettings::get_option('swpm_redirect', get_home_url());
            if(!empty($levels) && !in_array($member_level, $levels) && !current_user_can('administrator')) {
                wp_redirect($redirect);
                exit;
            }
        }
    }

    /**
     * Restrict Content PRO
     */
    public function rcpro(){
        if (function_exists('rcp_get_customer_by_user_id') && is_user_logged_in()) {
            $levels = PalleonSettings::get_option('rcpro_levels','');
            $redirect = PalleonSettings::get_option('rcpro_redirect', get_home_url());
            if (!empty($levels)) {
                $customer = rcp_get_customer_by_user_id(get_current_user_id());
                if (empty($customer) && !current_user_can('administrator')) {
                    wp_redirect($redirect);
                    exit;
                } else if (!current_user_can('administrator')) {
                    $memberships = $customer->get_memberships();
                    $memberlevels = array();
                    foreach ( $memberships as $membership ) {
                        $membership_level_id = $membership->get_object_id();
                        array_push($memberlevels, $membership_level_id);
                    }
                    $result = array_intersect($levels, $memberlevels);
                    if(empty($result)) {
                        wp_redirect($redirect);
                        exit;
                    }
                }
            }
        }
    }

    /* ---------------------------------------------------------
    HELPER FUNCTIONS
    ----------------------------------------------------------- */

    /**
     * Get Filters
     */
    static function get_image_filters() {
        $output = '';
        $filters = ["horizontal_lines","extreme_offset_blue","extreme_offset_green","offset_green","extra_offset_blue","extra_offset_red","extra_offset_green","extreme_offset_red","specks_redscale","eclectic","pane","diagonal_lines","green_specks","casino","yellow_casino","green_diagonal_lines","offset","offset_blue","neue","sunset","specks","wood","lix","ryo","bluescale","solange","evening","crimson","teal_min_noise","phase","dark_purple_min_noise","coral","darkify","incbrightness","incbrightness2","invert","sat_adj","lemon","pink_min_noise","frontward","vintage","perfume","serenity","pink_aura","haze","cool_twilight","blues","horizon","mellow","solange_dark","solange_grey","zapt","eon","aeon","matrix","cosmic","min_noise","red_min_noise","matrix2","purplescale","radio","twenties","ocean","a","pixel_blue","greyscale","grime","redgreyscale","retroviolet","greengreyscale","warmth","green_med_noise","green_min_noise","blue_min_noise","rosetint","purple_min_noise"];
        foreach ( $filters as $filter ) {
            $output .= '<div class="grid-item" data-filter="' .  $filter . '" title="' .  $filter . '">
            <img src="' . esc_url(PALLEON_PLUGIN_URL . 'assets/filters/default.png') . '" /></div>';
        }
        return $output;
    }

    /**
     * Is this a PRO template?
     */
    static function is_pro_template($template_id) {
        $templates = palleon_templates();
        $isPRO = false;
        foreach($templates as $template) {
            if ($template_id == $template[0] && $template[5] == 'pro') {
                $isPRO = true;
                break;
            }
        }
        return $isPRO;
    }

    /**
     * Is user allowed to use PRO templates?
     */
    static function can_use_template(){
        $pro = true;

        if (is_user_logged_in() && (defined('IHC_PATH') || function_exists('ihc_initiate_plugin'))){
            $levels = PalleonSettings::get_option('umpro_template_levels','');
            if(!empty($levels) && !current_user_can('administrator')) {
                $pro = false;
                foreach($levels as $level) {
                    if(ihc_user_has_level(get_current_user_id(), $level)) {
                        $pro = true;
                        break;
                    }
                }
            }
        }

        if (function_exists('pmpro_hasMembershipLevel') && is_user_logged_in()) {
            $levels = PalleonSettings::get_option('pmpro_template_levels','');
            if(!empty($levels) && !pmpro_hasMembershipLevel($levels) && !current_user_can('administrator')) {
                $pro = false;
            } else {
                $pro = true;
            }
        }
    
        if (class_exists('SwpmMemberUtils') && is_user_logged_in()) {
            $member_level = SwpmMemberUtils::get_logged_in_members_level();
            $levels = PalleonSettings::get_option('swpm_template_levels','');
            if(!empty($levels) && !in_array($member_level, $levels) && !current_user_can('administrator')) {
                $pro = false;
            } else {
                $pro = true;
            }
        }

        if (function_exists('rcp_get_customer_by_user_id') && is_user_logged_in()) {
            $levels = PalleonSettings::get_option('rcpro_template_levels','');
            $redirect = PalleonSettings::get_option('rcpro_redirect', get_home_url());
            if (!empty($levels)) {
                $customer = rcp_get_customer_by_user_id(get_current_user_id());
                if (empty($customer) && !current_user_can('administrator')) {
                    $pro = false;
                } else if (!current_user_can('administrator')) {
                    $memberships = $customer->get_memberships();
                    $memberlevels = array();
                    foreach ( $memberships as $membership ) {
                        $membership_level_id = $membership->get_object_id();
                        array_push($memberlevels, $membership_level_id);
                    }
                    $result = array_intersect($levels, $memberlevels);
                    if(empty($result)) {
                        $pro = false;
                    } else {
                        $pro = true;
                    }
                }
            }
        }

        return $pro;
    }

    // Get websafe fonts
    static function get_websafe_fonts() {
        $fonts = apply_filters('palleonSafeFonts',array(
            'Impact, Charcoal, sans-serif' => esc_html__( 'Impact', 'palleon' ),
            'Helvetica Neue, Helvetica, Arial, sans-serif' => esc_html__( 'Helvetica Neue', 'palleon' ),
            'Georgia, serif' => esc_html__( 'Georgia', 'palleon' ),
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => esc_html__( 'Palatino Linotype', 'palleon' ),
            'Times New Roman, Times, serif' => esc_html__( 'Times New Roman', 'palleon' ),
            'Arial, Helvetica, sans-serif' => esc_html__( 'Arial', 'palleon' ),
            'Arial Black, Gadget, sans-serif' => esc_html__( 'Arial Black', 'palleon' ),
            'Comic Sans MS, cursive, sans-serif' => esc_html__( 'Comic Sans', 'palleon' ),
            'Lucida Sans Unicode, Lucida Grande, sans-serif' => esc_html__( 'Lucida Sans', 'palleon' ),
            'Tahoma, Geneva, sans-serif' => esc_html__( 'Tahoma', 'palleon' ),
            'Trebuchet MS, Helvetica, sans-serif' => esc_html__( 'Trebuchet', 'palleon' ),
            'Verdana, Geneva, sans-serif' => esc_html__( 'Verdana', 'palleon' ),
            'Courier New, Courier, monospace' => esc_html__( 'Courier New', 'palleon' ),
            'Lucida Console, Monaco, monospace' => esc_html__( 'Lucida Console', 'palleon' )
        ));
        return $fonts;
    }

    // Get User Menu
    static function user_menu(){
        $menu = apply_filters('palleonUserMenu',array(
            array(esc_html__('Documentation', 'palleon'), 'https://themes.thememasters.club/plugin-docs/palleon/index.html', 'text_snippet'),
            array(esc_html__('Return to Dashboard', 'palleon'), get_dashboard_url(), 'wordpress'),
        ));
        if (current_user_can('manage_options')) {
            array_unshift($menu, array(esc_html__('Settings', 'palleon'), admin_url('admin.php?page=palleon_options'), 'settings'));
        }
        $i = 1;
        foreach($menu as $item) {
            echo '<li id="palleon-user-menu-item-' . $i . '"><a href="' . $item[1] . '"><span class="material-icons">' . $item[2] . '</span>' . $item[0] . '</a></li>';
            $i++;
        }
    }

    // Print Filters
    static function get_filters(){
        $filters = array(
            'grayscale' => esc_html__('Grayscale', 'palleon'),
            'sepia' => esc_html__('Sepia', 'palleon'),
            'blackwhite' => esc_html__('Black/White', 'palleon'),
            'brownie' => esc_html__('Brownie', 'palleon'),
            'vintage' => esc_html__('Vintage', 'palleon'),
            'kodachrome' => esc_html__('Kodachrome', 'palleon'),
            'technicolor' => esc_html__('Technicolor', 'palleon'),
            'polaroid' => esc_html__('Polaroid', 'palleon'),
            'shift' => esc_html__('Shift', 'palleon'),
            'invert' => esc_html__('Invert', 'palleon'),
            'sharpen' => esc_html__('Sharpen', 'palleon'),
            'emboss' => esc_html__('Emboss', 'palleon'),
            'sobelX' => esc_html__('SobelX', 'palleon'),
            'sobelY' => esc_html__('SobelY', 'palleon')
        );
        return $filters;
    }

    // Print Filters
    static function print_filters(){
        $filters = Palleon::get_filters();
        foreach($filters as $id => $name) {
            echo '<div class="grid-item">';
            echo '<input type="checkbox" name="palleon-filter" id="' . $id . '" autocomplete="off" class="input-hidden" />';
            echo '<label for="' . $id . '">';
            echo '<img class="lazy" data-src="'. PALLEON_PLUGIN_URL . 'assets/filters/' . $id . '.png" />';
            echo '<span>' . $name . '</span>';
            echo '</label>';
            echo '</div>';
        }
    }

    // Get Brushes
    static function get_brushes(){
        $brushes = apply_filters('palleonBrushes',array(
            "pencil" => esc_html__('Pencil', 'palleon'),
            "circle" => esc_html__('Circle', 'palleon'),
            "spray" => esc_html__('Spray', 'palleon'),
            "hline" => esc_html__('H-line Pattern', 'palleon'),
            "vline" => esc_html__('V-line Pattern', 'palleon'),
            "square" => esc_html__('Square Pattern', 'palleon'),
            "erase" => esc_html__('Erase BG Image', 'palleon')
        ));
        return $brushes;
    }

    // Get User Meta
    static function get_user_option($key, $user_id, $default){
        $options = get_user_meta($user_id, 'palleon_preferences',true);
        if (!empty($options)) {
            $options = json_decode($options, true);
            foreach($options as $option => $value) {
                if ($option == $key) {
                    return $value;
                }
            }
        } else {
            return $default;
        }
    }

    // Ad Manager
    static function ad_manager($placement){
        $show_banners = PalleonSettings::get_option('show_img_banners', 'disable');
        $banners = PalleonSettings::get_option('img_banners', array());
        $showAds = true;

        if (function_exists('pmpro_hasMembershipLevel') || class_exists('SwpmMemberUtils') || function_exists('rcp_get_customer_by_user_id') || defined('IHC_PATH') ||  function_exists('ihc_initiate_plugin')) {

            if (is_user_logged_in() && (defined('IHC_PATH') || function_exists('ihc_initiate_plugin'))){
                $levels = PalleonSettings::get_option('umpro_remove_ads_levels','');
                if(!empty($levels)) {
                    foreach($levels as $level) {
                        if(ihc_user_has_level(get_current_user_id(), $level)) {
                            $showAds = false;
                            break;
                        }
                    }
                }
            }

            if (function_exists('pmpro_hasMembershipLevel') && is_user_logged_in()) {
                $levels = PalleonSettings::get_option('pmpro_remove_ads_levels','');
                if(!empty($levels) && pmpro_hasMembershipLevel($levels)) {
                    $showAds = false;
                } else {
                    $showAds = true;
                }
            }
    
            if (class_exists('SwpmMemberUtils') && is_user_logged_in()) {
                $member_level = SwpmMemberUtils::get_logged_in_members_level();
                $levels = PalleonSettings::get_option('swpm_remove_ads_levels','');
                if(!empty($levels) && in_array($member_level, $levels)) {
                    $showAds = false;
                } else {
                    $showAds = true;
                }
            }
    
            if (function_exists('rcp_get_customer_by_user_id') && is_user_logged_in()) {
                $levels = PalleonSettings::get_option('rcpro_remove_ads_levels','');
                $redirect = PalleonSettings::get_option('rcpro_redirect', get_home_url());
                if (!empty($levels)) {
                    $customer = rcp_get_customer_by_user_id(get_current_user_id());
                    if (empty($customer)) {
                        $showAds = true;
                    } else {
                        $memberships = $customer->get_memberships();
                        $memberlevels = array();
                        foreach ( $memberships as $membership ) {
                            $membership_level_id = $membership->get_object_id();
                            array_push($memberlevels, $membership_level_id);
                        }
                        $result = array_intersect($levels, $memberlevels);
                        if(empty($result)) {
                            $showAds = true;
                        } else {
                            $showAds = false;
                        }
                    }
                }
            }
        }

        if ($show_banners == 'enable' && $showAds) {
            if (!empty($banners) && is_array($banners)) {
                shuffle($banners);
                foreach ( $banners as $key => $entry ) {
                    $title = $placements = $image = $url = '';
                    if ( isset( $entry['title'] ) ) {
                        $title = esc_html( $entry['title'] );
                    }
                    if ( isset( $entry['placements'] ) ) {
                        $placements = $entry['placements'];
                    }
                    if ( isset( $entry['image'] ) ) {
                        $image = $entry['image'];
                    }
                    if ( isset( $entry['url'] ) ) {
                        $url = esc_url( $entry['url'] );
                    }

                    if (in_array($placement, $placements)) {
                        echo '<a class="palleon-banner" href="' . $url . '" target="_blank"><img src="' . $image . '" alt="' . $title . '" /></a>';
                        break;
                    }
                }
            }
        } else if ($show_banners == 'enable-nonlogin' && $showAds) {
            if (!is_user_logged_in()) {
                if (!empty($banners) && is_array($banners)) {
                    shuffle($banners);
                    foreach ( $banners as $key => $entry ) {
                        $title = $placements = $image = $url = '';
                        if ( isset( $entry['title'] ) ) {
                            $title = esc_html( $entry['title'] );
                        }
                        if ( isset( $entry['placements'] ) ) {
                            $placements = $entry['placements'];
                        }
                        if ( isset( $entry['image'] ) ) {
                            $image = $entry['image'];
                        }
                        if ( isset( $entry['url'] ) ) {
                            $url = esc_url( $entry['url'] );
                        }
    
                        if (in_array($placement, $placements)) {
                            echo '<a class="palleon-banner" href="' . $url . '" target="_blank"><img src="' . $image . '" alt="' . $title . '" /></a>';
                            break;
                        }
                    }
                }
            }
        } 
    }

    /**
     * Get Templates Filtered by Dimensions
     */
    private function get_templates_by_dimensions($dimensions, $page = 1, $per_page = 6) {
        
        // Si no se especificaron dimensiones, devolver array vacío para debugging
        if (empty($dimensions)) {
            return array('templates' => array(), 'total' => 0);
        }
        
        // Calcular offset para paginación
        $offset = ($page - 1) * $per_page;
        
        // Query para obtener posts de palleontemplates con la taxonomía category_palleon
        $args = array(
            'post_type' => 'palleontemplates',
            'posts_per_page' => $per_page,
            'offset' => $offset,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category_palleon',
                    'field'    => 'slug',
                    'terms'    => $dimensions,
                ),
            ),
        );
        
        $query = new WP_Query($args);
        $custom_templates = array();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                
                $templateUrl = get_post_meta(get_the_ID(), 'palleon_cmb2_template', true);
                $templateVersion = get_post_meta(get_the_ID(), 'palleon_cmb2_template_version', true);
                $imageurl = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                $largeurl = get_the_post_thumbnail_url(get_the_ID(), 'full');
                
                // Obtener tags normales
                $terms = get_the_terms(get_the_ID(), 'palleontags');
                $customTags = array();
                if ($terms) {
                    foreach ($terms as $term) {
                        $customTags[] = $term->slug;
                    }
                }
                
                $custom_templates[] = array(
                    "custom-template-" . get_the_ID(), 
                    get_the_title(), 
                    esc_url($imageurl), 
                    esc_url($templateUrl), 
                    $customTags, 
                    $templateVersion ? $templateVersion : 'free', 
                    $largeurl
                );
            }
            wp_reset_postdata();
        }
        
        // Devolver templates y total para paginación
        return array(
            'templates' => $custom_templates,
            'total' => $query->found_posts
        );
    }
}

/**
 * Returns the main instance of the class
 */
function Palleon() {  
	return Palleon::instance();
}
// Global for backwards compatibility
$GLOBALS['Palleon'] = Palleon();