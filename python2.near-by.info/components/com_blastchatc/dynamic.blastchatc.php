<?php
/**
* dynamic.blastchatc.php
* @package BlastChat Client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/* BlastChat module set params to load
*/
function bc_getParams() {
	$bc_params->multisite		= mosGetParam($_REQUEST, 'multisite' );
	$bc_params->showlist		= mosGetParam($_REQUEST, 'showlist' );
	$bc_params->showmode		= mosGetParam($_REQUEST, 'showmode' );
	$bc_params->tooltip			= mosGetParam($_REQUEST, 'tooltip' );
	$bc_params->showmodechat	= mosGetParam($_REQUEST, 'showmodechat' );
	$bc_params->username_type	= mosGetParam($_REQUEST, 'username_type' );
	$bc_params->chat_order		= mosGetParam($_REQUEST, 'chat_order' );
	$bc_params->chat_l	= mosGetParam($_REQUEST, 'chat_l' );
	$bc_params->cb_order		= mosGetParam($_REQUEST, 'cb_order' );
	$bc_params->cb_l		= mosGetParam($_REQUEST, 'cb_l' );
	$bc_params->smf_order		= mosGetParam($_REQUEST, 'smf_order' );
	$bc_params->smf_l		= mosGetParam($_REQUEST, 'smf_l' );
	$bc_params->username_order	= mosGetParam($_REQUEST, 'username_order' );
	$bc_params->addspace		= mosGetParam($_REQUEST, 'space' );
	$bc_params->detached		= mosGetParam($_REQUEST, 'detached' );
	$bc_params->currentitemid	= mosGetParam($_REQUEST, 'currentitemid' );
	$bc_params->bc_itemid		= mosGetParam($_REQUEST, 'bc_itemid' );
	$bc_params->bc_itemidp		= mosGetParam($_REQUEST, 'bc_itemidp' );
	$bc_params->cb_avatar		= mosGetParam($_REQUEST, 'cb_avatar' );
	$bc_params->cb_bold			= mosGetParam($_REQUEST, 'cb_bold' );
	$bc_params->cb_s			= mosGetParam($_REQUEST, 'cb_s' );
	$bc_params->cb_sm		= mosGetParam($_REQUEST, 'cb_sm' );
	$bc_params->cb_sf		= mosGetParam($_REQUEST, 'cb_sf' );
	$bc_params->cb_sfield	= mosGetParam($_REQUEST, 'cb_sfield' );
	$bc_params->cb_sfield_m	= mosGetParam($_REQUEST, 'cb_sfield_m' );
	$bc_params->cb_sfield_f	= mosGetParam($_REQUEST, 'cb_sfield_f' );
	return $bc_params;
}

/* Module params from module configuration
*/
function bc_getBCparams($params) {
	$bc_params->multisite		= $params->get( 'bcm_multisite' );
	$bc_params->showlist		= $params->get( 'bcm_showlist' );
	$bc_params->showmode		= $params->get( 'bcm_showmode' );
	$bc_params->tooltip			= $params->get( 'bcm_tooltip' );
	$bc_params->showmodechat	= $params->get( 'bcm_showmodechat' );
	$bc_params->username_type	= $params->get( 'bcm_username_type' );
	$bc_params->chat_order		= $params->get( 'bcm_chat_order' );
	$bc_params->chat_l	= $params->get( 'bcm_chat_l' );
	$bc_params->cb_order		= $params->get( 'bcm_cb_order' );
	$bc_params->cb_l		= $params->get( 'bcm_cb_l' );
	$bc_params->smf_order		= $params->get( 'bcm_smf_order' );
	$bc_params->smf_l		= $params->get( 'bcm_smf_l' );
	$bc_params->username_order	= $params->get( 'bcm_username_order' );
	$bc_params->addspace		= $params->get( 'bcm_space' );
	$bc_params->detached		= $params->get( 'bcm_detached' );
	$bc_params->currentitemid	= $params->get( 'bcm_currentitemid' );
	$bc_params->bc_itemid		= $params->get( 'bcm_itemid' );
	$bc_params->bc_itemidp		= $params->get( 'bcm_itemidp' );
	$bc_params->cb_avatar		= $params->get( 'bcm_cb_avatar' );
	$bc_params->cb_bold			= $params->get( 'bcm_cb_bold' );
	$bc_params->cb_s			= $params->get( 'bcm_cb_s' );
	$bc_params->cb_sm		= $params->get( 'bcm_cb_sm' );
	$bc_params->cb_sf		= $params->get( 'bcm_cb_sf' );
	$bc_params->cb_sfield	= $params->get( 'bcm_cb_sfield' );
	$bc_params->cb_sfield_m	= $params->get( 'bcm_cb_sfield_m' );
	$bc_params->cb_sfield_f	= $params->get( 'bcm_cb_sfield_f' );
	return $bc_params;
}

function bc_getURLparams($bc_params) {
	global $Itemid;
	$spar = "multisite=".$bc_params->multisite
	."&showlist=".$bc_params->showlist
	."&showmode=".$bc_params->showmode
	."&tooltip=".$bc_params->tooltip
	."&showmodechat=".$bc_params->showmodechat
	."&username_type=".$bc_params->username_type
	."&chat_order=".$bc_params->chat_order
	."&chat_l=".$bc_params->chat_l
	."&cb_order=".$bc_params->cb_order
	."&cb_l=".$bc_params->cb_l
	."&smf_order=".$bc_params->smf_order
	."&smf_l=".$bc_params->smf_l
	."&username_order=".$bc_params->username_order
	."&addspace=".$bc_params->addspace
	."&detached=".$bc_params->detached
	."&currentitemid=".$bc_params->currentitemid
	."&bc_itemid=".$bc_params->bc_itemid
	."&bc_itemidp=".$bc_params->bc_itemidp
	."&cb_avatar=".$bc_params->cb_avatar
	."&cb_bold=".$bc_params->cb_bold
	."&cb_s=".$bc_params->cb_s
	."&cb_sm=".$bc_params->cb_sm
	."&cb_sf=".$bc_params->cb_sf
	."&cb_sfield=".$bc_params->cb_sfield
	."&cb_sfield_m=".$bc_params->cb_sfield_m
	."&cb_sfield_f=".$bc_params->cb_sfield_f
	."&Itemid=".$Itemid;
	return $spar;
}

//type - 0 chat, 1 profile
function bc_getItemid($bc_params, $Itemid, $type=-1) {
	$chatlink = '';
	if ($bc_params->currentitemid == 1) {
		$chatlink .= "&Itemid=".$Itemid;
	} elseif ($bc_params->currentitemid == 2) {
		if ($type == 1) {
			$chatlink .= "&Itemid=".$bc_params->bc_itemidp;
		} elseif ($type == 0) {
			$chatlink .= "&Itemid=".$bc_params->bc_itemid;
		}
	}
	return $chatlink;
}

/*
Adjust this function to change tool-tip presentation looks
$istt = is tooltip, 1 - in case this is usertext generation for tooltip function
*/
function getUsernameColor($row, $bc_params, $text, $istt = 1) {
	if ($bc_params->cb_s && $row->cb_sfield && $bc_params->cb_sfield_m && $bc_params->cb_sfield_f) {
		if (strcasecmp($row->cb_sfield, $bc_params->cb_sfield_m) == 0) {
			//$color = " color: ".$bc_params->cb_sm."; ";
			if ($istt) {
				$text = "<font color=\'".$bc_params->cb_sm."\'>".$text."</font>";
			} else {
				$text = "<font color='".$bc_params->cb_sm."'>".$text."</font>";
			}
		} elseif (strcasecmp($row->cb_sfield, $bc_params->cb_sfield_f) == 0) {
			//$color = " color: ".$bc_params->cb_sf."; ";
			if ($istt) {
				$text = "<font color=\'".$bc_params->cb_sf."\'>".$text."</font>";
			} else {
				$text = "<font color='".$bc_params->cb_sf."'>".$text."</font>";
			}
		}
	}
	if ($bc_params->cb_bold) {
		$text = "<b>".$text."</b>";
	}
	//return "<span style=' ".$color.$bold." '>".$text."</span>";
	return $text;
}

/*
Adjust this function to change tool-tip presentation looks
*/
function bc_getUserText($row, $bc_params) {
	global $dynamic_upd, $bc_time;
	
	$usertext = sprintf( _BC_MEMBER, $row->username );
	if ($dynamic_upd) {
		//$usertext = getUsernameColor($row, $bc_params, urlencode($usertext));
		$usertext = getUsernameColor($row, $bc_params, $usertext);
	} else {
		$usertext = getUsernameColor($row, $bc_params, $usertext);
	}
	
	if ( $row->guest == 0 && $row->last_update && $row->last_update > $bc_time && $row->logged == 1) {
		if ($row->roomname)
			$usertext .= sprintf( _BC_USER_CHATTING_IN, $row->roomname, $row->idle );
		else
			$usertext .= sprintf( _BC_USER_INSIDE_CHAT, $row->idle );
	} else
		$usertext .= sprintf( _BC_USER_NOT_CHATTING);
	
	if (!$row->last_entry || $row->last_entry == "0000-00-00 00:00:00") {
		$usertext .= sprintf( _BC_USER_LASTCHATENTRY, _BC_NEVER);
	} else {
		$usertext .= sprintf( _BC_USER_LASTCHATENTRY, date("H:i:s d-M-Y", strtotime($row->last_entry)));
	}
	$usertext .= sprintf( _BC_USER_LASTLOGIN, date("H:i:s d-M-Y", strtotime($row->lastvisitDate)));
	$return = $usertext;
	if ($bc_params->cb_avatar && $row->avatarapproved) {
		//CB avatar
		$user_avatar_path = "images/comprofiler";
		$imm = "";
		if($row->avatar && file_exists($user_avatar_path."/tn".$row->avatar)) {
			$imm = "<img src=\'".$user_avatar_path."/tn".$row->avatar."\' />";
		} elseif ($row->avatar && file_exists($user_avatar_path."/".$row->avatar)) {
			$imm = "<img src=\'".$user_avatar_path."/".$row->avatar."\' /> ";
		} elseif (file_exists("components/com_comprofiler/images/english/tnnophoto.jpg")) {
			$imm = "<img src=\'components/com_comprofiler/images/english/tnnophoto.jpg\' /> ";
		}
		$return = $imm."<br>".$return;
		//CB avatar end
	}
	return $return;
}

function bc_showChatting($row, $bc_params, $Itemid) {
	global $mosConfig_live_site, $bc_time;
	
	$content = "";
	$chatlink = $mosConfig_live_site."/index.php?option=com_blastchatc";
	if ($bc_params->detached == 1)
		$chatlink .= "&d=1";
	elseif ($bc_params->detached == 0)
		$chatlink .= "&d=0";
	$chatlink .= bc_getItemid($bc_params, $Itemid, 0); //0 - chat itemid
	$usertext = bc_getUserText($row, $bc_params);
	if ($row->last_update && $row->last_update > $bc_time && $row->logged == 1) {
		if ($row->roomid) {
			$chatlink .= "&rid=".$row->roomid;
			$chatlink .= "&rsid=".$row->room_serverid;
		}
		$content .= mosToolTip( $usertext, _BC_CHATLINK, $bc_params->tooltip, "../../../components/com_blastchatc/images/online.png", "", $chatlink, $bc_params->chat_l );
	} else
		$content .= mosToolTip( $usertext, _BC_CHATLINK, $bc_params->tooltip, "../../../components/com_blastchatc/images/offline.png", "", $chatlink , $bc_params->chat_l );
	return $content;
}

function bc_showCBProfile($row, $bc_params, $Itemid) {
	global $mosConfig_live_site, $bc_time;
	
	$chatlink = bc_getItemid($bc_params, $Itemid, 1); //1 - prfile itemid
	$usertext = bc_getUserText($row, $bc_params);
	$content = mosToolTip( $usertext, _BC_CBLINK, $bc_params->tooltip, "../../../components/com_blastchatc/images/profiles.gif", "", $mosConfig_live_site."/index.php?option=com_comprofiler&task=userProfile".$chatlink."&user=".$row->id, $bc_params->cb_l );
	return $content;
}

function bc_showSMFProfile($row, $bc_params, $Itemid) {
	global $bc_time, $mosConfig_live_site;
	
	$chatlink = bc_getItemid($bc_params, $Itemid, 1); //1 - profile itemid
	$usertext = bc_getUserText($row, $bc_params);
	$content = mosToolTip( $usertext, _BC_SMFLINK, $bc_params->tooltip, "../../../components/com_blastchatc/images/profiles.gif", "", $mosConfig_live_site."/index.php?option=com_smf&action=profile".$chatlink."&u=".$row->id, $bc_params->smf_l );
	return $content;
}

function bc_showChatLink($row, $bc_params, $Itemid) {
	global $mosConfig_live_site, $bc_time;

	$chatlink = $mosConfig_live_site."/index.php?option=com_blastchatc";
	if ($bc_params->detached == 1)
		$chatlink .= "&d=1";
	elseif ($bc_params->detached == 0)
		$chatlink .= "&d=0";
	$chatlink .= bc_getItemid($bc_params, $Itemid, 0); //0 - chat itemid
	if ($row->last_update && $row->last_update > $bc_time && $row->logged == 1 && $row->roomid) {
		$chatlink .= "&rid=".$row->roomid;
		$chatlink .= "&rsid=".$row->room_serverid;
	}
	$usertext = bc_getUserText($row, $bc_params);
	$content = mosToolTip( $usertext, _BC_CHATLINK, $bc_params->tooltip, "", getUsernameColor($row, $bc_params, $row->username, 0), $chatlink );
	return $content;
}

function bc_showCBProfileLink($row, $bc_params, $Itemid) {
	global $mosConfig_live_site, $bc_time;
	
	$chatlink = bc_getItemid($bc_params, $Itemid, 1); //1 - profile itemid
	$usertext = bc_getUserText($row, $bc_params);
	$content .= mosToolTip( $usertext, _BC_CBLINK, $bc_params->tooltip, "", getUsernameColor($row, $bc_params, $row->username, 0), $mosConfig_live_site."/index.php?option=com_comprofiler&task=userProfile".$chatlink."&user=".$row->id);
	return $content;
}

function bc_showSMFProfileLink($row, $bc_params, $Itemid) {
	global $mosConfig_live_site, $bc_time;
	
	$chatlink = bc_getItemid($bc_params, $Itemid, 1); //1 - prfile itemid
	$usertext = bc_getUserText($row, $bc_params);
	$content = mosToolTip( $usertext, _BC_SMFLINK, $bc_params->tooltip, "", getUsernameColor($row, $bc_params, $row->username, 0), $mosConfig_live_site."/index.php?option=com_smf&action=profile".$chatlink."&u=".$row->id );
	return $content;
}

function bc_getContent($bc_params, $dynamic_update=0) {
	global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $Itemid, $database;
	global $dynamic_upd;
	global $bc_time;
	
	$content = "";
	$chlink = "";
	$usertext = "";
	$dynamic_upd = $dynamic_update;
	
	if (!file_exists($mosConfig_absolute_path.'/components/com_blastchatc/module.blastchatc.php')) {
		echo "Missing file ".$mosConfig_absolute_path."/components/com_blastchatc/module.blastchatc.php";
		return;
	}
	// Get the languages file if it exists
	if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php'))
		include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php');
	if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php'))
		include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php');
	
	require_once($mosConfig_absolute_path.'/components/com_blastchatc/module.blastchatc.php');
	
	bc_userActivity();
	
	$chatters = bc_getLocalChatters($bc_params);
	$chatters_count = bc_getChattersCount($bc_params);
	
	if ($bc_params->showmode==0 || $bc_params->showmode==2) {
		$user_array 	= 0;
		$user_chatter_array 	= 0;
		$guest_array 	= 0;
		$guest_chatter_array 	= 0;
		foreach( $chatters_count as $chatter ) {
				if ( $chatter->guest == 1 && !$chatter->usertype) {
					$guest_array++;
					if ($chatter->last_update && $chatter->last_update > $bc_time && $chatter->logged == 1)
						$guest_chatter_array++;
				}
				if ( $chatter->guest == 0 ) {
					$user_array++;
					if ($chatter->last_update && $chatter->last_update > $bc_time && $chatter->logged == 1)
						$user_chatter_array++;
				}
		}
	
		if ($guest_array != 0 || $user_array != 0) {
			$content_more = _BC_WE_HAVE;
			
			// guest count handling
			if ($guest_array == 1) {
			// 1 guest only
				$content_more .= sprintf( _BC_GUEST_COUNT, $guest_array );
			} elseif ($guest_array > 1) {
			// more than 1 guest
				$content_more .= sprintf( _BC_GUESTS_COUNT, $guest_array );
			}
		
			// if there are guests and members online
			if ($guest_array != 0 && $user_array != 0) {
				$content_more .= _BC_AND;
			}
				
			// member count handling
			if ($user_array == 1) {
			// 1 member only
				$content_more .= sprintf( _BC_MEMBER_COUNT, $user_array );
			} elseif ($user_array > 1) {
			// more than 1 member
				$content_more .= sprintf( _BC_MEMBERS_COUNT, $user_array );
			}
			$content_more.= _BC_ONLINE;
		} else {
			//uncomment in case you want to print out that 0 members are online
			//$content_more.= _BC_WE_HAVE;
			//$content_more .= " 0 "._BC_ONLINE;
		}
		if ($dynamic_upd) {
			//$content .= urlencode($content_more);
			$content .= $content_more;
		} else {
			$content .= $content_more;
		}
	}
	
	$content_more = null;
	if ($bc_params->showmodechat==0) {
		if ($guest_chatter_array != 0 || $user_chatter_array != 0) {
			$content_more = "<br>\n"._BC_WE_HAVE;
			
			// guest count handling
			if ($guest_chatter_array == 1) {
			// 1 guest only
				$content_more .= sprintf( _BC_GUEST_COUNT, $guest_chatter_array );
			} elseif ($guest_chatter_array > 1) {
			// more than 1 guest
				$content_more .= sprintf( _BC_GUESTS_COUNT, $guest_chatter_array );
			}
		
			// if there are guests and members online
			if ($guest_chatter_array != 0 && $user_chatter_array != 0) {
				$content_more .= _BC_AND;
			}
				
			// member count handling
			if ($user_chatter_array == 1) {
			// 1 member only
				$content_more .= sprintf( _BC_MEMBER_COUNT, $user_chatter_array );
			} elseif ($user_chatter_array > 1) {
			// more than 1 member
				$content_more .= sprintf( _BC_MEMBERS_COUNT, $user_chatter_array );
			}
			$content_more.= " "._BC_CHATTING;
		} else {
			//uncomment in case you want to print out that 0 chatters are chatting
			//$content_more.= "<br>"._BC_WE_HAVE;
			//$content_more .= " 0 "._BC_CHATTING;
		}
		if ($dynamic_upd) {
			//$content .= urlencode($content_more);
			$content .= $content_more;
		} else {
			$content .= $content_more;
		}
	}
	
	if ($bc_params->showmode==1 || $bc_params->showmode==2) {
		if ($chatters) {
			if ($bc_params->showlist)
				$content .= "<ul>\n";
			else
				$content .= "<br>\n";
			foreach($chatters as $row) {
				if ( $row->guest == 0 && $row->username) {
					if ($bc_params->showlist)
						$content .= "<li><strong>";
					for ($i=1;$i<=4;$i++) {
						if ($bc_params->chat_order == $i) {
							$content .= bc_showChatting($row, $bc_params, $Itemid);
						} elseif ($bc_params->cb_order == $i) {
								$content .= bc_showCBProfile($row, $bc_params, $Itemid);
						} elseif ($bc_params->smf_order == $i) {
								$content .= bc_showSMFProfile($row, $bc_params, $Itemid);
						} elseif ($bc_params->username_order == $i)
							switch ($bc_params->username_type) {
								case 0: $content .= getUsernameColor($row, $bc_params, $row->username, 0);
									break;
								case 1: $content .= bc_showChatLink($row, $bc_params, $Itemid);
									break;
								case 2: $content .= bc_showCBProfileLink($row, $bc_params, $Itemid);
									break;
								case 3: $content .= bc_showSMFProfileLink($row, $bc_params, $Itemid);
									break;
							}
						if ($bc_params->addspace && $i < 3)
							$content .= "<br>";
					}
					if ($bc_params->showlist)
						$content .= "</strong></li>\n";
					else
						$content .= "<br>";
				}
			}
			$content .= "</ul>\n";
		}
	}
	
	$chlink .= $mosConfig_live_site."/index.php?option=com_blastchatc";
	if ($bc_params->detached == 1) $chlink .= "&d=1";
	elseif ($bc_params->detached == 0) $chlink .= "&d=0";
	$chlink .= bc_getItemid($bc_params, $Itemid);
	$global_count = bc_getGlobalCount();
	$content .= "\n<div style='text-align:center; display: block; margin-top: 5px;'>\n";
	$usertext .= sprintf( _BC_GLOBALCOUNT, $global_count->global_count." BlastChat" );
	if ($global_count->global_update) {
		$usertext .= sprintf( _BC_LASTUPDATE, date("H:i:s d-M-Y", $global_count->global_update ));
	} else {
		$usertext .= sprintf( _BC_LASTUPDATE, "-");
	}
	if ($dynamic_upd) {
		//$usertext= urlencode($usertext);
	}
	$content .= mosToolTip( $usertext, "BlastChat "._BC_GLOBALSTATUS."<br>www.blastchat.com", $bc_params->tooltip, "", _BC_JOINCHAT, $chlink );
	$content .= "\n</div>\n";

	return $content;
}
?>