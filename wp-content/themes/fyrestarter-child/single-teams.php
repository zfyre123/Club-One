<?php

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

$team_type = wp_get_object_terms( $post->ID, 'coach_type' );

$team_name = strtolower(get_the_title());
$team_slug = str_replace( ' ', '-', $team_name);

//ACF VARS
$jersery_number = get_field('jersery_number');
$insta_tag = get_field('insta_tag');
$lowercase_insta_tag = strtolower($insta_tag);
$final_insta_tag = str_replace( '#', '', $lowercase_insta_tag);

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
                <span><span><a href="/">Home</a> / <span><a href="/teams/">Teams</a> / <span class="breadcrumb_last red-txt" aria-current="page"><?php echo get_the_title(); ?></span></span></span></span>
            </div>
        </div>
    </div>
</div>

<section id="team-roster">
    <div class="container wide-container">
        <div class="row">
            <div class="col-12">
                <h2>Team Roster</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="roster-info" class="rounded-shadow">
                    <?php if($playersQuery->have_posts()): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th class="gry-bg"><h4 class="blu-txt"><?php echo get_the_title(); ?></h4></th>
                                    <th>Jersey #</th>
                                    <th>Position</th>
                                    <th>Grad Year</th>
                                    <th>Height</th>
                                    <th>Approach</th>
                                    <th>Block</th>
                                    <th>High School</th>
                                    <th>Commitment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($playersQuery->have_posts()) : $playersQuery->the_post(); 
                                    //vars
                                    $player_post_name = get_the_title();
                                    $player_name = str_replace( ' ', '<br>', $player_post_name);

                                    if ( !empty(get_the_post_thumbnail()) && !has_term( ['12-years-under', '13-years-under', '14-years-under', '15-years-under'], 'age_group') ) {
                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'thumbnail' )[0]; 
                                    } else {
                                        $image = '/wp-content/uploads/2020/06/default-user.jpg';
                                    }

                                    if ( has_term( ['12-years-under', '13-years-under', '14-years-under', '15-years-under'], 'age_group') ) {
                                        $under_16 = ' under-16';
                                    }
                                   
                                ?>  

                                    <tr>
                                        <td class="gry-bg"><div class="player-name-img"><div class="d-flex justify-content-center"><div class="head-shot-medium cover-bg fyrelazy<?php echo $under_16 ?>" data-background-image="<?php echo $image; ?>"></div><div class="middle-content"><h5><?php echo $player_name ?></h5></div></div></div></td>
                                        <td><?= get_field('jersery_number') ?></td>
                                        <td><?= get_field('position') ?></td>
                                        <td><?= get_field('grad_year') ?></td>
                                        <td><?= get_field('height') ?></td>
                                        <td><?= get_field('approach') ?></td>
                                        <td><?= get_field('block') ?></td>
                                        <td><?= get_field('high_school') ?></td>
                                        <td><?= get_field('commitment') ?></td>
                                    </tr>

                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endif; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>   
</section>

<section id="coachin-staff">
    <div class="container wide-container">
        <div class="row">
            <div class="col-12">
                <h2>Coaching Staff</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="blu-bg wht-txt rounded-shadow row ml-0 mr-0 team-coaches-box">
                    <div class="row">
                        <div class="col-xl-10 col-lg-10 mx-auto">
                            <div class="row">
                                <?php if( have_rows('coaches') ): ?>
                                     <?php while( have_rows('coaches') ): the_row();
                                        //vars
                                        $coach_object = get_sub_field('coach');
                                        $coach = $coach_object; setup_postdata( $coach );
                                        if ( has_post_thumbnail( $coach->ID ) ) {
                                            $coach_image = wp_get_attachment_image_src( get_post_thumbnail_id( $coach->ID ), 'medium' )[0];
                                        } else {
                                            $coach_image = '/wp-content/uploads/2020/06/default-user.jpg';
                                        }
                                        $coach_name = $coach_object->post_title;
                                     ?> 
                                        <div class="col-lg-4 col-sm-12 team-coach text-center">
                                            <div class="head-shot cover-bg fyrelazy" data-background-image="<?php echo $coach_image; ?>"></div>
                                            <h4 class="ylw-txt"><?php echo $coach_name ?></h4>
                                            <?php if(get_field('position')): ?>
                                                <p><?= get_field('position'); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</section>

<section id="team-details">
    <div class="container wide-container">
        <div class="row">
            <div class="col-12">
                <h2>Team Details</h2>
            </div> 
        </div>
        <div class="row">
            <div class="col-12">
                <div class="red-bg wht-txt rounded-shadow team-details-box">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4>Regular Practice Schedule*:</h4>
                            <?= get_field('regular_practive_schedule_content'); ?>                            
                        </div>
                        <div class="col-lg-4 text-center end-content">
                            <?php if(get_field('pay_dues_link')): ?>
                                <div class="flex-btn"><a class="btn ylw-btn" href="<?= get_field('pay_dues_link') ?>">Pay Team Dues</a></div>
                            <?php endif; ?>  
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </div>   
</section>

<section id="calendar">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="events-box">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="navy-blu"><?php echo get_the_title(); ?> Calendar</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?php echo do_shortcode('[tribe_events view="month" category="'.$team_slug .'"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part( 'assets/partials/join-a-program' ); ?>

<section id="latest-grams">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div class="d-flex view-grams">
                        <h2 class="navy-blu">Latest Grams</h2>
                        <div class="flex-btn hidden-sm-down"><a class="line-btn" target="_blank" href="<?= get_field('insta_link'); ?>" title="View Instaram Account">View Profile</a></div>
                    </div>
                    <h2 class="ylw-txt viva hidden-sm-down"><?= get_field('insta_tag'); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div id="instagram-feed" class="instagram_feed"></div>
    <div class="hidden-md-up text-center">
        <h2 class="ylw-txt viva"><?= get_field('insta_tag'); ?></h2>
        <div class="flex-btn"><a class="line-btn" target="_blank" href="<?= get_field('insta_link'); ?>" title="View Instaram Account">View Profile</a></div>
    </div>
    <script>

        (function($){
            $(window).on('load', function(){
                $.instagramFeed({
                    'tag': <?= json_encode($final_insta_tag) ?>,
                    'container': "#instagram-feed",
                    'display_profile': false,
                    'display_biography': false,
                    'display_gallery': true,
                    'callback': null,
                    'styling': true,
                    'items': 5,
                    'items_per_row': 5,
                    'margin': 0,
                    'image_size': 520 
            });
        });
    })(jQuery);
    </script>
</section>

<?php get_footer(); ?>