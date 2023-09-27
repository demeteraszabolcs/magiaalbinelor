<?php
/**
 * Template Name: Home Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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

	<section id="products-home">
		<div class="container py-5 text-center">
			<div class="row pb-5">
				<div class="col">
					<div class="deco-wrap">
						<img src="<?php echo get_template_directory_uri();?>/images/deco-wax.png" alt="" class="wax-deco mb-4">
					</div>
					<h4 class=""><?php the_field('products_subheading'); ?></h4>
					<h2 class=""><?php the_field('products_heading'); ?></h2>

					<div class="row products mb-4">
						<div class="col col-12 col-md-6 col-lg-3">
							<div class="product">
								<p>HONEY</p>
								<img src="<?php echo get_template_directory_uri();?>/images/honey.png" alt="">
							</div>
						</div>
					</div>

					<div class="col col-md-8 offset-md-2">
						<p class="px-4"><?php the_field('products_description'); ?></p>
					</div>
					<div class="mbh-button aligncenter rounded-0">
						<a href="<?php echo get_field('products_button')['url']; ?>" class="mbh-link inverse"><?php echo get_field('products_button')['title']; ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="trace-home">
		<div class="deco-wrap">
			<img src="<?php echo get_template_directory_uri();?>/images/deco-honey-top.png" alt="" class="honey-deco">
		</div>
		<div class="container">
			<div class="row pb-5">
				<div class="col col-md-10 offset-md-1 text-center px-5 pb-5">
					<h2 class="mb-4" style="color: #db8202;"><?php the_field('cta_heading'); ?></h2>
					<p class=""><?php the_field('cta_text'); ?></p>
					<div class="mbh-button aligncenter rounded-0">
						<a href="<?php echo get_field('cta_button')['url']; ?>" class="mbh-link"><?php echo get_field('cta_button')['title']; ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php 
		$cert = get_field('certification');
		$eco = get_field('eco');
	?>
	<section id="certification-home">
		<div class="bg-primary position-relative">
			<div class="container">
				<div class="row">
					<div class="col col-md-7 p-0">
					</div>
					<div class="col col-md-5 p-0 py-5">
						<h2 class="m-0 text-secondary pl-5"><?php echo $cert['title']; ?></h2>
						<h4 class="mb-4 pl-5"><?php echo $cert['subtitle']; ?></h4>
						<p class="text-light pl-5 mb-5"><?php echo $cert['text']; ?></p>
						<?php 
							if ($cert['button'] != ''){ ?>
								<a href="<?php echo $cert['button']['url']; ?>" class="pl-5" style="color: #000;"><?php echo $cert['button']['title']; ?></a>
							<?php }
						?>
					</div>
				</div>
			</div>
			<div class="absolute-bg">
				<img src="<?php echo get_template_directory_uri(); ?>/images/cert-bg.jpg" alt="" class="">
			</div>
			<div class="center-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/certification-icon.png" alt="" class="icon">
			</div>
		</div>
		<div class="bg-primary position-relative">
			<div class="container">
				<div class="row">
						<div class="col col-md-5 p-0 py-5">
							<h2 class="m-0 text-secondary"><?php echo $eco['title']; ?></h2>
							<h4 class="mb-4"><?php echo $eco['subtitle']; ?></h4>
							<p class="text-light pr-5"><?php echo $cert['text']; ?></p>
							<?php 
								if ($eco['button'] != ''){ ?>
									<a href="<?php echo $eco['button']['url']; ?>" class="" style="color: #000;"><?php echo $eco['button']['title']; ?></a>
								<?php }
							?>
						</div>
						<div class="col col-md-7 p-0">
						</div>
					</div>
			</div>
			<div class="absolute-bg right">
				<img src="<?php echo get_template_directory_uri(); ?>/images/eco-bg.jpg" alt="" class="">
			</div>
			<div class="center-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/bee-icon.png" alt="" class="icon" style="width: 65px;">
			</div>
		</div>
	</section>

	<section id="video-home" class="pt-1">
		<div class="container text-center p-5">
			<h4 class="text-primary mb-5"><?php the_field('video_title'); ?></h4>
			<iframe src="https://player.vimeo.com/video/111727990?color=ff164e&title=0&byline=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
		</div>
	</section>

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
