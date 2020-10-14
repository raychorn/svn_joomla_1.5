<?php

/**
* @version		$Id: cpannel.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* The Smartsef cpannel controller;
*/
 // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class cpannelSmartsef
{

	function cpannel ( ) {
		$document =& JFactory::getDocument();
		$document->addStyleSheet( '/administrator/components/com_smartsef/includes/smartsef.css');

		JToolBarHelper::title(   JText::_( 'SmartSEF Control Panel' ), 'smartsef_logo' );
	?>


   <table class="thisform">
   <tr class="thisform">
      <td width="50%" valign="top" class="thisform">

         <table width="100%" class="thisform2">
         	<tr class="thisform2">
         		<td align="center" height="100px" width="140" class="thisform2" onClick="window.location='index.php?option=com_smartsef&control=config&task=edit'">
                    <img src="components/com_smartsef/images/config.png" width="48px" height="48px" align="middle" border="0"/>
            		<br />
            		<?php echo JTEXT::_('VW_CPANNEL_CONFIGURATION') ?></a>
            	</td>
            	<td align="center" height="100px" width="140" class="thisform2" onClick="window.location='index.php?option=com_smartsef&control=url_repos&task=view'">
                   <img src="components/com_smartsef/images/url_repos.png" width="48px" height="48px" align="middle" border="0"/>
			       <br />
            		<?php echo JTEXT::_('VW_CPANNEL_REPOSITORY') ?></a>
            	</td>
            	<td>
            	</td>
             </tr>
            <tr>

         		<td align="center" height="100px" width="140" class="thisform2" onclick="javascript:if(confirm('<?php echo JTEXT::_('VW_PURG_CONFIRM', true ) ?>')){window.location='index.php?option=com_smartsef&control=purge&task=purge'};">
                    <img src="components/com_smartsef/images/empty.png" width="48px" height="48px" align="middle" border="0"/>
            		<br />
            		<?php echo JTEXT::_('VW_CPANNEL_PURGE') ?></a>
            	</td>
           		<td align="center" height="100px" width="140" class="thisform2" onClick="window.location='index.php?option=com_smartsef&control=plugins&task=view'">
                   <img src="components/com_smartsef/images/pluggins.png" width="48px" height="48px" align="middle" border="0"/>
			       <br />
            		<?php echo JTEXT::_('VW_CPANNEL_PLUGINS') ?></a>
            	</td>
	           	<td align="center" height="100px" width="140" class="thisform2" onClick="window.location='index.php?option=com_smartsef&control=routes_settings&task=view'">
                   <img src="components/com_smartsef/images/routers.png" width="48px" height="48px" align="middle" border="0"/>
			       <br />
            		<?php echo JTEXT::_('VW_CPANNEL_ROUTER') ?></a>
            	</td>

            </tr>
            </table>
     </td>

      <td valign="top" align="center">
      <table border="1" width="100%" class="thisform">
         <tr class="thisform">
            <th class="cpanel" colspan="2" align="center"><b>SmartSEF URL Rewriter</b><br/>A Joomlatwork.com component.</th>
         </tr>
         <tr class="thisform"><td bgcolor="#FFFFFF" valign="top">
      		<img src="components/com_smartsef/images/box_smartsef.jpg">
      </td>

      <td valign="top">
      <table><tr><td colspan="2">
				For support questions please go to our forum at <a href="http://www.smartsef.org/forum.html" target="_new">www.smartsef.org</a>.
      </td></tr>
        <tr class="thisform">

            <td valign="top" bgcolor="#FFFFFF">Version:</td>
            <td bgcolor="#FFFFFF">RC 1.0
			</td>
         </tr>
        <tr class="thisform">
            <td valign="top" bgcolor="#FFFFFF">Release date:</td>
            <td bgcolor="#FFFFFF">8 march 2008
			</td>
         </tr>
         <tr class="thisform">
            <td bgcolor="#FFFFFF">Copyright:</td>
            <td bgcolor="#FFFFFF">&copy; 2008 <a href="http://www.joomlatwork.com" target="new">JoomlAtWork</a></td>

         </tr>
         <tr class="thisform">
            <td bgcolor="#FFFFFF">License:</td>
            <td bgcolor="#FFFFFF"><a href="http://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GNU General Public License</a></td>
         </tr>
         <tr class="thisform">
            <td valign="top" bgcolor="#FFFFFF">Development:</td>
            <td bgcolor="#FFFFFF">JoomlAtWork Development team
			</td>

         </tr>

      </table>
      </td>
      </tr>
      </table>
      </td>
   </tr>
	<tr class="thisform">
      <th valign="top" class="thisform">
      	<b>Smartsef is build with PHP developmentstudio 3.0:</b><br/>
      	<a href="http://www.joomlatwork.com/products/components/php_development_studio_pro_v3.0.html" target="_new"><img src="components/com_smartsef/images/box_devstudio3.jpg" /></a>
      </th>
     </tr>
	</table>
   <?php
	}


}
