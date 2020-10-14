Attachments for Articles Extension for Joomla 1.5

This extension allows uploaded files to be attached to articles.
It includes options for controlling who can see the attachments
and who can add them.  This extension consists of a plugin and
a component.

Be sure to install the plugin first!

Jonathan Cameron
jmcameron@jmcameron.net (feedback is welcome!)
http://joomlacode.org/gf/project/attachments/

Copyright (C) 2007, 2008 Jonathan M. Cameron, All Rights Reserved
License http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

NOTES:

Once the attachment plugins and component have been installed and the
plugins are enabled, attachments should work.  The default after
installation is for the links to the attachments to be visible to anyone 
that is logged in and for the link to add attachments only to be visible 
to the author of the article.  Both of these options can be changed via 
the attachments parameters which can be changed in the Component manager
administrative back end. (Under 'Components', select 'Article Attachments',
then click on the 'Parameters' button on the right end of the tool bar.)

If your files are sensitive or private, use the secure option since by
default the attachment files are saved in a directory that is publically
inaccessible to anyone that knows the full URL for the attachment file.

Once an attachment is uploaded, it is not visible until it is published.  
To do this, go to the administrative back end and select "Article Attachments"
under the "Components" menu.  This will show a list of attachments and has
controls to publish the attachments.  The option to make attachments
automatically be published after they are uploaded can be changed via the
plugin manager.

Every time a file is uploaded, the existence of the upload subdirectory is
checked and it will be created if if it does not exist.  If the 
'Attachments' extension is unable to create the subdirectory for uploads, 
you must create it yourself (and you may have problems uploading files).  
Make sure to give the subdirectory suitable permissions for uploading files.  
In the Unix/Linux world, that is probably something like 744.

This extension respects the options in the Media Manager regarding what 
types of files can be uploaded.  If you can't attach certain file types 
(such as zip files), go to the "Global Configuration" item under the "Site" 
menu in the administrative back end.  Click on the "System" tab and look for
the "Media Settings" section.  You can add appropriate file extensions or 
mime types there.

This extension supports several languages including English, Chinese
(Simplified and Traditional), Dutch, German, Finnish, Norwegian, Brazilian
Portuguese, and Spanish. If you would like to help translate the extension
to any other language, please contact the author (see above).

The "Add Attachment Button" plugin adds a button to the article editor that
can be clicked to add an attachment.  Note that the button will not be present
when an article is first created since the article must exist for attachments
to be added.

More help is available in the administrative back end.  Select
"Article Attachments" under the "Components" menu.  Click on 
the help icon visible on the right to get more help and to see 
known limitations of this software.

WARNINGS:
  
  * The options have moved from the plugin manager to the component
    manager in the administrative back end.  Under 'Components',
    select 'Article Attachments', then click on the 'Parameters'
    button on the right end of the tool bar.
