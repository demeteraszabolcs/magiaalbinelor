<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'magicalbeehive_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<header class="banner">
		<div class="container-fluid d-flex justify-content-center">
			<div class="nav-separator"></div>
			<div class="nav-wrapper left">
				<nav class="nav-secondary left">
					<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'secondary_left',
								'container_class' => '',
								'container_id'    => 'navbarNavDropdown',
								'menu_class'      => 'navbar-nav nav ml-auto flex-row',
								'fallback_cb'     => '',
								'menu_id'         => 'menu-accessibility',
								'depth'           => 2,
								'walker'          => new magicalbeehive_WP_Bootstrap_Navwalker(),
							)
						); 
					?>
				</nav>
				<nav class="nav-primary left">
					<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'primary_left',
								'container_class' => '',
								'container_id'    => 'navbarNavDropdown',
								'menu_class'      => 'navbar-nav nav ml-auto flex-row',
								'fallback_cb'     => '',
								'menu_id'         => 'menu-left-menu',
								'depth'           => 2,
								'walker'          => new magicalbeehive_WP_Bootstrap_Navwalker(),
							)
						); 
					?>
				</nav>
			</div>
			<a class="brand" href="<?php echo home_url(); ?>">
				<img src=<?php echo get_template_directory_uri() . "/images/logo-t.png" ?>>
			</a>
			<div class="nav-wrapper right">
				<nav class="nav-secondary right">
					<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'secondary_right',
								'container'				=> false,
								'menu_class'      => 'navbar-nav nav flex-row',
								'fallback_cb'     => '',
								'menu_id'         => 'menu-account',
								'depth'           => 2,
								'walker'          => new magicalbeehive_WP_Bootstrap_Navwalker(),
							)
						); 
					?>
				</nav>
				<nav class="nav-primary right">
					<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'primary_right',
								'container'				=> false,
								'menu_class'      => 'navbar-nav nav ml-auto flex-row',
								'fallback_cb'     => '',
								'menu_id'         => 'menu-right-menu',
								'depth'           => 2,
								'walker'          => new magicalbeehive_WP_Bootstrap_Navwalker(),
							)
						); 
					?>
				</nav>
			</div>
		</div>
	</header>

	<!-- if homepage -->
	<?php
		if (is_front_page() || is_home() || is_page('home')){ ?>

			<div class="hero-wrapper">
				<div class="container-fluid h-100 d-flex flex-column justify-space-between">
					<h1 style="text-align:center"><?php the_field('heading'); ?></h1>
					<h3 style="text-align:center"><?php the_field('subheading'); ?></h3>
					<!-- <a href="#" class="btn btn-dark btn-lg rounded-0" role="button" aria-pressed="true">SWEETEN YOUR DAY</a> -->
					<div class="mbh-button aligncenter rounded-0">
						<a href="<?php echo get_field('button')['url']; ?>" class="mbh-link"><?php echo get_field('button')['title']; ?></a>
					</div>
				</div>
			</div>

		<?php }
	?>

	<div class="deco-wrap top">
		<img src=<?php echo get_template_directory_uri() . "/images/deco-top.png" ?> class="honey-deco top">
	</div>

