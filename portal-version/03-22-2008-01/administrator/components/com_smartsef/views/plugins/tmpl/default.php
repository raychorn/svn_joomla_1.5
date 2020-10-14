<?php
/**
* @version		$Id: default.php 201 2008-01-30 21:31:10Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

defined( '_JEXEC' ) or die( 'Restricted access' );


JToolBarHelper::title(   JText::_( 'VW_PLUGGIN_DEFAULT_TITLE' ), 'smartsef_plugin' );
JToolBarHelper::publishList('publish', '(un)Publish');
JToolBarHelper::deleteList(JTEXT::_('VW_PLUGGIN_DEFAULT_REMOVE'), 'delete');
JToolBarHelper::editListX();
JToolBarHelper::addNewX('install');
JToolBarHelper::custom( 'back','back','back','Back' , false);
JToolBarHelper::help( 'screen.smartsef' );

?>
<form action="index.php" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'VW_PLUGGIN_DEFAULT_FILTER' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'VW_PLUGGIN_DEFAULT_GO' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'VW_PLUGGIN_DEFAULT_RESET' ); ?></button>
	</td>
	<td nowrap="nowrap">
		<?php
			echo $this->lists['state'];
		?>
	</td>
</tr>
</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'VW_PLUGGIN_DEFAULT_NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th>
				<?php echo JTEXT::_('VW_PLUGGIN_DEFAULT_PLUGGIN'); ?>
			</th>
			<th class="title">
				<?php echo  JTEXT::_('VW_PLUGGIN_DEFAULT_NAME'); ?>
			</th>
			<th class="title">
				<?php echo JTEXT::_('VW_PLUGGIN_DEFAULT_DESCR'); ?>
			</th>
			<th class="title">
				<?php echo JTEXT::_('VW_PLUGGIN_DEFAULT_VERSION'); ?>
			</th>
			<th class="title">
				<?php echo JTEXT::_('VW_PLUGGIN_DEFAULT_AUTHOR'); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JTEXT::_( 'VW_PLUGGIN_DEFAULT_PUBLISHED' ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="8">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];

		$link 	= JRoute::_( 'index.php?option=com_smartsef&control=plugins&task=edit&cid[]='. $row->id );

		$checked 			= JHTML::_('grid.checkedout',   $row, $i );
		$published 			= JHTML::_('grid.published', $row, $i );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'VW_PLUGGIN_DEFAULT_EDIT' ); ?>">
				<?php echo $row->plugin ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'VW_PLUGGIN_DEFAULT_EDIT' ); ?>">
						<?php echo $row->name ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'VW_PLUGGIN_DEFAULT_EDIT' ); ?>">
						<?php echo $row->description?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'VW_PLUGGIN_DEFAULT_EDIT' ); ?>">
						<?php echo $row->version?></a>
			</td>
			<td>
				<?php echo $row->author ?>
			</td>
			<td align="center">
				<?php echo $published;?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
</div>

<input type="hidden" name="option" value="com_smartsef" />
<input type="hidden" name="control" value="plugins" />
<input type="hidden" name="task" value="view" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>