<?php

/**

* @package   Master

* @author    YOOtheme http://www.yootheme.com

* @copyright Copyright (C) YOOtheme GmbH

* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL

*/



// get template configuration

include($this['path']->path('layouts:template.config.php'));

	

?>

<!DOCTYPE HTML>

<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">
<head>
<?php echo $this['template']->render('head'); ?>
<?php
if(!is_front_page()):?>
<style>
.tm-sticky-navbar {
  -moz-box-sizing: border-box;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 10;
  
}
.top_margin{ float:left; width:100%; position:relative; padding-top:110px; }
</style>
<?php
endif;
?>
</head>

<body id="page" class="page <?php echo $this['config']->get('body_classes'); ?>" data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>
<?php if ($this['modules']->count('absolute')) : ?>
<div id="absolute"> <?php echo $this['modules']->render('absolute'); ?> </div>
<?php endif; ?>
<?php if ($this['modules']->count('top-a')) : ?>
<section id="top-a" class="grid-block"><?php echo $this['modules']->render('top-a', array('layout'=>$this['config']->get('top-a'))); ?></section>
<?php endif; ?>
<div class="tm-sticky-navbar">
  <header id="header">
    <?php if ($this['modules']->count('toolbar-l + toolbar-r') || $this['config']->get('date')) : ?>
    <div id="toolbar" class="clearfix">
      <?php if ($this['modules']->count('toolbar-l') || $this['config']->get('date')) : ?>
      <div class="float-left">
        <?php if ($this['config']->get('date')) : ?>
        <time datetime="<?php echo $this['config']->get('datetime'); ?>"><?php echo $this['config']->get('actual_date'); ?></time>
        <?php endif; ?>
        <?php echo $this['modules']->render('toolbar-l'); ?> </div>
      <?php endif; ?>
      <?php if ($this['modules']->count('toolbar-r')) : ?>
      <div class="float-right"><?php echo $this['modules']->render('toolbar-r'); ?></div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($this['modules']->count('logo + headerbar')) : ?>
    <div id="headerbar" class="clearfix">
    	<div class="wrapper clearfix">
      <?php if ($this['modules']->count('logo')) : ?>
      <a id="logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
      <?php endif; ?>
      <?php echo $this['modules']->render('headerbar'); ?> </div>
      </div>
    <?php endif; ?>
    <?php if ($this['modules']->count('menu + search')) : ?>
    <div id="menubar" class="clearfix">
      <?php if ($this['modules']->count('search')) : ?>
      <div id="search"><?php echo $this['modules']->render('search'); ?></div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($this['modules']->count('banner')) : ?>
    <div id="banner">
    <div class="wrapper clearfix">
	<?php echo $this['modules']->render('banner'); ?></div>
    </div>
    <?php endif; ?>
  </header>
</div>
<div class="top_margin">
<div class="wrapper  clearfix">
  <?php if ($this['modules']->count('top-b')) : ?>
  <section id="top-b" class="grid-block"><?php echo $this['modules']->render('top-b', array('layout'=>$this['config']->get('top-b'))); ?></section>
  <?php endif; ?>
  <?php if ($this['modules']->count('innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
  <div id="main" class="grid-block">
    <div id="maininner" class="grid-box">
      <?php if ($this['modules']->count('innertop')) : ?>
      <section id="innertop" class="grid-block"><?php echo $this['modules']->render('innertop', array('layout'=>$this['config']->get('innertop'))); ?></section>
      <?php endif; ?>
      <?php if ($this['modules']->count('breadcrumbs')) : ?>
      <section id="breadcrumbs"><?php echo $this['modules']->render('breadcrumbs'); ?></section>
      <?php endif; ?>
      <?php 
 				if ($this['config']->get('system_output') && !is_front_page()) : ?>
      <div class="page_layout">
        <!--<div class="slider_left">
          <h3>The World at your Fingertips</h3>
          <h4>Connect</h4>
          <span class="simple">Simply</span> </div>-->
        <section id="content" class="grid-block"><?php echo $this['template']->render('content'); ?></section>
      </div>
      <?php endif; ?>
      <?php if ($this['modules']->count('innerbottom')) : ?>
      <section id="innerbottom" class="grid-block"><?php echo $this['modules']->render('innerbottom', array('layout'=>$this['config']->get('innerbottom'))); ?></section>
      <?php endif; ?>
    </div>
    
    <!-- maininner end -->
    
    <?php if ($this['modules']->count('sidebar-a')) : ?>
    <aside id="sidebar-a" class="grid-box"><?php echo $this['modules']->render('sidebar-a', array('layout'=>'stack')); ?></aside>
    <?php endif; ?>
    <?php if ($this['modules']->count('sidebar-b')) : ?>
    <aside id="sidebar-b" class="grid-box"><?php echo $this['modules']->render('sidebar-b', array('layout'=>'stack')); ?></aside>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  
  <!-- main end -->
  
  <?php if ($this['modules']->count('bottom-a')) : ?>
  <section id="bottom-a" class="grid-block"><?php echo $this['modules']->render('bottom-a', array('layout'=>$this['config']->get('bottom-a'))); ?></section>
  <?php endif; ?>
</div>
</div>
<div id="slide_footer" class="foot_bg hoverout">
  <div class="wrapper clearfix">
    <div class="logo_clouds"><a href="<?php echo home_url();?>"><div class="site_logo"></div></a>
          <div class="clouds"></div>
    </div>  
       <?php if ($this['modules']->count('bottom-b')) : ?>
      <section id="bottom-b" class="grid-block"><?php echo $this['modules']->render('bottom-b', array('layout'=>$this['config']->get('bottom-b'))); ?></section>
      <?php endif; ?>
      <?php

				echo $this['modules']->render('footer');

				$this->output('warp_branding');

				echo $this['modules']->render('debug');

			?>
   </div>
</div>
<div class="wrapper clearfix">
  <?php if ($this['modules']->count('footer + debug') || $this['config']->get('warp_branding') || $this['config']->get('totop_scroller')) : ?>
  <footer id="footer">
    <?php if ($this['config']->get('totop_scroller')) : ?>
    <a id="totop-scroller" href="#page"></a>
    <?php endif; ?>
  </footer>
  <?php endif; ?>
</div>
<?php echo $this->render('footer'); ?>
</body>
</html>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery ('#bottom-b h3.module-title').click(function(){
		jQuery('#slide_footer').stop().animate({bottom:'0px'}, 'slow');
		jQuery('#bottom-b ul.menu').stop().show('fast');
		jQuery('#cencel').stop().show('slow');
		jQuery('.logo_clouds').stop().hide('slow');
		jQuery('#bottom-b h3.module-title').css('cursor', 'default');
 	});
	jQuery ('#cencel').click(function(){
			jQuery('#slide_footer').stop().animate({bottom:'-180px'}, 'slow');
			jQuery('#bottom-b ul.menu').stop().hide('fast');
			jQuery(this).stop().hide('slow');
			jQuery('.logo_clouds').stop().show('fast');
			jQuery('#bottom-b h3.module-title').css('cursor', 'pointer');

 	});
	
	jQuery(".hoverout").hover(function(){
		
 	  },function(){
			jQuery('#slide_footer').stop().animate({bottom:'-180px'}, 'slow');
			jQuery('#bottom-b ul.menu').stop().hide('fast');
			jQuery('#cencel').stop().hide('slow');
			jQuery('.logo_clouds').stop().show('fast');
			jQuery('#bottom-b h3.module-title').css('cursor', 'pointer');
	}); 

		
	jQuery('#absolute').hover(function(){
		jQuery('#front_login').stop().show('slow');
	},function(){
		jQuery('#front_login').stop().hide('slow');
		});
		
	jQuery ('.pupup_a').click(function(){
		jQuery('.page_popup_box', this).show('slow');
		jQuery('.remove_popup').show('slow');
 	});
	jQuery ('.remove_popup').click(function(){
		jQuery('.page_popup_box').hide('slow');
		jQuery(this).hide('slow');
 	});
		
 });

</script>