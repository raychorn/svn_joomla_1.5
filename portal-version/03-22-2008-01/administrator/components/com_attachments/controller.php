<?php
defined('_JEXEC') or die('Restricted access');
/**
* Attachments component
* @package Attachments
* @Copyright (C) 2007, 2008 Jonathan M. Cameron, All Rights Reserved
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @link http://joomlacode.org/gf/project/attachments/frs/
* @author Jonathan M. Cameron
**/

jimport('joomla.application.component.controller');

class AttachmentsController extends JController
{
    function __construct( $default = array() )
    {
        parent::__construct( $default );
        $this->registerTask('apply', 'save');
        $this->registerTask('applyNew', 'saveNew');
        $this->registerTask('unpublish', 'publish');
    }
    
    function showAttachments()
    {
        global $option, $mainframe;
        $limit = JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
        $limitstart = JRequest::getVar('limitstart', 0);
        $db =& JFactory::getDBO();
        $query = "SELECT count(*) FROM #__attachments";
        $db->setQuery($query);
        $total = $db->loadResult();
        $query = "SELECT *, #__attachments.id as id, c.title as title FROM #__attachments ";
        $query .= "LEFT JOIN #__content as c ON #__attachments.article_id = c.id ORDER BY c.id";
        $db->setQuery($query, $limitstart, $limit);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
            }
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);
        HTML_attachments::showAttachments($option, $rows, $pageNav);
    }

    function add()
    {
        global $option;

        // See if an article is specified
        $article_id = JRequest::getVar('article_id', false);
        $from = JRequest::getVar('from', false);

        // Use a different template for the iframe view
        if ( $from == 'closeme') {
           JRequest::setVar('tmpl', 'component');
           }

        // Add the published selection
        $lists['published'] = JHTML::_('select.booleanlist',
            'published', 'class="inputbox"', false);
        
        if ( !$article_id ) {
            // Get the article names
            $db =& JFactory::getDBO();
            $query = "SELECT * FROM #__content WHERE state != '-2' ORDER BY title";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            $articles = array();
            $articles[] = JHTML::_('select.option', -1, JText::_('SELECT ARTICLE REQUIRED'));
            if ($db->getErrorNum()) {
                $errmsg = JText::_('DB ERROR') . ' ' . $db->stderr();
                echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
                exit();
                }
            foreach ($rows as $row) {
                $articles[] = JHTML::_('select.option', $row->id, '[' . $row->id . '] ' . $row->title);
                }
            $lists['articles'] = JHTML::_('select.genericlist',  $articles, 
                'article_id', 'class="inputbox" size="1"', 'value', 'text', -1);
            }
        else {
            if ( !is_numeric($article_id) ) {
                $errmsg = JText::_('ERROR INVALID ARTICLE ID') . " ($article_id)";
                echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
                exit();     
                }
            }
            
        JRequest::setVar( 'hidemainmenu', 1 );
        
        HTML_attachments::newAttachment($article_id, $lists, $option, $from);
    }

    function edit()
    {
        global $option, $mainframe;
        
        $db =& JFactory::getDBO();

        $row =& JTable::getInstance('Attachments', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array');
        $change_article = JRequest::getVar('change', False) == 'article';
        $id = $cid[0];
        $row->load($id);
        $lists = array();
        $lists['published'] = JHTML::_('select.booleanlist',
            'published', 'class="inputbox"', $row->published);

        // Construct the drop-down list for legal icon filenames
        $icon_filenames = array();
        require_once(JPATH_SITE.DS.'components'.DS.'com_attachments'.DS.'file_types.php');
        foreach ( AttachmentsFileTypes::unique_icon_filenames() as $ifname) {
            $icon_filenames[] = JHTML::_('select.option', $ifname);
            }
        $lists['icon_filenames'] = JHTML::_('select.genericlist',  $icon_filenames, 
                'icon_filename', 'class="inputbox" size="1"', 'value', 'text', $row->icon_filename);

        // Get the uploaders name
        $query = "SELECT name FROM #__users WHERE id='" . $row->uploader_id . "' LIMIT 1";
        $db->setQuery($query);
        $row->uploader_name = $db->loadResult();

        // Massage the data
        $row->size = intval( $row->file_size / 1024.0 );
        $row->url = $mainframe->getSiteURL() . $row->url;

        // Get the article name
        $article_id = $row->article_id;
        $query = "SELECT * FROM #__content WHERE id='$article_id' LIMIT 1";
        $db->setQuery($query);
        $arows = $db->loadObjectList();
        if ( count($arows) != 1 ) {
            $errmsg = JText::_('ERROR INVALID ARTICLE ID') . " ($article_id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $row->article_title = $arows[0]->title;

        // Add the article list if needed
        if ( $change_article ) {
            // Get the article names
            $query = "SELECT * FROM #__content WHERE state != '-2' ORDER BY title";
            $db->setQuery($query);
            $arows = $db->loadObjectList();
            $articles = array();
            $articles[] = JHTML::_('select.option', $row->article_id, '[' . $row->article_id . '] ' . $row->article_title );
            if ($db->getErrorNum()) {
                $errmsg = JText::_('DB ERROR') . ' ' . $db->stderr();
                echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
                exit();
                }
            foreach ($arows as $arow) {
                if ( $arow->id != $row->article_id )
                   $articles[] = JHTML::_('select.option', $arow->id, '[' . $arow->id . '] ' . $arow->title);
                }
            $lists['articles'] = JHTML::_('select.genericlist',  $articles,
                'article_id', 'class="inputbox" size="1"', 'value', 'text', -1);
            }

        JRequest::setVar( 'hidemainmenu', 1 );
        
        HTML_attachments::editAttachment($row, $lists, $option, $change_article);
    }

    function save()
    {
        // Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token');

        global $option;
        $row =& JTable::getInstance('Attachments', 'Table');
        if (!$row->bind(JRequest::get('post'))) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
            }

        // See if the article has been changed, rename files if necessary
        $old_article_id = JRequest::getVar('old_article_id', False);
        if ( $old_article_id && is_numeric($old_article_id) ) {
            $old_article_id = intval($old_article_id);
            }
        $new_article_id = intval($row->article_id);
        if ( $old_article_id && ( $new_article_id != $old_article_id ) ) {
            require(JPATH_BASE.DS.'..'.DS.'components'.DS.'com_attachments'.DS.'helper.php');
            $error_msg = AttachmentsHelper::switch_article($row, $old_article_id, $new_article_id);
            if ( $error_msg != '' ) {
                $warning = JText::_($error_msg);
                echo "<script> alert('$warning'); window.history.go(-1); </script>\n";
                exit();
                }
            }

        // Save the updated attachment
        if (!$row->store()) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
            }

        switch ($this->_task)
        {
            case 'apply':
                $msg = JText::_('CHANGES TO ATTACHMENT SAVED');
                $link = 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->id;
                break;
                
            case 'save':
            default:
                $msg = JText::_('ATTACHMENT SAVED');
                $link = 'index.php?option=' . $option;
                break;
        }
        
        $this->setRedirect($link, $msg);
    }


    function saveNew()
    {
        // Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token');

        // Make sure we have a user
        $user =& JFactory::getUser();
        if ( $user->get('username') == "" ) {
            $errmsg = JText::_('ERROR MUST BE LOGGED IN TO UPLOAD ATTACHMENT');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
            
        require(JPATH_BASE.DS.'..'.DS.'components'.DS.'com_attachments'.DS.'helper.php');

        // Make sure we have a valid article ID
        $article_id = AttachmentsHelper::valid_article_id($_POST['article_id']);
        if ( $article_id == -1 ) {
            $errmsg = JText::_('ERROR MUST SELECT ARTICLE');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();     
            }
            
        // Make sure this user has permission to edit/upload
        AttachmentsHelper::verify_permissions($user, $article_id);

        // Set up the new record
        $row =& JTable::getInstance('Attachments', 'Table');
        if (!$row->bind(JRequest::get('post'))) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
            }
        $row->uploader_id = $user->get('id');
        $row->article_id = $article_id;
                        
        // Handle 'from' clause
        $from = JRequest::getVar('from', ' (no from)');

        $msg = AttachmentsHelper::upload_file($row, $article_id);

        // See where to go to next
        global $option;
        switch ($this->_task)
        {
            case 'applyNew':
                $link = 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->id;
                break;
                
            case 'saveNew':
            default:
                $link = 'index.php?option=' . $option;
                break;
        }
        
        // If called from the editor, go back to it
        if ($from == 'editor') {
            $link = 'index.php?option=com_content&task=edit&cid[]=' . $article_id;
            }
                
        // If we are supposed to close this iframe, do it now.
        if ( $from == 'closeme' ) {
            echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.document.getElementById('sbox-window').close()</script>";
            exit();
            }
        
        $this->setRedirect($link, $msg);
    }

    function myCancel()
    {
        // See if we have a special 'from' to handle
        $from = JRequest::getVar('from', false);
        if ( $from == 'editor' ) {
                
            // Make sure we have a valid article ID
            require(JPATH_BASE.DS.'..'.DS.'components'.DS.'com_attachments'.DS.'helper.php');
            $article_id = AttachmentsHelper::valid_article_id($_POST['article_id']);
            if ( $article_id == -1 ) {
                $this->execute('cancel'); // Give up   
                }
                                
            $link = 'index.php?option=com_content&task=edit&cid[]=' . $article_id;
            $this->setRedirect($link, "Upload canceled!");
            }

        $this->execute('cancel');
    }
        
    function download()
    {
        global $mainframe;
        if ( ! $mainframe->isAdmin() ) {
            $errmsg = JText::_('ERROR MUST BE LOGGED IN AS ADMIN');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();     
            }
        
        // Get the attachment ID
        $id = JRequest::getVar('id', null);
        if ( !is_numeric($id) ) {
            $errmsg = JText::_('ERROR INVALID ATTACHMENT ID') . " ($id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }

        require(JPATH_BASE.DS.'..'.DS.'components'.DS.'com_attachments'.DS.'helper.php');
        
        AttachmentsHelper::download_attachment($id);
    }


    function remove()
    {
        global $option;
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $db =& JFactory::getDBO();
        if (count($cid)) {
            $cids = implode(',', $cid);
            $query = "SELECT filename_sys, id FROM #__attachments WHERE id IN ( $cids )";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            
            // First delete the actual attachment files
            foreach ($rows as $row) {
                unlink($row->filename_sys);
                }
                
            // Delete the entries in the attachments table
            $query = "DELETE FROM #__attachments WHERE id IN ( $cids )";
            $db->setQuery($query);
            if (!$db->query()) {
                echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }
            }
            
        $this->setRedirect( 'index.php?option=' . $option);
    }

    
    function publish()
    {
        global $option;
        $cid = JRequest::getVar('cid', array(), '', 'array');
        if ($this->_task == 'publish') {
            $publish = 1;
            }
        else {
            $publish = 0;
            }
        $attachmentTable =& JTable::getInstance('attachments', 'Table');
        $attachmentTable->publish($cid, $publish);
        $this->setRedirect('index.php?option=' . $option);
    }
    
    function add_icon_filenames()
    {
        global $option; 
        require(JPATH_BASE.DS.'..'.DS.'components'.DS.'com_attachments'.DS.'file_types.php');

        // Get all the attachment IDs
        $db =& JFactory::getDBO();
        $query = "SELECT id, filename, file_type, icon_filename FROM #__attachments";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $IDs = array();
        foreach ($rows as $row) {
            $IDs[] = $row->id;
            }
        
        // Update all the attachments
        $row =& JTable::getInstance('Attachments', 'Table');
        $numUpdated = 0;
        foreach ($IDs as $id) {
            
            $row->load($id);
            
            // Only update those attachment records that don't already have an icon_filename
            if ( strlen( $row->icon_filename ) == 0 ) {
                $new_icon_filename = AttachmentsFileTypes::icon_filename($row->filename, $row->file_type);
                if ( strlen( $new_icon_filename) > 0 ) {
                    $row->icon_filename = $new_icon_filename;
                    if (!$row->store()) {
                        echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                        }
                    $numUpdated++;
                    }
                }
            }
        
        $msg = JText::_('ADDED ICON FILENAMES TO') . " $numUpdated " . JText::_('ATTACHMENT(S)');
        $this->setRedirect('index.php?option=' . $option, $msg);
    }
}
?>
