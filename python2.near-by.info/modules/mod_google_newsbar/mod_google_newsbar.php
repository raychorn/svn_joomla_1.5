<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$key = $params->get('sitekey');
$newsHeading = $params->get('newsTitle');
$newsAlignment = $params->get('alignment');
$searchWords = $params->get('searchWords');
$words = explode(',',$searchWords);
$linkTarget = $params->get('linktarget');
echo "<!-- ++Begin News Bar Wizard Generated Code++ -->";
echo "<!--\r\n";
echo "// The Following div element will end up holding the actual newsbar.\r\n";
echo "// You can place this anywhere on your page.\r\n";
echo "-->\r\n";
echo "<div id='newsBar-bar'>\r\n";
echo "<span style='color:#676767;font-size:11px;margin:10px;padding:4px;'>Loading...</span>\r\n";
echo "</div>\r\n";
echo "<script src='http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-nbw&key=" . $key . "' type='text/javascript'></script>\r\n";
echo "<style type='text/css'>\r\n";
echo "@import url(\"http://www.google.com/uds/css/gsearch.css\");\r\n";
echo "</style>\r\n";
echo "  <!-- News Bar Code and Stylesheet -->\r\n";
echo "  <script type='text/javascript'>\r\n";
echo "    window._uds_nbw_donotrepair = true;\r\n";
echo "  </script>\r\n";
echo "  <script src='http://www.google.com/uds/solutions/newsbar/gsnewsbar.js?mode=new' type='text/javascript'></script>\r\n";
echo "  <style type='text/css'>\r\n";
echo "    @import url(\"http://www.google.com/uds/solutions/newsbar/gsnewsbar.css\");\r\n";
echo "  </style>\r\n";
echo "  <script type='text/javascript'>\r\n";
echo "    function LoadNewsBar() {\r\n";
echo "      var newsBar;\r\n";
echo "      var options = {\r\n";
echo "      largeResultSet : false,\r\n";
echo "      title : \"" . $newsHeading . "\",\r\n";
if($newsAlignment == 'horizontal'){
echo "		 horizontal: true,\r\n";
}else{
echo "		 horizontal: false,\r\n";
}
if($linkTarget == 'new'){
echo "		linkTarget : GSearch.LINK_TARGET_BLANK,\r\n";
}
echo "        autoExecuteList : {\r\n";
echo "          executeList : [";
$wordsSize = count($words);
$counter = 0;
foreach($words as $word){
	$word = trim($word);
	echo "\"" . $word . "\"";
	if($counter < ($wordsSize -1)){
		echo ", ";
	}
  $counter += 1;
}
echo "]\r\n";
echo "}\r\n";
echo "}\r\n";
echo "newsBar = new GSnewsBar(document.getElementById('newsBar-bar'), options);\r\n";
echo "}\r\n";
echo "    // arrange for this function to be called during body.onload\r\n";
echo "    // event processing\r\n";
echo "    GSearch.setOnLoadCallback(LoadNewsBar);\r\n";
echo "  </script>\r\n";
echo "<!-- ++End News Bar Wizard Generated Code++ -->  ";
echo "<div style='display:none;'><a href='http://www.informationmadness.com/cms' target='_blank'>Information Madness</a></div>";
?>