<?php
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2007 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Configuration file for the File Manager Connector for PHP.
 *
 * Modified for joomlafck2
 * Copyright (C) 2007 Nick Miles - Database Developments Ltd
 *
*/

global $Config ;

define( '_VALID_MOS', 1 );
require_once ( '../../../../../../../configuration.php' );
require_once ( $mosConfig_absolute_path . '/includes/joomla.php' );

// Start session
session_name( md5( $mosConfig_live_site ) );
session_start();

// Try and get frontend login
$mainframe = new mosMainFrame( $database, $option, '.' );
$mainframe->initSession();
$my = $mainframe->getUser();

// If no frontend login, try backend
if ( !$my->id ) {
	$my = new mosUser( $database );
	$my->id = intval( mosGetParam( $_SESSION, 'session_user_id', '' ) );	
}

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
// WARNING: don't just set "ConfigIsEnabled = true", you must be sure that only 
//		authenticated users can access this file or use some kind of session checking.
if ( $my->id ) {
	$Config['Enabled'] = true ;
} else {
	$Config['Enabled'] = false ;
}

// Load mambot params from db
$query = "SELECT id FROM #__mambots WHERE element = 'joomlafck2' AND folder = 'editors'";
$database->setQuery( $query );
$id = $database->loadResult();
$mambot = new mosMambot( $database );
$mambot->load( $id );
$params =& new mosParameters( $mambot->params );

//	$Config['UserFilesPath'] = $mosConfig_live_site . '/';
//	$Config['UserFilesAbsolutePath'] = $mosConfig_absolute_path . '/';

$exp_url = parse_url($mosConfig_live_site);
$Config['UserFilesPath'] = @$exp_url["path"] . '/';
$Config['UserFilesAbsolutePath'] = $mosConfig_absolute_path . '/';

// Due to security issues with Apache modules, it is reccomended to leave the
// following setting enabled.
$Config['ForceSingleExtension'] = true ;

// Perform additional checks for image files
// if set to true, validate image size (using getimagesize)
$Config['SecureImageUploads'] = true;

// What the user can do with this connector
$Config['ConfigAllowedCommands'] = array('QuickUpload', 'FileUpload', 'GetFolders', 'GetFoldersAndFiles', 'CreateFolder') ;

// Allowed Resource Types
$Config['ConfigAllowedTypes'] = array('File', 'Image', 'Flash', 'Media') ;

// For security, HTML is allowed in the first Kb of data for files having the
// following extensions only.
$Config['HtmlExtensions'] = array("html", "htm", "xml", "xsd", "txt", "js") ;

/*
	Configuration settings for each Resource Type

	- AllowedExtensions: the possible extensions that can be allowed. 
		If it is empty then any file type can be uploaded.
	- DeniedExtensions: The extensions that won't be allowed. 
		If it is empty then no restrictions are done here.

	For a file to be uploaded it has to fullfil both the AllowedExtensions
	and DeniedExtensions (that's it: not being denied) conditions.

	- FileTypesPath: the virtual folder relative to the document root where
		these resources will be located. 
		Attention: It must start and end with a slash: '/'

	- FileTypesAbsolutePath: the physical path to the above folder. It must be
		an absolute path. 
		If it's an empty string then it will be autocalculated.
		Usefull if you are using a virtual directory, symbolic link or alias. 
		Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
		Attention: The above 'FileTypesPath' must point to the same directory.
		Attention: It must end with a slash: '/'

	 - QuickUploadPath: the virtual folder relative to the document root where
		these resources will be uploaded using the Upload tab in the resources 
		dialogs.
		Attention: It must start and end with a slash: '/'

	 - QuickUploadAbsolutePath: the physical path to the above folder. It must be
		an absolute path. 
		If it's an empty string then it will be autocalculated.
		Usefull if you are using a virtual directory, symbolic link or alias. 
		Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
		Attention: The above 'QuickUploadPath' must point to the same directory.
		Attention: It must end with a slash: '/'

	 	NOTE: by default, QuickUploadPath and QuickUploadAbsolutePath point to 
	 	"userfiles" directory to maintain backwards compatibility with older versions of FCKeditor. 
	 	This is fine, but you in some cases you will be not able to browse uploaded files using file browser.
	 	Example: if you clik on "image button", select "Upload" tab and send image 
	 	to the server, image will appear in FCKeditor correctly, but because it is placed 
	 	directly in /userfiles/ directory, you'll be not able to see it in built-in file browser.
	 	The more expected behaviour would be to send images directly to "image" subfolder.
	 	To achieve that, simply change
			$Config['QuickUploadPath']['Image']			= $Config['UserFilesPath'] ;
			$Config['QuickUploadAbsolutePath']['Image']	= $Config['UserFilesAbsolutePath'] ;
		into:	
			$Config['QuickUploadPath']['Image']			= $Config['FileTypesPath']['Image'] ;
			$Config['QuickUploadAbsolutePath'['Image'] 	= $Config['FileTypesAbsolutePath']['Image'] ;			
		
*/

$Config['AllowedExtensions']['File']	= array('7z', 'aiff', 'asf', 'avi', 'bmp', 'csv', 'doc', 'fla', 'flv', 'gif', 'gz', 'gzip', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'ods', 'odt', 'pdf', 'png', 'ppt', 'pxd', 'qt', 'ram', 'rar', 'rm', 'rmi', 'rmvb', 'rtf', 'sdc', 'sitd', 'swf', 'sxc', 'sxw', 'tar', 'tgz', 'tif', 'tiff', 'txt', 'vsd', 'wav', 'wma', 'wmv', 'xls', 'xml', 'zip') ;
$Config['DeniedExtensions']['File']		= array() ;
$Config['FileTypesPath']['File']		= $Config['UserFilesPath'] . $params->get( 'file_path', 'files/') ;
$Config['FileTypesAbsolutePath']['File']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'] . $params->get( 'file_path', 'files/') ;
$Config['QuickUploadPath']['File']		= $Config['FileTypesPath']['File'] ;
$Config['QuickUploadAbsolutePath']['File']= $Config['FileTypesAbsolutePath']['File'] ;

$Config['AllowedExtensions']['Image']	= array('bmp','gif','jpeg','jpg','png','psd','tif','tiff') ;
$Config['DeniedExtensions']['Image']	= array() ;
$Config['FileTypesPath']['Image']		= $Config['UserFilesPath'] . $params->get( 'image_path', 'images/stories/') ;
$Config['FileTypesAbsolutePath']['Image']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'] . $params->get( 'image_path', 'images/stories/') ;
$Config['QuickUploadPath']['Image']		= $Config['FileTypesPath']['Image'] ;
$Config['QuickUploadAbsolutePath']['Image']= $Config['FileTypesAbsolutePath']['Image'] ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;
$Config['FileTypesPath']['Flash']		= $Config['UserFilesPath'] . $params->get( 'flash_path', 'flash/') ;
$Config['FileTypesAbsolutePath']['Flash']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'] . $params->get( 'flash_path', 'flash/') ;
$Config['QuickUploadPath']['Flash']		= $Config['FileTypesPath']['Flash'] ;
$Config['QuickUploadAbsolutePath']['Flash']= $Config['FileTypesAbsolutePath']['Flash'] ;

$Config['AllowedExtensions']['Media']	= array('aiff', 'asf', 'avi', 'bmp', 'fla', 'flv', 'gif', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'png', 'qt', 'ram', 'rm', 'rmi', 'rmvb', 'swf', 'tif', 'tiff', 'wav', 'wma', 'wmv') ;
$Config['DeniedExtensions']['Media']	= array() ;
$Config['FileTypesPath']['Media']		= $Config['UserFilesPath'] . 'media/' ;
$Config['FileTypesAbsolutePath']['Media']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'] . 'media/' ;
$Config['QuickUploadPath']['Media']		= $Config['FileTypesPath']['Media'] ;
$Config['QuickUploadAbsolutePath']['Media']= $Config['FileTypesAbsolutePath']['Media'] ;

?>
