<?php get_header(); ?>

<div class="container">
   <div class="row">
      <div class="col-sm-9">
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

               <h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

		        <?php get_template_part('loop'); ?>

		        <?php get_template_part('pagination'); ?>

            </section>
            <!-- /section -->
         </main>
      </div>
      <div class="col-sm-3">
	      <?php get_sidebar(); ?>
      </div>
   </div>
</div>





<?php get_footer(); ?>
