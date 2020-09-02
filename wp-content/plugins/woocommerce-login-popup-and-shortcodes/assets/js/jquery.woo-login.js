(function( $, window, document, undefined ) {
    $( document ).ready(function(){
        $( document ).on( 'click', '.woo-login-popup-sc-open', function( e ){
            var hrf = $(this).attr('href');
            var arr = [ '#woo-login-popup-sc-login' ,'#woo-login-popup-sc-register', '#woo-login-popup-sc-password' ];

            if( typeof hrf == 'undefined' ){
                hrf = $(this).find( 'a' ).attr('href');
            }

            if( typeof hrf != 'undefined' && jQuery.inArray( hrf, arr ) >  -1 ){
                $( '.woo-login-popup-sc' ).hide();
                $( hrf ).show();
            }else{
                $( '.woo-login-popup-sc' ).hide();
                $( '#woo-login-popup-sc-login' ).show();
            }
            if( $( '.woo-login-popup-sc-modal-off' ).length > 0 ){
                $('html, body').animate({
                    scrollTop: $( '.woo-login-popup-sc-modal-off' ).offset().top - 30
                }, 400);
                $( '.woo-login-popup-sc-modal-overlay' ).show();
            }else{
                var ftop = '100px';
                if ( $(window).width() < 700 ){
                    ftop = '20px';
                }
                $( '.woo-login-popup-sc-modal-overlay, .woo-login-popup-sc-modal-on' ).show();
                $( '.woo-login-popup-sc-modal-on' ).animate({ top : ftop }, 400 );
            }

            e.preventDefault();
            e.stopPropagation();
        });

        $( document ).on( 'click', '.woo-login-popup-sc-toggle', function( e ){
            var href = $(this).attr('href');

            if (typeof href  !== "undefined"){
                $( '.woo-login-popup-sc' ).fadeOut('fast').promise().done(function(){
                     $(href).show();
                 });
            }

            e.preventDefault();
            e.stopPropagation();
        } );

        $( document ).on( 'click', '.woo-login-popup-sc-modal-overlay, .woo-login-popup-sc-close a', function( e ){
            woo_login_styler_esc();
            e.preventDefault();
            e.stopPropagation();
        });

        $(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                woo_login_styler_esc();
            }
        });
    });
    function woo_login_styler_esc(){
        $( '.woo-login-popup-sc-modal-overlay' ).fadeOut(100);
        $( '.woo-login-popup-sc-modal-on' ).animate({ top :'-200px', 'opacity' : '0' }, 250, function(){
            $( '.woo-login-popup-sc-modal-on' ).css({ 'display' : 'none', 'opacity' : '1' })
        } );
    }
})( jQuery, window, document );
