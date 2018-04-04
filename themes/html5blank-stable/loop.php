<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<!-- post thumbnail -->
		<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
          <div class="blog-img-wrapper">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		          <?php the_post_thumbnail('full', array('class' => '')); // Declare pixel size you need inside the array ?>
             </a>
          </div>
		<?php endif; ?>
		<!-- /post thumbnail -->

		<!-- post title -->
		<h2 class="bp-title">
			<a class="" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<!-- /post title -->
      <span class="date"><?php the_time('F j, Y'); ?></span>&nbsp;&nbsp;<br class="mobile-new-line" style="display: none;"><i class="fas fa-map-signs"></i>&nbsp;&nbsp;<?php the_category( ' &bull; ' ); ?><br>
		<!-- post details -->

      <div style="height:5px;"></div>

		<span class="comments"><i class="far fa-comment"></i>&nbsp;<?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); ?></span>
		<!-- /post details -->


	</article>
	<!-- /article -->
   <hr class="style-one">

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
