<?php $page_id=get_the_ID(); if($page_id==2520 or $page_id==2524 or $page_id==2522  or $page_id==2526){?>
<div class="page_navigation">
    <div class="page_next"><?php next_post_link(); ?></div>
    <div class="page_pre"><?php previous_post_link(); ?></div>
</div>
<?php }?>
<?php 
if($page_id==2352){ ?>

<div class="page_navigation">
    <div class="page_next"><?php next_post_link(); ?></div>
  <div class="page_pre">« <a rel="prev" href="http://www.imeet.biz/marketing-message-sent">Marketing Message Sent</a></div>
</div>
<?php }?>
<?php 
if($page_id==2528){ ?>

<div class="page_navigation">
  <div class="page_next"><a rel="next" href="http://www.imeet.biz/global-fashion-design">Global Fashion Design</a>»</div>
    <div class="page_pre"><?php previous_post_link(); ?></div>
</div>
<?php }?>

<div id="system">


	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
		<article class="item">
		
			<?php if (has_post_thumbnail()) : ?>
				<?php
				$width = get_option('thumbnail_size_w'); //get the width of the thumbnail setting
				$height = get_option('thumbnail_size_h'); //get the height of the thumbnail setting
				?>
				<?php the_post_thumbnail(array($width, $height), array('class' => 'size-auto')); ?>
			<?php endif; ?>
		
			<header>
		
				<h1 class="title"><?php the_title(); ?></h1>
				
			</header>
 			<div class="content clearfix"><?php the_content(''); ?></div>

			<?php edit_post_link(__('Edit this post.', 'warp'), '<p class="edit">','</p>'); ?>
	
		</article>
		
		<?php endwhile; ?>
	<?php endif; ?>
	
	<?php //comments_template(); ?>

</div>