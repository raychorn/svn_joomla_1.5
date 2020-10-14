<?php
//
// Copyright (C) 2007 http://www.football-supporter.net
// Edited by MetZ.
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

include_once ($mainframe->getCfg("absolute_path") .'/administrator/components/com_fireboard/fireboard_config.php');
require_once ($mainframe->getCfg("absolute_path") . "/components/com_fireboard/class.fireboard.php");

// JOOMLA STYLE CHECK
if ($fbConfig['joomlaStyle'] < 1)
{
    $boardclass = "fb_";
}

// Add required header tags
$mainframe->addCustomHeadTag('<script type="text/javascript" src="' . JB_JQURL . '"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript">
//1: show, 0 : hide
jr_expandImg_url = "' . JB_URLIMAGESPATH . '";</script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="' . JB_COREJSURL . '"></script>');
if ($fbConfig['joomlaStyle'] < 1) {
$mainframe->addCustomHeadTag('<link type="text/css" rel="stylesheet" href="' . JB_TMPLTCSSURL . '" />');
} else {
$mainframe->addCustomHeadTag('<link type="text/css" rel="stylesheet" href="' . JB_DIRECTURL . '/template/default/joomla.css" />');
}
include ( $mosConfig_absolute_path .'/components/com_fireboard/template/default/plugin/recentposts/recentposts.php');
?>