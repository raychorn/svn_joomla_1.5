<?PHP
/**
 * Base class for patTemplate template cache
 *
 * $Id: TemplateCache.php 8287 2007-08-01 08:38:59Z eddieajau $
 *
 * A template cache is used to cache the data after
 * the template has been read, but before the variables
 * have been added.
 *
 * Data is normally stored in serialized format. This
 * will increase performance.
 *
 * This is not related to an output cache!
 *
 * @package		patTemplate
 * @subpackage	Caches
 * @author		Stephan Schmidt <schst@php.net>
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Base class for patTemplate template cache
 *
 * $Id: TemplateCache.php 8287 2007-08-01 08:38:59Z eddieajau $
 *
 * A template cache is used to cache the data after
 * the template has been read, but before the variables
 * have been added.
 *
 * Data is normally stored in serialized format. This
 * will increase performance.
 *
 * This is not related to an output cache!
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Caches
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_TemplateCache extends patTemplate_Module
{
	/**
	* load template from cache
	*
	* @access	public
	* @param	string			cache key
	* @param	integer			modification time of original template
	* @return	array|boolean	either an array containing the templates or false cache could not be loaded
	*/
	function load( $key, $modTime = -1 )
	{
		return false;
	}

	/**
	* write template to cache
	*
	* @access	public
	* @param	string		cache key
	* @param	array		templates to store
	*/
	function write( $key, $templates )
	{
		return true;
	}

	/**
	* get the cache key for the input
	*
	* @param	mixed	input to read from.
	*					This can be a string, a filename, a resource or whatever the derived class needs to read from
	* @param	array	options
	* @return	string	key
	*/
	function getKey( $input, $options = array() )
	{
		return	md5( $input . serialize( $options ) );
	}
}
?>
