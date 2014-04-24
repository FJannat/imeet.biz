<?php
/**
 * Register Settings
 *
 * @package     Captain Social
 * @subpackage  Register Settings
 * @copyright   Copyright (c) 2012-2013, Bryce Adams
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.0
*/


function ctsocial_options_each( $key ) {

	$social_options = get_option( 'ctsocial_all_options' );

	 /* Define the array of defaults */ 
	$defaults = array(
		'facebook'     	=> 0,
		'twitter'     	=> 0,
		'tumblr'		=> 0,
		'linkedin'		=> 0,
		'pinterest'    	=> 0,
		'youtube'		=> 0,
		'vimeo'			=> 0,
		'instagram'		=> 0,
		'flickr'		=> 0,
		'github'		=> 0,
		'gplus'			=> 0,
		'dribbble'		=> 0,
		'behance'		=> 0,
		'soundcloud'	=> 0,
		'spotify'		=> 0,
		'rdio'			=> 0
		//'other'			=> 0
	);

	$social_options = wp_parse_args( $social_options, $defaults );

	if( isset( $social_options[$key] ) )
		 return $social_options[$key];

	return false;
}


function ctsocial_admin_menu() {
	add_submenu_page(
		'options-general.php',
		__( 'Captain Social Settings', 'ctsocial' ),
		__( 'Captain Social', 'ctsocial' ),
		'manage_options',
		'ctsocial_all_options',
		'ctsocial_render_settings_page'
	);
}
add_action( 'admin_menu', 'ctsocial_admin_menu' );


/**
 * Render Settings Page
 *
 * @access      private
 * @since       1.1.0
 * @return      void
 * @todo        Make shortlink for Captain Social docs (http://cpthe.me/socialdocs/)
 */

function ctsocial_render_settings_page( $active_tab = '' ) {
	ob_start(); ?>

	<div class="wrap">
	
		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'Captain Social Settings', 'ctsocial' ); ?></h2>
		<?php settings_errors(); ?>
		
		<?php if ( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = 'display_options';
		}

		?>
		
		<h3><?php _e( 'Documentation', 'ctsocial' ); ?></h3>
		<p><?php printf( __( 'I love writing documentation, so I wrote some just for you: %sVisit Captain Social Documentation%s.', 'ctsocial' ), '<strong><a href="http://cpthe.me/socialdocs/">', '</a></strong>' ); ?></p>
		
		<form method="post" action="options.php">
			<?php
			if ( $active_tab == 'display_options' ) {
				settings_fields( 'ctsocial_all_options' );
				do_settings_sections( 'ctsocial_all_options' );
			}

			submit_button();
	
	echo ob_get_clean();	
}


function ctsocial_initialize_theme_options() {

	// If the theme options don't exist, create them.
	if ( false == get_option( 'ctsocial_all_options' ) )
		add_option( 'ctsocial_all_options' );

	// First, we register a section.
	add_settings_section(
		'general_settings_section',
		__( 'Settings', 'ctsocial' ),
		'ctsocial_general_options_callback',
		'ctsocial_all_options'
	);

	add_settings_field(	
		'facebook',						
		__( 'Facebook',	'ctsocial' ),						
		'ctsocial_facebook_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'twitter',						
		__( 'Twitter', 'ctsocial' ),
		'ctsocial_twitter_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'tumblr',						
		__( 'Tumblr', 'ctsocial' ),
		'ctsocial_tumblr_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'linkedin',						
		__( 'LinkedIn', 'ctsocial' ),
		'ctsocial_linkedin_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);
	
	add_settings_field(	
		'pinterest',						
		__( 'Pinterest', 'ctsocial' ),					
		'ctsocial_pinterest_callback',
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'youtube',						
		__( 'Youtube', 'ctsocial' ),
		'ctsocial_youtube_callback',
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'vimeo',						
		__( 'Vimeo', 'ctsocial' ),
		'ctsocial_vimeo_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'instagram',						
		__( 'Instagram', 'ctsocial' ),
		'ctsocial_instagram_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'flickr',						
		__( 'Flickr', 'ctsocial' ),
		'ctsocial_flickr_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'github',						
		__( 'Github','ctsocial' ),
		'ctsocial_github_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'gplus',						
		__( 'Google+', 'ctsocial' ),
		'ctsocial_gplus_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'dribbble',						
		__( 'Dribbble',	'ctsocial' ),
		'ctsocial_dribbble_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'behance',						
		__( 'Behance', 'ctsocial' ),
		'ctsocial_behance_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'soundcloud',						
		__( 'SoundCloud', 'ctsocial' ),
		'ctsocial_soundcloud_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'spotify',						
		__( 'Spotify', 'ctsocial' ),
		'ctsocial_spotify_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'rdio',						
		__( 'Rdio', 'ctsocial' ),
		'ctsocial_rdio_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);

	/*
	add_settings_field(	
		'other',						
		__( 'Other Social Network (add later)',	'ctsocial' ),
		'ctsocial_other_callback',	
		'ctsocial_all_options',	
		'general_settings_section'			
	);
	*/

	// Finally, we register the fields with WordPress
	register_setting(
		'ctsocial_all_options',
		'ctsocial_all_options',
		'ctsocial_sanitize_social_options'
	);


} // end ctsocial_initialize_theme_options
add_action( 'admin_init', 'ctsocial_initialize_theme_options' );



/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 


/**
 * This function provides a simple description for the General Options page. 
 *
 * It's called from the 'ctsocial_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */

function ctsocial_general_options_callback() {
	echo '<p>';
	_e( 'Add the links to your social network profiles below. Only those that have been filled in will displayed when the social icons are inserted.', 'ctsocial' );
	echo '</p>';
} // end ctsocial_general_options_callback


/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 


/**
 * This function renders the interface elements for toggling the visibility of the header element.
 * 
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */

// Facebook Callback
function ctsocial_facebook_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['facebook'] ) ) {
		$url = esc_url( $options['facebook'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="facebook" name="ctsocial_all_options[facebook]" value="' . $url . '" />';
	
} // end ctsocial_facebook_callback


// Twitter Callback
function ctsocial_twitter_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['twitter'] ) ) {
		$url = esc_url( $options['twitter'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="twitter" name="ctsocial_all_options[twitter]" value="' . $url . '" />';
	
} // end ctsocial_twitter_callback


// Tumblr Callback
function ctsocial_tumblr_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['tumblr'] ) ) {
		$url = esc_url( $options['tumblr'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="tumblr" name="ctsocial_all_options[tumblr]" value="' . $url . '" />';
	
} // end ctsocial_tumblr_callback


// LinkedIn Callback
function ctsocial_linkedin_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['linkedin'] ) ) {
		$url = esc_url( $options['linkedin'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="linkedin" name="ctsocial_all_options[linkedin]" value="' . $url . '" />';
	
} // end ctsocial_linkedin_callback


// Pinterest Callback
function ctsocial_pinterest_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['pinterest'] ) ) {
		$url = esc_url( $options['pinterest'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="pinterest" name="ctsocial_all_options[pinterest]" value="' . $url . '" />';
	
} // end ctsocial_pinterest_callback


// Youtube Callback
function ctsocial_youtube_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['youtube'] ) ) {
		$url = esc_url( $options['youtube'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="youtube" name="ctsocial_all_options[youtube]" value="' . $url . '" />';
	
} // end ctsocial_youtube_callback


// Vimeo Callback
function ctsocial_vimeo_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['vimeo'] ) ) {
		$url = esc_url( $options['vimeo'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="vimeo" name="ctsocial_all_options[vimeo]" value="' . $url . '" />';
	
} // end ctsocial_vimeo_callback


// Instagram Callback
function ctsocial_instagram_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['instagram'] ) ) {
		$url = esc_url( $options['instagram'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="instagram" name="ctsocial_all_options[instagram]" value="' . $url . '" />';
	
} // end ctsocial_instagram_callback


// Flickr Callback
function ctsocial_flickr_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['flickr'] ) ) {
		$url = esc_url( $options['flickr'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="flickr" name="ctsocial_all_options[flickr]" value="' . $url . '" />';
	
} // end ctsocial_flickr_callback


// Github Callback
function ctsocial_github_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['github'] ) ) {
		$url = esc_url( $options['github'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="github" name="ctsocial_all_options[github]" value="' . $url . '" />';
	
} // end ctsocial_github_callback


// Google+ Callback
function ctsocial_gplus_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['gplus'] ) ) {
		$url = esc_url( $options['gplus'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="gplus" name="ctsocial_all_options[gplus]" value="' . $url . '" />';
	
} // end ctsocial_gplus_callback


// Dribbble Callback
function ctsocial_dribbble_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['dribbble'] ) ) {
		$url = esc_url( $options['dribbble'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="dribbble" name="ctsocial_all_options[dribbble]" value="' . $url . '" />';
	
} // end ctsocial_dribbble_callback


// Behance Callback
function ctsocial_behance_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['behance'] ) ) {
		$url = esc_url( $options['behance'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="behance" name="ctsocial_all_options[behance]" value="' . $url . '" />';
	
} // end ctsocial_behance_callback


// SoundCloud Callback
function ctsocial_soundcloud_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['soundcloud'] ) ) {
		$url = esc_url( $options['soundcloud'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="soundcloud" name="ctsocial_all_options[soundcloud]" value="' . $url . '" />';
	
} // end ctsocial_soundcloud_callback


// Spotify Callback
function ctsocial_spotify_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['spotify'] ) ) {
		$url = esc_url( $options['spotify'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="spotify" name="ctsocial_all_options[spotify]" value="' . $url . '" />';
	
} // end ctsocial_spotify_callback


// Rdio Callback
function ctsocial_rdio_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['rdio'] ) ) {
		$url = esc_url( $options['rdio'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="rdio" name="ctsocial_all_options[rdio]" value="' . $url . '" />';
	
} // end ctsocial_rdio_callback

/*
// Other Callback
function ctsocial_other_callback() {
	
	$options = get_option( 'ctsocial_all_options' );
	$url = '';

	if( isset( $options['other'] ) ) {
		$url = esc_url( $options['other'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="other" name="ctsocial_all_options[other]" value="' . $url . '" />';
	
} // end ctsocial_other_callback
*/


/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 
 /**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *	
 * @since 		1.0.0
 * @param		$input (The unsanitized collection of options)
 * @return		The collection of sanitized values.
 */

function ctsocial_sanitize_social_options( $input ) {
	
	// Define the array for the updated options
	$output = array();

	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {
	
		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if	
	
	} // end foreach
	
	// Return the new collection
	return apply_filters( 'ctsocial_sanitize_social_options', $output, $input );

} // end sandbox_theme_sanitize_social_options