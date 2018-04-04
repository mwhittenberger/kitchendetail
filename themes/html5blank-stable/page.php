<?php get_header(); ?>

<div class="page-header" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
   <h1><?php the_title(); ?></h1>
         </div>
      </div>
   </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('
<p id="breadcrumbs">','</p>
');
			}
			?>
			<main role="main">
				<!-- section -->
				<section>



					<?php if (have_posts()): while (have_posts()) : the_post(); ?>

						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php the_content(); ?>

						</article>
						<!-- /article -->

					<?php endwhile; ?>

					<?php endif; ?>

				</section>
				<!-- /section -->
			</main>
		</div>
	</div>
</div>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
