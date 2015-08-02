<?php



load_theme_textdomain('WEBNUS_TEXT_DOMAIN', get_template_directory().'/languages');


class webnus_description_walker extends Walker_Nav_Menu
{


	
	function start_el(&$output, $item, $depth=0, $args=array(),$current_object_id=0)
	{
		

		$this->curItem = $item;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since 3.0.0
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of arguments. @see wp_nav_menu()
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since 3.0.1
		 *
		 * @param string The ID that is applied to the menu item's <li>.
		 * @param object $item The current menu item.
		 * @param array $args An array of arguments. @see wp_nav_menu()
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		
		$is_mega_menu = '';
		
		if('page'  == $item->object)
		{
			$post_obj = get_post( $item->object_id, 'OBJECT' );
			
			$is_mega = get_post_meta($item->object_id,'_is_mega_menu',true);
			
			if(!empty($is_mega) && $is_mega['is_mega_menu'] == 'yes')
						$is_mega_menu .= ' mega ';
		}
		
		
		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since 3.6.0
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 *     @type string $title  The title attribute.
		 *     @type string $target The target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item The current menu item.
		 * @param array  $args An array of arguments. @see wp_nav_menu()
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		$item_output = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		if('page'  == $item->object)
		{
			$post_obj = get_post( $item->object_id, 'OBJECT' );
			
			$is_mega = get_post_meta($item->object_id,'_is_mega_menu',true);
			
			if(!empty($is_mega) && $is_mega['is_mega_menu'] == 'yes')
						$item_output .= do_shortcode($post_obj->post_content);
			else
			{
				$item_output .= $args->before;
				/** colorize categories in menu */
				$color ='';
				if ($item->object == 'category'){
					$cat_data = get_option("category_$item->object_id");
					$color = (!empty($cat_data['catBG']))?'style="color:'. $cat_data['catBG'] .'"':'';
				}

				$item_output .= '<a '. $color . $attributes. ' data-description="' .$item->description .'">';
				/** This filter is documented in wp-includes/post-template.php */
				if(!empty($item->icon))
				$item_output .= '<i class="'.$item->icon.'"></i>';
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= '</a>';
				$item_output .= $args->after;
			}
		}
		else{
		$item_output .= $args->before;
		$item_output .= '<a '. $attributes. ' data-description="' .$item->description .'">';
		/** This filter is documented in wp-includes/post-template.php */
		if(!empty($item->icon))
		$item_output .= '<i class="'.$item->icon.'"></i>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		}
		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes $args->before, the opening <a>,
		 * the menu item's title, the closing </a>, and $args->after. Currently, there is
		 * no filter for modifying the opening and closing <li> for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of arguments. @see wp_nav_menu()
		 */
		 
		 			if ( $depth == 0 && $item->object == 'category' && $item->classes['0'] == "mega" ) {
				$item_output .= '<ul class="sub-posts">';			
					global $post;
					$menuposts = get_posts( array( 'posts_per_page' => 3, 'category' => $item->object_id ) );
					foreach( $menuposts as $post ):
						$post_title = get_the_title();
						$post_link = get_permalink();
						$post_time = get_the_time('d M Y');
						$post_comments = get_comments_number();
						$post_views = getViews(get_the_ID());
						
						$post_image = wp_get_attachment_image_src( get_post_thumbnail_id(), "home_lfb" );
						if ( $post_image != ''){
							$menu_post_image = '<img src="' . $post_image[0]. '" alt="' . $post_title . '" width="' . $post_image[1]. '" height="' . $post_image[2]. '" />';
						} else {
							$menu_post_image = __( 'No image','WEBNUS_TEXTDOMAIN');
						}
						$item_output .= '
								<li>
									<figure>
										<a href="'  .$post_link . '">' . $menu_post_image . '</a>
									</figure>
									<a href="' . $post_link . '">' . $post_title . '</a>
									<div class="sub-meta">
									<i class="fa-clock-o"></i> <span>' . $post_time . '</span> <i class="fa-eye"></i> <span>'. $post_views.'</span> <i class="fa-comment-o"></i> <span>' . $post_comments . '</span>
									</div>
								</li>';
					endforeach;
					wp_reset_postdata();
				$item_output .= '</ul>';
			}
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );	
	}
}

include_once('inc/init.php');
include_once get_template_directory(). '/inc/visualcomposer/init.php';


$webnus_options = new webnus_options();


/******************************/
/*
/*		Theme Customization
/*
/******************************/
add_theme_support( 'woocommerce' );
add_theme_support('post-thumbnails');

//add_filter('show_admin_bar', '__return_false');
add_filter('excerpt_length', 'webnus_excerpt_length', 999);
add_filter('widget_text', 'do_shortcode');



function webnus_excerpt_length($len) {
    GLOBAL $webnus_options;
    return $webnus_options->webnus_blog_excerpt_len();
}


function webnus_excerpt_more($more) {
    global $post, $webnus_options;
    
    return '... <br><br><a class="readmore" href="' . get_permalink($post->ID) . '">' . $webnus_options->webnus_blog_readmore_text() . '</a>';
}

add_filter('excerpt_more', 'webnus_excerpt_more');



function webnus_limit_content($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

/******************************/
/*
/*		Register Menus
/*
/******************************/
function webnus_register_menus() {
    register_nav_menus(
            array(
                'header-menu' => __('Header Menu', 'WEBNUS_TEXTDOMAIN'),
				'duplex-menu-left' => __('Duplex Menu - Left', 'WEBNUS_TEXTDOMAIN'),
				'duplex-menu-right' => __('Duplex Menu - Right', 'WEBNUS_TEXTDOMAIN'),
                'footer-menu' => __('Footer Menu', 'WEBNUS_TEXTDOMAIN'),
                'header-top-menu' => __('Topbar Menu', 'WEBNUS_TEXTDOMAIN'),
				'leftnav-menu' => __('Left-Nav Menu', 'WEBNUS_TEXTDOMAIN'),
				'onepage-header-menu' => __('Onepage Header Menu', 'WEBNUS_TEXTDOMAIN'),
				
            )
    );
	
}

add_action('init', 'webnus_register_menus');

/******************************/
/*
/*		Header Assets
/*
/******************************/

include_once get_template_directory() . '/inc/dynamicfiles/dynjs.php';
include_once get_template_directory() . '/inc/dynamicfiles/dyncss.php';


function webnus_script_loader(){
	
	GLOBAL $webnus_options;
	
	/***************************************/
	/*			Main style.css
	/***************************************/
	
	wp_register_style( 'main-style', get_stylesheet_uri() );
	wp_enqueue_style('main-style');
	

	
	/***************************************/
	/*			Google fonts
	/***************************************/
	
	
	
	wp_register_style( 'google_fonts_css', $webnus_options->webnus_get_google_fonts() );
	wp_enqueue_style('google_fonts_css');
	
	
	
	/***************************************/
	/*			Dynamic Css dyncss.php
	/***************************************/
	
	
	
	wp_register_style( 'dynamic_css', get_template_directory_uri() .'/css/dyncss.css' );
	wp_enqueue_style('dynamic_css');
	
	wp_enqueue_script(
            'dynamic-js', get_template_directory_uri() . '>/js/dynjs.js', null, null, true
    );
	
	
	
	/***************************************/
	/*			Default Google Font
	/***************************************/
	

	$protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'gfont-style', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700,800%7CMerriweather:300,400,700" );
	
	
	/***************************************/
	/*			Comment Reply JS
	/***************************************/

	
	
	if ( is_singular() && $webnus_options->webnus_allow_comments_on_page() )
		wp_enqueue_script( 'comment-reply' );
	
	/***************************************/
	/*			flex & prettyphoto
	/***************************************/
	
	wp_register_style( 'flexslider', get_template_directory_uri() .'/css/flexslider.css' );
	wp_enqueue_style('flexslider');
		
	wp_register_style( 'prettyphoto', get_template_directory_uri() .'/css/prettyPhoto.css' );
	wp_enqueue_style('prettyphoto');	
}
add_action('wp_enqueue_scripts', 'webnus_script_loader');


/******************************/
/*
/*		Footer Assets
/*
/******************************/

function webnus_footer_script_loader(){
	wp_enqueue_script(
            'doubletab', get_template_directory_uri() . '>/js/jquery.plugins.js', null, null, true
    );
    wp_enqueue_script(
            'mediaelement', get_template_directory_uri() . '/js/mediaelement-and-player.min.js', null, null, true
    );
	wp_enqueue_script(
			'msaonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', null, null, true
	);
	wp_enqueue_script(
			'ticker', get_template_directory_uri() . '/js/jquery.ticker.js', null, null, true
	);
    wp_enqueue_script(
            'custom_script', get_template_directory_uri() . '/js/papillon-custom.js', null, null, true
    );

}

add_action('wp_enqueue_scripts', 'webnus_footer_script_loader');



/******************************/
/*
/*		Filters wp_title
/*
/******************************/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_inactive('all-in-one-seo-pack/all_in_one_seo_pack.php') && is_plugin_inactive('wordpress-seo/wp-seo.php')){
	 
function theme_name_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	// Add the blog name
	$title .= esc_attr(get_bloginfo( 'name', 'display' ));

	// Add the blog description for the home/front page.
	$site_description = esc_attr(get_bloginfo( 'description', 'display' ));
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'WEBNUS_TEXT_DOMAIN' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'theme_name_wp_title', 10, 2 );

}

/******************************/
/*
/*		Add Tracking Code Hook
/*
/******************************/

/***************************************/
/*			Page Background 
/***************************************/
function webnus_page_background_override(){

GLOBAL $webnus_page_options_meta;

$meta = $webnus_page_options_meta->the_meta();


if(!empty( $meta )){


	$bgcolor =  isset($meta['webnus_page_options'][0]['background_color'])?$meta['webnus_page_options'][0]['background_color']:null;
	$bgimage =  isset($meta['webnus_page_options'][0]['the_page_bg'])?$meta['webnus_page_options'][0]['the_page_bg']:null;
	$bgpercent =  isset($meta['webnus_page_options'][0]['bg_image_100'])?$meta['webnus_page_options'][0]['bg_image_100']:null;
	$bgrepeat =  isset($meta['webnus_page_options'][0]['bg_image_repeat'])?$meta['webnus_page_options'][0]['bg_image_repeat']:null;
			
			$out = "";
		
			$out .= '<style type="text/css" media="screen">';
			
			$out .='body{ ';
					
				if(!empty($bgcolor)){
					$out .= "background-image:url('');background-color:{$bgcolor};";
				}
				if(!empty($bgimage))
				{
					if($bgrepeat == 1)
						$out .=  " background-image:url('{$bgimage}'); background-repeat:repeat;";
					else if($bgrepeat==2)
						$out .=  " background-image:url('{$bgimage}'); background-repeat:repeat-x;";
					else if($bgrepeat==3)
						$out .=  " background-image:url('{$bgimage}'); background-repeat:repeat-y;";
					else if($bgrepeat==0)
					{
						if($bgpercent)
							$out .=  " background-image:url('{$bgimage}'); background-repeat:no-repeat; background-size:100% auto; ";
						else
							$out .=  " background-image:url('{$bgimage}'); background-repeat:no-repeat; ";
							
					}
				}
		
			
			if($bgpercent == 'yes' && !empty($bgimage)) 
			$out .= 'background-size:cover;-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover; background-attachment:fixed;
					background-position:center; ';
			$out .= ' } </style>';

			
	echo $out;

/***************************************/
/*			End Page Background 
/***************************************/
}

}




function webnus_wphead_action(){
	
	GLOBAL $webnus_options;
	global $post;
	
	echo $webnus_options->webnus_background_image_style();
	echo $webnus_options->webnus_tracking_code();
	echo $webnus_options->webnus_space_before_head();
	$w_adobe_typekit = ltrim ($webnus_options->webnus_typekit_id());
    if(isset($w_adobe_typekit ) && !empty($w_adobe_typekit ))
        echo '<script src="//use.typekit.net/'.$w_adobe_typekit.'.js"></script><script>try{Typekit.load();}catch(e){}</script>';

	if(!is_404() && isset($post))
		webnus_page_background_override(); // referred to up
}

add_action('wp_head', 'webnus_wphead_action');


/***************************************/
/*			Login
/***************************************/

function webnus_login() {
	global $user_ID, $user_identity, $user_level;
	function webnus_logout_redirect($logouturl, $redir){
        return $logouturl . '&amp;redirect_to=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
	add_filter('logout_url', 'webnus_logout_redirect', 10, 2);;
	if ($user_ID) : ?>
		<div id="user-logged">
			<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '60'); ?></span>
			<div class="user-welcome"><?php _e('Welcome','WEBNUS_TEXT_DOMAIN'); ?> <strong><?php echo $user_identity ?></strong></div>
			<ul class="logged-links">
				<li><a href="<?php echo home_url() ?>/wp-admin/"><?php _e('Dashboard','WEBNUS_TEXT_DOMAIN'); ?> </a></li>
				<li><a href="<?php echo home_url() ?>/wp-admin/profile.php"><?php _e('My Profile','WEBNUS_TEXT_DOMAIN'); ?> </a></li>
				<li><a href="<?php echo wp_logout_url(); ?>"><?php _e('Logout','WEBNUS_TEXT_DOMAIN'); ?> </a></li>	
			</ul>
			<div class="clear"></div>
		</div>
	<?php else: ?>
		<div id="user-login">
			<form name="loginform" id="loginform" action="<?php echo home_url() ?>/wp-login.php" method="post">
				<p id="login-user"><input type="text" name="log" id="log" value="<?php _e('Username','WEBNUS_TEXT_DOMAIN'); ?>" onfocus="if (this.value == '<?php _e('Username','WEBNUS_TEXT_DOMAIN'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Username','WEBNUS_TEXT_DOMAIN'); ?>';}"  size="33" /></p>
				<p id="login-pass"><input type="password" name="pwd" id="pwd" value="<?php _e('Password','WEBNUS_TEXT_DOMAIN'); ?>" onfocus="if (this.value == '<?php _e('Password','WEBNUS_TEXT_DOMAIN'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Password','WEBNUS_TEXT_DOMAIN'); ?>';}" size="33" /></p>
				<input type="submit" name="submit" value="<?php _e('Log in' ) ?>" class="login-button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _e('Remember Me','WEBNUS_TEXT_DOMAIN'); ?></label>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
			<ul class="login-links">
				<?php if ( get_option('users_can_register') ) : ?><?php echo wp_register() ?><?php endif; ?>
				<li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword"><?php _e('Lost your password?','WEBNUS_TEXT_DOMAIN'); ?></a></li>
			</ul>
		</div>
	<?php endif;
}

/******************************/
/*
/*		Add Color Picker
/*
/******************************/

add_action( 'admin_enqueue_scripts', 'webnus_enqueue_color_picker' );
function webnus_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-core' ,null,null,null,false);
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'my-script-handle', get_template_directory_uri().'/inc/nc-options/color.js', array( 'wp-color-picker' ), false, true );
}


add_action('admin_enqueue_scripts', 'webnus_base64_include_js');

function webnus_base64_include_js(){
	
	
	
    wp_enqueue_script(
            'base64', get_template_directory_uri() . '/js/base64.js', null, null, true
    );
}

/******************************/
/*
/*		Custom Admin Logo
/*
/******************************/

function webnus_custom_login_logo() {
    GLOBAL $webnus_options;
    $logo = $webnus_options->webnus_admin_login_logo();
    if(isset($logo) && !empty($logo))
    {
        echo '<style type="text/css">'.
             'h1 a { background-image:url('.$logo.') !important; }'.
         '</style>';
    }
}
add_action( 'login_head', 'webnus_custom_login_logo' );

/******************************/
/*
/*		Images Size
/*
/******************************/

$portfolio_image_width = $webnus_options->webnus_portfolio_image_width();
$portfolio_image_height = $webnus_options->webnus_portfolio_image_height();

add_image_size("portfolio_full", $portfolio_image_width, $portfolio_image_height, true);

// Theme Thumbs
add_image_size("home_lfb", 720 ,406, true);
add_image_size("blog2_thumb", 420,390, true);
add_image_size("lfb_thumb", 140,110, true);
add_image_size("latestfromblog", 720,388, true);
add_image_size("blog_timeline",380,302, true);
add_image_size("portfolio_thumb",720,549, true);
add_image_size("tabs-img", 100, 100, true);
add_image_size("latest-cover", 680, 395, true);

/*
 *ICONFONTS SCRIPT AND CSS ADDED 
 */
add_action( 'admin_enqueue_scripts', 'webnus_iconfonts_enqueue' );
function webnus_iconfonts_enqueue( $hook_suffix ) {
    	
   wp_enqueue_style(
            'iconfonts-style', get_template_directory_uri() . '/inc/iconfonts/style.css', null, null
    );
  wp_enqueue_style(
            'iconfonts-style-gen', get_template_directory_uri() . '/inc/iconfonts/custom.css', null, null
   );
 
}


if (!isset($content_width))
    $content_width = 940;

if (false)
    wp_link_pages(); 
if(false){
    posts_nav_link();
    paginate_links();
    the_tags();
    get_post_format(0);
}

if (function_exists('add_theme_support')) {
    add_theme_support('automatic-feed-links');	
    add_theme_support( 'post-formats', array( 'aside','gallery', 'link', 'quote','image','video','audio' ) );
}


/*
OneClick xml importer
*/


if(isset($_POST['webnus_oneclick_importer_all']))
{
add_action('admin_menu', 'webnus_include_all_demo_at_page_loaded');
}
function webnus_include_all_demo_at_page_loaded(){
}




if(isset($_POST['webnus_oneclick_importer_page']))
{
add_action('admin_init', 'webnus_include_page_demo_at_page_loaded');
}
function webnus_include_page_demo_at_page_loaded(){ 
	ob_start();
    if ( ! class_exists( 'WP_Import' ) )
    	include_once get_template_directory() . "/inc/plugins/wordpress-importer/wordpress-importer.php";
    $myimporter = new WP_Import();
    $myimporter->import(get_template_directory() . '/inc/dummy-data/dummy2.xml');
	ob_end_clean();
}


if(isset($_POST['webnus_oneclick_importer_templatera']))
{
add_action('admin_init', 'webnus_include_templatera_demo_at_page_loaded');
}
function webnus_include_templatera_demo_at_page_loaded(){	
    ob_start();
    if ( ! class_exists( 'WP_Import' ) )
    	include_once get_template_directory() . "/inc/plugins/wordpress-importer/wordpress-importer.php";
    $myimporter = new WP_Import();
    $myimporter->import(get_template_directory() . '/inc/dummy-data/dummy3.xml');
	ob_end_clean();
}


if(isset($_POST['webnus_oneclick_setup_reading']))
{
add_action('admin_init', 'webnus_setup_default_reading_settings');
}


function webnus_setup_default_reading_settings()
{
	$home = get_page_by_title( 'Home 1 – Business' );
	if(!empty($home))
	{
		update_option( 'page_on_front', $home->ID );
		update_option( 'show_on_front', 'page' );
	}
// Set the blog page
	$blog   = get_page_by_title( 'Blog' );
	if(!empty($blog))
	{
		update_option( 'page_for_posts', $blog->ID );
	}
}

/*
 * Add Topbar Menu link to Theme option
 * 
 */

function add_webnus_admin_bar_link() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	$wp_admin_bar->add_menu( array(
	'id' => 'webnus_themeoption_link',
	'title' => __( 'Webnus Theme Option','WEBNUS_TEXT_DOMAIN'),
	'href' => site_url().'/wp-admin/themes.php?page=webnus_theme_options',
	) );
}
add_action('admin_bar_menu', 'add_webnus_admin_bar_link',25);






/*
Woocommerce js error hack
*/


add_action( 'wp_enqueue_scripts', 'webnus_custom_frontend_scripts' );

function webnus_custom_frontend_scripts() {

		if (class_exists('Woocommerce')) {
		global $post, $woocommerce;

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		if(file_exists($woocommerce->plugin_path() . '/assets/js/jquery-cookie/jquery.cookie'.$suffix.'.js'))
		{
			rename($woocommerce->plugin_path() . '/assets/js/jquery-cookie/jquery.cookie'.$suffix.'.js', $woocommerce->plugin_path() . '/assets/js/jquery-cookie/jquery_cookie'.$suffix.'.js');
			
			
		}
		wp_deregister_script( 'jquery-cookie' ); 
		wp_register_script( 'jquery-cookie', $woocommerce->plugin_url() . '/assets/js/jquery-cookie/jquery_cookie'.$suffix.'.js', array( 'jquery' ), '1.3.1', true );
}
}



add_action('print_media_templates', 'webnus_print_media_templates'); 

function webnus_print_media_templates(){

  // define your backbone template;
  // the "tmpl-" prefix is required,
  // and your input field should have a data-setting attribute
  // matching the shortcode name
  ?>
  <script type="text/html" id="tmpl-my-custom-gallery-setting">
    <label class="setting">
      <span><?php _e('Gallery Type','WEBNUS_TEXT_DOMAIN'); ?></span>
      <select data-setting="webnus_gallery_type">
        <option value="normal"> Normal </option>
        <option value="slider"> Slider </option>
 
      </select>
    </label>
  </script>

  <script>

    jQuery(document).ready(function(){

      // add your shortcode attribute and its default value to the
      // gallery settings list; $.extend should work as well...
      _.extend(wp.media.gallery.defaults, {
        my_custom_attr: 'default_val'
      });

      // merge default gallery settings template with yours
      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          return wp.media.template('gallery-settings')(view)
               + wp.media.template('my-custom-gallery-setting')(view);
        }
      });

    });

  </script>
  <?php

};


function setViews($postID) {
    $count_key = 'webnus_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
    return $count; /* so you can show it */
}
function getViews($postID) {
    $count_key = 'webnus_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
	}
    return $count; /* so you can show it */
}

if(function_exists('vc_set_as_theme'))
{
	add_action('init','webnus_set_vc_as_theme');
}

function webnus_set_vc_as_theme()
{
	
	vc_set_as_theme($notifier = false);
	
}
	



/*
 * MIMETYPE fonts
 * 
 */

 
add_filter('upload_mimes', 'webnus_custom_font_mimes');
function webnus_custom_font_mimes ( $existing_mimes=array() ) {
 
$existing_mimes['woff'] = 'application/x-font-woff';
$existing_mimes['ttf'] = 'application/x-font-ttf';
$existing_mimes['eot'] = 'application/vnd.ms-fontobject"';
$existing_mimes['svg'] = 'image/svg+xml"';

 return $existing_mimes;
}


/*
 * Function that validates a field's length.
 * 
 */
if ( ! function_exists( 'webnus_validate_length' ) ) {
	function webnus_validate_length( $fieldValue, $minLength ) {
		// First, remove trailing and leading whitespace
		return ( strlen( trim( $fieldValue ) ) > $minLength );
	}
}

?>