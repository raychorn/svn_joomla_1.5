/************************************************************************************************************
	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.	
	
************************************************************************************************************/
		
	var readSizeFromCookie = false;	// Determines if size and position of windows should be set/retreved by use of cookie
	var windowMinSize = [80,30];	// Mininum width and height of windows.
	var moveCounter = -1;	
	var startEventPos = new Array();
	var startPosWindow = new Array();
	var startWindowSize = new Array();
	var initResizeCounter = -1;	
	var activeWindow = false;
	var activeWindowContent = false;	
	var windowSizeArray = new Array();
	var windowPositionArray = new Array();
	var currentZIndex = 10000;
	var windowStateArray = new Array();	// Minimized or maximized
	var activeWindowIframe = false;
	var divCounter = 0;
	var zIndexSet = false;
	
	var CloseDiv='CloseDiv';
	var book_detail='book_detail';
	var bookmark_link='bookmark_link';
	var bookimg='bookimg';
	
	var MSIEWIN = (navigator.userAgent.indexOf('MSIE')>=0 && navigator.userAgent.indexOf('Win')>=0 && navigator.userAgent.toLowerCase().indexOf('opera')<0)?true:false;
	var opera = navigator.userAgent.toLowerCase().indexOf('opera')>=0?true:false;
	
	var ajaxObjects = new Array();
    
	var isWindowDisplayed = false;

	var imagePath;	
	var MainDivID;
    		
	function Get_Cookie(name) { 

	}
    
	function Set_Cookie(name,value,expires,path,domain,secure) { 
	} 
			
	function cancelEvent()
	{
		return (moveCounter==-1 && initResizeCounter==-1)?true:false;
	}
	function initMove1(e)
	{		
		if(document.all)e = event;
		moveCounter = 0;
		switchElement1(false,this);
		startEventPos = [e.clientX,e.clientY];
		startPosWindow = [activeWindow.offsetLeft,activeWindow.offsetTop];
		startMove1();
		if(!MSIEWIN)return false;
	
	}
	
	function startMove1()
	{
		if(moveCounter>=0 && moveCounter<=10){
			moveCounter++;
			setTimeout('startMove1()',5);
		}
	}
	
	function stopMove1(e)
	{
		if(document.all)e = event;
		moveCounter=-1;
		initResizeCounter=-1;
		if(!activeWindow || !activeWindowContent)return;
		var state = '0';
		if(windowStateArray[activeWindow.id.replace(/[^0-9]/g,'')])state = '1';
		
		Set_Cookie(activeWindow.id + '_attr',activeWindow.style.left.replace('px','') + ',' + activeWindow.style.top.replace('px','') + ',' + activeWindow.style.width.replace('px','') + ',' + activeWindowContent.style.height.replace('px','') + ',' + activeWindow.style.zIndex + ',' + state,50);
	}
	
	function moveWindow1(e)
	{
		
		if(document.all)e = event;
		if(moveCounter>=10){
			activeWindow.style.left = startPosWindow[0] + e.clientX - startEventPos[0]  + 'px';
			activeWindow.style.top = startPosWindow[1] + e.clientY - startEventPos[1]  + 'px';
			
		}	
		
		if(initResizeCounter>=10){
			var newWidth = Math.max(windowMinSize[0],startWindowSize[0] + e.clientX - startEventPos[0]);
			var newHeight = Math.max(windowMinSize[1],startWindowSize[1] + e.clientY - startEventPos[1]);
			activeWindow.style.width =  newWidth + 'px';
			activeWindowContent.style.height = newHeight  + 'px';		
			
			if(MSIEWIN && activeWindowIframe){
				activeWindowIframe.style.width = (newWidth) + 'px';	
				activeWindowIframe.style.height = (newHeight+20) + 'px';	
			}
				
			
		}
		if(!document.all)return false;
	}
	
	
	function initResizeWindow1(e)
	{
		if(document.all)e = event;
		initResizeCounter = 0;
		switchElement1(false,document.getElementById('sbz_book_mark_id' + this.id.replace(/[^\d]/g,'')));

		startWindowSize = [activeWindowContent.offsetWidth,activeWindowContent.offsetHeight];
		startEventPos = [e.clientX,e.clientY];
		
		if(MSIEWIN)activeWindowIframe = activeWindow.getElementsByTagName('IFRAME')[0];
		startResizeWindow1();
		return false;
			
	}
	
	function startResizeWindow1()
	{
		if(initResizeCounter>=0 && initResizeCounter<=10){
			initResizeCounter++;
			setTimeout('startResizeWindow1()',5);
		}
	}
	
	function switchElement1(e,inputElement)
	{
		if(!inputElement)inputElement = this;
		var numericId = inputElement.id.replace(/[^0-9]/g,'');
		var state = '0';
		if(windowStateArray[numericId])state = '1';
			
		if(activeWindow && activeWindowContent){
			Set_Cookie(activeWindow.id + '_attr',activeWindow.style.left.replace('px','') + ',' + activeWindow.style.top.replace('px','') + ',' + activeWindow.style.width.replace('px','') + ',' + activeWindowContent.style.height.replace('px','') + ',' + activeWindow.style.zIndex + ',' + state,50);
	
		}
		currentZIndex = currentZIndex/1 + 1;
		activeWindow = document.getElementById('sbz_book_mark_id' + numericId);	
		activeWindow.style.zIndex = currentZIndex;
		activeWindowContent = document.getElementById('windowContent' + numericId);

		Set_Cookie(activeWindow.id + '_attr',activeWindow.style.left.replace('px','') + ',' + activeWindow.style.top.replace('px','') + ',' + activeWindow.style.width.replace('px','') + ',' + activeWindowContent.style.height.replace('px','') + ',' + activeWindow.style.zIndex + ',' + state,50);
	}
	
	function hideWindow1()
	{
		switchElement1(false,document.getElementById('sbz_book_mark_id' + this.id.replace(/[^\d]/g,'')));	
		activeWindow.style.display='none';
        isWindowDisplayed = false;
	}
	
	function minimizeWindow1(e,inputObj)
	{
		if(!inputObj)inputObj = this;
		var numericID = inputObj.id.replace(/[^0-9]/g,'');
		switchElement1(false,document.getElementById('sbz_book_mark_id' + numericID));
		var state;	
		if(inputObj.src.indexOf('minimize')>=0){
			activeWindowContent.style.display='none';
			document.getElementById('resizeImage'+numericID).style.display='none';
			inputObj.src = inputObj.src.replace('minimize','maximize');	
			windowStateArray[numericID] = false;
			state = '0';		
		}else{			
			activeWindowContent.style.display='block';
			document.getElementById('resizeImage'+numericID).style.display='';
			inputObj.src = inputObj.src.replace('maximize','minimize');
			windowStateArray[numericID] = true;
			state = '1';
		}
		
		Set_Cookie(activeWindow.id + '_attr',activeWindow.style.left.replace('px','') + ',' + activeWindow.style.top.replace('px','') + ',' + activeWindow.style.width.replace('px','') + ',' + activeWindowContent.style.height.replace('px','') + ',' + activeWindow.style.zIndex + ',' + state,50);

	}
	
	function initWindows1(e,divObj)
	{
		
		
		var divs = document.getElementsByTagName('DIV');
		
		if(divObj){
			var tmpDivs = divObj.getElementsByTagName('DIV');
			var divs = new Array();
			divs[divs.length] = divObj;
			
			for(var no=0;no<tmpDivs.length;no++){
				divs[divs.length] = tmpDivs[no];
			}
		}
		
		for(var no=0;no<divs.length;no++){
			
			if(divs[no].className=='sbz_bookmark_window'){	
		
				if(MSIEWIN){
					var iframe = document.createElement('IFRAME');
					iframe.style.border='0px';
					iframe.frameborder=0;
					iframe.style.position = 'absolute';
					iframe.style.backgroundColor = '#FFFFFF';
					iframe.style.top = '0px';
					iframe.style.left = '0px';
					iframe.style.zIndex = 100;
				
					
					var subDiv = divs[no].getElementsByTagName('DIV')[0];
					divs[no].insertBefore(iframe,subDiv);
					
				}					
				if(divObj){
					divs[no].style.zIndex = currentZIndex;
					currentZIndex = currentZIndex /1 + 1;
				}
				
				divCounter = divCounter + 1;	
				if(divCounter==1)activeWindow = divs[no];		
				divs[no].id = 'sbz_book_mark_id' + divCounter;	
				divs[no].onmousedown = switchElement1;
				if(readSizeFromCookie)var cookiePos = Get_Cookie(divs[no].id + '_attr') + '';	else cookiePos = '';
				if(divObj)cookiePos='';
				var cookieValues = new Array();
				
					
				if(cookiePos.indexOf(',')>0){
					cookieValues = cookiePos.split(',');
					if(!windowPositionArray[divCounter])windowPositionArray[divCounter] = new Array();
					windowPositionArray[divCounter][0] = Math.max(0,cookieValues[0]);
					windowPositionArray[divCounter][1] = Math.max(0,cookieValues[1]);
				}

				if(cookieValues.length==5 && !zIndexSet){
					divs[no].style.zIndex = cookieValues[4];
					if(cookieValues[4]/1 > currentZIndex)currentZIndex = cookieValues[4]/1;					
				}
				if(windowPositionArray[divCounter]){
					divs[no].style.left = windowPositionArray[divCounter][0] + 'px';	
					divs[no].style.top = windowPositionArray[divCounter][1] + 'px';	
				}
				
				var subImages = divs[no].getElementsByTagName('IMG');
				for(var no2=0;no2<subImages.length;no2++){
					if(subImages[no2].className=='resizeImage'){
						subImages[no2].style.cursor = 'nw-resize';
						subImages[no2].onmousedown = initResizeWindow1;
						subImages[no2].id = 'resizeImage' + divCounter;
						break;
					}	
					if(subImages[no2].className=='closeButton'){ 
						subImages[no2].id = 'closeImage' + divCounter;
						subImages[no2].onclick = hideWindow1;	
					}	
					if(subImages[no2].className=='minimizeButton'){
						subImages[no2].id = 'minimizeImage' + divCounter;
						subImages[no2].onclick = minimizeWindow1;	
						if(cookieValues.length==6 && cookieValues[5]=='0'){							
							setTimeout('minimizeWindow1(false,document.getElementById("minimizeImage' + divCounter + '"))',10);
						}
						if(cookieValues.length==6 && cookieValues[5]=='1'){							
							windowStateArray[divCounter] = 1;
						}
						
						
					}
				}			
			}	
			if(divs[no].className=='sbz_bookmark_windowMiddle' || divs[no].className=='sbz_bookmark_window_bottom'){
				divs[no].style.zIndex = 1000;
				
			}
			if(divs[no].className=='sbz_bookmark_window_top'){
				divs[no].onmousedown = initMove1;
				divs[no].id = 'top_bar'+divCounter;
				divs[no].style.zIndex = 1000;
	
			}

			if(divs[no].className=='sbz_bookmark_windowContent'){
				divs[no].id = 'windowContent'+divCounter;
				divs[no].style.zIndex = 1000;
				if(cookieValues && cookieValues.length>3){
					if(!windowSizeArray[divCounter])windowSizeArray[divCounter] = new Array();
					windowSizeArray[divCounter][0] = cookieValues[2];
					windowSizeArray[divCounter][1] = cookieValues[3];
				}	
				if(cookieValues && cookieValues.length==5){
					activeWindowContent = document.getElementById('windowContent' + divCounter);	
				}		
				if(windowSizeArray[divCounter]){
					divs[no].style.height = windowSizeArray[divCounter][1] + 'px';
					divs[no].parentNode.parentNode.style.width = windowSizeArray[divCounter][0] + 'px';
					
					if(MSIEWIN){
						iframe.style.width = (windowSizeArray[divCounter][0]) + 'px';
						iframe.style.height = (windowSizeArray[divCounter][1]+20) + 'px';
					}
				}
			}

			
		}	
		
		if(!divObj){
			document.documentElement.onmouseup = stopMove1;	
			document.documentElement.onmousemove = moveWindow1;
			document.documentElement.ondragstart = cancelEvent;
			document.documentElement.onselectstart = cancelEvent;
		}
		
		return divCounter;
	}

	function createNewWindow1(width,height,left,top)
	{
		var div = document.createElement('DIV');  
		div.className='sbz_bookmark_window';
		document.body.appendChild(div); 
        
		var topDiv = document.createElement('DIV');
		topDiv.className='sbz_bookmark_window_top';
		div.appendChild(topDiv);
		
		var buttonDiv = document.createElement('DIV');
		buttonDiv.className='top_buttons';
		topDiv.appendChild(buttonDiv);
		
		
		var middleDiv = document.createElement('DIV');
		middleDiv.className='sbz_bookmark_windowMiddle';
		div.appendChild(middleDiv);
		
		var contentDiv = document.createElement('DIV');
		contentDiv.className='sbz_bookmark_windowContent';
		middleDiv.appendChild(contentDiv);
		
		var bottomDiv = document.createElement('DIV');
		bottomDiv.className='sbz_bookmark_window_bottom';
		div.appendChild(bottomDiv);
		

		windowSizeArray[windowSizeArray.length] = [width,height];
		windowPositionArray[windowPositionArray.length] = [left,top];

		div.style.width =  width + 'px';
		//contentDiv.style.height = height  + 'px';		
        contentDiv.style.height = '100%';        
		div.style.left =  left + 'px';
		div.style.top = top  + 'px';	
       
           
		return initWindows1(false,div);
		
		
		 	
	}
	
	function showAjaxContent1(ajaxIndex,windowId)
	{
		document.getElementById('windowContent' + windowId).innerHTML = ajaxObjects[ajaxIndex].response;			
	}
	
	function addContentFromUrl1(url,windowId)
	{
		var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
		ajaxObjects[ajaxIndex].onCompletion = function(){ showAjaxContent1(ajaxIndex,windowId); };	// Specify function that will be executed after file has been found
		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function			
	}
	
		
	/* This function illustrates how you can create a new custom window dynamically */
	function customFunctionCreateWindow1(urlToExternalFile,width,height,left,top)
	{		
		var divId = createNewWindow1(width,height,left,top);
        MainDivID = divId;
        
        document.getElementById('windowContent' + divId).innerHTML = document.getElementById(this.CloseDiv).innerHTML;;
        document.getElementById('windowContent' + divId).innerHTML = (document.getElementById('windowContent' + divId).innerHTML) + document.getElementById(this.book_detail).innerHTML;
        
		if(urlToExternalFile)addContentFromUrl1(urlToExternalFile,divId);	// Add content from external file
        isWindowDisplayed = true;
	}
	
    function fnShowBookContainer1(e,position,imgPath,CloseDiv,book_detail,bookmark_link,bookimg)
    {
        // Temporary variables to hold mouse x-y pos.s
		
		if(!CloseDiv)
		  this.CloseDiv = 'CloseDiv';
		else  
		  this.CloseDiv = CloseDiv;
		  
		if(!book_detail)
		  book_detail = 'book_detail';
		else
		  this.book_detail = book_detail;
		
		
		if(!bookmark_link)
		  this.bookmark_link = 'bookmark_link';
		else
		  this.bookmark_link = bookmark_link;
		  
		if(!bookimg)
		  this.bookimg = 'bookimg';
		else  
		  this.bookimg = bookimg;
		  
        var tempX = 0
        var tempY = 0
        
        var winHeight = 175;
        var winWidth  = 450;
        
        if(imgPath!='')
        {
           imagePath = imgPath;           
        }
                
        if(isWindowDisplayed)
        {
            return true;
        }
        if(position=='bottom')
        {
           tempX = AnchorPosition_getPageOffsetLeft1(document.getElementById(this.bookmark_link));  
           tempY = document.getElementById(this.bookimg).height + AnchorPosition_getPageOffsetTop1(document.getElementById(this.bookmark_link));               
           
        }else if(position=='left')
        {
           tempX = AnchorPosition_getPageOffsetLeft1(document.getElementById(this.bookmark_link)) - winWidth; 
           tempY = AnchorPosition_getPageOffsetTop1(document.getElementById(this.bookmark_link));                
        }
        else if(position=='right')
        {
           tempX = AnchorPosition_getPageOffsetLeft1(document.getElementById(this.bookmark_link)) + document.getElementById(this.bookimg).width; 
           tempY = AnchorPosition_getPageOffsetTop1(document.getElementById(this.bookmark_link));                
        }
        else if(position=='top')
        {
           tempX = AnchorPosition_getPageOffsetLeft1(document.getElementById(this.bookmark_link));
           tempY = (AnchorPosition_getPageOffsetTop1(document.getElementById(this.bookmark_link)) - winHeight) - document.getElementById(this.bookimg).height;               
        }
        customFunctionCreateWindow1(false,winWidth,winHeight,tempX,tempY)    
    } 
    
    function AnchorPosition_getPageOffsetLeft1(el) 
    {
        var ol=el.offsetLeft;
        while ((el=el.offsetParent) != null) { ol += el.offsetLeft; }
        return ol;
    }
    function AnchorPosition_getWindowOffsetLeft1 (el) 
    {
        return AnchorPosition_getPageOffsetLeft1(el)-document.body.scrollLeft;
    }    
    function AnchorPosition_getPageOffsetTop1 (el) 
    {
        var ot=el.offsetTop;
        while((el=el.offsetParent) != null) { ot += el.offsetTop; }
        return ot;
    }
    function AnchorPosition_getWindowOffsetTop (el) 
    {
        return AnchorPosition_getPageOffsetTop1(el)-document.body.scrollTop;
    }
    
    
	window.onload = initWindows1;
    
    function MyhideWindow(){
        document.getElementById('sbz_book_mark_id'+MainDivID).innerHTML='';  
        isWindowDisplayed = false;  
    }
