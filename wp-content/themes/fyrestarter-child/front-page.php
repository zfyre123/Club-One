<?php

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

$current_questions = 'home';

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


// blog Query Args
$blogArgs = array (
  'order'=> 'DESC',
  'posts_per_page' => '1',
  'orderby' => 'post_date',
);
// The Query
$blogQuery = new WP_Query( $blogArgs );



// ACF
$questions_image = get_field('questions_image');


get_header();?>

<section id="home-top" class="ylw-bg">
	<div class="container wide-container">
		<div class="row">
			<div class="col-xl-5 col-lg-5 col-md-6 push-xl-7 push-lg-7 push-md-6">
				<div class="home-top-content">
					<h1 class="navy-blu"><?= get_field('top_header') ?></h1>
					<p><?= get_field('top_subheader') ?></p>
				</div>
			</div>
			<div class="col-xl-7 col-lg-7 col-md-6 pull-xl-5 pull-lg-5 pull-md-6">
				<img class="vb-player" src="/wp-content/uploads/2020/07/home-hero-player-clubone.png">
			</div>
		</div>
		<h2 class="viva large-training-txt">We are one</h2>	
	</div>
	<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve.svg" class="home-top-curve desk-curve"></object>
	<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-Home-1024.svg" class="home-top-curve mid-curve"></object>
	<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-Home-375.svg" class="home-top-curve mobile-curve"></object>
</section>

<section id="home-top-info-contained">
	<div id="home-top-info" class="container">
		<div class="row">
			<div class="col-12">	
				<div class="offerings">
					<div class="offerings-left">
						<h3 class="blu-txt"><?= get_field('offerings_header') ?></h3>
						<p><?= get_field('offerings_content') ?></p>
					</div>
					<div class="offerings-right d-flex justify-content-between">
						<?php if( have_rows('offerings_columns') ): ?>
				         <?php $counter = 0; ?>
				            <?php while( have_rows('offerings_columns') ): the_row(); ?> 
				            <?php $counter++; ?>
				              <div class="offerings-col text-center middle-content">
				                <div class="offerings-col-inner">
									<a href="<?= get_sub_field('link') ?>"></a>
				                  	<img src="<?= get_sub_field('image') ?>">
				                  	<div class="offerings-col-title"><h3 class="blu-txt"><?= get_sub_field('header') ?></h3></div>
				                </div>
				              </div>
				          <?php endwhile; ?>
				        <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="home-intro" class="pt-0">
	<div class="container">
		<div class="row">
			<div class="offset-xl-1 col-xl-7 offset-lg-1 col-lg-8">
				<h2 class="navy-blu"><?= get_field('into_header') ?></h2>
				<?= get_field('intro_content') ?>
				<a class="btn red-btn" href="<?= get_field('intro_button_link') ?>" title="Learn More What We Offer"><?= get_field('intro_button_text') ?></a>
			</div>
		</div>
	</div>
	<div class="container wide-container">
		<div class="row home-traits">

		    <div class="col-3 home-trait compete-trait">
		      	<div class="home-trait-inner">
		      		<div class="home-trait-img fyrelazy" data-background-image="<?= get_field('compete_image') ?>"></div>
		        	<h3 class="ylw-txt viva">Compete</h3>
		      	</div>
		    </div>

		    <div class="col-3 home-trait serve-trait">
		    	<div class="home-trait-inner">
		      		<div class="home-trait-img fyrelazy" data-background-image="<?= get_field('serve_image') ?>"></div>
		       		<h3 class="ylw-txt viva">Serve</h3>
		      	</div>
		    </div>

		    <div class="col-3 home-trait learn-trait">
		    	<div class="home-trait-inner">
		      		<div class="home-trait-img fyrelazy" data-background-image="<?= get_field('learn_image') ?>"></div>
		        	<h3 class="ylw-txt viva">Learn</h3>
		      	</div>
		    </div>

		    <div class="col-3 home-trait grow-trait">
		    	<div class="home-trait-inner">
		      		<div class="home-trait-img fyrelazy" data-background-image="<?= get_field('grow_image') ?>"></div>
		        	<h3 class="ylw-txt viva">Grow</h3>
		     	 </div>
		    </div>

		</div>
	</div>
</section>

<?php 
$coaches_bg_color = 'red-bg';
include( locate_template( 'assets/partials/meet-our-coaches.php', false, false ) );
?>

<?php get_template_part( 'assets/partials/our-facility' ); ?>

<section id="home-events">
	<div class="container">
		<div class="row">
			<div class="col-12 sec-header text-center">
				<h2 class="navy-blu">Upcoming Events</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-10 col-md-11 mx-auto">
				<div class="row row-eq-height">
				<?php
					// Ensure the global $post variable is in scope
					global $post;
					 
					// Retrieve
					$events = tribe_get_events( [ 'posts_per_page' => 6, 'start_date' => date( 'Y-m-d H:i:s', strtotime( 'now' ) ) ] );
					 
					// Loop
						if(empty($events)) { ?>
							<div class="no-events">
								<p>No upcoming Club One events.</p>
							</div>
						<?php } else { foreach ( $events as $post ) {
					   setup_postdata( $post ); ?>
					 
					    <div class="col-xl-4 col-lg-6 col-md-12">
					    	<div class="event d-flex">
					    		<a href="<?php echo get_permalink(); ?>"></a>
							    <div class="event-date middle-content">
							   		<strong><?php echo tribe_get_start_date( $post, false, 'M' ); ?></strong>
							   		<span><?php echo tribe_get_start_date( $post, false, 'j' ); ?></span>
							   	</div>
							   	<div class="event-info middle-content">
							   		<span class="event-time"><?php echo tribe_get_start_date( $post, false, 'g:i a' ); ?> - <?php echo tribe_get_end_date( $post, false, 'g:i a' ); ?></span>
							   		<strong class="blu-txt"><?php echo the_title(); ?></strong>
							   	</div>
						   </div>
					   </div>
					<?php } } ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center">
				<div class="flex-btn"><a class="line-btn" href="/volleyball-events/">View All Events</a></div>
			</div>
		</div>
	</div>
</section>

<section id="home-questions" class="red-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<div class="questions-image cover-bg fyrelazy" data-background-image="<?php echo $questions_image['url']; ?>"></div>
			</div>
			<div class="col-lg-7 middle-content">
				<h2 class="ylw-txt">Have Questions?</h2>
				<?php if($questionQuery->have_posts()): ?>
	            	<?php $counter = 0; ?>
	            	<div id="questions-accordion">
		            	<?php while($questionQuery->have_posts()) : $questionQuery->the_post(); ?> 
			            <?php $counter++; ?>
							<div class="card">
						        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $counter; ?>">
						        	<?php the_title(); ?>
						        </button>
							    <div id="collapse-<?php echo $counter; ?>" class="collapse" aria-labelledby="question-<?php echo $counter; ?>" data-parent="#questions-accordion">
							    	<div class="card-body wht-txt">
							        	<?php the_content(); ?>
							        </div>
							    </div>
							</div>
		            	<?php endwhile; ?>
	            	</div>
	      		<?php endif; wp_reset_query(); ?>
	      	</div>			
		</div>
	</div>
</section>

<section id="home-latest-story">
	<div class="container">
		<div class="row sec-header">
			<div class="col-12">
				<div class="d-flex justify-content-between">
					<h2 class="navy-blu">Latest Story</h2>
					<div class="flex-btn hidden-sm-down"><a class="line-btn" href="/blog/">View All Stories</a></div>
				</div>
			</div>
		</div>
		
	      <?php if($blogQuery->have_posts()): 
	        //vars
	        $counter = 0; 
	      ?>
	      	<div class="row row-eq-height latest-post justify-content-center">
		        <?php while($blogQuery->have_posts()) : $blogQuery->the_post(); 
		          //vars
		          $counter++;
		          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' )[0]; 
		        ?>  

		          	<div class="col-lg-6">
		          		<div class="post-image cover-bg fyrelazy" data-background-image="<?php echo $image; ?>"></div>
		          	</div>
		          	<div class="col-lg-6 middle-content">
		              	<div class="latest-post-content">
			                <p class="post-date"><?php echo get_the_date(); ?></p>                    
			                <h3 class="home-post-title"><a class="blu-txt" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
			                <div><?php the_excerpt(); ?></div>
			            </div>
		          	</div>

		        <?php endwhile; ?>
	        </div>
	      <?php endif; wp_reset_postdata(); ?>
		<div class="row hidden-md-up text-center">
			<div class="col-12">
				<div class="flex-btn"><a class="line-btn" href="/blog/">View All Stories</a></div>
			</div>
		</div>	      		
	</div>
</section>

<section id="we-are-one" class="pt-0 hidden-xs-down">
	<div class="container wide-container">
		<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/icons/we-are-one-gray.svg" class="we-are-one"></object>
	</div>
</section>

<section id="latest-grams">
	<div class="container">
		<div class="row sec-header">
			<div class="col-12">
				<div class="d-flex justify-content-between">
					<div class="d-flex view-grams">
						<h2 class="navy-blu">Latest Grams</h2>
						<div class="flex-btn hidden-sm-down"><a class="line-btn" target="_blank" href="<?php echo get_option('ig_url'); ?>" title="View Instaram Account">View Profile</a></div>
					</div>
					<h2 class="ylw-txt viva hidden-sm-down">#cluboneaz</h2>
				</div>
			</div>
		</div>
	</div>
 	<div id="instagram-feed" class="instagram_feed"></div>
 	<div class="hidden-md-up text-center">
		<h2 class="ylw-txt viva">#cluboneaz</h2>
 		<div class="flex-btn"><a class="line-btn" target="_blank" href="<?php echo get_option('ig_url'); ?>" title="View Instaram Account">View Profile</a></div>
 	</div>
	<script>
	    (function($){
	        $(window).on('load', function(){
	            $.instagramFeed({
	                'username': 'cluboneaz',
	                'container': "#instagram-feed",
                    'display_profile': false,
                    'display_biography': false,
                    'display_gallery': true,
                    'callback': null,
                    'styling': true,
                    'items': 5,
                    'items_per_row': 5,
                    'margin': 0,
                    'image_size': 480
            });
        });
    })(jQuery);
	</script>
</section>

<section id="we-are-one-mobile" class="text-center hidden-md-up">
	<div class="container">
		<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/icons/We-are-one-vertical.svg" class="we-are-one"></object>
	</div>
</section>


<?php get_footer(); ?>