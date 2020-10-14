<?php
// Joomla Feedmap Generator
//
// Please upload the files sitefeedmapmap.php, visorFreemind.swf, index.php (the main file), flashobject.js into a directory of
// your Webspace with a Joomla installation and edit the config.php.
//
// This tool retreives all Newsfeeds and their categories (which are published) directly from Joomla database
// and creates a nice flash based mind maps. Note that users need macromedia flash player 7 or 8 to see the mind map.
//
// You may create menu link in Joomla to the index.php as the sitemap of your newsfeeds. Google is able to index it.
//
// Created by (C) Dipl-Ing. Mustafa Görmezer
// http://www.goermezer.de ( mail@goermezer.de )

// Please don`t edit anything from here! Your map may be get corrupted.
//
//-------------------------------------------------------------------

include('config.php');

#echo '<cloud COLOR="#ffcc00"/>';

// Possible Icons: bookmark, attach, ksmiletris, messagebox_warning, xmag, gohome, back, penguin
echo '<icon BUILTIN="attach"/>';

echo '<hook>';
echo '<text>All newsfeed entries (RSS feeds). You will leave this website. Good bye...</text>';
echo '</hook>';

$db = @mysql_connect($mosConfig_host,$mosConfig_user,$mosConfig_password)
      or die(mysql_error());
mysql_query('set character set '.$character_set .';');
@mysql_select_db($mosConfig_db,$db) or die(mysql_error());
$sql_categ = "SELECT title, id FROM ".$mosConfig_dbprefix."categories WHERE SECTION='com_newsfeeds' AND PUBLISHED='1' AND ACCESS='0' ORDER BY 'title'";
$result = @mysql_query($sql_categ);
$position='right';
while($row = mysql_fetch_assoc($result)) {
        $sql_feed="SELECT name, link FROM ".$mosConfig_dbprefix."newsfeeds WHERE catid='".$row['id']."' AND PUBLISHED='1' ORDER BY 'name'";
        $result2 = @mysql_query($sql_feed);
        $count = @mysql_num_rows($result2); 
        echo '<node '.$section_bgcolor.' STYLE="'.$section_style.'" '.$section_font_color.' TEXT="'.$row['title'].'('.$count.')'.'">';

        while($row2 = mysql_fetch_assoc($result2)) {
           	echo '<node '.$content_bgcolor.' '.$content_font_color.' STYLE="'.$content_style.'" TEXT="'.$row2['name'].'" LINK="'.$row2['link'].'"/>';
        }    
        echo '</node>';
}
mysql_free_result($result);
mysql_free_result($result2);
?>