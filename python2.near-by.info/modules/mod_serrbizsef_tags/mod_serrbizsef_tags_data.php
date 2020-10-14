<?php
/**
* @version $Id: mod_serrbizsef_tags_data.php 2007-10-19 11:19:30 $
* @package Joomla
* @subpackage SerrBizSEF
* @copyright Copyright (C) Serr.biz. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*
* SerrBizSEF is a released under the terms of the GNU General Public License;
* Warranty : This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
* FITNESS FOR A PARTICULAR PURPOSE. 
*
* @author Serr.biz
* @version 1.0 Complete
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );
class SerrBizSEFSocialTags
{
    var $action;        
    var $objParams;
    
    function ConstructBookmarks($action)
    {
        global $database,$mosConfig_live_site;              

        $return = false;
        if(!$action) return $return;            
        $this->action = $action;                

        switch($this->action)
        {
            case 'loadParam':
            $sql = "SELECT params FROM #__modules WHERE module = 'mod_serrbizsefTags'";
            $database->setQuery($sql);
            $result = $database->query();
            if($result) {                
                $database->loadObject($social);
                $this->objParams = new mosParameters($social->params);    
                $return = true;
            }  
            break;
        }
        return $return;
    }   
}

?> 