<?php
/**
* @version		$Id: plugin_edit.php 201 2008-01-30 21:31:10Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
		JToolBarHelper::title(   JText::_( 'VW_PLUGGIN_EDIT_TITLE') . $this->row->plugin , 'smartsef_plugin' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::help( 'screen.smartsef' );

		JRequest::setVar( 'hidemainmenu', 1 );

		// clean item data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'content' );

		// Check for component metadata.xml file
		//$path = JApplicationHelper::getPath( 'mod'.$client->id.'_xml', $row->module );
		//$params = new JParameter( $row->params, $path );
		$document =& JFactory::getDocument();

		JHTML::_('behavior.combobox');

		jimport('joomla.html.pane');
		$pane =& JPane::getInstance('sliders');

		JHTML::_('behavior.tooltip');
?>
		<form action="index.php" method="post" name="adminForm">
		<div class="col50">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'VW_PLUGGIN_EDIT_DETAILS' ); ?></legend>

				<table class="admintable" cellspacing="1">
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'VW_PLUGGIN_EDIT_NAME' ); ?>:
						</td>
						<td>
							<?php echo JText::_($this->row->name); ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'VW_PLUGGIN_EDIT_PUBLISHED' ); ?>:
						</td>
						<td>
							<?php echo $this->lists['published']; ?>
						</td>
					</tr>

					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'VW_PLUGGIN_EDIT_VERSIONS' ); ?>:
						</td>
						<td>
							<?php echo JText::_($this->row->version); ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'VW_PLUGGIN_EDIT_DESCR' ); ?>:
						</td>
						<td>
							<?php echo JText::_($this->row->description); ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'VW_PLUGGIN_EDIT_AUTHOR' ); ?>:
						</td>
						<td>
							<?php echo JText::_($this->row->author); ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'VW_PLUGGIN_EDIT_AUTHURL' ); ?>:
						</td>
						<td>
							<a href="<?php echo $this->row->author_url?>" target="_new">
							<?php echo JText::_($this->row->author_url); ?>
							</a>
						</td>
					</tr>
					</table>
				</fieldset>
		</div>
		<div class="col50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Parameters' ); ?></legend>

				<?php
					echo $pane->startPane("menu-pane");
					echo $pane->startPanel(JText :: _('Smartsef plugin Parameters'), "param-page");
					$p = $this->params;
					if($params = $p->render('params')) :
						echo $params;
					else :
						echo "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
					endif;
					echo $pane->endPanel();

					if ($p->getNumParams('advanced')) {
						echo $pane->startPanel(JText :: _('Advanced Parameters'), "advanced-page");
						if($params = $p->render('params', 'advanced')) :
							echo $params;
						else :
							echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('There are no advanced parameters for this item')."</div>";
						endif;
						echo $pane->endPanel();
					}

					echo $pane->endPane();
				?>
			</fieldset>
		</div>
		<div class="clr">
		</div>
		<input type="hidden" name="option" value="com_smartsef" />
		<input type="hidden" name="control" value="plugins" />
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="id" value="<?php echo $this->row->id ?>" />

		</form>