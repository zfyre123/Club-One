<?php  /* Template Name: Beach */

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

<section id="page-header" class="simple beach-blu-bg text-center middle-content">
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
	        		<h2>Beach Volleyball Options</h2>
	        		<p><?= get_field('beach_volleyball_options_content') ?></p>
	      		</div>
	    	</div>
	    </div>
	</div>
<img src="/wp-content/themes/fyrestarter-child/assets/icons/outdoor-icon.svg">	
</section>

<section id="options-cols">
    <div class="container">
        <div class="row row-eq-height">
          <?php if( have_rows('volleyball_options') ): ?>
            <?php while( have_rows('volleyball_options') ): the_row(); 
                $title = get_sub_field('title');
                $option_title = str_replace( ' ', '<br>', $title);
            ?> 
                <div class="col-lg-4 no-padd">
                    <div class="option-box-holder text-center option-box">
                        <div class="fyrelazy cover-bg" data-background-image="<?= get_sub_field('bg_image') ?>"></div>
                        <div class="overlay"></div>
                        <div class="option-box-inner between-content">
                            <div class="option-box-inner-top">
                                <h3><?php echo $option_title ?></h3>
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

<section id="where-we-play" class="fyrelazy cover-bg" data-background-image="/wp-content/uploads/2020/06/beach-sand.jpg">
<div class="overlay"></div>
    <div class="container">
    	<div class="row">
            <div class="col-lg-11 offset-lg-1">
                <div class="row sec-header">
                    <div class="col-xl-7 col-lg-8">
                        <h2>Where we play</h2>
                        <p class="wht-txt"><?= get_field('where_we_play_description') ?></p>
                    </div>
                </div>
                <div class="row row-eq-height">
                    <div class="col-lg-8">
                        <h3 class="ylw-txt">Arizona</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php if( have_rows('az_locations_column_1') ): ?>
                                    <ul>
                                    <?php while( have_rows('az_locations_column_1') ): the_row(); ?> 
                                        <li class="wht-txt"><strong><?= get_sub_field('name') ?></strong><br><?= get_sub_field('address') ?></li>
                                    <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>                                
                            </div>
                            <div class="col-lg-6">
                                <?php if( have_rows('az_locations_column_2') ): ?>
                                    <ul>
                                    <?php while( have_rows('az_locations_column_2') ): the_row(); ?> 
                                        <li class="wht-txt"><strong><?= get_sub_field('name') ?></strong><br><?= get_sub_field('address') ?></li>
                                    <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>                                 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h3 class="ylw-txt">California</h3>
                        <?php if( have_rows('ca_locations_column') ): ?>
                            <ul>
                            <?php while( have_rows('ca_locations_column') ): the_row(); ?> 
                                <li class="wht-txt"><strong><?= get_sub_field('name') ?></strong><br><?= get_sub_field('address') ?></li>
                            <?php endwhile; ?>
                            </ul>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>
    	</div>
    </div>	
</section>

<?php 
$coaches_bg_color = 'beach-blu-bg';
include( locate_template( 'assets/partials/meet-our-coaches.php', false, false ) );
?>

<?php get_template_part( 'assets/partials/our-facility' ); ?>

<section id="calendar" class="lt-blu-bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
            	<div class="row sec-header">
                    <div class="col-12 text-center">
                        <h2 class="ylw-txt">Upcoming Beach Events</h2>
                    </div>
                </div>
                <div class="events-box wht-bg">
                    <div class="row">
                        <div class="col-12">
                            <?php echo do_shortcode('[tribe_events view="month" category="beach"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
$alumni_bg_color = 'beach-blu-bg';
$alumni_alt_txt_color = 'navy-txt';
include( locate_template( 'assets/partials/alumni.php', false, false ) );
?>

<?php get_template_part( 'assets/partials/join-a-program' ); ?>

<?php 
$current_questions = 'beach';
$questions_bg_color = 'beach-blu-bg';
include( locate_template( 'assets/partials/questions.php', false, false ) );
?>

<section id="latest-grams">
	<div class="container">
		<div class="row sec-header">
			<div class="col-12">
				<div class="d-flex justify-content-between">
					<div class="d-flex view-grams">
						<h2 class="navy-blu">Latest Grams</h2>
						<div class="flex-btn hidden-sm-down"><a class="line-btn" target="_blank" href="https://www.instagram.com/<?= get_field('instagram_account') ?>" title="View Instaram Account">View Profile</a></div>
					</div>
					<h2 class="ylw-txt viva hidden-sm-down">@<?= get_field('instagram_account') ?></h2>
				</div>
			</div>
		</div>
	</div>
 	<div id="instagram-feed" class="instagram_feed"></div>
 	<div class="hidden-md-up text-center">
		<h2 class="ylw-txt viva">@<?= get_field('instagram_account') ?></h2>
 		<div class="flex-btn"><a class="line-btn" target="_blank" href="https://www.instagram.com/<?= get_field('instagram_account') ?>" title="View Instaram Account">View Profile</a></div>
 	</div>
	<script>
	    (function($){
	        $(window).on('load', function(){
	            $.instagramFeed({
	                'username': '<?= get_field('instagram_account') ?>',
	                'container': "#instagram-feed",
                    'display_profile': false,
                    'display_biography': false,
                    'display_gallery': true,
                    'callback': null,
                    'styling': true,
                    'items': 5,
                    'items_per_row': 5,
                    'margin': 0,
                    'image_size': 480
            });
        });
    })(jQuery);
	</script>
</section>

<?php get_footer(); ?>