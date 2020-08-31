<?php /* Template Name: Partnership */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

// testimonials Query Args
$testimonialArgs = array (
  'post_type' => 'testimonials',
  'posts_per_page' => '-1',
);
// The Query
$testimonialQuery = new WP_Query( $testimonialArgs );

// partnerss Query Args
$partnersArgs = array (
  'post_type' => 'partners',
  'posts_per_page' => '-1',
);
// The Query
$partnersQuery = new WP_Query( $partnersArgs );

get_header();?>

<section id="page-header" class="bg-header middle-content text-center cover-bg fyrelazy wht-txt" <?php printf( ' data-background-image="%s"', $image_src[0] ); ?>>
  <div class="overlay"></div>
  <div class="container">
      <div class="row">
        <div class="col-12">
          <h1><?php echo get_the_title(); ?></h1>
          <a class="btn ylw-btn" href="<?= get_field('donate_link'); ?>"><?= get_field('donate_button_text'); ?></a>
        </div>
      </div>
    </div>  
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White.svg" class="page-top-curve desk-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-1024.svg" class="page-top-curve mid-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-375.svg" class="page-top-curve mobile-curve"></object>
</section>

<section class="text-center">
	<div class="container">
		<div class="row sec-header">
			<div class="col-xl-6 col-lg-7 col-md-9 mx-auto">
				<h2>We need your support now more than ever</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-8 col-lg-9 col-md-11 mx-auto">
				<?= get_field('need_your_support_content'); ?>
			</div>
		</div>
	</div>
</section>

<section id="founders">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="cover-bg founders-img fyrelazy rounded-shadow" data-background-image="<?= get_field('founder_image'); ?>"></div>
				<div class="rounded-shadow founders-note red-bg wht-txt">
					<h3 class="text-center">A Note From The Founders</h3>
					<?= get_field('note_from_founder'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">   
	  <?php if( have_rows('donations_info') ): ?>
	  <?php $counter = 0; ?>
	    <?php while( have_rows('donations_info') ): the_row();
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
						  <?php if (get_sub_field('button_link')) { ?>
						  	<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('button_link') ?>" title="<?= get_sub_field('header') ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Donate Now<?php } ?></a></div>
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
						  <?php if (get_sub_field('button_link')) { ?>
						  	<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('button_link') ?>" title="<?= get_sub_field('header') ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Donate Now<?php } ?></a></div>
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

<section id="testimonials" class="ylw-bg text-center">
	<div class="container">
		<div class="row sec-header">
			<div class="col-12">
				<h2 class="red-txt">Others Say It Best</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="testimonial-slider">
					<?php if($testimonialQuery->have_posts()): ?>
			         <?php $counter = 0; ?>
			            <?php while($testimonialQuery->have_posts()) : $testimonialQuery->the_post(); ?> 
			            <?php $counter++; ?>
			            	<div class="item testimonial-slide">
			            		<div class="middle-content">
			            			<h4><?= get_the_content(); ?></h4>
			            			<h4><?php the_title(); ?></h4>
			            		</div>
			            	</div>
			        	<?php endwhile; ?>
	          		<?php endif; wp_reset_query(); ?>
	          	</div>				
			</div>
		</div>
	</div>
</section>

<section id="partners" class="text-center">
	<div class="container">
	    <div class="row sec-header">
			<div class="col-12">
				<h2>Thank you to our partners</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="partners-all">
					<?php if($partnersQuery->have_posts()): ?>
			         <?php $counter = 0; ?>
			            <?php while($partnersQuery->have_posts()) : $partnersQuery->the_post(); 
			            	//vars
			            	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'medium' )[0]; 
			            ?> 
			            <?php $counter++; ?>
			            	<div class="single-partner middle-content">
			            		<div class="flex-img"><img class="fyrelazy" title="partner-<?php the_title(); ?>" data-src="<?php echo $image; ?>"></div>
			            	</div>
			        	<?php endwhile; ?>
		          	<?php endif; wp_reset_query(); ?>
		        </div>
			</div>
		</div>
	</div>
</section>

<section id="split-section" class="pt-0 pb-0 text-center">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 middle-content ylw-bg split-section-col">
				<div class="split-section-content">
					<h3>Have Questions</h3>
					<p><?= get_field('have_questions_description'); ?></p>
					<div class="flex-btn"><a class="btn red-btn" href="<?= get_field('have_questions_link'); ?>" title="Reach Out"><?= get_field('have_questions_button_text'); ?></a></div>
				</div>
			</div>
			<div class="col-lg-6 middle-content lt-blu-bg wht-txt split-section-col">
				<div class="split-section-content">
					<h3>Learn About<br> Competitive Programs</h3>
					<p><?= get_field('make_a_donation_description'); ?></p>
					<div class="flex-btn"><a class="btn ylw-btn" href="<?= get_field('make_a_donation_link'); ?>" title="Make A Donation to Club One"><?= get_field('make_a_donation_button_text'); ?></a></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>