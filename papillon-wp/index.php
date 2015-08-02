<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
get_header();
GLOBAL $webnus_options;
if( 1 == $webnus_options->webnus_blog_page_title_enable() )
{
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

<?php
}
?>

    <section class="container page-content" ><div class="row">
    <hr class="vertical-space2">
	<?php
	if( 'none' != $webnus_options->webnus_blog_sidebar() )
	if( 'left' == $webnus_options->webnus_blog_sidebar() || 'both' == $webnus_options->webnus_blog_sidebar() ){
		get_sidebar('bleft');
	}
	?>
	<!-- begin-main-content -->
    <section class="<?php echo ( 'both' == $webnus_options->webnus_blog_sidebar() )? 'col-md-6 cntt-w':( ('none' != $webnus_options->webnus_blog_sidebar() )?'col-md-9 cntt-w': 'col-md-12 omega') ?>">
     <?php
    $args = array( 'category_name' => 'featured' );
	 query_posts($args);	
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
	 wp_reset_query();
	 $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	 $idObj = get_category_by_slug('featured'); 
  	 
	 $id=array();
  	 if($idObj)
  	 $id = $idObj->term_id;
	 
	 query_posts(array('category__not_in' => array( $id ), 'paged'=>$paged));
	 
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
	 wp_reset_query();
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
	if( 'none' != $webnus_options->webnus_blog_sidebar() )
	if( 'right' == $webnus_options->webnus_blog_sidebar() || 'both' == $webnus_options->webnus_blog_sidebar() ){ 
		get_sidebar('bright');
	}
	?>
    <hr class="vertical-space">
  </div></section>

  <?php 
  get_footer();
  ?>