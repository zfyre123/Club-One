<?php

// ADMIN BAR
  //show_admin_bar( false );

// CHILD THEME URI CONSTANTS
    define( 'FYRECHILD_DIR', get_stylesheet_directory_uri() );
    define( 'FYRECHILD_PATH', get_stylesheet_directory() );
    define( 'FYRECHILD_JS', FYRECHILD_DIR . '/assets/js' );
    define( 'FYRECHILD_CSS', FYRECHILD_DIR . '/assets/css' ); 
    define( 'FYRECHILD_INCLUDES' , FYRECHILD_PATH . '/assets/includes' );
    define( 'FYRECHILD_SHORTCODES' , FYRECHILD_PATH . '/assets/shortcodes' );

// INCLUDES
  include FYRECHILD_INCLUDES . '/custom-post-types.php';

// CHILD SCRIPTS
    function fyrechild_enqueue_styles() {  
    // CHILD SCRIPTS  
        // CHILD.JS
        wp_enqueue_script('child-js', FYRECHILD_JS . '/child.js', array('jquery'), false, true);
        // INSTAGRAMFEED.JS
        wp_enqueue_script( 'instagramFeed', FYRECHILD_JS . '/jquery.instagramFeed.min.js', array(), false, true );

    // PARENT/CHILD CSS
        // PARENT.CSS
        wp_enqueue_style('parentcss', FYRE_DIR . '/style.css');
        // CHILD.CSS
        wp_enqueue_style( 'childcss', FYRECHILD_DIR . '/style.css', array( 'bs4', 'parentcss' ) );

    // PAGE SPECIFICS
        // FRONT PAGE   
        if ( is_front_page() ) {  
          wp_enqueue_style('home', FYRECHILD_CSS . '/home.css', array(), null);
        }
        // INNER PAGES GLOBAL
        if ( !is_front_page() || !is_front_page() && !is_home() || !is_category() || !is_single() && 'post' == get_post_type() ) {  
          wp_enqueue_style('inner-pages-global', FYRECHILD_CSS . '/inner-pages-global.css', array(), null );
        }
        // TRAINING
        if ( is_page_template('training.php') ) {  
          wp_enqueue_style('training', FYRECHILD_CSS . '/training.css', array(), null );
        }
        // PLAY
        if ( is_page_template('play.php') ) {  
          wp_enqueue_style('play', FYRECHILD_CSS . '/play.css', array(), null );
        }
        // BECOME A COACH
        if ( is_page_template('become-a-coach.php') ) {  
          wp_enqueue_style('become-a-coach', FYRECHILD_CSS . '/become-a-coach.css', array(), null );
        }
        // TEAMS
        if ( is_page_template('teams.php') || is_single() && 'teams' == get_post_type() ) {  
          wp_enqueue_style('teams', FYRECHILD_CSS . '/teams.css', array(), null );
        }
        // STAFF
        if ( is_page_template('staff.php') || is_page_template('alumni.php') ) {  
          wp_enqueue_style('staff', FYRECHILD_CSS . '/staff.css', array(), null );
        }
        // INDOOR/BEACH
        if ( is_page_template('indoor.php') || is_page_template('beach.php') ) {  
          wp_enqueue_style('indoor-beach', FYRECHILD_CSS . '/indoor-beach.css', array(), null );
        }
        // EVENTS
        if ( is_page_template('events.php') || is_single() && 'tribe_events' == get_post_type() || strpos($_SERVER['REQUEST_URI'], "events") !== false ) {  
          wp_enqueue_style('events', FYRECHILD_CSS . '/events.css', array(), null );
        }
        // PARTNERSHIP
        if ( is_page_template('partnership.php') ) {  
          wp_enqueue_style('partnership', FYRECHILD_CSS . '/partnership.css', array(), null );
        }
        // BLOG PAGE - ARCHIVES & SINGLE
        if ( !is_front_page() && is_home() || is_category() || is_single() && 'post' == get_post_type() ) {
            wp_enqueue_style('blog', FYRECHILD_CSS . '/blog.css', array(), null );
        }
  }
  add_action( 'wp_enqueue_scripts', 'fyrechild_enqueue_styles' );

// Critical CSS
  function critical_css(){
    echo '<style>'; 
      include get_stylesheet_directory() . '/assets/css/main-menu.css';
      include get_stylesheet_directory() . '/assets/css/mobile-menu.css';
      include get_stylesheet_directory() . '/assets/css/footer.css';
      include get_stylesheet_directory() . '/assets/css/fonts.css';
    echo '</style>';
  }
  add_action('wp_head', 'critical_css');


// NEW MENUS

  add_action( 'after_setup_theme', 'register_primary_menu' );
   
  function register_primary_menu() {
      register_nav_menu( 'mobile-menu', __( 'Mobile Menu', 'fyrestarter' ) );
      register_nav_menu( 'mobile-menu-btm', __( 'Mobile Menu Btm', 'fyrestarter' ) );
      register_nav_menu( 'foot-menu', __( 'Foot Menu', 'fyrestarter' ) );
      register_nav_menu( 'foot-menu-btm', __( 'Foot Menu Btm', 'fyrestarter' ) );
  }

  // OFF CANVAS MENU
  function fyre_mobile_menu() {
    $options = array(
          'theme_location' => 'mobile-menu',
          'echo' => false,
          'container' => false,
          'menu_id' => 'mobile-menu-nav',
          'fallback_cb'=> 'default_page_menu'
      ); 

      $menu = wp_nav_menu($options);

      echo $menu;
  } 
  // OFF CANVAS MENU 2
  function fyre_mobile_menu_btm() {
    $options = array(
          'theme_location' => 'mobile-menu-btm',
          'echo' => false,
          'container' => false,
          'menu_id' => 'mobile-menu-nav-btm',
          'fallback_cb'=> 'default_page_menu'
      ); 

      $menu = wp_nav_menu($options);

      echo $menu;
  } 
  // FOOT MENU
  function fyre_foot_menu() {
    $options = array(
          'theme_location' => 'foot-menu',
          'echo' => false,
          'container' => false,
          'menu_id' => 'foot-menu-nav',
          'fallback_cb'=> 'default_page_menu'
      ); 

      $menu = wp_nav_menu($options);

      echo $menu;
  } 
  // FOOT MENU BTM
  function fyre_foot_menu_btm() {
    $options = array(
          'theme_location' => 'foot-menu-btm',
          'echo' => false,
          'container' => false,
          'menu_id' => 'foot-menu-nav-btm',
          'fallback_cb'=> 'default_page_menu'
      ); 

      $menu = wp_nav_menu($options);

      echo $menu;
  } 

// GRAVITY FORMS FUNCTIONS

  // TAB INDEX
  add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
  function gform_tabindexer( $tab_index, $form = false ) {
      $starting_index = 1000; // if you need a higher tabindex, update this number
      if( $form )
          add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
      return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
  }

//POSTS

  // POST CUSTOM EXCERPT

  function custom_excerpt_length( $length ) {
    if ( is_front_page() ) :
        return 25;
    else :
        return 30;
    endif;
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

  function new_excerpt_more( $more ) {
    return '..';
  }
  add_filter('excerpt_more', 'new_excerpt_more');

// HIDE MENU ITEMS

  //HIDE ACF
  function remove_acf_menu() {
      remove_menu_page('edit.php?post_type=acf-field-group');
    }
  add_action( 'admin_menu', 'remove_acf_menu', 999);

// ADMIN DASH ITEMS
  function remove_menus(){
    remove_menu_page( 'edit-comments.php' );     //Comments
  }
  add_action( 'admin_menu', 'remove_menus' );



