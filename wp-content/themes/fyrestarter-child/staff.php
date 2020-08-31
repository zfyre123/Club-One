<?php /* Template Name: Staff */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

get_header();?>

<section id="page-header" class="simple text-center middle-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?php echo get_the_title(); ?></h1>
            </div>  
        </div>
    </div>
</section>

<div class="breadcrumbs">
    <div class="container wide-container">
        <div class="row">
            <div class="col-12">
                <?php echo do_shortcode('[wpseo_breadcrumb]'); ?>               
            </div>
        </div>
    </div>
</div>

<section class="text-center">
	<div class="container">
		<div class="row section-header">
			<div class="col-lg-6 col-md-9 mx-auto">
				<h2 class="red-txt">Club One Coaches</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7 col-md-10 mx-auto">
				<?= get_field('club_one_coaches_description'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7 col-md-10 mx-auto">
				<div class="d-flex justify-content-center link-move staff-nav">	
					<a href="#in-door-staff">Indoor Volleyball Coaches</a> <span>|</span> <a href="#beach-staff">Beach Volleyball Coaches</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php

$custom_terms = $custom_terms = get_terms( array( 
    'taxonomy' 	 => 'coach_type',
    'hide_empty' => true,
) );

foreach($custom_terms as $custom_term) {
    wp_reset_query();
    $args = array(
		'post_type' => 'coaches',
		'posts_per_page' => '-1',
        'tax_query' => array(
            array(
                'taxonomy' => 'coach_type',
                'field' => 'slug',
                'terms' => $custom_term->slug,
            ),
        ),
    );			    

    $loop = new WP_Query($args); { 

    	//GET ID FOR COACHES SECTION
		$coach_type_id = strtolower($custom_term->slug);
		$background_color = get_field('background_color', $custom_term);
    ?>

	<section id="<?php echo $coach_type_id ?>-staff" class="staff-section">
		<div class="container wide-container">
			<div class="row">
				<div class="col-12">

					<div class="rounded-shadow staff-contained" style="background-color: <?php echo $background_color ?>">
				     	<div class="row">
				     		<div class="col-12 sec-header">
						        <h2 class="wht-txt"><?php echo $custom_term->name ?> Coaching Staff</h2>
						    </div>
						</div>

						<div class="row">
                        	<div class="col-xl-10 col-lg-10 col-md-9 mx-auto">                 
						        <?php if($loop->have_posts()): ?>
						        	<div class="row row-eq-height">
							        	<?php while($loop->have_posts()) : $loop->the_post(); 
											//VARS
											$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'medium' )[0]; 
							        	?>

								        	<div class="col-lg-4 col-md-6 col-sm-12 teams-coach text-center">
											    <a class="box-link" data-toggle="modal" data-target="#myModal-story" data-header="<?php echo the_title(); ?>" data-content='<?php the_content() ?>' data-img="<?php echo $image; ?>" title="<?php echo the_title(); ?>"><div class="head-shot cover-bg fyrelazy" data-background-image="<?php echo $image; ?>"></div></a>
		    									<div class="middle-content">
		    										<h4 class="ylw-txt"><?php echo the_title(); ?></h4>
		    										<?php if(get_field('position')): ?>
		    											<p><?= get_field('position'); ?></p>
		    										<?php endif; ?>
		    									</div>
											</div>  

							        	<?php endwhile; ?>
						        	</div>
						        <?php endif; ?>
						    </div>
						</div>
			        </div>

				</div>
			</div>
		</div>
	</section>

<?php }
} wp_reset_postdata(); ?>

<!-- staff modal -->
<div class="modal fade" id="myModal-story" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-shadow">
            <button id="close-story" type="button" class="button" data-dismiss="modal"><i class="fal fa-times" aria-hidden="true"></i></button>
            <div class="modal-body ylw-bg">
            	<div class="modal-top text-center">
            		<div class="story-head-shot head-shot cover-bg"></div>
                </div>
                <h4 class="red-txt"><span class="story-title"></span></h4>
                <div class="story-content"></div>
            </div>
        </div> 
    </div>
</div>

<?php get_template_part( 'assets/partials/split-section' ); ?>

<?php get_footer(); ?>