<?php
////////////////////////////////////////////////////////////////////
// FILE:         help.html.php
//------------------------------------------------------------------
// PACKAGE:      multidivs
// NAME:         MultiDivs!
// DESCRIPTION:  MultiDivs! ...easily create divs in Joomla!
// VERSION:      1.1.1
// CREATED:      October 2007
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
	$file_root = 'plugins/system/multidivs/elements/';
	$admin_root = 'administrator/';
	/* INCLUDE FILE */ 
	include('adminpopups_1.inc.php');
	/* SET ROOT FOLDER OF THIS FILE AND ADMIN AGAIN! */ 
	$file_root = 'plugins/system/multidivs/elements/';
	$admin_root = 'administrator/';

////////////////////////////////////////////////////////////////////
// DEFINE NEW BODY HTML
////////////////////////////////////////////////////////////////////

	$html .= '
		<h1><img src="../logo.png" height="28" width="103" title="MultiDivs!" alt="MultiDivs!" style="vertical-align: bottom" /> Help Page</h1>
		
		<div style="float: right; padding-top: 10px;">
		<form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr">
			<input type="hidden" value="_s-xclick" name="cmd" /> <input type="image" style="border:0" alt="Make payments with PayPal - it\'s fast, free and secure!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" /> <img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt="" /> <input type="hidden" value="-----BEGIN PKCS7-----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-----END PKCS7-----" name="encrypted" />
		</form>
		</div>
		
		<p>With MultiDivs! you can generate nested div structures very easily anywhere in your content. You can use this for numerous reasons. For instance, to make a box with rounded corners, you may need 4 nested divs...</p>
		<h2>Syntax</h2>
		<p><em>Note: Examples based on Default Classname set to \'quote\'</em><br />
		<em>Note: Note: The colors, tabs and newlines used in these examples are for readability only.</em></p>
		<table cellspacing="1" class="adminlist">
			<tbody>
				<tr>
					<td>Syntax</td>
					<td><span style="color: blue;">{<span>multidivs</span> <span style="color: green;">count classname(s)</span>}<span style="color: grey;">Text</span>{/<span>multidivs</span>}</span></td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>Example 1: No count, no classname</strong></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>multidivs</span>}<span style="color: grey;">Text</span>{/multidivs}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;div <span style="color: green;">class="quote"</span>&gt;<br />
					&#160;&#160;&#160;&#160;<span style="color: grey;">Text</span><br />
					&lt;/div&gt;</span></td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>Example 2: count 4, no classname</strong></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>multidivs</span> <span style="color: green;">4</span>}<span style="color: grey;">Text</span>{/<span>multidivs</span>}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;div <span style="color: green;">class="quote_1"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&lt;div <span style="color: green;">class="quote_2"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&lt;div <span style="color: green;">class="quote_3"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&lt;div <span style="color: green;">class="quote_4"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;<span style="color: grey;">Text</span><br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&lt;/div&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&lt;/div&gt;<br />
					&#160;&#160;&#160;&#160;&lt;/div&gt;<br />
					&lt;/div&gt;</span></td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>Example 3: count 3, classname: myClass</strong></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>multidivs</span> <span style="color: green;">3 myClass</span>}<span style="color: grey;">Text</span>{/<span>multidivs</span>}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;div <span style="color: green;">class="myClass_1"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&lt;div <span style="color: green;">class="myClass_2"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&lt;div <span style="color: green;">class="myClass_3"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;<span style="color: grey;">Text</span><br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&lt;/div&gt;<br />
					&#160;&#160;&#160;&#160;&lt;/div&gt;<br />
					&lt;/div&gt;</span></td>
				</tr>
				<tr class="row1">
					<td colspan="2"><strong>Example 4: count 2, classname: mainClass subClass</strong></td>
				</tr>
				<tr>
					<td>Example</td>
					<td><span style="color: blue;">{<span>multidivs</span> <span style="color: green;">2 mainClass subClass</span>}<span style="color: grey;">Text</span>{/<span>multidivs</span>}</span></td>
				</tr>
				<tr>
					<td>Output</td>
					<td><span style="color: blue;">&lt;div <span style="color: green;">class="mainClass subClass_1"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&lt;div <span style="color: green;">class="mainClass subClass_2"</span>&gt;<br />
					&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;<span style="color: grey;">Text</span><br />
					&#160;&#160;&#160;&#160;&lt;/div&gt;<br />
					&lt;/div&gt;</span></td>
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