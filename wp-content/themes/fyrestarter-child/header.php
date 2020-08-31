<!DOCTYPE html>
<html lang="en">
<!--
                 /
        //        /
        //      //
         //     //
         ///    //
          //   ////
          ///  ////
         ////  /////
         //// //////
         //// ///////
        ///// ///////
       ////// ////////
      /////// //////////
/     ////// ////////////
 //   ////// //////////////
  /// ////// ////////////////
   ///////// ///////////////////
    ////////  /////////////////////
     //////// /////////////////////////
     ///////// //////////////////////////
     ////////// ///////////////////////////
     /////////// ///////////////////////////
      /////////// ///////////////////////////
      ///////////// //////////////////////////
      /////////////////                    ////
     //////////////////                    /////
     //////////////////     /////////////////////
     //////////////////     /////////////////////
     //////////////////     /////////////////////
     //////////////////                //////////
      /////////////////                //////////
       ////////////////     ////////////////////
        ///////////////     ////////////////////
         //////////////     ///////////////////
           ////////////     ////////////////
             //////////     ///////////////
               ////////     /////////////
                 //////     /////////
-->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

  <link rel="stylesheet" href="https://use.typekit.net/rnw8nfk.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <?php echo get_option('track_code'); ?> 
  <?php wp_head(); ?> 
</head>

<div id="hide"></div>

<body id="fyre" <?php body_class(); ?> itemscope itemtype="<?php echo get_option('schema_url'); ?>">

<div id="navs">

<!-- main nav -->
<div id="main-nav-contained" class="hidden-md-down">
  <?php 
    //var
    $light_header = get_field('light_header');
  if( $light_header && in_array('yes', $light_header) || !is_front_page() && is_home() || is_category() || is_single() && 'post' == get_post_type() || is_single() && 'teams' == get_post_type() || is_404() ) { ?>
    <header id="navigation" class="sticky-grab wht-nav">
  <?php } else { ?>
    <header id="navigation" class="sticky-grab">
  <?php } ?>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="d-flex justify-content-between"> 

            <div id="logo">
              <a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo( 'name' ); ?>">
                <?php 
                if( $light_header && in_array('yes', $light_header) || !is_front_page() && is_home() || is_category() || is_single() && 'post' == get_post_type() || is_single() && 'teams' == get_post_type() || is_404() ) { ?>
                  <img itemprop="logo" src="<?php echo get_option('alt_logo_url'); ?>" />
               <?php } else { ?>
                  <img itemprop="logo" src="<?php echo get_option('logo_url'); ?>" />
                <?php } ?>
              </a>
            </div>     
            <div id="main-nav" class="d-flex justify-content-center flex-column">
              <?php wp_nav_menu( array(
                'theme_location' => 'primary',
                'container' => 'ul',
                'menu_class' => 'd-flex', //Adding the class for dropdowns
              ) ); ?>
            </div>

          </nav>
        </div>
      </div>
    </div>
  </header>
</div>
<!-- main nav -->

<!-- mobile nav -->

<div id="mobile-nav-contained" class="hidden-lg-up">
<?php 
    if( $light_header && in_array('yes', $light_header) || !is_front_page() && is_home() || is_category() || is_single() && 'post' == get_post_type() || is_single() && 'teams' == get_post_type() || is_404() ) { ?>
  <header id="navigation-mobile" class="sticky-mobile wht-nav">
<?php } else { ?>
  <header id="navigation-mobile" class="sticky-mobile">
<?php } ?>
      <div class="container">

          <div class="row">
            <div class="col-12">
              <nav class="mobile-nav" role="navigation" aria-label="mobile navigation" class="d-flex justify-content-between"> 

                <a id="mobile-brand" class="navbar-brand" href="/" title="<?php echo get_bloginfo( 'name' ); ?>">
                  <?php 
                    if( $light_header && in_array('yes', $light_header) || !is_front_page() && is_home() || is_category() || is_single() && 'post' == get_post_type() || is_single() && 'teams' == get_post_type() || is_404() ) { ?>
                    <img itemprop="logo" src="<?php echo get_option('alt_logo_url'); ?>" />
                  <?php } else { ?>
                    <img itemprop="logo" src="<?php echo get_option('logo_url'); ?>" />
                  <?php } ?>
                </a>

                <div id="mobile-btn">
                  <span class="top"></span>
                  <span class="middle"></span>
                  <span class="bottom"></span>
                </div>

              </nav>
            </div>
          </div>
        

        <!-- off canvas nav -->
          <div id="off-canvas-nav">
            <div id="mobile-menu-all">
              <div id="mobile-menu-scroll">

                <div class="menu-mobile">
                  <div class="container">
                    <div class="row">
                      <div class="col-12">
                        <?php fyre_mobile_menu() ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="btm-mobile">
                  <div class="container">
                    <div class="row">
                      <div class="col-12">
                        <div class="btm-mobile-contained">
                          <?php fyre_mobile_menu_btm() ?>
                          <ul class="nav-socials d-flex justify-content-center">
                            <?php if (!empty(get_option('fb_url'))) { ?>
                                <li><a href="<?php echo get_option('fb_url'); ?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
                            <?php } if (!empty(get_option('ig_url'))) { ?>
                                <li><a href="<?php echo get_option('ig_url'); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <?php } if (!empty(get_option('yt_url'))) { ?>
                                <li><a href="<?php echo get_option('yt_url'); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <?php } ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>     
                </div>

              </div>
            </div>
          </div>
        <!-- off canvas nav -->

      </div>
  </header>
</div>
<!-- mobile nav -->

</div>

<main id="main">
