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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
   <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <script src='js/jquery-1.9.1.min.js'></script>
   <script src='js/jquery-ui-1.10.2.custom.min.js'></script>

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
.cal{
  color:#fff; -moz-box-sizing: border-box; 
  border-color: #fff; border-style: solid solid solid solid;  
  border-width: 2px 2px 2px 2px; width: 65%; height:40%; padding:35px 35px 35px 35px; 
  background: #48bad9;
  display: inline-block;
  padding: 5px 10px 6px;
  text-decoration: none;
  font-weight: bold;
  line-height: 5;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-box-shadow: 0 1px 3px #999;
  -webkit-box-shadow: 0 1px 3px #999;
  text-shadow: 0 -1px 1px #222;
  border: 1px #222;
  margin-left: 90px ;
  margin-right: auto ;
  margin-top: -500px;
}
#purchase{ 
  background-image: url("http://www.imeet.biz/wp-content/uploads/2013/10/purchase.png"); 
  width: 159px; height: 45px; background-repeat: no-repeat;
 display: inline-block;
  /*padding: 5px 10px 6px;*/
  text-decoration: none;
  font-weight: bold;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-box-shadow: 0 1px 3px #999;
  -webkit-box-shadow: 0 1px 3px #999;
  text-shadow: 0 -1px 1px #222;
  border-bottom: -1px #48bad9; 
  border-left: 0px;
  border-top: 0px;
  border-right: 0px;
  border-color: #48bad9; 
  margin-left: 20px; 
  cursor: pointer;
}
#input1{
  height: 25px;
  margin-top: -1px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-box-shadow: inset 0 1px 3px #999;
  -webkit-box-shadow: inset 0 1px 3px #999;
  text-shadow: 0 -1px 1px #222;
  text-align: center;
}

#input2{
  height: 25px;
  margin-top: -1px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-box-shadow: inset 0 1px 3px #999;
  -webkit-box-shadow: inset 0 1px 3px #999;
  text-shadow: 0 -1px 1px #222;
  text-align: center;
}
#output{
  height: 25px;
  margin-top: -1px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-box-shadow: inset 0 1px 3px #999;
  -webkit-box-shadow: inset 0 1px 3px #999;
  text-shadow: 0 -1px 1px #222;
  text-align: center;
}

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
<div class="wrapper  clearfix" style="margin-top: 28px;">
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
	jQuery ('#bottom-b h3.module-title').hover(function(){
		jQuery('#slide_footer').stop().animate({bottom:'0px'}, 'slow');
		jQuery('#bottom-b ul.menu').show('fast');
		jQuery('#cencel').stop().show('slow');
		jQuery('.logo_clouds').stop().hide('slow');
		jQuery('#bottom-b h3.module-title').css('cursor', 'default');
 	});


	jQuery ('#cencel').hover(function(){
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

  jQuery('#module mod-box widget_text deepest').hover(function(){
    jQuery('.footer_left').show('slow');
  });

//    $(document).ready(function(){
//     $( '.pupup_a' ).click(function() {
//         $( ".page_popup_box" ).dialog( "open" );
//         $('.remove_popup').show('slow');
//       });      
   
//    $( "#login_form" ).dialog({
//       autoOpen: false,
//    height: $(window).height() - 350,
//       width: $(window).width() - 800,
//       modal: true,
//    open: function (event, ui) {
//     $('#dialog-form').css('scroll', 'none'); 
//   }
   
//    });
// });

		
/*	jQuery ('.pupup_a').click(function(){
		jQuery('.page_popup_box', this).show('slow');
    jQuery('.page_popup_box', this).height('fixed'),
    jQuery('.page_popup_box', this).width('fixed'),
		jQuery('.remove_popup').show('slow');
 	});
 
	jQuery ('.remove_popup').click(function(){
		jQuery('.page_popup_box').stop().hide('slow');
     jQuery('.page_popup_box', this).height('fixed'),
    jQuery('.page_popup_box', this).width('fixed'),
     jQuery('.page_popup_box', this).position('auto'),
  	 jQuery(this).hide('slow');
 	});
*/
// jQuery("#input2,#input1").keyup(function () {

//     jQuery('#output').val(jQuery('#input1').val() * jQuery('#input2').val());

// });

 $("#input1").keyup(function () {
   if ($('#input1').val() <= 5)
    {
        $('#output').val($('#input1').val() * 40);
    }
   else if ($('#input1').val() >= 6 && $('#input1').val() <= 20 )
    {
        $('#output').val($('#input1').val() * 30);
    }
   else if ($('#input1').val() >= 21 && $('#input1').val() <= 35 )
    {
        $('#output').val($('#input1').val() * 20);
    }
   else if ($('#input1').val() >= 36)
    {
        $('#output').val($('#input1').val() * 10);
    }

  });		
});

</script>
