<?php

// Kwick Sliding Menu  
// By Andy Sikumbang 
// http://www.templateplazza.com
// Based on mootols (http://www.mootols.net) and Sam Birch at http://www.phatfusion.net/
// Copyright (C) 2007 TemplatePlazza.com
// License http://www.gnu.org/copyleft/gpl.html GNU/GPL


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$widthmenu  = $params->get( 'widthmenu','120' );
$widthmenuall = $widthmenu * 6 + 25;
$widthmenuhover = $params->get( 'widthmenuhover' );
$menuheight =$params->get( 'menuheight','100' );
$menucontainerheight = $menuheight;
$separator_width=$params->get( 'separator_width','2' ); 
$separator_color=$params->get( 'separator_color','#FFFFFF' ); 
$menutitle1 =$params->get( 'menutitle1','Menu 1' );
$menutitle2 =$params->get( 'menutitle1','Menu 2' );
$menutitle3 =$params->get( 'menutitle3','Menu 3' );
$menutitle4 =$params->get( 'menutitle4','Menu 4' );
$menutitle5 =$params->get( 'menutitle5','Menu 5' );
$menutitle6 =$params->get( 'menutitle6','Menu 6' );
$menuurl1 =$params->get( 'menuurl1','http://www.templateplazza.com' );
$menuurl2 =$params->get( 'menuurl2','http://www.templateplazza.com' );
$menuurl3 =$params->get( 'menuurl3','http://www.templateplazza.com' );
$menuurl4 =$params->get( 'menuurl4','http://www.templateplazza.com' );
$menuurl5 =$params->get( 'menuurl5','http://www.templateplazza.com' );
$menuurl6 =$params->get( 'menuurl6','http://www.templateplazza.com' );
$menuimg1 =$params->get( 'menuimg1','1.png' );
$menuimg2 =$params->get( 'menuimg2','2.png' );
$menuimg3 =$params->get( 'menuimg3','3.png' );
$menuimg4 =$params->get( 'menuimg4','4.png' );
$menuimg5 =$params->get( 'menuimg5','5.png' );
$menuimg6 =$params->get( 'menuimg6','6.png' );
?>
<script type="text/javascript">
	window.addEvent('domready', function(){
		var myMenu = new ImageMenu($$('#kwick .kwick'),{openWidth:<?php echo $widthmenuhover; ?>});
	});
</script>
<!-- Kwick Sliding Menu for Joomla by http://www.templateplazza.com - If you want to make this module xhtml compliant, you need to move the style below into <head> section of your template -->  
<style>
#kwickcontainer {
	margin:auto 0;
}
#kwick {
	/*border-bottom: 3px double #333;*/
	margin-top: 10px;
	width:<?php echo $widthmenuall; ?>px;
}
#kwick .kwicks {
	display: block;
	height: <?php echo $menucontainerheight; ?>px;
	margin: 0px;
}
#kwick li {
	float: left;
	margin:0;
	padding:0;
	list-style: none;
}
#kwick .kwick {
	display: block;
	cursor: pointer;
	overflow: hidden;
	height:<?php echo $menuheight; ?>px;
	width:<?php echo $widthmenu; ?>px;
	/*padding: 10px;*/
	background: #fff;
	/*border-right: 5px solid #202020;*/
	border-right: <?php echo $separator_width; ?>px solid <?php echo $separator_color; ?>;
}
#kwick .kwick span {
	display:none;
}
#kwick .opt1 {
	background: url(modules/kwick_menu/images/<?php echo $menuimg1?>) ;
}
#kwick .opt2 {
	background:  url(modules/kwick_menu/images/<?php echo $menuimg2 ?>);
}
#kwick .opt3 {
	background:  url(modules/kwick_menu/images/<?php echo $menuimg3 ?>);
}
#kwick .opt4 {
	background:  url(modules/kwick_menu/images/<?php echo $menuimg4 ?>);
}
#kwick .opt5 {
	background:  url(modules/kwick_menu/images/<?php echo $menuimg5 ?>);
}
#kwick .opt6 {
	background:  url(modules/kwick_menu/images/<?php echo $menuimg6 ?>);
	border-right: 0;
}
</style>
<div id="kwickcontainer" align="center">
<div id="kwick" align="center" >
	<ul class="kwicks">
		<li ><a href="<?php echo $menuurl1; ?>" class="kwick opt1"><span><?php echo $menutitle1; ?></span></a></li>
		<li ><a href="<?php echo $menuurl2; ?>" class="kwick opt2"><span><?php echo $menutitle2; ?></span></a></li>
		<li ><a href="<?php echo $menuurl3; ?>" class="kwick opt3"><span><?php echo $menutitle3; ?></span></a></li>
		<li ><a href="<?php echo $menuurl4; ?>" class="kwick opt4"><span><?php echo $menutitle4; ?></span></a></li>
		<li ><a href="<?php echo $menuurl5; ?>" class="kwick opt5"><span><?php echo $menutitle5; ?></span></a></li>
		<li ><a href="<?php echo $menuurl6; ?>" class="kwick opt6"><span><?php echo $menutitle6; ?></span></a></li>
	</ul>
</div>
</div>
