<?php
// SHORT CODES
	
	//[phone]
	function fyre_phone(){
		return get_option('phone_number');
	}
	//[phonelink]
	function fyre_phone_link(){
		$phonelink = '<a href="tel:'. get_option('phone_number') .'" target="_blank">'. get_option('phone_number') .'</a>';
		return $phonelink;
	}
	//[email] 
	function fyre_email(){
		return get_option('email_address');
	}
	//[emaillink]
	function fyre_email_link(){
		$emaillink = '<a href="mailto:'. get_option('email_address') .'" target="_blank">'. get_option('email_address') .'</a>';
		return $emaillink;
	}
	//[fax]
	function fyre_fax(){
		return get_option('the_fax');
	}
	//[address]
	function fyre_address(){
		$street = get_option('the_street');
		$city = get_option('the_city');
		$state = get_option('the_state');
		$zip = get_option('the_zip');
		$fulladdress = $street.' '.$city.' '.$state.' '.$zip;
		return $fulladdress;
	}
	//[glink]
	function fyre_glink(){
		return get_option('local_link');
	}
	//[fb_url]
	function fyre_fb(){
		$fblink = '<a class="facebook-link" href="'. get_option('fb_url') .'" target="_blank"><i class="fa fa-facebook"></i></a>';
		return $fblink;
	}
	//[tw_url]
	function fyre_tw(){
		$twlink = '<a class="twitter-link" href="'. get_option('tw_url') .'" target="_blank"><i class="fa fa-twitter"></i></a>';
		return $twlink;
	}
	//[gp_url]
	function fyre_gp(){
		$gplink = '<a class="googlep-link" href="'. get_option('gp_url') .'" target="_blank"><i class="fa fa-google-plus"></i></a>';
		return $gplink;
	}
	//[ig_url]
	function fyre_ig(){
		$iglink = '<a class="instagram-link" href="'. get_option('ig_url') .'" target="_blank"><i class="fa fa-instagram"></i></a>';
		return $iglink;
	}
	//[ig_url]
	function fyre_li(){
		$lilink = '<a class="linkedin-link" href="'. get_option('li_url') .'" target="_blank"><i class="fa fa-linkedin"></i></a>';
		return $lilink;
	}
	// ADD SHORTCODES
	function fyre_codes(){
		add_shortcode( 'phone', 'fyre_phone' );
		add_shortcode( 'phonelink', 'fyre_phone_link' );
		add_shortcode( 'email', 'fyre_email' );
		add_shortcode( 'emaillink', 'fyre_email_link' );
		add_shortcode( 'fax', 'fyre_fax' );
		add_shortcode( 'address', 'fyre_address' );
		add_shortcode( 'glink', 'fyre_glink' );
		add_shortcode( 'fb_url', 'fyre_fb' );
		add_shortcode( 'tw_url', 'fyre_tw' );
		add_shortcode( 'gp_url', 'fyre_gp' );
		add_shortcode( 'ig_url', 'fyre_ig' );
		add_shortcode( 'li_url', 'fyre_li' );
	}
	add_action( 'init', 'fyre_codes');
?>