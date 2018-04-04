<?php get_header(); ?>

<div class="ger_the_wrapper">

   <div class="page-header" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)">
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <h1><?php the_title(); ?></h1>
            </div>
         </div>
      </div>
   </div>

	<div class="container" >
		<div class="row">
			<div class="col-sm-12">
				<main role="main">
					<!-- section -->
					<section>

						<?php if (have_posts()): while (have_posts()) : the_post(); ?>

							<!-- article -->
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

								<!-- post thumbnail
								<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_post_thumbnail(); // Fullsize image for the single post ?>
									</a>
								<?php endif; ?>
								 /post thumbnail -->


								<?php
								if ( function_exists('yoast_breadcrumb') ) {
									yoast_breadcrumb('
<p id="breadcrumbs">','</p>
');
								}
								?>
								<!-- post details -->
								<span class="date"><?php the_time('F j, Y'); ?></span>

								<!-- /post details -->

								<?php the_content(); // Dynamic Content ?>

								<?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

                        <?php comments_template( '/comments.php', false ); ?>

							</article>
							<!-- /article -->

						<?php endwhile; ?>

						<?php else: ?>

							<!-- article -->
							<article>

								<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

							</article>
							<!-- /article -->

						<?php endif; ?>

					</section>

					<!-- /section -->
				</main>
			</div>
			<div class="side-filter" style="display: none;">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
