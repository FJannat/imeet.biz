<?php
/**
 * Create Shortcode to Display Social Links
 * Shortcode  = ctsocial
 *
 * @package     Captain Social
 * @subpackage  Shortcode
 * @copyright   Copyright (c) 2012, Bryce Adams
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @uses        ob_start
 * @uses        ob_get_clean
*/


// Slider Shortcode
function ctsocial_icons_shortcode( $atts, $content = null ) {
	
	ob_start();
	ctsocial_icons_template();
	$output = ob_get_clean();

	return $output;

}
add_shortcode( 'ctsocial', 'ctsocial_icons_shortcode' );