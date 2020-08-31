<?php	

	function fyre_widgets_init() {

		register_sidebar( array(
			'name'          => 'Sidebar',
			'id'            => 'sidebar-1',
			'description'   => 'This is the widgetized area for the default sidebar',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		) );
		/* Widget for Offcanvas Navigation */
		register_sidebar( array(
			'name'          => 'Off Canvas Nav',
			'id'            => 'off_canvas_nav',
			'description'   => 'This is the widgetized area for the off canvas navigation',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		) );
		/* Footer Col 1 */
		register_sidebar(array(
			'name' => 'Footer 1',
			'id'   => 'foot1',
			'description'   => 'This is the first widgetized area for the footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
		/* Footer Col 2 */
		register_sidebar(array(
			'name' => 'Footer 2',
			'id'   => 'foot2',
			'description'   => 'This is the second widgetized area for the footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
		/* Footer Col 3 */
		register_sidebar(array(
			'name' => 'Footer 3',
			'id'   => 'foot3',
			'description'   => 'This is the third widgetized area for the footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
		/* Footer Col 4 */
		register_sidebar(array(
			'name' => 'Footer 4',
			'id'   => 'foot4',
			'description'   => 'This is the fourth widgetized area for the footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s" >',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));

	}
	add_action( 'widgets_init', 'fyre_widgets_init' ); 

?>