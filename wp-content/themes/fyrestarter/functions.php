<?php // FYRESTARTER 5-22-2017

// URI CONSTANTS
	define( 'FYRE_DIR', get_template_directory_uri() );
	define( 'FYRECHILD_DIR', get_stylesheet_directory_uri() );
	define( 'FYRE_ASSETS', FYRE_DIR . '/assets' );
	define( 'FYRE_CSS', FYRE_ASSETS . '/css' );
	define( 'FYRE_JS', FYRE_ASSETS . '/js' );
	define( 'FYRE_FONTS', FYRE_ASSETS . '/fonts' );
	define( 'FYRECHILD_JS', FYRECHILD_DIR . '/js' );

// PATH CONSTANTS
	define( 'FYRE_PATH' , get_template_directory() );
	define( 'FYRE_INC' , FYRE_PATH . '/inc' );

// ADD THEME SUPPORT

	// Enable support for menus
	add_theme_support( 'menus' );
	// Enable support for excerpts on posts and pages
	add_post_type_support( 'page', 'excerpt' );
	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );
	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' ); 
	// Enable support for custom fields on posts and pages
	add_theme_support( 'custom-fields' );
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	//Switch default core markup for search form, comment form, and comments to HTML5
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

//  CONTENT WIDTH
	
	if ( ! isset( $content_width ) ) $content_width = 1170;

// WOOCOMMERCE
	add_action( 'after_setup_theme', 'woocommerce_support' );
	function woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}

// ADD FILTERS
	add_filter( 'widget_text', 'shortcode_unautop');
	add_filter( 'widget_text', 'do_shortcode');

// FAVICON
	function add_favicon() { ?>
		<link rel="shortcut icon" href="<?php echo get_option('fav_url'); ?>" > 
	<?php } 
	add_action('login_head', 'add_favicon');
	add_action('wp_head', 'add_favicon');
	add_action('admin_head', 'add_favicon');

// LOAD SCRIPTS & STYLES

	function fyre_enqueue_styles() {
		//FONTS
		//wp_enqueue_style( 'fontawesome',  FYRE_FONTS . '/font-awesome.min.css', false );
		//wp_enqueue_style( 'fontawesome',  FYRE_FONTS . '/webfonts/fontawesome-all.css', false, true );
		wp_enqueue_style( 'fontawesome',  FYRE_FONTS . '/webfonts/all.min.css', false, true );

		//STYLES 
		wp_enqueue_style( 'normalize', FYRE_CSS . '/normalize.css' );
		wp_enqueue_style( 'bs4', FYRE_CSS . '/bootstrap.min.css' );
		//wp_enqueue_style( 'multiple-select', FYRE_CSS . '/multiple-select.css' );
	    //wp_enqueue_style( 'animate', FYRE_CSS . '/animate.min.css' );
	    wp_enqueue_style( 'slick-style', FYRE_ASSETS . '/slick/slick.css', false );
		wp_enqueue_style( 'slick-theme', FYRE_ASSETS . '/slick/slick-theme.css', false );

	    /* If using a child theme, auto-load the parent theme style. 
	    if ( is_child_theme() ) { 
	        wp_enqueue_style( 'parent-style', trailingslashit( FYRE_DIR ) . 'style.css' );
	    }*/

	    /* Always load active theme's style.css. 
	    wp_enqueue_style( 'style', get_stylesheet_uri(), array('bs4','woocommerce-general') );*/
  
	    //SCRIPTS 
	    //wp_enqueue_script( 'jquery', FYRE_JS . '/jquery.slim.min.js', array(), false, false ); 
	    //wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', array(), false, false );
	    wp_enqueue_script( 'jqueryui', FYRE_JS . '/jquery-ui.min.js', array('jquery'), false, true );
	   	wp_enqueue_script( 'nav', FYRE_JS . '/jquery.nav.js', array('jquery'), false, true);
	    wp_enqueue_script( 'slick', FYRE_ASSETS . '/slick/slick.min.js', array('jquery'), false, true);
	    wp_enqueue_script( 'tether', FYRE_JS . '/tether.min.js', array('jquery'), false, true );
	    //wp_enqueue_script( 'wow', FYRE_JS . '/wow.min.js', array('jquery'), false, true ); 
	    wp_enqueue_script( 'bootstrap', FYRE_JS . '/bootstrap.min.js', array('jquery'), false, true );
	    //wp_enqueue_script( 'parallax', FYRE_JS . '/parallax.min.js', array('jquery'), false );
	    //wp_enqueue_script( 'multiple-select', FYRE_JS . '/multiple-select.js', array('jquery'),false, true );
	    //wp_enqueue_script( 'mainjs', FYRE_JS . '/main.js', array('jquery','parallax'),false, true );
	     
	}

	add_action( 'wp_enqueue_scripts', 'fyre_enqueue_styles' ); 

// DEFER SCRIPTS
	 function my_async_scripts( $tag, $handle, $src ) { 
	     // the handles of the enqueued scripts we want to async
	     $async_scripts = array( 'jquery', 'tether', 'bootstrap', 'mainjs', 'childjs'); 

	     if ( in_array( $handle, $async_scripts ) ) {
	         return '<script type="text/javascript" src="' . $src . '" async="async" defer></script>' . "\n";
	     }

	    return $tag;
	 }
	 add_filter( 'script_loader_tag', 'my_async_scripts', 10, 3 );

// BOOTSTRAP NAV WALKER
	
	include FYRE_INC . '/wp_bootstrap_navwalker.php';

// NAVIGATION
	
	/* Register Nav Menus */
	function fyre_menus() {
		register_nav_menus( array(
		    'primary' => __( 'Primary Menu', 'fyrestarter'),
		    'secondary' => __( 'Secondary Menu', 'fyrestarter'),
		    'top' => __( 'Top Menu', 'fyrestarter'),
		    'offcanvas' => __( 'Off Canvas', 'fyrestarter')
		) );
	}
	add_action( 'after_setup_theme', 'fyre_menus' );

	// TOGGLE NAV
		/* Navigation you can toggle */
		function fyre_nav_toggle() {
			$options = array(
	            'menu'              => 'Primary',
	            'depth'             => 2,
	            'container'         => 'div',
	            'container_class'   => 'col-12 collapse navbar-toggleable-md',
	    		'container_id'      => 'fyrenav',
	            'menu_class'        => 'nav navbar-nav pull-md-right',
	            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	            'walker'            => new wp_bootstrap_navwalker()
			); 

			$menu = wp_nav_menu($options);
	        echo $menu;
		}
	
	// OFF CANVAS NAV
		/* Navigation that slides in offcanvas */
		function fyre_nav_offcanvas() {
			$options = array(
	            'theme_location' => 'offcanvas',
	            'echo' => false,
		        'container' => false,
		        'menu_id' => 'offcanvasnav',
		        'fallback_cb'=> 'default_page_menu'
		    ); 

		    $menu = wp_nav_menu($options);

		    echo $menu;
		} 
	
	// NORMAL NAV
		/* Default Nav Behavior */
		function fyre_nav_normal() {
			$options = array(
	            'theme_location'    => 'primary',
	            'menu'              => 'Primary',
	            'depth'             => 3,
	            'container'         => 'div',
	            'container_class'   => 'hidden-md-down',
	    		'container_id'      => 'fyrenav',
	            'menu_class'        => 'nav pull-md-right',
	            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	            'walker'            => new wp_bootstrap_navwalker()
	        );

	        $menu = wp_nav_menu($options);
	        echo $menu;
		}
	
	// SECONDARY NAV
		/* Regular Unorderlist Menu */
		function fyre_nav_footer() {
		    $options = array(
		        'echo' => false,
		        'container' => false,
		        'container_class'   => 'hidden-md-down',
		        'theme_location' => 'secondary',
		        'fallback_cb'=> 'default_page_menu'
		    );

		    $menu = wp_nav_menu($options);

		    echo preg_replace(array(
		        '#^<ul[^>]*>#',
		        '#</ul>$#'
		    ), '', $menu);
		}

	// TOP NAV
		function fyre_nav_top() {
		    $options = array(
		        'echo' => false,
		        'container' => false,
		        'theme_location' => 'top',
		        'fallback_cb'=> 'default_page_menu'
		    );

		    $menu = wp_nav_menu($options);

		    echo preg_replace(array(
		        '#^<ul[^>]*>#',
		        '#</ul>$#'
		    ), '', $menu);
		}

// BREADCRUMBS  
	
	include FYRE_INC . '/breadcrumbs.php';

// FYRESTARTER
	
	include FYRE_INC . '/fyrestarter.php';

// SHORTCODES 
	
	include FYRE_INC . '/shortcodes.php';

// SOCIAL SHARING 
	
	// include FYRE_INC . '/social-sharing.php');

// WIDGETS

	include FYRE_INC . '/widgets.php';

// PAGINATION 
	function pagination_bar() {
	    global $wp_query;
	 
	    $total_pages = $wp_query->max_num_pages;
	 
	    if ($total_pages > 1){
	        $current_page = max(1, get_query_var('paged'));
	 
	        echo paginate_links(array(
	            'base' => get_pagenum_link(1) . '%_%',
	            'format' => 'page/%#%',
            	'current' => $current_page,
	            'total' => $total_pages, 
	        ));
	    }
	}

// REMOVE QUERY STRING FROM STATIC FILES

	add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
	add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );
 
	function sdt_remove_ver_css_js( $src, $handle ) 
	{
	    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

	    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
	        $src = remove_query_arg( 'ver', $src );

	    return $src;
	}
