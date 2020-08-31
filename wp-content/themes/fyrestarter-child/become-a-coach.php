<?php /* Template Name: Become a Coach */

$post_id = get_the_ID();

$thumbnail_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src( $thumbnail_id, 'full' );

$current_questions = 'training';

// questions Query Args
$questionArgs = array (
  'post_type' => 'questions',
  'posts_per_page' => '-1',
  'tax_query' => array( 
    array(
        'taxonomy' => 'question_location',
        'field'    => 'slug',
        'terms'    => $current_questions,
    ),
  ) 
);
// The Query
$questionQuery = new WP_Query( $questionArgs );

get_header();?>

<section id="page-header" class="alt-header middle-content ylw-bg">
 	 <div class="container">
      	<div class="row">
			<div class="col-12">
				<div class="header-content">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
			</div>
			<h2 class="viva large-training-txt">We are one</h2>
	    </div>
    </div>  
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White.svg" class="page-top-curve desk-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-1024.svg" class="page-top-curve mid-curve"></object>
<object type="image/svg+xml" data="/wp-content/themes/fyrestarter-child/assets/img/Club-One-Curve-White-375.svg" class="page-top-curve mobile-curve"></object>
</section>

<section id="become-a-coach">
    <div class="container">
    	<div class="row">
      		<div class="col-xl-5 col-lg-8 offset-xl-1 offset-lg-2 middle-content">
        		<h2 class="red-txt">Club One Coaches</h2>
        		<p><?= get_field('club_one_coaches_content') ?></p>
      		</div>
    	</div>
    <img class="coaches" src="/wp-content/uploads/2020/06/Become-A-Coach-min.png" title="Become a Club One Coach">
	</div>	
</section>

<?php 
$current_questions = 'become-a-coach';
$questions_bg_color = 'lt-blu-bg';
include( locate_template( 'assets/partials/questions.php', false, false ) );
?>

<?php 
$coaches_bg_color = 'red-bg';
include( locate_template( 'assets/partials/meet-our-coaches.php', false, false ) );
?>

<section id="apply">
	<div class="container">
    	<div class="row sec-header text-center">
      		<div class="col-xl-6 col-lg-7 mx-auto">
        		<h2 class="blu-txt">Apply To Be A Coach</h2>
        		<p><?= get_field('apply_to_be_a_coach_content') ?></p>
      		</div>
    	</div>
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true" tabindex="50"]'); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>