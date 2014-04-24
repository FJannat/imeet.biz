<?php

/**
 * Create Template Structure for the Display of Social Links
 *
 * @package     Captain Social
 * @subpackage  Template
 * @copyright   Copyright (c) 2012-2013, Bryce Adams
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.0
 * @uses        ob_start
 * @uses        ob_get_clean
*/

function ctsocial_icons_template() {
	
	ob_start(); ?>

	<div class="ctsocial">

		<?php

		// Let's define each social network option so we can easily store each network's
		// URL in a variable.
	     $facebook = ctsocial_options_each( 'facebook' );
	     $twitter = ctsocial_options_each( 'twitter' );
	    // $tumblr = ctsocial_options_each( 'tumblr' );
	     $linkedin = ctsocial_options_each( 'linkedin' );
	    // $pinterest = ctsocial_options_each( 'pinterest' );
	    // $youtube = ctsocial_options_each( 'youtube' );
	    // $vimeo = ctsocial_options_each( 'vimeo' );
	    // $instagram = ctsocial_options_each( 'instagram' );
	    // $flickr = ctsocial_options_each( 'flickr' );
	    // $github = ctsocial_options_each( 'github' );
	     $gplus = ctsocial_options_each( 'gplus' );
	    // $dribbble = ctsocial_options_each( 'dribbble' );
	    // $behance = ctsocial_options_each( 'behance' );
	    // $soundcloud = ctsocial_options_each( 'soundcloud' );
	    // $spotify = ctsocial_options_each( 'spotify' );
	    // $rdio = ctsocial_options_each( 'rdio' );

	    // In the next release, we have multiple social media icon styles/icons to choose
	    // from in the settings. We'll need the following:
	    // $type = ctsocial_options_each( 'type' );

		?>

		<?php
		// Now we only want to show ul.social if at least one social network option has been filled, so let's check for that.
		if ( ( $facebook or $twitter or $tumblr or $linkedin or $pinterest or $youtube or $vimeo or $instagram or $flickr or $github or $gplus or $dribbble or $behance or $soundcloud or $spotify or $rdio ) != '' ) { ?>

		<?php // Assuming there is, let's go ahead and display the ones that have been filled ?>
			<?php // _TODO_ Make this into a switch/case structure or a foreach statement if possible ?>
		    <ul class="social <?php /* Again, this is for the new Type option in an upcoming version.
		    					// If a user has chosen one of the other social media icon
		    					// designs, let's add a class that will change the icons
		    					// accordingly. 2 = Circle Black/White. 3 = Square Color. 4 = Square Black/White.
		    					if ( $type == 2 ) {
		    						echo 'circle bw';
		    					} elseif ( $type == 3 ) {
		    						echo 'square color';
		    					} elseif ( $type == 4 ) {
		    						echo 'square bw'; } */ ?>">
		    	<?php if ( $facebook !='' ) { ?>
		    	<li class="facebook">
		    	    <a href="<?php echo $facebook; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $twitter !='' ) { ?>
		    	<li class="twitter">
		    	    <a href="<?php echo $twitter; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<!--<?php if ( $tumblr !='' ) { ?>
		    	<li class="tumblr">
		    	    <a href="<?php echo $tumblr; ?>"></a>
		    	</li>
		    	<?php } ?> -->
		    	<?php if ( $linkedin !='' ) { ?>
		    	<li class="linkedin">
		    	    <a href="<?php echo $linkedin; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<!--<?php if ( $pinterest !='' ) { ?>
		    	<li class="pinterest">
		    	    <a href="<?php echo $pinterest; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $youtube !='' ) { ?>
		    	<li class="youtube">
		    	    <a href="<?php echo $youtube; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $vimeo !='' ) { ?>
		    	 <li class="vimeo">
		    	    <a href="<?php echo $vimeo; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $instagram !='' ) { ?>
		    	<li class="instagram">
		    	    <a href="<?php echo $instagram; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $flickr !='' ) { ?>
		    	 <li class="flickr">
		    	    <a href="<?php echo $flickr; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $github !='' ) { ?>
		    	 <li class="github">
		    	    <a href="<?php echo $github; ?>"></a>
		    	</li>
		    	<?php } ?>-->
		    	<?php if ( $gplus !='' ) { ?>
		    	 <li class="gplus">
		    	    <a href="<?php echo $gplus; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<!--<?php if ( $dribbble !='' ) { ?>
		    	 <li class="dribbble">
		    	    <a href="<?php echo $dribbble; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $behance !='' ) { ?>
		    	<li class="behance">
		    	    <a href="<?php echo $behance; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $soundcloud !='' ) { ?>
		    	<li class="soundcloud">
		    	    <a href="<?php echo $soundcloud; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $spotify !='' ) { ?>
		    	<li class="spotify">
		    	    <a href="<?php echo $spotify; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $rdio !='' ) { ?>
		    	<li class="rdio">
		    	    <a href="<?php echo $rdio; ?>"></a>
		    	</li>
		    	<?php } ?>-->
	    </ul><!-- .social.*design choice for icons* -->

		<?php } ?>	
    
	</div><!-- .ctsocial -->

	<?php
		echo ob_get_clean();

}