<?php
defined('_JEXEC') or die('Restricted access');
/**
* Attachments component
* @package Attachments
* @Copyright (C) 2007, 2008 Jonathan M. Cameron, All Rights Reserved
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @link http://joomlacode.org/gf/project/attachments/frs/
* @author Jonathan M. Cameron
**/

function com_install()
{
	// First make sure that this version of Joomla is 1.5 or greater
	$version = new JVersion();
	if ( (real)$version->RELEASE < 1.5 ) {
		echo "<h1 style=\"color: red;\">The 'Attachments' package will only work on Joomla version 1.5 or later!</h1>";
		return false;
		}
	
	// Check to see if the plugin has been installed yet
	$plugin_installed = false;
	$plugin_published = false;
	$db =& JFactory::getDBO();
	$query = "SELECT published FROM #__plugins WHERE element='attachments' AND folder='content' LIMIT 1";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	if ( count($rows) > 0 ) {
		$plugin_installed = true;
		$plugin_published = (intval($rows[0]->published) == 1);
		}
	?>
	<div class="header">Attachments for articles component succesfully installed! <br>
	<?php
	if ( $plugin_installed ) {
		if ( !$plugin_published )
			echo "<i>Don&rsquo;t forget to enable the plugin!</i>";	
		}
	else {
		echo "<i>Don&rsquo;t forget to install the plugin too!</i>";
		}
	?>
	</div>
	<h2>NOTES:</h2>
	
	<p>
		Once both the attachment plugin and component have been installed and the plugins are enabled, 
		the attachments should work.  The default after installation is for the attachments to be 
		visible to anyone that is logged in and for the link to add attachments to visible only 
		to the author of the article.   Both of these options can be changed via the attachments 
		parameters which can be changed in the plugin manager.
	</p>

	<p>
		Once an attachment is uploaded, it is not visible until it is published.  To do this go to the
		administrative backend and select "Article&nbsp;Attachments" under the "Components" menu.  This will
		show a list of attachments and has controls to publish the attachments.  The option to make 
		attachments automatically be published after they are uploaded can be changed via the plugin 
		manager.
	</p>

	<p>
        This extension respects the options in the Media Manager regarding what types of files can 
		be uploaded.  If you can&rsquo;t attach certain file types (such as zip files), go to the
		"Global Configuration" item under the "Site" menu in the administrative backend.  Click 
		on the "System" tab and look for the "Media Settings" section.  You can add appropriate 
		file extensions or mime types there.
	</p>
	
	<p>
		This extension now supports translations.  However, only English, Chinese, Dutch, and
		Brazilian Portuguese translations are currently provided.  If you would like to help 
		translate the extension to any other language, please contact the author (see below).
	</p>
	
	<p>
        In some versions of Joomla!, you may see warning messages above that
        various language files could not be installed.  These are harmless warnings and can
        be ignored.  If the warnings refer to one of the languages you need, you must install
        the Joomla! language packs for that language before installing this extension.
	</p>
	
	<p>
		Please see the help page for further details, including known limitations of this extension and 
		suggestions on how to upgrade this extension.  To get to the help page, select 
		"Article&nbsp;Attachments" under the "Components" menu in the adminstrative	backend.   
		Click on the help icon on the right to bring up the help page.
	</p>
	
	<p>
		Please report bugs and suggestions to <a href="mailto:jmcameron@jmcameron.net">jmcameron@jmcameron.net</a>.
	</p>
	<?php
	
	return true;
}
?>