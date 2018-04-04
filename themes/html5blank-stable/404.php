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

               <!-- article -->
               <article id="post-404">

                  <h1><?php _e( 'Page not found', 'html5blank' ); ?></h1>
                  <h2>
                     <a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
                  </h2>

               </article>
               <!-- /article -->

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
