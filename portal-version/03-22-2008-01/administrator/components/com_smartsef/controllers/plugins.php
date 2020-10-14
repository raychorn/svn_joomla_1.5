<?php
/**
* @version		$Id: plugins.php 207 2008-01-31 21:32:47Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.controller' );
class pluginsController extends JController {

	function __construct() 	{
		parent::__construct();
		$this->registerTask( 'unpublish', 'publish' );
	}

	function delete () {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		$model = $this->getModel('plugins');
		foreach ( $cid as $id ) {
			$model->delete($id );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=plugins&task=view','Smartsef plugin(s) are removed');
	}

	// Display an overview of the available URL in the repos;
	function view () {
		$model =& $this->getModel ('plugins');
		$view  = $this->getView  ( 'plugins','html');
		$view->setModel( $model, true );
		//$model = $this->getModel('plugins');
		$view->view( );
	}


	/*
	 * Edit the Smartsef plugin;
	 */
	function edit() {
		$model =& $this->getModel ('plugins');
		$view  = $this->getView  ( 'plugins','edit');
		$view->setModel( $model, true );
		$view->edit( 'edit');
	}

	function back_view() {
		$this->setRedirect( 'index.php?option=com_smartsef&control=plugins&task=view');
	}


	function back () {
		$this->setRedirect( 'index.php?option=com_smartsef');
	}
	function cancel ( ) {
		$this->setRedirect( 'index.php?option=com_smartsef&control=plugins&task=view');
	}

	/*
	 * Publish the plugin
	 */

	function publish() {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		$model = $this->getModel('plugins');
		foreach ( $cid as $id ) {
			$model->publish($id );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=plugins&task=view');
	}

	/*
	 * Install a plugin
	 */
	function save () {
		$id  	= JRequest::getVar	('id', 0, 'method', 'int');
		$model 	= $this->getModel	('plugins');
		if ( !$model->save( $id ) ) {
			return JError::raiseWarning( 500, $url_record->getError() );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=plugins&task=view', JTEXT::_('Smartsef plugin record is saved'));
	}

	function install() {
		$view  = $this->getView  ( 'plugins','install');
		$view->install('install');
	}

	function doinstall() {

		jimport( 'joomla.application.component.model' );
		jimport( 'joomla.installer.installer' );
		// check if the plugins directory  is writable
		$directory = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'plugins';
		if ( !is_writable($directory) ) {

		}

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			JError::raiseWarning('1001', JText::_('Your PHP settings doesn\'t allow uploads'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			JError::raiseWarning('1001', JText::_('The PHP extension ZLIB is not loaded, file cannot be unziped'));
			return false;
		}

		$userfile = JRequest::getVar('install_package', null, 'files', 'array' );

		// Check if the upload is succeeded;
			// If there is no uploaded file, we have a problem...
		if (!is_array($userfile) ) {
			JError::raiseWarning('1001', JText::_('No file selected'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ( $userfile['error'] || $userfile['size'] < 1 ) {
			JError::raiseWarning('1001', JText::_('WARNINSTALLUPLOADERROR'));
			return false;
		}

		$config =& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path').DS.$userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest);
		jimport('joomla.installer.helper');
		$package = JInstallerHelper::unpack($tmp_dest);

		// Get an installer instance
		$installer =& JInstaller::getInstance();

		$adapter = new smartsef_plugin_adapter( $installer );

		$installer->_adapters['smartsef']  =& $adapter;

		// Install the package
		if (!$installer->install($package['dir'])) {
			// There was an error installing the package
			$msg = JText::sprintf('INSTALLEXT', JText::_($package['type']), JText::_('Error'));
			$result = false;
		} else {
			// Package installed sucessfully
			$msg = JText::sprintf('INSTALLEXT', JText::_($package['type']), JText::_('Success'));
			$result = true;
		}

		// Cleanup the install files
		if (!is_file($package['packagefile'])) {
			$config =& JFactory::getConfig();
			$package['packagefile'] = $config->getValue('config.tmp_path').DS.$package['packagefile'];
		}
		JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);
		$this->setRedirect( 'index.php?option=com_smartsef&control=plugins&task=view', JTEXT::_('Smartsef plugin is installed'));
		return $package;

	}
}
/*
 * Smartsef plugin install adapater
 */
class smartsef_plugin_adapter extends JObject {

	function __construct( &$parent ) 	{
		$this->parent =& $parent;
	}

	function install()	{

		$manifest =& $this->parent->getManifest();
		$this->manifest =& $manifest->document;
		$root =& $manifest->document;

		$name 		=& $root->getElementByPath('name');
		$author 	=& $root->getElementByPath('author');
		$authorUrl 	=& $root->getElementByPath('authorurl');
		$version 	=& $root->getElementByPath('version');
		$plugin		=& $root->getElementByPath('plugin');
		$description	=& $root->getElementByPath('description');
		$name 		= JFilterInput::clean($name->data(), 'cmd');;
		$author 	= $author->data();
		$version	= $version->data();
		$authorUrl 	= $authorUrl->data();
		$description = $description->data();
		$plugin		= $plugin->data();

		$basePath = JPATH_SITE;

		// set the installation path
		$this->parent->setPath('extension_site', $basePath.DS."administrator".DS."components".DS."com_smartsef".DS."plugins");

		$element =& $root->getElementByPath('files');

		// install the files;
		if ($this->parent->parseFiles($element) === false) {
			// Install failed, rollback changes
			$this->parent->abort();
			return false;
		} else {
			$plugin_record =& JTable::getInstance('smartsef_plugins', 'Table');
			$plugin_record->name 	= $name;
			$plugin_record->author	= $author;
			$plugin_record->author_url = $authorUrl;
			$plugin_record->version	= $version;
			$plugin_record->description = $description;
			$plugin_record->published = 1;
			$plugin_record->plugin = $plugin;
			$plugin_record->store();
			return true;
		}

	}
}
?>
