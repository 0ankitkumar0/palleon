<?php

/**
 * Plugin Name: Palleon
 * Plugin URI: https://palleon.website
 * Description: Image Editor For WordPress
 * Version: 4.2.2
 * Update URI: https://api.freemius.com
 * Requires PHP: 7.0
 * Author: Palleon Team
 * Author URI: https://palleon.website
 * Text Domain: palleon
 * Domain Path: /languages
 *
 */
defined( 'ABSPATH' ) || exit;
if ( !function_exists( 'palleon_fs' ) ) {
    // Create a helper function for easy SDK access.
    function palleon_fs() {
        global $palleon_fs;
        if ( !isset( $palleon_fs ) ) {
            // Activate multisite network integration.
            if ( !defined( 'WP_FS__PRODUCT_16537_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_16537_MULTISITE', true );
            }
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
            $palleon_fs = fs_dynamic_init( array(
                'id'               => '16537',
                'slug'             => 'palleon',
                'premium_slug'     => 'palleon',
                'type'             => 'plugin',
                'public_key'       => 'pk_722f1ec2a33e3cd823c23201a97aa',
                'is_premium'       => true,
                'is_premium_only'  => true,
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'has_affiliation'  => 'selected',
                'menu'             => array(
                    'slug'    => 'palleon',
                    'support' => false,
                ),
                'is_live'          => true,
            ) );
        }
        return $palleon_fs;
    }

    // Init Freemius.
    palleon_fs();
    // Signal that SDK was initiated.
    do_action( 'palleon_fs_loaded' );
}
if ( palleon_fs()->is_paying() ) {
    if ( !defined( 'PALLEON_PLUGIN_URL' ) ) {
        define( 'PALLEON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }
    if ( !defined( 'PALLEON_SOURCE_URL' ) ) {
        define( 'PALLEON_SOURCE_URL', 'https://palleon.website/js-version/palleon/files/' );
    }
    if ( !defined( 'PALLEON_VERSION' ) ) {
        define( 'PALLEON_VERSION', '4.2.2' );
    }
    /* ---------------------------------------------------------
       Include files
       ----------------------------------------------------------- */
    $palleondir = ( version_compare( PHP_VERSION, '5.3.0' ) >= 0 ? __DIR__ : dirname( __FILE__ ) );
    if ( file_exists( $palleondir . '/cmb2/init.php' ) ) {
        require_once $palleondir . '/cmb2/init.php';
    } else {
        if ( file_exists( $palleondir . '/CMB2/init.php' ) ) {
            require_once $palleondir . '/CMB2/init.php';
        }
    }
    include_once 'settingsClass.php';
    include_once 'library.php';
    include_once 'mainClass.php';
    include_once 'pexels.php';
    include_once 'pixabay.php';
    include_once 'iconfinder.php';
    /* ---------------------------------------------------------
       Plugins Loaded
       ----------------------------------------------------------- */
    function palleon_plugins_loaded() {
        include_once 'customFrames.php';
        include_once 'customTemplates.php';
        include_once 'customElements.php';
        include_once 'customFonts.php';
    }

    add_action( 'plugins_loaded', 'palleon_plugins_loaded' );
}
// TGM Plugin Activation
require_once 'class-tgm-plugin-activation.php';
function palleon_register_required_plugins() {
    $plugins = array(
        array(
            'name'               => esc_html__( 'Antimena', 'palleon' ),
            'slug'               => 'antimena',
            'source'             => PALLEON_PLUGIN_URL . 'addons/antimena.zip',
            'required'           => false,
            'version'            => '4.4.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__( 'Calumma', 'palleon' ),
            'slug'               => 'calumma',
            'source'             => PALLEON_PLUGIN_URL . 'addons/calumma.zip',
            'required'           => false,
            'version'            => '2.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__( 'Trioceros', 'palleon' ),
            'slug'               => 'trioceros',
            'source'             => PALLEON_PLUGIN_URL . 'addons/trioceros.zip',
            'required'           => false,
            'version'            => '2.1.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__( 'Furcifer', 'palleon' ),
            'slug'               => 'furcifer',
            'source'             => PALLEON_PLUGIN_URL . 'addons/furcifer.zip',
            'required'           => false,
            'version'            => '2.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        )
    );
    if ( defined( 'PRINTEON_VERSION' ) ) {
        $printeon_plugins = array(
            array(
                'name'     => esc_html__( 'Kirki', 'printeon' ),
                'slug'     => 'kirki',
                'required' => true,
            ),
            array(
                'name'     => esc_html__( 'Elementor', 'printeon' ),
                'slug'     => 'elementor',
                'required' => true,
            ),
            array(
                'name'     => esc_html__( 'WooCommerce', 'printeon' ),
                'slug'     => 'woocommerce',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH WooCommerce Wishlist', 'printeon' ),
                'slug'     => 'yith-woocommerce-wishlist',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Contact Form 7', 'printeon' ),
                'slug'     => 'contact-form-7',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'One Click Demo Import', 'printeon' ),
                'slug'     => 'one-click-demo-import',
                'required' => false,
            )
        );
        $plugins = array_merge( $plugins, $printeon_plugins );
    }
    $config = array(
        'id'           => 'palleon',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'plugins.php',
        'capability'   => 'manage_options',
        'has_notices'  => true,
        'dismissable'  => false,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'strings'      => array(
            'page_title'                     => esc_html__( 'Install Required Plugins', 'palleon' ),
            'menu_title'                     => esc_html__( 'Install Plugins', 'palleon' ),
            'oops'                           => esc_html__( 'Something went wrong with the plugin API.', 'palleon' ),
            'notice_can_install_recommended' => _n_noop( 'Palleon recommends the following plugins: %1$s.', 'Palleon recommends the following plugins: %1$s.', 'palleon' ),
            'notice_ask_to_update'           => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with Palleon: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with Palleon: %1$s.', 'palleon' ),
        ),
    );
    tgmpa( $plugins, $config );
}

if ( palleon_fs()->is_plan( 'pro', true ) ) {
    add_action( 'tgmpa_register', 'palleon_register_required_plugins' );
}