<?php  /* Template Name: Indoor */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

//ACF VARS
$jersery_number = get_field('jersery_number');

//PLAYERS ARGS
$playersArgs = array (
    'post_type' => 'players',
    'posts_per_page' => '-1',
    'meta_key' => 'jersery_number',
    'orderby' => 'meta_value_num',
    'order' => 'ASC', 
    'tax_query' => array( 
        array(
            'taxonomy' => 'team',
            'field'    => 'slug',
            'terms'    => $team_slug,
        ),
        array(
            'taxonomy' => 'alumni',
            'field'    => 'slug',
            'terms'    => 'yes',
            'operator' => 'NOT IN',
        ),
    ) 
);
// The Query
$playersQuery = new WP_Query( $playersArgs );

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

<section id="options-content">
	<div class="middle-content">
	    <div class="container wide-container">
	    	<div class="row">
	      		<div class="col-xl-6 col-lg-7 offset-lg-1 col-md-8">
	        		<h2>Indoor Volleyball Options</h2>
	        		<p><?= get_field('indoor_volleyball_options_content') ?></p>
	      		</div>
	    	</div>
	    </div>
	</div>
<img src="/wp-content/themes/fyrestarter-child/assets/icons/indoor-icon.svg">	
</section>

<section id="options-cols">
    <div class="container">
        <div class="row row-eq-height">
          <?php if( have_rows('volleyball_options') ): ?>
          <?php $counter = 0; ?>
            <?php while( have_rows('volleyball_options') ): the_row(); 
                $title = get_sub_field('title');
                $option_title = str_replace( ' ', '<br>', $title);
            ?> 
            <?php $counter++; ?>
                <div class="col-lg-4 no-padd">
                    <div class="option-box-holder text-center option-box">
                    	<div class="fyrelazy cover-bg" data-background-image="<?= get_sub_field('bg_image') ?>"></div>
                        <div class="overlay"></div>
                        <div class="option-box-inner between-content">
                            <div class="option-box-inner-top">
                                <h3 class="ylw-txt"><?php echo $option_title ?></h3>
                                <p class="wht-txt"><?= get_sub_field('description') ?></p>
                            </div>
                            <?php if (get_sub_field('link')): ?>
                                <div class="flex-btn"><a class="btn ylw-btn" href="<?= get_sub_field('link') ?>" title="<?php echo $option_title ?>"><?php if (get_sub_field('button_text')) { ?><?= get_sub_field('button_text') ?><?php } else { ?>Learn More<?php }?></a></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
    </div>  
</section>

<section id="we-are-one-banner" class="fyrelazy cover-bg" data-background-image="<?= get_field('banner_image') ?>">
	<div class="container wide-container">
		<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/icons/we-are-one-wht.svg" class="we-are-one hidden-sm-down"></object>
        <object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/icons/we-are-one-wht-vert.svg" class="we-are-one hidden-md-up"></object>
	</div>
</section>

<?php 
$coaches_bg_color = 'red-bg';
include( locate_template( 'assets/partials/meet-our-coaches.php', false, false ) );
?>

<?php get_template_part( 'assets/partials/our-facility' ); ?>

<section id="calendar" class="lt-blu-bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
            	<div class="row sec-header">
                    <div class="col-12 text-center">
                        <h2 class="ylw-txt">Upcoming Indoor Events</h2>
                    </div>
                </div>
                <div class="events-box wht-bg">
                    <div class="row">
                        <div class="col-12">
                            <?php echo do_shortcode('[tribe_events view="month" category="indoor"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part( 'assets/partials/join-a-program' ); ?>

<?php get_footer(); ?>