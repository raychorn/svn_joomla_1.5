<?php
// Include ezSQL core ==========================================
include_once "../configuration.php";
include_once "shared/ez_sql_core.php";
// Include ezSQL database specific component
include_once "ez_sql_mysql.php";

//db settings ==================================================
$db_user = $mosConfig_user;
$db_password = $mosConfig_password;
$db_name = $mosConfig_db;
$db_host = $mosConfig_host;
// Initialise database object and establish a connection
// at the same time - db_user / db_password / db_name / db_host
$db = new ezSQL_mysql($db_user,$db_password,$db_name,$db_host);
//	---------------------------------------------

//---------------------------------------------------------
$title = $_GET['_title'] ;
$titlealias = $_GET['_titlealias'] ;
$intro = $_GET['_intro'] ;
$type = $_GET['_ftype'] ;
$vid = $_GET['_vid'] ;
$img = $_GET['_img'] ;
$a_id = $_GET['_id'] ;
$a_channel = $_GET['_catid'] ;
$a_section = $_GET['_section'] ;
$a_userid = $_GET['_userid'] ;
$a_username = $_GET['_username'];
$a_published = $_GET['_auto'];
//*************************************************************************************
//If you are nto using the default db prefix "jos_" for you joomla tables 
//change line "jos_clipboxtv" to your dbprefix E.G  my_clipbox
//$user = $db->get_row("SELECT * FROM jos_categories WHERE title = $a_channel");
$c_channel = $a_channel ;
//$db->debug();

/*$article = "<div class=\"cm_clip\"><div class=\"cm_thumbnail\">{mgmediabot}http://legalnewstv.com/custompages/movies/$vid|true(<img src=\"custompages/images/$img\" style=\"width:100px; height:100px;\" align=\"left\" title=\"PlayMovie\"><div class=\"cm_title\">$title</div>)|300|300{/mgmediabot}</div><div id=\"cm_description_119570\" class=\"cm_description\">$intro</div></div>" ; */
$article = "<div class=\"cm_clip\">{mgmediabot}$mosConfig_live_site/media/clips/$vid|true(<img src=\"images/stories/$img\" class=\"cm_thumbnail\" align=\"left\" title=\"$title\" alt=\"$title\"><div class=\"cm_title\">$title</div>)|300|300{/mgmediabot}<div class=\"cm_description\">$intro</div></div>"; 

//-----------------------------------------------------------------
 //If you are nto using the default db prefix "jos_" for you joomla tables 
 //change line "jos_clipboxtv" to your dbprefix E.G  my_clipbox
$db->query("INSERT INTO `jos_content` (`id`, `title`, `title_alias`, `introtext`, `fulltext`, `state`, `sectionid`, `mask`, `catid`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `images`, `urls`, `attribs`, `version`, `parentid`, `ordering`, `metakey`, `metadesc`, `access`, `hits`) VALUES ('', '$title', '$titlealias', '$article', '', '$a_published', '$a_section', '0', '$c_channel', '0000-00-00 00:00:00', '$a_userid', '$a_username', '0000-00-00 00:00:00', '0', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0')");
$db->debug();
//------------------------------------------------------------------
//--------------------------------------------------------
/*
//------------------------------------
insert into jos_clipboxtv (id,flv_file,movie_summary,submitted_by,date_sub,views,size,published,type) values ( NULL,'$flv','$summary','$user','$date',NULL,'$size',NULL,'$type')

*/

 echo "success=SUCCESS" ;

?>

