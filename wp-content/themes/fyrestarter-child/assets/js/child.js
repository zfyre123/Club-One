jQuery(document).ready(function($) {

//KEEPS WINDOW AT TOP
$(window).scrollTop(0);

// // ANIMATIONS
//     wow = new WOW(
//         {
//             boxClass:     'wow',
//             animateClass: 'animated',
//             offset:       0, 
//             mobile:       false, 
//             live:         true
//         }
//     )
//     wow.init(); 
	

var stickyTop = $('.sticky-grab').offset().top + 20;

$(window).on( 'scroll', function(){
    if ($(window).scrollTop() >= stickyTop) {
        $('.sticky-grab').addClass('sticky');
        if ($("#navigation").hasClass("wht-nav")) {
          $('#logo img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');
        }
        if ($("#navigation-mobile").hasClass("wht-nav")) {
          $('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');
        }
        //MOBILE
        $('.sticky-mobile').addClass('sticky');
    } else {
        $('.sticky-grab').removeClass('sticky');
        if ($("#navigation").hasClass("wht-nav")) {
            $('#logo img').attr('src','/wp-content/uploads/2020/06/club-one-logo-wht.png');
        }
        if ($("#navigation-mobile").hasClass("wht-nav")) {
            $('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/club-one-logo-wht.png');
        }
        //MOBILE
        $('.sticky-mobile').removeClass('sticky');          
        // $('#navigation li').removeClass('current');
        // $('#mobile-menu-nav  li').removeClass('current');
    }
});



$('#navigation ul.sub-menu li.menu-item-has-children .sub-menu').addClass('inner-sub-menu');
$('#navigation ul.sub-menu li.menu-item-has-children .sub-menu').removeClass('sub-menu');

$('#main-nav > ul > li > a').wrapInner("<span class='inner-menu-item'></span>");


//TESTIMONIAL SLIDER
$('.testimonial-slider').slick({
    dots: false,
    //appendDots: '.appendDots',
    swipeToSlide: true,
    //fade: true,
    //vertical: true,
    //verticalSwiping: true,
    arrows: false,
    infinite: true,
    autoplay: true,
    draggable: true,
    speed: 900,
    swipeToSlide: true,
    autoplaySpeed: 4000
  })


//TESTIMONIAL SLIDER
$('.resources-slider').slick({
  dots: false,
  speed: 900,
  slidesToShow: 4,
 // slidesToScroll: 3,
  //centerMode: true,
  //centerPadding: '15px',
  infinite: false,
  variableWidth: false,
  responsive: [
    {
      breakpoint: 991,
      settings: {
        dots: true,
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 768,
      settings: {
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 575,
      settings: {
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
})




// NAV HEIGHT
    // $(window).on("resize", function () {
    //     //$header_height = $('#main-nav-contained').outerHeight();
    //     $header_height = $('#nav-header').outerHeight();
    //     $page_header_height = $('#page-header').outerHeight();
    //     $home_header_height = $('#home-header').outerHeight();
    //     $footer_height = $('#footer').outerHeight();
    //     $window_height = $( window ).height();
    //     $neg_height = $header_height + $footer_height + $page_header_height + $home_header_height;
    //     $content_height = $window_height - $neg_height;

    //    //$('body').css({"padding-top":$header_height+"px"});
    //    //$('#fyre.home .slick-initialized .slick-slide').css({"height":$content_height+"px"});
    //    //$('#fyre .slick-initialized .slick-slide').css({"height":$content_height+"px"});
    //    //$('.front-page #main').css({"height":$content_height+"px"});
    //    $('#below-header').css({"min-height":$content_height+"px"});
    //    //$('#home-header').css({"height":$content_height+"px"});
    //    //$('#home-header .home-slide').css({"height":$content_height+"px"});
    //    //$('#home-header .home-slider-text').css({"height":$content_height+"px"});
    //    //$('#home-header .slideshow').css({"height":$content_height+"px"});
    //    //$('#main').css({"min-height":$content_height+"px"});

    // }).resize();


//L SEP


//nav
  $(".menu-toggle").on('click', function() {
    $(".menu-toggle").toggleClass("on");
    $("#fade-nav").toggleClass('hidden');
    $(".fade-nav-overlay").toggleClass('no-hide');
    $(".fade-in-menu").toggleClass('no-hide');
    $(".menu-item-has-children").removeClass("on");
    $(".sub-menu").removeClass('open');
  });




//HAMBURGER
$('#mobile-btn').click(function(){
    $('#mobile-btn').toggleClass('active');
    $('#off-canvas-nav').toggleClass('active');
    //LOGO
    if ( $("#off-canvas-nav").hasClass("active") ) {
      $('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');
    } else if ( $("#navigation-mobile").hasClass("sticky") || !$("#navigation-mobile").hasClass("wht-nav") ) {
      $('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');
    } else {
      $('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/club-one-logo-wht.png'); 
    }
});




$('.link-move a').click(function(){
     $('html, body').animate({
         scrollTop: $( $.attr(this, 'href') ).offset().top - 0
     }, 500);
     return false;
 }); 






//equal height
equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.team-box');
});

$(window).resize(function(){
  equalheight('.team-box');
});





//STAFF MODAL
  $('#myModal-story').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var name = button.data('header'); // Extract info from data-* attributes
    var content = button.data('content');
    var img = button.data('img');
    //var gradient = button.data('gradient');
    var modal = $(this);  

    modal.find('.story-title').text(name.replace('<br>', ''));
    modal.find('.story-content').html( content.replace(/(?:\r\n|\r|\n)/g, '') );
    modal.find('.story-head-shot').css( 'background-image', 'url('+ img +')');  

  });

  $('#myModal-story').on('hidden.bs.modal', function () {
    var modal = $(this);
    modal.find('.story-title').text('');
    modal.find('.story-content').text('');
    modal.find('.story-head-shot').css( 'background-image', '');  
    //modal.find('.modal-content').css('background', '');
  });


  $('.modal-btn .btn').click(function(){
      $('#myModal-story').modal("hide");
  });


}); 
