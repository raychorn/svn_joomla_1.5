<?php
/* @version		$Id: changelog.php 238 2008-03-08 14:29:41Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
1. Copyright and disclaimer
---------------------------
This application is opensource software released under the GPL.  Please
see source code and the LICENSE file


2. Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
Joomla! 1.5, including beta and release candidate versions.
Our thanks to all those people who've contributed bug reports and
code fixes.


Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note
-------------------- RC 1.0 release [8 march 2008]--------------------
+ Seperate the 404 handler from the mainrouter into a separate file so custom 404 handlers can be made
^ Support of raw POSTS in the router settings: no redirects for POSTS which solves legacy problems
# large part of the mainrouter is rewritten to support POST redirects and rewrites
# replacement of the &amp; in the URL which cause 404 errors
+ added multiple categories support for virtuemart
# some bugs fixes in the virtuemart plugin: thanks to Alien
-------------------- 1.0.3 BETA release [21 februari 2008]--------------------
+ added the virtuemart plugin (virtuemart 1.1 only)
+ added additional index at the smartsef URL table for optimal performance
# fixed several warnings errors
# fixed the routing for redirecting URL's
# fixed legacy mode issue in regards of CB login (note you must patch CB and the legacy functions of J1.5)
# fixed mailto smartsef plugin default setting
# fixed search smartsef plugin, suporting filters.
+ added support for parameters added to URL by templates (for example the RocketTheme fontstyle setting)
-------------------- 1.0.2 Beta release [11 februari 2008]--------------------
# fixed undefined variables in the mainrouter.php: $_is_post / $cat_path
-------------------- 1.0.2 Beta release [10 februari 2008]--------------------
+ added a priority setting for the SEF order within a priority file for the different URL types;
+ added apply button + purge functionality at the smartsef configuration settings
# Fix the issue that non sef URL request where routed to the root URL
# Fix the plg_mail_to the double //
# Read the parameter alias from the plugins (default plugins)

-------------------- 1.0.1 Beta release [4 februari 2008]---------------------
^ update the smartsef URL repository view (backend admin)
# corrected the filter state of the URL repository  (backend admin)
# bugfix in smartsef plugin: initialized key_string variable which caused a warning.
# bugfix in the mainrouter: correct presentation of the category /section URL structure acording to the configuration settings
  note: the menu alias must be present to guarantee an unique URL.
^ changed the installation SQL into UTF8 encoding, removed the BTREE index.

+ Added Character replacements list within the configuration, allows chars replacements. (thanks to sh404).
+ Added the ability to log 404 errors in a logfile.
+ Added the 'edit' task at an article URL (when the article is editable)