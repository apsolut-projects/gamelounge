<?php
// header
get_header();
?>
<div class="container">
    <div class="row">
        <h1 class="mb-5"><?php bloginfo( 'name' ); ?></h1>
    </div>
</div>


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
