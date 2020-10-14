/* 
 *  FCKPlugin.js
 *  ------------
 *  This is a generic file which is needed for plugins that are developed
 *  for FCKEditor. With the below statements that toolbar is created and
 *  several options are being activated.
 *
 *  See the online documentation for more information:
 *  http://wiki.fckeditor.net/
 */

// Register the related commands.
FCKCommands.RegisterCommand(
	'JoomlaContent',
	new FCKDialogCommand(
		'JoomlaContent',
		'Insert Joomla Content Item Link',
		FCKPlugins.Items['JoomlaContent'].Path + 'fck_joomlacontent.php',
		400,
		300
	)
);
 
// Create the "JoomlaContent" toolbar button.
// FCKToolbarButton( commandName, label, tooltip, style, sourceView, contextSensitive )
var oJoomlaContentItem = new FCKToolbarButton( 'JoomlaContent', 'Insert Joomla Content Item Link', null, null, false, true ); 
oJoomlaContentItem.IconPath = FCKConfig.PluginsPath + 'JoomlaContent/joomlacontent.gif'; 

// 'JoomlaContent' is the name that is used in the toolbar config.
FCKToolbarItems.RegisterItem( 'JoomlaContent', oJoomlaContentItem );