jQuery(document).ready(function($){
    wp.customize('the_launcher_h1_font_size',function( value ){
       value.bind(function( h1_font_size ){
            $( 'h1' ).attr( 'style','font-size:'+h1_font_size+'px' );
       });  
    });
     wp.customize('the_launcher_h2_font_size',function(value){
       value.bind(function(h2_font_size){
            $('h2').attr('style','font-size:'+h2_font_size+'px');
       });  
    });
    wp.customize('the_launcher_h3_font_size',function(value){
       value.bind(function(h3_font_size){
            $('h3').attr('style','font-size:'+h3_font_size+'px');
       }); 
    });
    wp.customize('the_launcher_h4_font_size',function(value){
       value.bind(function(h4_font_size){
            $('h3').attr('style','font-size:'+h4_font_size+'px');
       }); 
    });
    wp.customize('the_launcher_h5_font_size',function(value){
        value.bind(function(h5_font_size){
            $('h5').attr('style','font-size:'+h5_font_size+'px');
        });    
    });
    wp.customize('the_launcher_h6_font_size',function(value){
        value.bind(function(h6_font_size){
            $('h6').attr('style','font-size:'+h6_font_size+'px');
        });    
    });
    wp.customize('the_launcher_body_font_size',function(value){
        value.bind(function(body_font_size){
            $('body').attr('style','font-size:'+body_font_size+'px');
        });    
    });
    wp.customize( 'the_launcher_h1_font', function( value ) {
		value.bind( function( h1_font ) {
		  if(h1_font){
			$( 'h1' ).attr( 'style', 'font-family: '+h1_font+'' );
            WebFont.load({
            google: {
              families: [h1_font]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_h2_font', function( value ) {
		value.bind( function( h2_font ) {
		  if(h2_font){
			$( 'h2' ).attr( 'style', 'font-family: '+h2_font+'' );
            WebFont.load({
            google: {
              families: [h2_font]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_h3_font', function( value ) {
		value.bind( function( h3_font ) {
		  if(h3_font){
			$( 'h3' ).attr( 'style', 'font-family: '+h3_font+'' );
            WebFont.load({
            google: {
              families: [h3_font]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_h4_font', function( value ) {
		value.bind( function( h4_font ) {
		  if(h4_font){
			$( 'h4' ).attr( 'style', 'font-family: '+h4_font+'' );
            WebFont.load({
            google: {
              families: [h4_font]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_h5_font', function( value ) {
		value.bind( function( h5_font ) {
		  if(h5_font){
			$( 'h5' ).attr( 'style', 'font-family: '+h5_font+'' );
            WebFont.load({
            google: {
              families: [h5_font]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_h6_font', function( value ) {
		value.bind( function( h6_font ) {
		  if(h6_font){
			$( 'h6' ).attr( 'style', 'font-family: '+h6_font+'' );
            WebFont.load({
            google: {
              families: [h6_font]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_body_font', function( value ) {
		value.bind( function( body ) {
		  if(body){
			$( 'body' ).attr( 'style', 'font-family: '+body+'' );
            WebFont.load({
            google: {
              families: [body]
            }
          });
          }
		} );
	});
    wp.customize( 'the_launcher_skin_color', function( value ) {
		value.bind( function( skin_color ) {
			$('input[type="submit"].newsletter-submit, .blogs_date_wrap .date_blogs, .the_launcher_pricing_button_link_class a, .launcher_video .play-pause-video, .cta_button button, .contact_section_wrap .home-map-section aside form input[type="submit"]').css('background', skin_color );
            $('.the_launcher_pricing_button_link_class a, .main_wrap_feature .owl-carousel .owl-controls .owl-dot.active span, #plx_testimonial_section .owl-carousel .owl-controls .owl-dot.active span, .cta_button button, .contact_section_wrap .home-map-section aside form input[type="submit"]').css('border', '2px solid '+skin_color+'');
            $('.header_logo .site-title a').css('color',skin_color);
		} );
	} );   
    
    function LightenDarkenColor(col,amt) {
        var usePound = false;
        if ( col[0] == "#" ) {
            col = col.slice(1);
            usePound = true;
        }
    
        var num = parseInt(col,16);
    
        var r = (num >> 16) + amt;
    
        if ( r > 255 ) r = 255;
        else if  (r < 0) r = 0;
    
        var b = ((num >> 8) & 0x00FF) + amt;
    
        if ( b > 255 ) b = 255;
        else if  (b < 0) b = 0;
    
        var g = (num & 0x0000FF) + amt;
    
        if ( g > 255 ) g = 255;
        else if  ( g < 0 ) g = 0;
    
        return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
    }
    
    wp.customize( 'the_launcher_skin_color', function( value ) {
		value.bind( function( newval ) {
		  if(newval){
          var result = newval.split("#");
          var color = result['1']
		  var myColor = color;
          var myColor1 = LightenDarkenColor(myColor,-50);
          var thePlaceTheColorIsUsed = ("#" + myColor1);
		  var borderColor = '<style>' +
          '.blogs_date_wrap .date_blogs:after{border-left-color:'+thePlaceTheColorIsUsed+';}'+
          '.the_launcher_pricing_button_link_class a:hover, input[type="submit"].newsletter-submit:hover, .cta_button button:hover, .main-navigation ul li a:hover{background:'+thePlaceTheColorIsUsed+' !important;}'+
          '.main_wrap_feature .owl-carousel .owl-controls .owl-dot span:hover, .blogs_post_wrap .blog_title_content:before, #plx_testimonial_section .owl-carousel .owl-controls .owl-dot span:hover, .testimonial_image:before, .circle_div:before{border:2px solid '+newval+' !important; }'+
          '.footer_area_launcher .title_content_wrap .tn_title a:hover, #arrow_left:hover, #arrow_right:hover, .top_menu ul li a:hover, .bottom_menu ul li a:hover, blog_title_content .blog_title a:hover, footer .site-info span a:hover, .service_posts_wrap .service_title a:hover, .blog_title_content .blog_title a:hover{color:'+newval+' !important;}'+
          '</style>';
          $('#launcher-dynamic-styles').html(borderColor);
          }
		} );
	} );
    
    wp.customize('the_launcher_blogs_section_sub_title',function( value ){
       value.bind( function ( newval ){
            $('#plx_blogs_section .service_sub_title').html(newval);
       });   
    });
    wp.customize( 'the_launcher_blogs_section_title', function( value ) {
		value.bind( function( newval ) {
			$( '#plx_blogs_section .service_title' ).html( newval );
		} );
	} );
    
     wp.customize( 'the_launcher_service_section_title', function( value ) {
		value.bind( function( newval ) {
			$( '#plx_service_section .service_title' ).html( newval );
		} );
	});
     wp.customize( 'the_launcher_service_section_sub_title', function( value ) {
		value.bind( function( newval ) {
			$( '#plx_service_section .service_sub_title' ).html( newval );
		} );
    });
    
    wp.customize( 'the_launcher_service_desc', function( value ) {
		value.bind( function( newval ) {
			$( '#plx_service_section .service_desc' ).html( newval );
		} );
    });
    wp.customize( 'the_launcher_video_section_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_video_section .service_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_video_section_sub_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_video_section .service_sub_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_video_desc', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_video_section .service_desc' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_pricing_section_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_pricing_section .service_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_pricing_section_sub_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_pricing_section .service_sub_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_pricing_desc', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_pricing_section .service_desc' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_testimonial_section_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_testimonial_section .service_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_testimonial_section_sub_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_testimonial_section .service_sub_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_client_section_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_client_section .service_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_client_section_sub_title', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_client_section .service_sub_title' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_cta_desc', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_cta_section .cta_description' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_button_text_cta', function( value ) {
    	value.bind( function( newval ) {
    		$( '#plx_cta_section .cta_button a button' ).html( newval );
    	} );
    });
    wp.customize( 'the_launcher_footer_copy_right', function( value ) {
    	value.bind( function( newval ) {
    		$( '.text_input' ).html( newval + ' | ' );
    	} );
    });
    wp.customize( 'the_launcher_service_title_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_service_section .title_sub .service_title, .service_posts_wrap .service_title a, #plx_service_section .title_sub .service_sub_title').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_service_content_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_service_section .service_posts_wrap .service_content, #plx_service_section .service_desc').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_feature_title_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_feature_section .main_wrap_feature .title_feature').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_feature_content_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_feature_section .main_wrap_feature .desc_feature p').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_blogs_title_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_blogs_section .title_sub .service_title, #plx_blogs_section .title_sub .service_sub_title, #plx_blogs_section .blog_title_content .blog_title a').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_blogs_content_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_blogs_section .blog_title_content .blog_content').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_pricing_title_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_pricing_section .title_sub .service_title, #plx_pricing_section .title_sub .service_sub_title').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_pricing_content_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_pricing_section .service_desc').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_testimonial_title_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_testimonial_section .title_sub .service_title, #plx_testimonial_section .title_sub .service_sub_title, #plx_testimonial_section .testimonial_main h3').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_testimonial_content_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_testimonial_section .testimonial_content').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_contact_title_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_contact_section .contact_section_wrap .home-map-section .ufbl-default-template .ufbl-form-title, #plx_contact_section .contact_section_wrap .contact_title, #plx_contact_section .contact_section_wrap  .contact_sub_title').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_contact_content_color', function( value ) {
    	value.bind( function( newval ) {
            $('#plx_contact_section .contact_section_wrap  .contact_desc').css('color',newval);
    	} );
    });
    wp.customize( 'the_launcher_enable_service', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_service_section').css('display','none');
            }
            else{
                $('#plx_service_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_feature', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_feature_section').css('display','none');
            }
            else{
                $('#plx_feature_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_blogs', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_blogs_section').css('display','none');
            }
            else{
                $('#plx_blogs_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_video', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_video_section').css('display','none');
            }
            else{
                $('#plx_video_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_pricing', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_pricing_section').css('display','none');
            }
            else{
                $('#plx_pricing_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_testimonial', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_testimonial_section').css('display','none');
            }
            else{
                $('#plx_testimonial_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_client', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_client_section').css('display','none');
            }
            else{
                $('#plx_client_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_cta', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_cta_section').css('display','none');
            }
            else{
                $('#plx_cta_section').css('display','block');
            }
    	} );
    });
    wp.customize( 'the_launcher_enable_contact', function( value ) {
    	value.bind( function( newval ) {
            if(newval == ''){
                $('#plx_contact_section').css('display','none');
            }
            else{
                $('#plx_contact_section').css('display','block');
            }
    	} );
    });
});