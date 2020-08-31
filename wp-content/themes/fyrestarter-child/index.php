<?php

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );


$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
// blog Query Args
$blogArgs = array (
    'posts_per_page' => 8,
    'order'                  => 'DESC',
    'ignore_sticky_posts' => 'true',
    'orderby'            => 'post_date',
    'paged'          => $paged
);
// The Query
$blogQuery = new WP_Query( $blogArgs );

get_header();?>

<section id="page-header" class="simple text-center middle-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Club One Blog</h1>
            </div>  
        </div>
    </div>
</section>

<section id="post-feed">
    <div class="container">
        <div class="row">
            <div class="col-12">
        <?php if($blogQuery->have_posts()): 
            //vars
            $counter = 0; 
          ?>

                <?php while($blogQuery->have_posts()) : $blogQuery->the_post(); 
                  //vars
                  $counter++;
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' )[0]; 
                ?>  
                <!-- bog row -->
                    <?php if ($counter % 2 != 0) { ?>

                        
                        <div class="row row-eq-height blog-row blog-row-odd">
                            <div class="col-xl-4 col-lg-5 blog-img cover-bg fyrelazy" data-background-image="<?php echo $image; ?>"></div>
                            <div class="col-xl-8 col-lg-7 blog-content">
                                <div class="blog-content-inner middle-content">   
                                    <p class="red-txt"><?php echo get_the_date(); ?></p>                    
                                    <h3 class="blog-post-title blu-txt"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="blog-excerpt"><?php the_excerpt(); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row row-eq-height blog-row blog-row-even">
                            <div class="col-xl-4 push-xl-8 col-lg-5 push-lg-7 blog-img cover-bg fyrelazy" data-background-image="<?php echo $image; ?>"></div>
                            <div class="col-xl-8 pull-xl-4 col-lg-7 pull-lg-5 blog-content">
                                <div class="blog-content-inner middle-content">   
                                    <p class="red-txt"><?php echo get_the_date(); ?></p>                    
                                    <h3 class="blog-post-title blu-txt"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="blog-excerpt"><?php the_excerpt(); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <!-- bog row -->

                <?php endwhile; ?>
            </div>
    
        </div>
        <div class="row">
            <nav class="col-12 pagination center" style="padding-top:0px;">
                <?php
                    global $blogQuery; 

                    $total_pages = $blogQuery->max_num_pages;

                    if ($total_pages > 1){
                        $current_page = max(1, get_query_var('paged'));

                        echo paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => 'page/%#%',
                            'current' => $current_page,
                            'total' => $total_pages, 
                            'prev_text'          => 'PREV',
                            'next_text'          => 'NEXT',
                        ));
                    } 
                 ?>
            </nav>
            <?php wp_reset_postdata(); endif; ?>
        </div>
    </div> 
</section>


<?php get_footer(); ?>
