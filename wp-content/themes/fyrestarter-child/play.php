<?php /* Template Name: Play */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

$the_way_we_train_image = get_field('the_way_we_train_image');

get_header();?>

<section id="page-header" class="alt-header middle-content red-bg wht-txt">
 	 <div class="container">
      	<div class="row">
			<div class="col-12">
				<div class="header-content">
					<h1 class="wht-txt">Let's Play</h1>
					<p class="wht-txt"><?= get_field('lets_play_subheader') ?></p>
				</div>
			</div>
			<h2 class="viva large-training-txt">Let's Play</h2>
	    </div>
	    <img class="vb-player hidden-sm-down" src="/wp-content/uploads/2020/06/Lets-Play-Header-Image.png">
    </div>  
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White.svg" class="page-top-curve desk-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-1024.svg" class="page-top-curve mid-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-375.svg" class="page-top-curve mobile-curve"></object>
</section>

<section id="below-page-header">
	<div class="middle-content">
	    <div class="container">
	    	<div class="row hidden-md-up">
	    		<div class="col-12">
					<img class="vb-player" src="/wp-content/uploads/2020/06/Lets-Play-Header-Image.png">	    			
	    		</div>
	    	</div>
	    	<div class="row">
	      		<div class="col-xl-5 offset-xl-1 col-lg-7 offset-lg-1">
	        		<h2>Our Volleyball Clubs</h2>
	        		<p><?= get_field('volleyball_clubs_content') ?></p>
	      		</div>
	    	</div>
	    </div>
	</div>	
</section>

<section id="clubs">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="club-box rounded-shadow cover-bg fyrelazy" data-background-image="<?= get_field('in_door_club_image'); ?>">
				<div class="mobile-bg-club cover-bg fyrelazy hidden-lg-up" data-background-image="<?= get_field('in_door_club_image'); ?>"></div>
			      <div class="club-info text-center">
			        <div class="content-inner">
			          <div class="club-icon">
			          	<img src="/wp-content/themes/fyrestarter-child/assets/icons/Indoor-Volleyball.svg">
			          </div>
			          <h3>Indoor Club</h3>
			          <div class="hidden-content">
			            <p><?= get_field('in-door_club_content') ?></p>
			            <a href="<?= get_field('in-door_club_link') ?>" class="btn ylw-btn"><?= get_field('in-door_club_button_text') ?></a>
			          </div>
			        </div>
			      </div>
			    </div>		
			</div>
			<div class="col-lg-6">
				<div class="club-box rounded-shadow cover-bg fyrelazy" data-background-image="<?= get_field('beach_club_image'); ?>">
				<div class="mobile-bg-club cover-bg fyrelazy hidden-lg-up" data-background-image="<?= get_field('beach_club_image'); ?>"></div>
			      <div class="club-info text-center">
			        <div class="content-inner">
			          <div class="club-icon">
			          	<img src="/wp-content/themes/fyrestarter-child/assets/icons/Icon-Sun-Yellow.svg">
			          </div>
			          <h3>Beach Club</h3>
			          <div class="hidden-content">
			            <p><?= get_field('beach_club_content') ?></p>
			            <a href="<?= get_field('beach_club_link') ?>" class="btn ylw-btn"><?= get_field('beach_club_button_text') ?></a>
			          </div>
			        </div>
			      </div>
			    </div>		
			</div>
		</div>
	</div>
</section>

<section id="experience" class="cover-bg wht-txt" style="background-image:url(<?= get_field('experience_image'); ?>);">
<div class="overlay"></div>
	<div class="container wide-container">
		<div class="row">
			<div class="col-xl-12 col-lg-9 mx-auto">

				<div class="row sec-header">
					<div class="col-12">
						<h2>Club One for Everyone</h2>
					</div>
				</div>
				<div class="row row-eq-height">
					<div class="col-xl-6 middle-content">
					  <?php if( have_rows('experience_levels') ): ?>
					  <?php $counter = 0; ?>
					    <?php while( have_rows('experience_levels') ): the_row(); ?> 
					    <?php $counter++; ?>
							<div class="row experience-row row-eq-height">
								<div class="col-12 middle-content">
								  <h3 class="ylw-txt"><?= get_sub_field('title') ?></h3>
								  <h4><?= get_sub_field('ages') ?></h4>
								  <?= get_sub_field('description') ?>
								</div>
							</div>
					    <?php endwhile; ?>
					  <?php endif; ?>				
					</div>
					<div class="col-xl-6 middle-content">
						<div class="rounded-shadow red-bg what-level text-center middle-content">
							<h2>Which level is right for my athlete?</h2>
							<p class="wht-txt"><?= get_field('which_level_content') ?></p>
							<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_field('which_level_link') ?>" title="Contact Us"><?= get_field('which_level_button_text') ?></a></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<section id="why-we-train" class="pb-0 hidden-md-down">
	<div class="container">
		<div class="row">
			<div class="col-lg-11 col-md-12 no-padd">
				<div class="ylw-bg why-we-train-box">
					<div class="row">
						<div class="col-xl-7 push-xl-6 col-md-12 middle-content">
						  	<div class="way-we-train-img cover-bg rounded-shadow fyrelazy" data-background-image="<?php echo $the_way_we_train_image['url']; ?>"></div>			
						</div>
						<div class="col-xl-5 pull-xl-7 col-md-12 middle-content">
							<h2 class="blu-txt">The Way We Train</h2>
							<?= get_field('the_way_we_train_content') ?>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<img src="/wp-content/themes/fyrestarter-child/assets/icons/Indoor-Volleyball-ylw.svg">
</section>

<section id="why-we-train-mobile" class="hidden-lg-up ylw-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="">
					<div class="row">
						<div class="col-md-12 middle-content">
							<h2 class="blu-txt">The Way We Train</h2>
							<?= get_field('the_way_we_train_content') ?>		
						</div>
						<div class="col-md-12 middle-content">
							<img class="fyrelazy" data-src="<?php echo $the_way_we_train_image['url']; ?>" src="/wp-content/plugins/fyrelazyload/assets/img/Gradient-Shimmer-loding.gif" title="<?php echo $the_way_we_train_image['title']; ?>" width="<?php echo $the_way_we_train_image['width']; ?>" height="<?php echo $the_way_we_train_image['height']; ?>" />		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'assets/partials/join-a-program' ); ?>

<?php 
$current_questions = 'play';
$questions_bg_color = 'red-bg';
include( locate_template( 'assets/partials/questions.php', false, false ) );
?>

<?php get_footer(); ?>