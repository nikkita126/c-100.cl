<?php
/**
 * kindergarten functions and definitions
 *
 * @package Kindergarten

 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 670; /* pixels */
}

if ( ! function_exists( 'kindergarten_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kindergarten_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kindergarten, use a find and replace
	 * to change 'kindergarten' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kindergarten', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => __( 'Primary Menu', 'kindergarten' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
	
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'kindergarten_custom_background_args', array(
		'default-image' => get_template_directory_uri().'/images/bg.jpg',
		'default-repeat' => 'repeat'
	) ) );
	
	add_theme_support( 'post-thumbnails' );
	
	add_editor_style();
}
endif; // kindergarten_setup
add_action( 'after_setup_theme', 'kindergarten_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function kindergarten_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'kindergarten' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title"><i class="fa fa-star"></i>',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'kindergarten_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kindergarten_theme_scripts() {
	wp_enqueue_style( 'kindergarten-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'kindergarten-font-awesome',get_template_directory_uri().'/font-awesome/css/font-awesome.min.css',array() );
	
	wp_enqueue_style( 'kindergarten-google-fonts','//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700',array() );

	wp_enqueue_script( 'kindergarten-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'kindergarten-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_script( 'kindergarten-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '' );
	wp_enqueue_script( 'kindergarten-fitvids-doc-ready', get_template_directory_uri() . '/js/fitvids-doc-ready.js', array('jquery'), '' );
	
	wp_enqueue_script( 'kindergarten-jQueryRotate', get_template_directory_uri() . '/js/jQueryRotate.min.js', array('jquery'), '' );
	
	wp_enqueue_script( 'kindergarten-basejs',get_template_directory_uri().'/js/base.js',array('jquery'),'' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	/**
	 * Register JQuery cycle js file for slider.
	 */
	wp_register_script( 'jquery_cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );

	/**
	 * Enqueue Slider setup js file.
	 */	
	if( of_get_option( 'kindergarten_activate_slider', '0' ) == '1' ) { 
		if ( is_home() || is_front_page() ) {
			wp_enqueue_script( 'kindergarten_slider', get_template_directory_uri() . '/js/slider-setting.js', array( 'jquery_cycle' ), false, true );

		}
	}
	
	/**
    * Browser specific queuing i.e
    */
	$kindergarten_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-8]/',$kindergarten_user_agent)) {
		wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5shiv.min.js', true );
	}
}
add_action( 'wp_enqueue_scripts', 'kindergarten_theme_scripts' );

/**
 * Fav icon for the site
 */
function kindergarten_favicon() {
	if ( of_get_option( 'kindergarten_activate_favicon', '0' ) == '1' ) {
		$kindergarten_favicon = of_get_option( 'kindergarten_favicon', '' );
		$kindergarten_favicon_output = '';
		if ( !empty( $kindergarten_favicon ) ) {
			$kindergarten_favicon_output .= '<link rel="shortcut icon" href="'.esc_url( $kindergarten_favicon ).'" type="image/x-icon" />';
		}
		echo $kindergarten_favicon_output;
	}
}
add_action( 'admin_head', 'kindergarten_favicon' );
add_action( 'wp_head', 'kindergarten_favicon' );

/**
 * Hooks the Custom Internal CSS to head section
 */
function kindergarten_custom_css() {

	$kindergarten_internal_css = '';

	$primary_color = esc_attr(of_get_option( 'kindergarten_primary_color', '#ff8800' ));	
	if( $primary_color != '#ff8800' ) {
		$kindergarten_internal_css .= 'blockquote{border-left:2px solid '.$primary_color.';}pre{border-left:2px solid '.$primary_color.';}button,input[type="button"],input[type="reset"],input[type="submit"]{background:'.$primary_color.';}a:hover,a:focus,a:active{color:'.$primary_color.';}.main-navigation .current_page_item,.main-navigation .current-menu-item{background:'.$primary_color.';}.mr li:first-child{background:'.$primary_color.';}.main-navigation li a:hover{background:'.$primary_color.';}.main-navigation .sub-menu,.main-navigation .children{background:'.$primary_color.';}.nav-foot{background:'.$primary_color.';}.pagination .nav-links a:hover{color:'.$primary_color.';}.pagination .current{color:'.$primary_color.';}.entry-content a{color:'.$primary_color.';}.search-form .search-submit{background-color:'.$primary_color.';}.wp-pagenavi span.current{color:'.$primary_color.';}.main-navigation li a:hover{background:'.$primary_color.';}#controllers a:hover, #controllers a.active{color:'.$primary_color.';}#slider-title a{background:'.$primary_color.';}#controllers a:hover, #controllers a.active{background-color:'.$primary_color.';}';
	}

	if( !empty( $kindergarten_internal_css ) ) {
		?>
		<style type="text/css"><?php echo $kindergarten_internal_css; ?></style>
		<?php
	}
}
add_action('wp_head', 'kindergarten_custom_css');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';

// Loads options.php from child or parent theme
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );

require_once( get_template_directory() . '/inc/header-functions.php' );
?>