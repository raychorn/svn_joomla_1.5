<?php
//Last update 3/11/2007 to Fix Title display problem for special Chars
//Update 2/13/2007 to Fix language display problems
//Updated 12/3/2006 to fix RSS item count 

require_once('simplepie/simplepie.inc.php'); 

if(!isset($_GET['rssURL'])){ 
   die("No RSS url given"); 
} 

$rssItems = new SimplePie();


// Strip slashes if magic quotes is enabled (which automatically escapes certain characters)
	if (get_magic_quotes_gpc())
	{
		$_GET['rssURL'] = stripslashes(htmlentities($_GET['rssURL'],ENT_QUOTES));
	}
	
	

$rssItems->feed_url($_GET['rssURL']); 
$rssItems->enable_caching(true);
$rssItems->cache_location("./cache");
$rssItems->init(); 

$rssItems->handle_content_type();

if(!file_exists("cache"))mkdir("cache",0775); 

$maxRssItems = $_GET['maxRssItems'];    // Maximum number of RSS news to show. 
// Change the title of the Feed here by using the variable set in the backend.
//if 	(isset($selfheader) { echo $selfheader."\n"; } else {		
echo $rssItems->get_feed_title()."\n";	
if (min($maxRssItems,$rssItems->get_item_quantity()) < 1) { 
$damin = $rssItems->get_item_quantity(); 
echo $damin . "\n";   // Number of news  
} else { 
echo min($maxRssItems,$rssItems->get_item_quantity())."\n";   // Number of news  
}


$max = $rssItems->get_item_quantity($maxRssItems);
	echo $max;
    for ($x = 0; $x < $max; $x++) {
        $item = $rssItems->get_item($x);
					echo "\n\n";
					$title = $item->get_title();
					$title = mb_convert_encoding($title,"HTML-ENTITIES","auto");
					echo preg_replace("/[\r\n]/"," ",$title)."##";   // Title
					echo date("Y-m-d H:i:s",$item->get_date('j M Y'))."##";   // Date 
					$description = addslashes($item->get_description());					
					$description = mb_convert_encoding($description,"HTML-ENTITIES","auto");
					if ($description) { echo preg_replace("/[\r\n]/"," ",htmlentities($description,ENT_QUOTES,"UTF-8"))."##"; }
					else { echo "NO FEED DESCRIPTION" . "##"; }   // Description 
					echo preg_replace("/[\r\n]/"," ",$item->get_permalink())."##";   // Link 
			}
?> 