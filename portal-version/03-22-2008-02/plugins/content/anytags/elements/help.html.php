<?php
////////////////////////////////////////////////////////////////////
// FILE:         help.html.php
//------------------------------------------------------------------
// PACKAGE:      anytags
// NAME:         AnyTags!
// DESCRIPTION:  AnyTags! ...place special tags in Joomla!
// VERSION:      2.1.2
// CREATED:      December 2007
// MODIFIED:     March 2008
//------------------------------------------------------------------
// AUTHOR:       NoNumber! (Peter van Westen)
// E-MAIL:       peter@nonumber.nl
// WEBSITE:      http://www.nonumber.nl
//------------------------------------------------------------------
// COPYRIGHT:    (C) 2008-2010 - NoNumber! - All Rights Reserved
// LICENSE:      GNU/GPL  [ http://www.gnu.org/copyleft/gpl.html ]
////////////////////////////////////////////////////////////////////

define( '_JEXEC', 1 );

////////////////////////////////////////////////////////////////////
// INCLUDE FIRST FILE TO SET THE NECESSARY STUF
////////////////////////////////////////////////////////////////////

	/* SET ROOT FOLDER OF THIS FILE AND ADMIN */ 
	$file_root = 'plugins/content/anytags/elements/';
	$admin_root = 'administrator/';
	/* INCLUDE FILE */ 
	include('adminpopups_1.inc.php');
	/* SET ROOT FOLDER OF THIS FILE AND ADMIN AGAIN! */ 
	$file_root = 'plugins/content/anytags/elements/';
	$admin_root = 'administrator/';

////////////////////////////////////////////////////////////////////
// DEFINE NEW BODY HTML
////////////////////////////////////////////////////////////////////

	$html .= '
		<h1><img src="../logo.png" height="28" width="98" title="AnyTags!" alt="AnyTags!" style="vertical-align: bottom" /> Help Page</h1>
		
		<div style="float: right; padding-top: 10px;">
		<form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr">
			<input type="hidden" value="_s-xclick" name="cmd" /> <input type="image" style="border:0" alt="Make payments with PayPal - it\'s fast, free and secure!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" /> <img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt="" /> <input type="hidden" value="-----BEGIN PKCS7-----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-----END PKCS7-----" name="encrypted" />
		</form>
		</div>
		
		<p>AnyTags! enables you to place <b>any kind of HTML tag, PHP, JavaScript and CSS</b> right in to your articles!</p>
		<p>Most Joomla! Text Editors will strip any special kind of tags, like script tags. With AnyTags! you won\'t have these limitations.</p>
		<h2>Security Level</h2>
		<p>For the obvious security reasons, AnyTags! will only work on Articles created or modified by Back-End users. You can set the Security Level you want. For PHP you can set the Security Level separately (but can\'t be lower than the overall Security Level).</p>
		<h2>Syntax</h2>
		<p><em>Note: The colors used in these examples are for readability only.</em></p>
		<table cellspacing="1" class="adminlist">
			<tbody>
				<tr class="row1">
					<td colspan="2"><strong>HTML tags</strong></td>
				</tr>
				<tr>
					<td>Normal Syntax</td>
					<td><span style="color: blue;">{<span>anytags</span> <span style="color: green;">tagname</span> <span style="color: red;">attributes</span>}<span style="color: grey;">Text</span>{/<span>anytags</span> <span style="color: green;">tagname</span>}</span></td>
				</tr>
				<tr>
					<td>Asterisk Syntax</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">tagname</span> <span style="color: red;">attributes</span>}<span style="color: grey;">Text</span>{/<span>*</span> <span style="color: green;">tagname</span>}</span></td>
				</tr>
				<tr>
					<td>End Tag Syntax</td>
					<td>Both <span style="color: blue;">{/<span>*</span> <span style="color: green;">tagname</span>}</span> and <span style="color: blue;">{<span>*</span> <span style="color: green;">/tagname</span>}</span> work.</td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;<span style="color: green;">tagname</span> <span style="color: red;">attributes</span>&gt;<span style="color: grey;">Text</span>&lt;/<span style="color: green;">tagname</span>&gt;</span></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">span</span> <span style="color: red;">style="color:red;"</span>}<span style="color: grey;">This text will be displayed in red!</span>{/<span>*</span> <span style="color: green;">span</span>}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;<span style="color: green;">span</span> <span style="color: red;">style="color:red;"</span>&gt;<span style="color: grey;">This text will be displayed in red!</span>&lt;/<span style="color: green;">span</span>&gt;</span></td>
				</tr>
				<tr>
					<td></td>
					<td>In the following examples the Asterisk Sytax is used.</td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>PHP</strong></td>
				</tr>
				<tr>
					<td>Syntax</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">php</span>}<span style="color: red;">code</span>{/<span>*</span> <span style="color: green;">tagname</span>}</span></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">php</span>}<br />
						<span style="color: red;">
						&nbsp;&nbsp;&nbsp;&nbsp;echo \'Today is a \'.date("l");
						</span><br />
						{/<span>*</span> <span style="color: green;">php</span>}</span></td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>JavaScript</strong> (you can use the tagname: <span style="color: green;">js</span> or <span style="color: green;">javascript</span>)</td>
				</tr>
				<tr>
					<td>Syntax</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">js</span>}<span style="color: red;">script</span>{/<span>*</span> <span style="color: green;">php</span>}</span></td>
				</tr>
				<tr>
					<td>Example</td>
				<td><span style="color: blue;">{<span>*</span> <span style="color: green;">js</span>}<br />
					<span style="color: red;">
					&nbsp;&nbsp;&nbsp;&nbsp;alert(\'Never use alerts... they are very irritating!\');
					</span><br />
					{/<span>*</span> <span style="color: green;">js</span>}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;<span style="color: green;">script type="text/javascript"</span>&gt;<br />
						<span style="color: grey;">&lt;!--</span><br />
						&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: red;">alert(\'Never use alerts... they are very irritating!\');</span><br />
						<span style="color: grey;">--&gt;</span><br />
						&lt;/<span style="color: green;">script</span>&gt;</span></td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>CSS</strong> (you can use the tagname: <span style="color: green;">css</span> or <span style="color: green;">style</span>)</td>
				</tr>
				<tr>
					<td>Single Tag Syntax</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">css</span>|<span style="color: red;">styles</span>}</span></td>
				</tr>
				<tr>
					<td>Syntax</td>
				<td><span style="color: blue;">{<span>*</span> <span style="color: green;">css</span>}<span style="color: red;">styles</span>{/<span>*</span> <span style="color: green;">css</span>}</span></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>*</span> <span style="color: green;">css</span>}<br />
						<span style="color: red;">
						&nbsp;&nbsp;&nbsp;&nbsp;body {<br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;background-color: black;<br />
						&nbsp;&nbsp;&nbsp;&nbsp;}
						</span><br />
						{/<span>*</span> <span style="color: green;">css</span>}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;<span style="color: green;">style type="text/css"</span>&gt;<br />
						<span style="color: red;">
						&nbsp;&nbsp;&nbsp;&nbsp;body {<br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;background-color: black;<br />
						&nbsp;&nbsp;&nbsp;&nbsp;}
						</span><br />
						&lt;/<span style="color: green;">style</span>&gt;</span></td>
				</tr>
			</tbody>
		</table>
	';

////////////////////////////////////////////////////////////////////
// INCLUDE SECOND FILE TO OUTPUT PAGE
////////////////////////////////////////////////////////////////////

	include('adminpopups_2.inc.php');

////////////////////////////////////////////////////////////////////
?>