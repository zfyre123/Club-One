<?php

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

<section id="page">
	<div class="container">
	  	<div class="row">
	  		<article id="page-<?php the_ID(); ?>" class="col-12 content">
				<?php if ( have_posts() ) : 
					while ( have_posts() ) : the_post();
					 	echo the_content(); 
					endwhile; 
				endif; ?>
			</article>
		</div>
	</div>
</section>

<?php get_footer(); ?>