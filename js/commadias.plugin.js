jQuery.fn.commaDias = function() {
    this.each( function() {
        jQuery( this ).html(
            jQuery( this ).html()
                .replace( /ș/g, "ş" )
                .replace( /ț/g, "ţ" )
                .replace( /Ș/g, "Ş" )
                .replace( /Ț/g, "Ţ" )
        );
    } );
return jQuery( this );
};