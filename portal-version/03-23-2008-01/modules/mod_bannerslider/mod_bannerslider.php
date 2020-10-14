<?php
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');

$cache =& JFactory::getCache();
if ($params->get('cache') == 1)
	$cache->setCaching(1);
$cache->call( array('modBannerSliderHelper', 'view'), modBannerSliderHelper::getlist($params) );

?>