<?php
/*
* mod_html allows inclusion of HTML/JS/CSS and now PHP, in Joomla/Mambo Modules
* (c) Copyright: Fiji Web Design, www.fijiwebdesign.com.
* email: info@fijiwebdesign.com 
* date: Feb 4, 2007
* Release: 1.0.0.Beta
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// mod_php version
$ver = '1.0.0.Beta';

// define our functions
if (!class_exists('modHtml')) {

	/**
	* Our modHTML namespace. 
	* All functions are static.
	*/
	class modHTML {
		/**
		* Parses PHP by writing to temporary file
		* todo: write to filename = (sha1 of $html). maintanance after last access expires
		*/
		function parsePHPviaFile($html) {
			$tmpfname = tempnam("/tmp", "html");
			$handle = fopen($tmpfname, "w");
			fwrite($handle, $html, strlen($html));
			fclose($handle);
			include_once($tmpfname);
			unlink($tmpfname);
		}
	}
}

// get module parameters
$html = $params->get( 'fwd_html' );
$eval_php = $params->get( 'eval_php' );
$discovery = $params->get( 'discovery' );

// remove annoying <br /> tags from module parameter
$html = str_replace('<br />', '', $html);

// show that site uses mod_php
$debug = $discovery ? mosGetParam($_REQUEST, 'debug') : false;
if ($discovery) {
	echo "\r\n<!-- /mod_php version $ver (c) www.fijiwebdesign.com -->\r\n";
}
if ($debug == 'mod_php') {
	echo '<div style="border:1px solid red;padding:6px;">';
	echo '<div style="color:red;font-weight:bold;">Mod PHP</div>';
}

// evaluate the PHP code
if ($eval_php) {
	modHtml::parsePHPviaFile($html);
} else {
	echo $html;
}

// end show site uses mod_php
if ($debug == 'mod_php') {
	echo '</div>';
}
if ($discovery) {
	echo "\r\n<!-- mod_php version $ver/ -->\r\n";
}

?>