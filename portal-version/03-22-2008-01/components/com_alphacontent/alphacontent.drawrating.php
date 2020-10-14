<?php
/*
Page:           drawrating.php
Created:        Aug 2006
Last Mod:       Mar 18 2007
The function that draws the rating bar.
--------------------------------------------------------- 
ryan masuga, masugadesign.com
ryan@masugadesign.com 
Licensed under a Creative Commons Attribution 3.0 License.
http://creativecommons.org/licenses/by/3.0/
See readme.txt for full credit details.
--------------------------------------------------------- 
Modified by Bernard Gilly for AlphaContent on 30 Jan 2008
www.visualclinic.fr
contact@visualclinic.fr
Last revision : 22 Feb 2008 for AlphaContent version 3.0.3
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function rating_bar( $id, $units='', $component, $rating_unitwidth='', $static='' ) {
	global $database, $mosConfig_lang, $my;	
	
	$userid = $my->id;
	
	//set some variables
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!$units) {$units = 5;}
	if (!$static) {$static = FALSE;}
	if (!$rating_unitwidth) {$rating_unitwidth = 16;}
	
	// get votes, values, ips for the current rating bar
	$query = "SELECT total_votes, total_value, used_ips, component FROM #__alphacontent_rating WHERE id='".$id."' AND component='".$component."'";
	$database->setQuery( $query );	
	$numbers = $database->loadObjectList();
	
	if (!$numbers){
		$sql = "INSERT INTO #__alphacontent_rating (`id`,`total_votes`, `total_value`, `used_ips`, `component`, `cid`, `rid`) VALUES ('".$id."', '0', '0', '', '".$component."', '0', '0')";
		$database->setQuery( $sql );
		$database->query();
		// get votes, values, ips for the current rating bar
		$query = "SELECT total_votes, total_value, used_ips, component FROM #__alphacontent_rating WHERE id='".$id."' AND component='".$component."'";
		$database->setQuery( $query );	
		$numbers = $database->loadObjectList();
	}
	
	if ($numbers[0]->total_votes < 1) {
		$count = 0;
	} else {
		$count=$numbers[0]->total_votes; //how many votes total
	}
	$current_rating=$numbers[0]->total_value; //total number of rating added together and stored
	$tense=($count<=1) ? _AJAX_ALPHACONTENT_VOTE : _AJAX_ALPHACONTENT_VOTES; //plural form votes/vote
	
	// determine whether the user has voted, so we know how to draw the ul/li
	$user_registered = ( $userid > 0 )? " OR used_ips LIKE '%uid".$userid.";%'" : "" ;

	$query = "SELECT used_ips FROM #__alphacontent_rating WHERE ( used_ips LIKE '%".$ip."%'".$user_registered." ) AND id='".$id."' AND component='".$component."'";
	$database->setQuery( $query );	
	$voted = $database->loadResult();
	
	// now draw the rating bar
	$rating_width = @number_format($current_rating/$count,2)*$rating_unitwidth;
	$rating1 = @number_format($current_rating/$count,1);
	$rating2 = @number_format($current_rating/$count,2);
	
	if ($static == 'static') {
	
			$static_rater = array();
			$static_rater[] .= '<div class="ratingblock">';
			$static_rater[] .= '<div id="unit_long'.$id.'">';			
			$static_rater[] .= '<div class="ratingbar"><ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
			$static_rater[] .= '<li class="current-rating" style="width:'.$rating_width.'px;">Currently '.$rating2.'/'.$units.'</li>';
			$static_rater[] .= '<li class="current-rating" style="width:'.$rating_width.'px;"></li>';
			$static_rater[] .= '</ul></div>';
			$static_rater[] .= '<p class="static">'._AJAX_ALPHACONTENT_RATING.' <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.')</p>';
			$static_rater[] .= '</div>';
			$static_rater[] .= '</div>'."\n\n";
	
			return join("\n", $static_rater);
	
	} else {
	
		  $rater ='';
		  $rater.='<div class="ratingblock">';		  
		  $rater.='<div id="unit_long'.$id.'">';		  
		  $rater.='<div class="ratingbar">';
		  $rater.='  <ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
		  $rater.='     <li class="current-rating" style="width:'.$rating_width.'px;">Currently '.$rating2.'/'.$units.'</li>';
		  $rater.='     <li class="current-rating" style="width:'.$rating_width.'px;"></li>';
	
		  for ($ncount = 1; $ncount <= $units; $ncount++) { // loop from 1 to the number of units
			   if(!$voted) { // if the user hasn't yet voted, draw the voting stars
				  $rater.='<li><a href="components/com_alphacontent/alphacontent.db.php?j='.$ncount.'&amp;q='.$id.'&amp;t='.$ip.'&amp;c='.$units.'&amp;u='.$rating_unitwidth.'&amp;p='.$component.'&amp;lang='.$mosConfig_lang.'&amp;user='.$my->id.'" title="'.$ncount.' out of '.$units.'" class="r'.$ncount.'-unit rater" rel="nofollow">'.$ncount.'</a></li>';
			   }
		  }
		  $ncount=0; // resets the count
	
		  $rater.='  </ul>';
		  $rater.=' </div>'; 

		  $rater.='  <p';
		  if($voted){ $rater.=' class="voted"'; }		  
		  $rater.='>'._AJAX_ALPHACONTENT_RATING.' <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.')';		  
		  $rater.='  </p>';
		  $rater.='</div>';
		  $rater.='</div>';
		  return $rater;
	 }
}
?>