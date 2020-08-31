<?php get_header();?>

<!-- MAIN BANNER -->
	<section id="main-banner" class="center nrmlsec inner parallax-window" data-position="top center" data-bleed="10" data-parallax="scroll" data-image-src="/wp-content/uploads/2016/05/small-header.jpg" data-natural-height="960" data-natural-width="2450" data-speed="0.8">
		<div class="vmiddle"> 
			<div class="container-fluid">
				<div class="row">
					<div class="col-12"> 
						<h1><?php
								// echo wp_title('',true,'right');
								echo the_archive_title();
							?>
						</h1>
					</div> 
				</div>
			</div>
		</div>
	</section>
<!-- MAIN CONTENT -->
<main id="main">

	<!-- ABOUT GRID -->
	<section id="blog" class="content content-grid">
		<div class="container">
			<div class="row whitebg">
				<div id="cat-list" class="center col-12">
					<li id="allnews"><a href="/about-us/news">All News</a></li>
					<?php 
					$catsy = get_the_category();
					$myCat = $catsy[0]->cat_ID;
					$catargs = array(
						'exclude' => '1 17 23',
						'hide_empty' => 0,
						'orderby' => 'id',
						'separator' => '',
						'hierarchical' => 0,
						'style' => 'list',
						'current_category' => $myCat,
						'title_li'  => 0
					);
					echo wp_list_categories($catargs); ?>
				</div>
			</div>

			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$archive_args = array(
			      	post_type => 'post',
			    );
				$archive_query = new WP_Query( $archive_args );
				//$wp_query = new WP_Query();
				$archive_query->query('posts_per_page='.get_option('posts_per_page').'&paged=' . $paged);
			?>

			<?php  if( have_posts() ) : while (have_posts() ) : the_post(); ?>

				<div class="post row row-eq-height whitebg">
				
				<?php 	
					global $post; 
				 	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
					if ( has_post_thumbnail() ) { ?>

					<a class="pic-box col-12 col-sm-12 col-md-4" style="background-image:url(<?php echo $src[0]; ?>);" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'blog-post' ); ?>

					<?php } else { ?>

					<a class="pic-box col-12 col-sm-12 col-md-4" style="background-image:url(/wp-content/uploads/2016/05/post-placeholder.jpg);" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
						<img height="600" width="800" src="/wp-content/uploads/2016/05/post-placeholder.jpg"/>
					
					<?php } ?>
					</a>
					<div class="post-content col-12 col-sm-12 col-md-8">
						<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<small><?php the_time( 'F jS, Y' ); ?> </small>
						<p class="entry">
							<?php echo excerpt(15) ?>
						</p>
						<div class="postmetadata">
							<?php the_category( ' ' ); ?>
						</div>
					</div> 
				</div>
		
			<?php endwhile; ?>
			<nav class="pagination">
				<?php pagination_bar(); ?>
			</nav>
			<?php wp_reset_postdata();
			else : ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.', 'fyrestarter' ); ?></p>
			<?php endif; ?>
			</div>
		</div> 
	</section>
</main>
<?php get_footer(); ?>
