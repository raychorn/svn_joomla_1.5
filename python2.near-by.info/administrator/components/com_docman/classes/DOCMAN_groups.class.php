<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: DOCMAN_groups.class.php 561 2008-01-17 11:34:40Z mjaz $
 * @package DOCman_1.4
 * @copyright (C) 2003-2008 The DOCman Development Team
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.org/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

if (defined('_DOCMAN_GROUPS')) {
    return true;
} else {
    define('_DOCMAN_GROUPS', 1);
}

class DOCMAN_groups {

    /**
     * Provides a list of all groups
     * $groups = & DOCMAN_groups::getList();
     */
    function & getList() {
        static $groups;

        if( !isset( $groups )) {
            global $database;
            $database->setQuery("SELECT groups_id, groups_name "
             . "\n  FROM #__docman_groups "
             . "\n ORDER BY groups_name ASC");
            $groups = $database->loadObjectList();
        }

        return $groups;
    }
}