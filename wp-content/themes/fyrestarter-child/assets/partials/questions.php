<?php
//ARGS
$questionArgs = array (
  'post_type' => 'questions',
  'posts_per_page' => '-1',
  'tax_query' => array( 
    array(
        'taxonomy' => 'question_location',
        'field'    => 'slug',
        'terms'    => esc_html( $current_questions ),
    ),
  ) 
);
//QUERY
$questionQuery = new WP_Query( $questionArgs ); ?>

<section id="questions" class="<?php echo esc_html( $questions_bg_color ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 mx-auto">
				<h2 class="ylw-txt">Have Questions?</h2>
				<?php if($questionQuery->have_posts()): ?>
	            	<?php $counter = 0; ?>
	            	<div id="questions-accordion">
		            	<?php while($questionQuery->have_posts()) : $questionQuery->the_post(); ?> 
			            <?php $counter++; ?>
							<div class="card">
						        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $counter; ?>">
						        	<?php the_title(); ?>
						        </button>
							    <div id="collapse-<?php echo $counter; ?>" class="collapse" aria-labelledby="question-<?php echo $counter; ?>" data-parent="#questions-accordion">
							    	<div class="card-body wht-txt">
							        	<?php the_content(); ?>
							        </div>
							    </div>
							</div>
		            	<?php endwhile; ?>
	            	</div>
	      		<?php endif; wp_reset_query(); ?>				
			</div>
		</div>
	</div>
</section>