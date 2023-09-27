<?php
/**
 * Template Name: Certification Page
 *
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'magicalbeehive_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<section id="main-home">

		<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

			<div class="row">

				<main class="site-main" id="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- .row -->

		</div><!-- #content -->

	</section>

	<section id="trace-cert">
		<div class="deco-wrap">
			<img src="<?php echo get_template_directory_uri();?>/images/deco-honey-top.png" alt="" class="honey-deco">
		</div>
		<div class="container">
			<div class="row">
				<div class="col col-md-10 offset-md-1 text-center">
					<div class="mbh-button aligncenter rounded-0">
					<a href="<?php echo get_field('cta_button')['url']; ?>" class="mbh-link"><?php echo get_field('cta_button')['title']; ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
