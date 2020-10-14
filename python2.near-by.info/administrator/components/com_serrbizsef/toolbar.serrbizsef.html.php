<?php
/**
* @version $Id: toolbar.serrbizsef.html.php 2007-10-19 11:19:30 $
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

 class TOOLBAR_sb
 {
    /**
     * @desc Function defaultButtons - creates default tool bnar for SerrBizSEF.
     * @access public
     */
    function defaultButtons() 
    {
        // Open the table that contains the buttons
        mosMenuBar::startTable();
        TOOLBAR_sb::getIcon('edit','edit.png','edit.png','Edit',false);
        mosMenuBar::spacer();        
        
        TOOLBAR_sb::getIcon('remove','delete.png','delete.png','Delete');
        mosMenuBar::spacer();

        TOOLBAR_sb::getIcon('sef_list','sef.png','sef.png','SEF URLs',false);                                             
        mosMenuBar::spacer();                      

        TOOLBAR_sb::getIcon('manage_special_sef','nav-icon-redirect.gif','nav-icon-redirect.gif','Redirect',false);
        mosMenuBar::spacer(); 

        TOOLBAR_sb::getIcon('config','config.gif','config.gif','Configure',false);
        mosMenuBar::spacer(); 

        TOOLBAR_sb::getIcon('imported_sef_list','opensef.gif','opensef.gif','OpenSEFs',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('support','support.png','support.png','Help',false);
        mosMenuBar::spacer();

        // Close the table
        mosMenuBar::endTable();
    }
	
    /**
     * @desc Function manageSpecialSEFs - creates toolbar for redirect URLs .
     * @access public
     */
	function manageSpecialSEFs()
	{
	
        mosMenuBar::startTable();
        TOOLBAR_sb::getIcon('edit','edit.png','edit.png','Edit',false);
        mosMenuBar::spacer();        
        
        TOOLBAR_sb::getIcon('remove_special','delete.png','delete.png','Delete');
        mosMenuBar::spacer();

        TOOLBAR_sb::getIcon('save_special_sef','save.png','save.png','Save',false);   
        mosMenuBar::spacer();         

        TOOLBAR_sb::getIcon('sef_list','sef.png','sef.png','SEF URLs',false);                                             
        mosMenuBar::spacer();                      

        TOOLBAR_sb::getIcon('manage_special_sef','nav-icon-redirect.gif','nav-icon-redirect.gif','Redirect',false);
        mosMenuBar::spacer(); 

        TOOLBAR_sb::getIcon('config','config.gif','config.gif','Configure',false);
        mosMenuBar::spacer(); 
		
        TOOLBAR_sb::getIcon('imported_sef_list','opensef.gif','opensef.gif','OpenSEFs',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('support','support.png','support.png','Help',false);
        mosMenuBar::spacer();
        
        // Close the table
        mosMenuBar::endTable();
	}
	
    /**
     * @desc Function editButtons - creates toolbar for edit SEF URLs .
     * @access public
     */
    function editButtons()
    {
        mosMenuBar::startTable(); 
       
        TOOLBAR_sb::getIcon('save','save.png','save.png','Save',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('apply','apply.png','apply.png','Apply',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('cancel','cancel.png','cancel.png','Cancel',false);
        mosMenuBar::spacer();

        TOOLBAR_sb::getIcon('sef_list','sef.png','sef.png','SEF URLs',false);                                             
        mosMenuBar::spacer(); 

        TOOLBAR_sb::getIcon('manage_special_sef','nav-icon-redirect.gif','nav-icon-redirect.gif','Redirect',false);
        mosMenuBar::spacer(); 

        TOOLBAR_sb::getIcon('config','config.gif','config.gif','Configure',false);   
        mosMenuBar::spacer();        

        TOOLBAR_sb::getIcon('imported_sef_list','opensef.gif','opensef.gif','OpenSEFs',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('support','support.png','support.png','Help',false);
        mosMenuBar::spacer();

        mosMenuBar::endTable();        
    }

    /**
     * @desc Function editConfigButtons - creates toolbar for SerrBizSEF configuration.
     * @access public
     */
    function editConfigButtons()
    {
        mosMenuBar::startTable();                
        
        TOOLBAR_sb::getIcon('save_config','save.png','save.png','Save',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('sef_list','sef.png','sef.png','SEF URLs',false);
        mosMenuBar::spacer();

        TOOLBAR_sb::getIcon('manage_special_sef','nav-icon-redirect.gif','nav-icon-redirect.gif','Redirect',false);
        mosMenuBar::spacer(); 
        
        TOOLBAR_sb::getIcon('config','config.gif','config.gif','Configure',false);   
        mosMenuBar::spacer();                 

        TOOLBAR_sb::getIcon('imported_sef_list','opensef.gif','opensef.gif','OpenSEFs',false);
        mosMenuBar::spacer(); 

        TOOLBAR_sb::getIcon('support','support.png','support.png','Help',false);
        mosMenuBar::spacer();        
        mosMenuBar::endTable();        
    }

    /**
     * @desc Function editLinkButtons - creates toolbar for editing link buttons.
     * @access public
     */
    function editLinkButtons()
    {
        mosMenuBar::startTable();     
        
        TOOLBAR_sb::getIcon('save_link','save.png','save.png','Save',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('apply_link','apply.png','apply.png','Apply',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('cancel','cancel.png','cancel.png','Cancel',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('sef_list','sef.png','sef.png','SEF URLs',false);                                             
        mosMenuBar::spacer();
                
        TOOLBAR_sb::getIcon('manage_special_sef','nav-icon-redirect.gif','nav-icon-redirect.gif','Redirect',false);
        mosMenuBar::spacer(); 
                
        TOOLBAR_sb::getIcon('config','config.gif','config.gif','Configure',false);   
        mosMenuBar::spacer();        

        TOOLBAR_sb::getIcon('imported_sef_list','opensef.gif','opensef.gif','OpenSEFs',false);
        mosMenuBar::spacer();         

        TOOLBAR_sb::getIcon('support','support.png','support.png','Help',false);
        mosMenuBar::spacer();
        mosMenuBar::endTable();        
    }
    
    /**
     * @desc Function editImportButtons - creates toolbar for importing SEF.
     * @access public
     */
    function editImportButtons()
    {
        mosMenuBar::startTable();           
        
        TOOLBAR_sb::getIcon('active_import','apply.png','apply.png','Active',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('inactive_import','cancel.png','cancel.png','Inactive',false);
        mosMenuBar::spacer(); 
        
        TOOLBAR_sb::getIcon('sef_list','sef.png','sef.png','SEF URLs',false);
        mosMenuBar::spacer();
        
        TOOLBAR_sb::getIcon('manage_special_sef','nav-icon-redirect.gif','nav-icon-redirect.gif','Redirect',false);
        mosMenuBar::spacer(); 
        
        TOOLBAR_sb::getIcon('config','config.gif','config.gif','Configure',false);   
        mosMenuBar::spacer();         

        TOOLBAR_sb::getIcon('imported_sef_list','opensef.gif','opensef.gif','OpenSEFs',false);
        mosMenuBar::spacer(); 
        
        TOOLBAR_sb::getIcon('support','support.png','support.png','Help',false);
        mosMenuBar::spacer();
        mosMenuBar::endTable();        
    }       

   
    /**
     * @desc Function getIcon - links and validation depending on the $task.
     * @access public
     */
    function getIcon($task='', $icon='', $iconOver='', $alt='', $listSelect=true)
    {
        global $mosConfig_live_site;
        $icon     = ( $iconOver ? $iconOver : $icon );
        $image     = mosAdminMenus::ImageCheckAdmin( $icon, '/administrator/components/com_serrbizsef/images/', NULL, NULL, $alt, $task, 1, 'middle', $alt );

        if ($listSelect) 
        {
            $href = "javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to $alt');}else{submitbutton('$task')}";
        }
        elseif($task=='edit')
        {
            $href = "javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item from the list to edit'); } else {submitbutton('edit', '');}";
        }
        elseif($task=='save_link')
        {
            $href = "javascript:if (document.adminForm.boxchecked.value>0){if(confirm('Save new internal link ?')){submitbutton('save_link', '');}}else{submitbutton('save_link', '');}";
        }
        elseif($task=='active_import' || $task=='inactive_import')
        {                          
            $href = "javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select one SEF from the list to set ".strtolower($alt)."');}else{submitbutton('$task')}";
        }
        elseif($task=='save_special_sef' )
        {                                                                                                                        

		?>
			<script language="javascript" type="text/javascript">
				/*
				function learnRegExp(urlChk)
				{
					 checkedVal = 0;
					 for (var i=0; i < document.adminForm.sef_type.length; i++)
					   {
					   if (document.adminForm.sef_type[i].checked)
						  {
						    checkedVal = document.adminForm.sef_type[i].value;
						  }
					   }
					   
					  if(checkedVal==2) 
					  {
						 if(!urlChk.match(/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(([0-9]{1,5})?\/.*)?$/))
						 {
							alert("please enter valid URL for \"{redirect To URL}\" ");
						 }
						 else
						 {
							submitbutton('<?php echo $task?>');						 
						 }
					  }
					  else
					  {
							submitbutton('<?php echo $task?>');						 
					  }
				}*/
			</script>		
<script language="javascript" >
        function chkDup()
        {
          liveSiteURL = '<?php echo $mosConfig_live_site; ?>';
          OldURl = document.adminForm.internal_url.value;
          newURl = document.adminForm.redirect_to_url.value;
          
        if(eval(document.adminForm.internal_url.value.length)==0 || eval(document.adminForm.redirect_to_url.value.length)==0 )
        {
            alert('Required fields cannot be left blank');
        }
        else
        {
          if(OldURl==newURl ||'/'+OldURl==newURl || OldURl=='/'+newURl || liveSiteURL+OldURl==newURl || liveSiteURL+OldURl=='/'+newURl || liveSiteURL+'/'+OldURl==newURl || liveSiteURL+'/'+OldURl=='/'+newURl || '/'+liveSiteURL+OldURl==newURl || '/'+liveSiteURL+'/'+OldURl==newURl || '/'+liveSiteURL+'/'+OldURl=='/'+newURl || liveSiteURL+newURl==OldURl || liveSiteURL+newURl=='/'+OldURl || liveSiteURL+'/'+newURl==OldURl || liveSiteURL+'/'+newURl=='/'+OldURl || '/'+liveSiteURL+newURl==OldURl || '/'+liveSiteURL+'/'+newURl==OldURl || '/'+liveSiteURL+'/'+newURl=='/'+OldURl)
          {
             alert('Old and new URl cannot be same');   
          }
          else
          {
             submitbutton('save_special_sef');      
          }
        } 
        }    
  </script>

		<?php
           $href = "javascript:chkDup();";
           //$href = "javascript:if(eval(document.adminForm.internal_url.value.length)==0 || eval(document.adminForm.redirect_to_url.value.length)==0) alert('Required fields cannot be left blank'); else{submitbutton('$task')}";
           //$href = "javascript:if(eval(document.adminForm.internal_url.value.length)==0 || eval(document.adminForm.redirect_to_url.value.length)==0) alert('Required fields cannot be left blank'); else{learnRegExp(document.adminForm.redirect_to_url.value)}";
           //$href = "javascript:submitbutton('save_special_sef');";
        }
        else
        {
            $href = "javascript:submitbutton('$task')";
        }
        if ($icon && $iconOver) {

        ?>

        <td>
            <?php
                if($task == 'add_url') {
            ?> 
                <a class="toolbar" href=" http://www.serr.biz/add-your-url.html" target="_blank">

                <?php echo $image; ?>

                <br /><?php echo $alt; ?></a>            
            <?php
                }
                 else if($task == 'ask_question') {
            ?>
                <a class="toolbar" href="http://www.serr.biz/ask-a-question-free-tips.html" target="_blank">

                <?php echo $image; ?>

                <br /><?php echo $alt; ?></a>            
            <?php
                }
                else if($task == 'support') {
            ?>
                <a class="toolbar" href="http://www.serr.biz/ask-a-question/joomla-seo-serrbizsef.html" target="_blank">

                <?php echo $image; ?>

                <br /><?php echo $alt; ?></a>            
            <?php } else { ?>
            <a class="toolbar" href="<?php echo $href;?>">

                <?php echo $image; ?>

                <br /><?php echo $alt; ?></a>   
            <?php } ?>
        </td>

        <?php

        } else {

        ?>

        <td>

            <a class="toolbar" href="<?php echo $href;?>">

                <br /><?php echo $alt; ?></a>

        </td>

        <?php

        }

    }
    
    //herte

} 

?>

