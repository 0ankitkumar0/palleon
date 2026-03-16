/*!
 * Palleon - Initialization JavaScript File
 * Unminified version for development purposes
 * This initializes the Palleon image editor with configuration options
 */

!function(a) {
    "use strict";
    
    // Initialize Palleon when document is ready
    a(document).ready(function() {
        // Initialize the palleon plugin on the main element
        a("#palleon").palleon({
            // Enable GL filtering based on configuration
            enableGLFiltering: "true" === palleonParams.enableGLFiltering,
            
            // Texture size for canvas operations
            textureSize: palleonParams.textureSize,
            
            // Version information (frontend/backend)
            version: palleonParams.version,
            
            // Watermark configuration
            watermark: palleonParams.watermark,
            watermarkText: palleonParams.watermarkText,
            watermarkFontFamily: palleonParams.watermarkFontFamily,
            watermarkFontColor: palleonParams.watermarkFontColor,
            watermarkFontSize: palleonParams.watermarkFontSize,
            watermarkStrokeColor: palleonParams.watermarkStrokeColor,
            watermarkFontStyle: palleonParams.watermarkFontStyle,
            watermarkLocation: palleonParams.watermarkLocation,
            watermarkFontWeight: palleonParams.watermarkFontWeight,
            
            // Custom functions for addon modules
            customFunctions: function(a, r, e) {
                // Load antimena addon if available
                if ("function" == typeof antimena) {
                    antimena(a, r, e);
                }
                
                // Load furcifer addon if available
                if ("function" == typeof furcifer) {
                    furcifer(a, r, e);
                }
                
                // Load trioceros addon if available
                if ("function" == typeof trioceros) {
                    trioceros(a, r, e);
                }
            }
        });
    });
    
}(jQuery);
