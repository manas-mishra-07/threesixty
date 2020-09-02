jQuery(document).ready(function ($) {

    
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    var isMobile = true;
}else{
    var isMobile = false;
}
if(isMobile){
    $('#site-navigation .sub-menu').show();
}
$(window).resize(function(){
    setTimeout(function(){
        if ( $(window).width() > 768) {
            if(isMobile){
                $('#site-navigation .sub-menu').show();
            }
        }
    },1000)
});
    
//Menue Hover
if ( $(window).width() > 768) {
$("#site-navigation ul li").hoverIntent({
    over:function(){
            $(this).addClass('hover');
             $(this).children('.sub-menu').slideDown(200);
    },
    out: function(){
            $(this).children('.sub-menu').slideUp(200);
            $('#site-navigation ul li').removeClass('hover');
    }
});
}
if(isMobile){
    $(".side_menu .menu-item-has-children > a:after").css("display", "none");
}
//Home Video Section
var myPlayer;
myPlayer = $('.js-video').YTPlayer();
$('#togglePlay').click(function(){
    $('#container-1').YTPTogglePlay();
    $("#togglePlay").toggleClass('play');
    $('#plx_video_section .title_desc').toggleClass('play');
    $('.video_wrap').toggleClass('play');
    return false;
});
$('.YTPOverlay').click(function(){
    $("#togglePlay").toggleClass('play');
    $('#plx_video_section .title_desc').toggleClass('play');
    $('.video_wrap').toggleClass('play');
    return false;
});


//Responsive menu toggle    
$("#toggle").click(function () {
    $(this).toggleClass("menu_visible");
    $('#menu').toggleClass('nav_visable');
    $('#site-navigation_normal').toggleClass('responsive_menu');
    $('#side-menu-title').toggleClass('menu-visable');
});

$('#site-navigation').click(function(event){
    event.stopPropagation();
});
$('#toggle').click(function(event){
   event.stopPropagation();
});
$('body').click(function() {
   $('#toggle').removeClass("menu_visible");
    $('#menu').removeClass('nav_visable');
    $('#side-menu-title').removeClass('menu-visable');
});

//custom scromm menu

$(".main-navigation").mCustomScrollbar();

var width_window = $( window ).width();
//Sickey Sidebar
if(width_window > '984'){
$('#secondary, #primary').theiaStickySidebar({additionalMarginTop: 60});
}

//Slider Header
 $('.heade_bg_slider').maximage({
        cycleOptions: {
        		prev: '#arrow_left',
        		next: '#arrow_right',
                fx: 'fade',
        		speed: 5000,  //Set the speed for CSS transitions in jQuery.maximage.css (lines 30 - 33)
        		timeout: 10000,
        		pause: 1
        	},
            backgroundSize: 'contain'
    });
    if ( $( ".banner_timer" ).is( ".arrow-enable" ) ) {
        $(".heade_bg_slider_image_size").owlCarousel({
            nav:true,
            animateOut: 'fadeOut',
            navText:['',''],
            items:1
        });
    }
    else{
        $(".heade_bg_slider_image_size").owlCarousel({
            nav:true,
            animateOut: 'fadeOut',
            navText:['NEXT','PREV'],
            items:1
        });
    }
 if ( $(window).width() > 768) {
var example = $('#primary-menu-simple').superfish({
		//add options here if required
        delay: 50,
	});
 }
// Stickey Menu
$(".header_menu").sticky();

//Home Entrance animation                    
var wow = new WOW(
    {
        boxClass: 'wow', // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset: 150, // distance to the element when triggering the animation (default is 0)
        mobile: true, // trigger animations on mobile devices (default is true)
        live: true, // act on asynchronously loaded content (default is true)
        callback: function (box) {
            // the callback is fired every time an animation is started
            // the argument that is passed in is the DOM node being animated
        }
    }
);
wow.init();
    
//Carousel client images js start
$("#carousel_client").owlCarousel({
    margin:10,
    nav:true,
    margin: 50,
    navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
    responsive:{
          0:{
                items:1
            },
            360:{
                items:1
            },
             411:{
                items:2
            },
            435:{
                items:2
            },
            500:{
                items:3
            },
            650:{
                items:4
            },
            1000:{
                items:5
            }
        }
});

//Carousel client images js end
var updateTime = function()
{
    var date = $("#date").val();
    var time = $("#time").val();
    var datetime = date + ' ' + time + ':00';
    $("#DateCountdown").data('date', datetime).TimeCircles().start();
}

//Testimonial Slider
var owl = $(".bxslider_testimonial").owlCarousel({
    margin:10,
    nav:false,
    responsive:{
          0:{
                items:1
            },
            360:{
                items:1
            },
             411:{
                items:1
            },
            435:{
                items:1
            },
            500:{
                items:1
            },
            650:{
                items:1
            },
            1000:{
                items:1
            }
        }
});

//Feature Slider
var owl = $(".feature_slider_wrap").owlCarousel({
    margin:10,
    nav:false,
    responsive:{
          0:{
                items:1
            },
            360:{
                items:1
            },
             411:{
                items:1
            },
            435:{
                items:1
            },
            500:{
                items:1
            },
            650:{
                items:1
            },
            1000:{
                items:1,
            }
        }
});

//Parallax BG
$(window).load(function(){
    $('.footer_call_to_action').parallax('50%', 0.4, true);
    $('#plx_pricing_section').parallax('50%', 0.4, true);
    $('#plx_service_section').parallax('50%', 0.4, true);
    $('#plx_feature_section').parallax('50%', 0.4, true);
    $('#plx_blogs_section').parallax('50%', 0.4, true);
    $('#plx_client_section').parallax('50%', 0.4, true);
    $('#plx_testimonial_section').parallax('50%', 0.4, true);
    $('#plx_cta_section').parallax('50%', 0.4, true);
    $('#plx_contact_section').parallax('50%', 0.4, true);
});

// Slider Countdowm JS
var date = $('#lwt-countdown-losange').text();
if(date){
    var myarr = date.split("-");
    var day = myarr[0];
    var month = myarr[1];
    var year = myarr[2];
    var hour = myarr[3];
    var min = myarr[4];
    var sec = '0';
    $('#countdown_dashboard').countDown({
    	targetDate: {
    		'day': 		day,
    		'month': 	month,
    		'year': 	year,
    		'hour': 	hour,
    		'min': 		min,
    		'sec': 		sec
    	}
    });
 }
});
