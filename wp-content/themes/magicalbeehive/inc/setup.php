<?php
/**
 * Theme basic setup.
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

add_action( 'after_setup_theme', 'magicalbeehive_setup' );

if ( ! function_exists ( 'magicalbeehive_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function magicalbeehive_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on magicalbeehive, use a find and replace
		 * to change 'magicalbeehive' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'magicalbeehive', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary_left' => __( 'Primary Menu Left', 'magicalbeehive' ),
			'primary_right' => __( 'Primary Menu Right', 'magicalbeehive' ),
			'secondary_left' => __( 'Secondary Menu Left', 'magicalbeehive' ),
			'secondary_right' => __( 'Secondary Menu Right', 'magicalbeehive' ),
			'footer' => __( 'Footer Menu', 'magicalbeehive' ),
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

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'magicalbeehive_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Set up the WordPress Theme logo feature.
		add_theme_support( 'custom-logo' );
		
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Check and setup theme default settings.
		magicalbeehive_setup_theme_default_settings();

	}
}


add_filter( 'excerpt_more', 'magicalbeehive_custom_excerpt_more' );

if ( ! function_exists( 'magicalbeehive_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function magicalbeehive_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}

add_filter( 'wp_trim_excerpt', 'magicalbeehive_all_excerpts_get_more_link' );

if ( ! function_exists( 'magicalbeehive_all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function magicalbeehive_all_excerpts_get_more_link( $post_excerpt ) {
		if ( ! is_admin() ) {
			$post_excerpt = $post_excerpt . ' [...]<p><a class="btn btn-secondary magicalbeehive-read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More...',
			'magicalbeehive' ) . '</a></p>';
		}
		return $post_excerpt;
	}
}

add_filter('body_class', function (array $classes) {
	/** Add page slug if it doesn't exist */
	if (is_single() || is_page() && !is_front_page()) {
			if (!in_array(basename(get_permalink()), $classes)) {
					$classes[] = basename(get_permalink());
			}
	}

	return array_filter($classes);
});

// Remove title from shop page
add_filter( 'woocommerce_show_page_title', 'mbh_hide_shop_page_title' );
 
function mbh_hide_shop_page_title( $title ) {
   if ( is_shop() ) $title = false;
   return $title;
}

// Remove breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );

add_filter( 'woocommerce_show_variation_price', '__return_true' );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_product_description_heading', '__return_null' );

add_action( 'woocommerce_before_add_to_cart_quantity', 'mbh_echo_qty_front_add_cart' );
 
function mbh_echo_qty_front_add_cart() {
 echo '<label for="quantity">Quantity </label>'; 
}

/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	$tabs['taste_tab'] = array(
		'title' 	=> __( 'Taste', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'mbh_taste_callback'
	);
	
	$tabs['benefits_tab'] = array(
		'title' 	=> __( 'Benefits', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'mbh_benefits_callback'
	);
	
	$tabs['usage_tab'] = array(
		'title' 	=> __( 'Usage tips', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'mbh_usage_callback'
	);
	
	$tabs['consistency_tab'] = array(
		'title' 	=> __( 'Consistency', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'mbh_consistency_callback'
	);

	unset( $tabs['additional_information'] );

	return $tabs;

}

function mbh_taste_callback() {
	echo '<p>' . get_field('taste') . '</p>';	
}

function mbh_benefits_callback() {
	echo '<p>' . get_field('benefits') . '</p>';	
}

function mbh_usage_callback() {
	echo '<p>' . get_field('usage_tips') . '</p>';	
}

function mbh_consistency_callback() {
	echo '<p>' . get_field('consistency') . '</p>';	
}

$role = get_role( 'editor' );
//for woocommerce
$role->add_cap("manage_woocommerce");
$role->add_cap("view_woocommerce_reports");
$role->add_cap("edit_product");
$role->add_cap("read_product");
$role->add_cap("delete_product");
$role->add_cap("edit_products");
$role->add_cap("edit_others_products");
$role->add_cap("publish_products");
$role->add_cap("read_private_products");
$role->add_cap("delete_products");
$role->add_cap("delete_private_products");
$role->add_cap("delete_published_products");
$role->add_cap("delete_others_products");
$role->add_cap("edit_private_products");
$role->add_cap("edit_published_products");
$role->add_cap("manage_product_terms");
$role->add_cap("edit_product_terms");
$role->add_cap("delete_product_terms");
$role->add_cap("assign_product_terms");
$role->add_cap("edit_shop_order");
$role->add_cap("read_shop_order");
$role->add_cap("delete_shop_order");
$role->add_cap("edit_shop_orders");
$role->add_cap("edit_others_shop_orders");
$role->add_cap("publish_shop_orders");
$role->add_cap("read_private_shop_orders");
$role->add_cap("delete_shop_orders");
$role->add_cap("delete_private_shop_orders");
$role->add_cap("delete_published_shop_orders");
$role->add_cap("delete_others_shop_orders");
$role->add_cap("edit_private_shop_orders");
$role->add_cap("edit_published_shop_orders");
$role->add_cap("manage_shop_order_terms");
$role->add_cap("edit_shop_order_terms");
$role->add_cap("delete_shop_order_terms");
$role->add_cap("assign_shop_order_terms");
$role->add_cap("edit_shop_coupon");
$role->add_cap("read_shop_coupon");
$role->add_cap("delete_shop_coupon");
$role->add_cap("edit_shop_coupons");
$role->add_cap("edit_others_shop_coupons");
$role->add_cap("publish_shop_coupons");
$role->add_cap("read_private_shop_coupons");
$role->add_cap("delete_shop_coupons");
$role->add_cap("delete_private_shop_coupons");
$role->add_cap("delete_published_shop_coupons");
$role->add_cap("delete_others_shop_coupons");
$role->add_cap("edit_private_shop_coupons");
$role->add_cap("edit_published_shop_coupons");
$role->add_cap("manage_shop_coupon_terms");
$role->add_cap("edit_shop_coupon_terms");
$role->add_cap("delete_shop_coupon_terms");
$role->add_cap("assign_shop_coupon_terms");
$role->add_cap("edit_shop_webhook");
$role->add_cap("read_shop_webhook");
$role->add_cap("delete_shop_webhook");
$role->add_cap("edit_shop_webhooks");
$role->add_cap("edit_others_shop_webhooks");
$role->add_cap("publish_shop_webhooks");
$role->add_cap("read_private_shop_webhooks");
$role->add_cap("delete_shop_webhooks");
$role->add_cap("delete_private_shop_webhooks");
$role->add_cap("delete_published_shop_webhooks");
$role->add_cap("delete_others_shop_webhooks");
$role->add_cap("edit_private_shop_webhooks");
$role->add_cap("edit_published_shop_webhooks");
$role->add_cap("manage_shop_webhook_terms");
$role->add_cap("edit_shop_webhook_terms");
$role->add_cap("delete_shop_webhook_terms");
$role->add_cap("assign_shop_webhook_terms");


add_action('wp_ajax_mbh_trace', 'datatables_server_side_callback');
add_action('wp_ajax_nopriv_mbh_trace', 'datatables_server_side_callback');

add_shortcode ('mbh_trace', 'mbh_trace');

function mbh_trace() {

	mbh_enqueue_frontend_scripts();

	mbh_trace_scripts();
	
	ob_start();

	?>

	<table id="tracetable" class="table table-striped table-hover">
			<thead>
					<tr>
							<th>Batch Number</th>
							<th>Date</th>
							<th>Certificate</th>
					</tr>
			</thead>
	</table>
	
	<?php
	return ob_get_clean();
}


function mbh_enqueue_frontend_scripts(){
	wp_enqueue_script( 'datatables', 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', array(), '', true );
	wp_enqueue_script( 'datatables-responsive', 'https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js', array(), '', true );
	wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array(), '', true );
}

			
function mbh_trace_scripts(){
	wp_enqueue_script('mbh_trace', get_template_directory_uri() . '/js/trace-script.js', array('jquery'));
	wp_localize_script( 'mbh_trace', 'ajax_url_trace', admin_url() . 'admin-ajax.php?action=mbh_trace' );
}


function datatables_server_side_callback() {

	date_default_timezone_set('Europe/Berlin');
	
	header("Content-Type: application/json");
	
	$request = $_GET;
	
	$columns = array(
		0 => 'trace_number',
		1 => 'trace_date',
		2 => 'trace_cert',
	);
	
	$args = array(
		'post_type' => 'trace',
		'post_status' => 'publish',
		'posts_per_page' => 500, //$request['length'],
		'offset' => $request['start'],
		'order' => 'DESC',
		'orderby' => 'publish_date'
	);
	
	$trace_query = new \WP_Query($args);
	$totalData = $trace_query->found_posts;
	
	if ( $trace_query->have_posts() ) {
		while ( $trace_query->have_posts() ) {
			$trace_query->the_post();

			$cert = get_field('certificate');

			$nestedData = array();
			$nestedData[] = get_the_title();
			$nestedData[] = get_field('date');
			$nestedData[] = $cert['url'];
			
			$data[] = $nestedData;
		}
		wp_reset_query();
		
		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalData),
			"data" => $data
		);
		
		echo json_encode($json_data);
	
	} else {
		
		$json_data = array(
			"data" => array()
		);
		
		echo json_encode($json_data);
	}
	
	wp_die();
	
}
