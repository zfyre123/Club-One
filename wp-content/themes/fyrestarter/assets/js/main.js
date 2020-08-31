jQuery(document).ready(function($) {

//OFF CANVAS
    $('[data-toggle="offcanvas"]').click(function () {
        $('#sidebar-offcanvas').toggleClass('active')
    });

// ANIMATIONS
    wow = new WOW(
        {
            boxClass:     'wow',
            animateClass: 'animated',
            offset:       0, 
            mobile:       true, 
            live:         true
        }
    )
    wow.init(); 

// NAV HEIGHT
    $(window).on("resize", function () {
        $header_height = $('#header').outerHeight();
        $footer_height = $('#footer').outerHeight();
        $window_height = $( window ).height();
        $neg_height = $header_height + $footer_height;
        $content_height = $window_height - $neg_height;

       $('body').css({"padding-top":$header_height+"px"});
       $('#main').css({"min-height":$content_height+"px"}); 

    }).resize();

// MENU TOGGLE
    $('.navbar-toggler').click(function(){  
        if ($('.navbar-toggler .fa').hasClass('fa-bars')){ 
            //$('.navbar-toggler .fa').removeClass('fa-bars', '150', 'easeInQuart').addClass('fa-close', '150', 'easeInQuart');
            $('.navbar-toggler .fa').switchClass('fa-bars', 'fa-close', '800', 'easeInOutQuart' );
        } else { 
            //$('.navbar-toggler .fa').removeClass('fa-close', '150', 'easeInQuart').addClass('fa-bars', '150', 'easeInQuart');
            $('.navbar-toggler .fa').switchClass('fa-close', 'fa-bars', '800', 'easeInOutQuart' );
        }
    }); 

});