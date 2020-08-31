<?php

if ( is_page( 15 ) && get_field('club_one_alumni_description', 15) ) {
	$alumni_page = 15;
} else {
	$alumni_page = 7;	
}

//ARGS
$alumniArgs = array (
  	'post_type' => 'players',
  	'posts_per_page' => '3',
	'tax_query' => array(
		array(
		    'taxonomy' => 'alumni',
		    'field' => 'slug',
		    'terms' => 'yes',
		),
	),
);
//QUERY
$alumniQuery = new WP_Query( $alumniArgs );

?>

<section id="alumni" class="text-center <?php echo esc_html( $alumni_bg_color ); ?>">
	<div class="container">
		<div class="row lrg-sec-header">
			<div class="col-xl-6 col-lg-7 col-md-9 mx-auto">
				<h2 class="<?php echo esc_html( $alumni_alt_txt_color ); ?>">Club One Alumni</h2>
				<p class="wht-txt"><?= get_field('club_one_alumni_description', $alumni_page); ?></p>
				<a class="btn ylw-btn" href="/alumni" title="View Club one Alumni"><?= get_field('club_one_alumni_button_text', 7); ?></a>
			</div>
		</div>
		<div class="row">
			<?php if($alumniQuery->have_posts()): ?>
	         <?php $counter = 0; ?>
	            <?php while($alumniQuery->have_posts()) : $alumniQuery->the_post(); 
                    if ( !empty(get_the_post_thumbnail())) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'medium' )[0]; 
                    } else {
                        $image = '/wp-content/uploads/2020/06/default-user.jpg';
                    }
	            ?> 
	            <?php $counter++; ?>
	            	<div class="col-lg-4 text-center">
	            		<div class="head-shot fyrelazy" data-background-image="<?php echo $image; ?>"></div>
	            		<div class="below-head-shot-info">
		            		<h4 class="wht-txt"><?php the_title(); ?></h4>
		            		<p class="<?php echo esc_html( $alumni_alt_txt_color ); ?>"><?= get_field('year'); ?></p>
		            		<p class="wht-txt small"><?= get_field('short_desc'); ?></p>
		            	</div>
	            	</div>
	        	<?php endwhile; ?>
      		<?php endif; wp_reset_query(); ?>
		</div>
	</div>
</section>