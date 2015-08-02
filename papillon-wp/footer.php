<?php 

GLOBAL $webnus_options; 

/***************************************/
/*			Close  head line if woocommerce available
/***************************************/		

if( isset($post) ){
if( 'product' == get_post_type( $post->ID ))
{
echo '</section>';
}
}

?>

<?php
$footer_show = 'true';
if(isset($post))
{
GLOBAL $webnus_page_options_meta;
$footer_show_meta = isset($webnus_page_options_meta)?$webnus_page_options_meta->the_meta():null;
$footer_show =(isset($footer_show_meta) && is_array($footer_show_meta) && isset($footer_show_meta['webnus_page_options'][0]['webnus_footer_show']))?$footer_show_meta['webnus_page_options'][0]['webnus_footer_show']:null;
}

if ($footer_show != 'false') : ?>
	<footer id="footer" <?php if( $webnus_options->webnus_footer_color() == 2 ) echo 'class="litex"';?>>
	
	
	
<?php //start footer bars

if( $webnus_options->webnus_footer_instagram_bar() )
	get_template_part('parts/instagram-bar');
	
if( $webnus_options->webnus_footer_social_bar() )
	get_template_part('parts/social-bar');
	
if( $webnus_options->webnus_footer_subscribe_bar() )
	get_template_part('parts/subscribe-bar');

?>


	<section class="container footer-in">
	<div class="row">
	  <?php 
		
	/***************************************/
	/*			Loading footer type 1,2,3,4,5
	/*			Each footer has it's own behaviour
	/***************************************/		
		
		$footer_type = $webnus_options->webnus_footer_type();
	  
		get_template_part('parts/footer',$footer_type);
			  
	  ?>
	  </div>
	  </section>
	<!-- end-footer-in -->
	<?php 
	if( $webnus_options->webnus_footer_bottom_enable() )
		get_template_part('parts/footer','bottom'); 

	?>
	<!-- end-footbot -->
	</footer>
	<!-- end-footer -->
<?php endif; ?>


<span id="scroll-top"><a class="scrollup"><i class="fa-chevron-up"></i></a></span></div>
<!-- end-wrap -->
<!-- End Document
================================================== -->
<?php

	echo $webnus_options->webnus_space_before_body();
	wp_footer(); 
	
?>
</body>
</html>