<?php
defined( '_VALID_MOS' ) or die( 'Restricted access' );
$iso = split( '=', _ISO ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php 
	if ( $my->id ) {
		initEditor();
	}
mosShowHead();
?>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate();?>/css/template_css.css" media="screen" type="text/css" />
<?php if (mosCountModules('user1') + mosCountModules('user2') + mosCountModules('user3') ==3) $columncount = "_count3"; ?>
<?php if (mosCountModules('user1') + mosCountModules('user2') + mosCountModules('user3') ==2) $columncount = "_count2"; ?>
<?php if (mosCountModules('user1') + mosCountModules('user2') + mosCountModules('user3') ==1) $columncount = "_count1"; ?>
<script language="javascript" type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate();?>/js/matching_columns.js"></script>
</head>

<body>
<div class="topbar">
<div id="navcontainer">
<?php mosLoadModules ( 'top',-1 ); ?>
<div id="header">
<h1><a href="#">HEADER</a></h1>
<h2>A Simple Template for Joomla</h2>
<h3>Add Your Slogan Content Here</h3>
</div>
</div>
</div>
<div class="wrapper">
<div id="mainbody">
<div class="inside">
<?php mosMainBody(); ?>
<?php if (mosCountModules('user1') || mosCountModules('user2') || mosCountModules('user3')) { ?>
  <?php if (mosCountModules('user1')) { ?>
    <div id="user1<?php echo $columncount; ?>" class="column">
    	<?php mosLoadModules( 'user1', -2 );?>
    </div>
	<?php } ?>
	<?php if (mosCountModules('user2')) { ?>
    <div id="user2<?php echo $columncount; ?>" class="column">
    	<?php mosLoadModules( 'user2', -2 );?>
    </div>
	<?php } ?>
	<?php if (mosCountModules('user3')) { ?>
    <div id="user3<?php echo $columncount; ?>" class="column">
    	<?php mosLoadModules( 'user3', -2 );?>
    </div>
	<?php } ?>
<?php } ?>
<div class="footer">Place Your Footer Information Here</div>
</div><!-- END MAINBODY -->
</div> <!-- END INSIDE -->
</div> <!-- END WRAPPER -->
</div>
<div class="designer"><?php include($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/js/template.css.php"); ?></div>
</body>
</html>
