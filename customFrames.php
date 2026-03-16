<?php
defined( 'ABSPATH' ) || exit;

class PalleonFrames {
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
        add_filter('cmb2_meta_boxes', array($this, 'add_frame') );
        add_action('admin_head', array($this, 'admin_style'));
        add_filter('post_row_actions', array($this, 'remove_row_actions'), 10, 1 );
    }

    /**
	 * Register Post Type
	 */
    public function register_post_type() {
        $labels = array(
            'name'              => esc_html__( 'Palleon Frames', 'palleon' ),
            'singular_name'     => esc_html__( 'Frame', 'palleon' ),
            'add_new'           => esc_html__( 'Add new group', 'palleon' ),
            'add_new_item'      => esc_html__( 'Add new group', 'palleon' ),
            'edit_item'         => esc_html__( 'Edit group', 'palleon' ),
            'new_item'          => esc_html__( 'New group', 'palleon' ),
            'view_item'         => esc_html__( 'View group', 'palleon' ),
            'search_items'      => esc_html__( 'Search groups', 'palleon' ),
            'not_found'         => esc_html__( 'No group found', 'palleon' ),
            'not_found_in_trash'=> esc_html__( 'No group found in trash', 'palleon' ),
            'parent_item_colon' => esc_html__( 'Parent group:', 'palleon' ),
            'menu_name'         => esc_html__( 'PE Frames', 'palleon' )
        );
    
        $taxonomies = array();
     
        $supports = array('title');
     
        $post_type_args = array(
            'labels'            => $labels,
            'singular_label'    => esc_html__('Frame Group', 'palleon'),
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
        register_post_type('palleonframes',$post_type_args);
    }

    /**
	 * Add Frame
	 */
    public function add_frame( $meta_boxes ) {
        $prefix = 'palleon_cmb2';
        $palleon_cmb2 = new_cmb2_box( array(
            'id' => 'palleon_frame',
            'title' => esc_attr__( 'Frames', 'palleon'),
            'object_types' => array('palleonframes'),
            'context' => 'normal',
            'priority' => 'default',
            'show_names' => false,
            'cmb_styles' => true
        ));

        $palleon_cmb2->add_field( array(
            'name'    => esc_html__( 'Frame File', 'palleon' ),
            'id'      => $prefix  . '_custom_frames',
            'type' => 'file_list',
            'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
            'query_args' => array(
                'type' => 'image/svg+xml'
            )
        ));
    }

    /**
	 * Admin Style
	 */
    public function admin_style() {
        echo '<style>
        #palleon_cmb2_custom_frames-status li img {
            width:100px;
            height:auto;
        }
        </style>';
    }

    /**
	 * Remove admin view links
	 */
    public function remove_row_actions( $actions ){
        if( get_post_type() === 'palleonframes' ) {
            unset( $actions['view'] );
        }
        return $actions;
    }

}

/**
 * Returns the main instance of the class
 */
function PalleonFrames() {  
	return PalleonFrames::instance();
}
// Global for backwards compatibility
$GLOBALS['PalleonFrames'] = PalleonFrames();
