<!-- mod_dbrss version 2.2.8
original code from DHTMLgoodies
mod_dbrss2.php 
last Modified 19 Feb 2007	
add new feed control added.
15 Feb - modified browser check
13 Feb 2007 Added Safari fix from Stan Orr
readRSS.php last Modified 3 Dec 2006
-->
<?php
/*
mod_dbrss version 2.2.8
original code from DHTMLgoodies
mod_dbrss2.php 
last Modified 19 Feb 2007	
add new feed control added.
15 Feb - modified browser check
13 Feb 2007 Added Safari fix from Stan Orr
readRSS.php last Modified 3 Dec 2006

*/
//ini_set("display_errors",0);

defined( '_VALID_MOS' ) or die( 'Restricted access' );
	$setcolumns = $params->get('columns');
	$moveable = $params->get('moveable');
	$cookie = $params->get('cookie');
	$cookiename = $params->get('pagecookie');
	$bannercolor = $params ->get('bannercolor');
	$bannerfont = $params->get('bannerfont');
	$feedfont = $params->get('feedfont');
	$feedbgcolor = $params->get('feedbgcolor');
	$tooltipx = $params->get('tooltipx');
	$tooltipy = $params->get('tooltipy');
	if ($cookie =="0") { $cookie ="false"; } else { $cookie = "true"; }
	
	$url1 = $params->get( 'target1');
	$url2 = $params->get( 'target2');
	$url3 = $params->get( 'target3');
	$url4 = $params->get( 'target4');
	$url5 = $params->get( 'target5');
	$url6 = $params->get( 'target6');
	$url7 = $params->get( 'target7');
	$url8 = $params->get( 'target8');

	
	if ($setcolumns == '1' ) {
	$pos1 = 1;
	$pos2 = 1;
	$pos3 = 1;
	$pos4 = 1;
	$pos5 = 1;
	$pos6 = 1;
	$pos7 = 1;
	$pos8 = 1;	
	
	}	else	{			
	$pos1=$params->get('position1');
	$pos2=$params->get('position2');
	$pos3=$params->get('position3');
	$pos4=$params->get('position4');
	$pos5=$params->get('position5');
	$pos6=$params->get('position6'); 
	$pos7=$params->get('position7'); 
	$pos8=$params->get('position8'); 
	}

	$refresh1=$params->get('refresh1');
	$refresh2=$params->get('refresh2');
	$refresh3=$params->get('refresh3');
	$refresh4=$params->get('refresh4');
	$refresh5=$params->get('refresh5');
	$refresh6=$params->get('refresh6');
	$refresh7=$params->get('refresh7');
	$refresh8=$params->get('refresh8');

	$height1=$params->get('height1'); if (!$height1) {$height1='150';}
	$height2=$params->get('height2'); if (!$height2) {$height2='150';}
	$height3=$params->get('height3'); if (!$height3) {$height3='150';}
	$height4=$params->get('height4'); if (!$height4) {$height4='150';}
	$height5=$params->get('height5'); if (!$height5) {$height5='150';}
	$height6=$params->get('height6'); if (!$height6) {$height6='150';}
	$height7=$params->get('height7'); if (!$height7) {$height7='150';}
	$height8=$params->get('height8'); if (!$height8) {$height8='150';}

	$items1=$params->get('item1'); if (!$items1) {$items1='50';}
	$items2=$params->get('item2'); if (!$items2) {$items2='50';}
	$items3=$params->get('item3'); if (!$items3) {$items3='50';}
	$items4=$params->get('item4'); if (!$items4) {$items4='50';}
	$items5=$params->get('item5'); if (!$items5) {$items5='50';}
	$items6=$params->get('item6'); if (!$items6) {$items6='50';}
	$items7=$params->get('item7'); if (!$items7) {$items7='50';}
	$items8=$params->get('item8'); if (!$items8) {$items8='50';}

	$tooltip=$params->get('tooltip'); if ($tooltip == "No" ) {$tooltip = "";}
	$tooltipconvert=$params->get('tooltipconvert'); if ($tooltipconvert == "No" ) {$tooltipconvert = "";}
	$addnewfeed = $params->get('addnew'); if ($addnewfeed == "No" ) {$addnewfeed = "";}

	/* For Future Use 
	$tooltip1=$params->get('tooltip1'); if ($tooltip1 == "No" ) {$tooltip1 = "";}
	$tooltip2=$params->get('tooltip2'); if ($tooltip2 == "No" ) {$tooltip2 = "";}
	$tooltip3=$params->get('tooltip3'); if ($tooltip3 == "No" ) {$tooltip3 = "";}
	$tooltip4=$params->get('tooltip4'); if ($tooltip4 == "No" ) {$tooltip4 = "";}
	$tooltip5=$params->get('tooltip5'); if ($tooltip5 == "No" ) {$tooltip5 = "";}
	$tooltip6=$params->get('tooltip6'); if ($tooltip6 == "No" ) {$tooltip6 = "";}
	$tooltip7=$params->get('tooltip7'); if ($tooltip7 == "No" ) {$tooltip7 = "";}
	$tooltip8=$params->get('tooltip8'); if ($tooltip8 == "No" ) {$tooltip8 = "";} */
	
	

?>
<?php $tip=1; ?>
<meta name="keywords" content="mod_dbrss,mod_dbrss2,AJAX RSS Reader,dbrss2,poweredbysimplepie,joomla,PHP augusta" />
<span style="display:none;">mod_dbrss2 AJAX RSS Reader poweredbysimplepie</span>
	<style type="text/css">
#mainContainer{
		width:100%;
		margin:0 auto;
		text-align:left;
		height:100%;		
		padding-bottom:30px;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
	}

	.dragableBox{	/* The RSS box */
		border:1px solid #317082;
		background-color:<?php echo $feedbgcolor;?>;
		margin:5px;
	}
	.dragableBoxHeader{	/* Header inside RSS box */
		background-color: <?php echo $bannercolor;?> ;
		height:20px;
		font-weight:bold;
		color: <?php echo $bannerfont;?> ;
		margin-bottom:2px;

	}
	.dragableBoxHeader span{	/* Text inside header of RSS box */
		text-indent:5px;
		height:20px;
		line-height:20px;
	}
	.dragableBoxHeader img,.dragableBoxHeader span{	/* Text and reload image inside RSS box */
		float:left;
	}
	.boxItemHeader{	/* Title of items inside dragable boxes */
		font-weight:bold;
		margin:0px;
		color:#000;
		text-decoration:none;
		overflow:hidden;
	}	
	.boxItemHeader:hover{	/* Title of items inside dragable boxes - mouseover*/
		font-weight:bold;
		margin:0px;
		color:#F00;
		text-decoration:underline;
	}
	.dragableBoxHeader input{	/* text inputs that gets visible when you click on the "edit" link at the top of a rss box */
		font-size:10px;	
	}
	
	.rssNumberOfItems{	/* Number of RSS items in header - the one inside parantheses */
		color:#F00;
		text-align:right;
	}
	.dragableBoxContent{	/* DIV holding data inside dragable boxes */
		padding:3px;
		clear:both;
		background-color:<?php echo $feedbgcolor;?>;
	}
	.dragableBoxContent a{	/* DIV holding data inside dragable boxes */
		color:<?php echo $feedfont;?>;
		background-color:<?php echo $feedbgcolor;?>;
		
	}
	.dragableBoxContent p{	/* DIV holding data inside dragable boxes */
		color:<?php echo $feedfont;?>;
		background-color:<?php echo $feedbgcolor;?>;
		
	}
	.dragableBoxContent img{	/* DIV holding data inside dragable boxes */
		color:<?php echo $feedfont;?>;
		background-color:<?php echo $feedbgcolor;?>;
		
	}
	
		
	#rectangleDiv{	/* Dotted rectangle indicating where objects will be dropped */
		border:1px dotted red;
		margin:5px;
	}
	
	.closeButton{	/* Close button */
		padding:2px;
		border:1px solid #317082;
		line-height:9px;
		height:9px;
		margin:2px;
		color:#317082;
		padding:2px;
		padding-bottom:3px;
	}
	.closeButton_over{	/* Close button - mouse over */
		padding:2px;
		border:1px solid #317082;
		line-height:9px;
		padding:2px;
		padding-bottom:3px;
		margin:2px;	
		background-color:#317082;
		color:#FFF;
	}
	.dragableBoxStatusBar{	/* Status bar at the bottom of rss boxes */
		border-top:3px double #317082;
		height:12px;
		background-color: <?php echo $bannercolor;?>;
		color:<?php echo $bannerfont;?>;
		padding:2px;
		margin:1px;
		display:none;
	}
	
	.dragableBoxEditLink{	/* Edit link on top of a box */
		color:#317082;
		text-decoration:none;
		padding-top:1px;
	}
	.dragableBoxEditLink:hover{	/* Edit link - mouse over */
		color:red;
		text-decoration:underline;
	}
	form{	/* No borders in forms */
		display:inline;
		color:#000000;
	}
	#addNewFeed{	/* The white box at the top right corner where you can add a new RSS feed */
		float:right;
		width:300px;
		background-color:#FFF;
		border:2px solid #317082;
		padding:2px;
		margin-right:2px;
		margin-top:2px;
	}
	
	img{
		border:0px;
		}
	/* CSS needed for the tooltip script */
/* Last-Modified: 29/10/06 00:08:22 */

#dhtmltooltip{
position: absolute;
width: 450px;
height:300px;
min-height:200px;
max-height:700px;
overflow:auto;
border: 2px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 2000;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);

}
/* Browser specific (not valid) styles to make preformatted text wrap */
pre {
 white-space: pre-wrap;       /* css-3 */
 white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
 white-space: -pre-wrap;      /* Opera 4-6 */
 white-space: -o-pre-wrap;    /* Opera 7 */
 word-wrap: break-word;       /* Internet Explorer 5.5+ */
}
	</style>		
	
	<script type="text/javascript" src="./modules/js/ajax.js"></script>
	
<div id="dhtmltooltip"></div>
<script type="text/javascript">
/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=<?php echo $tooltipx;?> //Customize x offset of tooltip
var offsetypoint=<?php echo $tooltipy;?> //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML="<div style=\"background-color:#CCCCCC\"><a href=\"javascript:hideddrivetip();\" style=\"color:#FF0000;text-align:right\">CLOSE</a><br /></div>"+thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().curY+offsetypoint+"px" : window.curY+offsetypoint+offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onclick=positiontip
</script>
<script type="text/javascript">
/**
 * stringFunctions.js
 *
 * This file contains a collection of string functions for javascript.
 * Most of them are inspired by their PHP equivalent.
 *
 * This source file is subject to version 2.1 of the GNU Lesser
 * General Public License (LPGL), found in the file LICENSE that is
 * included with this package, and is also available at
 * http://www.gnu.org/copyleft/lesser.html.
 * @package     Javascript
 *
 * @author      Dieter Raber <dieter@dieterraber.net>
 * @copyright   2004-12-27
 * @version     1.0
 * @license     http://www.gnu.org/copyleft/lesser.html
 *
 */

/**
 * TOC
 *
 * - hex2rgb
 * - htmlentities
 * - numericEntities
 * - trim
 * - ucfirst
 * - strPad
 */

/**
 * hex2rgb
 *
 * Convert hexadecimal color triplets to RGB
 *
 * Expects an hexadecimal color triplet (case insensitive)
 * Returns an array containing the decimal values
 * for r, g and b.
 *
 * example:
 *   test = 'ff0033'
 *   test.hex2rgb() //returns the array (255,00,51)
 */

String.prototype.hex2rgb = function()
{
  var red, green, blue;
  var triplet = this.toLowerCase().replace(/#/, '');
  var rgbArr  = new Array();

  if(triplet.length == 6)
  {
    rgbArr[0] = parseInt(triplet.substr(0,2), 16)
    rgbArr[1] = parseInt(triplet.substr(2,2), 16)
    rgbArr[2] = parseInt(triplet.substr(4,2), 16)
    return rgbArr;
  }
  else if(triplet.length == 3)
  {
    rgbArr[0] = parseInt((triplet.substr(0,1) + triplet.substr(0,1)), 16);
    rgbArr[1] = parseInt((triplet.substr(1,1) + triplet.substr(1,1)), 16);
    rgbArr[2] = parseInt((triplet.substr(2,2) + triplet.substr(2,2)), 16);

    return rgbArr;
  }
  else
  {
    throw triplet + ' is not a valid color triplet.';
  }
}


/**
 * htmlEntities
 *
 * Convert all applicable characters to HTML entities
 *
 * object string
 * return string
 *
 * example:
 *   test = 'äöü'
 *   test.htmlEntities() //returns '&auml;&ouml;&uuml;'
 */

String.prototype.htmlEntities = function()
{
  var chars = new Array ('&','à','á','â','ã','ä','å','æ','ç','è','é',
                         'ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô',
                         'õ','ö','ø','ù','ú','û','ü','ý','þ','ÿ','À',
                         'Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë',
                         'Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö',
                         'Ø','Ù','Ú','Û','Ü','Ý','Þ','€','\"','ß','<',
                         '>','¢','£','¤','¥','¦','§','¨','©','ª','«',
                         '¬','­','®','¯','°','±','²','³','´','µ','¶',
                         '·','¸','¹','º','»','¼','½','¾');

  var entities = new Array ('amp','agrave','aacute','acirc','atilde','auml','aring',
                            'aelig','ccedil','egrave','eacute','ecirc','euml','igrave',
                            'iacute','icirc','iuml','eth','ntilde','ograve','oacute',
                            'ocirc','otilde','ouml','oslash','ugrave','uacute','ucirc',
                            'uuml','yacute','thorn','yuml','Agrave','Aacute','Acirc',
                            'Atilde','Auml','Aring','AElig','Ccedil','Egrave','Eacute',
                            'Ecirc','Euml','Igrave','Iacute','Icirc','Iuml','ETH','Ntilde',
                            'Ograve','Oacute','Ocirc','Otilde','Ouml','Oslash','Ugrave',
                            'Uacute','Ucirc','Uuml','Yacute','THORN','euro','quot','szlig',
                            'lt','gt','cent','pound','curren','yen','brvbar','sect','uml',
                            'copy','ordf','laquo','not','shy','reg','macr','deg','plusmn',
                            'sup2','sup3','acute','micro','para','middot','cedil','sup1',
                            'ordm','raquo','frac14','frac12','frac34');

  newString = this;
  for (var i = 0; i < chars.length; i++)
  {
    myRegExp = new RegExp();
    myRegExp.compile(chars[i],'g')
    newString = newString.replace (myRegExp, '&' + entities[i] + ';');
  }
  return newString;
}


/**
 * numericEntities
 *
 * Convert all applicable characters to numeric entities
 *
 * object string
 * return string
 *
 * example:
 *   test = 'äöü'
 *   test.numericEntities() //returns '&#228;&#246;&#252;'
 */

String.prototype.numericEntities = function()
{
  var i;
  var chars = new Array ('&','à','á','â','ã','ä','å','æ','ç','è','é',
                         'ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô',
                         'õ','ö','ø','ù','ú','û','ü','ý','þ','ÿ','À',
                         'Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë',
                         'Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö',
                         'Ø','Ù','Ú','Û','Ü','Ý','Þ','€','\"','ß','<',
                         '>','¢','£','¤','¥','¦','§','¨','©','ª','«',
                         '¬','­','®','¯','°','±','²','³','´','µ','¶',
                         '·','¸','¹','º','»','¼','½','¾');

  var entities = new Array()
  for (i = 0; i < chars.length; i++)
  {
    entities[i] = chars[i].charCodeAt(0);
  }

  newString = this;
  for (i = 0; i < chars.length; i++)
  {
    myRegExp = new RegExp();
    myRegExp.compile(chars[i],'g')
    newString = newString.replace (myRegExp, '&#' + entities[i] + ';');
  }
  return newString;
}



/**
 * trim
 *
 * Strip whitespace from the beginning and end of a string
 *
 * object string
 * return string
 *
 * example:
 *   test = '\nsomestring\n\t\0'
 *   test.trim()  //returns 'somestring'
 */
String.prototype.trim = function()
{
  return this.replace(/^\s*([^ ]*)\s*$/, "$1");
}


/**
 * ucfirst
 *
 * Returns a string with the first character capitalized,
 * if that character is alphabetic.
 *
 * object string
 * return string
 *
 * example:
 *   test = 'john'
 *   test.ucfirst() //returns 'John'
 */

String.prototype.ucfirst = function()
{
  firstLetter = this.charCodeAt(0);
  if((firstLetter >= 97 && firstLetter <= 122)
     || (firstLetter >= 224 && firstLetter <= 246)
     || (firstLetter >= 249 && firstLetter <= 254))
  {
    firstLetter = firstLetter - 32;
  }
  alert(firstLetter)
  return String.fromCharCode(firstLetter) + this.substr(1,this.length -1)
}


/**
 * strPad
 *
 * Pad a string to a certain length with another string
 *
 * This functions returns the input string padded on the left, the right, or both sides
 * to the specified padding length. If the optional argument pad_string is not supplied,
 * the output is padded with spaces, otherwise it is padded with characters from pad_string
 * up to the limit.
 *
 * The optional argument pad_type can be STR_PAD_RIGHT, STR_PAD_LEFT, or STR_PAD_BOTH.
 * If pad_type is not specified it is assumed to be STR_PAD_RIGHT.
 *
 * If the value of pad_length is negative or less than the length of the input string,
 * no padding takes place.
 *
 * object string
 * return string
 *
 * examples:
 *   var input = 'foo';
 *   input.strPad(9);                      // returns "foo      "
 *   input.strPad(9, "*+", STR_PAD_LEFT);  // returns "*+*+*+foo"
 *   input.strPad(9, "*", STR_PAD_BOTH);   // returns "***foo***"
 *   input.strPad(9 , "*********");        // returns "foo******"
 */

var STR_PAD_LEFT  = 0;
var STR_PAD_RIGHT = 1;
var STR_PAD_BOTH  = 2;

String.prototype.strPad = function(pad_length, pad_string, pad_type)
{
  /* Helper variables */
  var num_pad_chars   = pad_length - this.length;/* Number of padding characters */
  var result          = '';                       /* Resulting string */
  var pad_str_val     = ' ';
  var pad_str_len     = 1;                        /* Length of the padding string */
  var pad_type_val    = STR_PAD_RIGHT;            /* The padding type value */
  var i               = 0;
  var left_pad        = 0;
  var right_pad       = 0;
  var error           = false;
  var error_msg       = '';
  var output           = this;

  if (arguments.length < 2 || arguments.length > 4)
  {
    error     = true;
    error_msg = "Wrong parameter count.";
  }


  else if(isNaN(arguments[0]) == true)
  {
    error     = true;
    error_msg = "Padding length must be an integer.";
  }
  /* Setup the padding string values if specified. */
  if (arguments.length > 2)
  {
    if (pad_string.length == 0)
    {
      error     = true;
      error_msg = "Padding string cannot be empty.";
    }
    pad_str_val = pad_string;
    pad_str_len = pad_string.length;

    if (arguments.length > 3)
    {
      pad_type_val = pad_type;
      if (pad_type_val < STR_PAD_LEFT || pad_type_val > STR_PAD_BOTH)
      {
        error     = true;
        error_msg = "Padding type has to be STR_PAD_LEFT, STR_PAD_RIGHT, or STR_PAD_BOTH."
      }
    }
  }

  if(error) throw error_msg;

  if(num_pad_chars > 0 && !error)
  {
    /* We need to figure out the left/right padding lengths. */
    switch (pad_type_val)
    {
      case STR_PAD_RIGHT:
        left_pad  = 0;
        right_pad = num_pad_chars;
        break;

      case STR_PAD_LEFT:
        left_pad  = num_pad_chars;
        right_pad = 0;
        break;

      case STR_PAD_BOTH:
        left_pad  = Math.floor(num_pad_chars / 2);
        right_pad = num_pad_chars - left_pad;
        break;
    }

    for(i = 0; i < left_pad; i++)
    {
      output = pad_str_val.substr(0,num_pad_chars) + output;
    }

    for(i = 0; i < right_pad; i++)
    {
      output += pad_str_val.substr(0,num_pad_chars);
    }
  }

  return output;
}

</script>







		<script type="text/javascript">
/*
	***********************************************************************************************************
	(C) www.dhtmlgoodies.com, January 2006
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Version:	1.0	: January 16th - 2006
				1.1 : January 31th - 2006 - Added cookie support - remember rss sources
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	*********************************************************************************************************** 
*/		
	/* USER VARIABLES */
	url1 = '<?php echo $url1;?>';
	url2 = '<?php echo $url2;?>';
	url3 = '<?php echo $url3;?>';
	url4 = '<?php echo $url4;?>';
	url5 = '<?php echo $url5;?>';
	url6 = '<?php echo $url6;?>';
	url7 = '<?php echo $url7;?>';
	url8 = '<?php echo $url8;?>'; 
	moveable = '<?php echo $moveable;?>';
	cookie = '<?php echo $cookie;?>';
	//alert(cookie);

	var numberOfColumns = <?php echo $setcolumns; ?>;	// Number of columns for dragable boxes
	var columnParentBoxId = 'floatingBoxParentContainer';	// Id of box that is parent of all your dragable boxes
	var src_rightImage = 'modules/images/arrow_right.gif';
	var src_downImage = 'modules/images/arrow_down.gif';
	var src_refreshSource = 'modules/images/refresh.gif';
	var src_smallRightArrow = 'modules/images/small_arrow.gif';
	
	var transparencyWhenDragging = false;
	var txt_editLink = 'Edit';
	var txt_editLink_stop = 'End edit';
	var autoScrollSpeed = 4;	// Autoscroll speed	- Higher = faster	
	var dragObjectBorderWidth = 1;	// Border size of your RSS boxes - used to determine width of dotted rectangle
	
	var useCookiesToRememberRSSSources = <?php echo $cookie;?>;
	
	var nameOfCookie = '<?php echo $cookiename;?>';	// Name of cookie
	
/* END USER VARIABLES */

	var columnParentBox;

	var dragableBoxesObj;

	

	var ajaxObjects = new Array();

	

	var boxIndex = 0;	

	var autoScrollActive = false;

	var dragableBoxesArray = new Array();

	

	var dragDropCounter = -1;

	var dragObject = false;

	var dragObjectNextSibling = false;

	var dragObjectParent = false;

	var destinationObj = false;

	

	var mouse_x;

	var mouse_y;

	

	var el_x;

	var el_y;	

	

	var rectangleDiv;

	var okToMove = true;



	var documentHeight = false;

	var documentScrollHeight = false;

	var dragableAreaWidth = false;

	var opera = navigator.userAgent.toLowerCase().indexOf('opera')>=0?true:false;
	var konqueror = navigator.userAgent.toLowerCase().indexOf('konqueror')>=0?true:false;
	var safari = navigator.userAgent.toLowerCase().indexOf('macintosh')>=0?true:false;


	var cookieCounter=0;

	var cookieRSSSources = new Array();

	

	var staticObjectArray = new Array();

	

	/*

	These cookie functions are downloaded from 

	http://www.mach5.com/support/analyzer/manual/html/General/CookiesJavaScript.htm

	*/	

	function Get_Cookie(name) { 

	   var start = document.cookie.indexOf(name+"="); 

	   var len = start+name.length+1; 

	   if ((!start) && (name != document.cookie.substring(0,name.length))) return null; 

	   if (start == -1) return null; 

	   var end = document.cookie.indexOf(";",len); 

	   if (end == -1) end = document.cookie.length; 

	   return unescape(document.cookie.substring(len,end)); 

	} 

	// This function has been slightly modified

	function Set_Cookie(name,value,expires,path,domain,secure) { 

		expires = expires * 60*60*24*1000;

		var today = new Date();

		var expires_date = new Date( today.getTime() + (expires) );

	    var cookieString = name + "=" +escape(value) + 

	       ( (expires) ? ";expires=" + expires_date.toGMTString() : "") + 

	       ( (path) ? ";path=" + path : "") + 

	       ( (domain) ? ";domain=" + domain : "") + 

	       ( (secure) ? ";secure" : ""); 

	    document.cookie = cookieString; 

	} 



	function autoScroll(direction,yPos)

	{

		if(document.documentElement.scrollHeight>documentScrollHeight && direction>0)return;

		if(opera)return;

		window.scrollBy(0,direction);

		if(!dragObject)return;

		

		if(direction<0){

			if(document.documentElement.scrollTop>0){

				dragObject.style.top = (el_y - mouse_y + yPos + document.documentElement.scrollTop) + 'px';		

			}else{

				autoScrollActive = false;

			}

		}else{

			if(yPos>(documentHeight-50)){	

				dragObject.style.top = (el_y - mouse_y + yPos + document.documentElement.scrollTop) + 'px';			

			}else{

				autoScrollActive = false;

			}

		}

		if(autoScrollActive)setTimeout('autoScroll('+direction+',' + yPos + ')',5);

	}

		

	function initDragDropBox(e)

	{

		

		

		dragDropCounter = 1;

		if(document.all)e = event;

		

		if (e.target) source = e.target;

			else if (e.srcElement) source = e.srcElement;

			if (source.nodeType == 3) // defeat Safari bug

				source = source.parentNode;

		

		if(source.tagName.toLowerCase()=='img' || source.tagName.toLowerCase()=='a' || source.tagName.toLowerCase()=='input' || source.tagName.toLowerCase()=='td' || source.tagName.toLowerCase()=='tr' || source.tagName.toLowerCase()=='table')return;

		

	

		mouse_x = e.clientX;

		mouse_y = e.clientY;	

		var numericId = this.id.replace(/[^0-9]/g,'');

		el_x = getLeftPos(this.parentNode.parentNode)/1;

		el_y = getTopPos(this.parentNode.parentNode)/1 - document.documentElement.scrollTop;

			

		dragObject = this.parentNode.parentNode;

		

		documentScrollHeight = document.documentElement.scrollHeight + 100 + dragObject.offsetHeight;

		

		

		if(dragObject.nextSibling){

			dragObjectNextSibling = dragObject.nextSibling;

			if(dragObjectNextSibling.tagName!='DIV')dragObjectNextSibling = dragObjectNextSibling.nextSibling;

		}

		dragObjectParent = dragableBoxesArray[numericId]['parentObj'];

			

		dragDropCounter = 0;

		initDragDropBoxTimer();	

		

		return false;

	}

	

	

	function initDragDropBoxTimer()

	{

		if(dragDropCounter>=0 && dragDropCounter<10){

			dragDropCounter++;

			setTimeout('initDragDropBoxTimer()',10);

			return;

		}

		if(dragDropCounter==10){

			mouseoutBoxHeader(false,dragObject);

		}

		

	}



	function moveDragableElement(e){

		if(document.all)e = event;

		if(dragDropCounter<10)return;

		

		if(document.all && e.button!=1 && !opera){

			stop_dragDropElement();

			return;

		}

		

		if(document.body!=dragObject.parentNode){

			dragObject.style.width = (dragObject.offsetWidth - (dragObjectBorderWidth*2)) + 'px';

			dragObject.style.position = 'absolute';	

			dragObject.style.textAlign = 'left';

			if(transparencyWhenDragging){	

				dragObject.style.filter = 'alpha(opacity=70)';

				dragObject.style.opacity = '0.7';

			}	

			dragObject.parentNode.insertBefore(rectangleDiv,dragObject);

			rectangleDiv.style.display='block';

			document.body.appendChild(dragObject);



			rectangleDiv.style.width = dragObject.style.width;

			rectangleDiv.style.height = (dragObject.offsetHeight - (dragObjectBorderWidth*2)) + 'px'; 

			

		}

		

		if(e.clientY<50 || e.clientY>(documentHeight-50)){

			if(e.clientY<50 && !autoScrollActive){

				autoScrollActive = true;

				autoScroll((autoScrollSpeed*-1),e.clientY);

			}

			

			if(e.clientY>(documentHeight-50) && document.documentElement.scrollHeight<=documentScrollHeight && !autoScrollActive){

				autoScrollActive = true;

				autoScroll(autoScrollSpeed,e.clientY);

			}

		}else{

			autoScrollActive = false;

		}		



		

		var leftPos = e.clientX;

		var topPos = e.clientY + document.documentElement.scrollTop;

		

		dragObject.style.left = (e.clientX - mouse_x + el_x) + 'px';

		dragObject.style.top = (el_y - mouse_y + e.clientY + document.documentElement.scrollTop) + 'px';

								



		

		if(!okToMove)return;

		okToMove = false;



		destinationObj = false;	

		rectangleDiv.style.display = 'none'; 

		

		var objFound = false;

		var tmpParentArray = new Array();

		

		if(!objFound){

			for(var no=1;no<dragableBoxesArray.length;no++){

				if(dragableBoxesArray[no]['obj']==dragObject)continue;

				tmpParentArray[dragableBoxesArray[no]['obj'].parentNode.id] = true;

				if(!objFound){

					var tmpX = getLeftPos(dragableBoxesArray[no]['obj']);

					var tmpY = getTopPos(dragableBoxesArray[no]['obj']);



					if(leftPos>tmpX && leftPos<(tmpX + dragableBoxesArray[no]['obj'].offsetWidth) && topPos>(tmpY-20) && topPos<(tmpY + (dragableBoxesArray[no]['obj'].offsetHeight/2))){

						destinationObj = dragableBoxesArray[no]['obj'];

						destinationObj.parentNode.insertBefore(rectangleDiv,dragableBoxesArray[no]['obj']);

						rectangleDiv.style.display = 'block';

						objFound = true;

						break;

						

					}

					

					if(leftPos>tmpX && leftPos<(tmpX + dragableBoxesArray[no]['obj'].offsetWidth) && topPos>=(tmpY + (dragableBoxesArray[no]['obj'].offsetHeight/2)) && topPos<(tmpY + dragableBoxesArray[no]['obj'].offsetHeight)){

						objFound = true;

						if(dragableBoxesArray[no]['obj'].nextSibling){

							

							destinationObj = dragableBoxesArray[no]['obj'].nextSibling;

							if(!destinationObj.tagName)destinationObj = destinationObj.nextSibling;

							if(destinationObj!=rectangleDiv)destinationObj.parentNode.insertBefore(rectangleDiv,destinationObj);

						}else{

							destinationObj = dragableBoxesArray[no]['obj'].parentNode;

							dragableBoxesArray[no]['obj'].parentNode.appendChild(rectangleDiv);

						}

						rectangleDiv.style.display = 'block';

						break;					

					}

					

					

					if(!dragableBoxesArray[no]['obj'].nextSibling && leftPos>tmpX && leftPos<(tmpX + dragableBoxesArray[no]['obj'].offsetWidth)

					&& topPos>topPos>(tmpY + (dragableBoxesArray[no]['obj'].offsetHeight))){

						destinationObj = dragableBoxesArray[no]['obj'].parentNode;

						dragableBoxesArray[no]['obj'].parentNode.appendChild(rectangleDiv);	

						rectangleDiv.style.display = 'block';	

						objFound = true;				

						

					}

				}

				

			}

		

		}

		

		if(!objFound){

			

			for(var no=1;no<=numberOfColumns;no++){

				if(!objFound){

					var obj = document.getElementById('dragableBoxesColumn' + no);			

					

						var left = getLeftPos(obj)/1;						

					

						var width = obj.offsetWidth;

						if(leftPos>left && leftPos<(left+width)){

							destinationObj = obj;

							obj.appendChild(rectangleDiv);

							rectangleDiv.style.display='block';

							objFound=true;		

							

						}				

					

				}

			}		

			

		}

	



		setTimeout('okToMove=true',5);

		

	}

	

	function stop_dragDropElement()

	{

		

		if(dragDropCounter<10){

			dragDropCounter = -1

			return;

		}

		dragDropCounter = -1;

		if(transparencyWhenDragging){

			dragObject.style.filter = null;

			dragObject.style.opacity = null;

		}		

		dragObject.style.position = 'static';

		dragObject.style.width = null;

		var numericId = dragObject.id.replace(/[^0-9]/g,'');

		if(destinationObj && destinationObj.id!=dragObject.id){

			

			if(destinationObj.id.indexOf('dragableBoxesColumn')>=0){

				destinationObj.appendChild(dragObject);

				dragableBoxesArray[numericId]['parentObj'] = destinationObj;

			}else{

				destinationObj.parentNode.insertBefore(dragObject,destinationObj);

				dragableBoxesArray[numericId]['parentObj'] = destinationObj.parentNode;

			}





							

		}else{

			if(dragObjectNextSibling){

				dragObjectParent.insertBefore(dragObject,dragObjectNextSibling);	

			}else{

				dragObjectParent.appendChild(dragObject);

			}				

			

			

		}

	



		

		autoScrollActive = false;

		rectangleDiv.style.display = 'none'; 

		dragObject = false;

		dragObjectNextSibling = false;

		destinationObj = false;

		

		if(useCookiesToRememberRSSSources)setTimeout('saveCookies()',100);



		documentHeight = document.documentElement.clientHeight;	

	}



	function saveCookies()

	{

		cookieCounter = 0;

		var tmpUrlArray = new Array();

		for(var no=1;no<=numberOfColumns;no++)

		{

			var parentObj = document.getElementById('dragableBoxesColumn' + no);

			

			var items = parentObj.getElementsByTagName('DIV');

			if(items.length==0)continue;

			

			var item = items[0];

			

			var tmpItemArray = new Array();

			while(item){

				var boxIndex = item.id.replace(/[^0-9]/g,'');

				if(item.id!='rectangleDiv'){

					tmpItemArray[tmpItemArray.length] = boxIndex;

				}	

				item = item.nextSibling;			

			}

			

			var columnIndex = no;

			

			for(var no2=tmpItemArray.length-1;no2>=0;no2--){

				var boxIndex = tmpItemArray[no2];

				var url = dragableBoxesArray[boxIndex]['rssUrl'];

				var heightOfBox = dragableBoxesArray[boxIndex]['heightOfBox'];

				var maxRssItems = dragableBoxesArray[boxIndex]['maxRssItems'];

				var minutesBeforeReload = dragableBoxesArray[boxIndex]['minutesBeforeReload'];

				var uniqueIdentifier = dragableBoxesArray[boxIndex]['uniqueIdentifier'];

				var state = dragableBoxesArray[boxIndex]['boxState'];

				if(!tmpUrlArray[url]){

					tmpUrlArray[url] = true;

					

					Set_Cookie(nameOfCookie + cookieCounter,url + '#;#' + columnIndex + '#;#' + maxRssItems + '#;#' + heightOfBox + '#;#' + minutesBeforeReload + '#;#' + uniqueIdentifier + '#;#' + state ,60000);

					cookieRSSSources[url] = cookieCounter;

					cookieCounter++;	

				

				}else{

					

					Set_Cookie(nameOfCookie + cookieCounter,'' + '#;#' + columnIndex + '#;#' + '' + '#;#' + heightOfBox + '#;#' + '' + '#;#' + uniqueIdentifier ,60000);

					cookieCounter++;

				}		

				

			}

		}

	}

	

	

	function getTopPos(inputObj)

	{		

	  var returnValue = inputObj.offsetTop;

	  while((inputObj = inputObj.offsetParent) != null){

	  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetTop;

	  }

	  return returnValue;

	}

	

	function getLeftPos(inputObj)

	{

	  var returnValue = inputObj.offsetLeft;

	  while((inputObj = inputObj.offsetParent) != null){

	  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetLeft;

	  }

	  return returnValue;

	}

		

	

	function createColumns()

	{

		if(!columnParentBoxId){

			alert('No parent box defined for your columns');

			return;

		}

		columnParentBox = document.getElementById(columnParentBoxId);

		var columnWidth = Math.floor(100/numberOfColumns);

		var sumWidth = 0;

		for(var no=0;no<numberOfColumns;no++){

			var div = document.createElement('DIV');

			if(no==(numberOfColumns-1))columnWidth = 99 - sumWidth;

			sumWidth = sumWidth + columnWidth;

			div.style.cssText = 'float:left;width:'+columnWidth+'%;padding:0px;margin:0px;';

			div.style.height='100%';

			div.style.styleFloat='left';

			div.style.width = columnWidth + '%';

			div.style.padding = '0px';

			div.style.margin = '0px';



			div.id = 'dragableBoxesColumn' + (no+1);

			columnParentBox.appendChild(div);

			

			var clearObj = document.createElement('HR');	

			clearObj.style.clear = 'both';

			clearObj.style.visibility = 'hidden';

			div.appendChild(clearObj);

		}

		

		

		

		var clearingDiv = document.createElement('DIV');

		columnParentBox.appendChild(clearingDiv);

		clearingDiv.style.clear='both';

		

	}

	

	function mouseoverBoxHeader()

	{

		if(dragDropCounter==10)return;

		var id = this.id.replace(/[^0-9]/g,'');

		document.getElementById('dragableBoxExpand' + id).style.visibility = 'visible';		

		document.getElementById('dragableBoxRefreshSource' + id).style.visibility = 'visible';		

		document.getElementById('dragableBoxCloseLink' + id).style.visibility = 'visible';

		if(document.getElementById('dragableBoxEditLink' + id))document.getElementById('dragableBoxEditLink' + id).style.visibility = 'visible';

		

	}

	function mouseoutBoxHeader(e,obj)

	{

		if(!obj)obj=this;

		

		var id = obj.id.replace(/[^0-9]/g,'');

		document.getElementById('dragableBoxExpand' + id).style.visibility = 'hidden';		

		document.getElementById('dragableBoxRefreshSource' + id).style.visibility = 'hidden';		

		document.getElementById('dragableBoxCloseLink' + id).style.visibility = 'hidden';		

		if(document.getElementById('dragableBoxEditLink' + id))document.getElementById('dragableBoxEditLink' + id).style.visibility = 'hidden';		

		

	}

	

	function refreshRSS()

	{

		reloadRSSData(this.id.replace(/[^0-9]/g,''));

		setTimeout('dragDropCounter=-5',5);

	}

	

	function showHideBoxContent(e,inputObj)

	{

		if(document.all)e = event;

		if(!inputObj)inputObj=this;

		

		var numericId = inputObj.id.replace(/[^0-9]/g,'');

		var obj = document.getElementById('dragableBoxContent' + numericId);

		

		obj.style.display = inputObj.src.indexOf(src_rightImage)>=0?'none':'block';

		inputObj.src = inputObj.src.indexOf(src_rightImage)>=0?src_downImage:src_rightImage

		

		dragableBoxesArray[numericId]['boxState'] = obj.style.display=='block'?1:0;

		saveCookies();

		setTimeout('dragDropCounter=-5',5);

	}

	

	function mouseover_CloseButton()

	{

		this.className = 'closeButton_over';	

		setTimeout('dragDropCounter=-5',5);

	}

	

	function highlightCloseButton()

	{

		this.className = 'closeButton_over';	

	}

	

	function mouseout_CloseButton()

	{

		this.className = 'closeButton';	

	}

	

	function closeDragableBox(e,inputObj)

	{

		if(!inputObj)inputObj = this;

		var numericId = inputObj.id.replace(/[^0-9]/g,'');

		document.getElementById('dragableBox' + numericId).style.display='none';	

		

		Set_Cookie(nameOfCookie + cookieRSSSources[dragableBoxesArray[numericId]['rssUrl']],'none' ,60000);



		setTimeout('dragDropCounter=-5',5);

		

	}

	

	function editRSSContent()

	{

		var numericId = this.id.replace(/[^0-9]/g,'');

		var obj = document.getElementById('dragableBoxEdit' + numericId);

		if(obj.style.display=='none'){

			obj.style.display='block';

			this.innerHTML = txt_editLink_stop;

			document.getElementById('dragableBoxHeader' + numericId).style.height = '135px';

		}else{

			obj.style.display='none';

			this.innerHTML = txt_editLink;

			document.getElementById('dragableBoxHeader' + numericId).style.height = '20px';

		}

		setTimeout('dragDropCounter=-5',5);

	}

	

	

	function showStatusBarMessage(numericId,message)

	{

		document.getElementById('dragableBoxStatusBar' + numericId).innerHTML = message;

		

	}

	

	function addBoxHeader(parentObj,externalUrl)

	{

		var div = document.createElement('DIV');
		div.className = 'dragableBoxHeader';
				if(moveable=='Yes')
		{
			div.style.cursor = 'move';
		}
		if(moveable=='No')	
		{
			div.style.cursor = 'pointer';
		}
		div.id = 'dragableBoxHeader' + boxIndex;
		div.onmouseover = mouseoverBoxHeader;
		div.onmouseout = mouseoutBoxHeader;
		if(moveable=='Yes')
		{
			div.onmousedown = initDragDropBox;
		}
		if(moveable=='No')
		{
			div.onmousedown = mouseoutBoxHeader;
		}		

		var image = document.createElement('IMG');

		image.id = 'dragableBoxExpand' + boxIndex;

		image.src = src_rightImage;

		image.style.visibility = 'hidden';	

		image.style.cursor = 'pointer';

		image.onmousedown = showHideBoxContent;	

		div.appendChild(image);

		

		var textSpan = document.createElement('SPAN');

		textSpan.id = 'dragableBoxHeader_txt' + boxIndex;

		div.appendChild(textSpan);

				

		parentObj.appendChild(div);	



		var closeLink = document.createElement('A');

		closeLink.style.cssText = 'float:right';

		closeLink.style.styleFloat = 'right';

		closeLink.id = 'dragableBoxCloseLink' + boxIndex;

		closeLink.innerHTML = 'x';

		closeLink.className = 'closeButton';

		closeLink.onmouseover = mouseover_CloseButton;

		closeLink.onmouseout = mouseout_CloseButton;

		closeLink.style.cursor = 'pointer';

		closeLink.style.visibility = 'hidden';

		closeLink.onmousedown = closeDragableBox;

		div.appendChild(closeLink);



			

		var image = document.createElement('IMG');

		image.src = src_refreshSource;

		image.id = 'dragableBoxRefreshSource' + boxIndex;

		image.style.cssText = 'float:right';

		image.style.styleFloat = 'right';

		image.style.visibility = 'hidden';

		image.onclick = refreshRSS;

		image.style.cursor = 'pointer';

		if(!externalUrl)image.style.display='none';

		div.appendChild(image);

		

	

		



		



	}

	

	function saveFeed(boxIndex)

	{

		var heightOfBox = dragableBoxesArray[boxIndex]['heightOfBox'] = document.getElementById('heightOfBox[' + boxIndex + ']').value;

		var intervalObj = dragableBoxesArray[boxIndex]['intervalObj'];

		if(intervalObj)clearInterval(intervalObj);

		

		if(heightOfBox && heightOfBox>40){

			var contentObj = document.getElementById('dragableBoxContent' + boxIndex);

			contentObj.style.height = heightOfBox + 'px';

			contentObj.setAttribute('heightOfBox',heightOfBox);

			contentObj.heightOfBox = heightOfBox;	

			if(document.all)contentObj.style.overflowY = 'auto';else contentObj.style.overflow='-moz-scrollbars-vertical;';

			if(opera||safari||konqueror)contentObj.style.overflow='auto';			

			

		}

		

		dragableBoxesArray[boxIndex]['rssUrl'] = document.getElementById('rssUrl[' + boxIndex + ']').value;

		dragableBoxesArray[boxIndex]['heightOfBox'] = heightOfBox;

		dragableBoxesArray[boxIndex]['maxRssItems'] = document.getElementById('maxRssItems[' + boxIndex + ']').value;

		dragableBoxesArray[boxIndex]['heightOfBox'] = document.getElementById('heightOfBox[' + boxIndex + ']').value;

		dragableBoxesArray[boxIndex]['minutesBeforeReload'] = document.getElementById('minutesBeforeReload[' + boxIndex + ']').value;

		

		if(dragableBoxesArray[boxIndex]['minutesBeforeReload'] && dragableBoxesArray[boxIndex]['minutesBeforeReload']>5){

			var tmpInterval = setInterval("reloadRSSData(" + boxIndex + ")",(dragableBoxesArray[boxIndex]['minutesBeforeReload']*1000*60));	

			dragableBoxesArray[boxIndex]['intervalObj'] = tmpInterval;

		}

		reloadRSSData(boxIndex);

		

		if(useCookiesToRememberRSSSources)setTimeout('saveCookies()',100);

		

	}

	

	function addRSSEditContent(parentObj)

	{



		var editLink = document.createElement('A');

		editLink.href = '#';

		editLink.onclick = cancelEvent;

		editLink.style.cssText = 'float:right';

		editLink.style.styleFloat = 'right';

		editLink.id = 'dragableBoxEditLink' + boxIndex;

		editLink.innerHTML = txt_editLink;

		editLink.className = 'dragableBoxEditLink';

		editLink.style.cursor = 'pointer';

		editLink.style.visibility = 'hidden';

		editLink.onmousedown = editRSSContent;

		parentObj.appendChild(editLink);	

				

		var editBox = document.createElement('DIV');

		editBox.style.clear='both';

		editBox.id = 'dragableBoxEdit' + boxIndex;

		editBox.style.display='none';

		

		var content = '<form><table cellpadding="1" cellspacing="1"><tr><td>Source:<\/td><td><input type="text" id="rssUrl[' + boxIndex + ']" value="' + dragableBoxesArray[boxIndex]['rssUrl'] + '" size="25" maxlength="255"><\/td><\/tr>'

		+ '<tr><td>Items:<\/td><td width="30"><input type="text" id="maxRssItems[' + boxIndex + ']" onblur="this.value = this.value.replace(/[^0-9]/g,\'\');if(!this.value)this.value=' + dragableBoxesArray[boxIndex]['maxRssItems'] + '" value="' + dragableBoxesArray[boxIndex]['maxRssItems'] + '" size="2" maxlength="2"><\/td><\/tr><tr><td>Fixed height:<\/td><td><input type="text" id="heightOfBox[' + boxIndex + ']" onblur="this.value = this.value.replace(/[^0-9]/g,\'\');if(!this.value)this.value=' + dragableBoxesArray[boxIndex]['heightOfBox'] + '" value="' + dragableBoxesArray[boxIndex]['heightOfBox'] + '" size="2" maxlength="3"><\/td><\/tr><tr>'

		+'<tr><td>Reload every:<\/td><td width="30"><input type="text" id="minutesBeforeReload[' + boxIndex + ']" onblur="this.value = this.value.replace(/[^0-9]/g,\'\');if(!this.value || this.value/1<5)this.value=' + dragableBoxesArray[boxIndex]['minutesBeforeReload'] + '" value="' + dragableBoxesArray[boxIndex]['minutesBeforeReload'] + '" size="2" maxlength="3">&nbsp;minute<\/td><\/tr>'

		+'<tr><td><input type="button" onclick="saveFeed(' + boxIndex + ')" value="Save"><\/td><\/tr><\/table><\/form>';


		editBox.innerHTML = content;

		

		parentObj.appendChild(editBox);		

		

	}

	

	

	function addBoxContentContainer(parentObj,heightOfBox)

	{

		var div = document.createElement('DIV');

		div.className = 'dragableBoxContent';

		if(opera)div.style.clear='none';

		div.id = 'dragableBoxContent' + boxIndex;

		parentObj.appendChild(div);			

		if(heightOfBox && heightOfBox/1>40){

			div.style.height = heightOfBox + 'px';

			div.setAttribute('heightOfBox',heightOfBox);

			div.heightOfBox = heightOfBox;	

			if(document.all)div.style.overflowY = 'auto';else div.style.overflow='-moz-scrollbars-vertical;';

			if(opera||safari||konqueror)div.style.overflow='auto';

		}		

	}

	

	function addBoxStatusBar(parentObj)

	{

		var div = document.createElement('DIV');

		div.className = 'dragableBoxStatusBar';

		div.id = 'dragableBoxStatusBar' + boxIndex;

		parentObj.appendChild(div);	

		

		

	}

	

	function createABox(columnIndex,heightOfBox,externalUrl,uniqueIdentifier)

	{

		boxIndex++;

		

		var maindiv = document.createElement('DIV');

		maindiv.className = 'dragableBox';

		maindiv.id = 'dragableBox' + boxIndex;

		

		var div = document.createElement('DIV');

		div.className='dragableBoxInner';

		maindiv.appendChild(div);

		

		

		addBoxHeader(div,externalUrl);

		addBoxContentContainer(div,heightOfBox);

		addBoxStatusBar(div);

		

		var obj = document.getElementById('dragableBoxesColumn' + columnIndex);		

		var subs = obj.getElementsByTagName('DIV');

		if(subs.length>0){

			obj.insertBefore(maindiv,subs[0]);

		}else{

			obj.appendChild(maindiv);

		}

		

		dragableBoxesArray[boxIndex] = new Array();

		dragableBoxesArray[boxIndex]['obj'] = maindiv;

		dragableBoxesArray[boxIndex]['parentObj'] = maindiv.parentNode;

		dragableBoxesArray[boxIndex]['uniqueIdentifier'] = uniqueIdentifier;

		dragableBoxesArray[boxIndex]['heightOfBox'] = heightOfBox;

		dragableBoxesArray[boxIndex]['boxState'] = 1;	// Expanded

		

		staticObjectArray[uniqueIdentifier] = boxIndex;

		

		return boxIndex;

		

	}

	

	function showRSSData(ajaxIndex,boxIndex)

	{

		var rssContent = ajaxObjects[ajaxIndex].response;

		tokens = rssContent.split(/\n\n/g);

		

		

		var headerTokens = tokens[0].split(/\n/g);

		if(headerTokens[0]=='0'){

			headerTokens[1] = '';

			headerTokens[0] = 'Invalid source';

			closeDragableBox(false,document.getElementById('dragableBoxHeader_txt' + boxIndex));

			return;			

		}

		document.getElementById('dragableBoxHeader_txt' + boxIndex).innerHTML = '<span>' + headerTokens[0] + '&nbsp;<\/span><span class="rssNumberOfItems">(' + headerTokens[1] + ')<\/span>';	// title

		

		var string = '<table cellpadding="1" cellspacing="0" align="left">';

		for(var no=1;no<tokens.length;no++){	// Looping through RSS items

			var itemTokens = tokens[no].split(/##/g);			
var dadesc = itemTokens[2];	
			
			<?php if (($tooltip) AND ($tooltipconvert)) { ?>
				string = string + '<tr><td><a href="javascript:void(0);" onclick="ddrivetip(\'' + dadesc.htmlEntities() + '\');"><img src="modules/images/icon_comment.png" border="0"></a>&nbsp;</td><td><p class=\"boxItemHeader\"><a id="1" class=\"boxItemHeader\" href="' + itemTokens[3] + '" onclick="var w = window.open(this.href);return false">' + itemTokens[0] + '<\/a><\/p><\/td><\/tr>';	
				<?php } else if (($tooltip) AND (!$converthtml)) {  ?>
				string = string + '<tr><td><a href="javascript:void(0);" onclick="ddrivetip(\'' + dadesc + '\');"><img src="modules/images/icon_comment.png" border="0"></a>&nbsp;</td><td><p class=\"boxItemHeader\"><a id="1" class=\"boxItemHeader\" href="' + itemTokens[3] + '" onclick="var w = window.open(this.href);return false">' + itemTokens[0] + '<\/a><\/p><\/td><\/tr>';	
				<?php } else { ?>			
			string = string + '<tr><td><img src="' + src_smallRightArrow + '" >&nbsp;</td><td><p class=\"boxItemHeader\"><a id="1" class=\"boxItemHeader\" href="' + itemTokens[3] + '" onclick="var w = window.open(this.href);return false">' + itemTokens[0] + '<\/a><\/p><\/td><\/tr>';	
			<?php } ?>	

		}

		string = string + '<\/table>';

		document.getElementById('dragableBoxContent' + boxIndex).innerHTML = string;

		showStatusBarMessage(boxIndex,'');

		ajaxObjects[ajaxIndex] = false;

	}

	

	function reloadRSSData(numericId)

	{

		var ajaxIndex = ajaxObjects.length;

		ajaxObjects[ajaxIndex] = new sack();

		showStatusBarMessage(numericId,'Loading data...');
		//alert (dragableBoxesArray[numericId]['rssUrl']);

		ajaxObjects[ajaxIndex].requestFile = './modules/readRSS.php?rssURL=' + escape(dragableBoxesArray[numericId]['rssUrl']) + '&maxRssItems=' + dragableBoxesArray[numericId]['maxRssItems'];	// Specifying which file to get

		ajaxObjects[ajaxIndex].onCompletion = function(){ showRSSData(ajaxIndex,numericId); };	// Specify function that will be executed after file has been found

		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function			

		

	}


		

	function createARSSBox(url,columnIndex,heightOfBox,maxRssItems,minutesBeforeReload,uniqueIdentifier,state)

	{



		if(!heightOfBox)heightOfBox = '0';

		if(!minutesBeforeReload)minutesBeforeReload = '0';



			

		var tmpIndex = createABox(columnIndex,heightOfBox,true);



		if(useCookiesToRememberRSSSources)

		{

			if(!cookieRSSSources[url]){

				cookieRSSSources[url] = cookieCounter;		

				Set_Cookie(nameOfCookie + cookieCounter,url + '#;#' + columnIndex + '#;#' + maxRssItems + '#;#' + heightOfBox + '#;#' + minutesBeforeReload + '#;#' + uniqueIdentifier + '#;#' + state  ,60000);

				cookieCounter++;

			}

		}		

		

		dragableBoxesArray[tmpIndex]['rssUrl'] = url;

		dragableBoxesArray[tmpIndex]['maxRssItems'] = maxRssItems?maxRssItems:100;

		dragableBoxesArray[tmpIndex]['minutesBeforeReload'] = minutesBeforeReload;

		dragableBoxesArray[tmpIndex]['heightOfBox'] = heightOfBox;

		dragableBoxesArray[tmpIndex]['uniqueIdentifier'] = uniqueIdentifier;

		dragableBoxesArray[tmpIndex]['state'] = state;



		if(state==0){

			showHideBoxContent(false,document.getElementById('dragableBoxExpand' + tmpIndex));

		}

		

		staticObjectArray[uniqueIdentifier] = tmpIndex;

		

		var tmpInterval = false;

		if(minutesBeforeReload && minutesBeforeReload>0){

			var tmpInterval = setInterval("reloadRSSData(" + tmpIndex + ")",(minutesBeforeReload*1000*60));

		}



		dragableBoxesArray[tmpIndex]['intervalObj'] = tmpInterval;

			

		addRSSEditContent(document.getElementById('dragableBoxHeader' + tmpIndex))

			

		if(!document.getElementById('dragableBoxContent' + tmpIndex).innerHTML)document.getElementById('dragableBoxContent' + tmpIndex).innerHTML = 'loading RSS data';



		if(url.length>0 && url!='undefined'){

			

			var ajaxIndex = ajaxObjects.length;

			ajaxObjects[ajaxIndex] = new sack();

			if(!maxRssItems)maxRssItems = 100;

			ajaxObjects[ajaxIndex].requestFile = './modules/readRSS.php?rssURL=' + escape(url) + '&maxRssItems=' + maxRssItems;	// Specifying which file to get

			ajaxObjects[ajaxIndex].onCompletion = function(){ showRSSData(ajaxIndex,tmpIndex); };	// Specify function that will be executed after file has been found

			ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function

		}else{

			hideHeaderOptionsForStaticBoxes(tmpIndex);

		}			

	}

	

	function createHelpObjects()

	{

		/* Creating rectangle div */

		rectangleDiv = document.createElement('DIV');

		rectangleDiv.id='rectangleDiv';

		rectangleDiv.style.display='none';

		document.body.appendChild(rectangleDiv);

		

		 

	}

	

	function cancelSelectionEvent(e)

	{

		if(document.all)e = event;

		

		if (e.target) source = e.target;

			else if (e.srcElement) source = e.srcElement;

			if (source.nodeType == 3) // defeat Safari bug

				source = source.parentNode;

		if(source.tagName.toLowerCase()=='input')return true;


						

		if(dragDropCounter>=0)return false; else return true;	

		

	}

	

	function cancelEvent()

	{

		return false;

	}

	

	function initEvents()

	{

		document.body.onmousemove = moveDragableElement;

		document.body.onmouseup = stop_dragDropElement;

		document.body.onselectstart = cancelSelectionEvent;



		document.body.ondragstart = cancelEvent;	

		

		documentHeight = document.documentElement.clientHeight;	

		

	}

	

	

	function createFeed(formObj)

	{

		var url = formObj.rssUrl.value;

		var items = formObj.items.value;
		
		var column = formObj.column.value;

		var height = formObj.height.value;

		var reloadInterval = formObj.reloadInterval.value;

		if(isNaN(height) || height/1<40)height = false;	

		if(isNaN(reloadInterval) || reloadInterval/1<5)reloadInterval = false;

		createARSSBox(url,column,height,items,reloadInterval);	

	}

	

	function createRSSBoxesFromCookie()

	{

		var tmpArray = new Array();

		var cookieValue = Get_Cookie(nameOfCookie + '0');

		while(cookieValue && cookieValue!=''){

			var items = cookieValue.split('#;#');

			var index = items[0];

			if(!items[0])index = items[5];

			if(items.length>1 && !tmpArray[index]){

				tmpArray[index] = true;

				createARSSBox(items[0],items[1],items[3],items[2],items[4],items[5],items[6]);

				cookieRSSSources[items[0]]=cookieCounter;

			}else{

				cookieCounter++;

			}

			var cookieValue = Get_Cookie(nameOfCookie + cookieCounter);

		}		

	}



	

	/* Clear cookies */

	

	function clearCookiesForDragableBoxes()

	{

		var cookieValue = Get_Cookie(nameOfCookie);

		while(cookieValue && cookieValue!=''){

			Set_Cookie(nameOfCookie + cookieCounter,'',-500);

			cookieCounter++;

			var cookieValue = Get_Cookie(nameOfCookie + cookieCounter);

		}		

		

	}

	

	/* Delete all boxes */

	

	function deleteAllDragableBoxes()

	{

		var divs = document.getElementsByTagName('DIV');

		for(var no=0;no<divs.length;no++){

			if(divs[no].className=='dragableBox')closeDragableBox(false,divs[no]);	

		}

			

	}

	

	/* Reset back to default settings */

	

	function resetDragableBoxes()

	{

		cookieCounter = 0;

		clearCookiesForDragableBoxes();

		

		deleteAllDragableBoxes();

		cookieCounter = 0;

		cookieRSSSources = new Array();

		createDefaultBoxes();

	}

	

	function hideHeaderOptionsForStaticBoxes(boxIndex)

	{

		if(document.getElementById('dragableBoxRefreshSource' + boxIndex))document.getElementById('dragableBoxRefreshSource' + boxIndex).style.display='none';

		if(document.getElementById('dragableBoxCloseLink' + boxIndex))document.getElementById('dragableBoxCloseLink' + boxIndex).style.display='none';		

		if(document.getElementById('dragableBoxEditLink' + boxIndex))document.getElementById('dragableBoxEditLink' + boxIndex).style.display='none';		

	}

	

	

	

	/* You customize this function 
			
			(url,columnIndex,heightOfBox,maxRssItems,minutesBeforeReload) 

	
	*/
	function createDefaultBoxes()
	{		

		
		if(cookieCounter==0){
		
		if(url8) {	
				createARSSBox('<?php echo $url8;?>',<?php echo $pos8;?>,<?php echo $height8;?>,<?php echo $items8;?>,<?php echo $refresh8;?>);	}
		if(url7) {	
				createARSSBox('<?php echo $url7;?>',<?php echo $pos7;?>,<?php echo $height7;?>,<?php echo $items7;?>,<?php echo $refresh7;?>);	}
 		if(url6) {	
				createARSSBox('<?php echo $url6;?>',<?php echo $pos6;?>,<?php echo $height6;?>,<?php echo $items6;?>,<?php echo $refresh6;?>);	}
		if(url5) {	
				createARSSBox('<?php echo $url5;?>',<?php echo $pos5;?>,<?php echo $height5;?>,<?php echo $items5;?>,<?php echo $refresh5;?>);	}
		if(url4) {	
				createARSSBox('<?php echo $url4;?>',<?php echo $pos4;?>,<?php echo $height4;?>,<?php echo $items4;?>,<?php echo $refresh4;?>);	}
		if(url3) {	
				createARSSBox('<?php echo $url3;?>',<?php echo $pos3;?>,<?php echo $height3;?>,<?php echo $items3;?>,<?php echo $refresh3;?>);	}
		if(url2) {	
				createARSSBox('<?php echo $url2;?>',<?php echo $pos2;?>,<?php echo $height2;?>,<?php echo $items2;?>,<?php echo $refresh2;?>);	}
		if(url1) {	
				createARSSBox('<?php echo $url1;?>',<?php echo $pos1;?>,<?php echo $height1;?>,<?php echo $items1;?>,<?php echo $refresh1;?>);	}
		}	

	

		

	}
	


	function initDragableBoxesScript()

	{

		createColumns();	// Always the first line of this function

		createHelpObjects();	// Always the second line of this function

		initEvents();	// Always the third line of this function

		

		if(useCookiesToRememberRSSSources)createRSSBoxesFromCookie();	// Create RSS boxes from cookies

		createDefaultBoxes();	// Create default boxes.

	}
	if (window.addEventListener)
	window.addEventListener("load", initDragableBoxesScript, false)
	else if (window.attachEvent)
	window.attachEvent("onload", initDragableBoxesScript)
	//window.onload = initDragableBoxesScript;
</script>

 <div id="mainContainer">

	<div id="floatingBoxParentContainer">
	</div>
	<?php if ($addnewfeed > "") { ?>
	<div id="addNewFeed">
			<form method="post" action="#">
			<table cellpadding="0" cellspacing="0">
				<tr><td colspan="4"><strong>Add New Feed</strong></td></tr>
				<tr><td>RSS url: </td><td colspan="4"><input type="text" name="rssUrl" size="30" value="http://www.stroz.us/php/index.php?option=com_rss&feed=RSS1.0&no_html=1" maxlength="255"></td></tr>
				<tr>
					<td>Items: </td>
					<td><input type="text" name="items" value="10" size="2" maxlength="2"></td>
					<td>Column: </td>
					<td><input type="text" name="column" value="1" size="2" maxlength="2"></td>
					</tr>
					<tr>
					<td>&nbsp;Refresh every:</td>
					<td><input type="text" name="reloadInterval" value="10" size="2" maxlength="2"></td>
					<td>&nbsp;minute</td>
				</tr>
				<tr>
					<td>Fixed height:</td>
					<td><input type="text" name="height" value="150" size="2" maxlength="3"> </td>
					<td><input type="button" onclick="createFeed(this.form)" value="Create"></td>
				</tr>

			</table>
			</form>
		</div>
		<?php } ?>
</div>

<div id="debug"></div>