<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();


?>

<div id="main">
	<div class="contents">



		<div id="homepage">
	
			<div id="pgi_sidebar_nav" uri="60288c1d88984ab456d27a5f88e728e3" class="pgi_ajax_vert">
				<ul class="pgi_ajax_vert homepage-buttons red">
					<li class="0 first active"><a href="<?php echo esc_url( home_url( '/innovative' ) ); ?>" id="innovative1" class="pgi-subnav noajaxload isfront active"><span><img src="<?php bloginfo('stylesheet_directory'); ?>/images/sidenav_innovative.png"></span></a></li>
					<li class="1"><a href="<?php echo esc_url( home_url( '/reliable' ) ); ?>" id="reliable1" uri="node/593" class="pgi-subnav noajaxload isfront"><span><img src="<?php bloginfo('stylesheet_directory'); ?>/images/sidenav_reliable.png"></span></a></li>
					<li class="2"><a href="<?php echo esc_url( home_url( '/mobile' ) ); ?>" id="secure1" uri="node/594" class="pgi-subnav noajaxload isfront"><span><img src="<?php bloginfo('stylesheet_directory'); ?>/images/sidenav_mobile.png"></span></a></li>
					<li class="3"><a href="<?php echo esc_url( home_url( '/global' ) ); ?>" id="flexible1" uri="node/592" class="pgi-subnav noajaxload isfront"><span><img src="<?php bloginfo('stylesheet_directory'); ?>/images/sidenav_global.png"></span></a></li>
				</ul>
			</div>
			<br />
			<div id="home">
				<div class="fpprocontainer">
					<div class="fparrows nextprev">
						<a id="prev" href="/" class="prev imgrep">Prev</a> 
						<a id="next" href="/" class="next imgrep">Next</a>
					</div>
					<div class="fparrows pagenumbers">
						<ul id="nav"></ul>
					</div>
					<div class="fppromo">
						<a href="services/web-development/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/i.jpg" width="898px" height="369px" alt="Work in Fashion" /></a>
						<a href="services/web-2-0-social-web/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/social.jpg" width="898px" height="369px" alt="U-Live - The new active social network" /></a>
						<a href="services/mobile-solutions/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/mobile.jpg" width="898px" height="369px" alt="Amanda Wakeley" /></a> 
						
						
					</div>
					<div class="fptitle"></div>
				</div><!--fpprocontainer-->
				<br />
				<div class="row" style="margin-top:400px;">
					<div class="colsingle web">
						<h2><a href="<?php echo esc_url( home_url( '/audiovideo-conferencing' ) ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/av.jpg" /></a></h2>
						<p>From content management systems to ecommerce sites, our web design and development team create visually appealing websites that are easy to use and deliver across all market sectors.</p>
						<a class="imgrep viewweb" href="<?php echo esc_url( home_url( '/audiovideo-conferencing' ) ); ?>">View Web Services</a>
					</div>
					<div class="colsingle mrgnlft social">
						<h2><a  href="<?php echo esc_url( home_url( '/team-work-communications' ) ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/1social.jpg" /></a></h2>
						<p>Social media is all about communities and conversations. At EdgeComDigital we help brands to utilise this to connect with their audience through applications and integration into social networks.</p>
						<a class="imgrep viewsocial" href="<?php echo esc_url( home_url( '/team-work-communications' ) ); ?>">View Social Media Services</a>
					</div>
					<div class="colsingle mrgnlft mobile">
						<h2><a  href="<?php echo esc_url( home_url( '/mobile-conferencing' ) ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/mc.jpg" /></a></h2>
						<p>Mobile is predicted to overtake desktop usage by 2015. In preparation of this we help to plan, design and develop mobile applications, websites and platforms to take advantage of this audience shift.</p>
						<a class="imgrep viewmobile" href="<?php echo esc_url( home_url( '/mobile-conferencing' ) ); ?>">View Social Media Services</a>
					</div>
				</div><!--row--><br />
		
			</div>
			
			
			
			
		
			
		
			
					
		
			
			
			
		
        
		</div><!--homepage-->
    <br class="clr" />
	</div><!--content-->
</div><!-- #main -->

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
