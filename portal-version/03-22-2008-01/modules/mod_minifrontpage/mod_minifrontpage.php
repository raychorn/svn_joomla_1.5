<?php
/**
 * Hello World! Module Entry Point
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );


// Get All Parameters
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx', '' );
		$sections 		 	= $params->get( 'sections', '1,2,3' ) ;
		$categories 	 	= $params->get( 'categories', '1,3,7' ) ;
		$order		     	= $params->get( 'order', 1);
		$period 		 	= intval( $params->get( 'period', 366 ) );
		$loadorder 		 	= intval( $params->get( 'loadorder', 1 ) );
		$cat_title 		 	= intval( $params->get( 'cat_title', 0 ) );
		$show_front		 	= intval( $params->get( 'show_front', 0 ) );
		$show_title 	 	= intval( $params->get( 'show_title', 1 ) );
		$title_link 	 	= intval( $params->get( 'title_link', 1 ) );
		$show_author     	= intval( $params->get( 'show_author', 0 ) );
		$show_date 	     	= intval( $params->get( 'show_date', 0 ) );
		$limit 			 	= intval( $params->get( 'limit', 200 ) );
		$fulllink 		 	= $params->get( 'fulllink','' );
		$header_title_links = $params->get( 'header_title_links', "" );
		$columns 			= intval( $params->get( 'columns', 1 ) );
		$count 				= intval( $params->get( 'count', 5 ) );
		$num_intro 			= intval( $params->get( 'num_intro', 1) );

		$thumb_enable 		= 1;
		$thumb_embed 		= intval( $params->get( 'thumb_embed', 0 ) );
		$thumb_width 		= intval( $params->get( 'thumb_width', 32 ) );
		$thumb_height 		= intval( $params->get( 'thumb_height', 32 ) );
		$aspect 			= intval( $params->get( 'aspect', 0 ) );

		$allowed_tags =  "<i><b>"; 

		// please change these here
		$skip = 0; // whether you want skip some items or not
		$sep = " | "; // separator between articles date and creator

		if ($columns > 4) $columns = 4; // limit nmber of columns
		$anotherlink = ( ($count - $num_intro) ==0 ) ? 0 : 1 ;

		if ($order == 0) $orderby = "created";
		else $orderby = "hits";

		// css classes - hardcoded
		$class_date = "minifp-date";
		$class_author = "minifp-date";
		$class_another_links = "minifp-anotherlinks";
		$class_minifulllink = "minifp-full_link";
		$class_introtitle = 'minifp-introtitle';
		$class_categoria = 'minifp-anotherlinks';

		
		// Set the path definitions
		define('MOD_MINIFRONTPAGE_BASE', JPATH_SITE.DS.$params->get('image_path', 'images'.DS.'stories'));
		define('MOD_MINIFRONTPAGE_BASEURL', JURI::base().$params->get('image_path', 'images/stories'));
		
		// if there's no image in an article, give it a default one - change image name here if you have one
		define('MOD_MINIFRONTPAGE_DEFAULT_BASE', JPATH_SITE.DS.$params->get('image_path', 'modules'.DS.'mod_minifrontpage'.DS.'images'));
		define('MOD_MINIFRONTPAGE_DEFAULT_BASEURL', JURI::base().$params->get('image_path', 'modules/mod_minifrontpage/images'));
		define('MOD_MINIFRONTPAGE_DEFAULT_IMAGE', 'default.gif');


$rows = modMiniFrontPageHelper::getList( $params );
require( JModuleHelper::getLayoutPath( 'mod_minifrontpage' ) );


?>