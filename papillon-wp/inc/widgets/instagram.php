<?php
include_once str_replace("\\","/",get_template_directory()).'/inc/init.php';
class WebnusInstagramWidget extends WP_Widget{

	function __construct(){

		$params = array(
		'description'=> 'Webnus Instagram Widget',
		'name'=> 'Webnus-Instagram'
		);

		parent::__construct('WebnusInstagramWidget', '', $params);

	}

	public function form($instance){


		extract($instance);
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title') ?>">Title:</label>
		<input
		type="text"
		class="widefat"
		id="<?php echo $this->get_field_id('title') ?>"
		name="<?php echo $this->get_field_name('title') ?>"
		value="<?php if( isset($title) )  echo esc_attr($title); ?>"
		/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('username') ?>">Instagram Username:</label>
		<input type="text"		
		class="widefat"
		id="<?php echo $this->get_field_id('username') ?>"
		name="<?php echo $this->get_field_name('username') ?>"
		value="<?php if( isset($username) )  echo esc_attr($username); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('token') ?>">Instagram Access Token:</label>
		<input type="text"		
		class="widefat"
		id="<?php echo $this->get_field_id('token') ?>"
		name="<?php echo $this->get_field_name('token') ?>"
		value="<?php if( isset($token) ) echo esc_attr($token); ?>" />
		<small>Get the this information <a target="_blank" href="http://www.pinceladasdaweb.com.br/instagram/access-token/">here</a>.</small>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('count') ?>">Feed Count(Max 20):</label>
		<input type="text"
		class="widefat"
		id="<?php echo $this->get_field_id('count') ?>"
		name="<?php echo $this->get_field_name('count') ?>"
		value="<?php if( isset($count) )  echo esc_attr($count); ?>" />
		</p>
		<?php 
	}
	
	
	public function widget($args, $instance){
		extract($args);
		extract($instance);
		?>
		<?php echo $before_widget; ?>
		<?php 
		if(!empty($title))
		echo $before_title.$title.$after_title; 
		if(!empty($username) && !empty($token) ){
		?>
			<div class="instagram-feed">
			<?php 
			$base_url =  "https://api.instagram.com/v1/users/search?q=" . $username . "&access_token=" . $token . "&count=1&callback=?";
			
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
					
					$url = "https://api.instagram.com/v1/users/" . $id  ."/media/recent/?access_token=" . $token . "&count=" . $count . "&callback=?";
					
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
								
							$output .= '<li><a href="'.$data->link.'" target="_blank"><img alt="" src="'.$data->images->thumbnail->url.'"/></a></li>';
							
							
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
		  <?php } echo $after_widget; ?><!-- Disclaimer -->
		<?php 
	} 
}

add_action('widgets_init','register_webnus_instagram_widget'); 
function register_webnus_instagram_widget(){
	
	register_widget('WebnusInstagramWidget');
	
}

