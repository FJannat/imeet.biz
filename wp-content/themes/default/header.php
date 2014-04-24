<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.hoverIntent.minified.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/pdcustom.js" type="text/javascript"></script>
<script src="js/pdcustom.js" type="text/javascript"></script>
<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.2.74.js"></script>
<style type="text/css" media="screen">

<?php 

// Checks to see whether it needs a sidebar or not
if ( empty($withcomments) && !is_single() ) {
?>
	#page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbg-<?php bloginfo('text_direction'); ?>.jpg") repeat-y top; border: none; }
<?php } else { // No sidebar ?>
	#page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgwide.jpg") repeat-y top; border: none; }
<?php } ?>

</style>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php //wp_head(); ?>
</head>
<script type="text/javascript">
    $('.fppromo').cycle({
        fx: 'custom',
        cssBefore: {
            left: -2000,
            top: 0,
            display: 'block',
            opacity: 0
        },
        animIn: {
            left: 0,
            top: 0,
            opacity: 1
        },
        animOut: {
            left: 2000,
            top: 0,
            opacity: 0
        },
        timeout: 5000,
        sync: 0,
        speed: 250,
        pause: 0,
        prev: '#prev',
        next: '#next',
        pager: '#nav',
        pagerAnchorBuilder: pagerFactory,
        after: onAfter,
        before: onBefore
    });
    function onBefore() {
        $('.fptitle').html('');
    }
    function onAfter() {
        $('.fptitle').html('<h3>' + this.alt + '</h3>');
    }

    function pagerFactory(idx, slide) {
        var s = idx > 2 ? ' style="display:none"' : '';
        return '<li' + s + '><a href="#">' + (idx + 1) + '</a></li>';
    };

</script>

<body <?php body_class(); ?>  class="home page page-id-54 page-template page-template-pdhome-php">
<div>


<div id="header">
	<div class="contents">
		<img alt="Nksoft logo" height="70" class="logo" src="<?php bloginfo('stylesheet_directory'); ?>/i/NKSoft%20logo.jpg" width="159"/>
			<ul id="mainmenu">
				
                <li class="homeselected"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="home1">home</a></li>               	
				
                <li class="services">
                    <a href="#">services</a>
                    <div class="servicesmenu">

                    <div class="servicescontent">
                    <ul class="web" id="web">
                        <li><a href="<?php echo esc_url( home_url( '/audiovideo-conferencing' ) ); ?>">Audio/Video Conferencing </a></li>
						<li><a href="<?php echo esc_url( home_url( '/team-work-communications' ) ); ?>">Team Work Communications</a></li>
						 <li><a href="<?php echo esc_url( home_url( '/mobile-conferencing' ) ); ?>">Mobile Conferencing</a></li>
						  <li><a href="<?php echo esc_url( home_url( '/enterprise' ) ); ?>">Enterprise</a></li>
                    </ul>                    
                    </div>
                    <div class="servicesfooter"></div>
                    </div>  
                </li>
				<li class="about"><a href="<?php echo esc_url( home_url( '/about' ) ); ?>" id="about1">about</a></li>         
				 <li class="blog"><a href="<?php echo esc_url( home_url( '/category/blog' ) ); ?>" id="blog1">blog</a></li>	
                
                <li class="contact"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" id="contact1">contact</a></li>
               
			</ul>
			<span>Contact: 972-910-0069 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">Login</a></span>
            <div class="sociallink">
			

            <ul>
               	<li class="flickr"><a href="http://www.flickr.com/photos/edgecomdigital/">flickr</a></li>
                <li class="twitter"><a href="http://twitter.com/edgecomdigital">twitter</a></li>
                <li class="facebook"><a href="http://www.facebook.com/edgecomdigital">facebook</a></li>
            </ul>
            </div>
 
        <div class="clr"></div>
	</div>
    <div class="contents"><div class="hr"></div></div>
</div>

