<?php
/* @version		$Id: 404handler.php 236 2008-03-08 13:39:50Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* 404 handler function of smartsef. This takes care of handling the 404 errors
*
* Initial parameters are the smartsef configuration settings (for the document id and the log info) and the URL request
*
* return value is the $vars request object in case you want to display an error page or another page;
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

function smartsef_404handler ( $smartsef_config, $url2search ) {

	if ( $smartsef_config->log_404_errors == '1' & $smartsef_config->log_404_path != '' ) {
		// check if the file is writeble;
		if ( !(JPath::isOwner($smartsef_config->log_404_path) && !JPath::setPermissions( $smartsef_config->log_404_path, '0644'))) {
			if ( $handle = fopen($smartsef_config->log_404_path, 'a')) {
				// Make a line based logfile, date;
				$log_string = date('Y-m-d G:i:s');
				$log_string .= ';' . $url2search ;
				fwrite( $handle, "\n" . $log_string );
				//fwrite ( $handle,  );
				fclose( $handle);
			}
		}
	}
	$vars['option'] = 'com_content';
	$vars['view'] 	= 'article';
	$vars['id'] 	= $smartsef_config->page_not_found_id;

	// Set a 404 header
	header( 'HTTP/1.1 404 Page not found' );

	return ( $vars );

}

?>