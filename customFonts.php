<?php
defined( 'ABSPATH' ) || exit;

if (class_exists('Bsf_Custom_Fonts_Render')) {
    class palleonCustomFonts extends Bsf_Custom_Fonts_Render {
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
            add_action( 'palleon_head', array( $this, 'add_styles' ) );
            add_action( 'palleon_fonts', array( $this, 'add_fonts' ) );
            add_action( 'palleon_body_end', array( $this, 'add_scripts' ) );
        }

        /**
         * Font Select
         */
        public function add_fonts() {
			$all_fonts = Bsf_Custom_Fonts_Render::get_instance()->get_existing_font_posts();
			if ( ! empty( $all_fonts ) ) {
                echo '<optgroup id="custom-fonts" label="' . esc_html__('Custom Fonts', 'palleon') . '">';
				foreach ( $all_fonts as $key => $post_id ) {
                    $font_data = get_post_meta( $post_id, 'fonts-data', true );
					$font_type = get_post_meta( $post_id, 'font-type', true );
                    if ( 'google' !== $font_type ) {
						echo '<option class="noload" data-font="' . $font_data['font_name'] . '" value="' . $font_data['font_name'] . '">' . $font_data['font_name'] . '</option>';
					}
				}
                echo '</optgroup>';
			}
		}

        public function add_scripts() {
			$all_fonts = Bsf_Custom_Fonts_Render::get_instance()->get_existing_font_posts();
			if ( ! empty( $all_fonts ) ) { 
                $fonts = array();
                foreach ( $all_fonts as $key => $post_id ) {
                    $font_data = get_post_meta( $post_id, 'fonts-data', true );
					$font_type = get_post_meta( $post_id, 'font-type', true );
                    if ( 'google' !== $font_type ) {
						array_push($fonts, $font_data['font_name']);
					}
                }
                ?>
                <script>
                /* <![CDATA[ */
                var palleonCustomFonts = {
                    "fonts": <?php echo json_encode($fonts); ?>,
                };
                /* ]]> */
                </script>
			<?php }
		}

        public function add_styles() {
			$font_urls = get_option( 'bcf_font_urls', array() );

			if (! empty( $font_urls ) ) {
				$font_format = apply_filters( 'bcf_preloading_fonts_format', 'woff2' );
				foreach ( $font_urls as $key => $local_url ) {
					if ( $local_url ) {
						echo '<link rel="preload" href="' . esc_url( $local_url ) . '" as="font" type="font/' . esc_attr( $font_format ) . '" crossorigin>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Preparing HTML link tag.
					}
				}
			}

            $font_styles = '';
			$query_posts = $this->get_existing_font_posts();

			if ( $query_posts ) {
				foreach ( $query_posts as $key => $post_id ) {
					$font_styles .= get_post_meta( $post_id, 'fonts-face', true );
				}
				wp_reset_postdata();
			}

			if ( ! empty( $font_styles ) ) {
				?>
					<style type="text/css" id="cst_font_data">
						<?php echo wp_strip_all_tags( $font_styles ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</style>
				<?php
			}
		}
    }

    /**
     * Returns the main instance of the class
     */
    function palleonCustomFonts() {  
        return palleonCustomFonts::instance();
    }
    // Global for backwards compatibility
    $GLOBALS['palleonCustomFonts'] = palleonCustomFonts();
}