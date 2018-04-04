<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://lamarkmedia.com
 * @since      1.0.0
 *
 * @package    Lm_pixel_placer
 * @subpackage Lm_pixel_placer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<img src="https://www.lamarkmedia.com/wp-content/uploads/2015/11/lamark-logo-new.png" width="232" height="70" alt="logo">

Wicked Awesome Pixel Placer Settings Page
<br><br>
<strong>Note: when pasting pixel code into the various fields, include script tags as needed.</strong>

<div class="wrap">

   <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

   <form method="post" name="cleanup_options" action="options.php">

	   <?php

		   $options = get_option($this->plugin_name);

		   $google_analytics = $options['google_analytics'];

		   $google_analytics_id = $options['google_analytics_id'];
		   $ga_ecommerce = $options['ga_ecommerce'];
		   $gtm_datalayer = $options['gtm_datalayer'];
	      $gtm_id = $options['gtm_id'];
		   $google_conversion = $options['google_conversion'];
		   $adwords_conversion_id = $options['adwords_conversion_id'];
		   $adwords_converison_label = $options['adwords_converison_label'];
	      $google_remarketing = $options['google_remarketing'];
	      $remarketing_conversion_id = $options['remarketing_conversion_id'];
	      $facebook_pixel = $options['facebook_pixel'];
	      $facebook_id = $options['facebook_id'];
	      $bing_pixel = $options['bing_pixel'];
	      $bing_id = $options['bing_id'];
	      $metatags = $options['metatags'];
	      $additional_ecommerce_conversion_pixels = $options['additional_ecommerce_conversion_pixels'];
	      $additional_pixels_each_page = $options['additional_pixels_each_page'];
	      $specific_pixels_for_page1 = $options['specific_pixels_for_page1'];
	      $specific_page1 = $options['specific_page1'];
	      $specific_pixels_for_page2 = $options['specific_pixels_for_page2'];
	      $specific_page2 = $options['specific_page2'];
	      $specific_pixels_for_page3 = $options['specific_pixels_for_page3'];
	      $specific_page3 = $options['specific_page3'];
	      $specific_pixels_for_page4 = $options['specific_pixels_for_page4'];
	      $specific_page4 = $options['specific_page4'];

	   ?>

	   <?php
		   settings_fields($this->plugin_name);
		   do_settings_sections($this->plugin_name);
	   ?>

      <fieldset>
         <legend class="screen-reader-text"><span>Include Google Analytics Code?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-google_analytics">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-google_analytics" name="<?php echo $this->plugin_name; ?>[google_analytics]" value="1" <?php checked($google_analytics, 1); ?>/>
            <span><?php esc_attr_e('Add the basic Universal GA tracking pixel', $this->plugin_name); ?></span>
         </label>
         <div class="ga_id">
            <legend class="screen-reader-text"><span>Google Analytics ID</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-google_analytics_id">
               <input type="text" id="<?php echo $this->plugin_name; ?>-jquery_cdn" name="<?php echo $this->plugin_name; ?>[google_analytics_id]" value="<?php echo $google_analytics_id; ?>"  />
               <span><?php esc_attr_e('Add your Google Analytics ID', $this->plugin_name); ?></span>
            </label>
         </div>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Include Google Analytics Ecommerce Tracking?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-ga_ecommerce">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-ga_ecommerce" name="<?php echo $this->plugin_name; ?>[ga_ecommerce]" value="1" <?php checked($ga_ecommerce, 1); ?>/>
            <span><?php esc_attr_e('Include a GA Ecommerce tracking data layer', $this->plugin_name); ?></span>
         </label>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Include GTM Data Layer Ecommerce info?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-gtm_datalayer">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-gtm_datalayer" name="<?php echo $this->plugin_name; ?>[gtm_datalayer]" value="1" <?php checked($gtm_datalayer, 1); ?>/>
            <span><?php esc_attr_e('Include GTM Ecommerce tracking data layer', $this->plugin_name); ?></span>
         </label>
         <div class="gtm_id">
            <legend class="screen-reader-text"><span>GTM ID</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-gtm_id">
               <input type="text" id="<?php echo $this->plugin_name; ?>-jquery_cdn" name="<?php echo $this->plugin_name; ?>[gtm_id]" value="<?php echo $gtm_id; ?>"  />
               <span><?php esc_attr_e('Add your Google Tag Manager ID', $this->plugin_name); ?></span>
            </label>
         </div>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Include Google Adwords Ecommerce Conversion Pixel?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-body_class_slug">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-google_conversion" name="<?php echo $this->plugin_name; ?>[google_conversion]" value="1" <?php checked($google_conversion, 1); ?> />
            <span><?php esc_attr_e('Include Google Adwords Ecommerce Conversion Pixel', $this->plugin_name); ?></span>
         </label>
         <div class="adwords_ecomm">
            <legend class="screen-reader-text"><span>Adwords Conversion ID</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-adwords_conversion_id">
               <input type="text" id="<?php echo $this->plugin_name; ?>-adwords_conversion_id" name="<?php echo $this->plugin_name; ?>[adwords_conversion_id]" value="<?php echo $adwords_conversion_id; ?>"  />
               <span><?php esc_attr_e('Add your Adwords Conversion ID', $this->plugin_name); ?></span>
            </label>
            <br>
            <legend class="screen-reader-text adwords_ecomm"><span>Adwords Conversion Label</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-adwords_converison_label">
               <input type="text" id="<?php echo $this->plugin_name; ?>-adwords_converison_label" name="<?php echo $this->plugin_name; ?>[adwords_converison_label]" value="<?php echo $adwords_converison_label; ?>"  />
               <span><?php esc_attr_e('Add your Adwords Conversion Label', $this->plugin_name); ?></span>
            </label>
         </div>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Include Google Remarketing Code?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-body_class_slug">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-google_remarketing" name="<?php echo $this->plugin_name; ?>[google_remarketing]" value="1" <?php checked($google_remarketing, 1); ?> />
            <span><?php esc_attr_e('Add Google Remarketing tag values', $this->plugin_name); ?></span>
         </label>
         <div class="remarketing_idd">
            <legend class="screen-reader-text"><span>Google Conversion ID</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-remarketing_conversion_id">
               <input type="text" id="<?php echo $this->plugin_name; ?>-remarketing_conversion_id" name="<?php echo $this->plugin_name; ?>[remarketing_conversion_id]" value="<?php echo $remarketing_conversion_id; ?>"  />
               <span><?php esc_attr_e('Add your Dynamic Remarketing Conversion ID (should be the same as the Adwords Conversion ID)', $this->plugin_name); ?></span>
            </label>
         </div>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Include the Facebook Pixel and Purchase Conversion Code?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-facebook_pixel">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-facebook_pixel" name="<?php echo $this->plugin_name; ?>[facebook_pixel]" value="1" <?php checked($facebook_pixel, 1); ?> />
            <span><?php esc_attr_e('Add the Facebook tracking pixel', $this->plugin_name); ?></span>
         </label>
         <div class="facebook_id">
            <legend class="screen-reader-text"><span>Facebook Pixel ID</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-facebook_id">
               <input type="text" id="<?php echo $this->plugin_name; ?>-facebook_id" name="<?php echo $this->plugin_name; ?>[facebook_id]" value="<?php echo $facebook_id; ?>" />
               <span><?php esc_attr_e('Add your Facebook Pixel ID', $this->plugin_name); ?></span>
            </label>
         </div>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Include the Bing Pixel and Purchase Conversion Code?</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-bing_pixel">
            <input type="checkbox" id="<?php echo $this->plugin_name;?>-bing_pixel" name="<?php echo $this->plugin_name; ?>[bing_pixel]" value="1" <?php checked($bing_pixel, 1); ?> />
            <span><?php esc_attr_e('Add the Bing tracking and conversion pixels', $this->plugin_name); ?></span>
         </label>
         <div class="bing_id">
            <legend class="screen-reader-text"><span>Bing Pixel ID</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-bing_id">
               <input type="text" id="<?php echo $this->plugin_name; ?>-bing_id" name="<?php echo $this->plugin_name; ?>[bing_id]"  value="<?php echo $bing_id; ?>" />
               <span><?php esc_attr_e('Add your Bing Pixel ID', $this->plugin_name); ?></span>
            </label>
         </div>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Meta Tags to be included in the head section</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-metatags">
            <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-metatags" name="<?php echo $this->plugin_name; ?>[metatags]" /><?php echo $metatags; ?></textarea>
            <span><?php esc_attr_e('Meta Tags to be included in the head section', $this->plugin_name); ?></span>
         </label>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Additional Ecommerce Related Conversion Pixels</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-additional_ecommerce_conversion_pixels">
            <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-additional_ecommerce_conversion_pixels" name="<?php echo $this->plugin_name; ?>[additional_ecommerce_conversion_pixels]" value="<?php echo $additional_ecommerce_conversion_pixels; ?>" /><?php echo $additional_ecommerce_conversion_pixels; ?></textarea>
            <span>Paste additional ecommerce conversion pixels to be placed on the thank you page.<br>You can use [[subtotal]] to have the order subtotal placed via PHP. Same thing with [[orderid]].</span>
         </label>
      </fieldset>

      <fieldset>
         <legend class="screen-reader-text"><span>Additional Pixels to be placed on each page</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-additional_pixels_each_page">
            <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-additional_pixels_each_page" name="<?php echo $this->plugin_name; ?>[additional_pixels_each_page]"  /><?php echo $additional_pixels_each_page; ?></textarea>
            <span><?php esc_attr_e('Paste additional pixels to be place on each page', $this->plugin_name); ?></span>
         </label>
      </fieldset>

      <button id="click1">Paste code to be placed on one or more specific pages</button>
      <div class="specific1">
         <fieldset>
            <legend class="screen-reader-text"><span>Specific Pixels to be placed on one or more specific pages</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_pixels_for_page1">
               <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-specific_pixels_for_page1" name="<?php echo $this->plugin_name; ?>[specific_pixels_for_page1]"  /><?php echo $specific_pixels_for_page1; ?></textarea>
               <span><?php esc_attr_e('Paste additional pixels to be placed on one or more specific pages', $this->plugin_name); ?></span>
            </label>
            <br>
            <legend class="screen-reader-text"><span>Paste the page IDs for the pages that need the pixel above</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_page1">
               <input type="text" id="<?php echo $this->plugin_name; ?>-specific_page1" name="<?php echo $this->plugin_name; ?>[specific_page1]" value="<?php echo $specific_page1; ?>" />
               <span><?php esc_attr_e('Paste the page IDs for the pages that need the pixel above (comma seperated)', $this->plugin_name); ?></span>
            </label>
         </fieldset>
      </div>

       <button id="click2">Paste additional code to be placed on one or more specific pages</button>
      <div class="specific2">
         <fieldset>
            <legend class="screen-reader-text"><span>Specific Pixels to be placed on one or more specific pages</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_pixels_for_page2">
               <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-specific_pixels_for_page2" name="<?php echo $this->plugin_name; ?>[specific_pixels_for_page2]"  /><?php echo $specific_pixels_for_page2; ?></textarea>
               <span><?php esc_attr_e('Paste additional pixels to be placed on one or more specific pages', $this->plugin_name); ?></span>
            </label>
            <br>
            <legend class="screen-reader-text"><span>Paste the page IDs for the pages that need the pixel above</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_page2">
               <input type="text" id="<?php echo $this->plugin_name; ?>-specific_page2" name="<?php echo $this->plugin_name; ?>[specific_page2]" value="<?php echo $specific_page2; ?>" />
               <span><?php esc_attr_e('Paste the page IDs for the pages that need the pixel above (comma seperated)', $this->plugin_name); ?></span>
            </label>
         </fieldset>
      </div>

   <button id="click3">Paste additional code to be placed on one or more specific pages</button>
      <div class="specific3">
         <fieldset>
            <legend class="screen-reader-text"><span>Specific Pixels to be placed on one or more specific pages</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_pixels_for_page3">
               <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-specific_pixels_for_page3" name="<?php echo $this->plugin_name; ?>[specific_pixels_for_page3]" /><?php echo $specific_pixels_for_page3; ?></textarea>
               <span><?php esc_attr_e('Paste additional pixels to be placed on one or more specific pages', $this->plugin_name); ?></span>
            </label>
            <br>
            <legend class="screen-reader-text"><span>Paste the page IDs for the pages that need the pixel above</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_page3">
               <input type="text" id="<?php echo $this->plugin_name; ?>-specific_page3" name="<?php echo $this->plugin_name; ?>[specific_page3]" value="<?php echo $specific_page3; ?>"  />
               <span><?php esc_attr_e('Paste the page IDs for the pages that need the pixel above (comma seperated)', $this->plugin_name); ?></span>
            </label>
         </fieldset>
      </div>

   <button id="click4">Paste additional code to be placed on one or more specific pages</button>
      <div class="specific4">
         <fieldset>
            <legend class="screen-reader-text"><span>Specific Pixels to be placed on one or more specific pages</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_pixels_for_page4">
               <textarea type="checkbox" id="<?php echo $this->plugin_name;?>-specific_pixels_for_page4" name="<?php echo $this->plugin_name; ?>[specific_pixels_for_page4]" /><?php echo $specific_pixels_for_page4; ?></textarea>
               <span><?php esc_attr_e('Paste additional pixels to be placed on one or more specific pages', $this->plugin_name); ?></span>
            </label>
            <br>
            <legend class="screen-reader-text"><span>Paste the page IDs for the pages that need the pixel above</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-specific_page4">
               <input type="text" id="<?php echo $this->plugin_name; ?>-specific_page4" name="<?php echo $this->plugin_name; ?>[specific_page4]" value="<?php echo $specific_page4; ?>"  />
               <span><?php esc_attr_e('Paste the page IDs for the pages that need the pixel above (comma seperated)', $this->plugin_name); ?></span>
            </label>
         </fieldset>
      </div>



	   <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

   </form>

</div>