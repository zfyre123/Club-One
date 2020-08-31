<?php get_header();?>

<!-- MAIN CONTENT -->
<main id="main">
	<div class="container nrmlsec">
      	<div class="row">
      		<article id="page-<?php the_ID(); ?>" class="col-12 content">
				<?php if ( have_posts() ) : 
					while ( have_posts() ) : the_post();
					 	echo the_title( '<h1>', '</h1>' );
					 	echo the_content(); 
					endwhile; 
				endif; ?>
			</article>
		</div>
	</div>
</main>

<?php get_footer(); ?>

