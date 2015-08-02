 <?php
/******************/
/**  Single Post
/******************/

get_header();
if (is_single()){
		global $blogpost_meta;
		$post_meta = $blogpost_meta->the_meta();
			if(!empty($post_meta)){
				if($post_meta['style_type']=="postshow1" && $thumbnail_id = get_post_thumbnail_id()){
					$background = wp_get_attachment_image_src( $thumbnail_id, 'full' );
?>
					<div class="postshow1" style="background-image: url(<?php echo $background[0]; ?> );">
						<div class="postshow-overlay"></div>
						<div class="container"><h1 class="post-title-ps1"><?php the_title() ?></h1></div>
					</div>
<?php }}} ?>
 
 <section class="container page-content" ><div class="row">
    <hr class="vertical-space2">
    <?php 
	if( 'none' != $webnus_options->webnus_blog_singlepost_sidebar() )
	if( 'left' == $webnus_options->webnus_blog_singlepost_sidebar() ){ 
		get_sidebar('bleft');
	}
	?>
	<section class="<?php echo ( 'none' == $webnus_options->webnus_blog_singlepost_sidebar()  )?'col-md-12':'col-md-9 cntt-w'?>">
		<?php if( have_posts() ): while( have_posts() ): the_post();  ?>
      <article <?php post_class('blog-single-post blog-p post'); ?>>
		<?php
			
			setViews(get_the_ID());
			GLOBAL $webnus_options;
			
			
		$post_format = get_post_format(get_the_ID());
	
		$content = get_the_content();
			
			
	if(  $webnus_options->webnus_blog_sinlge_featuredimage_enable() && !isset($background) ){
	
		global $featured_video;
		
		$meta_video = $featured_video->the_meta();
		
		if( 'video'  == $post_format || 'audio'  == $post_format)
		{
			
		$pattern =
		  '\\['                              // Opening bracket
		. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
		. "(video|audio)"                     // 2: Shortcode name
		. '(?![\\w-])'                       // Not followed by word character or hyphen
		. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
		.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
		.     '(?:'
		.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
		.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
		.     ')*?'
		. ')'
		. '(?:'
		.     '(\\/)'                        // 4: Self closing tag ...
		.     '\\]'                          // ... and closing bracket
		. '|'
		.     '\\]'                          // Closing bracket
		.     '(?:'
		.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
		.             '[^\\[]*+'             // Not an opening bracket
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
		.                 '[^\\[]*+'         // Not an opening bracket
		.             ')*+'
		.         ')'
		.         '\\[\\/\\2\\]'             // Closing shortcode tag
		.     ')?'
		. ')'
		. '(\\]?)';  			
		
			
			preg_match('/'.$pattern.'/s', $post->post_content, $matches);
			
			
			if( (is_array($matches)) && (isset($matches[3])) && ( ($matches[2] == 'video') || ('audio'  == $post_format)) && (isset($matches[2])))
			{
				$video = $matches[0];
				
				echo do_shortcode($video);
				
				$content = preg_replace('/'.$pattern.'/s', '', $content);
				
			}else				
			if( (!empty( $meta_video )) && (!empty($meta_video['the_post_video'])) )
			{
				echo do_shortcode($meta_video['the_post_video']);
			}
				
	
			
			
		}else
		if( 'gallery'  == $post_format)
		{
			
						
			$pattern =
		  '\\['                              // Opening bracket
		. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
		. "(gallery)"                     // 2: Shortcode name
		. '(?![\\w-])'                       // Not followed by word character or hyphen
		. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
		.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
		.     '(?:'
		.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
		.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
		.     ')*?'
		. ')'
		. '(?:'
		.     '(\\/)'                        // 4: Self closing tag ...
		.     '\\]'                          // ... and closing bracket
		. '|'
		.     '\\]'                          // Closing bracket
		.     '(?:'
		.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
		.             '[^\\[]*+'             // Not an opening bracket
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
		.                 '[^\\[]*+'         // Not an opening bracket
		.             ')*+'
		.         ')'
		.         '\\[\\/\\2\\]'             // Closing shortcode tag
		.     ')?'
		. ')'
		. '(\\]?)';  			

			preg_match('/'.$pattern.'/s', $post->post_content, $matches);
			
			
			if( (is_array($matches)) && (isset($matches[3])) && ($matches[2] == 'gallery') && (isset($matches[2])))
			{
				
				$atts = shortcode_parse_atts($matches[3]);
				
				$ids = $gallery_type = '';
				
				if(isset($atts['ids']))
				{
					$ids = $atts['ids'];
				}
				if(isset($atts['webnus_gallery_type']))
				{
					$gallery_type = $atts['webnus_gallery_type'];
				}

					echo do_shortcode('[vc_gallery img_size= "full" type="flexslider_fade" interval="3" images="'.$ids.'" onclick="link_image" custom_links_target="_self"]');
				
				$content = preg_replace('/'.$pattern.'/s', '', $content);
			}
				
	
			
			
		}else
		if( (!empty( $meta_video )) && (!empty($meta_video['the_post_video'])) )
		{
			echo do_shortcode($meta_video['the_post_video']);
		}
		else
			get_the_image( array( 'meta_key' => array( 'Full', 'Full' ), 'size' => 'Full', 'image_class'=> 'blog-featured') ); 
	}
			
		?>

	  
	  	<?php if( 1 == $webnus_options->webnus_blog_meta_category_enable() ) { ?>
		<span class="blog-cat"><?php the_category(' / ') ?> </span>
		<?php } ?>
		
		
		<?php if( 1 == $webnus_options->webnus_blog_social_share() ) { ?>	
		<div class="blog-social">
			<a class="facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="blank"><i class="fa-facebook"></i></a>
			<a class="google" href="https://plusone.google.com/_/+1/confirm?hl=en-US&amp;url=<?php the_permalink(); ?>" target="_blank"><i class="fa-google"></i></a>
			<a class="twitter" href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : ''; ?>" target="_blank"><i class="fa-twitter"></i></a>
			<a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>"><i class="fa-linkedin"></i></a>
			<a class="email" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"><i class="fa-envelope"></i></a>
		</div>
		<?php } ?>
		
        <div class="blog-p-detail">
          
           <div class="postmetadata">
		<?php if(!isset($background)) { ?>
		<h1 class="blog-p-title">
	  	  <?php the_title(); ?>
		</h1>
		<?php } ?>
		
		 <div class="blog-p-meta">
			<?php if( 1 == $webnus_options->webnus_blog_meta_date_enable() ) { ?>
			<span class="blog-date"> <i class="fa-clock-o"></i><?php the_time('M d, Y') ?> </span>
			<?php } ?>
			
			<?php if( 1 == $webnus_options->webnus_blog_meta_author_enable() ) { ?>	
			<span class="blog-author"> <i class="fa-user"></i><?php _e('by ','WEBNUS_TEXT_DOMAIN'); ?><?php the_author_posts_link(); ?> </span>
			<?php } ?>
			
			<?php if( 1 == $webnus_options->webnus_blog_meta_views_enable() ) { ?>
			<span class="blog-views"> <i class="fa-eye"></i><?php echo getViews(get_the_ID()); ?> <?php _e('views','WEBNUS_TEXT_DOMAIN'); ?></span>
			<?php } ?>
			
			<?php if( 1 == $webnus_options->webnus_blog_meta_comments_enable() ) { ?>
			<span class="blog-comments"> <i class="fa-comment"></i><?php comments_number(  ); ?> </span>
			<?php } ?>
		  </div>
	
	  </div>

          
         
		
			<?php 
			
			if( 'quote' == $post_format  ) echo '<blockquote>';
			echo apply_filters('the_content',$content); 
			if( 'quote' == $post_format  ) echo '</blockquote>';
			
			?>
		 
          <br class="clear">
		  
		  <?php the_tags( '<div class="post-tags"><i class="fa-tags"></i>', '', '</div>' ); ?>
			 
			 <div class="next-prev-posts">
			 <?php $args = array(
					'before'           => '',
					'after'            => '',
					'link_before'      => '',
					'link_after'       => '',
					'next_or_number'   => 'next',
					'nextpagelink'     => '&nbsp;&nbsp; '.__('Next Page','WEBNUS_TEXT_DOMAIN'),
					'previouspagelink' => __('Previous Page','WEBNUS_TEXT_DOMAIN').'&nbsp;&nbsp;',
					'pagelink'         => '%',
					'echo'             => 1
				); 
				
				 wp_link_pages($args);
			
				 
				?>
			  
			 </div><!-- End next-prev post -->
		
         <?php if( $webnus_options->webnus_blog_single_authorbox_enable() ) { ?>
         <div class="about-author-sec clearfix">		  
	
		  <?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); ?>
		  <h5><?php the_author_posts_link(); ?></h5>
		  <p><?php echo get_the_author_meta( 'description' ); ?></p>
		  

		  
		  </div>
		  <?php  } ?>
        </div>
		<?php 
		
		  ?>
		
      </article>
      <?php 
       endwhile;
		 endif;
      comments_template(); ?>
    </section>
    <!-- end-main-conten -->
    <?php
    if( 'none' != $webnus_options->webnus_blog_singlepost_sidebar() ) 
	if( 'right' == $webnus_options->webnus_blog_singlepost_sidebar() ){
		get_sidebar('bright');
	}
	?>
    <!-- end-sidebar-->
    <div class="white-space"></div></div>
  </section>
  <?php 
  get_footer();
  ?>