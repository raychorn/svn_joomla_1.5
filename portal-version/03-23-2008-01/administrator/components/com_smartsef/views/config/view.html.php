<?php
/**
* @version		$Id: view.html.php 220 2008-02-10 21:31:18Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view');

class configViewconfig extends JView {


	function edit($tpl = null) {

		//$this->smartsef_config->url_part_print;
		// Create the select lists;
  		$document =& JFactory::getDocument();
  		$document->addStyleSheet( 'components/com_smartsef/includes/smartsef.css');
  		JHTML::_('behavior.mootools');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");


		smart_import( 'joomla.html.html.select');
		$lists['mode'] 						= JHTMLSelect::booleanlist('mode', 			null,$this->smartsef_config->mode );
		$lists['url_lowercase'] 			= JHTMLSelect::booleanlist('url_lowercase', null,$this->smartsef_config->url_lowercase );
		$lists['enable_sefurl_lookup'] 		= JHTMLSelect::booleanlist('enable_sefurl_lookup', null,$this->smartsef_config->enable_sefurl_lookup );
		$lists['append_itemid_to_sefurl'] 	= JHTMLSelect::booleanlist('append_itemid_to_sefurl', null,$this->smartsef_config->append_itemid_to_sefurl );
		$lists['append_itemid_to_rawurl'] 	= JHTMLSelect::booleanlist('append_itemid_to_rawurl', null,$this->smartsef_config->append_itemid_to_rawurl );
		$lists['check_for_unique_article_urls'] = JHTMLSelect::booleanlist('check_for_unique_article_urls', null,$this->smartsef_config->check_for_unique_article_urls );
		$lists['replace_joomla_space_char'] = JHTMLSelect::booleanlist('replace_joomla_space_char', null,$this->smartsef_config->replace_joomla_space_char );
		$lists['use_title_alias_for_menus'] = JHTMLSelect::booleanlist('use_title_alias_for_menus', null,$this->smartsef_config->use_title_alias_for_menus );
		$lists['use_title_alias_fullpath'] 	= JHTMLSelect::booleanlist('use_title_alias_fullpath', null,$this->smartsef_config->use_title_alias_fullpath );
		$lists['log_404_errors'] 			= JHTMLSelect::booleanlist('log_404_errors', null,$this->smartsef_config->log_404_errors );

		$url_part = array();
  		$url_part[] = JHTMLSelect::Option( 'alias', 'Use the alias field' );
		$url_part[] = JHTMLSelect::Option( 'title', 'Use the title field' );

		$lists['section_url_part']	= JHTMLSelect::genericlist( $url_part, 'section_url_part', 'class="inputbox" size="1 "' ,'value', 'text', $this->smartsef_config->section_url_part );
		$lists['category_url_part'] = JHTMLSelect::genericlist( $url_part, 'category_url_part', 'class="inputbox" size="1 "' ,'value', 'text', $this->smartsef_config->category_url_part );
		$lists['article_url_part'] 	= JHTMLSelect::genericlist( $url_part, 'article_url_part', 'class="inputbox" size="1 "' ,'value', 'text', $this->smartsef_config->article_url_part );

		$url_paths_section = array();
		$url_paths_section[] = JHTMLSelect::Option( '2', '/menu/section' );
		$url_paths_section[] = JHTMLSelect::Option( '1', '/section' );
		$url_paths_section[] = JHTMLSelect::Option( '0', '/menu' );
		$lists['url_paths_section'] 	= JHTMLSelect::genericlist( $url_paths_section, 'url_paths_section', 'class="inputbox" size="1 "' ,'value', 'text', $this->smartsef_config->url_paths_section );

		$url_paths_category = array();
		$url_paths_category[] = JHTMLSelect::Option( '4', '/menu/section/category' );
		$url_paths_category[] = JHTMLSelect::Option( '3', '/section/category' );
		$url_paths_category[] = JHTMLSelect::Option( '2', '/menu/category' );
		$url_paths_category[] = JHTMLSelect::Option( '1', '/category' );
		$url_paths_category[] = JHTMLSelect::Option( '0', '/menu' );
		$lists['url_paths_category'] 	= JHTMLSelect::genericlist( $url_paths_category, 'url_paths_category', 'class="inputbox" size="1 "' ,'value', 'text', $this->smartsef_config->url_paths_category );

		$url_paths_article = array();
		$url_paths_article[] = JHTMLSelect::Option( '3', '/menu/section/category/article' );
		$url_paths_article[] = JHTMLSelect::Option( '2', '/section/category/article' );
		$url_paths_article[] = JHTMLSelect::Option( '1', '/category/article' );
		$url_paths_article[] = JHTMLSelect::Option( '0', '/article' );
		$lists['url_paths_article'] 	= JHTMLSelect::genericlist( $url_paths_article, 'url_paths_article', 'class="inputbox" size="1 "' ,'value', 'text', $this->smartsef_config->url_paths_article );

		// Check if the 404_logfile is empty
		if ( $this->smartsef_config->log_404_path == "") {
			$this->smartsef_config->log_404_path = JPATH_ROOT . DS . 'logs' . DS . 'smartsef_404.log' ;
		}

		$this->assignRef('lists',		$lists);


		parent::display( $tpl) ;
	}
}
?>