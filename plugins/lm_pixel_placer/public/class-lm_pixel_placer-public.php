<?php

	/**
	 * The public-facing functionality of the plugin.
	 *
	 * @link       http://lamarkmedia.com
	 * @since      1.0.0
	 *
	 * @package    Lm_pixel_placer
	 * @subpackage Lm_pixel_placer/public
	 */

	/**
	 * The public-facing functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the public-facing stylesheet and JavaScript.
	 *
	 * @package    Lm_pixel_placer
	 * @subpackage Lm_pixel_placer/public
	 * @author     Lamark Media <webadmin@lamarkmedia.com>
	 */
	class Lm_pixel_placer_Public {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 *
		 * @param      string $plugin_name The name of the plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;

		}

		/**
		 * Register the stylesheets for the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Lm_pixel_placer_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Lm_pixel_placer_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lm_pixel_placer-public.css', array(), $this->version, 'all' );

		}

		/**
		 * Register the JavaScript for the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Lm_pixel_placer_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Lm_pixel_placer_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lm_pixel_placer-public.js', array( 'jquery' ), $this->version, false );

		}

		public function lamark_checkout() {
		  $options = get_option( $this->plugin_name );

		  $facebook_pixel = $options['facebook_pixel'];
		  if($facebook_pixel == 1 && is_checkout()) { ?>
             <script>
                fbq('track', 'InitiateCheckout');
             </script>
			  <?php
		  }
      }

		public function lamark_atc() {
		      global $woocommerce;

		  $options = get_option( $this->plugin_name );

		   $facebook_pixel = $options['facebook_pixel'];
		      $product_id = $_POST['add-to-cart'];
		      $_product = wc_get_product( $product_id );
		      $product_name = $_product->get_name();
		      $product_price = $_product->get_price();

	             if($facebook_pixel == 1) { ?>
                    <script>
                       fbq('track', 'AddToCart', {
                          content_name: '<?php echo $product_name; ?>',
                          value: <?php echo $product_price; ?>,
                          content_type: "product",
                          currency: 'USD'
                       });
                    </script>
                    <?php
          }
      }

		public function lamark_footer_scripts() {
			$options = get_option( $this->plugin_name );

			$gtm_datalayer             = $options['gtm_datalayer'];
			$google_remarketing        = $options['google_remarketing'];
			$remarketing_conversion_id = $options['remarketing_conversion_id'];
			$facebook_pixel            = $options['facebook_pixel'];
			$facebook_id               = $options['facebook_id'];

			if ( $google_remarketing == 1 || $gtm_datalayer == 1 ) : ?>


				   <?php
				   global $woocommerce;

				   if ( is_home() || is_front_page() ) {
					   $remarketing_page_type = "home";
				   }
				   if ( is_search() ) {
					   $remarketing_page_type = "searchresults";
				   }
				   if ( is_category() || is_shop() ) {
					   $remarketing_page_type = "category";
				   }
				   if ( is_cart() ) {
					   $remarketing_page_type = "cart";
				   }
				   if ( is_product() ) {
					   $remarketing_page_type = "product";
				   }
				   if ( is_checkout() ) {
					   $remarketing_page_type = "purchase";
				   }

				   if ( $remarketing_page_type == '' ) {
					   $remarketing_page_type = 'other';
				   }


				   if ( is_cart() || is_product() )
				   {
                     if ( is_cart() ) {
                     $products          = $woocommerce->cart->get_cart();
                     $products_total    = $woocommerce->cart->subtotal;
                     $products_tax      = WC()->cart->get_taxes_total( false, true );
                     $products_shipping = WC()->cart->get_shipping_total();
                     $product_skus      = array();
                     $product_prices    = array();

                     if ( count( $products ) > 0 ) {
                        foreach ( $products as $product => $value ) {
                           // $item_sku = $value['data']->sku;
                           $item_sku = $value['data']->get_id();
                           array_push( $product_skus, $item_sku );
                        }
                     }

                     $product_sku   = "'" . implode( "','", $product_skus ) . "'";
                     $product_price = $products_total;
                  }


                           if($gtm_datalayer == 1) { ?>
                           <script type = "text/javascript" >
                               // Cart Datalayer (this needs to go on the template for the cart page)

                                  dataLayer.push(
                                     {
                                        "event": "cartPageview",
                                        "ecommerce": {
                                           "revenue": "<?php echo $products_total; ?>",     // Subtotal
                                           "tax": "<?php echo $products_tax; ?>",             // Tax
                                           "shipping": "<?php echo $products_shipping; ?>",   // Shipping Cost
                                           "skus": [<?php echo $product_sku; ?>]      // Array of SKUs
                                        }
                                     }
                                  );
                           </script>

                        <?php
                     }




                     if ( is_product() ) {
                        $product       = wc_get_product();
                        $product_price = $product->get_price();
                        // $product_sku = "'" . $product->sku . "'";
                        $product_sku = "'" . $product->get_id() . "'";
                        $product_name = $product->get_name();
                        $product_cat = $product->get_category_ids();

                        if($facebook_pixel == 1) { ?>
                           <script>
                              fbq('track', 'ViewContent', {
                                 content_name: '<?php echo $product_name; ?>',
                                 value: <?php echo $product_price; ?>,
                                 content_type: "product",
                                 currency: 'USD'
                              });
                           </script>

                        <?php
                        }

                     }


					if ( $google_remarketing == 1 ) { ?>
                     <script type="text/javascript">
                       var google_tag_params = {
                       ecomm_prodid: [<?php echo $product_sku; ?>],
                       ecomm_pagetype: "<?php echo $remarketing_page_type; ?>",
                       ecomm_totalvalue: <?php echo $product_price; ?>
                       };
                      </script>
						<?php
					}

				} else {
					if ( $google_remarketing == 1 ) : ?>
                   <script type="text/javascript">
                       var google_tag_params = { ecomm_pagetype: "<?php echo $remarketing_page_type; ?>" };
                       </script>
					<?php endif;
				}
				?>



				<?php if($google_remarketing == 1) : ?>
                <script type = "text/javascript" >
                /* <![CDATA[ */
                var google_conversion_id = '<?php echo $remarketing_conversion_id; ?>';
                var google_custom_params = window.google_tag_params;
                var google_remarketing_only = true;
                /* ]]> */
               </script>
               <noscript>
                  <div style="display:inline;">
                     <img height="1" width="1" style="border-style:none;" alt=""
                          src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo $remarketing_conversion_id; ?>/?guid=ON&amp;script=0"/>
                  </div>
               </noscript>
			<?php endif;
         endif;
				}

		public function lamark_header_scripts() {
		  $options = get_option( $this->plugin_name );

		  $google_analytics            = $options['google_analytics'];
		  $google_analytics_id         = $options['google_analytics_id'];
		  $gtm_datalayer               = $options['gtm_datalayer'];
		  $gtm_id                      = $options['gtm_id'];
		  $metatags                    = $options['metatags'];
		  $facebook_pixel              = $options['facebook_pixel'];
		  $facebook_id                 = $options['facebook_id'];
		  $additional_pixels_each_page = $options['additional_pixels_each_page'];
		  $specific_pixels_for_page1   = $options['specific_pixels_for_page1'];
		  $specific_page1              = $options['specific_page1'];
		  $specific_pixels_for_page2   = $options['specific_pixels_for_page2'];
		  $specific_page2              = $options['specific_page2'];
		  $specific_pixels_for_page3   = $options['specific_pixels_for_page3'];
		  $specific_page3              = $options['specific_page3'];
		  $specific_pixels_for_page4   = $options['specific_pixels_for_page4'];
		  $specific_page4              = $options['specific_page4'];


		  if ( $facebook_pixel == 1 ) : ?>
            <!-- Facebook Pixel Code -->
            <script>
               !function (f, b, e, v, n, t, s) {
                  if (f.fbq) return;
                  n = f.fbq = function () {
                     n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                  };
                  if (!f._fbq) f._fbq = n;
                  n.push = n;
                  n.loaded = !0;
                  n.version = '2.0';
                  n.queue = [];
                  t = b.createElement(e);
                  t.async = !0;
                  t.src = v;
                  s = b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t, s)
               }(window,
                  document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
               // Insert Your Custom Audience Pixel ID below.
               fbq('init', '<?php echo $facebook_id; ?>');
            </script>
            <!-- Insert Your Custom Audience Pixel ID below. -->
            <noscript><img height="1" width="1" style="display:none"
                           src="https://www.facebook.com/tr?id=<?php echo $facebook_id; ?>&ev=PageView&noscript=1"/>
            </noscript>

           <?php endif;


            if ( $google_analytics == 1 ) : ?>
             <!-- Google Analytics -->
             <script>
                (function (i, s, o, g, r, a, m) {
                   i['GoogleAnalyticsObject'] = r;
                   i[r] = i[r] || function () {
                      (i[r].q = i[r].q || []).push(arguments)
                   }, i[r].l = 1 * new Date();
                   a = s.createElement(o),
                      m = s.getElementsByTagName(o)[0];
                   a.async = 1;
                   a.src = g;
                   m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', '<?php echo $google_analytics_id; ?>', 'auto');
                ga('send', 'pageview');
             </script>
             <!-- End Google Analytics -->
		  <?php
		  endif;

		  if ( $metatags != '' ) {
			  echo $metatags;
		  }
		  if ( $additional_pixels_each_page != '' ) {
			  echo $additional_pixels_each_page;
		  }
		  if ( is_page( $specific_page1 ) ) {
			  echo $specific_pixels_for_page1;
		  }
		  if ( is_page( $specific_page2 ) ) {
			  echo $specific_pixels_for_page2;
		  }
		  if ( is_page( $specific_page3 ) ) {
			  echo $specific_pixels_for_page3;
		  }
		  if ( is_page( $specific_page4 ) ) {
			  echo $specific_pixels_for_page4;
		  }
		  if ( $gtm_datalayer == 1 ) {
			  if ( is_product() || is_wc_endpoint_url( 'order-received' ) || is_cart() ) :

				  if ( is_product() ) {
					  $product = wc_get_product();
					  //print_r($product->get_id());
					  $pid   = $product->get_id();
					  $pname = $product->get_name();
					  $sku   = $product->get_sku();
					  $price = $product->get_price();
				  }

				  ?>
                 <!-- Google Tag Manager -->
                 <script>(function (w, d, s, l, i) {
                       w[l] = w[l] || [];
                       w[l].push({
                          'gtm.start':
                             new Date().getTime(), event: 'gtm.js'
                       });
                       var f = d.getElementsByTagName(s)[0],
                          j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                       j.async = true;
                       j.src =
                          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                       f.parentNode.insertBefore(j, f);
                    })(window, document, 'script', 'dataLayer', '<?php echo $gtm_id; ?>');</script>
                 <!-- End Google Tag Manager -->

				  <?php if ( is_product() ) : ?>
                 <script type="text/javascript">
                    dataLayer.push(
                       {
                          "event": "productPageview",
                          "ecommerce": {
                             "products": {
                                "name": "<?php echo $pname; ?>",
                                "sku": "<?php echo $sku; ?>",
                                "price": <?php echo $price; ?>
                             }
                          }
                       }
                    );
                 </script>

			  <?php endif; endif;
		  }

	  }


		//Lamark's Badass WooCommerce Pixel Machine
		public function lamark_badass_wc_pixel_machine( $order_id ) {

		  $options = get_option( $this->plugin_name );

		  $ga_ecommerce              = $options['ga_ecommerce'];
		  $gtm_datalayer             = $options['gtm_datalayer'];
		  $google_conversion         = $options['google_conversion'];
		  $adwords_conversion_id     = $options['adwords_conversion_id'];
		  $adwords_converison_label  = $options['adwords_converison_label'];
		  $google_remarketing        = $options['google_remarketing'];
		  $remarketing_conversion_id = $options['remarketing_conversion_id'];
		  $facebook_pixel            = $options['facebook_pixel'];
		  $facebook_id               = $options['facebook_id'];
		  $bing_pixel                = $options['bing_pixel'];
		  $bing_id                   = $options['bing_id'];

		  $additional_ecommerce_conversion_pixels = $options['additional_ecommerce_conversion_pixels'];

		  $pixels_flag = 0;
		  //grab the past orders cookie
		  if ( isset( $_COOKIE["wc_pastorders"] ) ) {
			  $orders_array = explode( ",", $_COOKIE["wc_pastorders"] );

			  //if the order is not in the past orders cookie, set the pixels flag to 1 and add the order to the cookie
			  if ( ! in_array( $order_id, $orders_array ) ) {
				  $pixels_flag = 1;
				  array_push( $orders_array, $order_id );
				  $orders = implode( ',', $orders_array );
				  wc_setcookie( "wc_pastorders", $orders, time() + ( 86400 * 60 ), false );
			  }
		  } else {
			  $pixels_flag = 1;
			  wc_setcookie( "wc_pastorders", $order_id, time() + ( 86400 * 60 ), false );
		  }

		  $order          = new WC_Order( $order_id );
		  $currency       = $order->get_currency();
		  $sub_total      = $order->get_subtotal();
		  $shipping       = $order->get_total_shipping();
		  $date           = $order->get_date_completed();
		  $product_skus   = array();
		  $cart_taxes     = $order->get_cart_tax();
		  $shipping_taxes = $order->get_shipping_tax();
		  $total_taxes    = round( $cart_taxes + $shipping_taxes, 2 );
		  $line_items     = $order->get_items();


		  //create skus list
		  foreach ( $line_items as $item ) {
			  $product = $order->get_product_from_item( $item );
			  array_push( $product_skus, $product->get_id() );
		  }
		  if ( count( $product_skus ) > 0 ) {
			  $product_sku = "'" . implode( "','", $product_skus ) . "'";
		  } else {
			  $product_sku = $product_skus;
		  }


		  if ( $pixels_flag == 1 ) {
			  echo "<!--fire all pixels!-->";
			  ?>

			  <?php if ( $ga_ecommerce == 1 ) : ?>
                <!-- GA Ecommerce Data -->
                <script type="text/javascript">
                   ga('require', 'ecommerce');

                   ga('ecommerce:addTransaction', {
                      'id': '<?php echo $order_id; ?>',    	                    // Transaction ID. Required.
                      'revenue': '<?php echo $sub_total; ?>',        // Grand Total.
                      'shipping': '<?php echo $shipping; ?>', // Shipping.
                      'tax': '<?php echo $total_taxes; ?>'             			  // Tax.
                   });

				   <?php

				   foreach ( $line_items as $item ) {
				   $product = $order->get_product_from_item( $item );
				   ?>
                   ga('ecommerce:addItem', {
                      'id': '<?php echo $order_id; ?>', 	                     // Transaction ID. Required.
                      'name': '<?php echo $item["name"]; ?>',    					// Product name. Required.
                      'sku': '<?php echo $product->get_id(); ?>',             // SKU/code.
                      //'category': '<?php //echo strip_tags( $product->get_categories() ); ?>', // Category or variation.
                      'price': '<?php echo $product->get_price(); ?>',         // Unit price.
                      'quantity': '<?php echo $item["qty"]; ?>'                // Quantity.
                   });
				   <?php
				   }
				   ?>
                   ga('ecommerce:send');

                </script>
                <!-- End GA Ecommerce Data -->
			  <?php endif; ?>

			  <?php if ( $google_conversion == 1 ) : ?>
                <!-- Google Code for Conversion  -->
                <script type="text/javascript">
                   /* <![CDATA[ */
                   var google_conversion_id = <?php echo $adwords_conversion_id; ?>;
                   var google_conversion_label = "<?php echo $adwords_converison_label; ?>";
                   var google_conversion_value = <?php echo $sub_total; ?>;
                   var google_conversion_currency = "USD";
                   var google_remarketing_only = false;
                   /* ]]> */
                </script>
                <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                </script>
                <noscript>
                   <div style="display:inline;">
                      <img height="1" width="1" style="border-style:none;" alt=""
                           src="//www.googleadservices.com/pagead/conversion/<?php echo $adwords_conversion_id; ?>/?value=<?php echo $sub_total; ?>&amp;currency_code=USD&amp;label=<?php echo $adwords_converison_label; ?>&amp;guid=ON&amp;script=0"/>
                   </div>
                </noscript>
                <!-- Google Code for Conversion  -->
			  <?php endif; ?>

			  <?php if ( $gtm_datalayer == 1 ) : ?>

                <script type="text/javascript">
					<?php
					$total_items = 0;
					foreach ( $line_items as $item ) {
						$product     = $order->get_product_from_item( $item );
						$total_items = + $item["qty"];
					}
					foreach ( $line_items as $item ) {
					$product = $order->get_product_from_item( $item );

					?>
                    dataLayer.push({
                       'event': 'itemPurchased',
                       'ecommerce': {
                          "id": "<?php echo $order_id; ?>",
                          "revenue": "<?php echo $sub_total; ?>",
                          "tax": "<?php echo $total_taxes; ?>",
                          "shipping": "<?php echo $shipping; ?>",
                          "quantity": <?php echo $total_items; ?>,
                          "products": {
                             "id": "<?php echo $product->get_id(); ?>",
                             "sku": "<?php echo $product->get_sku(); ?>",
                             "name": "<?php echo $product->get_name(); ?>",
                             "price": "<?php echo $product->get_price(); ?>",
                             "quantity": <?php echo $item["qty"]; ?>
                          }
                       }
                    })
					<?php } ?>
                </script>

                // Event for a successful Conversion holds all of the order data + items ordered
                <script type="text/javascript">
                   dataLayer.push(
                      {
                         "event": "conversionSuccess",
                         "ecommerce": {
                            "id": "<?php echo $order_id; ?>",
                            "revenue": "<?php echo $sub_total; ?>",
                            "tax": "<?php echo $total_taxes; ?>",
                            "shipping": "<?php echo $shipping; ?>",
                            "quantity": <?php echo $total_items; ?>,
                            "skus": [<?php echo $product_sku; ?>] // Array of SKUs
                         }
                      }
                   );
                </script>

			  <?php endif; ?>


			  <?php if ( $facebook_pixel == 1 ) : ?>
                <!-- Facebook Pixel Code -->
                <script>
                   fbq('track', 'Purchase', {
                      content_type: "product",
                      content_ids: [<?php echo $product_sku; ?>],
                      value: <?php echo $order->get_subtotal(); ?>,
                      currency: "USD"
                   });
                </script>
                <!-- End Facebook Pixel Code -->
			  <?php endif; ?>

			  <?php if ( $google_remarketing == 1 ) : ?>
                <!-- Google Remarketing Tag Values -->
                <script>
                   var google_tag_params = {
                      ecomm_prodid: [<?php echo $product_sku; ?>],
                      ecomm_pagetype: "purchase",
                      ecomm_totalvalue: <?php echo $sub_total; ?>
                   };
                </script>

			  <?php endif; ?>

			  <?php if ( $bing_pixel == 1 ) : ?>
                <!-- Bing Revenue Pixel -->
                <script>
                   (function (w, d, t, r, u) {
                      var f, n, i;
                      w[u] = w[u] || [] , f = function () {
                         var o = {ti: "<?php echo $bing_id; ?>"};
                         o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad")
                      } , n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function () {
                         var s = this.readyState;
                         s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null)
                      }, i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i)
                   })(window, document, "script", " //bat.bing.com/bat.js", "uetq");
                </script>
                <noscript>
                   <img src="//bat.bing.com/action/0?ti=<?php echo $bing_id; ?>& Ver=2" height="0" width="0"
                        style="display:none ; visibility: hidden;"/>
                </noscript>
                <script>
                   gv = value / subtotal
                   gc = currency(USD)
                   window.uetq.push({'gv': <?php echo $sub_total; ?>, 'gc': 'USD'});
                </script>
                <!-- Bing Revinue Pixel -->
			  <?php endif; ?>

			  <?php
			  if ( $additional_ecommerce_conversion_pixels != '' ) {
				  $additional_ecommerce_conversion_pixels = str_replace( '[[subtotal]]', $sub_total, $additional_ecommerce_conversion_pixels );
				  $additional_ecommerce_conversion_pixels = str_replace( '[[orderid]]', $order_id, $additional_ecommerce_conversion_pixels );
				  echo $additional_ecommerce_conversion_pixels;
			  }
			  ?>

             <!-- End Tracking Codes -->
			  <?php
		  }
	  }


	}
