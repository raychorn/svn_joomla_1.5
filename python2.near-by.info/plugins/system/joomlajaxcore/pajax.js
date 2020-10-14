/*
*                                                                              
*  JoomlaJax is an OpenSource Software based on Prototype Library and   
*  Scriptaculous toolkit that makes Joomla Contents Load faster than ever.     
*  Version 2.0                                                                 
*  Author: Hamidreza Tavakoli                                                  
*  Site: http://www.web2coder.com                                              
*  Email: hamidreza.tavakoli@gmail.com                                         
*  Copyright © 2007 by Hamidreza Tavakoli - All rights reserved                 
*                                                                              
*  JoomlaJax is free software; you can redistribute it and/or modify    
*  it under the terms of the GNU General Public License as published by        
*  the Free Software Foundation; either version 2 of the License, or           
*  (at your option) any later version.                                         
*                                                                              
*  JoomlaJax is distributed in the hope that it will be useful,         
*  but WITHOUT ANY WARRANTY; without even the implied warranty of              
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               
*  GNU General Public License for more details.                                
*                                                                              
*  You should have received a copy of the GNU General Public License           
*  along with this program; if not, write to the Free Software                 
*  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA  
*                                                                              
*                                                                              
*/
onerror=handleErr
var txt=""
function handleErr(msg,url,l)
{
txt="There was an error on this page.\n\n"
txt+="Error: " + msg + "\n"
txt+="URL: " + url + "\n"
txt+="Line: " + l + "\n\n"
txt+="Click OK to continue.\n\n"
redirect(rdurl);
//alert(txt);
return true;
}
function redirect(url){
    if(url){
    var sturl
    sturl = url.replace(/index2.php/gi,"index.php");
    window.location = sturl
    }
}
function deajax(){
for (var i=0;i < document.links.length;i++) {
sturl=document.links[i].href;
sturl = sturl.replace(/javascript:pajaxload\(\'(.*)?\'\)/gi,"$1");
sturl = sturl.replace(/index2.php/gi,"index.php");
document.links[i].href = sturl;
}
    }
var rdurl;
var pjcounter = 0;
function pajaxload(url){
try
{
    rdurl=url;
    if(pjcounter<1){
        if($('pathway')){
            $('pathway').remove();
        }
        if(gbcontainer){
            gbcontainer.remove();
        }
        if(stpresib){
            try{
            var x
        for (var x = 0; x < stpresib.length; ++x) {
        stpresib[x].hide();
            }
              }
            catch(err)
             {
            }
            }
    }
    pjcounter=pjcounter+1
    showLoad(true);
    if(url=="index2.php"){
        url="index2.php?option=com_frontpage&Itemid=1"
    }
new Ajax.Request(url, {
    method: 'get',
    evalScripts: true,
    encoding: 'UTF-8',
    onSuccess:function(request){     
        extrscript(request);
        evlscript(request);  
    },
    onComplete:function(request){
        showLoad(false);
        $('ajaxcontainer').update(iscriptdecode(request.responseText));
        '<script>ajaxLinks2();</script>'.evalScripts();
        if($('pathway')){
                bookmarkaction(url);
                new Insertion.After('pathway', '<div align="right"><a href="javascript:deajax()">Disable</a>/<a href="javascript:ajaxLinks2()" >Enable</a> Ajax</div>');
        }
    },
    onFailure:function(){
        alert("There is a problem with your browser, Please make sure that you have already enabled the JavaScript in your Browser");
    }
 });
}
catch(err)
{
    redirect(rdurl);
}
};
function bookmarksite(title,url){
if (window.sidebar) // firefox
	window.sidebar.addPanel(title, url, "");
else if(window.opera && window.print){ // opera
	var elem = document.createElement('a');
	elem.setAttribute('href',url);
	elem.setAttribute('title',title);
	elem.setAttribute('rel','sidebar');
	elem.click();
} 
else if(document.all)// ie
	window.external.AddFavorite(url, title);
}
function bookmarkaction(url){
    var sturl=url.replace(/index2.php/gi,"index.php");
    var stlink = document.URL;
    stlink=stlink.replace("#","");
    sturl=stlink+sturl;
    sturl='<div id="bookmarks" align="right"><a href="javascript:bookmarksite(\''+stlink+'\', \''+sturl+'\')">Bookmark This Page</a></div>'
    new Insertion.After('pathway', sturl);
}
function showLoad(show){
	if(show){
		//$('loading').setStyle({display: 'inline'});
		fadeIn()
		$('ajaxcontainer').hide();
		if (includeLoadingScript>0){
		removescript("include",includeLoadingScript,"head");
		includeLoadingScript = 0;
		}
		if (inlineloadingCounter>0){
		removescript("inline",inlineloadingCounter,"body");
		inlineloadingCounter = 0;
		}
	}else{
	    Effect.Appear("ajaxcontainer");
		$('loading').setStyle({display: 'none'});
	}
};
function removescript(type,numCount,location){
    for(x=1;x<numCount+1;x++){
        var rmvscript = document.getElementsByTagName(location)[0];
        rmvscript.removeChild(document.getElementById(type+x));
    }
}
var includeLoadingScript=0
function dhtmlLoadScript(url,location)
   {
      includeLoadingScript = includeLoadingScript +1
      var e = document.createElement("script");
	  e.src = url;
	  e.type="text/javascript";
	  e.id = "include"+includeLoadingScript
	  document.getElementsByTagName(location)[0].appendChild(e);	  
   }

var inlineloadingCounter=0
function loadinlinescript(strscript,location){
    inlineloadingCounter = inlineloadingCounter + 1
    var objhead = window.document.getElementsByTagName(location)[0]; 
    var objscript = window.document.createElement('script'); 
    objscript.text = strscript;
    objscript.type = 'text/javascript';
    objscript.id = "inline"+inlineloadingCounter;
    objhead.appendChild(objscript);
}
function evlscript(request){
    var rstr=request.responseText;
    var rstrex=rstr.extractScripts();
    var myReturnedValues = rstrex.map(function(script) {
    return evlaction(script);
    });
};
function evlaction(decodedRstr){
try
  {
     var decodedString=iscriptdecode(decodeURIComponent(unescape(String(decodedRstr))));
     loadinlinescript(decodedString,"body");
  }
catch(err)
  {
        txt="There was an error on this page.\n\n"
        txt+="Error description: " + err.description + "\n\n"
        txt+="Click OK to continue.\n\n"
        loadinlinescript(decodedString,"body");
  }
 };
function extrscript(decodedString){
    var exst=URLDecode(decodedString.responseText);
    var myregexp = /<\s*script[^>]*src\s*=\s*(\"|\')([^(\"|\')]*).>/gi;
    var strresult=exst.match(myregexp);
    var x
    if(strresult != null){
        for (var x = 0; x < strresult.length; ++x)
            {
             try
               {
                strresult[x]=strresult[x].replace(myregexp,"$2");
                dhtmlLoadScript(strresult[x],"head");
                 }
             catch(err)
                 {
                 }
            };
    };
 };
function URLDecode(psEncodeString){
  var lsRegExp = /\+/g;
  return unescape(String(psEncodeString).replace(lsRegExp, " "));
};
function iscriptdecode(psEncodeString){
  var lsRegExp = /document\.write/g;
  return unescape(String(psEncodeString).replace(lsRegExp, "//document.write"));
};
function footer(){
string="<div style=\"display:none\">";
string+="This site is Ajaxified by Joomlajax Plugin By Hamidreza Tavakoli, http://www.web2coder.com";
string+="</div>";
new Insertion.Bottom(document.body, string);
}
function fadeIn(){
	 var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  myWidth=(myWidth/2)-50;
  myHeight=(myHeight/2)-50;
  document.getElementById('loading').style.top=myHeight+"px";
  document.getElementById('loading').style.left=myWidth+"px";
  document.getElementById('loading').style.display="block";
}
