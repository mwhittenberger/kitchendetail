<hr class="style-one two">
<!-- footer -->
			<footer class="footer" role="contentinfo">
				<div class="container">
               <div class="row">
                  <div class="col-sm-4"><div class="footer-logo">Kitchen Detail</div><div class="social">
                        <ul>
                           <li><a onClick="ga('send', 'event', { eventCategory: 'Site Links', eventAction: 'Social Media Click', eventLabel: 'Instagram', eventValue: 1});" href="https://www.instagram.com/kitchendetailblog/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                           <li><a onClick="ga('send', 'event', { eventCategory: 'Site Links', eventAction: 'Social Media Click', eventLabel: 'Facebook', eventValue: 1});" href="https://www.facebook.com/kitchendetailblog/" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                            <li><a onClick="ga('send', 'event', { eventCategory: 'Site Links', eventAction: 'Social Media Click', eventLabel: 'YouTube', eventValue: 1});" href="https://www.youtube.com/channel/UC1v7D9EcISE7GVQpSAIeZmA" target="_blank"><i class="fab fa-youtube"></i></a></li>
                           <li><a onClick="ga('send', 'event', { eventCategory: 'Site Links', eventAction: 'Social Media Click', eventLabel: 'Twitter', eventValue: 1});" href="https://twitter.com/lacuisineus" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
                        </ul></div></div>
                  <div class="col-sm-4">
                     <div class="awesome">
        You are already subscribed, and we appreciate it! <a href="mailto:nancy@lacuisineus.com">Let us know what you're cooking...</a>
                     </div>
                     <div style="text-align:center;margin-bottom: 5px;">Subscribe to Kitchen Detail</div><div class="subscribe-wrapper"><input type="email" class="my-email" name="email" placeholder="Enter Your Email"><input type="button" value="Subscribe" class="subscribe-me"></div>
                  </div>
                  <div class="col-sm-4">
                      <?php
	                      wp_nav_menu( array(
		                      'menu'   => 'Footer Menu',
	                      ) );
                      ?>
                  </div>
               </div>
					<div class="row">
						<div class="col-sm-12">
							<!-- copyright -->
							<p class="copyright">
								&copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>.
							</p>
							<!-- /copyright -->

						</div>
					</div>
				</div>
			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

         <!-- Modal -->
         <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

               <!-- Modal content-->
               <div class="modal-content" style="height:200px;">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">&nbsp;</h4>
                  </div>
                  <div class="modal-body">

                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>

            </div>
         </div>


<!-- OuiBounce Modal -->
<div class="modal fade" id="ouibounce-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body" style="text-align: center;">
            <h3>Before you go, won't you consider becoming a Kitchen Detail subscriber?</h3>
            <div class="subscribe-wrapper">
               Enter your email address and never miss a new post
               <i class="far fa-envelope"></i>
               <input type="email" class="my-email" name="email" placeholder="Enter Your Email"><input type="button" value="Subscribe" class="subscribe-me" data-dismiss="modal"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">No thanks</button>
         </div>
      </div>
   </div>
</div>
	</body>
</html>
