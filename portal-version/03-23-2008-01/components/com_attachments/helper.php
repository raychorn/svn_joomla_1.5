<?php
defined('_JEXEC') or die('Restricted access');

class AttachmentsHelper
{
    function truncate_filename($raw_filename, $maxlen)
    {
        $filename_info = pathinfo($raw_filename);
        $basename = $filename_info['basename'];
        $extension = $filename_info['extension'];

        // Construct the filename without extension (since pathinfo doesn't
        // support directly this for PHP pre 5.2.0)                                                      
        $filename = substr($basename, 0, strlen($basename) - strlen($extension) - 1);
        
        if ( strlen($extension) > 0 ) {
            $maxlen = max( $maxlen - (strlen($extension) + 2), 1);
            return substr($filename, 0, $maxlen) . '~.' . $extension;
            }
        else {
            return substr($filename, 0, $maxlen) . '~';
            }
    }

    
    function valid_article_id($article_id)
    {
        if ( is_numeric($article_id) ) {
            $article_id = intval($article_id);
            }
        else {
            $errmsg = JText::_('ERROR BAD ARTICLE ID');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        return $article_id;
    }

    
    function verify_permissions($user, $article_id, $msg='upload')
    {
        // The user must be logged in
        if ( $user->get('username') == "" ) {
            $errmsg = 'ERROR MUST BE LOGGED IN TO '.strtoupper($msg);
            $errmsg = JText::_($errmsg);
            "ERROR: Must be logged in to $msg an attachment!";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }

        // Make sure we have an article id
        if ( $article_id == null ) {
            $errmsg = JText::_('ERROR IN CALL');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
            
        // Make sure the article is valid and load its info
        $db =& JFactory::getDBO();
        $query = "SELECT * from #__content WHERE id='" . $article_id . "'";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ( count($rows) == 0 ) {
            $errmsg = JText::_('ERROR INVALID ARTICLE ID')." ($article_id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();     
            }
        $article = $rows[0];
        
        // Admin can always add attachments
        $user_type = $user->get('usertype', false);
        if ( ($user_type == 'Administrator') ||
             ($user_type == 'Super Administrator') ) {
            return true;
            }
        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');

        // Check who may add attachments
        $who_can_add = $params->get('who_can_add');
            
        // Verify that this user can upload and attach to this article
        if ( ($who_can_add == 'author') && ( $user->get('id') == $article->created_by ) ) {
            return true;
            }
        elseif ( $who_can_add == 'logged_in' ) {
            // Can't get here unless the user is logged in
            return true;
            }
        else {
            $errmsg = 'ERROR NO PERMISSION TO '.strtoupper($msg);
            $errmsg = JText::_($errmsg);
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
                
        return true;
    }

    
    function setup_upload_directory($upload_dir, $secure)
    {
        $subdir_ok = false;
    
        // Create the subdirectory (if necessary)
        jimport( 'joomla.filesystem.folder' );
        if ( JFolder::exists( $upload_dir ) ) {
            $subdir_ok = true;
            }
        else {
            if ( JFolder::create( $upload_dir )) {
                $subdir_ok = true;
                }
            }

        if ( !$subdir_ok ) 
            return false;
        
        // Add a simple index.html file to the upload directory to prevent browsing
        $index_ok = false;
        $index_fname = $upload_dir.DS.'index.html';
        $index_f = fopen($index_fname, 'w');
        if ( $index_f ) {
            fwrite($index_f, "<html><body><br><h2 align=\"center\">Access denied.</h2></body></html>");
            fclose($index_f);
            }   
        if ( file_exists($index_fname) ) {
            $index_ok = true;
            }
        if ( ! $index_ok ) {
            echo "<p>".JText::_('ERROR ADD INDEX HTML')." (".$upload_dir.")</p>\n";
            return false;
            }       
    
        // If this is secure, create the .htindex file, if necessary
        $hta_fname = $upload_dir.DS.'.htaccess';
        if ( $secure ) {
            $hta_ok = false;
            $hta_f = fopen($hta_fname, 'w');
            if ( $hta_f ) {
                fwrite($hta_f, "order deny,allow\ndeny from all\n");
                fclose($hta_f);
                }   
            if ( file_exists($hta_fname) ) {
                $hta_ok = true;
                }
            if ( ! $hta_ok ) {
                echo "<p>".JText::_('ERROR ADD HTACCESS')." (".$upload_dir.")</p>\n";
                return false;
                }
            }
        else {
            if ( file_exists( $hta_fname ) ) {
                // If the htaccess file exists, delete it so normal access can occur
                unlink( $hta_fname );
                }
            }

        return true;
    }


    function upload_file(&$row, $article_id)
    {
        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');
        
        // Get the auto-publish setting
        $auto_publish = $params->get('publish_default', false);

        // Make sure the attachments directory exists
        $upload_subdir = $params->get('attachments_subdir', 'attachments');
        if ( $upload_subdir == "" ) {
            $upload_subdir = 'attachments';
            }
        $upload_dir = JPATH_SITE.DS.$upload_subdir;
        $secure = $params->get('secure', false);
        if ( !AttachmentsHelper::setup_upload_directory( $upload_dir, $secure ) ) {
            $errmsg = JText::_('ERROR UNABLE TO SETUP UPLOAD DIR');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }

        $filename  = $_FILES['upload']['name'];
        $ftype = $_FILES['upload']['type'];

        // Make sure a file was successfully uploaded
        if ( ($_FILES['upload']['size'] == 0) && ($_FILES['upload']['tmp_name'] == "") ) {
            $errmsg = JText::_('ERROR UPLOADING FILE') . ' ' . $filename;
            if ( $filename == '' )
                $errmsg .= '(' . JText::_('YOU MUST SELECT A FILE TO UPLOAD') . ')';
            else {
                $errmsg .= '  (' . JText::_('ERROR MAY BE LARGER THAN LIMIT') . ' ';
                $errmsg .= get_cfg_var('upload_max_filesize') . ')';
                }
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
            
        // Make sure the file type is okay (respect restrictions imposed by media manager)
        jimport('joomla.filesystem.file');
        $cmparams = &JComponentHelper::getParams( 'com_media' );
        
        // First check to make sure the extension is allowed
        $allowable = explode( ',', $cmparams->get( 'upload_extensions' ));
        $ignored = explode(',', $cmparams->get( 'ignore_extensions' ));
        $format = strtolower(JFile::getExt($filename));
        if (!in_array($format, $allowable) && !in_array($format,$ignored)) {
            $errmsg = JText::_('ERROR UPLOADING FILE') . ' ' . $filename;
            $errmsg .= '  (' . JText::_('ERROR ILLEGAL FILE EXTENSION') . " $format)";
            $errmsg .= "  \\n" . JText::_('ERROR CHANGE IN MEDIA MANAGER');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }

        // Check to make sure the mime type is okay
        if ( $cmparams->get('restrict_uploads',true) ) {
            if ( $cmparams->get('check_mime', true) ) {
                $allowed_mime = explode(',', $cmparams->get('upload_mime'));
                $illegal_mime = explode(',', $cmparams->get('upload_mime_illegal'));
                if( strlen($ftype) && !in_array($ftype, $allowed_mime) && in_array($ftype, $illegal_mime)) {
                    $errmsg = JText::_('ERROR UPLOADING FILE') . ' ' . $filename;
                    $errmsg .= '  (' . JText::_('ERROR ILLEGAL FILE MIME TYPE') . " $ftype)";
                    $errmsg .= "  \\n" . JText::_('ERROR CHANGE IN MEDIA MANAGER');
                    echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
                    exit();
                    }
                }
            }

        // Define where the attachments go
        $upload_url = $params->get('attachments_subdir', 'attachments');
        $upload_dir = JPATH_SITE . DS . $upload_url;

        // Figure out the system filename
        $filename_sys = null;
        $url = null;
        $prepend = $params->get('prepend', 'nothing');
        switch ($prepend) {
            case 'article_id': 
                $prefix = sprintf("%03d_", $article_id);
                $filename_sys = $upload_dir . DS . $prefix . $filename;
                $url = $upload_url . "/" . $prefix . $filename;
                break;
                
            // NOTE: for attachment_id, save normally and make a second pass 
            //       to rename after we know the attachment ID
            default:
                $filename_sys = $upload_dir . DS . $filename;
                $url = $upload_url . "/" . $filename;           
            }
        
        // Make sure the system filename doesn't already exist
        if ( file_exists($filename_sys) && ($prepend != 'attachment_id') ) {
            $errmsg = JText::_('ERROR FILE ALREADY ON SERVER');
            $errmsg .= "   ($filename)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
        
        // Get the maximum allowed filename length (for the filename display)
        $max_filename_length =$params->get('max_filename_length', 0);
        if ( is_numeric($max_filename_length) ) 
            $max_filename_length = intval($max_filename_length);
        else
            $max_filename_length = 0;
            
        // Create a display filename, if needed (for long filenames)
        if ( ($max_filename_length > 0) and 
             ( strlen($row->display_filename) == 0 ) and
             ( strlen($filename) > $max_filename_length ) ) {
            $row->display_filename = AttachmentsHelper::truncate_filename($filename, $max_filename_length);
            }

        // Copy the info about the uploaded file into the new record
        $row->filename = $filename;
        $row->filename_sys = $filename_sys;
        $row->url = $url;
        $row->file_type = $ftype;
        $row->file_size = $_FILES['upload']['size'];
        $row->published = $auto_publish;
        
        // Add the icon file type
        require_once(JPATH_SITE.DS.'components'.DS.'com_attachments'.DS.'file_types.php');
        $row->icon_filename = AttachmentsFileTypes::icon_filename($filename, $ftype);

        // Save the updated attachment
        if (!$row->store()) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
            }
            
        // Get the upload id
        $db =& JFactory::getDBO();
        $attachment_id = $db->insertid();

        // If we're prepending attachment IDs, fix the system filename and URL and
        // update the attachment record (now that we know the attachment ID)
        if ( $prepend == 'attachment_id' ) {
            $prefix = sprintf("%03d_", $attachment_id);
            $filename_sys = $upload_dir . DS . $prefix . $filename;
            $url = $upload_url . "/" . $prefix . $filename;
            $row->id = $attachment_id;
            $row->filename_sys = $filename_sys;
            $row->url = $url;
            $row->store();
            }

        // Move the file
        $msg = "";
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $filename_sys)) {
            $size = intval( $row->file_size / 1024.0 );
            chmod($filename_sys, 0644);
            $msg = JText::_('UPLOADED ATTACHMENT') . ' ' . $filename . " (" . $size . " Kb)!";
            }
        else {
            $query ="DELETE FROM #__attachments WHERE id=$attachment_id";
            $db->setQuery($query);
            $result = $db->loadResult();
            $msg = JText::_('ERROR MOVING FILE') . " {$_FILES['upload']['tmp_name']} -> {$filename_sys})";
            }
        
        return $msg;
    }
    
    function download_attachment($id)
    {
        // Verify the user is logged in
        $user =& JFactory::getUser();
        if ( $user->get('username') == "" ) {
            $errmsg = JText::_('ERROR MUST BE LOGGED IN TO DOWNLOAD ATTACHMENT');
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();
            }
            
        // Get the article ID
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__attachments WHERE id='$id' LIMIT 1";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ( count($rows) != 1 ) {
            $errmsg = JText::_('ERROR INVALID ATTACHMENT ID') . " ($id)";
            echo "<script> alert('$errmsg'); window.history.go(-1); </script>\n";
            exit();     
            }
        $article_id = $rows[0]->article_id;

        // NOTE: When 'who_can_see' mode is generalized for secure mode,
        //       we will probably need to add further checking here.

        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');

        // Get the other info about the attachment
        $download_mode = $params->get('download_mode', 'attachment');
        $content_type = $rows[0]->file_type;
        $filename = $rows[0]->filename;
        $filename_sys = $rows[0]->filename_sys;
        $len = filesize($filename_sys);

        // Begin writing headers
        ob_clean(); // Clear any previously written headers in the output buffer
        header("Pragma: public");
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: pre-check=0, post-check=0, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
       
        // Use the desired Content-Type
        header("Content-Type: $content_type");

        // Force the download
        header("Content-Disposition: $download_mode; filename=$filename;");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$len);
        @readfile($filename_sys);
        exit;
    }
    
    function attachmentsTableHTML($article_id, $title, 
                                  $show_file_links, $delete_url)
    {
        global $mainframe;
    
        // Load the language files from the backend
        $lang = & JFactory::getLanguage();
        $lang->load('plg_frontend_attachments', JPATH_ADMINISTRATOR);
    
        // Set up to list the attachments for this artticle
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__attachments WHERE article_id='$article_id' AND published='1' ORDER BY filename";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ( count($rows) == 0 )
            return "";

        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');

        // Get the plugin options
        $style = $params->get('attachments_table_style', 'attachmentsList');
        $secure = $params->get('secure', false);
        $show_column_titles = $params->get('show_column_titles', false);
        $show_description = $params->get('show_description', 1);
        $show_file_size = $params->get('show_file_size', 1);
        $show_mod_date = $params->get('show_modification_date', 0);
        $file_link_open_mode = $params->get('file_link_open_mode', 'in_same_window');
        if ($show_mod_date) {
            $mod_date_format = $params->get('mod_date_format', 'M-j-Y g:ia');
            }
    
        // Construct the title first
        $rtitle_str = $params->get('attachments_titles', '');
        if ( !$title || (strlen($title) == 0) ) 
            $title = 'ATTACHMENTS TITLE';
        if ( $rtitle_str != '' ) {
            $rtitle_list = split("[\n|\r]", $rtitle_str);
            foreach ($rtitle_list as $rtitle) {
                $rchunks = split(' ', $rtitle, 2);
                if ( (count($rchunks) == 2) && is_numeric($rchunks[0])) {
                    if ( intval($rchunks[0]) == intval($article_id) ) {
                        $title = trim($rchunks[1]);
                        break;
                        }
                    }
                }
            }
        $title = JText::_($title);

        // Massage some of the attachments info
        if ( $mainframe->isAdmin() ) {
            $base_url = $mainframe->getSiteURL();
            }
        else {
            $base_url = JURI::Base();
            }
        $icon_url_base = $base_url . 'components/com_attachments/media/icons/';
            
        // Construct the starting HTML
        $html = "\n<div class=\"$style\">\n";
        $html .= "<table>\n";
        $html .= "<caption>$title</caption>";
        
        // Add the column titles, if requested
        if ( $show_column_titles ) {
            $html .= "<thead><tr class=\"at_titles_row\">";
            $html .= "<th class=\"at_filename\">" . JText::_('FILE') . "</th>";
            if ( $show_description )
                $html .= "<th class=\"at_description\">" . JText::_('DESCRIPTION') . "</th>";
            if ( $show_file_size )
                $html .= "<th class=\"at_file_size\">" . JText::_('FILE SIZE') . "</th>";
            if ( $show_mod_date )
                $html .= "<th class=\"at_mod_date\">" . JText::_('LAST MODIFIED') . "</th>";
             if ( $delete_url )
                $html .= "<th class=\"at_delete\">&nbsp;</th>";
           $html .= "</tr></thead>";
            }

        $html .= "<tbody>\n";

        // Construct the lines for the attachments
        foreach ($rows as $row) {
            $html .= '<tr>';
    
            // Construct some display items
            if ( strlen($row->icon_filename) > 0 )
                $icon_url = $icon_url_base . $row->icon_filename;
            else
                $icon_url = $icon_url_base . 'generic.gif';
            if ( $show_file_size)
                $file_size = intval( $row->file_size / 1024.0 );
            if ( $show_mod_date )
                $last_modified = date($mod_date_format, filemtime($row->filename_sys));
                      
            // Add the filename
            $target = '';
            if ( $file_link_open_mode == 'new_window')
                $target = ' target="_blank"';
            $html .= '<td class="at_filename">';
            if ( strlen($row->display_filename) == 0 )
                $filename = $row->filename;
            else
                $filename = $row->display_filename;
            if ( $show_file_links ) {
                if ( $secure ) {
                    $url = "index.php?option=com_attachments&task=download&id=" . $row->id;
                    $url = JRoute::_($url);        
                    }
                else {
                    $url = $base_url . $row->url;
                    }
                $tooltip = JText::_('DOWNLOAD THIS FILE') . ' (' . $row->filename . ')';
                $html .= "<a class=\"at_icon\" href=\"$url\"$target title=\"$tooltip\"><img src=\"$icon_url\" />&nbsp;</a>";
                $html .= "<a href=\"$url\"$target title=\"$tooltip\">$filename</a>";
                }
            else {
                $html .= '<img src="' . $icon_url . '" alt="" />&nbsp;';
                $html .= $filename;
                }
            $html .= '</td>';
            
            // Add description (maybe)
            if ( $show_description ) {
                $description = $row->description;
                if ( strlen($description) == 0)
                    $description = '&nbsp;';
                if ( $show_column_titles )
                    $html .= "<td class=\"at_description\">$description</td>";
                else
                    $html .= "<td class=\"at_description\">[$description]</td>";
                }
            
            // Add file size (maybe)
            if ( $show_file_size ) {
                $html .= "<td class=\"at_file_size\">$file_size Kb</td>";
                }
            
            // Add the modification date (maybe)
            if ( $show_mod_date ) {
                $html .= "<td class=\"at_mod_date\">$last_modified</td>";
                }
                
            // Add the link to delete the article, if requested
            if ( $delete_url ) {
                $tooltip = JText::_('DELETE THIS FILE') . ' (' . $row->filename . ')';
                $msg = JText::_('REALLY DELETE ATTACHMENT') . " ($row->filename)";
                $url = JRoute::_(sprintf($delete_url, $row->id, $article_id));
                $link = "<a href=\"$url\" title=\"$tooltip\" onClick=\"javascript:return confirm('$msg')\">X</a>";
                $html .= "<td class=\"at_delete\">$link</td>";
                }
                
            $html .= "</tr>\n";
            }

        // Close the HTML
        $html .= "</tbody></table></div>\n";
        
        return $html;
    }


    function switch_article($row, $old_article_id, $new_article_id)
    {
        // Switch the article as specified, renaming the file as necessary
        // Return success status

        // Get the component parameters
        jimport('joomla.application.component.helper');
        $params = JComponentHelper::getParams('com_attachments');

        // Figure out how filenames are currently constructed
        $prepend = $params->get('prepend', 'nothing');
        
        // Construct the new filename, if we are prepending the article ID
        if ( $prepend == 'article_id' ) {
            $id = $row->id;

            // Get the old filename
            JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_attachments'.DS.'tables');
            $atrow =& JTable::getInstance('attachments', 'Table');
            $atrow->load($id);
            $old_filename_sys = $atrow->filename_sys;

            // Construct the new filename
            $filename = $atrow->filename;
            $upload_url = $params->get('attachments_subdir', 'attachments');
            $upload_dir = JPATH_SITE . DS . $upload_url;
            $prefix = sprintf("%03d_", $new_article_id);
            $new_filename_sys = $upload_dir . DS . $prefix . $filename;
            $new_url = $upload_url . "/" . $prefix . $filename;

            // Rename the file
            if ( file_exists($new_filename_sys) ) {
                 return 'ERROR CANNOT SWITCH ARTICLE NEW FILENAME ALREADY EXISTS';
                 }
            if ( !rename($old_filename_sys, $new_filename_sys) ) {
                 return 'ERROR CANNOT SWITCH ARTICLE FILE RENAME FAILED';
                 }
                 
            // Save the changes to the attachment record immediatley
            $atrow->filename_sys = $new_filename_sys;
            $atrow->url = $new_url;
            if ( !$atrow->store() ) {
                   JError::raiseError(500, $row->getError() );
               }
               
            return '';
            }
        else {
            // If $prepend is 'nothing' or 'attachment_id' there is
            // no need to rename the file, so do nothing
            return '';
            }
    }
}
