jQuery(document).ready(function($){$(window).scrollTop(0);var stickyTop=$('.sticky-grab').offset().top+20;$(window).on('scroll',function(){if($(window).scrollTop()>=stickyTop){$('.sticky-grab').addClass('sticky');if($("#navigation").hasClass("wht-nav")){$('#logo img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');}
if($("#navigation-mobile").hasClass("wht-nav")){$('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');}
$('.sticky-mobile').addClass('sticky');}else{$('.sticky-grab').removeClass('sticky');if($("#navigation").hasClass("wht-nav")){$('#logo img').attr('src','/wp-content/uploads/2020/06/club-one-logo-wht.png');}
if($("#navigation-mobile").hasClass("wht-nav")){$('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/club-one-logo-wht.png');}
$('.sticky-mobile').removeClass('sticky');}});$('#navigation ul.sub-menu li.menu-item-has-children .sub-menu').addClass('inner-sub-menu');$('#navigation ul.sub-menu li.menu-item-has-children .sub-menu').removeClass('sub-menu');$('#main-nav > ul > li > a').wrapInner("<span class='inner-menu-item'></span>");$('.testimonial-slider').slick({dots:false,swipeToSlide:true,arrows:false,infinite:true,autoplay:true,draggable:true,speed:900,swipeToSlide:true,autoplaySpeed:4000})
$('.resources-slider').slick({dots:false,speed:900,slidesToShow:4,infinite:false,variableWidth:false,responsive:[{breakpoint:991,settings:{dots:true,slidesToShow:2,slidesToScroll:2}},{breakpoint:768,settings:{dots:true,slidesToShow:1,slidesToScroll:1}},{breakpoint:575,settings:{dots:true,slidesToShow:1,slidesToScroll:1}}]})
$(".menu-toggle").on('click',function(){$(".menu-toggle").toggleClass("on");$("#fade-nav").toggleClass('hidden');$(".fade-nav-overlay").toggleClass('no-hide');$(".fade-in-menu").toggleClass('no-hide');$(".menu-item-has-children").removeClass("on");$(".sub-menu").removeClass('open');});$('#mobile-btn').click(function(){$('#mobile-btn').toggleClass('active');$('#off-canvas-nav').toggleClass('active');if($("#off-canvas-nav").hasClass("active")){$('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');}else if($("#navigation-mobile").hasClass("sticky")||!$("#navigation-mobile").hasClass("wht-nav")){$('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/Full-Color.png');}else{$('#mobile-brand img').attr('src','/wp-content/uploads/2020/06/club-one-logo-wht.png');}});$('.link-move a').click(function(){$('html, body').animate({scrollTop:$($.attr(this,'href')).offset().top-0},500);return false;});equalheight=function(container){var currentTallest=0,currentRowStart=0,rowDivs=new Array(),$el,topPosition=0;$(container).each(function(){$el=$(this);$($el).height('auto')
topPostion=$el.position().top;if(currentRowStart!=topPostion){for(currentDiv=0;currentDiv<rowDivs.length;currentDiv++){rowDivs[currentDiv].height(currentTallest);}
rowDivs.length=0;currentRowStart=topPostion;currentTallest=$el.height();rowDivs.push($el);}else{rowDivs.push($el);currentTallest=(currentTallest<$el.height())?($el.height()):(currentTallest);}
for(currentDiv=0;currentDiv<rowDivs.length;currentDiv++){rowDivs[currentDiv].height(currentTallest);}});}
$(window).load(function(){equalheight('.team-box');});$(window).resize(function(){equalheight('.team-box');});$('#myModal-story').on('show.bs.modal',function(event){var button=$(event.relatedTarget);var name=button.data('header');var content=button.data('content');var img=button.data('img');var modal=$(this);modal.find('.story-title').text(name.replace('<br>',''));modal.find('.story-content').html(content.replace(/(?:\r\n|\r|\n)/g,''));modal.find('.story-head-shot').css('background-image','url('+img+')');});$('#myModal-story').on('hidden.bs.modal',function(){var modal=$(this);modal.find('.story-title').text('');modal.find('.story-content').text('');modal.find('.story-head-shot').css('background-image','');});$('.modal-btn .btn').click(function(){$('#myModal-story').modal("hide");});});;