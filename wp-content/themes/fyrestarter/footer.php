	<!-- FOOTER -->
	<footer id="footer">
		<div class="container"> 
			<div class="row nrmlsec">
				<div class="footer-widget col-12 col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'foot1' ); ?>
				</div>
				<div class="footer-widget col-12 col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'foot2' ); ?>
				</div>
				<div class="footer-widget col-12 col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'foot3' ); ?>
				</div>
				<div class="footer-widget col-12 col-sm-6 col-md-3">
					<?php dynamic_sidebar( 'foot4' ); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- FOOTER NAV -->
					<ul id="footnav" class="list-inline center unstyled">
						<li>&copy; <?php echo date("Y") ?> <?php bloginfo('name') ?>. All Rights Reserved. </li>
						<?php fyre_nav_footer(); ?>
				    </ul>
				</div>
			</div>
		</div>
	</footer>
	<?php if (!empty(get_option('responsive_helper'))) { ?>
		<div id="responsive-check">
			<span class="hidden-sm-up">XS Portrait phones under 544px 34em</span>
			<span class="hidden-xs-down hidden-md-up">SM Landscape phones intbetween 544px - 768px 34em - 48em</span>
			<span class="hidden-sm-down hidden-lg-up">MD Tablets intbetween 768px - 992px 48em - 62em</span>
			<span class="hidden-md-down hidden-xl-up">LG Desktops intbetween 992px - 1200px 62em - 75em</span>
			<span class="hidden-lg-down">XL Desktops above 1200px</span>
		</div>
	<?php } ?>
	<?php wp_footer(); ?>
</body>
</html>