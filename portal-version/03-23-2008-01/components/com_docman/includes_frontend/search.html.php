<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: search.html.php 561 2008-01-17 11:34:40Z mjaz $
 * @package DOCman_1.4
 * @copyright (C) 2003-2008 The DOCman Development Team
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.org/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

if (defined('_DOCMAN_HTML_SEARCH')) {
    return;
} else {
    define('_DOCMAN_HTML_SEARCH', 1);
}

class HTML_DMSearch
{
    function searchForm(&$lists, $search_phrase)
    {
        global $_DOCMAN;

        $action = _taskLink('search_result');

        ob_start();
        ?>
		<form action="<?php echo $action;?>" method="post" name="adminForm" id="dm_frmsearch" class="dm_form">
		<fieldset class="input">
			<p>
				<label for="catid"><?php echo _DML_SELECCAT;?></label><br />
				<?php echo $lists['catid'] ;?>
			</p>
			<p>
				<label for="search_phrase"><?php echo _DML_PROMPT_KEYWORD;?></label><br />
				<input type="text" class="inputbox" id="search_phrase" name="search_phrase"  value="<?php echo htmlspecialchars(stripslashes($search_phrase), ENT_QUOTES); ?>" />
			</p>
			<p>
				<label for="search_mode"><?php echo _DML_SEARCH_MODE;?></label><br />
				<?php echo $lists['invert_search'] . _DML_NOT ;?><?php echo '&nbsp;' . $lists['search_mode']?>
			</p>
			<p>
				<label for="ordering"><?php echo _DML_CMN_ORDERING;?></label><br />
				<?php echo $lists['ordering'] ;?><?php echo "&nbsp;" . _DML_SEARCH_REVRS . ":" . $lists['reverse_order'] ;?>
			</p>
			<p>
				<label for="search_where"><?php echo _DML_SEARCH_WHERE;?></label><br />
				<?php echo $lists['search_where'] ;?>
			</p>
		</fieldset>
		<fieldset class="dm_button">
			<p>
				<input type="submit" class="button" value="<?php echo _DML_SEARCH;?>" />
			</p>
		</fieldset>
		</form>
		<?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

