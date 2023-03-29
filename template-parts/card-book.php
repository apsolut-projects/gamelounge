<div class="col ">
	<div class="card border px-2 py-2 h-100">
		<header class="d-flex flex-column align-items-start">
			<h2 class="h4"><?php the_title(); ?></h2>
			<div class="badge bg-success p-2"><?php echo get_post_type(); ?></div>
		</header>
		<div class="content mt-4">
			<?php
			/**
			 * get site tagline if defined
			 */
			$site_description = get_post_meta( get_the_ID(), 'gl_taglinetagline', true );

			if ( $site_description ) {
				echo $site_description;
			} else {
				the_excerpt();
			}

			?>
			<div class="col" >
				<a class="btn btn-success p-2 mt-2" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">Go to!</a>
			</div>
		</div>


	</div>
</div>