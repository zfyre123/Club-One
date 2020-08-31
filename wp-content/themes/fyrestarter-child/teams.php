<?php /* Template Name: Teams */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

// partnerss Query Args
$partnersArgs = array (
  	'post_type' => 'partners',
  	'posts_per_page' => '-1',
);
// The Query
$partnersQuery = new WP_Query( $partnersArgs );


get_header();?>

<section id="page-header" class="bg-header middle-content text-center cover-bg fyrelazy wht-txt" <?php printf( ' data-background-image="%s"', $image_src[0] ); ?>>
  <div class="overlay"></div>
  <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Club Volleyball Teams</h1>
        </div>
      </div>
    </div>  
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White.svg" class="page-top-curve desk-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-1024.svg" class="page-top-curve mid-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-375.svg" class="page-top-curve mobile-curve"></object>
</section>

<section class="text-center">
	<div class="container">
		<div class="row section-header">
			<div class="col-lg-7 col-md-9 mx-auto">
				<h2 class="red-txt">Club One AZ Teams & Coaches</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-9 col-md-11 mx-auto">
				<?= get_field('club_one_teams_description'); ?>
			</div>
		</div>
	</div>
</section>

<section id="teams">
	<div class="container">
		<div class="row">
			<div class="col-12">


		<?php
		    $custom_terms = $custom_terms = get_terms( array( 
			    'taxonomy' 	 => 'age_group',
			    'hide_empty' => true,
			) );

				foreach($custom_terms as $custom_term) {
				    wp_reset_query();
				    $args = array(
						'post_type' => 'teams',
						'posts_per_page' => '-1',
						// 'orderby'=> 'title', 
						// 'order' => 'DESC',
				        'tax_query' => array(
				            array(
				                'taxonomy' => 'age_group',
				                'field' => 'slug',
				                'terms' => $custom_term->slug,
				            ),
				        ),
				     );			    

				     $loop = new WP_Query($args); { ?>
				     	<div class="row row-eq-height age-group-row">
				     		<div class="col-12 text-center">
				     			<div class="age-group-header">
						        	<h4 class="gry-txt"><?php echo $custom_term->name ?></h4>
						        </div>
						    </div>
					        <?php if($loop->have_posts()): ?>
					        	<?php while($loop->have_posts()) : $loop->the_post(); ?>

						        	<div class="col-xl-6">
						        		<div class="team-box rounded-shadow">
						        			<a href="<?php echo the_permalink() ?>"></a>
						        			<div class="team-box-top d-flex justify-content-between">
						        				<div class="team-name ylw-bg middle-content">
						        					<h3 class="drk-blu-txt"><?php echo get_the_title() ?></h3>
						        				</div>
						        				<div class="team-practice middle-content">
						        					<p>Proposed Practice <strong><?= get_field('proposed_practice'); ?></strong></p>
						        				</div>
						        			</div>



						        			<?php if( have_rows('coaches') ): ?>
						        				<div class="team-box-btm">
							        				<p>Coaching Staff</p>
								        			<div class="teams-coaches d-flex">
														 <?php while( have_rows('coaches') ): the_row();
														    //vars
														    $coach_object = get_sub_field('coach');
														    $coach = $coach_object; setup_postdata( $coach );
														    if ( has_post_thumbnail( $coach->ID ) ) {
						                                        $coach_image = wp_get_attachment_image_src( get_post_thumbnail_id( $coach->ID ), 'thumbnail' )[0];
						                                    } else {
						                                        $coach_image = '/wp-content/uploads/2020/06/default-user.jpg';
						                                    }
														    $coach_post_name = $coach_object->post_title;
														    $coach_name = str_replace( ' ', '<br>', $coach_post_name);
														 ?> 
	  														<div class="teams-coach d-flex">
															    <div class="head-shot-small cover-bg fyrelazy" data-background-image="<?php echo $coach_image; ?>"></div>
				            									<div class="middle-content">
				            										<span><?php echo $coach_name ?></span>
				            									</div>
															</div>  
												  		<?php endwhile; ?>
											  		</div>	
											    </div>	
											<?php endif; ?>

							      		</div>
						        	</div>

					        	<?php endwhile; ?>
					        <?php endif; ?>
				        </div>
				    <?php }
				} wp_reset_postdata(); ?>


			</div>
		</div>
	</div>
</section>

<?php 
$alumni_bg_color = 'red-bg';
$alumni_alt_txt_color = 'ylw-txt';
include( locate_template( 'assets/partials/alumni.php', false, false ) );
?>

<?php get_template_part( 'assets/partials/split-section' ); ?>

<?php get_footer(); ?>