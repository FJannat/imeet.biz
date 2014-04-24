<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();
?>
<div id="home">
	<div id="main">
		<div class="contents">
			<div id="homepage">
			
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
	<div>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>

			
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>

				

			
		</div>

	<?php //comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>
</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
