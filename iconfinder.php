<?php
defined( 'ABSPATH' ) || exit;

class PalleonIconfinder {
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
        add_action('wp_ajax_iconfinderSearch', array($this, 'search'));
        add_action('wp_ajax_iconfinderLoadMore', array($this, 'load_more'));
        add_action('wp_ajax_iconfinderDownload', array($this, 'download'));
    }

    /**
	 * Get Categories
	 */
    public static function get_categories() {
        $getApiKey =  PalleonSettings::get_option('iconfinder', '');
        if (!empty($getApiKey)) {
            $apiKey = trim($getApiKey);
            $error = '';
            $curlURL = 'https://api.iconfinder.com/v4/categories?count=100';
            $ch = curl_init();
            $transient_value = get_transient($curlURL);

            if (false !== $transient_value){
                $response =	get_transient($curlURL);
            } else {
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $curlURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Bearer {$apiKey}"
                    )
                ));
            
                $response = curl_exec($ch);
                if (curl_errno($ch) > 0) { 
                    $error = esc_html__( 'Error connecting to API: ', 'palleon' ) . curl_error($ch);
                }
            
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($responseCode !== 200) {
                    $error = "HTTP {$responseCode}" . ' - ' . curl_error($ch);
                }
                if ($responseCode === 429) {
                    $error = esc_html__( 'API request rate limit exceeded.', 'palleon' );
                }
                if (empty($error)) {
                    set_transient( $curlURL, $response, 1000 * HOUR_IN_SECONDS );
                }
            }

            $data = json_decode($response);
            if ($data === false && json_last_error() !== JSON_ERROR_NONE) {
                $error = esc_html__( 'Error parsing response', 'palleon' );
            }

            if (!empty($error)) {
                return array('none' => $error);
            } else {
                $categories = $data->categories;
                $catArray = array('none' => esc_html__( 'All Categories', 'palleon' ));

                foreach ( $categories as $category ) {
                    $name = $category->name;
                    $identifier = $category->identifier;
                    $catArray[$identifier] = $name;
                }
                return $catArray;
            }
        } else {
            return array('none' => esc_html__( 'API Key is required.', 'palleon' ));
        }
    }

    /**
	 * Get Styles
	 */
    public static function get_styles() {
        $getApiKey =  PalleonSettings::get_option('iconfinder', '');
        if (!empty($getApiKey)) {
            $apiKey = trim($getApiKey);
            $error = '';
            $curlURL = 'https://api.iconfinder.com/v4/styles?count=100';
            $ch = curl_init();
            $transient_value = get_transient($curlURL);

            if (false !== $transient_value){
                $response =	get_transient($curlURL);
            } else {
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $curlURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Bearer {$apiKey}"
                    )
                ));
            
                $response = curl_exec($ch);
                if (curl_errno($ch) > 0) { 
                    $error = esc_html__( 'Error connecting to API: ', 'palleon' ) . curl_error($ch);
                }
            
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($responseCode !== 200) {
                    $error = "HTTP {$responseCode}" . ' - ' . curl_error($ch);
                }
                if ($responseCode === 429) {
                    $error = esc_html__( 'API request rate limit exceeded.', 'palleon' );
                }
                if (empty($error)) {
                    set_transient( $curlURL, $response, 1000 * HOUR_IN_SECONDS );
                }
            }

            $data = json_decode($response);
            if ($data === false && json_last_error() !== JSON_ERROR_NONE) {
                $error = esc_html__( 'Error parsing response', 'palleon' );
            }

            if (!empty($error)) {
                return array('none' => $error);
            } else {
                $styles = $data->styles;
                $styleArray = array('none' => esc_html__( 'All Styles', 'palleon' ));

                foreach ( $styles as $style ) {
                    $name = $style->name;
                    $identifier = $style->identifier;
                    $styleArray[$identifier] = $name;
                }
                return $styleArray;
            }
        } else {
            return array('none' => esc_html__( 'API Key is required.', 'palleon' ));
        }
    }

    /**
	 * Default Search
	 */
    public function download() {
        $getApiKey =  PalleonSettings::get_option('iconfinder', '');
        $apiKey = trim($getApiKey);
        $curlURL = $_POST['source'];
        $caching =  PalleonSettings::get_option('iconfinder_caching', 24);
        $transient_value = get_transient($curlURL); 

        if (false !== $transient_value){
            $response =	get_transient($curlURL);
        } else {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $curlURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$apiKey}"
                )
            ));
        
            $response = curl_exec($ch);
            if (curl_errno($ch) > 0) {
                $error = '{"message": "' . esc_html__( 'Error connecting to API. ', 'palleon' ) . curl_error($ch) . '"}';
            }
        
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($responseCode !== 200) {
                $error = '{"message": "HTTP ' . $responseCode . ' - ' . curl_error($ch) . '"}';
            }
            if ($responseCode === 429) {
                $error = '{"message": "' . esc_html__( 'API request rate limit exceeded.', 'palleon' ) . '"}';
            } 
            if (empty($error)) {
                set_transient( $curlURL, $response, intval($caching) * HOUR_IN_SECONDS );
            }
        }

        if (!empty($error)) {
            echo json_encode($error);
        } else {
            echo $response;
        }
        wp_die();
    }

    /**
	 * Default Search
	 */
    static function curated() {
        $getApiKey =  PalleonSettings::get_option('iconfinder', '');
        $apiKey = trim($getApiKey);
        $keyword =  PalleonSettings::get_option('iconfinder_default_keyword', '');
        if (!empty($keyword)) {
            $keyword = str_replace(' ', '%20', $keyword);
            $category =  PalleonSettings::get_option('iconfinder_default_cat', 'none');
            $style =  PalleonSettings::get_option('iconfinder_default_style', 'none');
            $license =  PalleonSettings::get_option('iconfinder_license', 'none');
            $exp =  PalleonSettings::get_option('iconfinder_exp', '1');
            $error = '';
            $caching =  PalleonSettings::get_option('iconfinder_caching', 24);

            $curlURL = 'https://api.iconfinder.com/v4/icons/search?query=' . $keyword . '&premium=0&vector=1&count=20&license=' . $license . '&is_explicit=' . $exp;
            if ($category != 'none') {
                $curlURL .= '&category=' . $category;
            }
            if ($style != 'none') {
                $curlURL .= '&style=' . $style;
            }

            $transient_value = get_transient($curlURL); 

            if (false !== $transient_value){
                $response =	get_transient($curlURL);
            } else {
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $curlURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Bearer {$apiKey}"
                    )
                ));
            
                $response = curl_exec($ch);
                if (curl_errno($ch) > 0) { 
                    $error = esc_html__( 'Error connecting to API: ', 'palleon' ) . curl_error($ch);
                }
            
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($responseCode !== 200) {
                    $error = "HTTP {$responseCode}" . ' - ' . curl_error($ch);
                }
                if ($responseCode === 429) {
                    $error = esc_html__( 'API request rate limit exceeded.', 'palleon' );
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
                $total = intval($data->total_count);
                if ($total !== 0) {
                    echo '<div id="palleon-iconfinder-grid" class="palleon-grid four-column">';
                    $icons = $data->icons;
                    foreach ( $icons as $icon ) {
                        $vector_sizes = $icon->vector_sizes;
                        $formats = $vector_sizes[0]->formats;
                        $svg = '';
                        foreach ( $formats as $item ) {
                            $format = $item->format;
                            if ($format === 'svg') {
                                $svg = $item->download_url;
                                break;
                            }
                        }
                        $raster = $icon->raster_sizes;
                        $img = '';
                        foreach ( $raster as $size ) {
                            $imgSize = $size->size;
                            if ($imgSize == 128) {
                                $img = $size->formats[0]->preview_url;
                                break;
                            }
                        }
                        if (empty($img)) {
                            foreach ( $raster as $size ) {
                                $imgSize = $size->size;
                                if ($imgSize >= 64) {
                                    $img = $size->formats[0]->preview_url;
                                    break;
                                }
                            }
                        }
                        $tags = $icon->tags;
                        $alt = implode(", ", $tags);

                        echo '<div class="palleon-element iconfinder-add" data-iconsource="' . esc_url($svg) . '" title="' . esc_attr($alt) . '"><div class="palleon-img-wrap"><img class="lazy" data-src="' . esc_url($img) . '" /></div></div>';
                    }
                    echo '</div>';
                    if ($total > 20) {
                        echo '<button id="iconfinder-loadmore" type="button" class="palleon-btn primary" data-page="20" data-keyword="' . $keyword . '" data-category="' . $category . '" data-style="' . $style . '">' . esc_html__( 'LOAD MORE', 'palleon' ) . '</button>';
                    }
                }
            }
        }
    }

    /**
	 * Search Icons
	 */
    public function search() {
        $getApiKey =  PalleonSettings::get_option('iconfinder', '');
        $apiKey = trim($getApiKey);
        $keyword =  $_POST['keyword'];
        if (!empty($keyword)) {
            $keyword = str_replace(' ', '%20', $keyword);
            $category =  $_POST['category'];
            $style =  $_POST['style'];
            $license =  PalleonSettings::get_option('iconfinder_license', 'none');
            $exp =  PalleonSettings::get_option('iconfinder_exp', '1');
            $error = '';
            $caching =  PalleonSettings::get_option('iconfinder_caching', 24);

            $curlURL = 'https://api.iconfinder.com/v4/icons/search?query=' . $keyword . '&premium=0&vector=1&count=20&license=' . $license . '&is_explicit=' . $exp;
            if ($category != 'none') {
                $curlURL .= '&category=' . $category;
            }
            if ($style != 'none') {
                $curlURL .= '&style=' . $style;
            }

            $transient_value = get_transient($curlURL); 

            if (false !== $transient_value){
                $response =	get_transient($curlURL);
            } else {
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $curlURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Bearer {$apiKey}"
                    )
                ));
            
                $response = curl_exec($ch);
                if (curl_errno($ch) > 0) { 
                    $error = esc_html__( 'Error connecting to API: ', 'palleon' ) . curl_error($ch);
                }
            
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($responseCode !== 200) {
                    $error = "HTTP {$responseCode}" . ' - ' . curl_error($ch);
                }
                if ($responseCode === 429) {
                    $error = esc_html__( 'API request rate limit exceeded.', 'palleon' );
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
                $total = intval($data->total_count);
                if ($total !== 0) {
                    echo '<div id="palleon-iconfinder-grid" class="palleon-grid four-column">';
                    $icons = $data->icons;
                    foreach ( $icons as $icon ) {
                        $vector_sizes = $icon->vector_sizes;
                        $formats = $vector_sizes[0]->formats;
                        $svg = '';
                        foreach ( $formats as $item ) {
                            $format = $item->format;
                            if ($format === 'svg') {
                                $svg = $item->download_url;
                                break;
                            }
                        }
                        $raster = $icon->raster_sizes;
                        $img = '';
                        foreach ( $raster as $size ) {
                            $imgSize = $size->size;
                            if ($imgSize == 128) {
                                $img = $size->formats[0]->preview_url;
                                break;
                            }
                        }
                        if (empty($img)) {
                            foreach ( $raster as $size ) {
                                $imgSize = $size->size;
                                if ($imgSize >= 64) {
                                    $img = $size->formats[0]->preview_url;
                                    break;
                                }
                            }
                        }
                        $tags = $icon->tags;
                        $alt = implode(", ", $tags);

                        echo '<div class="palleon-element iconfinder-add" data-iconsource="' . esc_url($svg) . '" title="' . esc_attr($alt) . '"><div class="palleon-img-wrap"><img class="lazy" data-src="' . esc_url($img) . '" /></div></div>';
                    }
                    echo '</div>';
                    if ($total > 20) {
                        echo '<button id="iconfinder-loadmore" type="button" class="palleon-btn primary" data-page="20" data-keyword="' . $keyword . '" data-category="' . $category . '" data-style="' . $style . '">' . esc_html__( 'LOAD MORE', 'palleon' ) . '</button>';
                    }
                }

            }
        }
        wp_die();
    }

    /**
	 * Load More
	 */
    public function load_more() {
        $getApiKey =  PalleonSettings::get_option('iconfinder', '');
        $apiKey = trim($getApiKey);
        $keyword =  $_POST['keyword'];
        if (!empty($keyword)) {
            $keyword = str_replace(' ', '%20', $keyword);
            $category =  $_POST['category'];
            $style =  $_POST['style'];
            $offset =  $_POST['page'];
            $license =  PalleonSettings::get_option('iconfinder_license', 'none');
            $exp =  PalleonSettings::get_option('iconfinder_exp', '1');
            $error = '';
            $caching =  PalleonSettings::get_option('iconfinder_caching', 24);

            $curlURL = 'https://api.iconfinder.com/v4/icons/search?query=' . $keyword . '&premium=0&vector=1&count=20&offset=' . $offset . '&license=' . $license . '&is_explicit=' . $exp;
            if ($category != 'none') {
                $curlURL .= '&category=' . $category;
            }
            if ($style != 'none') {
                $curlURL .= '&style=' . $style;
            }

            $transient_value = get_transient($curlURL); 

            if (false !== $transient_value){
                $response =	get_transient($curlURL);
            } else {
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $curlURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Bearer {$apiKey}"
                    )
                ));
            
                $response = curl_exec($ch);
                if (curl_errno($ch) > 0) {
                    $error = '{"message": "' . esc_html__( 'Error connecting to API. ', 'palleon' ) . curl_error($ch) . '"}';
                }
            
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($responseCode !== 200) {
                    $error = '{"message": "HTTP ' . $responseCode . ' - ' . curl_error($ch) . '"}';
                }
                if ($responseCode === 429) {
                    $error = '{"message": "' . esc_html__( 'API request rate limit exceeded.', 'palleon' ) . '"}';
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
                echo json_encode($error);
            } else {
                $total = intval($data->total_count);
                if ($total !== 0) {
                    $icons = $data->icons;
                    foreach ( $icons as $icon ) {
                        $vector_sizes = $icon->vector_sizes;
                        $formats = $vector_sizes[0]->formats;
                        $svg = '';
                        foreach ( $formats as $item ) {
                            $format = $item->format;
                            if ($format === 'svg') {
                                $svg = $item->download_url;
                                break;
                            }
                        }
                        $raster = $icon->raster_sizes;
                        $img = '';
                        foreach ( $raster as $size ) {
                            $imgSize = $size->size;
                            if ($imgSize == 128) {
                                $img = $size->formats[0]->preview_url;
                                break;
                            }
                        }
                        if (empty($img)) {
                            foreach ( $raster as $size ) {
                                $imgSize = $size->size;
                                if ($imgSize >= 64) {
                                    $img = $size->formats[0]->preview_url;
                                    break;
                                }
                            }
                        }
                        $tags = $icon->tags;
                        $alt = implode(", ", $tags);

                        echo '<div class="palleon-element iconfinder-add" data-iconsource="' . esc_url($svg) . '" title="' . esc_attr($alt) . '"><div class="palleon-img-wrap"><img class="lazy" data-src="' . esc_url($img) . '" /></div></div>';
                    }
                }
            }
        }
        wp_die();
    }

}

/**
 * Returns the main instance of the class
 */
function PalleonIconfinder() {  
	return PalleonIconfinder::instance();
}
// Global for backwards compatibility
$GLOBALS['PalleonIconfinder'] = PalleonIconfinder();    