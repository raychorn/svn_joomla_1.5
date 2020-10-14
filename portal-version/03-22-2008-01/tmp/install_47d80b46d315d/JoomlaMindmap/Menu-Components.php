<?php
// Joomla Mindmap Generator
//
// Please upload the files sitemap.php, visorFreemind.swf, index.php (the main file), flashobject.js into a directory of
// your Webspace with a Joomla installation and edit the config.php.
//
// This tool retreives sections, categories and content items which are published directly from Joomla database
// and creates a nice flash based Mindmap. Note that users need macromedia flash player 7 or 8 to see the mind map.
//
// You may create menu link in Joomla to the index.php as the sitemap of your website. Google is able to index it.
//
// Created by (C) Dipl-Ing. Mustafa Görmezer
// http://www.goermezer.de ( mail@goermezer.de )

// Please don`t edit anything from here! Your map may be get corrupted.
//
//-------------------------------------------------------------------

include('config.php');

/*
<icon BUILTIN="button_cancel"/>
<icon BUILTIN="stop"/>
<icon BUILTIN="button_ok"/>
<icon BUILTIN="help"/>
<icon BUILTIN="messagebox_warning"/>
<icon BUILTIN="back"/>
<icon BUILTIN="forward"/>
<icon BUILTIN="attach"/>
<icon BUILTIN="ksmiletris"/>
<icon BUILTIN="clanbomber"/>
<icon BUILTIN="desktop_new"/>
<icon BUILTIN="flag"/>
<icon BUILTIN="gohome"/>
<icon BUILTIN="kaddressbook"/>
<icon BUILTIN="knotify"/>
<icon BUILTIN="korn"/>
<icon BUILTIN="Mail"/>
<icon BUILTIN="password"/>
<icon BUILTIN="pencil"/>
<icon BUILTIN="stop"/>
<icon BUILTIN="wizard"/>
<icon BUILTIN="xmag"/>
<icon BUILTIN="bell"/>
<icon BUILTIN="bookmark"/>
<icon BUILTIN="penguin"/>
<icon BUILTIN="licq"/>
<icon BUILTIN="idea"/>
*/
echo '<icon BUILTIN="licq"/>';

// The description icon from this module
echo '<hook>';
echo '<text>All Joomla components, which are placed as menu items in the mainmenu.</text>';
echo '</hook>';

$db = @mysql_connect($mosConfig_host,$mosConfig_user,$mosConfig_password)
      or die(mysql_error());
      mysql_query('set character set '.$character_set .';');
      @mysql_select_db($mosConfig_db,$db) or die(mysql_error());

      error_reporting(0);
      $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

//Added to include publicly accessible published components (by kevin@saskma.com)
$result = @mysql_query("SELECT DISTINCT (j.option), m.id FROM ".$mosConfig_dbprefix."components AS j, ".$mosConfig_dbprefix."menu AS m WHERE m.componentid = j.id AND m.published = 1 and m.access=0 and m.menutype = 'mainmenu' and m.type = 'components'");

while($row = mysql_fetch_assoc($result)) {
    echo '<node '.$section_bgcolor.' STYLE="'.$section_style.'" '.$section_font_color.' TEXT="'.ucfirst(trim($row['option'],'com_')).'" LINK="'.$mosConfig_live_site.'/index.php?option='.$row['option'].'&itemid='.$row['id'].'">';
    echo '</node>';
}
mysql_free_result($result);
?>

