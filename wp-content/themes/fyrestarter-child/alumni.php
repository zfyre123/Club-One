<?php /* Template Name: Alumni */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

//ARGS
$alumniArgs = array (
  	'post_type' => 'players',
  	'posts_per_page' => '-1',
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

<section id="alumni" class="staff-section">
	<div class="container">
		<div class="row">
			<div class="col-12">

				<div class="rounded-shadow staff-contained red-bg">
			     	<div class="row">
			     		<div class="col-12 sec-header">
					        <h2 class="wht-txt">Club One Alumni</h2>
					    </div>
					</div>
					<div class="row">
                        <div class="col-xl-10 col-lg-10 col-md-9 mx-auto"> 
				        	<?php if($alumniQuery->have_posts()): ?>
				        		<div class="row row-eq-height">
						         <?php $counter = 0; ?>
						            <?php while($alumniQuery->have_posts()) : $alumniQuery->the_post(); 
					                    if ( !empty(get_the_post_thumbnail())) {
					                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'medium' )[0]; 
					                    } else {
					                        $image = '/wp-content/uploads/2020/06/default-user.jpg';
					                    }
						            ?> 
						            <?php $counter++; ?>
						            	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 teams-alumni text-center">
						            		<div class="head-shot fyrelazy" data-background-image="<?php echo $image; ?>"></div>
						            		<div class="below-head-shot-info">
							            		<h4 class="wht-txt"><?php the_title(); ?></h4>
							            		<p class="ylw-txt"><?= get_field('year'); ?></p>
							            		<p class="wht-txt small"><?= get_field('short_desc'); ?></p>
							            	</div>
						            	</div>
						        	<?php endwhile; ?>
							    </div>
					      	<?php endif; wp_reset_query(); ?>
					    </div>
				    </div>
		        </div>

			</div>
		</div>
	</div>
</section>

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