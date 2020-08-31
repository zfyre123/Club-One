</main>

<!-- FOOTER -->
<footer>
	<section id="footer-main" class="blu-bg wht-txt">
		<div class="container">
			<div class="row">
				<div class="footer-left widget">
					<div class="widget-inner">
						<img class="footer-logo" src="/wp-content/themes/fyrestarter-child/assets/icons/footer-logo.svg">
					</div>
				</div>
				<div class="footer-right d-flex">
					<div class="footer-right-left widget">
						<div class="widget-inner">
							<div class="footer-menus middle-content">
								<?php fyre_foot_menu() ?>
								<?php fyre_foot_menu_btm() ?>
							</div>
						</div>
					</div>
					<div class="footer-right-right widget">
						<div class="widget-inner">
							<div class="d-flex">
								<?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true" tabindex="49"]'); ?>
								<div class="middle-content">
									<ul class="footer-socials d-flex">
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
	</section>
	<section id="footer-copy" class="text-right">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<span>&copy; <?php echo date("Y"); ?> <?php echo get_bloginfo( 'name' ); ?></span><span> <span class="copy-space">|</span> Site by <a href="https://monomythstudio.com/" target="_blank">Monomyth Studio</a> - <a href="/sitemap_index.xml" target="_blank">Site Map</a></span>
				</div>	
			</div>
		</div>
	</section>
</footer>

<?php wp_footer(); ?>