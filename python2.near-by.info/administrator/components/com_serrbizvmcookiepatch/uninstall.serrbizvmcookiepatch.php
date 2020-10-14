<?php
/**
* @version $Id: uninstall.serrbizvmcookiepatch.php 867 2007-06-20 18:41:06Z soeren_nb $
* @package VirtueMart
* @subpackage classes
* @copyright Copyright (C) 2004-2006 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*
* This class handles the session initialization, restart
* and the re-init of a session after redirection to a Shared SSL domain
*
*/
 

function com_uninstall() 
{
    global $database,$mosConfig_live_site,$mosConfig_absolute_path;
	unlink($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php");
	unlink($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/serrbiz_vm_cookie_patch.php");
	rename($mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/vm_backup_ps_session.php",$mosConfig_absolute_path."/administrator/components/com_virtuemart/classes/ps_session.php");

	unlink($mosConfig_absolute_path."/administrator/components/com_serrbizvmcookiepatch/");
	unlink($mosConfig_absolute_path."/components/com_serrbizvmcookiepatch/");

	unlink($mosConfig_absolute_path."/administrator/components/com_serrbizvmcookiepatch");
	unlink($mosConfig_absolute_path."/components/com_serrbizvmcookiepatch");

}//function com_install() 	 
?> 