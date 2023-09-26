<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'magicalbeehive_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<footer class="content-info">
  <div class="container">
		<div class="bee-wrapper">
			<img src=<?php echo get_template_directory_uri() . "/images/symbol-bee.png" ?> class="">
		</div>
		<nav class="nav-primary left">
			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'footer',
						'container_class' => '',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav nav ml-auto flex-row',
						'fallback_cb'     => '',
						'menu_id'         => 'menu-footer-menu',
						'depth'           => 2,
						'walker'          => new magicalbeehive_WP_Bootstrap_Navwalker(),
					)
				); 
			?>
		</nav>
		<div class="footer-social">
			<a href="#"><i class="fab fa-facebook"></i></a>
			<a href="#"><i class="fab fa-instagram"></i></a>
			<a href="#"><i class="fab fa-twitter"></i></a>
		</div>
    <div class="footer-text">
      <a href="<?php echo get_privacy_policy_url(); ?>">Privacy Policy</a>
      <a href="<?php echo home_url( '/gdpr/' ); ?>">GDPR</a>
			<?php magicalbeehive_site_info(); ?>
		</div>
    <div class="deco-wrap bottom">
			<img src=<?php echo get_template_directory_uri() . "/images/deco-bottom.png" ?> class="honey-deco bottom">
    </div>
  </div>
</footer>

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

