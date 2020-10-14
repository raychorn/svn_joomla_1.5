<?php
/**
* Add Attachments Button plugin
* @package Attachments
* @Copyright (C) 2007, 2008 Jonathan M. Cameron, All Rights Reserved
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @link http://joomlacode.org/gf/project/attachments/frs/
* @author Jonathan M. Cameron
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');

/**
 * Editor Add Attachment buton
 *
 * @author Johan Janssens <johan.janssens@joomla.org>
 * @package Editors-xtd
 * @since 1.5
 */
class plgButtonAdd_attachment extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param       object $subject The object to observe
     * @param       array  $config  An array that holds the plugin configuration
     * @since 1.5
     */
    function plgAdd_attachment(& $subject, $config) 
    {
        parent::__construct($subject, $config);
    }

    /**
     * Add Attachment button
     *
     * @return a button
     */
    function onDisplay($name)
    {
        // Get the article ID
        $cid = JRequest::getVar( 'cid', array(0), '', 'array');
        $id = 0;
        if ( count($cid) > 0 ) {
            $id = intval($cid[0]);
            }
        if ( $id == 0) {
            $nid = JRequest::getVar( 'id', null);
            if ( !is_null($nid) ) {
                $id = intval($nid);
                }
            }
        
        $button = new JObject();
                
        if ( $id == 0 ) {
            $button->set('name',false);
            }
        else {
            
            // Load the language file from the backend
            $lang = & JFactory::getLanguage();
            $lang->load('plg_frontend_attachments', JPATH_ADMINISTRATOR);
            
            // Construct the warning for thedialog to warn user to save their changes first
            $warning = JText::_('SAVE YOUR EDITS BEFORE ADDING ATTACHMENTS');
                
            // Figure out where we are and construct the right link and set
            // up the style sheet (to get the visual for the button working)
            global $mainframe;
            $doc =& JFactory::getDocument();
            if ( $mainframe->isAdmin() ) {
                $button->set('options', "{handler: 'iframe', size: {x: 800, y: 530}}");
                $link = "index.php?option=com_attachments&task=add&article_id=$id&from=closeme";
                $doc->addStyleSheet( $mainframe->getSiteURL() . 'plugins/editors-xtd/add_attachment.css', 
                                     'text/css', null, array() );
                }
            else {
                $button->set('options', "{handler: 'iframe', size: {x: 700, y: 530}}");
                $link = "index.php?option=com_attachments&task=upload&artid=$id&from=closeme";
                $doc->addStyleSheet( JURI::Base() . 'plugins/editors-xtd/add_attachment.css', 
                                     'text/css', null, array() );
                $doc->addScript('media/system/js/mootools.js');
                $doc->addScript('media/system/js/modal.js');
                $doc->addStyleSheet('media/system/css/modal.css');
                $doc->addScript('includes/js/joomla.javascript.js');
                }

            $button->set('modal', true);
            $button->set('class', 'modal');
            $button->set('text', JText::_('ADD ATTACHMENT'));
            $button->set('name', 'add_attachment');
            $button->set('link', $link);
            $button->set('image', 'add_attachment.png');
            }

        return $button;
    }
}
?>
