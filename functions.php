<?php
/**
 * dukkha functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dukkha
 */

if ( ! function_exists( 'dukkha_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dukkha_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on dukkha, use a find and replace
		 * to change 'dukkha' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'dukkha', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'dukkha' ),
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
		add_theme_support( 'custom-background', apply_filters( 'dukkha_custom_background_args', array(
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
		
		// Add theme support for WooCommerce.
		add_theme_support( 'woocommerce' );
	}
endif;
add_action( 'after_setup_theme', 'dukkha_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dukkha_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dukkha_content_width', 640 );
}
add_action( 'after_setup_theme', 'dukkha_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dukkha_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dukkha' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'dukkha' ),
		'before_widget' => '<section id="%1$s" class="paper widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dukkha_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dukkha_scripts() {
	wp_enqueue_style( 'paper', get_template_directory_uri() . '/css/paper.min.css', array(), '0.3.0' );

	wp_enqueue_style( 'dukkha-style', get_stylesheet_uri() );

	wp_enqueue_script( 'dukkha-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'dukkha-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dukkha_scripts' );

/**
 * Enqueue block editor style
 */
function dukkha_block_editor_styles() {
	wp_enqueue_style( 'dukkha-block-editor-styles', get_theme_file_uri( '/style-editor.css' ), false, '1.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'dukkha_block_editor_styles' );

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

function add_class_to_menu_anchors( $atts ) {
	$atts['class'] = 'paper-btn margin current';

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_class_to_menu_anchors', 10 );

function get_comments_btn() {
	$comments_link = '';
	if ( ! is_single() && ! is_page() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		$comments_link = '<span class="comments-link paper-btn">';
		$comments_link .= '<a href="' . get_comments_link() . '">';
		$comments_link .= get_comments_number_text();
		$comments_link .= '</a></span>';
	}
	
	return $comments_link;
}

function add_class_to_more_link( $link, $text ) {

	$more_link = str_replace(
		'more-link',
		'more-link paper-btn',
		$link
	);

	$more_link .= get_comments_btn();

	return '<div class="row">' . $more_link . '</div>';
}
add_filter( 'the_content_more_link', 'add_class_to_more_link', 10, 2 );

function add_comments_link_after_the_content( $content ) {

	if ( ! strpos( $content, 'more-link' ) ) {
		$content .= '<div class="row">' . get_comments_btn() . '</div>';
	}
 
    return $content;
}
add_filter( 'the_content', 'add_comments_link_after_the_content' );


add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="paper-btn"';
}

/**
 * Comments
 */
function dukkha_comments( $comment, $args, $depth ) {
	$GLOBALS['comments'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div><?php comment_author(); ?></div>
			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
					'depth' => $depth ,
					'max_depth' => $args['max_depth']
				))); ?>
			</div>
		</article>
	</li>
	<?php
}

/**
 * Change submit button on Review form in WooCommerce
 */
function change_submit_button( $review_form ) {
	$review_form['id_submit']    = 'submit_dukkha';
	$review_form['class_submit'] = 'paper-btn';

	return $review_form;
}
add_filter( 'woocommerce_product_review_comment_form_args', 'change_submit_button' );

/**
 * Change order button on Checkout page in WooCommerce
 */
function change_order_button( $button ) {

	return '<button type="submit" class="btn-secondary" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order">Place order</button>';
}
add_filter( 'woocommerce_order_button_html', 'change_order_button' );
