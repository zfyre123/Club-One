<?php
	// FACEBBOK SHARE
	    function fyre_og_header() {
	        if(is_single() || is_product() || is_page()) {

	            $content = get_the_excerpt();?>
	            <meta property="og:title" content="<?php the_title(); ?>"/> 
	            <?php $fb_image = wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID() ), 'full'); ?>
	            <?php if ($fb_image) { ?>
	            	<meta property="og:image" content="<?php echo $fb_image[0]; ?>" /> 
	        	<?php } else { ?> 
					<meta property="og:image" content="<?php echo $fyre_fb_img; ?>" />
	        	<?php } ?>
	                <meta property="og:type" content="<?php
	                if (is_single() || is_page()) { echo "article"; } else { echo "website";}     ?>"
	            />
	                <meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
	            <?php 
	        }
	    }
	    add_action('wp_head', 'fyre_og_header');

	// TWITTER SHARE
	    function fyre_tw_meta_header() {
	        if(is_single() || is_product() || is_page()) {
	            $twitter_url    = get_permalink( $leavename = true );
	            $twitter_title  = get_the_title();
	            $twitter_desc   = strip_tags(get_the_excerpt());
	            $twitter_thumbs = wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID() ), 'full');
	            $twitter_thumb  = $twitter_thumbs[0];
	            ?>
	            <meta name="twitter:card" content="summary_large_image" />
	            <meta name="twitter:url" content="<?php echo $twitter_url; ?>" />
	            <meta name="twitter:title" content="<?php echo $twitter_title; ?>" />
	            <meta name="twitter:description" content="<?php echo $twitter_desc; ?>" />
	            <?php if ($twitter_thumbs) { ?>
	            	<meta name="twitter:image" content="<?php echo $twitter_thumbs; ?>" />
	            <?php } else { ?> 
					<meta name="twitter:image" content="<?php echo $fyre_tw_img; ?>" />
	        	<?php } ?>
	        	<?php if ($tw_handle) { ?>
	            	<meta name="twitter:site" content="<?php echo $fyre_tw_handle;?>" />
	            	<meta name="twitter:creator" content="<?php echo $fyre_tw_handle;?>" />
	            <?php } ?>
	        <?php
	       	}
	    }
	   	add_action('wp_head', 'fyre_tw_meta_header');
?>