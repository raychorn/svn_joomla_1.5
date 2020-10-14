<?php
/**
* @version		$Id: plg_com_virtuemart.php 238 2008-03-08 14:29:41Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* URL structure for categories
* alias/category
*
* URL structure for products
* alias/category/product
*
* TODO: read the virtuemart prefix from the plugin parameters
*/

function virtuemartBuildRoute(&$query)
{
	global $_virtuemart_alias, $_category_aliases, $_page_alias_flypage, $_page_page_alias_browse, $_print_alias, $_page_alias_checkout;
	global $_product_url_structure, $_url_append_product_id, $_page_alias_product_details, $_page_alias_ask, $_page_alias_shop_cart;

	$db =& JFactory::getDBO();

	foreach($query as $parameter => $value ) {
		$query[$parameter] = str_replace('&amp;','', $value);
	}

	// fetch the categories available (read once for performance)
	if ( $_category_aliases == NULL ) {
		$sql = "SELECT c.category_id, c.category_name, x.category_parent_id FROM #__vm_category as c " .
			   " LEFT JOIN #__vm_category_xref as x on c.category_id = x.category_child_id " .
			   " where c.category_publish = 'Y'";
		$db->setQuery( $sql );
		$vm_categories = $db->loadRowList();
		foreach ( $vm_categories as $element) {
			$_category_aliases[$element[0]]->name = $element[1];
			$_category_aliases[$element[0]]->parent_id = $element[2];
		}
	}

	$tmp_query = $query;
	$host = "";
	if (isset($_SERVER['HTTP_HOST'])) {
		$host = $_SERVER['HTTP_HOST'];
	}
	$segments = array();

	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_virtuemart_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_virtuemart'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_virtuemart_alias 				= $params->get( 'url_prefix_path');
			$_product_url_structure 		= $params->get( 'url_structure_product');
			$_url_append_product_id 		= $params->get( 'url_append_product_id');
			$_page_alias_product_details 	= $params->get( 'page_alias_product_details');
			$_page_alias_flypage			= $params->get( 'page_alias_flypage');
			$_page_page_alias_browse		= $params->get( 'page_alias_browse');
			$_page_alias_ask				= $params->get( 'page_alias_ask');
			$_page_alias_manufacturer		= $params->get( 'page_alias_manufacturer');
			$_print_alias					= $params->get( 'print_alias');
			$_page_alias_vendor				= $params->get( 'page_alias_vendor');
			$_page_alias_shop_cart			= $params->get( 'page_alias_shop_cart');
			$_page_alias_checkout			= $params->get( 'page_alias_checkout');


		}
	}

	if ( $_product_url_structure == NULL) {
		// set default if not set (to be sure)
		$_product_url_structure =1;
	}
	if ( empty ( $_page_alias_shop_cart)) {
		$_page_alias_shop_cart = 'shopcart';
	}
	if ( empty ( $_page_alias_checkout)) {
		$_page_alias_checkout = 'checkout';
	}
	if ( $_url_append_product_id == NULL) {
		$_url_append_product_id = 0;
	}

	if (isset($tmp_query['Itemid'])) {
		unset($tmp_query['Itemid']);
	}
	if (isset($tmp_query['option'] )) {
		unset($tmp_query['option']);
	}
	if (isset($query['ssl_redirect'])){
		unset($tmp_query['ssl_redirect']);
		// unset($query['ssl_redirect']);
	}

	// output string is not necessary within the SEF url;
	if (isset($tmp_query['output'] )) {
		unset($tmp_query['output']);
	}
	// check if there is a category set, and set the category path
	$categories_segments = array();
	if (isset($tmp_query['category_id'])) {
       $categories_segments[] = $_category_aliases[$tmp_query['category_id']]->name;
       $parent_id = $_category_aliases[$tmp_query['category_id']]->parent_id;
	    while($parent_id > 0){
			$categories_segments[] = $_category_aliases[$parent_id]->name;
			$parent_id = $_category_aliases[$parent_id]->parent_id;
		}

	}

	if (isset($tmp_query['page']) ) {
		// check if the page parameter is the shop.cart
		if ($tmp_query['page'] == 'shop.cart' ){
			// unset the product_id;
			if ( isset($tmp_query['product_id'] )) {
				unset($tmp_query['product_id'] );
				unset($query['product_id'] );
			}

		}
	}
	if (!empty($_virtuemart_alias)) {
		$segments[] = $_virtuemart_alias;
	}
	if (isset($tmp_query['product_id'])) {
		$db->setQuery ( "SELECT product_name FROM #__vm_product WHERE product_id = " . $tmp_query['product_id'] );
		// thanks to Alien
		$product_name = JFilterOutput::stringURLSafe($db->loadResult());

		switch ( $_product_url_structure ) {
			case 1:
				// structure is URL Prefix/category/product
				if ( isset( $tmp_query['category_id'])) {
					$segments = array_reverse ($categories_segments);
				}
				if ( $_url_append_product_id == 1) {
					$product_name .= ' ' . $tmp_query['product_id'];
				}
				$segments[] = $product_name;
				break;
			case 2:
				// structure is URL Prefix/product
				if ( $_url_append_product_id == 1) {
					$product_name .= ' ' . $tmp_query['product_id'];
				}
				$segments[] = $product_name;
				break;
			case 3:
				// structure is URL Prefix/category/3. alias product_details/product
				if ( isset( $tmp_query['category_id'])) {
					$segments = array_reverse ($categories_segments);
				}
				if ($_page_alias_product_details != NULL) {
					$segments[] = $_page_alias_product_details;
				}
				if ( $_url_append_product_id == 1) {
					$product_name .= ' ' . $tmp_query['product_id'];
				}
				$segments[] = $product_name;
				break;
			case 4:
				// structure is URL Prefix/category/4. alias flypage/product
				if ( isset( $tmp_query['category_id'])) {
					$segments = array_reverse ($categories_segments);
				}
				if ($_page_alias_flypage != NULL) {
					$segments[] = $_page_alias_flypage;
				}
				if ( $_url_append_product_id == 1) {
					$product_name .= ' ' . $tmp_query['product_id'];
				}
				$segments[] = $product_name;
				break;
		}
		if ( isset($tmp_query['page'])) {
			if ( $tmp_query['page'] == 'shop.ask') {
				$segments[] = $_page_alias_ask;
			}
		}
	} elseif (isset($tmp_query['manufacturer_id']) ) {
		// This is the manufacture URL;
		// Set the alias;
		if ( !empty($_page_alias_manufacturer)) {
			$segments[] = $_page_alias_manufacturer;
		}
		// Fetch the manufactor name ;
		if ( $tmp_query['manufacturer_id'] != 0  ) {
			$db->setQuery ( "SELECT mf_name FROM #__vm_manufacturer WHERE manufacturer_id = " . $tmp_query['manufacturer_id'] );
			$segments[] = $db->loadResult();
		}
	} elseif (isset($tmp_query['vendor_id'])) {
		if (!empty($_page_alias_vendor)) {
			$segments[] = $_page_alias_vendor;
		}
		// Fetch the vendor name ;
		$db->setQuery ( "SELECT vendor_name FROM #__vm_vendor WHERE vendor_id = " . $tmp_query['vendor_id'] );
		$segments[] = $db->loadResult();
	}else {
		if ( count($categories_segments)) {
			$segments =  array_merge($segments, array_reverse ($categories_segments));
			unset($tmp_query['category_id']);
		}
		foreach ( $tmp_query as $name => $value) {

			switch ( $name ) {
				case 'flypage':
					if ($value == 'shop.flypage') {
						// check if the alias is set other don't display the field
						if ( $_page_alias_flypage != "" ) {
							$segments[] = $_page_alias_flypage;
						}
					} else {
						$segments[] = str_replace('.',' ',$value);
					}
					break;
				case 'page':
					if ( $value == 'shop.browse') {
						if ( $_page_page_alias_browse != "") {
							$segments[] = $_page_page_alias_browse;
						}
					} elseif ( $value == 'shop.ask') {
						$segments[] = $_page_alias_ask;
					} elseif ( $value == 'shop.cart') {
						$segments[] = $_page_alias_shop_cart;
					} elseif ( $value == 'checkout.index') {
						$segments[] = $_page_alias_checkout;
					}else {
						$segments[] = str_replace('.',' ',$value);
					}
					break;
				case 'redirected':
					$segments[] = 'redirect';
					break;
				default:
					$segments[] = str_replace('.',' ',$value);
					break;
			}

		}
	}
	// check if it's a print is set, use the print alias from the component;
	if ( strpos( $_SERVER['REQUEST_URI'], 'index2.php')) {
		// assign the print template;
		$query['tmpl'] = 'component';
		if (isset($_print_alias)) {
			$segments[] = $_print_alias;
		}
	}
	return $segments;

}


?>