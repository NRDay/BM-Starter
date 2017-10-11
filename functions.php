<?php
/**
 * BM Starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BM_Starter
 */

/**DEV MODE
 *If is set to true then CSS and JS will load from minimized versions
 */
if (! defined('DEV_MODE')) {
	define( 'DEV_MODE', false );
}

if ( ! function_exists( 'bm_starter_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bm_starter_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on BM Starter, use a find and replace
		 * to change 'bm-starter' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bm-starter', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'bm-starter' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bm_starter_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'bm_starter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bm_starter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bm_starter_content_width', 640 );
}
add_action( 'after_setup_theme', 'bm_starter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bm_starter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bm-starter' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bm-starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bm_starter_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bm_starter_scripts() {

	//LOAD STYLES
	if (defined('DEV_MODE') && true === DEV_MODE) : 
		//IF IN DEV MODE LOAD UNMINIFIED STYLES
		wp_enqueue_style( 'bm-vendor-styles', get_template_directory_uri() . '/assets/css/vendors.css');
		wp_enqueue_style( 'bm-starter-style', get_stylesheet_uri() );
	else : 
		//IF NOT IN DEV MODE LOAD MINIFIED THEME STYLES
		wp_enqueue_style( 'bm-vendor-styles', get_template_directory_uri() . '/assets/css/vendors.min.css');
		wp_enqueue_style( 'bm-starter-style.min', get_template_directory_uri() . '/style.min.css' );
	endif;

	//LOAD SCRIPTS
	wp_enqueue_script( 'modernizr.js', get_template_directory_uri() . '/assets/js/modernizr.min.js', array(), '5.5.2.5', false );

	if (defined('DEV_MODE') && true === DEV_MODE) : 
	//IF IN DEV MODE LOAD UNMINIFIED SCRIPTS
	wp_enqueue_script( 'vendor-scripts', get_template_directory_uri() . '/assets/js/vendors.js', array('jquery'), '1.01', true );
	wp_enqueue_script( 'theme', get_template_directory_uri() . '/assets/js/theme.js', array('vendor-scripts'), '1.01', true );
	else : 
	//IF NOT IN DEV MODE LOAD MINIFIED SCRIPTS
	wp_enqueue_script( 'vendor-scripts.min', get_template_directory_uri() . '/assets/js/vendors.min.js', array('jquery'), '1.01', true );
	wp_enqueue_script( 'theme.min', get_template_directory_uri() . '/assets/js/theme.min.js', array('vendor-scripts.min'), '1.01', true );
	endif;

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'bm_starter_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
