<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: install.docman.php 561 2008-01-17 11:34:40Z mjaz $
 * @package DOCman_1.4
 * @copyright (C) 2003-2008 The DOCman Development Team
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.org/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'install.docman.helper.php');

function com_install() {
    global $mosConfig_absolute_path, $_DOCMAN;

    // Logo
    DMInstallHelper::showLogo();

    if(!DMInstallHelper::checkWritable())
    {
        echo 'Installation failed!<br />';
        return false;
    }

    // Upgrade tables
    DMInstallHelper::upgradeTables();

    // Files
    DMInstallHelper::fileOperations();

    // modules
    if( defined('_DM_J15')) {
    	DMInstallHelper::moduleFilesJ15();
    } else {
        DMInstallHelper::moduleFiles();
    }
    DMInstallHelper::moduleDB();

    //plugins
    DMInstallHelper::pluginFiles();
    DMInstallHelper::pluginDB();

    // index.html files
    $paths = array( 'components'.DS.'com_docman',
                    'administrator'.DS.'components'.DS.'com_docman',
                    'mambots'.DS.'docman',
                    'dmdocuments'  );
    foreach ( $paths as $path ) {
        $path = $mosConfig_absolute_path.DS.$path;;
        DMInstallHelper::createIndex( $path );
    }

    // Update menus
    DMInstallHelper::removeAdminMenuImages();
    DMInstallHelper::setAdminMenuImages();

    // Link to add sample data
    DMInstallHelper::cpanel();
}
