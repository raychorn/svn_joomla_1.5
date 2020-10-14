<?php
/**
* @version		$Id: default.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title(   JText::_( 'VW_ROUTER_TITLE' ), 'smartsef_routes_settings' );
JToolBarHelper::custom( 'save','save','save','save' , false);
JToolBarHelper::custom( 'back','back','back','Back' , false);
JToolBarHelper::custom( 'rebuild', 'delete.png', 'archive_f2.png', 'rebuild', false );
JToolBarHelper::help( 'screen.smartsef' );

?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'VW_ROUTER_NUM' ); ?>
			</th>
			<th class="title">
				<?php echo JTEXT::_('VW_ROUTER_NAME') ?>
			</th>
			<th class="title">
				<?php echo JTEXT::_('VW_ROUTER_TYPE') ?>
			</th>
			<th class="title">
				<?php echo JTEXT::_('VW_ROUTER_ALIAS') ?>
			</th>
			<th>
				<?php echo JTEXT::_('VW_ROUTER_URLSETTING') ?>
			</th>
			<th>
				<?php echo JTEXT::_('VW_ROUTER_BYPASS_POST_REDIRECT') ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="6">
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	$count = count( $this->items );
	for ($i=0, $n=$count; $i < $n; $i++)
	{
		$row = &$this->items[$i];
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo  $i+1  ?>
			</td>
			<td>
				<?php echo $row->component ?>
			</td>
			<td>
				<?php
					if ( $row->router_type == 1 ) {
						echo JTEXT::_('VW_ROUTER_15_ROUTER');
					}
					if ( $row->router_type == 2 ) {
						echo JTEXT::_('VW_ROUTER_10_EXT');
					}
					if ( $row->router_type == 0 ) {
						echo JTEXT::_('VW_ROUTER_NOT_AVAILABLE');
					}
				?>
			</td>
			<td>
				<input type="text" name="component_alias[<?php echo $row->id ?>]" size="25" value="<?php echo $row->component_alias ?>" />
			</td>
			<td>
				<?php echo $row->router_select ?>
				<input type="hidden" name="id[<?php echo $row->id ?>]" value="<?php echo $row->id ?>">
			</td>
			<td>
				<?php echo $row->bypass_post_redirect ?>
			</td>
		</tr>
	<?php
	}
	?>
	</tbody>
	</table>
</div>
<input type="hidden" name="option" value="com_smartsef" />
<input type="hidden" name="control" value="routes_settings" />
<input type="hidden" name="task" value="view" />
</form>