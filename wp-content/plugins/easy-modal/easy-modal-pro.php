<?php
if (!defined('EASYMODALPRO'))
	define('EASYMODALPRO', 'Easy Modal Pro');
if (!defined('EASYMODALPRO_VERSION'))
	define('EASYMODALPRO_VERSION', '1.3.0.5p');
class Easy_Modal_Pro extends Easy_Modal
{
	public function __construct()
	{
		parent::__construct();
		// Add WPMU Support
		// Add default options on new site creation.
		add_action('wpmu_new_blog', array(&$this, '_wpmu_activation'));
		// Allow us to run Ajax on the login.
		$settings = $this->getSettings();
		if(!is_admin())
		{
			add_filter('em_preload_modals_single',array(&$this,'preload_modal_filters'),1);
		}

		if($settings['login_modal_enabled'])
		{
			add_action( 'wp_ajax_nopriv_ajaxlogin', array(&$this, 'ajax_login' ) );
			add_filter( 'login_form_bottom', array(&$this, 'login_nonce'));
			add_filter( 'loginout', array(&$this, 'filter_loginout'));	
			add_filter( 'register', array(&$this, 'filter_register'));	
		}
		add_shortcode( 'easymodal_login', array(&$this, 'shortcode_login_modal'));
		add_shortcode( 'easymodal_register', array(&$this, 'shortcode_register_modal'));
		add_shortcode( 'easymodal_forgot', array(&$this, 'shortcode_forgot_modal'));
		if(isset($_POST['export']))
		{
			add_action( 'plugins_loaded',array(&$this, 'export'),1);
		}
		$check_time = strtotime('-1 week');
		if( get_option('EasyModal_License_LastChecked') < $check_time )
		{
			$license = get_option('EasyModal_License');
			$license_status = $this->check_license($license);
			update_option('EasyModal_License_Status', $license_status);
			if(in_array($license_status['status'], array(2000,2001,3002,3003)))
			{
				update_option('EasyModal_License_LastChecked', strtotime(date("Y-m-d H:i:s")));
				delete_option('_site_transient_update_plugins');
			}
		}
	}
	public function process_get()
	{
		parent::process_get();
		$theme_id = isset($_GET['theme_id']) ? $_GET['theme_id'] : NULL;
		if($theme_id>0 && isset($_GET['action']) && wp_verify_nonce($_GET['safe_csrf_nonce_easy_modal'], "safe_csrf_nonce_easy_modal"))
		{
			switch($_GET['action'])
			{
				case 'delete':
					if(!empty($_GET['confirm']))
					{
						$this->deleteTheme($theme_id);
						wp_redirect('admin.php?page='.EASYMODAL_SLUG.'-themes',302);
					}
				break;
				case 'clone':
					$settings = $this->updateThemeSettings('clone', $this->getThemeSettings( $theme_id ));
					wp_redirect('admin.php?page='.EASYMODAL_SLUG.'-themes&theme_id='.$settings['id'],302);
				break;
			}
		}
	}
	public function shortcode_login_modal( $atts )
	{
		global $user_login; get_currentuserinfo();
		$args = array(
		        'echo' => true,
		        'redirect' => site_url( $_SERVER['REQUEST_URI'] ), 
		        'form_id' => 'loginform',
		        'label_username' => __( 'Username' ),
		        'label_password' => __( 'Password' ),
		        'label_remember' => __( 'Remember Me' ),
		        'label_log_in' => __( 'Log In' ),
		        'id_username' => 'user_login',
		        'id_password' => 'user_pass',
		        'id_remember' => 'rememberme',
		        'id_submit' => 'wp-submit',
		        'remember' => true,
		        'value_username' => $user_login,
		        'value_remember' => false
		);
		return apply_filters('em_login_modal', wp_login_form( $args ));
	}
	public function shortcode_register_modal( $atts )
	{
		$settings = $this->getSettings();
		global $user_email, $user_login;
		get_currentuserinfo();
		$multisite_reg = get_site_option( 'registration' );
		$content = "";
		if ( ( get_option( 'users_can_register' ) && ! is_multisite() ) || ( $multisite_reg == 'all' || $multisite_reg == 'blog' || $multisite_reg == 'user' ) ) :
		$content .= '<form action="' .get_bloginfo('wpurl'). '/wp-login.php?action=register" method="post">';
			$content .= '<p>';
				$content .= '<label class="field-titles" for="reg_user">'. _( 'Username', 'easy-modal' ). '</label>';
				$content .= '<input type="text" name="user_login" id="reg_user" class="input" value="' .esc_attr( isset( $user_login ) ? stripslashes( $user_login ) : ""). '" size="20" tabindex="1" />';
			$content .= '</p>';
			$content .= '<p>';
				$content .= '<label class="field-titles" for="reg_email">'. _( 'Email', 'easy-modal' ). '</label>';
				$content .= '<input type="text" name="user_email" id="reg_email" class="input" value="' .esc_attr( stripslashes( isset( $user_email ) ? $user_email : "" ) ). '" size="20" tabindex="3" />';
			$content .= '</p>';
			if($settings['registration_modal']['enable_password']):
			$content .= '<p>';
				$content .= '<label class="field-titles" for="reg_pass">' ._( 'Password', 'easy-modal' ). '</label>';
				$content .= '<input type="password" name="reg_pass" id="reg_pass" class="input" size="20" tabindex="3" />';
				$content .= '<label class="field-titles" for="reg_confirm">' ._( 'Confirm Password', 'easy-modal' ). '</label>';
				$content .= '<input type="password" name="reg_confirm" id="reg_confirm" class="input" size="20" tabindex="3" />';
			$content .= '</p>';
			endif;
			$content .= '<p class="submit">';
				$content .= '<input type="submit" name="user-sumbit" id="user-submit" class="button button-primary button-large" value="' .esc_attr( 'Sign Up', 'easy-modal' ). '" />';
				$content .= '<input type="hidden" name="safe_csrf_nonce_easy_modal" id="safe_csrf_nonce_easy_modal" value="' .wp_create_nonce("safe_csrf_nonce_easy_modal",'easy-modal'). '"/>';
			$content .= '</p>';
		$content .= '</form>';
		endif;
		return apply_filters('em_register_modal', $content);
	}
	public function shortcode_forgot_modal( $atts )
	{
		global $user_login; get_currentuserinfo();
		$content = '<form action="' .wp_lostpassword_url(). '" method="post">';
			$content .= '<p>';
				$content .= '<label class="field-titles" for="forgot_login">' ._( 'Username or Email', 'easy-modal' ). '</label>';
				$content .= '<input type="text" name="forgot_login" id="forgot_login" class="input" value="' .esc_attr( stripslashes( $user_login ) ). '" size="20" />';
			$content .= '</p>';
			$content .= '<p class="submit">';
				$content .= '<input type="submit" name="user-submit" id="user-submit" class="button button-primary button-large" value="' .esc_attr( 'Reset Password', 'easy-modal' ). '">';
				$content .= '<input type="hidden" name="safe_csrf_nonce_easy_modal" id="safe_csrf_nonce_easy_modal" value="' .wp_create_nonce("safe_csrf_nonce_easy_modal",'easy-modal'). '"/>';
			$content .= '</p>';
		$content .= '</form>';
		return apply_filters('em_forgot_modal', $content);
	}
	public function login_nonce($content)
	{
		if( ! is_admin() && ! is_user_logged_in() )
		{
			$content .= '<input type="hidden" name="safe_csrf_nonce_easy_modal" id="safe_csrf_nonce_easy_modal" value="'. wp_create_nonce("safe_csrf_nonce_easy_modal",'easy-modal').'"/>';
			$register = wp_register('','',false);
			$content .= !empty($register) ? "<p>Don't have an account? ".$register."</p>" : "";
			$content .= "<p>Forgot your password? <a href='".wp_lostpassword_url()."' class='eModal-Forgot'>Click here</a></p>";
		}
		return $content;	
	}
	public function filter_loginout($link)
	{
		if(!empty($link))
		{
				$html = new DOMDocument();
			$html->loadHTML($link);
			$anchor = $html->getElementsByTagName('a')->item(0);
			if(!empty($anchor) && $anchor->hasAttribute('class'))
			{
				$classes = explode(' ', $anchor->getAttribute('class'));
				if(!in_array('eModal-Login', $classes))
					$classes[] = 'eModal-Login'; //Append the new value
				$classes = array_map('trim', array_filter($classes)); //Clean existing values
				$anchor->setAttribute('class', implode(' ', $classes)); //Set cleaned attribute
			}
			else
			{
				$anchor->setAttribute('class', 'eModal-Login');
			}
			return $html->saveXML($anchor);
		}
		return $link;
	}
	public function filter_register($link)
	{
		if(!empty($link))
		{
			$html = new DOMDocument();
			$html->loadHTML($link);
			$anchor = $html->getElementsByTagName('a')->item(0);
			if(!empty($anchor) && $anchor->hasAttribute('class'))
			{
				$classes = explode(' ', $anchor->getAttribute('class'));
				if(!in_array('eModal-Register', $classes))
					$classes[] = 'eModal-Register'; //Append the new value
				$classes = array_map('trim', array_filter($classes)); //Clean existing values
				$anchor->setAttribute('class', implode(' ', $classes)); //Set cleaned attribute
			}
			else
			{
				$anchor->setAttribute('class', 'eModal-Register');
			}
			return $html->saveXML($anchor);
		}
		return $link;
	}
	public function autoOpenModal()
	{
		if(empty($this->autoOpenModal))
		{
			$post_id = get_the_ID();
			$settings = $this->getSettings();
			if(($settings['force_user_login'] || get_post_meta( $post_id, 'easy_modal_post_force_user_login', true )) && !is_user_logged_in() && $settings['login_modal_enabled'])
			{
				$this->autoOpenModal = array(
					'id' => 'Login',
					'delay' => $settings['autoOpen_delay'],
					'timer' => 0.000001
				);
			}
			elseif(is_numeric(get_post_meta( $post_id, 'easy_modal_post_autoOpen_id', true )))
			{
				$this->autoOpenModal = array(
					'id' => get_post_meta( $post_id, 'easy_modal_post_autoOpen_id', true ),
					'delay' => get_post_meta( $post_id, 'easy_modal_post_autoOpen_delay', true ),
					'timer' => get_post_meta( $post_id, 'easy_modal_post_autoOpen_timer', true )
				);
			}
			elseif(in_array(get_post_meta( $post_id, 'easy_modal_post_autoOpen_id', true ), array('Login','Register','Forgot')) && !is_user_logged_in() && $settings['login_modal_enabled'])
			{
				$this->autoOpenModal = array(
					'id' => get_post_meta( $post_id, 'easy_modal_post_autoOpen_id', true ),
					'delay' => get_post_meta( $post_id, 'easy_modal_post_autoOpen_delay', true ),
					'timer' => get_post_meta( $post_id, 'easy_modal_post_autoOpen_timer', true )
				);
			}
			elseif(is_numeric($settings['autoOpen_id']))
			{
				$this->autoOpenModal = array(
					'id' => $settings['autoOpen_id'],
					'delay' => $settings['autoOpen_delay'],
					'timer' => $settings['autoOpen_timer']
				);
			}
			else
			{
				$this->autoOpenModal = false;
			}
		}
		return $this->autoOpenModal;
	}
	public function autoExitModal()
	{
		if(empty($this->autoExitModal))
		{
			$post_id = get_the_ID();
			$settings = $this->getSettings();
			if(is_numeric(get_post_meta( $post_id, 'easy_modal_post_autoExit_id', true )))
			{
				$this->autoExitModal = array(
					'id' => get_post_meta( $post_id, 'easy_modal_post_autoExit_id', true ),
					'timer' => get_post_meta( $post_id, 'easy_modal_post_autoExit_timer', true )
				);
			}
			elseif(is_numeric($settings['autoExit_id']))
			{
				$this->autoExitModal = array(
					'id' => $settings['autoExit_id'],
					'timer' => $settings['autoExit_timer']
				);
			}
			else
			{
				$this->autoExitModal = false;
			}
		}
		return $this->autoExitModal;
	}
	public function export()
	{
		if(isset($_POST['export']))
		{
			require EASYMODAL_DIR.'/pro/xml.php';
			$data = array(
				'@attributes' => array(
					'type' => $_POST['type'],
					'date' => date("Y-m-d"),
					'version' => get_option('EasyModal_Version')
				));
			
			if(in_array($_POST['type'], array('full','modals','themes')))
			{
				$themes = array();
				foreach($this->getThemeList() as $id => $name)
				{
					$themes[$id] = $name;
				}
			}
			switch($_POST['type'])
			{
				case "full" :
					$data['settings'] = $this->getSettings();
					foreach($themes as $id => $name)
					{
						$data['themes']['theme'][] = $this->getThemeSettings($id);					
					}			
					foreach($this->getModalList() as $id => $name)
					{
						$modal = $this->getModalSettings($id);
						$modal['theme'] = $themes[$modal['theme']];
						unset($modal['modal_id']);
						$data['modals']['modal'][] = $modal;
					}
					break;
				case "modals" :
					foreach($this->getModalList() as $id => $name)
					{
						$modal = $this->getModalSettings($id);
						$modal['theme'] = $themes[$modal['theme']];
						unset($modal['modal_id']);
						$data['modals']['modal'][] = $modal;
					}
					break;
				case "themes" :
					foreach($themes as $id => $name)
					{
						$data['themes']['theme'][] = $this->getModalSettings($id);					
					}			
					break;
				case "settings" :
					$data['settings'] = $this->getSettings();
					break;
			}
			$xml = Array2XML::createXML('em', $data);
			$filename = "easy-modal-{$_POST['type']}-" . date("Y-m-d") . ".xml";
			header('Content-Description: File Transfer');
			header("Content-Disposition: attachment; filename=$filename");
			header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
			echo $xml->saveXML();
			die();
		}
	}
	public function import()
	{
		if(isset($_FILES['import']))
		{
			
			$importFile = $_FILES['import'];
			if(file_exists($importFile['tmp_name']))
			{
				$xml = file_get_contents($importFile['tmp_name']);
				if(!$xml)
				{
					return new WP_Error('reading_error', 'Error when reading file'); //return error object
				}
				
				require EASYMODAL_DIR.'/pro/xml.php';
				$data = XML2Array::createArray($xml);
				$data = $data['em'];
				
				$type = $data['@attributes']['type'];
				if(isset($_POST['force_reset']))
				{
					$this->resetOptions();
					if(in_array($type, array('full','themes')))
					{
						$this->deleteTheme(1);
					}
				}
				switch($type)
				{
					case "full" :
						$settings = $this->updateSettings($data['settings']);
						foreach($data['themes']['theme'] as $theme)
						{
							$theme = $this->updateThemeSettings('new',$theme);
						}			
						$themes = array();
						foreach($this->getThemeList() as $id => $name)
						{
							$themes[$name] = $id;	
						}
						foreach($data['modals']['modal'] as $modal)
						{
							$modal['theme'] = isset($themes[$modal['theme']]) ? $themes[$modal['theme']] : 1;
							if(!in_array($modal['id'],array('Login','Register','Forgot')))
							{
								unset($modal['id']);
								$this->updateModalSettings('new',$modal);
							}
							else
							{
								$this->updateModalSettings($modal['id'],$modal);
							}
						}
						break;
					case "modals" :
						$themes = array();
						foreach($this->getThemeList() as $id => $name)
						{
							$themes[$name] = $id;	
						}
						foreach($data['modals']['modal'] as $modal)
						{
							$modal['theme'] = isset($themes[$modal['theme']]) ? $themes[$modal['theme']] : 1;
							if(!in_array($modal['id'],array('Login','Register','Forgot')))
							{
								unset($modal['id']);
								$this->updateModalSettings('new',$modal);
							}
							else
							{
								$this->updateModalSettings($modal['id'],$modal);
							}
							
						}
						break;
					case "themes" :
						foreach($data['themes']['theme'] as $theme)
						{
							$this->updateThemeSettings('new',$theme);
						}
						break;
					case "settings" :
						$settings = $this->updateSettings($data['settings']);
						break;
				}
				$this->get_messages();
				unset($this->messages);
				$this->message('Imported Succesfully');
				$this->get_messages();
			}
		}
	}
	public function _styles_scripts()
	{
		if (is_admin())
		{
			add_action("admin_head-toplevel_page_easy-modal",array(&$this,'admin_styles'));
			add_action("admin_head-toplevel_page_easy-modal",array(&$this,'admin_scripts'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-themes",array(&$this,'admin_styles'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-themes",array(&$this,'admin_scripts'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-settings",array(&$this,'admin_styles'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-settings",array(&$this,'admin_scripts'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-help",array(&$this,'admin_styles'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-help",array(&$this,'admin_scripts'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-importexport",array(&$this,'admin_styles'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-importexport",array(&$this,'admin_scripts'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-support",array(&$this,'admin_styles'));
			add_action("admin_head-easy-modal-pro_page_easy-modal-support",array(&$this,'admin_scripts'));
        }
		else
		{
			add_action('wp_print_styles', array(&$this, 'styles') );
			add_action('wp_print_scripts', array(&$this, 'scripts') );
		}
	}
	public function _menus()
	{
		add_menu_page( EASYMODALPRO,  EASYMODALPRO, 'edit_posts', EASYMODAL_SLUG, array(&$this, 'modal_page'),EASYMODAL_URL.'/inc/images/admin/dashboard-icon.png',1000);
		add_submenu_page( EASYMODAL_SLUG, 'Modals', 'Modals', 'edit_posts', EASYMODAL_SLUG, array(&$this, 'modal_page')); 
		add_submenu_page( EASYMODAL_SLUG, 'Themes', 'Themes', 'edit_themes', EASYMODAL_SLUG.'-themes', array(&$this, 'theme_page')); 
		add_submenu_page( EASYMODAL_SLUG, 'Settings', 'Settings', 'manage_options', EASYMODAL_SLUG.'-settings', array(&$this, 'settings_page')); 
		add_submenu_page( EASYMODAL_SLUG, 'Import/Export', 'Import/Export', 'manage_options', EASYMODAL_SLUG.'-importexport', array(&$this, 'importexport_page')); 
		//add_submenu_page( EASYMODAL_SLUG, 'Support', 'Support', 'edit_posts', EASYMODAL_SLUG.'-support', array(&$this, 'support_page')); 
		add_submenu_page( EASYMODAL_SLUG, 'Help', 'Help', 'edit_posts', EASYMODAL_SLUG.'-help', array(&$this, 'help_page')); 
	}
	public function _actionLinks( $links, $file )
	{
		if ( $file == 'easy-modal/easy-modal.php' )
		{
			$posk_links = '<a href="'.get_admin_url().'admin.php?page='.EASYMODAL_SLUG.'-settings">'.__('Settings').'</a>';
			array_unshift( $links, $posk_links );
			$posk_links = '<a href="http://wizardinternetsolutions.com/plugins/easy-modal/support?utm_source=em-pro&utm_medium=dashboard+link&utm_campaign=pro+support">'.__('Support').'</a>';
			array_unshift( $links, $posk_links );
		}
		return $links;
	}
	
	public function scripts()
	{
		$settings = $this->getSettings();
		wp_enqueue_script('animate-colors', EASYMODAL_URL.'/inc/js/jquery.animate-colors-min.js', array('jquery'));
		wp_enqueue_script('cookies', EASYMODAL_URL.'/inc/js/jquery.cookie.js', array('jquery'));
		wp_enqueue_script(EASYMODAL_SLUG.'-scripts', EASYMODAL_URL.'/inc/js/easy-modal.min.js', array('jquery','cookies'));
		$data = array(
			'modals' => $this->enqueue_modals(),
			'themes' => $this->enqueue_themes(),
			'autoOpen' => $this->autoOpenModal(),
			'autoExit' => $this->autoExitModal()
		);
		// Only run our ajax stuff when the user isn't logged in.
		if ( ! is_user_logged_in() && $settings['login_modal_enabled'] )
		{
			$data['ajaxLogin'] = admin_url( 'admin-ajax.php' );
			$data['redirecturl'] = esc_url($_SERVER['REQUEST_URI']);
			$data['loadingtext'] = __( 'Checking login info', 'easy-modal' );
		}
		if($settings['force_user_login'] || get_post_meta(  get_the_ID(), 'easy_modal_post_force_user_login', true ))
		{
			$data['force_user_login'] = true;
		}
		$params = array(
			'l10n_print_after' => 'easymodal = ' . json_encode($data) . ';'
		);
		wp_localize_script( EASYMODAL_SLUG.'-scripts', 'easymodal', $params );
	}
	
	
	public function ajax_login()
	{
		// Check our nonce and make sure it's correct.
		
		check_ajax_referer( 'safe_csrf_nonce_easy_modal','easy-modal');
		// Get our form data.
		$data = array();
		// Check that we are submitting the login form
		if ( isset( $_REQUEST['login'] ) )  {
			$data['user_login'] 	  = sanitize_user( $_REQUEST['username'] );
			$data['user_password'] = sanitize_text_field( $_REQUEST['password'] );
			$data['rememberme'] 	  = sanitize_text_field( $_REQUEST['rememberme'] );
			$user_login 			  = wp_signon( $data, false );
			// Check the results of our login and provide the needed feedback
			if ( is_wp_error( $user_login ) ) {
				echo json_encode( array(
					'loggedin' => false,
					'message'  => __( 'Wrong Username or Password!', 'easy-modal' ),
				) );
			} else {
				echo json_encode( array(
					'loggedin' => true,
					'message'  => __( 'Login Successful!', 'easy-modal' ),
				) );
			}
		}
		// Check if we are submitting the register form
		elseif ( isset( $_REQUEST['register'] ) )
		{
			$user_data = array(
				'user_login' => sanitize_user( $_REQUEST['user_login'] ),
				'user_email' => sanitize_email( $_REQUEST['user_email'] ),
				'user_pass' => sanitize_text_field( $_REQUEST['user_pass'] ),				
			);
			$user_register = $this->register_new_user( $user_data['user_login'], $user_data['user_email'], $user_data['user_pass'] );
			// Check if there were any issues with creating the new user
			if ( is_wp_error( $user_register ) )
			{
				echo json_encode( array(
					'registerd' => false,
					'message'   => $user_register->get_error_message(),
				) );
			}
			else
			{
				echo json_encode( array(
					'registerd' => true,
					'message'	=> __( 'Registration complete. Please check your e-mail.', 'easy-modal' ),
				) );
			}
		}
		// Check if we are submitting the forgotten pwd form
		elseif ( isset( $_REQUEST['forgotten'] ) ) {
			// Check if we are sending an email or username and sanitize it appropriately
			if ( is_email( $_REQUEST['username'] ) ) {
				$username = sanitize_email( $_REQUEST['username'] );
			} else {
				$username = sanitize_user( $_REQUEST['username'] );
			}
			// Send our information
			$user_forgotten = $this->retrieve_password( $username );
			// Check if there were any errors when requesting a new password
			if ( is_wp_error( $user_forgotten ) ) {
				echo json_encode( array(
					'reset' 	 => false,
					'message' => $user_forgotten->get_error_message(),
				) );
			} else {
				echo json_encode( array(
					'reset'   => true,
					'message' => __( 'Password Reset. Please check your email.', 'easy-modal' ),
				) );
			}
		}
		//check_ajax_referer( 'safe_csrf_nonce_easy_modal');
		die();
	}
	public function register_new_user( $user_login, $user_email, $user_pass = NULL )
	{
		$settings = $this->getSettings();

		$errors = new WP_Error();
		$sanitized_user_login = sanitize_user( $user_login );
		$user_email = apply_filters('user_registration_email', $user_email);


		// Check the username was sanitized
		if( $sanitized_user_login == '' )
		{
			$errors->add( 'empty_username', __( 'Please enter a username.', 'easy-modal' ) );
		}
		elseif( ! validate_username( $user_login ) )
		{
			$errors->add( 'invalid_username', __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', 'easy-modal' ) );
			$sanitized_user_login = '';
		}
		elseif( username_exists( $sanitized_user_login ) )
		{
			$errors->add( 'username_exists', __( 'This username is already registered. Please choose another one.', 'easy-modal' ) );
		}



		// Check the e-mail address
		if( $user_email == '' )
		{
			$errors->add( 'empty_email', __( 'Please type your e-mail address.', 'easy-modal' ) );
		}
		elseif( ! is_email( $user_email ) )
		{
			$errors->add( 'invalid_email', __( 'The email address isn\'t correct.', 'easy-modal' ) );
			$user_email = '';
		}
		elseif( email_exists( $user_email ) )
		{
			$errors->add( 'email_exists', __( 'This email is already registered, please choose another one.', 'easy-modal' ) );
		}






		if($settings['registration_modal']['enable_password'])
		{
			if( empty($user_pass) )
			{
				$errors->add( 'empty_pass', __( 'Please enter a password.', 'easy-modal' ) );
			}
			elseif( strlen($user_pass) < 8 )
			{
				$errors->add( 'short_pass', __( 'Your password needs to be 8 characters or more.', 'easy-modal' ) );
			}
		}
		else
		{
			$user_pass = wp_generate_password( 12, false );
		}

		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
		if ( $errors->get_error_code() )
			return $errors;

		$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
		if ( ! $user_id )
		{
			$errors->add( 'registerfail', __( 'Couldn\'t register you... please contact the site administrator', 'easy-modal' ) );
			return $errors;
		}
		if(!$settings['registration_modal']['enable_password'])
		{		
			update_user_option( $user_id, 'default_password_nag', true, true ); // Set up the Password change nag.
		}
		wp_new_user_notification( $user_id, $user_pass );
		if($settings['registration_modal']['autologin'])
		{
			$creds = array(
				'user_login' => $user_login,
				'user_password' => $user_pass,
				'remember' => true
			);
			$user = wp_signon( $creds );
		}
		return $user_id;
	}
	public function retrieve_password( $user_data )
	{
		global $wpdb, $current_site;
		$errors = new WP_Error();
		if ( empty( $user_data ) ) {
			$errors->add( 'empty_username', __( 'Please enter a username or e-mail address.', 'easy-modal' ) );
		} else if ( strpos( $user_data, '@' ) ) {
			$user_data = get_user_by( 'email', trim( $user_data ) );
			if ( empty( $user_data ) )
				$errors->add( 'invalid_email', __( 'There is no user registered with that email address.', 'easy-modal'  ) );
		} else {
			$login = trim( $user_data );
			$user_data = get_user_by( 'login', $login );
		}
		do_action( 'lostpassword_post' );
		if ( $errors->get_error_code() )
			return $errors;
		if ( ! $user_data ) {
			$errors->add( 'invalidcombo', __( 'Invalid username or e-mail.', 'easy-modal' ) );
			return $errors;
		}
		// redefining user_login ensures we return the right case in the email
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		do_action( 'retreive_password', $user_login );  // Misspelled and deprecated
		do_action( 'retrieve_password', $user_login );
		$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );
		if ( ! $allow )
			return new WP_Error( 'no_password_reset', __( 'Password reset is not allowed for this user', 'easy-modal' ) );
		else if ( is_wp_error( $allow ) )
			return $allow;
		$key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );
		if ( empty( $key ) ) {
			// Generate something random for a key...
			$key = wp_generate_password( 20, false );
			do_action( 'retrieve_password_key', $user_login, $key );
			// Now insert the new md5 key into the db
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user_login ) );
		}
		$message = __( 'Someone requested that the password be reset for the following account:', 'easy-modal' ) . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
		$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'easy-modal' ) . "\r\n\r\n";
		$message .= __( 'To reset your password, visit the following address:', 'easy-modal' ) . "\r\n\r\n";
		$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";
		if ( is_multisite() ) {
			$blogname = $GLOBALS['current_site']->site_name;
		} else {
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		}
		$title   = sprintf( __( '[%s] Password Reset' ), $blogname );
		$title   = apply_filters( 'retrieve_password_title', $title );
		$message = apply_filters( 'retrieve_password_message', $message, $key );
		if ( $message && ! wp_mail( $user_email, $title, $message ) ) {
			$errors->add( 'noemail', __( 'The e-mail could not be sent. Possible reason: your host may have disabled the mail() function.', 'easy-modal' ) );
			return $errors;
			wp_die();
		}
		return true;
	}
	
	// Post / Page EM Options Pane
	public function easy_modal_post_modals( $object, $box )
	{
		$current_modals = get_post_meta( $object->ID, 'easy_modal_post_modals', true );
		$current_autoOpen_id = get_post_meta(  $object->ID, 'easy_modal_post_autoOpen_id', true );
		$current_autoOpen_delay = get_post_meta(  $object->ID, 'easy_modal_post_autoOpen_delay', true );
		$current_autoOpen_timer = get_post_meta(  $object->ID, 'easy_modal_post_autoOpen_timer', true );
		$current_autoExit_id = get_post_meta(  $object->ID, 'easy_modal_post_autoExit_id', true );
		$current_autoExit_timer = get_post_meta(  $object->ID, 'easy_modal_post_autoExit_timer', true );
		$current_force_user_login = get_post_meta(  $object->ID, 'easy_modal_post_force_user_login', true );
		$modals = $this->getModalList();
		require EASYMODAL_DIR.'/pro/views/metaboxes.php';
	}
	public function save_easy_modal_post_modals( $post_id, $post )
	{
		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST['safe_csrf_nonce_easy_modal'] ) || !wp_verify_nonce( $_POST['safe_csrf_nonce_easy_modal'],  "safe_csrf_nonce_easy_modal" ) )
			return $post_id;
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;
		$post_modals = ( !empty( $_POST['easy_modal_post_modals']) && $this->all_numeric($_POST['easy_modal_post_modals']) ) ? $_POST['easy_modal_post_modals'] : array() ;
		$current_post_modals = get_post_meta( $post_id, 'easy_modal_post_modals', true );
		if ( $post_modals && '' == $current_post_modals )
			add_post_meta( $post_id, 'easy_modal_post_modals', $post_modals, true );
		elseif ( $post_modals && $post_modals != $current_post_modals )
			update_post_meta( $post_id, 'easy_modal_post_modals', $post_modals );
		elseif ( '' == $post_modals && $current_post_modals )
			delete_post_meta( $post_id, 'easy_modal_post_modals' );
		$autoOpen_id = (!empty( $_POST['easy_modal_post_autoOpen_id']) && (is_numeric($_POST['easy_modal_post_autoOpen_id']) || in_array($_POST['easy_modal_post_autoOpen_id'],array('Login','Register','Forgot')) )) ? $_POST['easy_modal_post_autoOpen_id'] : NULL ;
		$current_autoOpen_id = get_post_meta( $post_id, 'easy_modal_post_autoOpen_id', true );
		if ( $autoOpen_id && '' == $current_autoOpen_id )
			add_post_meta( $post_id, 'easy_modal_post_autoOpen_id', $autoOpen_id, true );
		elseif ( $autoOpen_id && $autoOpen_id != $current_autoOpen_id )
			update_post_meta( $post_id, 'easy_modal_post_autoOpen_id', $autoOpen_id );
		elseif ( '' == $autoOpen_id && $current_autoOpen_id )
			delete_post_meta( $post_id, 'easy_modal_post_autoOpen_id' );
			
		$autoOpen_delay = (!empty( $_POST['easy_modal_post_autoOpen_id']) && !empty( $_POST['easy_modal_post_autoOpen_delay']) && is_numeric($_POST['easy_modal_post_autoOpen_delay'])) ? $_POST['easy_modal_post_autoOpen_delay'] : 500;
		$current_autoOpen_delay = get_post_meta( $post_id, 'easy_modal_post_autoOpen_delay', true );
		if ( $autoOpen_delay && '' == $current_autoOpen_delay )
			add_post_meta( $post_id, 'easy_modal_post_autoOpen_delay', $autoOpen_delay, true );
		elseif ( $autoOpen_delay && $autoOpen_delay != $current_autoOpen_delay )
			update_post_meta( $post_id, 'easy_modal_post_autoOpen_delay', $autoOpen_delay );
		elseif ( '' == $autoOpen_delay && $current_autoOpen_delay )
			delete_post_meta( $post_id, 'easy_modal_post_autoOpen_delay' );
		$autoOpen_timer = (!empty( $_POST['easy_modal_post_autoOpen_id']) && !empty( $_POST['easy_modal_post_autoOpen_timer']) && is_numeric($_POST['easy_modal_post_autoOpen_timer'])) ? $_POST['easy_modal_post_autoOpen_timer'] : 5;
		$current_autoOpen_timer = get_post_meta( $post_id, 'easy_modal_post_autoOpen_timer', true );
		if ( is_numeric($autoOpen_timer) && '' == $current_autoOpen_timer )
			add_post_meta( $post_id, 'easy_modal_post_autoOpen_timer', $autoOpen_timer, true );
		elseif ( is_numeric($autoOpen_timer) && $autoOpen_timer != $current_autoOpen_timer )
			update_post_meta( $post_id, 'easy_modal_post_autoOpen_timer', $autoOpen_timer );
		elseif ( '' == $autoOpen_timer && $current_autoOpen_timer )
			delete_post_meta( $post_id, 'easy_modal_post_autoOpen_timer' );
		$autoExit_id = (!empty( $_POST['easy_modal_post_autoExit_id']) && (is_numeric($_POST['easy_modal_post_autoExit_id']) || in_array($_POST['easy_modal_post_autoExit_id'],array('Login','Register','Forgot')) )) ? $_POST['easy_modal_post_autoExit_id'] : NULL ;
		$current_autoExit_id = get_post_meta( $post_id, 'easy_modal_post_autoExit_id', true );
		if ( $autoExit_id && '' == $current_autoExit_id )
			add_post_meta( $post_id, 'easy_modal_post_autoExit_id', $autoExit_id, true );
		elseif ( $autoExit_id && $autoExit_id != $current_autoExit_id )
			update_post_meta( $post_id, 'easy_modal_post_autoExit_id', $autoExit_id );
		elseif ( '' == $autoExit_id && $current_autoExit_id )
			delete_post_meta( $post_id, 'easy_modal_post_autoExit_id' );
		$autoExit_timer = (!empty( $_POST['easy_modal_post_autoExit_id']) && !empty( $_POST['easy_modal_post_autoExit_timer']) && is_numeric($_POST['easy_modal_post_autoExit_timer'])) ? $_POST['easy_modal_post_autoExit_timer'] : 5;
		$current_autoExit_timer = get_post_meta( $post_id, 'easy_modal_post_autoExit_timer', true );
		if ( is_numeric($autoExit_timer) && '' == $current_autoExit_timer )
			add_post_meta( $post_id, 'easy_modal_post_autoExit_timer', $autoExit_timer, true );
		elseif ( is_numeric($autoExit_timer) && $autoExit_timer != $current_autoExit_timer )
			update_post_meta( $post_id, 'easy_modal_post_autoExit_timer', $autoExit_timer );
		elseif ( '' == $autoExit_timer && $current_autoExit_timer )
			delete_post_meta( $post_id, 'easy_modal_post_autoExit_timer' );
		$force_user_login = !empty($_POST['easy_modal_post_force_user_login']) ? $_POST['easy_modal_post_force_user_login'] : false;
		$current_force_user_login = get_post_meta( $post_id, 'easy_modal_post_force_user_login', true );
		if ( $force_user_login && '' == $current_force_user_login )
			add_post_meta( $post_id, 'easy_modal_post_force_user_login', $force_user_login, true );
		elseif ( $force_user_login && $force_user_login != $current_force_user_login )
			update_post_meta( $post_id, 'easy_modal_post_force_user_login', $force_user_login );
		elseif ( '' == $force_user_login && $current_force_user_login )
			delete_post_meta( $post_id, 'easy_modal_post_force_user_login' );
	}
	
	protected $_accepted_modal_ids = array('new','Login','Register','Forgot');
	
	protected $views = array(
		'admin_footer'		=> '/inc/views/admin_footer.php',
		'help'				=> '/pro/views/help.php',
		'importexport'		=> '/pro/views/importexport.php',
		'metaboxes'			=> '/pro/views/metaboxes.php',
		'modal'				=> '/pro/views/modal.php',
		'modal_delete'		=> '/pro/views/modal_delete.php',
		'modal_list'		=> '/pro/views/modal_list.php',
		'modal_settings'	=> '/pro/views/modal_settings.php',
		'settings'			=> '/pro/views/settings.php',
		'sidebar'			=> '/pro/views/sidebar.php',
		'theme_delete'		=> '/pro/views/theme_delete.php',
		'theme_list'		=> '/pro/views/theme_list.php',
		'theme_settings'	=> '/pro/views/theme_settings.php',
	);
	public function theme_page()
	{
		$theme_id = isset($_GET['theme_id']) ? $_GET['theme_id'] : NULL;
		if($theme_id > 0 && isset($_GET['action']) && wp_verify_nonce($_GET['safe_csrf_nonce_easy_modal'], "safe_csrf_nonce_easy_modal"))
		{
			switch($_GET['action'])
			{
				case 'delete':
					if(empty($_GET['confirm']))
					{
						require $this->load_view('theme_delete');
					}
				break;
			}
		}
		elseif(in_array($theme_id, $this->_accepted_modal_ids) || $theme_id > 0)
		{
			$settings = $this->getThemeSettings($theme_id);
			require $this->load_view('theme_settings');
		}
		else
		{
			$themes = $this->getThemeList();
			require $this->load_view('theme_list');
		}
	}
	public function importexport_page()
	{
		$this->import();
		require $this->load_view('importexport');
	}
	public function support_page()
	{
		require $this->load_view('support');
	}
	
	// Preload Modals, Themes, JS & Output of Modals
	public function loadModals()
	{
		if(empty($this->loadedModals))
		{
			$post_id = get_the_ID();
			/* If we have a post ID, proceed. */
			$load_modals = (!empty( $post_id ) && is_array(get_post_meta( get_the_ID(), 'easy_modal_post_modals', true ))) ?  get_post_meta( $post_id, 'easy_modal_post_modals', true )  : array();
			if($autoOpen = $this->autoOpenModal())
			{
				$load_modals[] = $autoOpen['id'];
			}
			if($autoExit = $this->autoExitModal())
			{
				$load_modals[] = $autoExit['id'];
			}
			if( !is_user_logged_in() )
			{
				$settings = $this->getSettings();
				if($settings['login_modal_enabled'])
				{
					$load_modals[] = 'Login';
					$load_modals[] = 'Register';
					$load_modals[] = 'Forgot';
				}
			}
			$this->loadedModals = $load_modals;
		}
		return $this->loadedModals;
	}
	public function enqueue_themes()
	{
		$themes = $this->getThemeList();
		$settings = array();
		foreach($themes as $key => $value){
			$setting = $this->getThemeSettings($key);
			$settings[$key] = $setting;
		}
		return $settings;
	}
	public function preload_modal_filters($modal)
	{
		$settings = $this->getSettings();
		if((($modal['id'] == 'Login' && ($settings['force_user_login']) || get_post_meta( get_the_ID(), 'easy_modal_post_force_user_login', true ))) && !is_user_logged_in() && $settings['login_modal_enabled'])
		{
			$modal['closeDisabled'] = true;
		}
		return $modal;
	}
	public function print_modals()
	{
		$modals = is_array($this->preload_modals()) ? $this->preload_modals() : array();
		foreach($modals as $id => $modal)
		{
			include EASYMODAL_DIR.'/pro/views/modal.php';
		}
	}	
	public function updateSettings($post = NULL, $silent = false)
	{
		$settings = $this->getSettings();
		if($post)
		{
			$post = stripslashes_deep($post);
			unset($post['safe_csrf_nonce_easy_modal'],$post['submit']);
			$defaults = array(
				'autoOpen_id' => NULL,
				'autoOpen_delay' => 500,
				'autoOpen_timer' => 5,
				'autoExit_id' => NULL,
				'autoExit_timer' => 5
			);
			$settings['login_modal_enabled'] = false;
			$settings['force_user_login'] = false;
			$settings['registration_modal']['enable_password'] = false;
			$settings['registration_modal']['autologin'] = false;

			foreach($post as $key => $val)
			{
				switch($key)
				{
					case 'autoOpen_id':
					case 'autoOpen_delay':
					case 'autoOpen_timer':
					case 'autoExit_id':
					case 'autoExit_timer':
						$settings[$key] = is_numeric($val) ? intval($val) : $defaults[$key];
						break;
					case 'login_modal_enabled':
					case 'force_user_login':
						$settings[$key] = ($val === true || $val === 'true') ? true : false;
						break;
					case 'registration_modal' :
						foreach($val as $key => $val)
						{
							switch($key)
							{
								case 'enable_password':
								case 'autologin':
									$settings['registration_modal'][$key] = ($val === true || $val === 'true') ? true : false;
									break;
							}
						}
						break;
				}
			}
			
			if($settings['login_modal_enabled'])
			{
				$all_options = wp_load_alloptions();
				if(!array_key_exists('EasyModal_Modal-Login', $all_options))
				{
					$this->updateModalSettings('Login',$this->defaultModalSettings());
				}
				if(!array_key_exists('EasyModal_Modal-Register', $all_options))
				{
					$this->updateModalSettings('Register',$this->defaultModalSettings());
				}
				if(!array_key_exists('EasyModal_Modal-Forgot', $all_options))
				{
					$this->updateModalSettings('Forgot',$this->defaultModalSettings());
				}
			}
			update_option('EasyModal_Settings', $settings);
			if(!$silent) $this->message('Settings Updated');
			
			if(array_key_exists('license',$post))
			{
				if($this->process_license($post['license']))
				{
					wp_redirect('admin.php?page='.EASYMODAL_SLUG.'-settings',302);
					exit;
				}
			}
		}
		return $settings;
	}
	public function updateModalSettings($modal_id, $post = NULL, $redirect = false, $silent = false)
	{
		$modals = $this->getModalList();
		if(!is_numeric($modal_id))
		{
			switch($modal_id)
			{
				case 'new':
				case 'clone':
					$highest = 0;
					if($modal_id == 'clone') $clone = true;
					foreach($modals as $id => $name)
					{
						if($id > $highest) $highest = $id;
					}
					$modal_id = $highest + 1;
					break;
				case 'Login' :
					$modal_id = 'Login';
					$post['name'] = 'Login';
					$post['content'] = '[easymodal_login]';
					break;
				case 'Register' :
					$modal_id = 'Register';
					$post['name'] = 'Register';
					$post['content'] = '[easymodal_register]';
					break;
				case 'Forgot' :
					$modal_id = 'Forgot';
					$post['name'] = 'Forgot';
					$post['content'] = '[easymodal_forgot]';
					break;
			}
		}
		$settings = $this->getModalSettings($modal_id);
		if($post)
		{
			$settings['id'] = $modal_id;
			unset($post['id']);
			$settings['sitewide'] = false;
			$settings['overlayClose'] = false;
			$settings['overlayEscClose'] = false;
			$settings['closeDisabled'] = false;
			foreach($post as $key => $val)
			{
				switch($key)
				{
					case 'name':
					case 'title':
						$settings[$key] = sanitize_text_field($val);
						break;
					case 'content':
						$settings[$key] = balanceTags($val);
						break;
					case 'sitewide':
					case 'overlayClose':
					case 'overlayEscClose':
					case 'closeDisabled':
						$settings[$key] = ($val === true || $val === 'true') ? true : false;
						break;
					case 'theme':
					case 'duration':
					case 'userHeight':
					case 'userWidth':
						if(is_numeric($val))
						{
							$settings[$key] = intval($val);
						}
						break;
					case 'size':
						if(in_array($val,array('','tiny','small','medium','large','xlarge','custom')))
						{
							$settings[$key] = $val;
						}
						break;
					case 'animation':
						if(in_array($val,array('fade','fadeAndSlide','grow','growAndSlide')))
						{
							$settings[$key] = $val;
						}
						break;
					case 'direction':
						if(in_array($val,array('top','bottom','left','right','topleft','topright','bottomleft','bottomright','mouse')))
						{
							$settings[$key] = $val;
						}
						break;
					case 'userHeightUnit':
					case 'userWidthUnit':
						if(in_array($val,array('px','%','em','rem')))
						{
							$settings[$key] = $val;
						}
						break;
				}
			}
			if(!$silent) !empty($clone) ? $this->message('Modal cloned successfully') : $this->message('Modal Updated Successfully');
		}
		if(!in_array($settings['id'], array('Login','Register','Forgot')))
			$modals[$settings['id']] = $settings['name'];
		update_option('EasyModal_ModalList', $modals);
		update_option('EasyModal_Modal-'.$modal_id, $settings);
		if($redirect) wp_redirect('admin.php?page='.EASYMODAL_SLUG.'&modal_id='.$settings['id'],302);
		return $settings;
	}
	public function updateThemeSettings($theme_id = 1, $post = NULL, $redirect = false, $silent = false)
	{
		$themes = $this->getThemeList();
		if(!is_numeric($theme_id))
		{
			switch($theme_id)
			{
				case 'new':
				case 'clone':
					$highest = 0;
					if($theme_id == 'clone') $clone = true;
					foreach($themes as $id => $name)
					{
						if($id > $highest) $highest = $id;
					}
					$theme_id = $highest + 1;
					break;
			}
		}
		$settings = $this->getThemeSettings($theme_id);
		if($post)
		{
			$settings['id'] = $theme_id;
			foreach($post as $key => $val)
			{
				switch($key)
				{
					case 'name':
					case 'closeText':
						$settings[$key] = sanitize_text_field($val);
						break;
					case 'overlayOpacity':
					case 'containerPadding':
					case 'containerBorderWidth':
					case 'containerBorderRadius':
					case 'closeFontSize':
					case 'closeBorderRadius':
					case 'closeSize':
					case 'contentTitleFontSize':
						if(is_numeric($val))
						{
							$settings[$key] = intval($val);
						}
						break;
					case 'overlayColor':
					case 'containerBgColor':
					case 'containerBorderColor':
					case 'closeBgColor':
					case 'closeFontColor':
					case 'contentTitleFontColor':
					case 'contentFontColor': 
						if(preg_match('/^#[a-f0-9]{6}$/i', $val))
						{
							$settings[$key] = $val;
						}
						break;
					case 'containerBorderStyle':
						if(in_array($val,array('none','solid','dotted','dashed','double','groove','inset','outset','ridge')))
						{
							$settings[$key] = $val;
						}
						break;
					case 'closeLocation':
						if(in_array($val,array('inside','outside')))
						{
							$settings[$key] = $val;
						}
						break;
					case 'closePosition':
						if(in_array($val,array('topright','topleft','bottomright','bottomleft')))
						{
							$settings[$key] = $val;
						}
						break;
					case 'contentTitleFontFamily':
						if(in_array($val,array('Sans-Serif','Tahoma','Georgia','Comic Sans MS','Arial','Lucida Grande','Times New Roman')))
						{
							$settings[$key] = $val;

						}
						break;
				}
			}
			if(!$silent) !empty($clone) ? $this->message('Theme cloned successfully') : $this->message('Theme Updated');
		}
		$themes[$theme_id] = $settings['name'];
		update_option('EasyModal_ThemeList', $themes);
		update_option('EasyModal_Theme-'.$theme_id, $settings);
		if($redirect) wp_redirect('admin.php?page='.EASYMODAL_SLUG.'-themes&theme_id='.$theme_id,302);
		return $settings;
	}
	
	public function defaultSettings()
	{
		return array(
			'autoOpen_id' => NULL,
			'autoOpen_delay' => 500,
			'autoOpen_timer' => 5,
			'autoExit_id' => NULL,
			'autoExit_timer' => 5,
			'login_modal_enabled' => false,
			'force_user_login' => false,
			'registration_modal' => array(
				'enable_password' => false,
				'autologin' => false
			)
		);
	}
	public function defaultModalSettings()
	{
		return array(
			'id' => '',
			'name'	=> 'change_me',
			'sitewide' => false,
			'title' => '',
			'content' => '',
			
			'theme' => 1,
			
			'size' => 'normal',
			'userHeight' => 0,
			'userHeightUnit' => 0,
			'userWidth' => 0,
			'userWidthUnit' => 0,
			
			'animation' => 'fade',
			'direction' => 'bottom',
			'duration' => 350,
			'overlayClose' => false,
			'overlayEscClose' => false,
			'closeDisabled' => false
		);
	}
	public function getModalList()
	{
		$modals = get_option('EasyModal_ModalList',array());
		$settings = $this->getSettings();
		if($settings['login_modal_enabled'])
		{
			$modals['Login'] = 'Login';
			$modals['Register'] = 'Register';
			$modals['Forgot'] = 'Forgot';
		}
		return $modals;
	}
	public function getThemeSettings($theme_id = 1)
	{
		if($theme = get_option('EasyModal_Theme-'.$theme_id))
		{
			return $this->merge_existing($this->defaultThemeSettings(), $theme);
		}
		else
		{
			return $this->defaultThemeSettings();
		}
	}
	public function getThemeList()
	{
		return get_option('EasyModal_ThemeList');
	}
	public function deleteTheme($theme_id)
	{
		if($theme_id == 1) return false;
		$themes = $this->getThemeList();
		unset($themes[$theme_id]);
		update_option('EasyModal_ThemeList', $themes);
		delete_option('EasyModal_Theme-'.$theme_id);
		$this->message('Theme deleted successfully');
	}
}