<?php
/**
* @version		$Id: view.html.php 220 2008-02-10 21:31:18Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.view');
class url_editViewurl_edit extends JView {


	function edit ( $tpl = null) {

		$document =& JFactory::getDocument();
		$document->addStyleSheet( '/administrator/components/com_smartsef/includes/smartsef.css');

		$Sef_record	= & $this->get( 'Data');

		smart_import( 'joomla.html.html.select');
		$deleted_list[] = JHTMLSelect::Option( '1', JTEXT::_('Yes') );
		$deleted_list[] = JHTMLSelect::Option( '0', JTEXT::_('No') );
   	   	$lists['locked'] = JHTMLSelect::genericlist( $deleted_list, 'delete_locked', 'class="inputbox" size="1 "','value', 'text', $Sef_record->delete_locked );

		$state_list[] = JHTMLSelect::Option( '0', JTEXT::_('Unpublished') );
		$state_list[] = JHTMLSelect::Option( '1', JTEXT::_('Published') );
   	   	$lists['state'] = JHTMLSelect::genericlist( $state_list, 'published', 'class="inputbox" size="1 "','value', 'text',$Sef_record->published );

		$valid_list[] = JHTMLSelect::Option( '0', JTEXT::_('Yes') );
		$valid_list[] = JHTMLSelect::Option( '1', JTEXT::_('No') );
   	   	$lists['valid'] = JHTMLSelect::genericlist( $valid_list, 'valid', 'class="inputbox" size="1 "','value', 'text',$Sef_record->valid );

   	   	$input_string = "";
   	   	if ($Sef_record->vars != "") {
   	   		$Sef_record->vars = unserialize( $Sef_record->vars ) ;
   	   		// Create the input string
			if ( $Sef_record->vars != FALSE) {
				foreach ( $Sef_record->vars as $parameter => $value ) {
					if (!empty($parameter) & !empty($value)) {
						$input_string .=  $parameter . "=" . $value . "\n";
					}
				}
			} else {
				// could not fetch the correct variables, show the unfriendly url;
				$input_string = 'ERROR: could not retrieve the correct parameters';
			}
		}
		$Sef_record->vars = $input_string;
		$this->assignRef('row'	,	$Sef_record	);
		$this->assignRef('lists',	$lists		);


		parent::display($tpl);
	}
}
?>