<?php 
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header();

?>

<section id="page-header" class="simple text-center middle-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>404</h1>
            </div>  
        </div>
    </div>
</section>

<section id="page" class="text-center">
  <div class="container">
    <div class="row">
      <article id="page-<?php the_ID(); ?>" class="col-12">
        <h4>Opps, we can't seem to find the page you're looking for..</h4>
        <a class="btn red-btn" href="<?php echo get_home_url(); ?>" title="Go Back to Home">Back to Home</a>
      </article>
    </div>
  </div>
</section>


<?php get_footer(); ?>