<?php

get_header();
GLOBAL $webnus_options;
?>
    <div class="container">
	<section id="headline">
      <h3><?php
					if ( is_day() ) :
						printf('<small>'. __( 'Daily Archives', 'WEBNUS_TEXT_DOMAIN' ) . ':</small> %s', get_the_date() );
					elseif ( is_month() ) :
						printf('<small>'. __( 'Monthly Archives', 'WEBNUS_TEXT_DOMAIN' ) . ':</small> %s', get_the_date( _x( 'F Y', 'monthly archives date format', 'WEBNUS_TEXT_DOMAIN' ) ) );
					elseif ( is_year() ) :
						printf('<small>'. __( 'Yearly Archives', 'WEBNUS_TEXT_DOMAIN' ) .':</small> %s', get_the_date( _x( 'Y', 'yearly archives date format', 'WEBNUS_TEXT_DOMAIN' ) ) );
						
					elseif ( is_category() ):
						printf(  '%s', single_cat_title( '', false ) );
					elseif ( is_tag() ):
						printf('<small>'. __( 'Tag', 'WEBNUS_TEXT_DOMAIN' ) .':</small> %s', single_tag_title( '', false ) );

					else :
						echo $webnus_options->webnus_blog_page_title();
					endif;
				?></h3>
	</section>
    </div>
  

    <section class="container" ><div class="row">
    <hr class="vertical-space2">
	<?php 
	if( 'left' == $webnus_options->webnus_blog_sidebar() || 'both' == $webnus_options->webnus_blog_sidebar() ): 
		get_sidebar('bleft');
	endif;
	?>
	<!-- begin-main-content -->
    <section class="<?php echo ( 'both' == $webnus_options->webnus_blog_sidebar() )? 'col-md-6 cntt-w':'col-md-9 cntt-w'?>">
     <?php
 	 if(have_posts()):
		while( have_posts() ): the_post();
			
			if( 'both' == $webnus_options->webnus_blog_sidebar() )
			{
				get_template_part('parts/blogloop','bothsidebar');
			}
			else{
				get_template_part('parts/blogloop');
			}
		endwhile;
	 else:
		get_template_part('blogloop-none');
	 endif;
	
	 ?>
       
      <br class="clear">
   
	  <?php 
		if(function_exists('wp_pagenavi'))
		{
			wp_pagenavi();
		}
	  ?>
      <div class="vertical-space3"></div>
    </section>
    <!-- end-main-content -->
	<?php 
	if( 'right' == $webnus_options->webnus_blog_sidebar() || 'both' == $webnus_options->webnus_blog_sidebar() ): 
		get_sidebar('bright');
	endif;
	?>
    <div class="vertical-space"></div></div>
  </section>
  </section>
  <?php 
  get_footer();
  ?>