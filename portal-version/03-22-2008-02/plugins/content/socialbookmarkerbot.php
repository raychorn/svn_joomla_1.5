<?php
/**
*
* @package SocialBookmarkerBot
* @copyright (C)2007 Patrick Swesey
* @license GNU/GPL
* http://joomladigger.com
*
**/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

global $mosConfig_lang, $mosConfig_absolute_path;

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botSocialBookmarkers' );

function botSocialBookmarkers( $published, &$row, &$params, $page=0 )
{
	global $_MAMBOTS, $mosConfig_live_site, $database, $Itemid;

	if( $published && isset($row->title_alias) )
	{
		$query = "SELECT params"
			. "\n FROM #__mambots"
			. "\n WHERE element = 'socialbookmarkerbot'"
			. "\n AND folder = 'content'"
			;
		$database->setQuery( $query );
		$database->loadObject($mybot);

		$query = "SELECT id "
			. "\n FROM `#__menu` "
			. "\n WHERE `menutype`='mainmenu'"
			. "\n AND `published` =1"
			. "\n ORDER BY `ordering` ASC "
			. "\n LIMIT 0, 1 ";
		$database->setQuery( $query );
		$frontpage_id = $database->loadResult();
		
		$botParams = new mosParameters( $mybot->params );

		$partialdisplay = $botParams->def( 'partialdisplay', 'none' );
		$excludecategories = $botParams->def( 'excludecategories', ' ' );
		$manualurl = $botParams->def( 'manualurl', 'no' );
		$staticcontent = $botParams->def( 'staticcontent', 'all' );
		$currenturl = $botParams->def( 'currenturl', 'no' );
		$verticalfloat = $botParams->def( 'verticalfloat', 'right' );
		$horizontalalign = $botParams->def( 'horizontalalign', 'left' );
		$bordercolor = $botParams->def( 'bordercolor', 'Gray' );
		$borderwidth = $botParams->def( 'borderwidth', '1' );
		$bookmarktext = $botParams->def( 'bookmarktext', '' );
		$removebaseurl = $botParams->def( 'removebaseurl', 'no' );
		$digg = $botParams->def( 'digg', 'advanced' );
		$diggalign = $botParams->def( 'diggalign', 'vertical' );
		$delicious = $botParams->def( 'delicious', 'small' );
		$deliciousalign = $botParams->def( 'deliciousalign', 'horizontal' );
		$google = $botParams->def( 'google', 'small' );
		$googlealign = $botParams->def( 'googlealign', 'horizontal' );
		$live = $botParams->def( 'live', 'small' );
		$livealign = $botParams->def( 'livealign', 'horizontal' );
		$facebook = $botParams->def( 'facebook', 'small' );
		$facebookalign = $botParams->def( 'facebookalign', 'horizontal' );
		$slashdot = $botParams->def( 'slashdot', 'small' );
		$slashdotalign = $botParams->def( 'slashdotalign', 'horizontal' );
		$netscape = $botParams->def( 'netscape', 'small' );
		$netscapealign = $botParams->def( 'netscapealign', 'horizontal' );
		$technorati = $botParams->def( 'technorati', 'small' );
		$technoratialign = $botParams->def( 'technoratialign', 'horizontal' );
		$stumbleupon = $botParams->def( 'stumbleupon', 'small' );
		$stumbleuponalign = $botParams->def( 'stumbleuponalign', 'horizontal' );
		$spurl = $botParams->def( 'spurl', 'no' );
		$spurlalign = $botParams->def( 'spurlalign', 'horizontal' );
		$wists = $botParams->def( 'wists', 'no' );
		$wistsalign = $botParams->def( 'wistsalign', 'horizontal' );
		$simpy = $botParams->def( 'simpy', 'no' );
		$simpyalign = $botParams->def( 'simpyalign', 'horizontal' );
		$newsvine = $botParams->def( 'newsvine', 'small' );
		$newsvinealign = $botParams->def( 'newsvinealign', 'horizontal' );
		$blinklist = $botParams->def( 'blinklist', 'no' );
		$blinklistalign = $botParams->def( 'blinklistalign', 'horizontal' );
		$furl = $botParams->def( 'furl', 'small' );
		$furlalign = $botParams->def( 'furlalign', 'horizontal' );
		$reddit = $botParams->def( 'reddit', 'small' );
		$redditalign = $botParams->def( 'redditalign', 'horizontal' );
		$fark = $botParams->def( 'fark', 'no' );
		$farkalign = $botParams->def( 'farkalign', 'horizontal' );
		$blogmarks = $botParams->def( 'blogmarks', 'no' );
		$blogmarksalign = $botParams->def( 'blogmarksalign', 'horizontal' );
		$yahoo = $botParams->def( 'yahoo', 'small' );
		$yahooalign = $botParams->def( 'yahooalign', 'horizontal' );
		$smarking = $botParams->def( 'smarking', 'small' );
		$smarkingalign = $botParams->def( 'smarkingalign', 'horizontal' );
		$netvouz = $botParams->def( 'netvouz', 'no' );
		$netvouzalign = $botParams->def( 'netvouzalign', 'horizontal' );
		$shadows = $botParams->def( 'shadows', 'no' );
		$shadowsalign = $botParams->def( 'shadowsalign', 'horizontal' );
		$rawsugar = $botParams->def( 'rawsugar', 'no' );
		$rawsugaralign = $botParams->def( 'rawsugaralign', 'horizontal' );
		$magnolia = $botParams->def( 'magnolia', 'small' );
		$magnoliaalign = $botParams->def( 'magnoliaalign', 'horizontal' );
		$plugim = $botParams->def( 'plugim', 'no' );
		$plugimalign = $botParams->def( 'plugimalign', 'horizontal' );
		$squidoo = $botParams->def( 'squidoo', 'no' );
		$squidooalign = $botParams->def( 'squidooalign', 'horizontal' );
		$blogmemes = $botParams->def( 'blogmemes', 'no' );
		$blogmemesalign = $botParams->def( 'blogmemesalign', 'horizontal' );
		$feedmelinks = $botParams->def( 'feedmelinks', 'no' );
		$feedmelinksalign = $botParams->def( 'feedmelinksalign', 'horizontal' );
		$blinkbits = $botParams->def( 'blinkbits', 'no' );
		$blinkbitsalign = $botParams->def( 'blinkbitsalign', 'horizontal' );
		$tailrank = $botParams->def( 'tailrank', 'no' );
		$tailrankalign = $botParams->def( 'tailrankalign', 'horizontal' );
		$linkagogo = $botParams->def( 'linkagogo', 'no' );
		$linkagogoalign = $botParams->def( 'linkagogoalign', 'horizontal' );
		$jrandom = rand(1000, 9999);
		
		// Calculate left/right margins
		$verticalmargin = '';
		if ($verticalfloat == 'right')
		{
			$verticalmargin = 'left';
		}
		else
		{
			$verticalmargin = 'right';
		}
		
		// Check if this content item is in an excluded category
		$excluded = explode (",", $excludecategories);
		$goodtogo = true;
		foreach ($excluded as $ex)
		{
			//echo($ex);
			if ($row->catid == $ex)
			{
				$goodtogo = false;
			}
		}
		
		// ((If current page is the full content item unless desired on homepage) and ((if not static content and not only static content desired) or (if static content and only static content not desired)))
		if ((@$_GET['task'] == 'view' || ($partialdisplay != "none") && ($currenturl == 'no')) && $goodtogo && ((($row->catid != 0) && ($staticcontent != "static")) || (($row->catid == 0) && ($staticcontent != "content"))))
		{
			$temphtml = '';
			$tophtml = '';
			$bottomhtml = '';
			
			if ($manualurl == 'yes' && preg_match('#{socialbookmarker}(.*?){/socialbookmarker}#s', $row->text, $matches, PREG_OFFSET_CAPTURE))
			{
				// Get $thisurl
				$pos1 = stripos($matches[0][0], 'sburl=&quot;') + 12;
				$pos2 = stripos($matches[0][0], '&quot;', $pos1);
				$thisurl = substr($matches[0][0], $pos1, $pos2 - $pos1);				
				// Get $thistitle
				if (preg_match('#sbtitle=#s', $matches[0][0]))
				{
					$pos1 = stripos($matches[0][0], 'sbtitle=&quot;') + 14;
					$pos2 = stripos($matches[0][0], '&quot;', $pos1);
					$thistitle = substr($matches[0][0], $pos1, $pos2 - $pos1);
				}
				else
				{
					$thistitle = $row->title;
				}

			}
			else
			{
				$thisurl = geturl($row->id);
				$thistitle = $row->title;
			}

			
			if ($digg == 'small')
			{
				//$temphtml = '<a href="http://digg.com/submit?phase=2&url='. $thisurl .'&title='. $thistitle .'" onclick="window.open(\'http://digg.com/submit?phase=2&amp;url=\'+encodeURIComponent('. $thisurl .')+\'&amp;title=\'+encodeURIComponent('. $thistitle .'));return false;" title="Digg!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/digg.png" alt="Digg!" title="Digg!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://digg.com/submit?phase=2&amp;url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://digg.com/submit?phase=2&url='. $thisurl .'&title='. $thistitle .'" title="Digg!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/digg.png" alt="Digg!" title="Digg!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($diggalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					$tophtml = $tophtml . $temphtml;
				}
			}
			else if ($digg == 'advanced')
			{
				// If using $currenturl
				if ($currenturl == 'yes')
				{
					$temphtml = '<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>';
				}
				// Else use generated URL
				else
				{
					$temphtml = '<script type="text/javascript" language="JavaScript">digg_url = \''. $thisurl .'\';</script><script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>';
				}
				
				if ($diggalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($reddit == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://reddit.com/submit?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://reddit.com/submit?url='. $thisurl .'&title='. $thistitle .'" title="Reddit!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/reddit.png" alt="Reddit!" title="Reddit!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($redditalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			else if ($reddit == 'wide')
			{
				$temphtml = '<script>reddit_url=sburl'.$jrandom.';</script><script language="javascript" src="http://reddit.com/button.js?t=1"></script>';
				if ($redditalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			else if ($reddit == 'diggstyle')
			{
				$temphtml = '<script>reddit_url=sburl'.$jrandom.';</script><script language="javascript" src="http://reddit.com/button.js?t=2"></script>';
				if ($redditalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			else if ($reddit == 'redditlogo')
			{
				$temphtml = '<script>reddit_url=sburl'.$jrandom.';</script><script language="javascript" src="http://reddit.com/button.js?t=3"></script>';
				if ($redditalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($delicious == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://del.icio.us/post?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://del.icio.us/post?url='. $thisurl .'&title='. $thistitle .'" title="Del.icio.us!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/delicious.png" alt="Del.icio.us!" title="Del.icio.us!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($deliciousalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			else if ($delicious == 'tallbadge')
			{
				$temphtml = '<script src="http://images.del.icio.us/static/js/blogbadge.js"></script>';
				if ($deliciousalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			else if ($delicious == 'widebadge')
			{
				$temphtml = '<script type="text/javascript">if (typeof window.Delicious == "undefined"){ window.Delicious = {}; } Delicious.BLOGBADGE_DEFAULT_CLASS = \'delicious-blogbadge-line\';</script><script src="http://images.del.icio.us/static/js/blogbadge.js"></script>';
				if ($deliciousalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($google == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.google.com/bookmarks/mark?op=add&amp;bkmk=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.google.com/bookmarks/mark?op=add&bkmk='. $thisurl .'&title='. $thistitle .'" title="Google!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/google.png" alt="Google!" title="Google!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($googlealign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($live == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'https://favorites.live.com/quickadd.aspx?marklet=1&amp;mkt=en-us&amp;top=0&amp;url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="https://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&top=0&url='. $thisurl .'&title='. $thistitle .'" title="Live!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/live.png" alt="Live!" title="Live!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($livealign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($facebook == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.facebook.com/share.php?u=\'+sburl'.$jrandom.'+\'&amp;t=\'+sbtitle'.$jrandom.');return false;" href="http://www.facebook.com/share.php?u='. $thisurl .'&t='. $thistitle .'" title="Facebook!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/facebook.png" alt="Facebook!" title="Facebook!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($facebookalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($slashdot == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://slashdot.org/bookmark.pl?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://slashdot.org/bookmark.pl?url='. $thisurl .'&title='. $thistitle .'" title="Slashdot!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/slashdot.png" alt="Slashdot!" title="Slashdot!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($slashdotalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($netscape == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.netscape.com/submit/?U=\'+sburl'.$jrandom.'+\'&amp;T=\'+sbtitle'.$jrandom.');return false;" href="http://www.netscape.com/submit/?U='. $thisurl .'&T='. $thistitle .'" title="Netscape!" target="_blank"><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/netscape.png" alt="Netscape!" title="Netscape!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($netscapealign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($technorati == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://technorati.com/faves/?add=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://technorati.com/faves/?add='. $thisurl .'" title="Technorati!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/technorati.png" alt="Technorati!" title="Technorati!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($technoratialign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($stumbleupon == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.stumbleupon.com/submit?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.stumbleupon.com/submit?url='. $thisurl .'&title='. $thistitle .'" title="StumbleUpon!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/stumbleupon.png" alt="StumbleUpon!" title="StumbleUpon!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($stumbleuponalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($spurl == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.spurl.net/spurl.php?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.spurl.net/spurl.php?url='. $thisurl .'&title='. $thistitle .'" title="Spurl!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/spurl.png" alt="Spurl!" title="Spurl!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($spurlalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($wists == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://wists.com/r.php?r=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://wists.com/r.php?r='. $thisurl .'&title='. $thistitle .'" title="Wists!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/wists.png" alt="Wists!" title="Wists!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($wistsalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($simpy == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.simpy.com/simpy/LinkAdd.do?href=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.simpy.com/simpy/LinkAdd.do?href='. $thisurl .'&title='. $thistitle .'" title="Simpy!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/simpy.png" alt="Simpy!" title="Simpy!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($simpyalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($newsvine == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.newsvine.com/_tools/seed&save?u=\'+sburl'.$jrandom.'+\'&amp;h=\'+sbtitle'.$jrandom.');return false;" href="http://www.newsvine.com/_tools/seed&save?u='. $thisurl .'&h='. $thistitle .'" title="Newsvine!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/newsvine.png" alt="Newsvine!" title="Newsvine!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($newsvinealign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($blinklist == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.blinklist.com/index.php?Action=Blink/addblink.php&Url=\'+sburl'.$jrandom.'+\'&amp;Title=\'+sbtitle'.$jrandom.');return false;" href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&Url='. $thisurl .'&Title='. $thistitle .'" title="Blinklist!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/blinklist.png" alt="Blinklist!" title="Blinklist!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($blinklistalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($furl == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.furl.net/storeIt.jsp?u=\'+sburl'.$jrandom.'+\'&amp;t=\'+sbtitle'.$jrandom.');return false;" href="http://www.furl.net/storeIt.jsp?u='. $thisurl .'&t='. $thistitle .'" title="Furl!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/furl.png" alt="Furl!" title="Furl!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($furlalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($fark == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://cgi.fark.com/cgi/fark/submit.pl?new_url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://cgi.fark.com/cgi/fark/submit.pl?new_url='. $thisurl .'" title="Fark!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/fark.png" alt="Fark!" title="Fark!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($farkalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($blogmarks == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://blogmarks.net/my/new.php?mini=1&simple=1&url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://blogmarks.net/my/new.php?mini=1&simple=1&url='. $thisurl .'&title='. $thistitle .'" title="Blogmarks!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/blogmarks.png" alt="Blogmarks!" title="Blogmarks!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($blogmarksalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($yahoo == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://myweb2.search.yahoo.com/myresults/bookmarklet?u=\'+sburl'.$jrandom.'+\'&amp;t=\'+sbtitle'.$jrandom.');return false;" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u='. $thisurl .'&t='. $thistitle .'" title="Yahoo!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/yahoo.png" alt="Yahoo!" title="Yahoo!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($yahooalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($smarking == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://smarking.com/editbookmark/?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://smarking.com/editbookmark/?url='. $thisurl .'" title="Smarking!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/smarking.png" alt="Smarking!" title="Smarking!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($smarkingalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($netvouz == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.netvouz.com/action/submitBookmark?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.netvouz.com/action/submitBookmark?url='. $thisurl .'&title='. $thistitle .'" title="Smarking!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/netvouz.png" alt="Netvouz!" title="Netvouz!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($netvouzalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($shadows == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.shadows.com/bookmark/saveLink.rails?page=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.shadows.com/bookmark/saveLink.rails?page='. $thisurl .'&title='. $thistitle .'" title="Shadows!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/shadows.png" alt="Shadows!" title="Shadows!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($shadowsalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($rawsugar == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.rawsugar.com/tagger/?turl=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.rawsugar.com/tagger/?turl='. $thisurl .'&title='. $thistitle .'" title="RawSugar!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/rawsugar.png" alt="RawSugar!" title="RawSugar!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($rawsugaralign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($magnolia == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://ma.gnolia.com/beta/bookmarklet/add?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://ma.gnolia.com/beta/bookmarklet/add?url='. $thisurl .'&title='. $thistitle .'" title="Ma.gnolia!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/magnolia.png" alt="Ma.gnolia!" title="Ma.gnolia!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($magnoliaalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($plugim == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.plugim.com/submit?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.plugim.com/submit?url='. $thisurl .'&title='. $thistitle .'" title="PlugIM!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/plugim.png" alt="PlugIM!" title="PlugIM!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($plugimalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($squidoo == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.squidoo.com/lensmaster/bookmark?\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.squidoo.com/lensmaster/bookmark?'. $thisurl .'" title="Squidoo!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/squidoo.png" alt="Squidoo!" title="Squidoo!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($squidooalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			if ($blogmemes == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.blogmemes.net/post.php?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.blogmemes.net/post.php?url='. $thisurl .'&title='. $thistitle .'" title="BlogMemes!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/blogmemes.png" alt="BlogMemes!" title="BlogMemes!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($blogmemesalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($feedmelinks == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://feedmelinks.com/categorize?from=toolbar&amp;op=submit&amp;url=\'+sburl'.$jrandom.'+\'&amp;name=\'+sbtitle'.$jrandom.');return false;" href="http://feedmelinks.com/categorize?from=toolbar&op=submit&url='. $thisurl .'&name='. $thistitle .'" title="FeedMeLinks!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/feedmelinks.png" alt="FeedMeLinks!" title="FeedMeLinks!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($feedmelinksalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($blinkbits == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.blinkbits.com/bookmarklets/save.php?v=1&amp;source_url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.blinkbits.com/bookmarklets/save.php?v=1&source_url='. $thisurl .'&title='. $thistitle .'" title="BlinkBits!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/blinkbits.png" alt="BlinkBits!" title="BlinkBits!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($blinkbitsalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($tailrank == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://tailrank.com/share/?text=&amp;link_href=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://tailrank.com/share/?text=&link_href='. $thisurl .'&title='. $thistitle .'" title="Tailrank!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/tailrank.png" alt="Tailrank!" title="Tailrank!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($tailrankalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}

			if ($linkagogo == 'small')
			{
				$temphtml = '<a rel="nofollow" onclick="window.open(\'http://www.linkagogo.com/go/AddNoPopup?url=\'+sburl'.$jrandom.'+\'&amp;title=\'+sbtitle'.$jrandom.');return false;" href="http://www.linkagogo.com/go/AddNoPopup?url='. $thisurl .'&title='. $thistitle .'" title="linkaGoGo!" target="_blank"><img src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/linkagogo.png" alt="linkaGoGo!" title="linkaGoGo!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				if ($linkagogoalign == 'horizontal')
				{
					$bottomhtml = $bottomhtml . $temphtml;
				}
				else
				{
					if ($tophtml != '')
					{
						$tophtml = $tophtml .'<br /><br />';
					}
					$tophtml = $tophtml . $temphtml;
				}
			}
			
			//if ($addtoyoursite == 'small')
			if ($bottomhtml != "")
			{				
				$temphtml = '<a href="http://joomladigger.com" title="Add these social bookmarking buttons to your personal Joomla! website."><img height="18px" width="18px" src="'. $mosConfig_live_site .'/mambots/content/socialbookmarkerbot_images/joomladigger.png" alt="Free social bookmarking plugins and extensions for Joomla! websites!" title="Drive more traffic to your website with free social bookmarking scripts!" style="border: solid '. $borderwidth .'px '. $bordercolor .'; padding: 1px; margin: 1px;" /></a>';
				$bottomhtml = $bottomhtml . $temphtml;
			}
			
			// Put it all together
			if (@$_GET['task'] != 'view')
			{
				if ($tophtml != '' && ($partialdisplay == 'all' || $partialdisplay == 'vertical'))
				{
					$row->text = '<div style="float:'. $verticalfloat .'; margin-'. $verticalmargin .': 10px; padding-bottom: 10px; text-align: right;">'. $tophtml .'</div>'. $row->text;
				}
				if ($bottomhtml != '' && ($partialdisplay == 'all' || $partialdisplay == 'horizontal'))
				{
					$row->text = $row->text .'<div style="clear:both; text-align: '. $horizontalalign .'"><br /><hr /><br />'. $bookmarktext .'<br />'. $bottomhtml .'</div>';
				}
			}
			else
			{
				if ($tophtml != '')
				{
					$row->text = '<div style="float:'. $verticalfloat .'; margin-'. $verticalmargin .': 10px; padding-bottom: 10px; text-align: right;">'. $tophtml .'</div>'. $row->text;
				}
				if ($bottomhtml != '')
				{
					$row->text = $row->text .'<div style="clear:both; text-align: '. $horizontalalign .'"><br /><hr /><br />'. $bookmarktext .'<br />'. $bottomhtml .'</div>';
				}
			}
			
			// Set JavaScript Variables if NOT using $currenturl
			if ($currenturl == 'no')
			{
				$row->text = '<script type="text/javascript" language="JavaScript">digg_title = "'. $thistitle .'"; var sbtitle'.$jrandom.'=encodeURIComponent("'. trim($thistitle) .'"); var sburl'.$jrandom.'=decodeURI("'. $thisurl .'"); sburl'.$jrandom.'=sburl'.$jrandom.'.replace(/amp;/g, "");sburl'.$jrandom.'=encodeURIComponent(sburl'.$jrandom.');</script>'. $row->text;
			}
			// Else use currenturl
			{
				$row->text = '<script type="text/javascript" language="JavaScript">digg_title = "'. $thistitle .'"; var sburl'.$jrandom.' = window.location.href; var sbtitle'.$jrandom.' = document.title;</script>'. $row->text;
			}
		}
	}
	// Remove code from HTML
	$row->text = preg_replace('#{socialbookmarker}(.*?){/socialbookmarker}#s', '', $row->text);
	
	return true;
}

function geturl($contentid)
{
	global $mosConfig_live_site, $mosConfig_sef;
	$link = '';
	if ($contentid)
	{
	    $link = sefRelToAbs( 'index.php?option=com_content&task=view&id='. $contentid );
		if ($mosConfig_sef == '0' && $removebaseurl == "no")
		{
			$link = $mosConfig_live_site .'/'. $link;
		}
	}
	return $link;
}
?>