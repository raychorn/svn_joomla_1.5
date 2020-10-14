<?php
/**
* @version		$Id: plugin_install.php 201 2008-01-30 21:31:10Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
JToolBarHelper::title(   JText::_( 'VW_PLUGGIN_INSTALL_TITLE' ), 'smartsef_plugin' );
JToolBarHelper::custom( 'back_view','back','back','Back' , false);
JToolBarHelper::help( 'screen.smartsef' );

$directory = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'plugins';
if ( is_writable($directory) ) {
?>
<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">


	<table class="adminform">
	<tbody><tr>
		<th colspan="2"><?php echo JTEXT::_('VW_PLUGGIN_INSTALL_UPLOAD') ?></th>
	</tr>
	<tr>
		<td width="120">
			<label for="install_package"><?php echo JTEXT::_('VW_PLUGGIN_INSTALL_PACKAGE') ?></label>

		</td>
		<td>
			<input class="input_box" id="install_package" name="install_package" size="57" type="file">
			<input class="button" value="Upload File &amp; Install" onclick="submitbutton()" type="button">
		</td>
	</tr>
	</tbody>
	</table>

	<input name="type" value="" type="hidden">
	<input name="task" value="doinstall" type="hidden">
	<input type="hidden" name="option" value="com_smartsef" />
	<input type="hidden" name="control" value="plugins" />
</form>
<?php
} else {
?>
	<table class="adminform">
	<tbody><tr>
		<th colspan="2">Upload Smartsef Package File</th>
	</tr>
	<tr>
		<td>
			<h1><?php JTEXT::_('VW_PLUGGIN_INSTALL_DIR') . $directory ?></h1>
		</td>
	</tr>
	</tbody>
<?php
}
?>