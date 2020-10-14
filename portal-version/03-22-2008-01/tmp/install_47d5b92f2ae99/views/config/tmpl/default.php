<?php
/**
* @version		$Id: default.php 230 2008-02-20 19:17:37Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::save( 'savepurge','save & purge' );
JToolBarHelper::apply( 'applypurge','apply & purge' );
JToolBarHelper::save( 'save' );
JToolBarHelper::apply( 'apply' );
JToolBarHelper::cancel( 'cancel' );
JToolBarHelper::title(   JText::_( 'VW_CONFIG_TITLE' ), 'smartsef_config' );

?>
<form action="index.php" method="post" name="adminForm">
	<div id="config-document">
		<table class="noshow">
			<tr>
			<td width="50%">
			   	<fieldset class="adminform">
				<legend><?php echo JText::_( 'VW_CONFIG_GENERAL' ); ?></legend>
				<table class="admintable">
					<tbody>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_ENABLE' ); ?>::<?php echo JText::_('VW_CONFIG_ENABLE_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_ENABLE' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['mode']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_LOWERCASEURLS' ); ?>::<?php echo JText::_('VW_CONFIG_LOWERCASEURLS_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_LOWERCASEURLS' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['url_lowercase']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_SEFURLLOOKUP' ); ?>::<?php echo JText::_('VW_CONFIG_SEFURLLOOKUP_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_SEFURLLOOKUP' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['enable_sefurl_lookup']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_APPENDMENUITEMID' ); ?>::<?php echo JText::_('VW_CONFIG_APPENDMENUITEMID_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_APPENDMENUITEMID' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['append_itemid_to_sefurl']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_APPENDMENUITEMIDRAW' ); ?>::<?php echo JText::_('VW_CONFIG_APPENDMENUITEMIDRAW_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_APPENDMENUITEMIDRAW' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['append_itemid_to_rawurl']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_CHECKUNIQUE_URLS' ); ?>::<?php echo JText::_('VW_CONFIG_CHECKUNIQUE_URLS_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_CHECKUNIQUE_URLS' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['check_for_unique_article_urls']	; ?>
							</td>
						</tr>

						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_PAGENOTFOUNDID' ); ?>::<?php echo JTEXT::_('VW_CONFIG_PAGENOTFOUNDID_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_PAGENOTFOUNDID' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="page_not_found_id" id="page_not_found_id" class="inputbox" size="4" value="<?php echo $this->smartsef_config->page_not_found_id ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_LOG404' ); ?>::<?php echo JTEXT::_('VW_CONFIG_LOG404_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_LOG404' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['log_404_errors'] ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_LOGPATH' ); ?>::<?php echo JTEXT::_('VW_CONFIG_LOGPATH_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_LOGPATH' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="log_404_path" id="log_404_path" class="inputbox" size="60" value="<?php echo $this->smartsef_config->log_404_path ?>" />
							</td>
						</tr>


						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_ALLOWURLREPLACE' ); ?>::<?php echo JTEXT::_('VW_CONFIG_ALLOWURLREPLACE_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_ALLOWURLREPLACE' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['use_title_alias_fullpath'] ?>
							</td>
						</tr>

						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_UNIQUECHAR' ); ?>::<?php echo JTEXT::_('VW_CONFIG_UNIQUECHAR_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_UNIQUECHAR' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="unique_seperator" id="unique_seperator" class="inputbox" size="4" value="<?php echo $this->smartsef_config->unique_seperator ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_CHARTOREMOVE' ); ?>::<?php echo JTEXT::_('VW_CONFIG_CHARTOREMOVE_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_CHARTOREMOVE' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="url_remove_chars" id="url_remove_chars" class="inputbox" size="20" value="<?php echo utf8_decode($this->smartsef_config->url_remove_chars) ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_VALIDCHARS' ); ?>::<?php echo JTEXT::_('VW_CONFIG_VALIDCHARS_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_VALIDCHARS' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="valid_regular_expresion" id="valid_regular_expresion" class="inputbox" size="20" value="<?php echo $this->smartsef_config->valid_regular_expresion ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_SPACEREPLACMENT' ); ?>::<?php echo JTEXT::_('VW_CONFIG_SPACEREPLACMENT_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_SPACEREPLACMENT' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="character_space" id="character_space" class="inputbox" size="4" value="<?php echo $this->smartsef_config->character_space ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_JOOMLASPACECHAR' ); ?>::<?php echo JTEXT::_('VW_CONFIG_JOOMLASPACECHAR_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_JOOMLASPACECHAR' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['replace_joomla_space_char']	; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_CHAR_REPLACE' ); ?>::<?php echo JTEXT::_('VW_CONFIG_CHAR_REPLACE_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_CHAR_REPLACE' ); ?>
								</span>
							</td>
							<td>
								<textarea name="char_replacements" cols="60" rows="5"><?php echo utf8_decode($this->smartsef_config->char_replacements) ?></textarea>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_PARAMETERS_SUPPORT' ); ?>::<?php echo JTEXT::_('VW_CONFIG_PARAMETERS_SUPPORT_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_PARAMETERS_SUPPORT' ); ?>
								</span>
							</td>
							<td>
								<textarea name="additional_parameter_check" cols="60" rows="5"><?php echo $this->smartsef_config->additional_parameter_check ?></textarea>
							</td>
						</tr>

					</tbody>
				</table>
				</fieldset>
			</td>
			<td width="50%">
			   	<fieldset class="adminform">
				<legend><?php echo JText::_( 'VW_CONFIG_LEGENDURL' ); ?></legend>
				<table class="admintable">
					<tbody>

						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_URLSUFFIX' ); ?>::<?php echo JTEXT::_('VW_CONFIG_URLSUFFIX_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_URLSUFFIX' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="url_suffix_page" id="url_suffix_page" class="inputbox" size="10" value="<?php echo $this->smartsef_config->url_suffix_page ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_URLSUFFIXPDF' ); ?>::<?php echo JTEXT::_('VW_CONFIG_URLSUFFIXPDF_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_URLSUFFIXPDF' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="url_suffix_pdf" id="url_suffix_pdf" class="inputbox" size="10" value="<?php echo $this->smartsef_config->url_suffix_pdf ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_PRINTSUFFIX' ); ?>::<?php echo JTEXT::_('VW_CONFIG_PRINTSUFFIX_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_PRINTSUFFIX' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="url_part_print" id="url_part_print" class="inputbox" size="20" value="<?php echo $this->smartsef_config->url_part_print ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_PAGETEXT' ); ?>::<?php echo JTEXT::_('VW_CONFIG_PAGETEXT_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_PAGETEXT' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="url_part_page" id="url_part_page" class="inputbox" size="20" value="<?php echo $this->smartsef_config->url_part_page ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_SHOWALLTEXT' ); ?>::<?php echo JTEXT::_('VW_CONFIG_SHOWALLTEXT_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_SHOWALLTEXT' ); ?>
								</span>
							</td>
							<td>
								<input type="text" name="url_part_showall" id="url_part_showall" class="inputbox" size="20" value="<?php echo $this->smartsef_config->url_part_showall ?>" />
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_SECTIONPART' ); ?>::<?php echo JTEXT::_('A'); ?>">
									<?php echo JText::_( 'VW_CONFIG_SECTIONPART' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['section_url_part']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_CATEGORYURL' ); ?>::<?php echo JTEXT::_('VW_CONFIG__CATEGORYURL_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_CATEGORYURL' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['category_url_part']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_ARTICLEURL' ); ?>::<?php echo JTEXT::_('VW_CONFIG_ARTICLEURL_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_ARTICLEURL' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['article_url_part']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_URLSTRUCTSECTION' ); ?>::<?php echo JTEXT::_('VW_CONFIG_URLSTRUCTSECTION_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_URLSTRUCTSECTION' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['url_paths_section']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_URLSTRUCTCATEGORY' ); ?>::<?php echo JTEXT::_('VW_CONFIG_URLSTRUCTCATEGORY_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_URLSTRUCTCATEGORY' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['url_paths_category']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_URLSTRUCTARTICLE' ); ?>::<?php echo JTEXT::_('VW_CONFIG_URLSTRUCTARTICLE_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_URLSTRUCTARTICLE' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['url_paths_article']; ?>
							</td>
						</tr>
						<tr>
							<td width="185" class="key">
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'VW_CONFIG_USEMENU_ALIAS' ); ?>::<?php echo JTEXT::_('VW_CONFIG_USEMENU_ALIAS_HELP'); ?>">
									<?php echo JText::_( 'VW_CONFIG_USEMENU_ALIAS' ); ?>
								</span>
							</td>
							<td>
								<?php echo $this->lists['use_title_alias_for_menus']; ?>
							</td>
						</tr>

					</tbody>
				</table>

			</td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="control" value="config" />
	<input type="hidden" name="option" value="com_smartsef" />
	<input type="hidden" name="task" value="edit" />

</form>

