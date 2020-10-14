<?php
/**
* @version		$Id: config.php 230 2008-02-20 19:17:37Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class configModelconfig extends Jmodel {
	var $_configuration = null;
	function __construct(){
		parent::__construct();
	}

	function _set_configuration () {
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'config'.DS.'configuration.php' );

		$this->_configuration = new smartsef_configuration();
	}

	// Saves the configuration;
	function _save_configuration() {

		$config = new JRegistry('config');
		$config_array = array();

		$config_array['mode']					= JRequest::getVar('mode', 0, 'post', 'int');
		$config_array['url_lowercase']			= JRequest::getVar('url_lowercase', 0, 'post', 'int');
		$config_array['url_suffix_page']		= JRequest::getVar('url_suffix_page', '.html', 'post', 'string');
		$config_array['url_suffix_pdf']			= JRequest::getVar('url_suffix_pdf', '.pdf', 'post', 'string');
		$config_array['url_part_print']			= JRequest::getVar('url_part_print', 'print', 'post', 'string');
		$config_array['url_part_page']			= JRequest::getVar('url_part_page', 'page_%d', 'post', 'string');
		$config_array['url_part_showall']		= JRequest::getVar('url_part_showall', 'showall', 'post', 'string');
		$config_array['url_remove_chars']		= utf8_encode(JRequest::getVar('url_remove_chars', 'print', 'post', 'string'));
		$config_array['character_space']		= JRequest::getVar('character_space', '_', 'post', 'string');
		$config_array['page_not_found_id']		= JRequest::getVar('page_not_found_id', -1, 'post', 'int');
		$config_array['log_404_errors']			= JRequest::getVar('log_404_errors', 0, 'post', 'int');
		$config_array['log_404_path']			= JRequest::getVar('log_404_path', '', 'post', 'string');
		$config_array['enable_sefurl_lookup']	= JRequest::getVar('enable_sefurl_lookup', 1, 'post', 'int');
		$config_array['append_itemid_to_sefurl']= JRequest::getVar('append_itemid_to_sefurl', 0, 'post', 'int');
		$config_array['append_itemid_to_rawurl']= JRequest::getVar('append_itemid_to_rawurl', 1, 'post', 'int');
		$config_array['section_url_part']		= JRequest::getVar('section_url_part', 'alias', 'post', 'string');
		$config_array['category_url_part']		= JRequest::getVar('category_url_part', 'alias', 'post', 'string');
		$config_array['article_url_part']		= JRequest::getVar('article_url_part', 'alias', 'post', 'string');
		$config_array['url_paths_section']		= JRequest::getVar('url_paths_section', 1, 'post', 'int');
		$config_array['url_paths_category']		= JRequest::getVar('url_paths_category', 1, 'post', 'int');
		$config_array['url_paths_article']		= JRequest::getVar('url_paths_article', 2, 'post', 'int');
		$config_array['check_for_unique_article_urls']		= JRequest::getVar('check_for_unique_article_urls', 1, 'post', 'int');
		$config_array['unique_seperator']			= JRequest::getVar('unique_seperator', '-', 'post', 'string');
		$config_array['replace_joomla_space_char']	= JRequest::getVar('replace_joomla_space_char', '1', 'post', 'int');
		$config_array['valid_regular_expresion']	= JRequest::getVar('valid_regular_expresion', '', 'post', 'string');
		$config_array['use_title_alias_for_menus']	= JRequest::getVar('use_title_alias_for_menus', '1', 'post', 'int');
		$config_array['use_title_alias_fullpath']	= JRequest::getVar('use_title_alias_fullpath', '1', 'post', 'int');
		$config_array['char_replacements']			= utf8_encode(JRequest::getVar('char_replacements', '', 'post', ''));
		$config_array['additional_parameter_check'] = JRequest::getVar('additional_parameter_check', '', 'post', 'string');

		$config->loadArray($config_array);
		// Set the configuration filename
		$filename = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'config'.DS.'configuration.php';

		if ( JPath::isOwner($fname) && !JPath::setPermissions($fname, '0644')) {
			JError::raiseNotice('2002', 'Could not make the ' . $filename . '  writable');
		}

		jimport('joomla.filesystem.file');
		if (JFile::write($filename, $config->toString('PHP', 'config', array('class' => 'smartsef_configuration')))) {
			return true;
		} else {
			return false;
		}


	}
}

?>