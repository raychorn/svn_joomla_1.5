<?php
/**
* banner.blastchatc.php
* @package BlastChat Client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/* Support functions for loading banners from a module assigned to position*/

function bc_loadBanner() {

	$pos = mosGetParam($_REQUEST, 'pos', '');
	$style = mosGetParam($_REQUEST, 'st', 0);
	$no_html = mosGetParam($_REQUEST, 'no_html', 0);
	$dynamic = mosGetParam($_REQUEST, 'dyn', 0);

	if (!$pos) {
		return;
	}
	if ($dynamic) {
		//set no caching in browser, this is for dynamic reloading of banner
		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
		header( "Cache-Control: no-store, no-cache, must-revalidate" );
		header( "Pragma: no-cache" );
	}

	if ($no_html) {
		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">"
		."\n<html xmlns=\"http://www.w3.org/1999/xhtml\">"
		."\n<head>"
		."\n<title></title>"
		."\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />"
		."\n<meta name=\"robots\" content=\"noindex, nofollow\" />"
		."\n</head>"
		."\n<body>\n"
		;
	}
	mosLoadModules($pos, $style);
	if ($no_html) {
		echo "\n</body>\n</html>";
	}
}
?>
