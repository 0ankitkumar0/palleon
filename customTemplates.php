<?php
defined( 'ABSPATH' ) || exit;

class PalleonTemplates {
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
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomy'), 0 );
        add_filter('cmb2_meta_boxes', array($this, 'add_template') );
        add_filter('cmb2_meta_boxes', array($this, 'template_version') );
        add_filter('manage_edit-palleontemplates_columns', array($this, 'admin_column'), 5);
        add_action('manage_posts_custom_column', array($this, 'admin_row'), 5, 2);
        add_filter('palleonTemplates', array($this, 'custom_templates'), 10, 2 );
        add_filter('palleonTemplateTags', array($this, 'custom_tags'), 10, 2 );
        add_action('palleon_after_save', array($this, 'save_field'), 1);
        add_action('before_delete_post', array($this, 'delete_attachment'), 10, 2);
        add_action('wp_ajax_savePEtemplate', array($this, 'save_template'));
        add_filter('post_row_actions', array($this, 'remove_row_actions'), 10, 1 );
    }

    /**
	 * Register Post Type
	 */
    public function register_post_type() {
        $labels = array(
            'name'              => esc_html__( 'Palleon Templates', 'palleon' ),
            'singular_name'     => esc_html__( 'Template', 'palleon' ),
            'add_new'           => esc_html__( 'Add new template', 'palleon' ),
            'add_new_item'      => esc_html__( 'Add new template', 'palleon' ),
            'edit_item'         => esc_html__( 'Edit template', 'palleon' ),
            'new_item'          => esc_html__( 'New template', 'palleon' ),
            'view_item'         => esc_html__( 'View template', 'palleon' ),
            'search_items'      => esc_html__( 'Search templates', 'palleon' ),
            'not_found'         => esc_html__( 'No template found', 'palleon' ),
            'not_found_in_trash'=> esc_html__( 'No template found in trash', 'palleon' ),
            'parent_item_colon' => esc_html__( 'Parent template:', 'palleon' ),
            'menu_name'         => esc_html__( 'PE Templates', 'palleon' )
        );
    
        $taxonomies = array();
     
        $supports = array('title', 'thumbnail');
     
        $post_type_args = array(
            'labels'            => $labels,
            'singular_label'    => esc_html__('Template', 'palleon'),
            'public'            => false,
            'exclude_from_search' => true,
            'show_ui'           => true,
            'show_in_nav_menus' => false,
            'publicly_queryable'=> true,
            'query_var'         => true,
            'capability_type'   => 'post',
            'capabilities' => array(
                'edit_post'          => 'manage_options',
                'read_post'          => 'manage_options',
                'delete_post'        => 'manage_options',
                'edit_posts'         => 'manage_options',
                'edit_others_posts'  => 'manage_options',
                'delete_posts'       => 'manage_options',
                'publish_posts'      => 'manage_options',
                'read_private_posts' => 'manage_options'
            ),
            'has_archive'       => false,
            'hierarchical'      => false,
            'supports'          => $supports,
            'menu_position'     => 10,
            'menu_icon'         => 'dashicons-category',
            'taxonomies'        => $taxonomies
        );
        register_post_type('palleontemplates',$post_type_args);
    }

    /**
	 * Register Taxonomy
	 */
    public function register_taxonomy() {
        register_taxonomy(
            'palleontags',
            'palleontemplates',
            array(
                'labels' => array(
                    'name' => esc_html__( 'Custom Tags', 'palleon' ),
                    'add_new_item' => esc_html__( 'Add new tag', 'palleon' ),
                    'new_item_name' => esc_html__( 'New tag', 'palleon' )
                ),
                'show_ui' => true,
                'show_tagcloud' => false,
                'show_admin_column' => true,
                'show_in_nav_menus' => false,
                'hierarchical' => true,
                'query_var' => true
            )
        );
    }

    /**
	 * Add Template
	 */
    public function add_template() {
        $palleon_cmb2 = new_cmb2_box( array(
            'id' => 'palleon_template',
            'title' => esc_html__( 'Template File', 'palleon'),
            'object_types' => array('palleontemplates'),
            'context' => 'normal',
            'priority' => 'default',
            'show_names' => true,
            'cmb_styles' => true
        ));

        $palleon_cmb2->add_field( array(
            'name'    => esc_html__( 'Template URL', 'palleon' ),
            'description' => esc_html__( 'To get a valid JSON file, create something with Palleon Image Editor and save/download as template.', 'palleon'),
            'id'      => 'palleon_cmb2_template',
            'type'    => 'file',
            'query_args' => array(
                'type' => 'application/json'
            )
        ));
    }

    /**
	 * Version
	 */
    public function template_version( $meta_boxes ) {
        $palleon_cmb2 = new_cmb2_box( array(
            'id' => 'palleon_template_version',
            'title' => esc_html__( 'Version', 'palleon'),
            'object_types' => array('palleontemplates'),
            'context' => 'side',
            'priority' => 'default',
            'show_names' => false,
            'cmb_styles' => true
        ));

        $palleon_cmb2->add_field( array(
            'name' => esc_html__( 'Version', 'palleon'),
            'description'    => esc_html__( 'As default users must login to the backend editor to use PRO templates. If you are using a supported Memberships plugin, you can select which members can access PRO templates from Palleon settings.', 'palleon'),
            'id' => 'palleon_cmb2_template_version',
            'type' => 'radio_inline',
            'options' => array(
                'free' => esc_html__( 'Free', 'palleon' ),
                'pro'   => esc_html__( 'Pro', 'palleon' )
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
            'default' => 'free'
        ));

    }

    /**
	 * Add custom admin table column
	 */
    public function admin_column($defaults){
        $defaults['palleon_template_share'] = esc_html__( 'Share Template', 'palleon' );
        $defaults['palleon_template_preview'] = esc_html__( 'Preview', 'palleon' );
        return $defaults;
    }

    /**
	 * Add custom admin table row
	 */
    public function admin_row($column_name, $post_id){
        if($column_name === 'palleon_template_share'){
            $editor = PalleonSettings::get_option('fe_editor','disable');
            $template = get_post_meta( $post_id, 'palleon_cmb2_template', true );
            $slug =  PalleonSettings::get_option('fe_slug', 'palleon');
            $templateFE = esc_url(get_site_url() . '?page=' . $slug . '&template_url=' . $template);
            $templateBE = admin_url('admin.php?page=palleon&template_url=' . $template);
            echo '<div class="palleon-template-share-wrap">';
            if ($editor == 'enable') {
                echo '<div><label>' . esc_html__( 'Front-End Version', 'palleon' ) . '</label><input type="text" class="palleon-template-share" value="' . $templateFE . '" readonly /></div>';
                echo '<div><label>' . esc_html__( 'Back-End Version', 'palleon' ) . '</label><input type="text" class="palleon-template-share" value="' . $templateBE . '" readonly /></div>';
            } else {
                echo '<div><input type="text" class="palleon-template-share" value="' . $templateBE . '" readonly /></div>';
            }
            echo '</div>';
        } 
        if($column_name === 'palleon_template_preview'){
            echo the_post_thumbnail('thumbnail');
        }    
    }

    /**
	 * Add save button to Palleon
	 */
    public function save_field(){
        if(is_user_logged_in() && (current_user_can('administrator') || current_user_can('editor'))) { ?>
        <div id="palleon-save-as-petemplate">
            <div class="palleon-block-50">
                <div>
                    <label><?php echo esc_html__('Name', 'palleon'); ?></label>
                    <input id="palleon-petemplate-save-name" class="palleon-form-field palleon-file-name" type="text" value="" autocomplete="off" data-default="">
                </div>
                <button id="palleon-petemplate-save" type="button" class="palleon-btn primary"><span class="material-icons">save</span><?php echo esc_html__('Save As PE Template', 'palleon'); ?></button>
            </div>
            <div class="palleon-block-100">
                <div>
                    <label><?php echo esc_html__('Category', 'palleon'); ?></label>
                    <select id="palleon-petemplate-save-tag" class="palleon-select palleon-select2" autocomplete="off" multiple="multiple">
                        <?php
                        $terms = get_terms( 'palleontags', array(
                            'hide_empty' => false,
                        ) );
                        foreach( $terms as $term ) {
                            echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label><?php echo esc_html__('Version', 'palleon'); ?></label>
                    <select id="palleon-petemplate-save-version" class="palleon-select" autocomplete="off">
                        <option value="free" selected><?php echo esc_html__('Free', 'palleon'); ?></option>
                        <option value="pro"><?php echo esc_html__('PRO', 'palleon'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <?php }
    }

    /**
	 * Save Template
	 */
    public function save_template(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }

        // Insert Post
        $post_id = wp_insert_post(array (
            'post_title' => esc_html($_POST['name']),
            'post_type' => 'palleontemplates',
            'post_status' => 'publish'
        ));

        if (isset($_POST['tag']) && $_POST['tag'] !== 0 && !empty($_POST['tag'])) {
            $tags = json_decode( stripslashes( $_POST['tag'] ), true );
            wp_set_post_terms( $post_id, $tags, 'palleontags');
        }
        unset($_POST['tag']);

        // Upload dir.
        $upload_dir  = wp_upload_dir();
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

        // SAVE IMAGE
        $img = str_replace( 'data:' . $_POST['type'] . ';base64,', '', $_POST['thumb'] );
        $img = str_replace( ' ', '+', $img );
        $img = base64_decode( $img );
        $filename = $_POST['filename'] . '.png';

        $upload_file = file_put_contents( $upload_path . $filename, $img );

        $attachment = array(
            'post_mime_type' => $_POST['type'],
            'post_title'     => esc_html($_POST['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $post_id,
            'guid'           => $upload_dir['url'] . '/' . basename( $filename ),
            'meta_input'   => array(
                'palleon_hide' => true
            ),
        );

        $attachment_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $filename );
        wp_update_attachment_metadata(
            $attachment_id,
            wp_generate_attachment_metadata( $attachment_id, $upload_dir['path'] . '/' . $filename )
        );

        set_post_thumbnail( $post_id, $attachment_id );

        unset($_POST['thumb']);
        unset($_POST['type']);

        // SAVE TEMPLATE
        $frontend =  PalleonSettings::get_option('fe_editor', 'disable');
        $slug =  PalleonSettings::get_option('fe_slug', 'palleon');
        $share =  PalleonSettings::get_option('share', 'enable');
        $filename_json = $_POST['filename'] . '.json';
        $json = stripslashes($_POST['json']);
        $upload_json_file = file_put_contents( $upload_path . $filename_json, $json );

        $attachment_json = array(
            'post_mime_type' => 'application/json',
            'post_title'     => esc_html($_POST['name']),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $post_id,
            'guid'           => $upload_dir['url'] . '/' . basename( $filename_json ),
            'meta_input'   => array(
                'palleon_hide' => true
            ),
        );

        $attachment_json_id = wp_insert_attachment( $attachment_json, $upload_dir['path'] . '/' . $filename_json );
        wp_update_attachment_metadata(
            $attachment_json_id,
            wp_generate_attachment_metadata( $attachment_json_id, $upload_dir['path'] . '/' . $filename_json )
        );

        $attachment_json_url = wp_get_attachment_url($attachment_json_id);
        update_post_meta($post_id, 'palleon_cmb2_template', esc_url($attachment_json_url));
        unset($_POST['json']);

        if (isset($_POST['version']) && !empty($_POST['version'])) {
            update_post_meta($post_id, 'palleon_cmb2_template_version', esc_html($_POST['version']));
        }
        unset($_POST['version']);

        if ($frontend == 'enable' && $share == 'enable') {
            echo get_site_url() . '?page=' . $slug . '&item_id=' . $attachment_json_id;
        }

        wp_die();
    }

    /**
     * Delete custom design attachments
     */
    public function delete_attachment($post_id) {
        if ( get_post_type( $post_id ) == 'palleontemplates' ) {
            $attachments = get_attached_media( '', $post_id );
            foreach ($attachments as $attachment) {
                wp_delete_attachment($attachment->ID, true);
            }
        }
    }

    // Custom Templates
    public function custom_templates($templates){
        $defaultTemplates = PalleonSettings::get_option('default_temp','enable');

        if ($defaultTemplates == 'disable') {
            $templates = array();
        }

        $args = array(
            'post_type' => 'palleontemplates',
            'posts_per_page'  => 999999,
            'order' => 'ASC',
            'orderby' => 'date'
        );

        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) : $the_query->the_post();
            $templateUrl = get_post_meta( get_the_ID(), 'palleon_cmb2_template', true );
            $templateVersion = get_post_meta( get_the_ID(), 'palleon_cmb2_template_version', true );
            $imageurl = get_the_post_thumbnail_url(get_the_ID(),'thumbnail');
            $largeurl = get_the_post_thumbnail_url(get_the_ID(),'full');
            $terms = get_the_terms( get_the_ID(), 'palleontags' );
            $customTags = array();
            if ($terms) {
                foreach( $terms as $term ) {
                    $customTags[] = $term->slug;
                }
            }
            $templates[] = array("custom-template-" . get_the_ID(), get_the_title(), esc_url($imageurl), esc_url($templateUrl), $customTags, $templateVersion, $largeurl);
            endwhile;
        }

        return $templates;
    }

    // Custom Tags
    public function custom_tags($tags){
        $defaultTemplates = PalleonSettings::get_option('default_temp','enable');

        if ($defaultTemplates == 'disable') {
            $tags = array();
        }

        $terms = get_terms( 'palleontags', array(
            'hide_empty' => false,
        ) );

        foreach( $terms as $term ) {
            $tags[$term->slug] = $term->name . ' (' . palleon_get_tag_count($term->slug) . ')';
        }

        return $tags;
    }

    /**
	 * Remove admin view links
	 */
    public function remove_row_actions( $actions ){
        if( get_post_type() === 'palleontemplates' ) {
            unset( $actions['view'] );
        }
        return $actions;
    }

}

/**
 * Returns the main instance of the class
 */
function PalleonTemplates() {  
	return PalleonTemplates::instance();
}
// Global for backwards compatibility
$GLOBALS['PalleonTemplates'] = PalleonTemplates();
