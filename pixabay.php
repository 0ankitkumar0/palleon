<?php
defined( 'ABSPATH' ) || exit;

class PalleonPixabay {
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
	 * Constructor
	 */
    public function __construct() {
        add_action('wp_ajax_pixabaySearch', array($this, 'search'));
    }

    public function search() {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'palleon-nonce' ) ) {
            wp_die(esc_html__('Security Error!', 'palleon'));
        }
        // Get The Api Key
        $getApiKey =  PalleonSettings::get_option('pixabay', '');
        $apiKey = trim($getApiKey);
        $error = '';
        $curlURL = '';
        $pagination =  PalleonSettings::get_option('pixabay_pagination', 15);
        $lang =  PalleonSettings::get_option('pixabay_lang', 'en');
        $caching =  PalleonSettings::get_option('pixabay_caching', 24);
        $safe =  PalleonSettings::get_option('pixabay_safe', 'disable');
        $editors_choice =  PalleonSettings::get_option('pixabay_editors_choice', 'disable');
        if ($safe == 'disable') {
            $safe = 'false';
        } else {
            $safe = 'true';
        }
        if ($editors_choice == 'disable') {
            $editors_choice = 'false';
        } else {
            $editors_choice = 'true';
        }
        $query = $_POST['keyword'];
        $orientation = $_POST['orientation'];
        $category = $_POST['category'];
        $color = $_POST['color'];
        $page = $_POST['page'];

        if (empty($query) && empty($orientation) && empty($color) && empty($category)) {
            $curlURL = "https://pixabay.com/api/?key=". $apiKey . "&editors_choice=true&order=latest&image_type=photo&lang=" . $lang . "&safesearch=" . $safe . "&page=" . $page . "&per_page=" . $pagination;
        } else {
            $curlURL = "https://pixabay.com/api/?";
            $curlURL .= 'key=' . $apiKey . '&image_type=photo&order=latest&lang=' . $lang . '&safesearch=' . $safe . '&editors_choice=' . $editors_choice . '&';
            if (!empty($query)) {
                $query = str_replace(' ', '+', $query);
                $curlURL .= 'q=' . $query . '&';
            }
            if (!empty($orientation)) {
                $curlURL .= 'orientation=' . $orientation . '&';
            }
            if (!empty($color)) {
                $curlURL .= 'colors=' . $color . '&';
            }
            if (!empty($category)) {
                $curlURL .= 'category=' . $category . '&';
            }
            $curlURL .= 'page=' . $page . '&per_page=' . $pagination;
        }

        $transient_value = get_transient($curlURL);

        if (false !== $transient_value){
            $response =	get_transient($curlURL);
        } else {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $curlURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20
            ));
        
            $response = curl_exec($ch);
            if (curl_errno($ch) > 0) { 
                $error = esc_html__( 'Error connecting to API: ', 'palleon' ) . curl_error($ch);
            }
        
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($responseCode !== 200) {
                $error = "HTTP {$responseCode}";
            }
            if ($responseCode === 429) {
                $error = esc_html__( 'Too many requests!', 'palleon' );
            } 
            if ($responseCode === 400) {
                $error = esc_html__( 'Invalid or missing API key.', 'palleon' );
            } 
            if (empty($error)) {
                set_transient( $curlURL, $response, intval($caching) * HOUR_IN_SECONDS );
            }
        }

        $data = json_decode($response);
        if ($data === false && json_last_error() !== JSON_ERROR_NONE) {
            $error = esc_html__( 'Error parsing response', 'palleon' );
        }

        if (!empty($error)) {
            echo '<div class="notice notice-danger">' . $error . '</div>';
        } else {
            $photos = $data->hits;

            if ($photos == array()) {
                echo '<div class="notice notice-warning">' . esc_html__('Nothing Found.', 'palleon') . '</div>';
            } else {

                echo '<div class="palleon-grid media-library-grid pixabay-grid">';

                foreach ( $photos as $photo ) {
                    $id = $photo->id;
                    $url = $photo->pageURL;
                    $thumb = $photo->webformatURL;
                    $full = $photo->largeImageURL;
                    if (isset($photo->fullHDURL)) {
                        $full = $photo->fullHDURL;
                    }
                    $alt = $photo->tags;

                    echo '<div class="palleon-masonry-item">';
                    echo '<a href="' . esc_url($url) . '" class="pixabay-url" target="_blank"><span class="material-icons">info</span></a>';
                    echo '<div class="palleon-masonry-item-inner">';
                    echo '<div class="palleon-img-wrap">';
                    echo '<div class="palleon-img-loader"></div>';
                    echo '<img class="lazy" data-src="' . esc_url($thumb) . '" data-full="' . esc_url($full) . '" data-id="' . esc_attr($id) . '" data-filename="pixabay-' . esc_attr($id) . '" title="' . esc_attr($alt) . '" />';
                    echo '</div>';
                    if (!empty($alt)) {
                        echo '<div class="palleon-masonry-item-desc">' . esc_html($alt) . '</div>';
                    }
                    echo '</div></div>';
                }

                echo '</div>';

                echo '<button id="pixabay-loadmore" type="button" class="palleon-btn palleon-lg-btn primary" autocomplete="off" data-page="' . $page . '">' . esc_html__('Load More', 'palleon') . '</button>';
            }

        }
        wp_die();
    }

    static function curated() {
        // Get The Api Key
        $getApiKey =  PalleonSettings::get_option('pixabay', '');
        $apiKey = trim($getApiKey);
        $error = '';
        $pagination =  PalleonSettings::get_option('pixabay_pagination', 15);
        $caching =  PalleonSettings::get_option('pixabay_caching', 24);
        $lang =  PalleonSettings::get_option('pixabay_lang', 'en-US');
        $safe =  PalleonSettings::get_option('pixabay_safe', 'disable');
        if ($safe == 'disable') {
            $safe = 'false';
        } else {
            $safe = 'true';
        }
        $curlURL = "https://pixabay.com/api/?key=". $apiKey . "&editors_choice=true&order=latest&image_type=photo&lang=" . $lang . "&safesearch=" . $safe . "&page=1&per_page=" . $pagination;

        $transient_value = get_transient($curlURL); 

        if (false !== $transient_value){
            $response =	get_transient($curlURL);
        } else {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $curlURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20
            ));
        
            $response = curl_exec($ch);
            if (curl_errno($ch) > 0) { 
                $error = esc_html__( 'Error connecting to API: ', 'palleon' ) . curl_error($ch);
            }
        
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($responseCode !== 200) {
                $error = "HTTP {$responseCode}";
            }
            if ($responseCode === 429) {
                $error = esc_html__( 'Too many requests!', 'palleon' );
            }
            if (empty($error)) {
                set_transient( $curlURL, $response, intval($caching) * HOUR_IN_SECONDS );
            }
        }

        $data = json_decode($response);
        if ($data === false && json_last_error() !== JSON_ERROR_NONE) {
            $error = esc_html__( 'Error parsing response', 'palleon' );
        }

        if (!empty($error)) {
            echo '<div class="notice notice-danger">' . $error . '</div>';
        } else {
            $photos = $data->hits;

            echo '<div class="palleon-grid media-library-grid pixabay-grid">';

            foreach ( $photos as $photo ) {
                $id = $photo->id;
                $url = $photo->pageURL;
                $thumb = $photo->webformatURL;
                $full = $photo->largeImageURL;
                if (isset($photo->fullHDURL)) {
                    $full = $photo->fullHDURL;
                }
                $alt = $photo->tags;

                echo '<div class="palleon-masonry-item">';
                echo '<a href="' . esc_url($url) . '" class="pixabay-url" target="_blank"><span class="material-icons">info</span></a>';
                echo '<div class="palleon-masonry-item-inner">';
                echo '<div class="palleon-img-wrap">';
                echo '<div class="palleon-img-loader"></div>';
                echo '<img class="lazy" data-src="' . esc_url($thumb) . '" data-full="' . esc_url($full) . '" data-id="' . esc_attr($id) . '" data-filename="pixabay-' . esc_attr($id) . '" title="' . esc_attr($alt) . '" />';
                echo '</div>';
                if (!empty($alt)) {
                    echo '<div class="palleon-masonry-item-desc">' . esc_html($alt) . '</div>';
                }
                echo '</div></div>';
            }

            echo '</div>';

            echo '<button id="pixabay-loadmore" type="button" class="palleon-btn palleon-lg-btn primary" autocomplete="off" data-page="1">' . esc_html__('Load More', 'palleon') . '</button>';

        }
    }
}

/**
 * Returns the main instance of the class
 */
function PalleonPixabay() {  
	return PalleonPixabay::instance();
}
// Global for backwards compatibility
$GLOBALS['PalleonPixabay'] = PalleonPixabay();    