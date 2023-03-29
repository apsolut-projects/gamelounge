<?php
// header
get_header();
?>

<h1><?php bloginfo( 'name' ); ?></h1>

<?php if ( have_posts() ) : ?>
<div class="container">
	<div class="row">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/card', get_post_type() ); ?>

		<?php endwhile; ?>
    </div>
</div>
<?php endif; ?>

<?php
// footer
wp_footer();
