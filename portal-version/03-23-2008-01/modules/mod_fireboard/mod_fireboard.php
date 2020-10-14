<?php
//
// Copyright (C) 2006 Rowan Seymour, edited for FireBoard by MetZ
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.


defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Load module parameters
$num_posts = $params->get( 'num_posts' );
$only_categories = $params->get( 'only_categories' );
$child_categories = $params->get( 'child_categories' );
$within_thread = $params->get( 'within_thread' );
$show_public = $params->get( 'show_public' );
$show_registered = $params->get( 'show_registered' );
$show_special = $params->get( 'show_special' );
$max_length = $params->get( 'max_length' );
$date_format = $params->get( 'date_format' );
$name_link = $params->get( 'name_link' );
$forum_header = $params->get( 'forum_header' );
$topic_text = $params->get( 'topic_text' );
$category_text = $params->get( 'category_text' );
$by_text = $params->get( 'by_text' );
$date_text = $params->get( 'date_text' );
$new_alt_text = $params->get( 'new_alt_text' );
$border_color = $params->get( 'border_color' );
$header_background = $params->get( 'header_background' );
$header_text = $params->get( 'header_text' );
$module_table_background = $params->get( 'module_table_background' );
$module_table_text = $params->get( 'module_table_text' );
$module_background = $params->get( 'module_background' );
$module_text = $params->get( 'module_text' );
$unread_text = '<img src="/modules/mod_fireboard/new.gif" title="'. $new_alt_text .'" alt="'. $new_alt_text .'">';
$item_format = '<tr><td style="text-align:center;background:'. $module_background .';color:'. $module_text .';">%R</td><td style="padding-left:5px;padding-top:2px;padding-bottom:2px;background:'. $module_background .';color:'. $module_text .';">%S</td><td style="padding-left:5px;padding-top:2px;padding-bottom:2px;background:'. $module_background .';color:'. $module_text .';">%N</td><td style="padding-left:5px;padding-top:2px;padding-bottom:2px;background:'. $module_background .';color:'. $module_text .';">%F</td><td style="padding-left:5px;padding-top:2px;padding-bottom:2px;background:'. $module_background .';color:'. $module_text .';">%D</<td></tr>';

// Ensure functions are only declared once, so that module can be used as multiple copies
if (!defined( '_FBLATEST_INCLUDED' )) {
	define( '_FBLATEST_INCLUDED', '1' );

	function fblatest_main( $num_posts, $only_categories, $child_categories, $within_thread, $show_public, $show_registered, $show_special, $max_length, $item_format, $tooltip_format, $date_format, $name_link, $unread_text, $header_background, $border_color, $header_text, $forum_header, $module_table_background, $topic_text, $by_text, $category_text, $date_text )
	{
		global $database;

		// Select the appropriate message board component
			$componentname = 'com_fireboard';
		
		// Get menu item ID of the forum
		$database->setQuery( "SELECT id FROM #__menu WHERE link LIKE '%".$componentname."%'" );
		$rows = $database->loadObjectList();
		$forumitemid = $rows[0]->id;
	
 		// Load posts from database
		$posts = fblatest_loadposts( $num_posts, $only_categories, $child_categories, $within_thread, $show_public, $show_registered, $show_special );
		if ($posts == null) {
			echo "None";
			return;
		}
		
		// Generate formatted items
		$items = array();
		foreach ($posts as $post)
			$items[] = fblatest_makeitem( $post, $componentname, $forumitemid, $max_length, $item_format, $tooltip_format, $date_format, $name_link, $unread_text, $header_background, $border_color, $header_text, $forum_header, $module_table_background, $topic_text, $by_text, $category_text, $date_text );
		
		$content .= '<table width="100%" style="background:'. $header_background . ';border-top:1px solid '. $border_color .';border-left:1px solid '. $border_color .';border-right:1px solid '. $border_color .';"><tr><td style="padding:2px;color:'. $header_text .';background:'. $header_background .';font-weight:bold;">'. $forum_header . '</td></tr></table>';
		$content .= '<table width="100%" style="border-bottom:1px solid '. $border_color .';border-left:1px solid '. $border_color .';border-right:1px solid '. $border_color .';margin-bottom:5px;margin-top:0px;"><tr>';
		$content .= '<td width="5%" style="background: '. $module_table_background .';padding:2px;"></td><td  style="background:'. $module_table_background .';padding-left:5px;padding-top:2px;padding-bottom:2px;" width="38%"><b>'. $topic_text .'</b></td>';
		$content .= '<td style="background:'. $module_table_background .';padding-left:5px;padding-top:2px;padding-bottom:2px;" width="15%"><b>'. $by_text .'</b></td>';
		$content .= '<td style="background:'. $module_table_background .';padding-left:5px;padding-top:2px;padding-bottom:2px;" width="19%"><b>'. $category_text .'</b></td>';
		$content .= '<td style="background:'. $module_table_background .';padding-left:5px;padding-top:2px;padding-bottom:2px;" width="17%"><b>'. $date_text .'</b></td>';
		$content .= '</tr>';

		// Generate item layout
				foreach ($items as $item)
					$content .= $item;
		echo $content;
	}
	// Loads the latest posts from the Fireboard database
	//
	function fblatest_loadposts( $num_posts, $only_categories, $child_categories, $within_thread, $show_public, $show_registered, $show_special )
	{
		global $database, $my;
		
		$fbcookie = $_COOKIE['fboard_settings'];		  
		$prevvisit = 0;
		$readtopics = null;
		
		// If a registered user is logged in, look for their last board session
	  if ($my->id != 0) {	  	
		  $database->setQuery( "SELECT * FROM #__fb_sessions WHERE userid = ".$my->id );
	    $sessions = $database->loadObjectList();
			if ($sessions && $sessions[0]->userid) {
				$prevvisit = $sessions[0]->lasttime;
				$readtopics = $sessions[0]->readtopics;                
			}
			else
				$prevvisit = time() - 1314000; // One year ago
				
			// If there is a valid value in the cookie, use it instead
			if ($fbcookie['prevvisit'])
				$prevvisit = $fbcookie['prevvisit'];		
		}
			
		//echo date("d-m-y H:i", $prevvisit)."<br/>";

		// Select latest posts / topics from database
		$sqlselect = "SELECT a.id, a.name, a.userid, a.subject, a.catid, a.time AS posttime, c.name AS catname";
		
		// Categorize as unread depending on last visit and list of read topics
		if ($readtopics && $prevvisit)
			$sqlselect .= ", (a.time > $prevvisit AND a.thread NOT IN ($readtopics)) AS unread";
		else if ($prevvisit)
			$sqlselect .= ", (a.time > $prevvisit) AS unread";
		else
			$sqlselect .= ", 0 AS unread";														

		if ($within_thread == 0) { // Show all posts from a thread
			$sqlfrom = "FROM  #__fb_messages AS a, #__fb_categories AS c";
			$sqlwhere = "WHERE a.catid = c.id AND c.published = 1 AND a.hold = 0 AND a.moved = 0";			
		}
		else if ($within_thread == 1) { // Show only first post from a thread
			$sqlfrom = "FROM #__fb_categories AS c, #__fb_messages AS a LEFT JOIN #__fb_messages AS b ON a.thread = b.thread AND a.time > b.time";
			$sqlwhere = "WHERE b.id IS NULL AND a.catid = c.id AND a.moved = 0";
		}
		else { // Show only last post from a thread
			$sqlfrom = "FROM #__fb_categories AS c, #__fb_messages AS a LEFT JOIN #__fb_messages AS b ON a.thread = b.thread AND a.time < b.time";
			$sqlwhere = "WHERE b.id IS NULL AND a.catid = c.id AND a.moved = 0";
		}
		
		$sqlorderby = " ORDER BY a.time DESC";				
		$sqllimit = " LIMIT $num_posts";
	
		// Only include posts with specific access levels
		if ($show_public == 0 && $show_registered == 0 && $show_special == 0) { 
			$sqlwhere .= ' AND c.pub_access == 999999';
		}
		else if ($show_public == 1 && $show_registered == 0 && $show_special == 0) {
			$sqlwhere .= ' AND c.pub_access = 0';
		}
		else if ($show_public == 0 && $show_registered == 1 && $show_special == 0) {
			$sqlwhere .= ' AND c.pub_access < 0';
		}
		else if ($show_public == 1 && $show_registered == 1 && $show_special == 0) {
			$sqlwhere .= ' AND c.pub_access <= 0';
		}
		else if ($show_public == 0 && $show_registered == 0 && $show_special == 1) {
			$sqlwhere .= ' AND c.pub_access > 0';
		}	
		else if ($show_public == 1 && $show_registered == 0 && $show_special == 1) {
			$sqlwhere .= ' AND c.pub_access >= 0';
		}
		else if ($show_public == 0 && $show_registered == 1 && $show_special == 1) {
			$sqlwhere .= ' AND c.pub_access != 0';
		}
		
		// Parse category inclusion list
		if ($only_categories) {
			$inc_cats = explode( ',', $only_categories );
			$inc_cats_checked = array();
			foreach ($inc_cats as $inc_cat) {
			  // Is a possible MySQL record ID
				if (ctype_digit( $inc_cat )) 
			    $inc_cats_checked[] = $inc_cat;
				// Special value -1 indicates the active category
				else if ($inc_cat == -1) { 
				  $active_cat = mosGetParam( $_GET, 'catid', 0 );
				  if (!$active_cat)
						// Using Forum jumping puts it in the post vars
						$active_cat = mosGetParam( $_POST, 'catid', 0 );
						 
				  if ($active_cat > 0)
						$inc_cats_checked[] = $active_cat;
				}
			}
			if (count( $inc_cats_checked ) > 0) {
				$only_categories = implode( ',', $inc_cats_checked );
		
				// Limit returned posts to specified categories
				if (!$child_categories)
					$sqlwhere .= ' AND c.id IN ('.$only_categories.')';
				else
					$sqlwhere .= ' AND (c.id IN ('.$only_categories.') OR c.parent IN ('.$only_categories.'))';
			}
		}
	
		$database->setQuery( "$sqlselect $sqlfrom $sqlwhere $sqlorderby $sqllimit" );
		return $database->loadObjectList();
	}
	
	/**
	 * Creates a formatted HTML item in the post list
	 * @param post The post being displayed
	 */
	function fblatest_makeitem( $post, $com_name, $menuitem_id, $max_length, $item_format, $tooltip_format, $date_format, $name_link, $unread_text )
	{	  
		$subject = stripslashes( $post->subject );  
		if (strlen( $subject ) == 0)
			$subject = 'No subject';
		
		if (strlen( $subject ) > $max_length)
			$short_subject = substr( $subject, 0, $max_length - 4 ).'...';
		else
			$short_subject = $subject;		
		$postname = ($name_link > 0) ? fblatest_makenamelink( $post->userid, $post->name ) : $post->name;
		$postdate = date( $date_format, $post->posttime );
		
		$item_format = str_replace( "%S", fblatest_makesubjectlink( $post, $short_subject, $com_name, $menuitem_id ), $item_format );
		$item_format = str_replace( "%L", fblatest_makesubjectlink( $post, $subject, $com_name, $menuitem_id ), $item_format );			
		$item_format = str_replace( "%N", $postname, $item_format );
		$item_format = str_replace( "%D", $postdate, $item_format );
		$item_format = str_replace( "%F", $post->catname, $item_format );
		$item_format = str_replace( "%R", ($post->unread) ? $unread_text : '<img style="margin-bottom:3px;" src="/modules/mod_fireboard/no_new.gif">', $item_format );
				
		$tooltip_format = str_replace( "%S", $short_subject, $tooltip_format );	
		$tooltip_format = str_replace( "%L", $subject, $tooltip_format );			
		$tooltip_format = str_replace( "%N", $postname, $tooltip_format );
		$tooltip_format = str_replace( "%D", $postdate, $tooltip_format );
		$tooltip_format = str_replace( "%F", $post->catname, $tooltip_format );
		$tooltip_format = str_replace( "%R", $unread_text, $tooltip_format );
		$tooltip_format = str_replace( "%R", ($post->unread) ? $unread_text : '', $tooltip_format );
								
		
		return $item_format;
	}
	
	/**
	 * Creates a link to a specific post on the board
	 */
	function fblatest_makesubjectlink( $post, $text, $componentname, $menuitemid )
	{
		$url = 'index.php?option='.$componentname.'&amp;Itemid='.$menuitemid.'&amp;func=view&amp;catid='.$post->catid.'&amp;id='.$post->id;
		if (function_exists( 'sefRelToAbs' ))
		  $url = sefRelToAbs( $url );
		
		// Anchor part of url isn't included until after SEF conversion
		return '<a href="'.$url.'#'.$post->id.'">'.$text.'</a>';
	}
	
	/**
	 * Creates a link to a specific CB user profile
	 */	
	function fblatest_makenamelink( $userid, $name )
	{
		if ($userid > 0) {
		  $url = "index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$userid;
		  if (function_exists( 'sefRelToAbs' ))
		  	$url = sefRelToAbs( $url );
			return "<a href=\"$url\">$name</a>";
		}
		return $name;}
}
// Run module main method
fblatest_main( $num_posts, $only_categories, $child_categories, $within_thread, $show_public, $show_registered, $show_special, $max_length, $item_format, $tooltip_format, $date_format, $name_link, $unread_text, $header_background, $border_color, $header_text, $forum_header, $module_table_background, $topic_text, $by_text, $category_text, $date_text );
echo "</table>";
?>