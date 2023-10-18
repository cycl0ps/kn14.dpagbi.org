<!-- BEGIN HEAD -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[admin_lang]" lang="$config[admin_lang]">
<head>
  <title>$lang['Admin'] - $config[title]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Description" content="" />
  <meta name="Keywords" content="" />
  <meta name="Generator" content="Quick.Cms" />
  <script type="text/javascript" src="$config[dir_core]common.js"></script>
  <script type="text/javascript" src="$config[dir_core]common-admin.js"></script>
  <script type="text/javascript" src="$config[dir_core]check-form.js"></script>
  <script type="text/javascript" src="$config[dir_core]lert.js"></script>
  <link rel="stylesheet" href="$config[dir_templates]admin/style.css" type="text/css" />
  <script type="text/javascript">
    <!--
    var cfBorderColor     = "#666666";
    var cfLangNoWord      = "$lang[cf_no_word]";
    var cfLangMail        = "$lang[cf_mail]";
    var cfWrongValue      = "$lang[cf_wrong_value]";
    var cfToSmallValue    = "$lang[cf_to_small_value]";
    var cfTxtToShort      = "$lang[cf_txt_to_short]";

    var delShure = "$lang['Operation_sure']";
    var yes = "$lang[yes]";
    var no = "$lang[no]";
    var Cancel = "$lang[Cancel]";
    var Yes = "$lang[Yes]";
    var YesWithoutFiles = "$lang[Yes_without_files]";
    var aDelTxt = Array( Yes, YesWithoutFiles );
    //-->
  </script><!-- END HEAD --><!-- BEGIN BODY -->
</head>

<body>
  <div id="container">
    $sMsg
    <div id="header">
      <div id="menuTop">
        <div id="links"><a href="?p=">$lang['dashboard']</a>|<a href="?p=logout"><strong>$lang['log_out']</strong></a> ($lang['Last_login']: <strong>$sDateLog</strong>)<!-- menu top end --></div>
        <form action="" method="get" id="searchPanel">
          <fieldset>
            <input type="hidden" name="p" value="search" />
            <input type="text" name="sPhrase" value="$sPhrase" class="input" size="25" />
            <select name="iTypeSearch">$sTypeSearchSelect</select>
            <input type="submit" value="$lang['search'] &raquo;" />
          </fieldset>
        </form>
        <div id="lang">$lang[Language]: <select name="" onchange="redirectToUrl( '$_SERVER[PHP_SELF]?sLang='+this.value )">$sLangSelect</select></div>
      </div>
      <div id="logoOs">
        <a href="http://opensolution.org/"><img src="$config[dir_templates]admin/img/logo_os.jpg" alt="OpenSolution.org" /></a>
      </div>
      <div class="clear"></div>

      <!-- menu under_logo start -->
      <ul id="menuBar">
        <li onmouseover="return buttonClick( event, 'pages' ); buttonMouseover( event, 'pages' );"><a href="?p=pages-list"><span class="pages">$lang['Pages']</span></a></li>
        <li onmouseover="return buttonClick( event, 'files' ); buttonMouseover( event, 'files' );"><a href="?p=files-list"><span class="files">$lang['Files']</span></a></li>
        <li onmouseover="return buttonClick( event, 'tools' ); buttonMouseover( event, 'tools' );"><a href="#"><span class="tools">$lang[Tools]</span></a></li>
        <!-- menu under_logo bar end -->
      </ul>

      <!-- submenu under_logo start -->
      <div id="pages" class="menu" onmouseover="menuMouseover( event );">
        <a href="?p=pages-form">$lang['New_page']</a>
      </div>
      <div id="tools" class="menu" onmouseover="menuMouseover( event );">
        <a href="?p=tools-config">$lang['Settings']</a>
        <span class="sep">&nbsp;</span>
        <a href="?p=lang-list">$lang['Languages']</a>
        <a href="?p=lang-form">$lang['New_language']</a>
      </div>
      <div id="files" class="menu" onmouseover="menuMouseover( event );"></div>
      <!-- menu under_logo end -->

    </div>
    <div class="clear"></div>
    <div id="body">
      $content <!-- this variable loads content of all forms, settings, lists etc -->
      <!-- END BODY --><!-- BEGIN FOOT -->
      <div id="back">
        &laquo; <a href="javascript:history.back();">$lang[back]</a>
      </div>
    </div>
  </div>
</body>
</html>
<!-- END FOOT -->

<!-- BEGIN HOME -->
<h1>$lang['Dashboard']</h1>
<div class="mainPage">
  <table cellspacing="0" id="mainPage">
    <tr>
      <td id="eventsLinks">
        <div id="newEventsBox" class="homeBox">
          <h2>$lang['New_events']</h2>

          <div id="tabs">
            <ul id="tabsNames">
              <!-- tabs start -->
              <li class="tabPages"><a href="#more" onclick="displayTab( 'tabPages' )">$lang['Pages']</a></li>
              <li class="tabFiles"><a href="#more" onclick="displayTab( 'tabFiles' )">$lang['Files']</a></li>
              <!-- tabs end -->
            </ul>
            <div id="tabsForms">
              <!-- tabs list start -->
              <div class="tab" id="tabPages">
                $sListEventsPages
              </div>
              <div class="tab" id="tabFiles">
                $sListEventsFiles
              </div>
            </div>
          </div>
          <script type="text/javascript">
          <!--
          AddOnload( getTabsArray );
          AddOnload( checkSelectedTab );
          AddOnload( nextNeedMoreSlide );
          //-->
          </script>
        </div>

        <div id="needMore" class="homeBox" onmouseover="pauseSlide( true )" onmouseout="pauseSlide( false )">
          <h2>$lang['Need_more']</h2>
          <ul id="needMoreIcons">
            <li><a href="http://opensolution.org/?p=support"><img src="$config[dir_templates]admin/img/ico_home_support.png" alt="$lang['Support']" />$lang['Support']</a></li>
            <li><a href="http://opensolution.org/?p=download&amp;sDir=Quick.Cms"><img src="$config[dir_templates]admin/img/ico_home_plugins.png" alt="$lang['Free_addons']" />$lang['Free_addons']</a></li>
            <li><a href="http://opensolution.org/?p=Quick.Cms_editions"><img src="$config[dir_templates]admin/img/ico_home_editions.png" alt="$lang['Editions']" />$lang['Editions']</a></li>
          </ul>
          <div id="needMoreTxt"><iframe src="http://opensolution.org/need-more,$config[admin_lang],$config[version].html?sUrl=$_SERVER[HTTP_HOST]&amp;sVer=Quick.Cms"></iframe></div>
        </div>
      
      </td>
      <td id="news">
        <div id="newsBox" class="homeBox">
          <h2>$lang['News_from_os']</h2>
          <!-- WE DONT RECOMMEND TO DELETE THIS IFRAME, ALL BUG FIXES NEWS ETC. FROM OPENSOLUTION.ORG WILL DISAPPEAR -->
          <iframe src="http://opensolution.org/news,$config[admin_lang],$config[version].html?sUrl=$_SERVER[HTTP_HOST]&amp;sVer=Quick.Cms"></iframe>
        </div>
      </td>
    </tr>
  </table>
</div>
<!-- END HOME -->

<!-- BEGIN EVENTS -->
<table cellspacing="0">
  <thead>
    <tr><!-- IF:START PAGES -->
      <td>$lang['Id']</td><td>$lang['Name']</td><!-- IF:END PAGES --><!-- IF:START FILES -->
      <td>$lang['Id']</td><td>$lang['Name']</td><td>$lang['Added_to']</td><!-- IF:END FILES -->
    </tr>
  </thead>
  <tbody><!-- START LIST -->
    <tr>
      <td class="id">
        $aData[iId]
      </td>
      <td class="name">
        <a href="$aData[sLink]">$aData[sName]</a>
      </td><!-- IF:START DATA -->
      <td class="data">
        $aData[sData]
      </td><!-- IF:END DATA -->
    </tr><!-- END LIST -->
  </tbody>
</table>
<!-- END EVENTS -->

<!-- BEGIN LOGIN_PANEL -->
</head>
<body id="bodyLogin">
  <div id="panelLogin">
    <div id="top"></div>
    <div id="body">
      <div id="logo"><a href="?p="><img src="$config[dir_templates]admin/img/logo_os.jpg" alt="OpenSolution"/></a></div><!-- IF:START FORM -->
      <script type="text/javascript">
        <!--
        AddOnload( cursor );
        //-->
      </script>
      <form method="post" action="$sLoginPage" name="form">
        <fieldset>
          <input type="hidden" name="sLoginPageNext" value="$_SERVER[REQUEST_URI]" />
          <div id="login"><label>$lang['Login']:</label><input type="text" name="sLogin" class="input" value="$_COOKIE[sLogin]" /></div>
          <div id="pass"><label>$lang['Password']:</label><input type="password" name="sPass" class="input" value="" /></div>
          <div id="submit"><input type="submit" value="$lang['log_in'] &raquo;" /></div>
        </fieldset>
      </form><!-- IF:END FORM --><!-- IF:START INCORRECT -->
      <div id="error">
        $lang['Wrong_login_or_pass']
        <div id="back"><a href="javascript:history.back()">&laquo; $lang['back']</a></div>
      </div><!-- IF:END INCORRECT --><!-- IF:START FAILED_LOGIN -->
      <div id="error">
        $lang['Falied_login_wait_time']
      </div><!-- IF:END FAILED_LOGIN -->
    </div>
    <div id="bottom">
      <div id="home"><a href="">$lang['homepage']</a></div>
      <div id="version"><a href="http://opensolution.org/">Quick.Cms v$config[version]</a></div>
<!-- END LOGIN_PANEL -->