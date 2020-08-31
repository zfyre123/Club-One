<?php get_header();

//POST ID
$post_id = get_the_ID();

//THUMBNAIL
$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

?>


<section id="post-header" class="middle-content cover-bg fyrelazy wht-txt text-center" <?php printf( ' data-background-image="%s"', $image_src[0] ); ?>>
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-9 col-md-11 mx-auto">
        <p><?php echo get_the_date(); ?></p> 
        <h1><?php echo get_the_title(); ?></h1>
      </div>
    </div>
  </div>
</section>

<section id="post">
  <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-11 mx-auto">
          <article id="page-<?php the_ID(); ?>">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <?php the_content(); ?>
            <?php endwhile; ?>
            <?php endif; ?>
          </article>
        </div>
      </div>
      <!-- POST NAVIGATION -->
      <div class="row">
        <div class="col-lg-9 col-md-11 mx-auto">
          <div id="bottom-links-pages" class="d-flex justify-content-between"> 
            <?php if (strlen(get_next_post()->post_title) > 0) { ?>
              <?php next_post_link( '%link', '<i class="fa fa-angle-left"></i> <span>Previous Post</span>' ); ?>
            <?php wp_reset_postdata(); } else { ?>
              <a class="no-link article-link-btn" title=""><i class="fa fa-angle-left"></i> <span>Previous Post</span></a>
            <?php } ?>
            <?php if (strlen(get_previous_post()->post_title) > 0) { ?>
              <?php previous_post_link( '%link', '<span>Next Post</span> <i class="fa fa-angle-right"></i>' ); ?>
            <?php wp_reset_postdata(); } else { ?>
              <a class="no-link article-link-btn" title=""><span>Next Post</span> <i class="fa fa-angle-right"></i></a>
            <?php } ?>
          </div> 
        </div>
      </div>
      <!-- POST NAVIGATION -->
  </div>
</section>

<?php get_footer(); ?>