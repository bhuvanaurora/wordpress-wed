<?php
include_once str_replace("\\","/",get_template_directory()).'/inc/init.php';
class webnus_subscribe_widget extends WP_Widget{

	function __construct(){

		$params = array(
		'description'=> 'Email Subscribe',
		'name'=> 'Webnus - Subscribe'
		);

		parent::__construct('webnus_subscribe_widget', '', $params);

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
		<label for="<?php echo $this->get_field_id('id') ?>">Feedburner ID:</label>
		<input
		type="text"
		class="widefat"
		id="<?php echo $this->get_field_id('id') ?>"
		name="<?php echo $this->get_field_name('id') ?>"
		value="<?php if( isset($id) )  echo esc_attr($id); ?>"
		/>
		</p>	
		<p>
		<label for="<?php echo $this->get_field_id('text') ?>">Custom text:</label>
		<textarea 
		class="widefat"
		id="<?php echo $this->get_field_id('text') ?>"
		name="<?php echo $this->get_field_name('text') ?>"
		><?php if( isset($text) )  echo esc_attr($text); ?></textarea>
		</p>
		
		

		<?php 
	}
	
	
	public function widget($args, $instance){
		
		extract($args);
		extract($instance);
		?>
	
			<?php echo $before_widget; ?>
			<?php if(!empty($title)) echo $before_title.$title.$after_title; ?>
			<form class="widget-subscribe-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onSubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr($id); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<input type="hidden" value="<?php echo esc_attr($id); ?>" name="uri"/>
				<input type="hidden" name="loc" value="en_US"/>
				<p><?php echo esc_html($text); ?></p>
				<input placeholder="your email here.." class="footer-subscribe-email" type="text" name="email"/>
				<button class="footer-subscribe-submit" type="submit">SUBSCRIBE</button>
			</form>
			
			<?php 
				$o = new webnus_options();
			?>
				
			<?php echo $after_widget; ?>

		<?php 
	} 
}

add_action('widgets_init', 'register_webnus_subscribe'); 
function register_webnus_subscribe(){
	
	register_widget('webnus_subscribe_widget');
	
}