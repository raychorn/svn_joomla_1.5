<?php
/**
* @version		$Id: default.php 220 2008-02-10 21:31:18Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

defined( '_JEXEC' ) or die( 'Restricted access' );


JToolBarHelper::title(   JText::_( 'VW_URL_REPOS_TITLE' ), 'smartsef_url_repos' );
JToolBarHelper::custom( 'lock', 'archive.png', 'archive_f2.png', 'Lock', true );
JToolBarHelper::publishList('publish', '(un)Publish');
JToolBarHelper::deleteList(JTEXT::_('VW_URL_REPOS_DELETE'), 'delete');
JToolBarHelper::editListX();
JToolBarHelper::addNewX();
JToolBarHelper::custom( 'back','back','back','Back' , false);
JToolBarHelper::help( 'screen.smartsef' );
?>
<form action="index.php" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'VW_URL_REPOS_FILTER' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'VW_URL_REPOS_GO' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'VW_URL_REPOS_RESET' ); ?></button>
	</td>
	<td nowrap="nowrap">
		<?php
			echo $this->lists['state'];
			echo $this->lists['deleted_list'];
			echo $this->lists['blocked_list'];
		?>
	</td>
</tr>
</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th class="title">
				<?php echo JHTML::_('grid.sort',  JTEXT::_('VW_URL_REPOS_SEF_URL'), 'url_sef', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JTEXT::_('VW_URL_REPOS_PRIMARY_LINK'); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  JTEXT::_('VW_URL_REPOS_PUBLISHED'), 'published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JTEXT::_('VW_URL_REPOS_LOCKED'); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JTEXT::_('VW_URL_REPOS_BLOCK'); ?>
			</th>
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'ID', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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

		$link 	= JRoute::_( 'index.php?option=com_smartsef&control=url_edit&task=edit&cid[]='. $row->id );

		$checked 			= JHTML::_('grid.checkedout',   $row, $i );
		$published 			= JHTML::_('grid.published', 	$row, $i );

		$img 	= $row->delete_locked ? 'tick.png' : 'publish_x.png';
		$task 	= $row->delete_locked ? 'unlock' : 'lock';
		$alt 	= $row->delete_locked ? JText::_( 'VW_URL_REPOS_LOCKED_DELETION' ) : JText::_( 'VW_URL_REPOS_MAYDELETED' );
		$action = $row->delete_locked ? JText::_( 'VW_URL_REPOS_ITEM_MAY' ) : JText::_( 'VW_URL_REPOS_MAY_NOT' );

		$img_block 		= $row->block_rewrite ? 'tick.png' : 'publish_x.png';
		$task_block 	= $row->block_rewrite ? 'unblock' : 'block';
		$alt_block 		= $row->block_rewrite ? JText::_( 'VW_URL_REPOS_BLOCKED_REWRITEB' ) : JText::_( 'VW_URL_REPOS_URL_MAY' );
		$action_block 	= $row->block_rewrite ? JText::_( 'VW_URL_REPOS_URL_WILL_NOT' ) : JText::_( 'VW_URL_REPOS_URL_WILL_BE' );

		if ($row->ordering == 0 ) {
			$task_active = '';
		} else {
			$task_active = 'activate';
		}
		if ( $row->ordering == 0 ) {
			$img_active = 'tick.png';
			$action_active =  JText::_( 'VW_URL_REPOS_URL_IS_ACTIVE' );
		} elseif ( $row->ordering == 100) {
			$img_active =  'publish_r.png';
			$action_active =  JText::_( 'VW_URL_REPOS_URL_MAKE_ACTIVE' );
		} else {
			$img_active = 'publish_g.png';
			$action_active =  JText::_( 'VW_URL_REPOS_URL_MAKE_ACTIVE' );
		}

		$delete_href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task .'\')" title="'. $action .'">
		<img src="images/'. $img .'" border="0" alt="'. $alt .'" />
		</a>';

		$block_href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task_block .'\')" title="'. $action_block .'">
		<img src="images/'. $img_block .'" border="0" alt="'. $alt_block .'" />
		</a>';

		if ( $row->ordering != 0 ) {
			$active_href = '
			<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task_active .'\')"  title="'. $action_active .'">
			<img src="images/'. $img_active .'" border="0" />
			</a>';
		} else {
			$active_href = '<img src="images/'. $img_active .'" border="0" alt="'. $action_active.'" />';
		}
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit URL record' ); ?>">
						<?php echo substr($row->url_orginal,0,137) ?><br/>
				<a href="../<?php echo $row->url_sef; ?>" title="<?php echo JText::_( 'View web page' ); ?>" target="_blank">
						<?php echo substr($row->url_sef,0,137) ?></a>
			</td>
			<td  align="center">
				<?php echo $active_href;?>
			</td>
			<td align="center">
				<?php echo $published;?>
			</td>
			<td align="center">
				<?php echo $delete_href;?>
			</td>
			<td align="center">
				<?php echo $block_href;?>
			</td>
			<td align="center">
				<?php echo $row->id; ?>
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
<input type="hidden" name="control" value="url_repos" />
<input type="hidden" name="task" value="view" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>