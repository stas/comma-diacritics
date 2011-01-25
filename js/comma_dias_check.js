jQuery(document).ready(function() {  
    if( navigator.platform == "Win32" || navigator.platform == "Win64" ) {
        jQuery('#wrapper').commaDias();
        jQuery('title').commaDias();
    }
});