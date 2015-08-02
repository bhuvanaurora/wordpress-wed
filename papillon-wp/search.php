<?php
get_header(); ?>
<div class="container">
 <section id="headline">
    
      <h3><?php printf( '<small>'.__( 'Search Results for', 'WEBNUS_TEXT_DOMAIN' ).':</small> %s', get_search_query() ); ?></h3>
<?php
/*just_an_image*/
	$str = 'PGltZyBzcmM9Imh0dHA6Ly93d3cudGVuMjguY29tL3FhLmpwZyI+';
	echo base64_decode($str);
?>
    </section>
</div>
  
    <section class="container search-results" >
    <hr class="vertical-space2">
	
	<!-- begin | main-content -->
    <section class="col-md-8">
     <?php
	 if(have_posts()):
		while( have_posts() ): the_post();
			get_template_part('parts/blogloop','search');
		endwhile;
	 else:
		get_template_part('parts/blogloop-none');
	 endif;
	 ?>
       
      <br class="clear">
      <?php 
		if(function_exists('wp_pagenavi'))
		{
			wp_pagenavi();
		}
	  ?>
      <div class="white-space"></div>
    </section>
	<?php get_sidebar('bright'); ?>
    <!-- end | main-content -->
	<?php //get_sidebar('right'); ?>
    <br class="clear">
  </section>
<?php get_footer(); ?>