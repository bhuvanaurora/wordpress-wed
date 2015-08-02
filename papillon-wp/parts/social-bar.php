<?php
GLOBAL $webnus_options;
?>

<section class="footer-social-bar">
	<div class="container"><div class="row">
	<ul class="footer-social-items">
	<?php
		if($webnus_options->webnus_facebook_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_facebook_ID()) .'" class="facebook"><i class="fa-facebook"></i><div><strong>Facebook</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Facebook</span></div></a></li>';
		if($webnus_options->webnus_twitter_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_twitter_ID()) .'" class="twitter"><i class="fa-twitter"></i><div><strong>Twitter</strong><span>'.__('Follow us on','WEBNUS_TEXT_DOMAIN').' Twitter</span></div></a></li>';
		if($webnus_options->webnus_dribbble_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_dribbble_ID()).'" class="dribble"><i class="fa-dribbble"></i><div><strong>Dribbble</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Dribbble</span></div></a></li>';
		if($webnus_options->webnus_pinterest_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_pinterest_ID()) .'" class="pinterest"><i class="fa-pinterest"></i><div><strong>Pinterest</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Pinterest</span></div></a></li>';
		if($webnus_options->webnus_vimeo_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_vimeo_ID()) .'" class="vimeo"><i class="fa-vimeo-square"></i><div><strong>Vimeo</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Vimeo</span></div></a></li>';
		if($webnus_options->webnus_youtube_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_youtube_ID()) .'" class="youtube"><i class="fa-youtube"></i><div><strong>Youtube</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Youtube</span></div></a></li>';	
		if($webnus_options->webnus_google_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_google_ID()) .'" class="google"><i class="fa-google"></i><div><strong>Google Plus</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Google Plus</span></div></a></li>';	
		if($webnus_options->webnus_linkedin_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_linkedin_ID()) .'" class="linkedin"><i class="fa-linkedin"></i><div><strong>Linkedin</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Linkedin</span></div></a></li>';	
		if($webnus_options->webnus_rss_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_rss_ID()) .'" class="rss"><i class="fa-rss"></i><div><strong>Rss</strong><span>'.__('Keep updated with','WEBNUS_TEXT_DOMAIN').' RSS</span></div></a></li>';
		if($webnus_options->webnus_instagram_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_instagram_ID()) .'" class="instagram"><i class="fa-instagram"></i><div><strong>Instagram</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Instagram</span></div></a></li>';	
		if($webnus_options->webnus_flickr_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_flickr_ID()) .'" class="other-social"><i class="fa-flickr"></i><div><strong>Flickr</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Flickr</span></div></a></li>';	
		if($webnus_options->webnus_reddit_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_reddit_ID()) .'" class="other-social"><i class="fa-reddit"></i><div><strong>Reddit</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Reddit</span></div></a></li>';
		if($webnus_options->webnus_delicious_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_delicious_ID()) .'" class="other-social"><i class="fa-delicious"></i><div><strong>Delicious</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Delicious</span></div></a></li>';	
		if($webnus_options->webnus_lastfm_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_lastfm_ID()) .'" class="other-social"><i class="fa-lastfm"></i><div><strong>Lastfm</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Lastfm</span></div></a></li>';
		if($webnus_options->webnus_tumblr_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_tumblr_ID()) .'" class="other-social"><i class="fa-tumblr"></i><div><strong>Tumblr</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Tumblr</span></div></a></li>';
		if($webnus_options->webnus_skype_ID())
			echo '<li><a href="'. esc_url($webnus_options->webnus_skype_ID()) .'" class="other-social"><i class="fa-skype"></i><div><strong>Skype</strong><span>'.__('Join us on','WEBNUS_TEXT_DOMAIN').' Skype</span></div></a></li>';
	?>
	</ul>
	</div></div>
	</section>