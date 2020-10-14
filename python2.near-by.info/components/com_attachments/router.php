<?php
defined('_JEXEC') or die('Restricted access');

function AttachmentsBuildRoute(&$query)
{
	// Syntax to upload an attachment:
	//      index.php?option=com_attachments&task=upload&artid=44
	//         --> index.php/attachments/upload/article/44

	// Syntax to delete an attachment:
	//      index.php?option=com_attachments&task=delete&id=4&artid=44&from=article
	//          --> /attachments/delete/4/article/44
	//          --> /attachments/delete/4/article/44/from/article
	// Note: The 'from' clause indicates which view the item was called from (eg, article or frontpage)

	$segments = array();
	
	if ( isset($query['task']) ) {
		$segments[] = $query['task'];
		unset($query['task']);
		}
		
	if ( isset($query['id']) ) {
		$segments[] = $query['id'];
		unset($query['id']);
		}
		
	if ( isset($query['artid']) ) {
		$segments[] = 'article';
		$segments[] = $query['artid'];
		unset($query['artid']);
		}
	
	if ( isset($query['from']) ) {
		$segments[] = 'from';
		$segments[] = $query['from'];
		unset($query['from']);
		}
		
	return $segments;
}


function AttachmentsParseRoute($segments)
{
	$vars = array();
	$task = $segments[0];
	$vars['task'] = $task;

	// Handle the delete syntax
	if ( ($task == 'delete') || ($task == 'download')  ) {
		$vars['id'] = $segments[1];
		}
	
	// Handle the other clauses
	for ( $i=0; $i < count($segments); $i++ ) {
	
		// Look for article IDs
		if ( ($segments[$i] == 'article') && ($segments[$i-1] != 'from') ) {
			if ( $i+1 >= count($segments) ) {
				echo "<br>Error in AttachmentsParseRoute:  Found 'article' without a following article ID!<br>";
				exit;
				}
			$vars['artid'] = $segments[$i+1];
			}
			
		// Look for 'from' clause
		if ( $segments[$i] == 'from' ) {
			if ( $i+1 >= count($segments) ) {
				echo "<br>Error in AttachmentsParseRoute:  Found 'from' without any info!<br>";
				exit;
				}
			$vars['from'] = $segments[$i+1];
			}
	
		}

	return $vars;
}


?>
