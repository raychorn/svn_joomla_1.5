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
echo '<icon BUILTIN="xmag"/>';

// The description icon from this module
echo '<hook>';
echo '<text>All content entries (articles, news, ...) of this site.</text>';
echo '</hook>';

$db = @mysql_connect($mosConfig_host,$mosConfig_user,$mosConfig_password) or die(mysql_error());
mysql_query('set character set '.$character_set .';');
@mysql_select_db($mosConfig_db,$db) or die(mysql_error());
error_reporting(0);
$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

$sql_section="SELECT title, id FROM ".$mosConfig_dbprefix."sections WHERE PUBLISHED='1' AND ACCESS='0' ORDER BY 'title' ASC";
$result = @mysql_query($sql_section);
while($row = mysql_fetch_assoc($result)) {
    $sql_categ="SELECT title, id FROM ".$mosConfig_dbprefix."categories WHERE section='".$row['id']."' AND PUBLISHED='1' AND ACCESS='0' ORDER BY 'title' ASC";
	  $result2 = @mysql_query($sql_categ);
		$count_section = @mysql_num_rows($result2);
		echo '<node '.$section_bgcolor.' '.$section_font_color.' STYLE="'.$section_style.'" LINK="'.$mosConfig_live_site.'/index.php?option=com_content&task=section&id='.$row['id'].'" TEXT="'.$row['title'].'('.$count_section.')">';
		
		while($row2 = mysql_fetch_assoc($result2)) {
		    $result3=@mysql_query("SELECT title, introtext, id, metadesc FROM ".$mosConfig_dbprefix."content WHERE sectionid='".$row['id']."' AND catid='".$row2['id']."' and state='1' AND ACCESS='0' ORDER BY hits DESC");
				$count_categs = @mysql_num_rows($result3);
				echo '<node '.$category_bgcolor.' STYLE="'.$category_style.'" '.$category_font_color.' LINK="'.$mosConfig_live_site.'/index.php?option=com_content&task=category&sectionid='.$row['id'].'&id='.$row2['id'].'" TEXT="'.$row2['title'].' ('.$count_categs.')">';
    
        while($row3 = mysql_fetch_assoc($result3)) {
            //echo utf8_encode('<node '.$content_bgcolor.' '.$content_font_color.' STYLE="'.$content_style.'" TEXT="'.$row3['title'].'" LINK="'.$mosConfig_live_site.'/index.php?option=com_content&task=view&id='.$row3['id'].'"/>');
			echo '<node '.$content_bgcolor.' '.$content_font_color.' STYLE="'.$content_style.'" TEXT="'.$row3['title'].'" LINK="'.$mosConfig_live_site.'/index.php?option=com_content&task=view&id='.$row3['id'].'">';
			#echo '<node '.$content_bgcolor.' '.$content_font_color.' STYLE="'.$content_style.'" TEXT="'.htmlspecialchars($row3['introtext']).'" LINK="'.$mosConfig_live_site.'/index.php?option=com_content&task=view&id='.$row3['id'].'">';
			#echo utf8_encode('</node>');
              echo '<hook>';
			    echo '<text>'.htmlspecialchars($row3['metadesc']).'</text>';
			  echo '</hook>';
			echo '</node>';
        }
		    echo "</node>"; # end categories
    }
    echo "</node>"; # end sections
}
mysql_free_result($result);
mysql_free_result($result2);
mysql_free_result($result3);
?>