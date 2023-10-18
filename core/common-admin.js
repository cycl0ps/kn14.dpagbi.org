function redirectToUrl( sUrl ){
  window.location = sUrl;
} // end function selectRedirect

function displayTab( sBlock ){
  if( sBlock && gEBI( sBlock ) ){
    for( var i = 0; i < aTabsId.length; i++ ){
      gEBI( aTabsId[i] ).style.display = 'none';
    } // end for

    gEBI( sBlock ).style.display = 'block';
    createCookie( 'sSelectedTab', sBlock, 2 );

    var aLi = gEBI( 'tabsNames' ).getElementsByTagName( 'li' );
    for( var i = 0; i < aLi.length; i++ ){
      if( aLi[i].className == sBlock )
        aLi[i].getElementsByTagName( 'a' )[0].style.color = '#000';
      else
        aLi[i].getElementsByTagName( 'a' )[0].style.color = '#ca2222';
    } // end for

    gEBI( 'tabs' ).className = '';
    if( sBlock == 'tabAddFiles' || sBlock == 'tabAddedFiles' )
      gEBI( 'tabs' ).className = 'files';
  }
} // end function displayTab

function checkSelectedTab( ){
  if( isset( 'bDone' ) && bDone === true ){
    var sSelectedName = throwCookie( 'sSelectedTab' );
    if( sSelectedName && sSelectedName != '' ){
      if( sSelectedName == 'tabAddFiles' )
        sSelectedName = 'tabAddedFiles';
      displayTab( sSelectedName, null );
    }
  }
  else
    delCookie( 'sSelectedTab' );
} // end function checkSelectedTab

var aTabsId = Array( );
function getTabsArray( ){
  if( typeof document.getElementsByClassName == 'function' ){
    var aTabs = gEBI( 'tabs' ).getElementsByClassName( 'tab' );
    for( var i = 0; i < aTabs.length; i++ ){
      aTabsId[aTabsId.length] = aTabs[i].getAttribute( 'id' );
    } // end for
  }
  else{
    var aTabs = gEBI( 'tabs' ).getElementsByTagName( '*' );
    for( var i = 0; i < aTabs.length; i++ ){
      if( aTabs[i].className == 'tab' )
        aTabsId[aTabsId.length] = aTabs[i].getAttribute( 'id' );
    } // end for
  }
} // end function getTabsArray

function displayTabs( bShow ){
  if( bShow == true ){
    gEBI( "tabs" ).style.display = "block";
    gEBI( "tabsHide" ).style.display = "inline";
    gEBI( "tabsShow" ).style.display = "none";
  }
  else{
    gEBI( "tabs" ).style.display = "none";
    gEBI( "tabsHide" ).style.display = "none";
    gEBI( "tabsShow" ).style.display = "inline";
  }
} // end function displayTabs

function checkType( ){
  if( gEBI( 'oPageParent' ).value == "" ){
    gEBI( "type" ).style.display = "";
  }
  else
    gEBI( "type" ).style.display = "none";
} // end function checkType

function throwYesNoBox( sName, bSelected ){
  if( bSelected && bSelected == true )
    sSelected = ' checked="checked"';
  else
    sSelected = '';
  document.write( '<input type="checkbox" name="'+sName+'" value="1" '+sSelected+' />' );
} // end function 

function enableFields(oObj){
  var oParentTr = oObj.parentNode.parentNode;
  var aFields = oParentTr.getElementsByTagName( 'input' );
  for( var i = 0; i < aFields.length; i++ ){
    removeClassName( aFields[i], 'disable' );
  }
  aFields = oParentTr.getElementsByTagName( 'select' );
  for( var i = 0; i < aFields.length; i++ ){
    removeClassName( aFields[i], 'disable' );
  }
} // end function enableFields

var iTime = 10;
var bPauseSlide = false;
function nextNeedMoreSlide( ){
  if( bPauseSlide == true ){
    setTimeout( "nextNeedMoreSlide()", 3000 );
  }
  else{
    if( iTime == 10 ){
      iTime = 5;
      gEBI( 'needMoreIcons' ).style.display = 'block';
      gEBI( 'needMoreTxt' ).style.display = 'none';
    }
    else{
      iTime = 10;
      gEBI( 'needMoreIcons' ).style.display = 'none';
      gEBI( 'needMoreTxt' ).style.display = 'block';
    }
    setTimeout( "nextNeedMoreSlide()", iTime*1000 );
  }
} // end function 
function pauseSlide( bValue ){
  bPauseSlide = bValue;
} // end function 

function Browser() {
  var ua, s, i;
  this.isIE    = false;  // Internet Explorer
  this.isOP    = false;  // Opera
  this.isNS    = false;  // Netscape
  this.version = null;
  ua = navigator.userAgent;
  s = "Opera";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isOP = true;
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }
  s = "Netscape6/";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isNS = true;
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }
  s = "Gecko";
  if ((i = ua.indexOf(s)) >= 0) {
    this.isNS = true;
    this.version = 6.1;
    return;
  }
  s = "MSIE";
  if ((i = ua.indexOf(s))) {
    this.isIE = true;
    this.version = parseFloat(ua.substr(i + s.length));
    return;
  }
}

var browser = new Browser();
var activeButton = null;
if (browser.isIE)
  document.onmousedown = pageMousedown;
else
  document.addEventListener("mousedown", pageMousedown, true);

function pageMousedown(event) {
  var el;
  if (activeButton == null)
    return;
  if (browser.isIE)
    el = window.event.srcElement;
  else
    el = (event.target.tagName ? event.target : event.target.parentNode);
  if (el == activeButton)
    return;
  if (getContainerWith(el, "DIV", "menu") == null) {
    resetButton(activeButton);
    activeButton = null;
  }
}

function buttonClick(event, menuId) {
  var button;
  if (browser.isIE)
    button = window.event.srcElement;
  else
    button = event.currentTarget;
  button.blur();
  if (button.menu == null) {
    button.menu = document.getElementById(menuId);
    if (button.menu.isInitialized == null)
      menuInit(button.menu);
  }
  if (activeButton != null && button != activeButton)
    resetButton(activeButton);
  if (button != activeButton) {
    depressButton(button);
    activeButton = button;
  }
  else
    activeButton = null;
  return false;
}

function buttonMouseover(event, menuId) {
  var button;
  if (browser.isIE)
    button = window.event.srcElement;
  else
    button = event.currentTarget;
  if (activeButton != null && activeButton != button)
    buttonClick(event, menuId);
}

function depressButton(button) {
  var x, y;
  button.className += " menuButtonActive";
  x = getPageOffsetLeft(button);
  y = getPageOffsetTop(button) + button.offsetHeight;
  if (browser.isIE) {
    x += button.offsetParent.clientLeft;
    y += button.offsetParent.clientTop;
  }
  button.menu.style.left = x + "px";
  button.menu.style.top  = y + "px";
  button.menu.style.visibility = "visible";
}

function resetButton(button) {
  removeClassName(button, "menuButtonActive");
  if (button.menu != null) {
    closeSubMenu(button.menu);
    button.menu.style.visibility = "hidden";
  }
}

function menuMouseover(event) {
  var menu;
  if (browser.isIE)
    menu = getContainerWith(window.event.srcElement, "DIV", "menu");
  else
    menu = event.currentTarget;
  if (menu.activeItem != null)
    closeSubMenu(menu);
}

function menuItemMouseover(event, menuId) {
  var item, menu, x, y;
  if (browser.isIE)
    item = getContainerWith(window.event.srcElement, "A", "menuItem");
  else
    item = event.currentTarget;
  menu = getContainerWith(item, "DIV", "menu");
  if (menu.activeItem != null)
    closeSubMenu(menu);
  menu.activeItem = item;
  item.className += " menuItemHighlight";
  if (item.subMenu == null) {
    item.subMenu = document.getElementById(menuId);
    if (item.subMenu.isInitialized == null)
      menuInit(item.subMenu);
  }
  x = getPageOffsetLeft(item) + item.offsetWidth;
  y = getPageOffsetTop(item);
  var maxX, maxY;
  if (browser.isIE) {
    maxX = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft) +
      (document.documentElement.clientWidth != 0 ? document.documentElement.clientWidth : document.body.clientWidth);
    maxY = Math.max(document.documentElement.scrollTop, document.body.scrollTop) +
      (document.documentElement.clientHeight != 0 ? document.documentElement.clientHeight : document.body.clientHeight);
  }
  if (browser.isOP) {
    maxX = document.documentElement.scrollLeft + window.innerWidth;
    maxY = document.documentElement.scrollTop  + window.innerHeight;
  }
  if (browser.isNS) {
    maxX = window.scrollX + window.innerWidth;
    maxY = window.scrollY + window.innerHeight;
  }
  maxX -= item.subMenu.offsetWidth;
  maxY -= item.subMenu.offsetHeight;
  if (x > maxX)
    x = Math.max(0, x - item.offsetWidth - item.subMenu.offsetWidth
      + (menu.offsetWidth - item.offsetWidth));
  y = Math.max(0, Math.min(y, maxY));
  item.subMenu.style.left = x + "px";
  item.subMenu.style.top  = y + "px";
  item.subMenu.style.visibility = "visible";
  if (browser.isIE)
    window.event.cancelBubble = true;
  else
    event.stopPropagation();
}

function closeSubMenu(menu) {
  if (menu == null || menu.activeItem == null)
    return;
  if (menu.activeItem.subMenu != null) {
    closeSubMenu(menu.activeItem.subMenu);
    menu.activeItem.subMenu.style.visibility = "hidden";
    menu.activeItem.subMenu = null;
  }
  removeClassName(menu.activeItem, "menuItemHighlight");
  menu.activeItem = null;
}

function menuInit(menu) {
  var itemList, spanList;
  var textEl, arrowEl;
  var itemWidth;
  var w, dw;
  var i, j;
  if (browser.isIE) {
    menu.style.lineHeight = "2.5ex";
    spanList = menu.getElementsByTagName("SPAN");
    for (i = 0; i < spanList.length; i++)
      if (hasClassName(spanList[i], "menuItemArrow")) {
        spanList[i].style.fontFamily = "Webdings";
        spanList[i].firstChild.nodeValue = "4";
      }
  }
  itemList = menu.getElementsByTagName("A");
  if (itemList.length > 0)
    itemWidth = itemList[0].offsetWidth;
  else
    return;
  for (i = 0; i < itemList.length; i++) {
    spanList = itemList[i].getElementsByTagName("SPAN");
    textEl  = null;
    arrowEl = null;
    for (j = 0; j < spanList.length; j++) {
      if (hasClassName(spanList[j], "menuItemText"))
        textEl = spanList[j];
      if (hasClassName(spanList[j], "menuItemArrow")) {
        arrowEl = spanList[j];
      }
    }
    if (textEl != null && arrowEl != null) {
      textEl.style.paddingRight = (itemWidth 
        - (textEl.offsetWidth + arrowEl.offsetWidth)) + "px";
      if (browser.isOP)
        arrowEl.style.marginRight = "0px";
    }
  }
  if (browser.isIE) {
    w = itemList[0].offsetWidth;
    itemList[0].style.width = w + "px";
    dw = itemList[0].offsetWidth - w;
    w -= dw;
    itemList[0].style.width = w + "px";
  }
  menu.isInitialized = true;
}

function getContainerWith(node, tagName, className) {
  while (node != null) {
    if (node.tagName != null && node.tagName == tagName &&
        hasClassName(node, className))
      return node;
    node = node.parentNode;
  }
  return node;
}

function hasClassName(el, name) {
  var i, list;
  list = el.className.split(" ");
  for (i = 0; i < list.length; i++)
    if (list[i] == name)
      return true;
  return false;
}

function removeClassName(el, name) {
  var i, curList, newList;
  if (el.className == null)
    return;
  newList = new Array();
  curList = el.className.split(" ");
  for (i = 0; i < curList.length; i++)
    if (curList[i] != name)
      newList.push(curList[i]);
  el.className = newList.join(" ");
}

function getPageOffsetLeft(el) {
  var x;
  x = el.offsetLeft;
  if (el.offsetParent != null)
    x += getPageOffsetLeft(el.offsetParent);
  return x;
}

function getPageOffsetTop(el) {
  var y;
  y = el.offsetTop;
  if (el.offsetParent != null)
    y += getPageOffsetTop(el.offsetParent);
  return y;
}

function del( ){
  if( confirm( delShure ) ) 
    return true;
  else 
    return false
} // end function del

function delConfirm( iId, aTxt, aUrl ){
	var oCancel = new LertButton(Cancel, function() {
		//do nothing
	});
	var oButton0 = new LertButton(aTxt[0], function() {
		window.location.href = aUrl[0] + iId;
	});
	var oButton1 = new LertButton(aTxt[1], function() {
		window.location.href = aUrl[1] + iId;
	});
	var message = '<strong>'+delShure+'</strong>';
	var delConfirmLert = new Lert(
		message,
		[oButton0,oButton1,oCancel],
		{
			defaultButton:oButton0,
			icon:'templates/admin/img/dialog-warning.png'
		});
	delConfirmLert.display();
} // end function delConfirm

function cursor( ){
  if( document.form.sLogin.value == "" ){
    document.form.sLogin.focus( );
  }
  else{
    document.form.sPass.focus( );        
  }
} // end function cursor

function showPreviewButton( oObj ){
  oObj.getElementsByTagName( 'a' )[1].className = '';
} // end function showPreviewButton

function hidePreviewButton( oObj ){
  oObj.getElementsByTagName( 'a' )[1].className = 'preview';
} // end function hidePreviewButton

function listTableSearch( sPhrase, sTableId, iCell ) {
	var aPhrases = sPhrase.value.toLowerCase().split(" ");
  var oTable = gEBI( sTableId );
  var sDisplay = null;
	for( var i = 0; i < oTable.rows.length; i++ ){
		sDisplay = '';
		for( var j = 0; j < aPhrases.length; j++ ){
			if( oTable.rows[i].cells[iCell].innerHTML.replace( /<[^>]+>/g, '' ).toLowerCase().indexOf( aPhrases[j] ) < 0 )
				sDisplay = 'none';
			oTable.rows[i].style.display = sDisplay;
		}
	}
}