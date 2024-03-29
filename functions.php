<?php
/**
 * Austin Ginder functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Austin_Ginder
 */

if ( ! function_exists( 'austinginder_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function austinginder_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Austin Ginder, use a find and replace
		 * to change 'austinginder' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'austinginder', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'austinginder' ),
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
		add_theme_support( 'custom-background', apply_filters( 'austinginder_custom_background_args', array(
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
add_action( 'after_setup_theme', 'austinginder_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function austinginder_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'austinginder_content_width', 640 );
}
add_action( 'after_setup_theme', 'austinginder_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function austinginder_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'austinginder' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'austinginder' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'austinginder_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function austinginder_scripts() {
	wp_enqueue_style( 'roboto-css', "https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900");
	wp_enqueue_style( 'materialdesignicons-css', "https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css");
    wp_enqueue_style( 'vuetify-css', "https://cdn.jsdelivr.net/npm/vuetify@2.0.0-beta.7/dist/vuetify.css");
	wp_enqueue_script( 'vue-js', "https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js");
	wp_enqueue_script( 'vuetify-js', "https://cdn.jsdelivr.net/npm/vuetify@2.0.0-beta.7/dist/vuetify.min.js");
	wp_enqueue_style( 'austinginder-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'austinginder_scripts' );

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
 * Load Parsedown.
 */
require_once get_template_directory() . '/inc/parsedown.php';

/**
 * Load Jetpack compatibility file.
 */
function austinginder_posts() {

	$Parsedown   = new Parsedown();

	// WP_Query arguments
	$args = array (
		'post_type'              => array( 'post'),
		'order'                  => 'DESC',
		'orderby'                => 'date',
		'posts_per_page' 		 => -1,
	);

	$posts = get_posts( $args );
	$posts_formatted = array();
	$previous_post_year = ""; 

	foreach( $posts as $post ) {
		$year = get_the_date( 'Y', $post->ID );
		$month = get_the_date( 'M', $post->ID );
		$content = $GLOBALS['wp_embed']->autoembed( $post->post_content );
		if ( $year != $previous_post_year ) {
			$posts_formated[] = (object) [
				'ID' => "year_{$year}",
				'title' => $year,
				'created_at' => $month,
				'format' => "year",
				'content' => "",
			];
			$new_post_year = false;
		}
		$p = (object) [
			'ID' => $post->ID,
			'title' => get_the_title($post->ID),
			'created_at' => $month,
			'format' => get_post_format($post->ID),
			'content' => $Parsedown->text( $content ),
		];

		$posts_formated[] = $p;
		$previous_post_year = get_the_date( 'Y', $post->ID );
	}

	return json_encode( $posts_formated );

}