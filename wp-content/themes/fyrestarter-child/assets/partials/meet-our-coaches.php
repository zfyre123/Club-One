<?php

if ( is_page( 15 ) && get_field('coaches', 15) ) {
	$meet_coaches_images = 15;
} else {
	$meet_coaches_images = 7;	
}

if ( is_page( 15 ) && get_field('meet_our_coaches_description', 15) ) {
	$meet_coaches_desc = 15;
} else {
	$meet_coaches_desc = 7;	
}

//GET COACHES WE WANT
$coachespicked = get_field('coaches', $meet_coaches_images);
$coachespicked_array = explode (",", $coachespicked);

// coaches Query Args
$coachesArgs = array (
	'post_type' => 'coaches',
	'posts_per_page' => '8',
	'post__in' => $coachespicked,
	'order' => 'DESC',
    'orderby' => 'post__in',
);
// The Query
$coachesQuery = new WP_Query( $coachesArgs );

?>

<section id="meet-coaches">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if($coachesQuery->have_posts()): ?>
	            	<?php $counter = 0; ?>
	            	
	            		<div class="meet-coaches-imgs">
			            	<?php while($coachesQuery->have_posts()) : $coachesQuery->the_post();
		            			if ( get_the_post_thumbnail() ) {
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'medium' )[0]; 
                                } else {
                                    $image = '/wp-content/uploads/2020/06/default-user.jpg';
                                }
			            	?> 
				            <?php $counter++; ?>
								<div class="coach-img cover-bg fyrelazy" data-background-image="<?php echo $image; ?>"></div>
			            	<?php endwhile; ?>
			            </div>
	          
	      		<?php endif; wp_reset_query(); ?>
			</div>			
		</div>
		<div class="row meet-coaches">
			<div class="col-xl-10 col-lg-12 mx-auto">
				<div class="wht-txt content-block middle-content text-center <?php echo esc_html( $coaches_bg_color ); ?>">
					<h2>Meet Our Coaches</h2>
					<p class="wht-txt"><?= get_field('meet_our_coaches_description', $meet_coaches_desc) ?></p>
					<div class="flex-btn">
						<a class="btn ylw-btn" href="/staff/" title="Meet Our Coaches"><?= get_field('meet_our_coaches_button_text', 7) ?></a>
					</div>							
				</div>
			</div>
		</div>
	</div>
</section>