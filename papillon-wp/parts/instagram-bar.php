<?php
GLOBAL $webnus_options;
$user = $webnus_options->webnus_footer_instagram_username();
$acess = $webnus_options->webnus_footer_instagram_access();
?>

<section class="footer-instagram-bar">
	<div class="container"><div class="row">
	<div class="footer-instagram-text col-md-8 col-sm-8"><i class="fa-instagram"></i><h6><?php bloginfo('name')?> on Instagram</h6></div>
	<div class="col-md-4 col-sm-4"><a class="button red  medium bordered-bot " href="http://instagram.com/<?php echo $user; ?>">FOLLOW</a></div>
	</div></div>
		<div class="instagram-feed">
			<?php 
			$base_url =  "https://api.instagram.com/v1/users/search?q=". $user ."&access_token=". $acess ."&count=1&callback=?";
			$raw_content = wp_remote_get(esc_url_raw($base_url));
			if(!is_wp_error($raw_content))
			{
				$raw_content = $raw_content['body'];
				$json_insta = json_decode($raw_content);
				if (isset($json_insta->data[0]))
				{
				   $id = $json_insta->data[0]->id;
				}				
				if(!empty($id))
				{
					$url = "https://api.instagram.com/v1/users/". $id ."/media/recent/?access_token=". $acess ."&count=8&callback=?";
					$raw_content = wp_remote_get(esc_url_raw($url));
					$output = '';
					if(!is_wp_error($raw_content))
					{
						$output .= '<ul>';	
						$raw_content = $raw_content['body'];
						$json_insta = json_decode($raw_content);
						if (isset($json_insta->data[0]))
					{
						foreach($json_insta->data as $data)
						{		
							$output .= '<li><a href="'.esc_url($data->link).'" target="_blank"><img alt="" src="'.esc_url($data->images->low_resolution->url).'"/></a></li>';	
						}
					}
						$output .= '</ul>';	
						echo $output;
					}
				} // end if empty id
			}
			else echo __('An error has occoured...','WEBNUS_TEXT_DOMAIN');
			?>
			<div class="clear"></div>
		</div>	
</section>