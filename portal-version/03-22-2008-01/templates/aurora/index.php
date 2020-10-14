<?php defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/<?php echo $this->params->get('templateColour'); ?>.css" type="text/css" />

<!--[if IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<style type="text/css">
#banner {
background:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/<?php echo $this->params->get('templateColour'); ?>/headimg_<?php echo $this->params->get('templateColour'); ?>.jpg) no-repeat;
}
</style>

<?php
$user1 = $this->countModules('user1')?1:0;
$user2 = $this->countModules('user2')?1:0;
$topmenu = $this->countModules('user3')?1:0;
$right = $this->countModules ('right')?1:0;
$left = $this->countModules ('left')?1:0;


// USER 1 & 2 calculations
if ($user1+$user2 == 2) :
$user1_style="float:left;width:49%;";
$user2_style="float:left;width:49%;";
elseif (($user1 == 1) and ($user2 == 0)) :
$user1_style="width:99%;";
elseif (($user1 == 0) and ($user2 == 1)) :
$user2_style="width:99%";
endif;
// END
if ($left+$right == 2) :
$content = "LR";
elseif (($left == 1) and ($right == 0)) :
$content = "L";
elseif (($left == 0) and ($right == 1)) :
$content = "R";
elseif (($left == 0) and ($right == 0)) :
$content = "0";
endif;

//CHECK FOR EDIT MODE
$editmode = false;
if (JRequest::getCmd('task') == 'edit' ) :
	$editmode = true;
	$content='L';
endif;
?>


</head>

<body class="mainbody">
	<div id="wrapper">
    		<div id="mainhead<?php echo $topmenu; ?>">
           		 <div id="flash">
                    <jdoc:include type="modules" name="top" style="xhtml" />
				</div>
				<div id="logo">
                <a href="index.php"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/images/<?php echo $this->params->get('templateColour'); ?>/logo.png" style="border:0;" alt=""/></a>
                </div>
                <?php if ($topmenu) : ?>
				<div id="topmenu">
					<jdoc:include type="modules" name="user3" />
				</div>
				<?php endif; ?>
			</div>
		<div id="inner_wrapper">
				<div id="bread">
				<jdoc:include type="module" name="breadcrumbs" />
				</div>
				<?php if ($this->params->get('banner')) : ?>
				<div id="banner"></div>
				<?php endif; ?>
       	<div id="wrapper2">
                <?php if ($left) : ?>
                <div id="leftmenu"> 
					<jdoc:include type="modules" name="left" style="xhtml" />
				</div>
				<?php endif; ?>
                <?php if ($right) : ?>
                <div id="rightcol">
					<jdoc:include type="modules" name="right" style="xhtml" />
                </div>
				<?php endif; ?>
			<div id="inner_wrapper2">
           		<?php if ($user1 or $user2) : ?>
               	<div id="usermod<?php echo $content; ?>">
                <?php if ($user1) : ?>
      					<div id="user1" style="<?php echo $user1_style; ?>">
      						<jdoc:include type="modules" name="user1" style="xhtml" />
      					</div>
						<?php endif; ?>
						<?php if ($user2) : ?>
      					<div id="user2" style="<?php echo $user2_style; ?>">
      						<jdoc:include type="modules" name="user2" style="xhtml" />
      					</div>
            			<?php endif; ?>
                </div>
                <jdoc:include type="message" />
                <?php endif; ?>    
				<div id="content<?php echo $content; ?>"> 
				<jdoc:include type="component" />
				</div>
             </div>     
			 <!-- end of content aread --> 
			 </div>
                    <div id="footer">
			Powered by <a href="http://www.joomla.org">Joomla! 1.5</a> | Design by <a href="http://www.nukedesign.co.uk">NukeDesign</a> |
		<a href="http://validator.w3.org/check/referer">XHTML</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
		 | <a href="http://www.hermish.com/check_this.cfm">508</a>
	    </div>    

        </div>
	</div>		
</body>
</html>
