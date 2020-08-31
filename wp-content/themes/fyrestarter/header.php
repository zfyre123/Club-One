<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<?php echo get_option('track_code'); ?> 

	<?php wp_head(); ?> 
	<style>
		<?php echo get_option('the_css'); ?>
	</style>
</head>
<body id="fyre" <?php body_class(); ?> itemscope itemtype="<?php echo get_option('schema_url'); ?>">
	<header id="header">
	<?php if (!empty(get_option('top_header'))) { ?>
		<!-- CONTACT LINKS -->
		<div id="top_header" class="container-fluid"> 
			<span id="site-desc" class="float-left"><?php echo get_bloginfo('description'); ?></span>
			
			<ul id="top-contact" class="list-inline float-right">
				<?php 
				if (!empty(get_option('the_street'))) { ?>
					<li> 
						<a title="Address" href="<?php echo get_option('local_link'); ?>" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" target="_blank">							<span itemprop="streetAddress"><?php echo get_option('the_street'); ?></span> 
							<span itemprop="addressLocality"><?php echo get_option('the_city'); ?></span> 
							<span itemprop="addressRegion"><?php echo get_option('the_state'); ?></span> 
							<span itemprop="postalCode"><?php echo get_option('the_zip'); ?></span>
						</a>
					</li>
				<?php }
				if (!empty(get_option('phone_number'))) { ?>
					<li>
						<a title="Phone Number" href="tel:<?php echo get_option('the_phone'); ?>" target="_blank">
							<span itemprop="telephone"><?php echo get_option('the_phone'); ?></span>
						</a>
					</li>
				<?php }   
				if (!empty(get_option('the_fax'))) { ?>
					<li class="hidden-md-down">
						<a title="Fax Number" href="#">
							<span itemprop="faxNumber"><?php echo get_option('the_fax'); ?></span>
						</a>
					</li>
				<?php }  
				if (!empty(get_option('email_address'))) { ?>
					<li>
						<a title="Email Address" href="mailto:<?php echo get_option('email_address'); ?>" target="_blank">
							<span itemprop="email"><?php echo get_option('email_address'); ?></span>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<!-- NAV LINKS -->
		<nav id="mainnav" class="container nav navbar">
			<div id="nav-wrap" > 
				<div class="navbar-header col-12"> 
					<button class="navbar-toggler float-left nav-link" type="button" data-toggle="offcanvas">
						<i class="animate fa fa-bars"></i>
					</button>
					<a class="navbar-brand mx-auto" href="<?php echo home_url(); ?>" title="<?php bloginfo('name') ?>" rel="home" itemprop="url"> 
						<?php echo '<img itemprop="logo" src="'.get_option('logo_url').'" />';?>
					</a>
					<?php global $woocommerce; ?>
					<a class="float-right nav-link" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('Cart View', 'woothemes'); ?>">
						<i class="fa fa-shopping-basket"></i>
						<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'),
						 $woocommerce->cart->cart_contents_count);?>  -
						<?php echo $woocommerce->cart->get_cart_total(); ?>
					</a>
				</div>
			</div>
		</nav>
	</header>
	<!-- OFF CANVAS NAV --> 
	<nav id="sidebar-offcanvas">
		<?php dynamic_sidebar( 'off_canvas_nav' ); ?> 
	</nav>