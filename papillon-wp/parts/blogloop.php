<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post blog-p'); ?>> 
	<?php
	GLOBAL $webnus_options;
	
	$post_format = get_post_format(get_the_ID());
	
	$content = get_the_content();
	
	
	if( !$post_format ) $post_format = 'standard';
	
	
	if(  $webnus_options->webnus_blog_featuredimage_enable() ){
	
		global $featured_video;
		
		$meta_video = !empty($featured_video)?$featured_video->the_meta():null;
		
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
				
				$ids = (shortcode_parse_atts($matches[3]));
				
				if(is_array($ids) && isset($ids['ids']))
					$ids = $ids['ids'];
				echo do_shortcode('[vc_gallery onclick="link_no" img_size= "full" type="flexslider_fade" interval="3" images="'.$ids.'"  custom_links_target="_self" el_class="blog-featured"]');
				$content = preg_replace('/'.$pattern.'/s', '', $content);
			}
				
	
			
			
		}else
		
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

	
	
	  <?php
	  
	   if(  $webnus_options->webnus_blog_posttitle_enable() ) { 
	  
	   if( ('aside' != $post_format ) && ('quote' != $post_format)  ) { 	
	  	
		if( 'link' == $post_format )
		{ 
		
		
		 preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $content,$matches);
		 $content = preg_replace('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i','', $content,1);
		 $link ='';
		 
		 if(isset($matches) && is_array($matches))
		 	$link = $matches[0];
			
		?>
			<h3><a href="<?php echo $link; ?>">
			 <?php the_title(); ?>
			</a></h3>
		<?php
		
		}else{
	  ?>
	  <h3 class="blog-p-title"><a href="<?php the_permalink(); ?>">
	  	  <?php the_title(); ?>
		</a></h3>
	  <?php } } } ?>

		  <div class="blog-p-meta">
			<?php if( 1 == $webnus_options->webnus_blog_meta_date_enable() ) { ?>
			<span class="blog-date"> <i class="fa-clock-o"></i><?php the_time('M d, Y') ?> </span>
			<?php } ?>
			
			<?php if( 1 == $webnus_options->webnus_blog_meta_author_enable() ) { ?>	
			<span class="blog-author"> <i class="fa-pencil"></i><?php _e('by ','WEBNUS_TEXT_DOMAIN'); ?><?php the_author_posts_link(); ?> </span>
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
	  
	  if( 0 == $webnus_options->webnus_blog_excerptfull_enable()  )
		{
			if( 'quote' == $post_format  ) echo '<blockquote>';
			echo '<p>';
			echo get_the_excerpt();
			echo '</p>';
			if( 'quote' == $post_format  ) echo '</blockquote>';
		} 
	  else
	  	{
			if( 'quote' == $post_format  ) echo '<blockquote>';
			echo apply_filters('the_content',$content);
			if( 'quote' == $post_format  ) echo '</blockquote>';
		}
	  ?>
	  </div>
	<hr class="vertical-space1">
</article>