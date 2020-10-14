<?php 
defined('_JEXEC') or die('Restricted access');
/**
* Attachments plugin
* @package Attachments
* @Copyright (C) 2007, 2008 Jonathan M. Cameron, All Rights Reserved
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @link http://joomlacode.org/gf/project/attachments/frs/
* @author Jonathan M. Cameron
**/

$mainframe->registerEvent('onAfterDispatch', 'addAttachmentsStyleSheet');
$mainframe->registerEvent('onAfterDisplayContent', 'addAttachments');


function addAttachmentsStyleSheet()
{
    $document = & JFactory::getDocument();
    $document->addStyleSheet( JURI::base() . 'plugins/content/attachments.css', 
                              'text/css', null, array() );
}


function attachments_attachmentListHTML($article_id, $user_can_add, $Itemid, $from)
{
    require_once(JPATH_SITE.DS.'components'.DS.'com_attachments'.DS.'helper.php');

    // Generate the HTML for the attachments for the specified article
    $alist = "";
    $db =& JFactory::getDBO();
    $query = "SELECT count(*) FROM #__attachments WHERE article_id='" . $article_id . "' AND published='1'";
    $db->setQuery($query);
    $total = $db->loadResult();
    if ( $total > 0 ) {

        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');

        // Check the security status
        $attach_dir = JPATH_SITE.DS.$params->get('upload_dir', 'attachments');
        $secure = $params->get('secure', false);
        $hta_filename = $attach_dir.DS.'.htaccess';
        if ( ($secure && !file_exists($hta_filename)) ||
             (!$secure && file_exists($hta_filename)) ) {
            AttachmentsHelper::setup_upload_directory($attach_dir, $secure);
            }

        $delete_link = false;
        if ( $user_can_add ) {                  
            $delete_link = "index.php?option=com_attachments&task=delete&id=%d";
            $delete_link .= "&artid=%d";
            if ( $from ) {
                // Add a var to give a hint of where to return to
                $delete_link .= "&from=$from";
                }
            }

        $alist = AttachmentsHelper::attachmentsTableHTML($article_id, false, true, $delete_link);
        }

    return $alist;
}


function attachments_attachmentButtonsHTML($article_id, $Itemid, $from)
{
    // Generate the HTML for a  button for the user to click to get to a form to add an attachment
    $url = "index.php?option=com_attachments&task=upload&artid=$article_id";
    if ( $from ) {
        // Add a var to give a hint of where to return to
        $url .= "&from=$from";
        }
    $url = JRoute::_($url);
    $icon_url = JURI::Base() . 'components/com_attachments/media/attachment.gif';
        
    return "\n<div class=\"addattach\"><a href=\"$url\"><img src=\"$icon_url\" alt=\"\" /></a>&nbsp;<a href=\"$url\">" . JText::_('ADD ATTACHMENT') . "</a></div>\n";
}


function addAttachments( &$row, &$params )
{
    // Get the component parameters
    jimport('joomla.application.component.helper');
    $attachParams       = JComponentHelper::getParams('com_attachments');

    // Get some of the options
    $user =& JFactory::getUser();
    $logged_in = $user->get('username') <> '';
    $user_type = $user->get('usertype', false);

    // Load the language files from the backend
    $lang = & JFactory::getLanguage();
    $lang->load('plg_frontend_attachments', JPATH_ADMINISTRATOR);

    // Check to see whether the attachments should be hidden for this article
    $hide_attachments_for = trim($attachParams->get('hide_attachments_for', ''));
    if ( $hide_attachments_for <> '' ) {
        $hide_frontpage = false;
        $hide_all_but_article_views = false;
        $hide_specs = split(',', $hide_attachments_for);
        foreach ( $hide_specs as $hide ) {
            if ( $hide == 'frontpage' ) {
                $hide_frontpage = true;
                }
            elseif ( $hide == 'all_but_article_views' ) {
                $hide_all_but_article_views = true;
                }
            else {
                // We assume it must be section/category specs
                $sectionid = intval($row->sectionid);
                $catid = intval($row->catid);
                $sect_cat = split('/', $hide);
                $hide_sect_id = intval($sect_cat[0]);
                $hide_cat_id = -1;
                if ( count($sect_cat) > 1 ) 
                    $hide_cat_id = intval($sect_cat[1]);
                if ( ($hide_cat_id == -1) and ($sectionid == $hide_sect_id) ) {
                    return;
                    }
                if ( ($sectionid == $hide_sect_id) and ($catid == $hide_cat_id) ) { 
                    return;
                    }
                }
            }
            
            // See if we should hide on the frontpage
            if ( $hide_frontpage ) {
                if ( JRequest::getVar( 'view', false) == 'frontpage' )
                    return;
                }
            // See if we should hide all but article views
            if ( $hide_all_but_article_views ) {
                if ( !(JRequest::getVar('view') == 'article') )
                    return;
                }
        }

    // See whether we can display the links to add attachments
    $who_can_add = $attachParams->get('who_can_add');
    $user_can_add = false;
    if ( ($user_type == 'Administrator') ||
         ($user_type == 'Super Administrator') ||
         ( ($who_can_add == 'logged_in') && $logged_in ) ||
         ( ($who_can_add == 'author') && ( $user->get('id') == $row->created_by )) ) {

        $user_can_add = true;
        }

    // Determine where we are 
    global $option;
    $from = JRequest::getVar( 'view', false);
    $Itemid = JRequest::getVar( 'Itemid', false);
    if ( is_numeric($Itemid) )
        $Itemid = intval($Itemid);
    else
        $Itemid = 1;
                
    // Show the attachment list (if appropriate)
    $who_can_see = $attachParams->get('who_can_see');
    $secure = $attachParams->get('secure', false);
    if ( $secure ) {
        if ( $logged_in)
            $row->text .= attachments_attachmentListHtml($row->id, $user_can_add, $Itemid, $from);        
        }
    else { 
        if ( ( $who_can_see == 'anyone' ) ||
             ( ($who_can_see == 'logged_in') && $logged_in ) ) {
            $row->text .= attachments_attachmentListHtml($row->id, $user_can_add, $Itemid, $from);
            }
        }
        
    if ( $user_can_add ) {
        $row->text .= attachments_attachmentButtonsHTML($row->id, $Itemid, $from);  
        }
}

?>
