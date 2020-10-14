<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require($mosConfig_absolute_path."/templates/mambospan_glass/mycssmenu.php");
// needed to seperate the ISO number from the language file constant _ISO
$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_css.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico" />
</head>
<body id="page_bg">
<a name="up" id="up"></a>
<table cellpadding="0" cellspacing="0" width="772" id="main" align="center">
    <tr valign="top">
      <td width="100%">
				<table cellpadding="0" cellspacing="0" width="100%" id="inner">
					<tr valign="top">
						<td width="100%">
						<div id="divider"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="4" width="770" /></div>
							<div id="title"><?php echo $mosConfig_sitename; ?></div>
							<div id="topmenu">
							<div id="naviglass"><div class="navhorzcontainer"><?php echo $mycssONLY_PRI_menu ?></div></div>	
							</div>
						</td>
					</tr>
					<tr valign="top">
					 <td>
					   <table cellpadding="0" cellspacing="0" width="100%">
							 <tr valign="top">
							   <td width="160">
							     <div class="left">
							       <?php mosLoadModules ( 'left',-2 ); ?>	
								   </div>
								   <div class="invi"><a class="invi" href="http://mambo.medspan.info" title="Free Templates and Modules for Mambo at Mambospan!" target="_blank">Designed by Mambospan</a></div>
							     <img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="1" width="160" />
							   </td>
							   <td><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="10" width="1" /></td>
							    <td width="10"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="10" width="10" /></td>
							   <td width="100%"><div id="pathway"><b>Location:</b>&nbsp;&nbsp; <?php mosPathway(); ?></div>
							   <table width="100%">
									<tr valign="top">
									  	<td>
											<?php mosLoadModules('user1', -2); ?>	
										</td>
										<td>
											<?php mosLoadModules('user2', -2); ?>
										</td>
									</tr>
								</table>
                     			<?php mosMainBody(); ?>
                     			<br />
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
                     			<tr valign="top">
                     		       		<td width="100%">
											<?php mosLoadModules ( 'user3',-2 ); ?>
										</td>
		                     	</tr>
                     			</table>
							     </div>
								 <p align="right"><a href="#up"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/up.png" alt="up, 0 kB" title="spacer" class="" border="0" height="11" width="11" />&nbsp;Go to Top&nbsp;<img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/up.png" alt="up, 0 kB" title="spacer" class="" border="0" height="11" width="11" /></a></p> 
							   </td>
							   <td width="10"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="10" width="10" /></td>
							 </tr>
					   </table>
					 </td>
				    </tr>
				</table>
      </td>
      </tr>
    <tr>
      <td class="bottom">:: <a href="http://www.mamboserver.com" target="_blank">Powered by Mambo</a> :: <a href="http://mambo.medspan.info" title="Free Templates and Modules for Mambo at Mambospan!" target="_blank">Designed by Mambospan</a> :: </td>
      </tr>
  </table>
</body>
</html>