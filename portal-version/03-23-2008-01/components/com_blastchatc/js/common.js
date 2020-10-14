<!--
/**
* common.js.php
* @package BlastChat Client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

//initiates the XMLHttpRequest object
function getHTTPObject() {
  var xmlhttp;
  /*@cc_on
  @if (@_jscript_version >= 5)
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
  @else
  xmlhttp = false;
  @end @*/
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}

function writeit(text,objId) {
	//alert(text);
	if (document.layers) { //Netscape 4
		myObj = eval('document.' + objId);
		myObj.document.open();
		myObj.document.write(text);
		myObj.document.close();
	} else 	if ((document.all && !document.getElementById) || navigator.userAgent.indexOf("Opera") != -1) { //IE 4 & Opera
		myObj = eval('document.all.' + objId);
		myObj.innerHTML = text;
	} else if (document.getElementById) { //Netscape 6 & IE 5
		myObj = document.getElementById(objId);
		//myObj.innerHTML = '';
		myObj.innerHTML = text;
	} else {
		alert('This website uses DHTML. We recommend you upgrade your browser.');
	}
}

//initiates the first data query
function updateList() {
	if (httpUpdater.readyState == 4 || httpUpdater.readyState == 0) {
		httpUpdater.open("POST", getURL, true);
		httpUpdater.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		httpUpdater.onreadystatechange = handlehttpUpdater;
		httpUpdater.send(param);
	}
}

//deals with the servers reply to requesting new content
function handlehttpUpdater() {
	if (httpUpdater.readyState == 4) {
		if (httpUpdater.responseText.substr(0, 7) == 'allowed') {
			var newcontent = httpUpdater.responseText.substr(7, httpUpdater.responseText.length);
			//writeit(decodeURI(newcontent),'bc_module');
			writeit(newcontent,'bc_module');
			if (refreshtime > 0)
				setTimeout("updateList()",refreshtime*1000);
		}
	}
}
//-->