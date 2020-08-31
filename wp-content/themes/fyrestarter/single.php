<?php get_header();?>

<!-- MAIN BANNER -->

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<section id="main-banner" class="center nrmlsec inner parallax-window" data-position="top center" data-bleed="10" data-parallax="scroll"  data-natural-height="960" data-natural-width="2450" data-speed="0.8">
		<div class="vmiddle"> 
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<?php custom_breadcrumbs(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<!-- MAIN CONTENT -->
<main id="main">

	<!-- TOP SECTION --> 
	<article id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
		<div class="container-fluid">
			<div class="post whitebg">
				<div class="col-12">
					<h1><?php wp_title('',true,'right');; ?></h1>
					<?php if(has_post_thumbnail()) :?>
						<?php the_post_thumbnail('medium', array( 'class' => 'alignleft' )); ?>
						<?php else :?>
						<?php endif;?>
					<?php the_content(); ?>
					<?php endwhile; else : ?>
						<p><?php _e( 'Sorry, no posts matched your criteria.', 'fyrestarter' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</article>

<!-- POST NAVIGATION -->
	<section id="bottom-links">
		<div class="container-fluid">
			<div class="row row-eq-height">
				<?php 
				$prevPost = get_previous_post(true);
			        if($prevPost) {
			            $args = array(
			                'posts_per_page' => 1,
			                'include' => $prevPost->ID
			            );
			            $prevPost = get_posts($args);
			            foreach ($prevPost as $post) {
			                setup_postdata($post);
			    ?>
			    <!-- PREVIOUS POST -->
				<div id="prev" class="col-xs-6">
					<a class="btn" href="<?php the_permalink(); ?>"> &laquo; <?php the_title(); ?></a>
				</div>

				<?php 
		    	wp_reset_postdata();
		            } //end foreach
		        } // end if
		        $nextPost = get_next_post(true);
		        if($nextPost) {
		            $args = array(
		                'posts_per_page' => 1, 
		                'include' => $nextPost->ID
		            );
		            $nextPost = get_posts($args);
		            foreach ($nextPost as $post) {
		                setup_postdata($post);
			    ?>

			    <!-- NEXT POST --> 
				<div id="next" class="col-xs-6">
					<a class="btn" href="<?php the_permalink(); ?>"><?php the_title(); ?> &raquo;</a>
				</div>
				<?php wp_reset_postdata();
			            } //end foreach
			        } // end if
			    ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>