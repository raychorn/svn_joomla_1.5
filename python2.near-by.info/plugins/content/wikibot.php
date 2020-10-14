<?php

/**********************************************************************************
 * Messiah's WikiBot
 * @version 2.0
 * @copyright (c) 2006 The Inevitable One
 * @license GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 * @author http://www.theinevitabledossier.com/wikibot.html
 * 
 * Version History:
 *
 * 2.0    Joomla 1.5 Support only! No Joomla Language support yet (Fish)!
 * 1.5.2  Now, Dutch (du/nl) works in a Fish solution as Wikipedia
 *        does not follow the ISO standard.
 * 1.5.1  Fix due to Google PR related problem (Added rel="nofollow"
 *        to created hyper links)
 * 1.5    Added Link Color as general switch
 * 1.4.2  A small bugfix due to 1.3 support problems.
 * 1.4.1  A General Bot switch for open link in a new window or not,
 *        by Holger Mueller
 * 1.4    Added the feature to open a new window if nw: is specified.
 * 1.3.1  Now, Swedish (se/sv) works in a Fish solution as Wikipedia
 *        does not follow the ISO standard.
 * 1.3    Support for [[wiktionary:, [[wikiquote:, [[wikisource:
 *        [[wikinews:, [[wikibooks:
 * 1.2    Link name splitter "|" added.
 * 1.1 	  Joom!Fish Internationalization added by Nicolas Moyroud.
 * 1.0 	  by Messiah, for own purposes, using the JoomlaBoard
 *		discussbot as referense.
 *
 **********************************************************************************/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

$mainframe->registerEvent( 'onPrepareContent', 'botWikiBot' );

function botWikiBot( &$row, &$params, $page=0 ) {

	// simple performance check to determine whether bot should process further
	if ( JString::strpos( $row->text, '[[' ) === false ) {
		return true;
	}


	// Get Plugin info
	$plugin =& JPluginHelper::getPlugin('content', 'wikibot');

	// Get the plugin parameters
	$pluginParams = new JParameter( $plugin->params );
	$defaultLang = $pluginParams->get( 'defaultlang' );
	$target = ($pluginParams->get( 'target' ) == "new") ? "_blank" : NULL;;
	$color = $pluginParams->get( 'color' );
	$ownsite = $pluginParams->get( 'ownsite' );
	$ownsitename = $pluginParams->get( 'ownsitename' );
	$wikipath= $pluginParams->get( 'wikipath' );

/*****************************************************
*
* FISH LANGUAGE SUPPORT MISSING!!!
* 
*****************************************************/

	// Fish Language needs to be created
	$lang = $defaultLang;

/*****************************************************
*
* FISH LANGUAGE SUPPORT MISSING!!!
* 
*****************************************************/

	// (Fish) International support follows OSI, but Wikipedia don't...
	if ($lang == "se") { // se is Sweden according to ISO
		$lang = "sv";    // but not according to Wikipedia, then lets correct it!
	}
	if ($lang == "du") { // se is Dutch according to ISO
		$lang = "nl";    // but not according to Wikipedia, then lets correct it!
	}

	// Set the expression to be matched
	$regex = "#\[\[(.*?)\]\]#s";


	// Fetch rows and loop words for matched
	preg_match_all( $regex, $row->text, $matches );
	for($x=0; $x<count($matches[0]); $x++) {

	   // Raw/Word loop begins here!

	   $match=$matches[1][$x];
	   

	   // If $match contains "|" split in two
	   $first = split('[\|]', $match);
    	if (empty($first[1])) {
		$second = split('[:]', $match);
    		if ($second[0] == 'wiktionary' || $second[0] == 'wikiquote' || $second[0] == 'wikisource' || $second[0] == 'wikinews' || $second[0] == 'wikibooks') {
			$wikisite = $second[0];
			if (!$Gtarget) {
				$target = $second[0];
			}
    		} else {
			$wikisite = "wikipedia";
			if ($second[0] == 'nw') {
				$target = "_blank";
			} else {
				if (!$target) {
					$target = "wikipedia";
				}
			}
    		}

   	} else {
		$third = split('[:]', $first[0]);
    		if ($third[0] == 'wiktionary' || $third[0] == 'wikiquote' || $third[0] == 'wikisource' || $third[0] == 'wikinews' || $third[0] == 'wikibooks') {
			$wikisite = $third[0];
			if (!$target) {
				$target = $third[0];
			}
    		} else {
			$wikisite = "wikipedia";
			if ($third[0] == 'nw') {
				$target = "_blank";
			} else {
				if (!$target) {
					$target = "wikipedia";
				}
			}
    		}
		$fourth = split('[:]', $first[1]);
		if ($fourth[0] == 'nw') {
			$target = "_blank";
		}
    	}

    // Check if the link should be colored.
    if (empty($color)) {
        $linkstart = '';
        $linkend = '';
    } else {
        $linkstart = '<font color='.$color.'>';
        $linkend = '</font>';
    }

    // Own wiki site?
    if (empty($ownsite)) {
        $returnsite = 'http://'.$lang.'.'.$wikisite.'.org';
    } else {
        $returnsite = $ownsite;
        $wikisite= $ownsitename;
    }

    // Search or direct links?
    if ($wikipath == 'direct') {
        $rwikipath = '/';
    } else {
        $rwikipath = '/Special:Search/';
    }

    // Let's create the link
    if (empty($first[1])) {
	    	if (empty($second[1])) {
		$link='<a href="'.$returnsite.'/wiki'.$rwikipath.$first[0].'" title="'.$wikisite.': '.$first[0].'" rel="nofollow" target="'.$target.'">'.$linkstart.$first[0].$linkend.'</a>';
		} else {
		$link='<a href="'.$returnsite.'/wiki'.$rwikipath.$second[1].'" title="'.$wikisite.': '.$second[1].'" rel="nofollow" target="'.$target.'">'.$linkstart.$second[1].$linkend.'</a>';
		}
	} else {
		if (empty($third[1])) {
			if (empty($fourth[1])) {
			$link='<a href="'.$returnsite.'/wiki'.$rwikipath.$first[0].'" title="'.$wikisite.': '.$first[0].'" rel="nofollow" target="'.$target.'">'.$linkstart.$first[1].$linkend.'</a>';
			} else {
			$link='<a href="'.$returnsite.'/wiki'.$rwikipath.$first[0].'" title="'.$wikisite.': '.$fourth[1].'" rel="nofollow" target="'.$target.'">'.$linkstart.$fourth[1].$linkend.'</a>';
			}
		} else {
			if (empty($fourth[1])) {
			$link='<a href="'.$returnsite.'/wiki'.$rwikipath.$third[1].'" title="'.$wikisite.': '.$first[1].'" rel="nofollow" target="'.$target.'">'.$linkstart.$first[1].$linkend.'</a>';
			} else {
			$link='<a href="'.$returnsite.'/wiki'.$rwikipath.$third[1].'" title="'.$wikisite.': '.$fourth[1].'" rel="nofollow" target="'.$target.'">'.$linkstart.$fourth[1].$linkend.'</a>';
			}
		}
	}

    $replace = $link;

    // It's time to return the code...
    $row->text = str_replace($matches[0][$x], $replace, $row->text);
    }
}
?>
