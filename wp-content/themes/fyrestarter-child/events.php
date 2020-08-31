<?php /* Template Name: Events */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

get_header();?>

<section id="page-header" class="bg-header middle-content text-center cover-bg fyrelazy wht-txt" <?php printf( ' data-background-image="%s"', $image_src[0] ); ?>>
  <div class="overlay"></div>
  <div class="container">
      <div class="row">
        <div class="col-12">
          <h1><?php echo get_the_title(); ?></h1>
        </div>
      </div>
    </div>  
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White.svg" class="page-top-curve desk-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-1024.svg" class="page-top-curve mid-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-375.svg" class="page-top-curve mobile-curve"></object>
</section>

<div id="players-bg">
<img class="events-player1" src="/wp-content/uploads/2020/06/Player4-Edit.jpg">
<img class="events-player2" src="/wp-content/uploads/2020/06/Player3-Edit.jpg">

	<section class="text-center">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-9 mx-auto">
					<h2>Club One and One Beach Volleyball Events</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-7 col-md-10 mx-auto">
					<?= get_field('club_one_events_content'); ?>
				</div>
			</div>
		</div>
	</section>

	<section id="events">
		<div class="container">   
			<div class="row">
				<div class="col-lg-9 mx-auto">

					<div class="row events-row">
						<div class="col-12">
							<div class="events-row-header d-flex">
								<img src="/wp-content/themes/fyrestarter-child/assets/icons/Icon-Vollyball-Blue.svg">
								<div class="middle-content">
									<h2>Indoor Club Events</h2>
								</div>
							</div>
						</div>
						<div class="col-12">	
							<?php
							// Ensure the global $post variable is in scope
							global $post;
							 
							// Retrieve
							$events = tribe_get_events( [ 'posts_per_page' => 12, 'tribe_events_cat' => 'club', 'start_date' => date( 'Y-m-d H:i:s', strtotime( 'now' ) ) ] );
							 
							// Loop
							if(empty($events)) { ?>
								<p>No upcoming club volleyball events.</p>
							<?php } else { foreach ( $events as $post ) {
							   setup_postdata( $post ); ?>
						    	<div class="event d-flex">
						    		<a href="<?php echo get_permalink(); ?>"></a>
								    <div class="event-date middle-content red-bg">
								   		<strong><?php echo tribe_get_start_date( $post, false, 'M' ); ?></strong>
								   		<span><?php echo tribe_get_start_date( $post, false, 'j' ); ?></span>
								   	</div>
								   	<div class="event-info middle-content">
								   		<span class="event-time"><?php echo tribe_get_start_date( $post, false, 'g:i a' ); ?> - <?php echo tribe_get_end_date( $post, false, 'g:i a' ); ?></span><br>
								   		<?php echo the_title(); ?>
								   	</div>
							   </div>
							<?php } } ?>
						</div>	
					</div>

					<div class="row events-row">
						<div class="col-12">
							<div class="events-row-header d-flex">
								<img src="/wp-content/themes/fyrestarter-child/assets/icons/Icon-Sun-Yellow.svg">
								<div class="middle-content">
									<h2>Beach Club Events</h2>
								</div>
							</div>
						</div>
						<div class="col-12">	
							<?php
							// Ensure the global $post variable is in scope
							global $post;
							 
							// Retrieve
							$events = tribe_get_events( [ 'posts_per_page' => 12, 'tribe_events_cat' => 'beach', 'start_date' => date( 'Y-m-d H:i:s', strtotime( 'now' ) ) ] );
							 
							// Loop
							if(empty($events)) { ?>
								<p>No upcoming beach volleyball events.</p>
							<?php } else { foreach ( $events as $post ) {
							   setup_postdata( $post ); ?>
						    	<div class="event d-flex">
						    		<a href="<?php echo get_permalink(); ?>"></a>
								    <div class="event-date middle-content beach-blu-bg">
								   		<strong><?php echo tribe_get_start_date( $post, false, 'M' ); ?></strong>
								   		<span><?php echo tribe_get_start_date( $post, false, 'j' ); ?></span>
								   	</div>
								   	<div class="event-info middle-content">
								   		<span class="event-time"><?php echo tribe_get_start_date( $post, false, 'g:i a' ); ?> - <?php echo tribe_get_end_date( $post, false, 'g:i a' ); ?></span><br>
								   		<?php echo the_title(); ?>
								   	</div>
							   </div>
							<?php } } ?>
						</div>	
					</div>

					<div class="row events-row">
						<div class="col-12">
							<div class="events-row-header d-flex">
								<img src="/wp-content/themes/fyrestarter-child/assets/icons/Icon-Stopwatch-Blue.svg">
								<div class="middle-content">
									<h2>Training Events</h2>
								</div>
							</div>
						</div>
						<div class="col-12">	
							<?php
							// Ensure the global $post variable is in scope
							global $post;
							 
							// Retrieve
							$events = tribe_get_events( [ 'posts_per_page' => 12, 'tribe_events_cat' => 'training', 'start_date' => date( 'Y-m-d H:i:s', strtotime( 'now' ) ) ] );
							 
							// Loop
							if(empty($events)) { ?>
								<p>No upcoming training events.</p>
							<?php } else { foreach ( $events as $post ) {
							   setup_postdata( $post ); ?>
						    	<div class="event d-flex">
						    		<a href="<?php echo get_permalink(); ?>"></a>
								    <div class="event-date middle-content red-bg">
								   		<strong><?php echo tribe_get_start_date( $post, false, 'M' ); ?></strong>
								   		<span><?php echo tribe_get_start_date( $post, false, 'j' ); ?></span>
								   	</div>
								   	<div class="event-info middle-content">
								   		<span class="event-time"><?php echo tribe_get_start_date( $post, false, 'g:i a' ); ?> - <?php echo tribe_get_end_date( $post, false, 'g:i a' ); ?></span><br>
								   		<?php echo the_title(); ?>
								   	</div>
							   </div>
							<?php } } ?>
						</div>	
					</div>

					<div class="row events-row">
						<div class="col-12">
							<div class="events-row-header d-flex">
								<img src="/wp-content/themes/fyrestarter-child/assets/icons/Icon-Volleyball-Black.svg">
								<div class="middle-content">
									<h2>Recreation Events</h2>
								</div>
							</div>
						</div>
						<div class="col-12">
							<?php
								// Ensure the global $post variable is in scope
								global $post;
								 
								// Retrieve
								$events = tribe_get_events( [ 'posts_per_page' => 12, 'tribe_events_cat' => 'recreation', 'start_date' => date( 'Y-m-d H:i:s', strtotime( 'now' ) ) ] );
								 
								// Loop
								if(empty($events)) { ?>
									<p>No upcoming recreation events.</p>
								<?php } else { foreach ( $events as $post ) {
									setup_postdata( $post ); ?>
							    	<div class="event d-flex">
							    		<a href="<?php echo get_permalink(); ?>"></a>
									    <div class="event-date middle-content ylw-bg">
									   		<strong><?php echo tribe_get_start_date( $post, false, 'M' ); ?></strong>
									   		<span><?php echo tribe_get_start_date( $post, false, 'j' ); ?></span>
									   	</div>
									   	<div class="event-info middle-content">
									   		<span class="event-time"><?php echo tribe_get_start_date( $post, false, 'g:i a' ); ?> - <?php echo tribe_get_end_date( $post, false, 'g:i a' ); ?></span><br>
									   		<?php echo the_title(); ?>
									   	</div>
								   </div>
							<?php } } ?>
						</div>
					</div>					

				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'assets/partials/our-facility' ); ?>

</div>

<section id="calendar" class="ylw-bg">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="row sec-header">
					<div class="col-12 text-center">
						<h2 class="navy-blu">Upcoming Club One Events</h2>
					</div>
				</div>
				<div class="events-box">
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

<?php get_template_part( 'assets/partials/join-a-program' ); ?>

<?php get_footer(); ?>