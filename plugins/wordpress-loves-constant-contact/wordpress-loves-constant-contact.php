<?php

	/**
	 * The plugin bootstrap file
	 *
	 * This file is read by WordPress to generate the plugin information in the plugin
	 * admin area. This file also includes all of the dependencies used by the plugin,
	 * registers the activation and deactivation functions, and defines a function
	 * that starts the plugin.
	 *
	 * @link              http://mikethetechninja.com
	 * @since             1.0.0
	 * @package           Wordpress_Loves_Constant_Contact
	 *
	 * @wordpress-plugin
	 * Plugin Name:       WordPress Loves Constant Contact
	 * Plugin URI:        http://mikethetechninja.com/wordpress-loves-constant-contact
	 * Description:       Utilize the Constant Contact API to send an email to your contacts to promote your latest post.
	 * Version:           1.0.0
	 * Author:            Mike the Tech Ninja
	 * Author URI:        http://mikethetechninja.com
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       wordpress-loves-constant-contact
	 * Domain Path:       /languages
	 */


// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}


	define( 'WORDPRESS_LOVES_CONSTANT_CONTACT_VERSION', '1.0.0' );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-wordpress-loves-constant-contact-activator.php
	 */
	function activate_wordpress_loves_constant_contact() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-loves-constant-contact-activator.php';
		Wordpress_Loves_Constant_Contact_Activator::activate();


	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-wordpress-loves-constant-contact-deactivator.php
	 */
	function deactivate_wordpress_loves_constant_contact() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-loves-constant-contact-deactivator.php';
		Wordpress_Loves_Constant_Contact_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_wordpress_loves_constant_contact' );
	register_deactivation_hook( __FILE__, 'deactivate_wordpress_loves_constant_contact' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */

	require plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-loves-constant-contact.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_wordpress_loves_constant_contact() {

		define( 'CTCT_FILE', __FILE__ );

		/** @define "CTCT_FILE_PATH" "./" */
		define( 'CTCT_FILE_PATH', dirname( __FILE__ ) . '/' );

		/** @define "CTCT_FILE_URL" "." */
		define( 'CTCT_FILE_URL', plugin_dir_url( __FILE__ ) );

		/** @define "CTCT_DIR_PATH" "." */
		define( 'CTCT_DIR_PATH', plugin_dir_path( __FILE__ ) );

		$plugin = new Wordpress_Loves_Constant_Contact();
		$plugin->run();

		require_once CTCT_DIR_PATH . 'vendor/constantcontact/constantcontact/src/Ctct/autoload.php';
		require_once CTCT_DIR_PATH . 'vendor/autoload.php';

		add_action( 'wp_ajax_my_action_wplcc', 'my_action_wplcc' );

	   add_action( 'wp_ajax_subscribe_wplcc', 'subscribe_wplcc' );

	   add_action( 'wp_ajax_nopriv_subscribe_wplcc', 'subscribe_wplcc' );
	   


	}

	run_wordpress_loves_constant_contact();

	use Ctct\Components\EmailMarketing\Campaign;
	use Ctct\Components\EmailMarketing\Schedule;
	use Ctct\Components\Account\VerifiedEmailAddress;
	use Ctct\ConstantContact;
	use Ctct\Exceptions\CtctException;
	use Ctct\Auth\CtctOAuth2;
	use Ctct\Exceptions\OAuth2Exception;
	use Ctct\Components\Contacts\Contact;

	/**
	 * Create an email campaign with the parameters provided
	 *
	 * @param array $params associative array of parameters to create a campaign from
	 *
	 * @return Campaign updated by server
	 *
	 *
	 */
	function createCampaign( array $params = array() ) {

		$options = get_option( 'wordpress-loves-constant-contact' );

		// Cleanup
		$apikey    = $options['apikey'];
		$apisecret = $options['apisecret'];
		define( "APIKEY", $apikey );
		define( "ACCESS_TOKEN", $apisecret );

		$cc                             = new ConstantContact( APIKEY );
		$campaign                       = new Campaign();
		$campaign->name                 = $params['name'];
		$campaign->subject              = $params['subject'];
		$campaign->from_name            = $params['from_name'];
		$campaign->from_email           = $params['from_addr'];
		$campaign->greeting_string      = $params['greeting_string'];
		$campaign->reply_to_email       = $params['reply_to_addr'];
		$campaign->text_content         = $params['text_content'];
		$email_content = str_replace('\\\"','"',$params['email_content']);
		$email_content = stripcslashes($email_content);
	   $email_content = trim($email_content,'"');
		$campaign->email_content        = '<html><body>' . $email_content . '</body></html>';
		$campaign->email_content_format = $params['format'];

		// add the selected list or lists to the campaign
		if ( isset( $params['lists'] ) ) {
			if ( count( $params['lists'] ) > 1 ) {
				foreach ( $params['lists'] as $list ) {
					$campaign->addList( $list );
				}
			} else {
				$campaign->addList( $params['lists'][0] );
			}
		}

		return $cc->emailMarketingService->addCampaign( ACCESS_TOKEN, $campaign );
	}

	/**
	 * Create a schedule for a campaign - this is time the campaign will be sent out
	 *
	 * @param $campaignId - Id of the campaign to be scheduled
	 * @param $time - ISO 8601 formatted timestamp of when the campaign should be sent
	 *
	 * @return Schedule updated by server
	 */
	function createSchedule( $campaignId, $time ) {
		$options = get_option( 'wordpress-loves-constant-contact' );

		// Cleanup
		$apikey    = $options['apikey'];
		$apisecret = $options['apisecret'];

		$cc                       = new ConstantContact( $apikey );
		$schedule                 = new Schedule();
		$schedule->scheduled_date = $time;

		return $cc->campaignScheduleService->addSchedule( $apisecret, $campaignId, $schedule );
	}

	function subscribe_wplcc() {

	   $options = get_option( 'wordpress-loves-constant-contact' );
	   $apikey    = $options['apikey'];
	   $apisecret = $options['apisecret'];
	   define( "APIKEY", $apikey );
	   define( "ACCESS_TOKEN", $apisecret );

	   $cc = new ConstantContact(APIKEY);

	   try {
		   // check to see if a contact with the email address already exists in the account
		   $response = $cc->contactService->getContacts(ACCESS_TOKEN, array("email" => $_POST['email']));

		   // create a new contact if one does not exist
		   if (empty($response->results)) {
			   $action = "Creating Contact";

			   $contact = new Contact();
			   $contact->addEmail($_POST['email']);
			   $contact->addList('1');
			   //$contact->first_name = $_POST['first_name'];
			   //$contact->last_name = $_POST['last_name'];

			   /*
			 * The third parameter of addContact defaults to false, but if this were set to true it would tell Constant
			 * Contact that this action is being performed by the contact themselves, and gives the ability to
			 * opt contacts back in and trigger Welcome/Change-of-interest emails.
			 *
			 * See: http://developer.constantcontact.com/docs/contacts-api/contacts-index.html#opt_in
			 */
			   $returnContact = $cc->contactService->addContact(ACCESS_TOKEN, $contact, true);

			   // update the existing contact if address already existed
		   } else {
			   echo "You are already subscribed to our list.";
		   }

		   // catch any exceptions thrown during the process and print the errors to screen
	   } catch (CtctException $ex) {
		   echo '<span class="label label-important">Error ' . $action . '</span>';
		   echo '<div class="container alert-error"><pre class="failure-pre">';
		   print_r($ex->getErrors());
		   echo '</pre></div>';
		   die();
	   }
	   wp_die(); // this is required to terminate immediately and return a proper response
   }


	function my_action_wplcc() {

      //print_r($_POST);
	   //wp_die(); // this is required to terminate immediately and return a proper response

		// attempt to create a campaign with the fields submitted, displaying any errors that occur
		try {
			$campaign = createCampaign( $_POST );
		} catch ( CtctException $ex ) { ?>
           <div class="error notice">
              <span class="label label-important"><h3>Error Creating Campaign</h3></span>
              <div class="container alert-error"><pre class="failure-pre">
					 <?php echo $ex->getErrors()[0]->error_message; ?>
         </pre>
              </div>
           </div>
			<?php
		}

		if ( isset( $campaign ) ) {
			try {
			   $blast_time = $_POST['schedule_date'].'T'.$_POST['schedule_time'].':00.000Z';

			   //echo "the time is ".$blast_time;

				$schedule = createSchedule( $campaign->id, $blast_time );
			} catch ( CtctException $ex ) {
				echo '<div class="error notice"><span class="label label-important"><h3>Error Scheduling Campaign</h3></span>';
				echo '<div class="container alert-error"><pre class="failure-pre">';
				print_r( $ex->getErrors() );
				echo '</pre></div></div>';

			}
		}

		// print the contents of the campaign to screen
		if ( isset( $campaign ) ) {
			echo '<span class="label label-success">Campaign Created!</span>';
			echo '<div class="container alert-success"><pre class="success-pre">';
			print_r( $campaign );
			echo '</pre></div>';
		}

// print the contents of the schedule to screen
		if ( isset( $schedule ) ) {
			echo '<span class="label label-success">Campaign Scheduled!</span>';
			echo '<div class="container alert-success"><pre class="success-pre">';
			print_r( $schedule );
			echo '</pre></div>';
		}


		wp_die(); // this is required to terminate immediately and return a proper response
	}


// display the metabox
	function my_customfield_box_content() {


		// nonce field for security check, you can have the same
		// nonce field for all your meta boxes of same plugin
		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_nonce' );


		//require_once '../wp-content/plugins/wordpress-loves-constant-contact/admin/vendor/constantcontact/constantcontact/src/Ctct/Components/EmailMarketing/Campaign.php';


		$options = get_option( 'wordpress-loves-constant-contact' );

		// Cleanup
		$apikey      = $options['apikey'];
		$apisecret   = $options['apisecret'];
		$header_logo = $options['login_logo_id'];
		define( "APIKEY", $apikey );
		define( "ACCESS_TOKEN", $apisecret );

		$cc   = new ConstantContact( APIKEY );
		$date = date( 'Y-m-d\TH:i:s\.000\Z', strtotime( "+1 month" ) );

		// attempt to get the lists in this account, displaying any errors that occur
		try {
			$lists = $cc->listService->getLists( ACCESS_TOKEN );
		} catch ( CtctException $ex ) {
			echo '<div class="container alert-error"><pre class="failure-pre">';
			print_r( $ex->getErrors() );
			echo '</pre></div>';
			die();
		}

		$verified_emails = $cc->accountService->getVerifiedEmailAddresses(ACCESS_TOKEN, array( "status" => 'ALL'));

		//$campaigndeats    = $cc->emailMarketingService->getCampaigns( ACCESS_TOKEN, array( "limit" => 1 ) );
		//$last_campaign_id = $campaigndeats->results[0]->id;
		//$campaigndeats    = $cc->emailMarketingService->getCampaign( ACCESS_TOKEN, $last_campaign_id );
		//print_r($campaigndeats);
		//$from_email = $campaigndeats->from_email;

		$actual_link = ( isset( $_SERVER['HTTPS'] ) ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$post_object = get_post( $_GET["post"] );


		?>
      Fields marked with * are required.<br><br>
       <div class="well">

          <form class="form-horizontal" name="CCLWPemailForm" id="emailForm" method="POST"
                action="<?php echo $actual_link; ?>">
             <div class="span6">
                <fieldset>
                   <div class="control-group">
                      <label class="control-label" for="name">Campaign Name*</label>

                      <div class="controls">
                         <input type="text" id="name" name="name"
                                value="Promo for <?php echo get_the_title( $_GET["post"] ); ?>"
                                class="required regular-text wplcc" placeholder="Campaign Name">
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="subject">Subject*</label>

                      <div class="controls">
                         <input type="text" id="subject"
                                value="Read the latest post from <?php echo get_bloginfo( 'name' ); ?>" name="subject"
                                placeholder="Subject" class="regular-text wplcc">
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="from_name">From Name*</label>

                      <div class="controls">
                         <input type="text" id="from_name" value="<?php echo get_bloginfo( 'name' ); ?>"
                                name="from_name" placeholder="From Name" class="regular-text wplcc">
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="from_addr">From Email*</label>

                      <div class="controls">
                         <select id="from_addr" name="from_addr"  class="wplcc">
	                      <?php
                            $x = 0;
		                      foreach ( $verified_emails as $email ) {
		                         $selected = '';
		                         if($x == 0)
		                            $selected = 'selected';
			                      echo '<option value="' . $email->email_address . '" '.$selected.' >' . $email->email_address . '</option><br />';
			                      $x++;
		                      }
		                      ?>
                          </select>

                         <!--<input type="email" id="from_addr" value="<?php //echo $from_email; ?>" name="from_addr"
                                placeholder="From Email" class="regular-text wplcc"> -->
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="name">Text Content</label>

                      <div class="controls">
                         <textarea id="text_content" name="text_content" placeholder="Text Content"
                                   class="regular-text wplcc">Follow this link ( <?php echo get_the_permalink( $_GET["post"] ); ?>) to read the latest post, <?php echo get_the_title( $_GET["post"] ); ?>, from <?php echo get_bloginfo( 'name' ); ?>.</textarea>
                      </div>
                   </div>

                </fieldset>
             </div>

             <div class="span6">
                <fieldset>

                   <div class="control-group">
                      <label class="control-label" for="reply_to_addr">Reply-To Email*</label>

                      <div class="controls">
                         <!--<input type="email" value="<?php //echo $from_email; ?>" id="reply_to_addr" name="reply_to_addr"
                                placeholder="Reply To" class="regular-text wplcc">-->
                         <select id="reply_to_addr" name="reply_to_addr" class="wplcc">
	                         <?php
		                         $x = 0;
		                         foreach ( $verified_emails as $email ) {
			                         $selected = '';
			                         if($x == 0)
				                         $selected = 'selected';
			                         echo '<option value="' . $email->email_address . '" '.$selected.' >' . $email->email_address . '</option><br />';
			                         $x++;
		                         }
	                         ?>
                         </select>
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="format">Lists to send to*: </label>

                      <div class="controls">
                         <select multiple="multiple" id="lists" name="lists[]" size="8" class="wplcc">
							 <?php
								 foreach ( $lists as $list ) {
									 echo '<option value="' . $list->id . '" >' . $list->name . '</option><br />';
								 }
							 ?>
                         </select>
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="format">Send Time*</label>

                      <div class="controls">
                         <input type="date" class="wplcc" name="schedule_date" id="schedule_date"
                                value="<?php echo date( 'Y-m-d', strtotime( "+1 day" ) ); ?>"/>
                         <input type="time" class="wplcc" name="schedule_time" id="schedule_time"
                                value="10:00"/>
                      </div>
                   </div>
                   <div class="control-group">
                      <label class="control-label" for="format">Email Content Format*</label>

                      <div class="controls">
                         <input type="hidden" name="wplcc-check" value="TRUE">
                         <input type="radio" id="name" name="format" value="HTML" checked> HTML
                         <input type="radio" id="name" name="format" value="XHTML"> XHTML
                      </div>
                   </div>
                </fieldset>
             </div>
             <br clear="all"/>

             <div class="control-group">

                <label class="control-label" for="email_content">Email Content*</label>

                <div class="controls">
					<?php wp_editor( wp_get_attachment_image( $header_logo, 'full', false, array( "style" => "margin:0 auto;display:block;max-width:300px;height:auto;" ) ) . '<br><br>Follow this link ( <a href="' . get_the_permalink( $_GET["post"] ) . '">' . get_the_permalink( $_GET["post"] ) . '</a> ) to read the latest post, <strong>' . get_the_title( $_GET["post"] ) . '</strong>, from ' . get_bloginfo( "name" ) . '.<br><br><hr>' . get_the_post_thumbnail( $_GET["post"], 'full', false, array( "style" => "margin:0 auto;display:block;max-width:500px;height:auto;" ) ) . '<br><span style="font-size:20px;font-weight:bold;">' . get_the_title( $_GET["post"] ) . '</span><br>' . wp_trim_words( wp_strip_all_tags( $post_object->post_content, false ), 40, "..." ) . '<br><a href="' . get_the_permalink( $_GET["post"] ) . '">Read The Entire Post</a>', 'email_content' ); ?>

                </div>

                <label class="control-label">
                   <div class="controls">
					   <?php submit_button( 'Create & Schedule', 'primary', 'submit', true ); ?>
                      <div class="messages"></div>
                   </div>
             </div>

          </form>
          <script type="text/javascript">
             jQuery('#submit').click(function (event) {
                console.log("submitting...");

                jQuery('.messages').empty();
                jQuery('.messages').append("Communicating with Constant Contact, please wait.");

                event.preventDefault();

                var error_flag = 0;
                jQuery('.wplcc').each(function(){
                   console.log(jQuery(this).attr('id'));
                   console.log(jQuery(this).val());
                   if(!jQuery(this).val()) {
                      error_flag = 1;
                      jQuery(this).css('background-color','red');
                   }
                   if(error_flag == 1) {
                      jQuery('.messages').empty();
                      jQuery('.messages').append("One or more required fields were not filled in correctly. Please check the fields above highlighted in red.");
                   }
                });

                var emailcontent = tinymce.editors['email_content'].getContent();
                var emailcontent = JSON.stringify(emailcontent);
                console.log(emailcontent);
                //emailcontent = emailcontent.replace(/\"/g,"'");

                var data = {

                   'action': 'my_action_wplcc',
                   'name': jQuery('#wplcc').find('#name').val(),
                   'subject': jQuery('#wplcc').find('#subject').val(),
                   'from_name': jQuery('#wplcc').find('#from_name').val(),
                   'from_addr': jQuery('#wplcc').find('#from_addr').val(),
                   'greeting_string': jQuery('#wplcc').find('#greeting_string').val(),
                   'reply_to_addr': jQuery('#wplcc').find('#reply_to_addr').val(),
                   'text_content': jQuery('#wplcc').find('#text_content').val(),
                   'format': jQuery('#wplcc').find('#format').val(),
                   'schedule_time': jQuery('#wplcc').find('#schedule_time').val(),
                   'schedule_date': jQuery('#wplcc').find('#schedule_date').val(),
                   'lists': jQuery('#wplcc').find('#lists').val(),
                   'email_content' : emailcontent

                };

                console.log(data);

               if(error_flag == 0) {
                  jQuery.post(ajaxurl, data, function (response) {
                     jQuery('.messages').empty();
                     jQuery('.messages').append(response);
                  });
               }

             });
          </script>
       </div>
	<? } ?>