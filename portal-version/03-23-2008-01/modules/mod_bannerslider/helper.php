<?php
defined('_JEXEC') or die('Restricted access');

class modBannerSliderHelper
{
	function getlist($params)
	{
		// get the parameters
		$var['moduleclass_sfx'] = $params->get('moduleclass_sfx');

		$var['banners']			= $params->get('banners', '');
		$var['categories']		= $params->get('categories', '');
		$var['clients']			= $params->get('clients', '');
		$var['type'] 			= $params->get('type', 1);

		$var['width']			= $params->get('width', 180);
		$var['height']			= $params->get('height', 150);
		$var['delay']			= $params->get('delay', 5000);

		$var['random']			= $params->get('random', 1);
		$var['fadein']			= $params->get('fadein', 1);
		$var['window']			= $params->get('window', 1);

		return $var;
	}
	
	function view($conf)
	{
		$where = array();
		if ($conf['banners'] != '')
		{
			$where[] = 'bid IN (' . modBannerSliderHelper::clean($conf['banners']) . ')';
		}
		
		if ($conf['categories'] != '')
		{
			$where[] = 'catid IN ('.modBannerSliderHelper::clean($conf['categories']) . ')';
		}

		if ($conf['clients'] != '')
		{
			$where[] = 'cid IN (' . modBannerSliderHelper::clean($conf['clients']) . ')';
		}
		
		$where = (count($where) > 0) ? ' AND ('.implode(' OR ', $where).')' : '';

		$query  = "SELECT bid, imageurl, custombannercode FROM #__banner WHERE showBanner = '1'".$where." ORDER BY bid";
		
		$db =& JFactory::getDBO();
		$db->setQuery( $query );
		$results = $db->loadObjectList();
		
		if ( ($count = count($results)) > 0 )
		{
			$slide_id = uniqid('mbs') ;
			$windowtarget = ($conf['window'] == 1) ? ' target="_blank"' : '';
		?>
		<link rel="stylesheet" type="text/css" href="modules/mod_bannerslider/mod_bannerslider.css" />
		<script type="text/javascript" src="modules/mod_bannerslider/mod_bannerslider.js"></script>
		<div id="<?php echo $slide_id; ?>" class="mod_bannerslider" style="width:<?php echo $conf['width']; ?>px;height:<?php echo $conf['height']; ?>px">
			<div class="bs_opacitylayer">
			<?php
			for($i = 0; $i < $count; $i++)
			{
					if ( !empty($results[$i]->imageurl) && ($conf['type'] == 1 || $conf['type'] == 3) )
					{
						echo '<div class="bs_contentdiv"><a href="index.php?option=com_banners&task=click&bid=' . $results[$i]->bid . '"' . $windowtarget . '><img src="images/banners/' . $results[$i]->imageurl . '" /></a></div>' . "\n";
					}
					else if ( !empty($results[$i]->custombannercode) && ($conf['type'] == 2 || $conf['type'] == 3) )
					{
						echo '<div class="bs_contentdiv">' . $results[$i]->custombannercode . "</div>\n";
					}
			}
			?>
			</div>
		</div>
		<script type="text/javascript">
			new ContentSlider("<?php echo $slide_id .'", ' . $conf['delay'] . ', ' . $conf['random'] . ', ' . $conf['fadein'] ?>);
		</script>
<?php
		}
	}
	
	function clean($input)
	{
		return preg_replace( '#,{2,}#', ',', preg_replace('#^[^\d]+|[^\d,]|[^\d]+$#', '', $input) );
	}
}
?>
