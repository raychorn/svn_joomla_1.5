<?php
/**
* @version		$Id: default.php 202 2008-01-30 21:55:36Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
defined( '_JEXEC' ) or die( 'Restricted access' );


JToolBarHelper::title(   JText::_( 'VW_URL_EDIT_TITLE') . $this->row->url_sef, 'smartsef_url_repos' );
JToolBarHelper::save();
JToolBarHelper::cancel();
JToolBarHelper::help( 'screen.smartsef' );
?>
		<form action="index.php" method="post" name="adminForm">

		<div class="col100">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'VW_URL_EDIT_DETAILS' ); ?></legend>

				<table class="admintable">
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_SEFURL' ); ?>:
							</label>
						</td>
						<td width="80%">
							<input class="inputbox" type="text" name="url_sef" id="url_sef" size="100" value="<?php echo $this->row->url_sef;?>" />
						</td>
					</tr>
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_ORG' ); ?>:
							</label>
						</td>
						<td width="80%">
							<input class="inputbox" type="text" name="url_orginal" id="url_orginal" size="100" value="<?php echo $this->row->url_orginal;?>" />
						</td>
					</tr>
					<tr>
						<td width="20%" class="key" valign="top">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_PARAM' ); ?>:
							</label>
						</td>
						<td width="80%">
							<textarea name="vars" rows="6" cols="50" class="text_area"><?php echo $this->row->vars ?></textarea>
						</td>
					</tr>
					<tr>
						<td width="20%" class="key" valign="top">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_ORDER' ); ?>:
							</label>
						</td>
						<td width="80%">
							<input class="inputbox" size="3" type="text" name="ordering" id="ordering" size="100" value="<?php echo $this->row->ordering;?>" />
						</td>
					</tr>
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_LOCK' ); ?>:
							</label>
						</td>
						<td width="80%">
							<?php echo $this->lists['locked']; ?>
						</td>
					</tr>
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_PUBLISHED' ); ?>:
							</label>
						</td>
						<td width="80%">
							<?php echo $this->lists['state']; ?>
						</td>
					</tr>
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_VALID' ); ?>:
							</label>
						</td>
						<td width="80%">
							<?php echo $this->lists['valid']; ?>
						</td>
					</tr>
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_NOTES' ); ?>:
							</label>
						</td>
						<td width="80%">
							<textarea name="remarks" rows="2" cols="50" class="text_area"><?php echo $this->row->remarks ?></textarea>
						</td>
					</tr>
					<tr>
						<td width="20%" class="key" valign="top" >
							<label for="name">
								<?php echo JText::_( 'VW_URL_EDIT_CACHED'); ?>:
							</label>
						</td>
						<td>
							<?php if ( $this->row->cache == "") {
								echo JText::_('VW_URL_EDIT_NOCACHED');
							} else {
								?>
								<table>
								<?php
								$counter = 0;
								foreach (  $this->row->cache as $cache_url => $value ) {
									$counter++;
									$link_org = JRoute::_( 'index.php?option=com_smartsef&control=url_edit&task=edit&cid[]='. $value['id'] );
									$link_sef = JRoute::_( 'index.php?option=com_smartsef&control=url_edit&task=edit&cid[]='. $value['url_sef'] );
									?>
										<tr>
											<td style="background-color:#FFFFEF; vertical-align: top;"  >
												<?php echo $counter . '.' ?>
											</td>
											<td  style="background-color: #FFFFEF; vertical-align: top;">
												<a href="<?php echo $link_sef ?>"><?php echo $value['url_sef']?></a><br/>
												<a href="<?php echo $link_org ?>"><?php echo $cache_url ?></a>
											</td>
										</tr>
									<?php
								}
								?>
								</table>
								<?php
							}
							?>

						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<input type="hidden" name="option" value="com_smartsef" />
		<input type="hidden" name="control" value="url_edit" />
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="id" value="<?php echo $this->row->id ?>" />
		</form>
