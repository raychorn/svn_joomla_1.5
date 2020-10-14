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

jimport( 'joomla.application.component.controller' );

require(dirname(__FILE__).DS.'helper.php');

class AttachmentsController extends JController
{
    function __construct( $default = array() )
    {
        parent::__construct( $default );
        // $this->registerTask('apply', 'save');
    }
    
    function upload()
    {
        $document = & JFactory::getDocument();
        $document->addStyleSheet( JURI::base() . 'plugins/content/attachments.css', 
                                  'text/css', null, array() );
                  
        // Setup basic info 
        $user =& JFactory::getUser();
        $article_id = JRequest::getVar('artid', null);
        $from = JRequest::getVar('from', '');
        $Itemid = JRequest::getVar('Itemid', 1);

        // Use a different template for the iframe view
        if ( $from == 'closeme') {
           JRequest::setVar('tmpl', 'component');
           $document->addStyleSheet( JURI::base() . 'plugins/content/attachments2.css',
                                     'text/css', null, array() );
           }

        AttachmentsHelper::verify_permissions($user, $article_id);
        
        // Get the article name
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__content WHERE id='$article_id' LIMIT 1";
        $db->setQuery($query);
        $arows = $db->loadObjectList();
        if ( count($arows) != 1 ) {
            $errmsg = JText::_('ERROR INVALID ARTICLE ID')." ($article_id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $article_title = $arows[0]->title;

        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');

        // Make sure the attachments directory exists
        $upload_subdir = $params->get('attachments_subdir', 'attachments');
        if ( $upload_subdir == "" ) {
            $upload_subdir = 'attachments';
            }
        $upload_dir = JPATH_BASE.DS.$upload_subdir;
        $secure = $params->get('secure', false);
        if ( !AttachmentsHelper::setup_upload_directory( $upload_dir, $secure ) ) {
            $errmsg = JText::_('ERROR UNABLE TO SETUP UPLOAD DIR');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $auto_publish = $params->get('publish_default', false);
        $mod_date_format = $params->get('mod_date_format', 'M-j-Y g:ia');
        
        $save_url = JRoute::_("index.php?option=com_attachments&task=save");

        // Generate the list of attachments
        echo AttachmentsHelper::attachmentsTableHTML($article_id, 
                  'Existing Attachments:', false, false);
        ?>
        <form class="attachments" enctype="multipart/form-data" 
              action="<?php echo $save_url; ?>" method="post">
            <fieldset>
                <legend><?php echo JText::_('UPLOAD ATTACHMENT FILE'); ?></legend>
                <p><label for="upload"><b><?php echo JText::_('FILE'); ?> </b></label> 
                   <input type="file" name="upload" id="upload" size="68" maxlength="512" /></p>
                <p><label for="display_filename"
                                                  title="<?php echo JText::_('DISPLAY FILENAME TOOLTIP'); ?>"
                                                  ><b><?php echo JText::_('DISPLAY FILENAME COLON'); ?></b></label> 
                   <input type="text" name="display_filename" id="display_filename" size="70" maxlength="80" 
                          title="<?php echo JText::_('DISPLAY FILENAME TOOLTIP'); ?>"
                          value="" />&nbsp;<?php echo JText::_('(OPTIONAL)'); ?></p>
                <p><label for="description"><b><?php echo JText::_('DESCRIPTION COLON'); ?></b></label> 
                   <input type="text" name="description" id="description" size="70" maxlength="100" value="" /></p>
            </fieldset>
            <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
            <input type="hidden" name="submitted" value="TRUE" />
            <input type="hidden" name="article_id" value="<?php echo $article_id; ?>" />
            <input type="hidden" name="from" value="<?php echo $from; ?>" />
            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
            <?php echo JHTML::_( 'form.token' ); ?>
            <div align="center">
                <input type="submit" name="submit" value="<?php echo JText::_('UPLOAD'); ?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <!-- <input type="submit" name="submit" value="<?php echo JText::_('CANCEL') ?>"> -->
            </div>
        </form>
        <?php
        if ( !$auto_publish ) {
            $msg = $params->get('auto_publish_warning', '');
            if ( strlen($msg) == 0 ) {
                $msg = 'WARNING ADMIN MUST PUBLISH';
                }
            $msg = JText::_($msg);
            echo "<h2>$msg<h2>";
            }
    }

    function save()
    {        
        // Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token');

        // Make sure that the caller is logged in
        $user =& JFactory::getUser();
        if ( $user->get('username') == "" ) {
            $errmsg = JText::_('ERROR MUST BE LOGGED IN TO UPLOAD ATTACHMENT');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }

        // Make sure we have a valid article ID
        $article_id = AttachmentsHelper::valid_article_id($_POST['article_id']);

        // Check the permissions
        AttachmentsHelper::verify_permissions($user, $article_id);
            
        // Get the Itemid
        $Itemid = $_POST['Itemid'];
        if ( is_numeric($Itemid) )
            $Itemid = intval($Itemid);
        else
            $Itemid = 1;

        // How to redirect?
        $from = $_POST['from'];
        if ( $from == '' ) 
            $from = false;
        if ( $from ) {
            if ( $from == 'frontpage' ) {
                $redirect_to = JURI::base();
                }
            elseif ( $from == 'article' ) {
                $redirect_to = JRoute::_("index.php?option=com_content&view=article&id=$article_id", False);

                // From articles (via readme on frontpage):
                //   http://tulip/joomla/index.php?option=com_content&view=article&id=1
                //   http://tulip/joomla/component/content/article/1
                // From articles via Sectin/Category list:
                //   http://tulip/joomla/index.php?view=article&catid=1&id=3&option=com_content&Itemid=5
                //   http://tulip/joomla/lastest-news-flashes/1/3  (1 is the catid, 3 is the article id)
                }
            else {
                $redirect_to = JURI::base();
                }
            }
        else {
            $redirect_to = JURI::base();
            }

        // See if we should cancel
        if ( $_POST['submit'] == JText::_('CANCEL') ) {
            $msg = JText::_('UPLOAD CANCELED!');
            $this->setRedirect( $redirect_to, $msg );
            return;
            }

        // Bind the info from the form
        $row =& JTable::getInstance('Attachments', 'Table');
        if (!$row->bind(JRequest::get('post'))) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
            }
        $row->uploader_id = $user->get('id');
        $row->article_id = $article_id;

        // Upload the file
        $msg = AttachmentsHelper::upload_file($row, $article_id);
                
        // If we are supposed to close this iframe, do it now.
        if ( $from == 'closeme' ) {
            echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.document.getElementById('sbox-window').close()</script>";
            exit();
            }
                             
        $this->setRedirect( $redirect_to, $msg );
    }

    
    function download()
    {
        // Get the attachment ID
        $id = JRequest::getVar('id', null);
        if ( !is_numeric($id) ) {
            $errmsg = JText::_('ERROR INVALID ATTACHMENT ID') . "  ($id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        
        AttachmentsHelper::download_attachment($id);
    }

    
    function delete()
    {
        global $option;
        $db =& JFactory::getDBO();
        
        // Verify the user is logged in
        $user =& JFactory::getUser();
        if ( $user->get('username') == "" ) {
            $errmsg = JText::_('ERROR MUST BE LOGGED IN TO DELETE ATTACHMENT');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }

        // Make sure we have a valid article ID
        $article_id = JRequest::getVar( 'artid');
        if ( is_numeric($article_id) ) {
            $article_id = intval($article_id);
            }
        else {
            $errmsg = JText::_('ERROR BAD ARTICLE ID');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $query = "SELECT title FROM #__content WHERE id='$article_id'";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if (count($rows) <= 0) {
            $errmsg = JText::_('ERROR CANNOT DELETE INVALID ARTICLE ID') . "  ($article_id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $article_title = $rows[0]->title;

        // Make sure we have a valid attachment ID
        $id = JRequest::getVar( 'id');
        if ( is_numeric($id) ) {
            $id = intval($id);
            }
        else {
            $errmsg = JText::_('ERROR CANNOT DELETE INVALID ATTACHMENT ID') . " ($id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $query = "SELECT filename_sys, filename FROM #__attachments WHERE id='$id'";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if (count($rows) != 1) {
            $errmsg = JText::_('ERROR CANNOT DELETE INVALID ATTACHMENT ID') . "  ($id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        $filename_sys = $rows[0]->filename_sys;
        $filename = $rows[0]->filename;
    
        // Assumption: If a person can upload, they can delete
        AttachmentsHelper::verify_permissions($user, $article_id, 'delete');
            
        // First delete the actual attachment files
        unlink($filename_sys);
            
        // Delete the entries in the attachments table
        $query = "DELETE FROM #__attachments WHERE id='$id' LIMIT 1";
        $db->setQuery($query);
        if (!$db->query()) {
            echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
            }

        // Get the Itemid
        $Itemid = JRequest::getVar( 'Itemid', false);
        if ( is_numeric($Itemid) )
            $Itemid = intval($Itemid);
        else
            $Itemid = 1;
            
        // How to redirect?
        $from = JRequest::getVar( 'from', false);           
        if ( $from ) {
            if ( $from == 'frontpage' ) {
                $redirect_to = JURI::base();
                }
            elseif ( $from == 'article' ) {
                $redirect_to = JRoute::_("index.php?option=com_content&view=article&id=$article_id", False);
                }
            else {
                $redirect_to = JURI::base();
                }
            }
        else {
            $redirect_to = JURI::Base();
            }

        $msg = JText::_('DELETED ATTACHMENT') . " '$filename'";

        $this->setRedirect( $redirect_to, $msg );
    }
}
?>
