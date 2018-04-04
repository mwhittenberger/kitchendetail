<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://mikethetechninja.com
 * @since      1.0.0
 *
 * @package    Wordpress_Loves_Constant_Contact
 * @subpackage Wordpress_Loves_Constant_Contact/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

   <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
<br>
   <form method="post" name="wphcc_options" action="options.php">

	   <?php
		   //Grab all options
		   $options = get_option($this->plugin_name);

		   // Cleanup
		   $apikey = $options['apikey'];
		   $apisecret = $options['apisecret'];
		   $login_logo_id = 0;
		   if(isset($options['login_logo_id']))
	         $login_logo_id = $options['login_logo_id'];
	      $login_logo = wp_get_attachment_image_src( $login_logo_id, 'thumbnail' );
	      $login_logo_url = $login_logo[0];
	      $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	      /*
	      $service_url = 'https://oauth2.constantcontact.com/oauth2/oauth/siteowner/authorize?response_type=code&client_id='.$apikey.'&redirect_uri='.$actual_link;
	      $curl = curl_init($service_url);
	      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	      curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );
	      $curl_response = curl_exec($curl);
	      print_r($curl_response);
	      if ($curl_response === false) {
		      $info = curl_getinfo($curl);
		      curl_close($curl);
		      die('error occured during curl exec. Additional info: ' . var_export($info));
	      }
	      curl_close($curl);
	      //$decoded = json_decode($curl_response);
	      /*if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		      die('error occured: ' . $decoded->response->errormessage);
	      }
	      echo 'response ok!';
	      var_export($decoded->response);*/

	   ?>

	   <?php
		   settings_fields($this->plugin_name);
		   do_settings_sections($this->plugin_name);
	   ?>

      <h2>Step 1: Enter your Constant Contact API Key and hit Save all changes.</h2>
      <a href="http://developer.constantcontact.com/home/api-keys.html" target="_blank">Follow these steps to get your API Key</a> 
      
      <fieldset>
         <legend class="screen-reader-text"><span>Constant Contact API Key</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-apikey">
            <input type="text" placeholder="CC API KEY" id="<?php echo $this->plugin_name; ?>-apikey" name="<?php echo $this->plugin_name; ?>[apikey]" class="regular-text wplcc" value="<?php if(!empty($apikey)) echo $apikey; ?>" />
            <span>Enter your CC API Key</span>
         </label>
      </fieldset>

      <h2>Step 2: After saving your API key, click the link below and create an account or sign in.</h2>
      <a href="https://api.constantcontact.com/mashery/account/<?php echo $apikey; ?>" target="_blank">Follow this link to get your Constant Contact API token after entering your API Key and saving</a>
      <fieldset>
         <legend class="screen-reader-text"><span>Constant Contact API Token</span></legend>
         <label for="<?php echo $this->plugin_name; ?>-apisecret">
            <input type="text" placeholder="CC API TOKEN" id="<?php echo $this->plugin_name; ?>-apisecret" name="<?php echo $this->plugin_name; ?>[apisecret]" class="regular-text wplcc" value="<?php if(!empty($apisecret)) echo $apisecret; ?>" />
            <span>Enter your CC API Token (<a href="https://api.constantcontact.com/mashery/account/<?php echo $apikey; ?>" target="_blank">follow this link to get it after entering your API Key and saving</a>)</span>
         </label>
      </fieldset>

      <h4>Upload a logo to be used on your email blasts</h4>
      <fieldset>
         <legend class="screen-reader-text"><span><?php esc_attr_e('Email Logo', $this->plugin_name);?></span></legend>
         <label for="<?php echo $this->plugin_name;?>-login_logo">
            <input type="hidden" id="login_logo_id" name="<?php echo $this->plugin_name;?>[login_logo_id]" value="<?php echo $login_logo_id; ?>" />
            <input id="upload_login_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', $this->plugin_name); ?>" />
            <span><?php esc_attr_e('Login Logo', $this->plugin_name);?></span>
         </label>
         <div id="upload_logo_preview" class="wp_cbf-upload-preview <?php if(empty($login_logo_id)) echo 'hidden'?>">
            <img src="<?php echo $login_logo_url; ?>" />
            <button id="wp_cbf-delete_logo_button" class="wp_cbf-delete-image">X</button>
         </div>
      </fieldset>


	   <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

   </form>

</div>