<?php /* Template Name: Training */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

$current_questions = 'training';

// questions Query Args
$questionArgs = array (
  'post_type' => 'questions',
  'posts_per_page' => '-1',
  'tax_query' => array( 
    array(
        'taxonomy' => 'question_location',
        'field'    => 'slug',
        'terms'    => $current_questions,
    ),
  ) 
);
// The Query
$questionQuery = new WP_Query( $questionArgs );

get_header();?>

<section id="page-header" class="alt-header middle-content red-bg wht-txt">
 	<div class="container">
      	<div class="row">
			<div class="col-12">
				<div class="header-content">
					<h1 class="wht-txt">Volleyball Training</h1>
				</div>
			</div>
			<h2 class="viva large-training-txt"><?php echo get_the_title(); ?></h2>
	    </div>
	    <img class="vb-player hidden-sm-down" src="/wp-content/uploads/2020/06/training-hero-player-1-min.png">
    </div>  
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-Blue.svg" class="page-top-curve desk-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-Blue-1024.svg" class="page-top-curve mid-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-Blue-375.svg" class="page-top-curve mobile-curve"></object>
</section>


<section id="training-options" class="lt-blu-bg wht-txt">	    
	<div class="container">
			<div class="row hidden-md-up">
	    		<div class="col-12">
					<img class="vb-player" src="/wp-content/uploads/2020/06/training-hero-player-1-min.png">	    			
	    		</div>
	    	</div>
	    	<div class="row">
	      		<div class="col-xl-5 offset-xl-1 col-lg-6 offset-lg-1 col-md-8 middle-content">
	      			<img src="/wp-content/themes/fyrestarter-child/assets/icons/Training.svg">
	        		<h2>Training Options</h2>
	        		<div><?= get_field('training_options_content') ?></div>
	      		</div>
	    	</div>
	    </div>
	</div>
</section>

<section>
	<div class="container">   
	  <?php if( have_rows('training_info') ): ?>
	  <?php $counter = 0; ?>
	    <?php while( have_rows('training_info') ): the_row();
	      //vars
	      $image = get_sub_field('image');
	    ?> 
	    <?php $counter++; ?>

	      <?php
	      ///left image
	      if ($counter % 2 != 0) { ?>
			    
			<div class="row info-row">
				<div class="col-lg-8 col-xl-12">
					<div class="row row-eq-height">
						<div class="col-xl-6 middle-content">
						  <div class="flex-img">
						  	<img class="fyrelazy" data-src="<?php echo $image['url']; ?>" src="/wp-content/plugins/fyrelazyload/assets/img/Gradient-Shimmer-loding.gif" title="<?php echo $image['title']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
						  </div>
						</div>
						<div class="col-xl-6 middle-content">
						  <h2 class="blu-txt"><?= get_sub_field('header') ?></h2>
						  <h3 class="red-txt"><?= get_sub_field('subheader') ?></h3>
						  <?= get_sub_field('content') ?>
						  <?php if (get_sub_field('link')) { ?>
						  	<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('link') ?>" title="<?= get_sub_field('header') ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Learn More<?php }?></a></div>
						  <?php } ?>
						</div>
					</div>
				</div>
			</div>

	      <?php }
	      //odd counter will have left image
	      else { ?>

			<div class="row info-row">
				<div class="col-lg-8 push-lg-4 col-xl-12 push-xl-0">
				    <div class="row row-eq-height">
				        <div class="col-xl-6 push-xl-6 middle-content">
				          <div class="flex-img">
				          	<img class="fyrelazy" data-src="<?php echo $image['url']; ?>" src="/wp-content/plugins/fyrelazyload/assets/img/Gradient-Shimmer-loding.gif" title="<?php echo $image['title']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
				          </div>
				        </div> 
				        <div class="col-xl-6 pull-xl-6 middle-content">
						  <h2 class="blu-txt"><?= get_sub_field('header') ?></h2>
						  <h3 class="red-txt"><?= get_sub_field('subheader') ?></h3>
						  <?= get_sub_field('content') ?>
						  <?php if (get_sub_field('link')) { ?>
						  	<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('link') ?>" title="<?= get_sub_field('header') ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Learn More<?php }?></a></div>
						  <?php } ?>
				        </div>
				    </div>	
				</div>
			</div>

	      <?php } ?>

	    <?php endwhile; ?>
	  <?php endif; ?>
	</div>
</section>

<section id="we-are-one-banner" class="fyrelazy cover-bg" data-background-image="<?= get_field('banner_image') ?>">
	<div class="container wide-container">
		<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/icons/we-are-one-wht.svg" class="we-are-one hidden-sm-down"></object>
		<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/icons/we-are-one-wht-vert.svg" class="we-are-one hidden-md-up"></object>
	</div>
</section>

<section>
	<div class="container">   
	  <?php if( have_rows('training_info_btm') ): ?>
	  <?php $counter = 0; ?>
	    <?php while( have_rows('training_info_btm') ): the_row();
	      //vars
	      $image = get_sub_field('image');
	    ?> 
	    <?php $counter++; ?>

	      <?php
	      ///left image
	      if ($counter % 2 != 0) { ?>
			    
			<div class="row info-row">
				<div class="col-lg-8 col-xl-12">
					<div class="row row-eq-height">
						<div class="col-xl-6 middle-content">
						  <div class="flex-img">
						  	<img class="fyrelazy" data-src="<?php echo $image['url']; ?>" src="/wp-content/plugins/fyrelazyload/assets/img/Gradient-Shimmer-loding.gif" title="<?php echo $image['title']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
						  </div>
						</div>
						<div class="col-xl-6 middle-content">
						  <h2 class="blu-txt"><?= get_sub_field('header') ?></h2>
						  <h3 class="red-txt"><?= get_sub_field('subheader') ?></h3>
						  <?= get_sub_field('content') ?>
						  <?php if (get_sub_field('link')) { ?>
						  	<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('link') ?>" title="<?= get_sub_field('header') ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Learn More<?php }?></a></div>
						  <?php } ?>
						</div>
					</div>
				</div>
			</div>

	      <?php }
	      //odd counter will have left image
	      else { ?>

			<div class="row info-row">
				<div class="col-lg-8 push-lg-4 col-xl-12 push-xl-0">
				    <div class="row row-eq-height">
				        <div class="col-xl-6 push-xl-6 middle-content">
				          <div class="flex-img">
				          	<img class="fyrelazy" data-src="<?php echo $image['url']; ?>" src="/wp-content/plugins/fyrelazyload/assets/img/Gradient-Shimmer-loding.gif" title="<?php echo $image['title']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
				          </div>
				        </div> 
				        <div class="col-xl-6 pull-xl-6 middle-content">
						  <h2 class="blu-txt"><?= get_sub_field('header') ?></h2>
						  <h3 class="red-txt"><?= get_sub_field('subheader') ?></h3>
						  <?= get_sub_field('content') ?>
						  <?php if (get_sub_field('link')) { ?>
						  	<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('link') ?>" title="<?= get_sub_field('header') ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Learn More<?php }?></a></div>
						  <?php } ?>
				        </div>
				    </div>	
				</div>
			</div>

	      <?php } ?>

	    <?php endwhile; ?>
	  <?php endif; ?>
	</div>
</section>

<?php get_template_part( 'assets/partials/our-facility' ); ?>

<section id="calendar" class="hidden-sm-down">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="events-box">
					<div class="row">
						<div class="col-12 text-center">
							<h2 class="navy-blu">Upcoming Events</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<?php echo do_shortcode('[tribe_events view="month" category="training"]'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php 
$current_questions = 'training';
$questions_bg_color = 'red-bg';
include( locate_template( 'assets/partials/questions.php', false, false ) );
?>

<?php get_template_part( 'assets/partials/split-section' ); ?>

<?php get_footer(); ?>