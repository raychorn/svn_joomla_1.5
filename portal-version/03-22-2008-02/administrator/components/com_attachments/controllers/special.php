<?php
/**
* Attachments component
* @package Attachments
* @Copyright (C) 2007, 2008 Jonathan M. Cameron, All Rights Reserved
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @link http://joomlacode.org/gf/project/attachments/frs/
* @author Jonathan M. Cameron
**/


require_once( JPATH_COMPONENT.DS.'views'.DS.'special'.DS.'view.php' );

/**
 * The controller for special requests
 * (adapted from administrator/components/com_config/controllers/component.php) 
 */
class AttachmentsControllerSpecial extends JController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default = array())
	{
		$default['default_task'] = 'noop';
		parent::__construct( $default );
	}

    function noop()
    {
        echo "<h1>Special function not specified!</h1>";
        exit();
    }
    
    function editParams()
    {	
        // This function allows editing the Attachments parameters
        // with a form that has a regular submit button (not Javascript).
        //
        // This function is for automated testing of the Attachments 
        // extension and as exactly the same functionality as the regular
        // Attachments parameter editor in the component manager, except
        // that it is not a pop-up window.
        //
        // Due to the implementation of the component parameter editor for
        // pop up frames, this save form pops back into edit mode after saving.

        $model = $this->getModel('Special');
        if ( !$model ) {
            echo "Unable to find Special model! <br>";
            exit();
            }
            
		$table =& JTable::getInstance('component');
		if (!$table->loadByOption( 'com_attachments' ))
		{
			JError::raiseWarning( 500, 'Unable to load Attachments component' );
			return false;
		}
        
        $view = new AttachmentsViewSpecial( );
	    $view->assignRef('component', $table);
	    $view->setModel( $model, true );
	    $view->display();
    }
    

    function showSEF()
    {
       global $mainframe;
       echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
       echo "<html><head><title>SEF Status</title></head><body>";
       echo "SEF: " . $mainframe->getCfg('sef') . "<br>";
       echo "</body></html>";
       exit();
    }

    function listAttachmentIDs()
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id FROM #__attachments";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        echo "<html><head><title>Attachment IDs</title></head><body>";
        echo "Attachment IDS:";
        foreach ($rows as $row) {
            echo " " . $row->id;
            }
        echo "<br>";
        echo "</body></html>";
        exit();  
    }  
}