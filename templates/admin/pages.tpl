<!-- BEGIN LIST_TITLE -->
<h1><img src="$config[dir_templates]admin/img/ico_pages.gif" alt="$lang['Pages']" />$lang['Pages']<a href="$config['manual_link']instruction#3" title="$lang[Manual]" target="_blank"></a></h1>
<form action="" method="get" id="search">
  <fieldset>
    <input type="hidden" name="p" value="$p" />
    <input type="hidden" name="sSort" value="$sSort" />
    <input type="text" name="sPhrase" value="$sPhrase" class="input" size="50" />
    <input type="submit" value="$lang['search'] &raquo;" />
  </fieldset>
</form>
<!-- END LIST_TITLE -->

<!-- BEGIN PAGES -->
<script type="text/javascript">
<!--
var aDelUrl = Array( '?p=$aActions[f]-delete&iPage=', '?p=$aActions[f]-delete&bWithoutFiles=true&iPage=' );
//-->
</script>
<form action="?p=$p&amp;sPhrase=$sPhrase&amp;sSort=$sSort" method="post">
  <fieldset>
    <table id="list" class="pages" cellspacing="1">
      <thead>
        <tr class="save">
          <th colspan="5">
            <input type="submit" name="sOption" value="$lang['save'] &raquo;" />
          </th>
        </tr>
        <tr>
          <td class="id"><a href="?p=$p&amp;sSort=id&amp;sPhrase=$sPhrase">$lang['Id']</a></td>
          <td class="name"><a href="?p=$p&amp;sSort=name&amp;sPhrase=$sPhrase">$lang['Name']</a></td>
          <td class="position"><a href="?p=$p&amp;sPhrase=$sPhrase">$lang['Position']</a></td>
          <td class="status">$lang['Status']</td>
          <td class="options">&nbsp;</td>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="5">
            <input type="submit" name="sOption" value="$lang['save'] &raquo;" />
          </th>
        </tr>
      </tfoot>
      <tbody><!-- START LIST --><!-- IF:START TYPE -->
        <tr class="type">
          <td colspan="5">
            $sType
          </td>
        </tr><!-- IF:END TYPE -->
        <tr class="l$aData[iDepth]" onmouseover="showPreviewButton( this )" onmouseout="hidePreviewButton( this )">
          <td class="id">
            $aData[iPage]
          </td>
          <th class="name">
            <a href="?p=$aActions[f]-form&amp;iPage=$aData[iPage]">$aData[sName]</a><a href="./$aData[sLinkName]" target="_blank" class="preview"><img src="$config[dir_templates]admin/img/ico_prev.gif" alt="$lang['preview']" title="$lang['preview']" /></a>
          </th>
          <td class="position">
            <input type="text" name="aPositions[$aData[iPage]]" value="$aData[iPosition]" class="inputr" size="2" maxlength="3" />
          </td>
          <td class="status">
            <input type="checkbox" name="aStatus[$aData[iPage]]" $aData[sStatusBox] value="1" />
          </td>
          <td class="options">
            <a href="?p=$aActions[f]-form&amp;iPage=$aData[iPage]"><img src="$config[dir_templates]admin/img/ico_edit.gif" alt="$lang['edit']" title="$lang['edit']" /></a>
            <a href="?p=$aActions[f]-delete&amp;iPage=$aData[iPage]" onclick="delConfirm( $aData[iPage], aDelTxt, aDelUrl );return false;"><img src="$config[dir_templates]admin/img/ico_del.gif" alt="$lang['delete']" title="$lang['delete']"/></a>  
          </td>
        </tr><!-- END LIST -->
      </tbody>
    </table>
  </fieldset>
</form>
<!-- END PAGES -->

<!-- BEGIN FORM_MAIN -->
<div id="tabsDisplayLinks">
  <a href="#more" onclick="displayTabs( );" id="tabsHide">$lang['Hide_tabs']</a>
  <a href="#more" onclick="displayTabs( true );" id="tabsShow">$lang['Display_tabs']</a>
</div>
<h1><img src="$config[dir_templates]admin/img/ico_pages.gif" alt="$lang['Pages_form']" />$lang['Pages_form']<a href="$config['manual_link']instruction#3" title="$lang[Manual]" target="_blank"></a></h1>
<script type="text/javascript">
<!--
function checkParentForm( aData ){
  if( aData['iPageParent'].value != '' && aData['iPageParent'].value == aData['iPage'].value ){
    alert( "$lang['Parent_page'] - $lang[cf_wrong_value]" );
    aData['iPageParent'].focus( );
    return false;
  }
  else{
    return checkForm( aData );
  }
} // end function checkParentForm
//-->
</script>
<form action="?p=$p&amp;iPage=$aData[iPage]" name="form" enctype="multipart/form-data" method="post" id="mainForm" onsubmit="return checkParentForm( this );">
  <fieldset id="type1">
    <input type="hidden" name="iPage" value="$aData[iPage]" />
    <table cellspacing="0" class="mainTable" id="page">
      <thead>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="$lang['save_list'] &raquo;" name="sOptionList" />
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="$lang['save_list'] &raquo;" name="sOptionList" />
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </tfoot>
      <tbody><!-- name start -->
        <tr class="l0">
          <td>
            $lang['Name']
          </td>
          <th rowspan="7" class="tabs">$sFormTabs</th>
        </tr>
        <tr class="l1">
          <td>
            <input type="text" name="sName" value="$aData[sName]" class="input" style="width:100%;" alt="simple" />
          </td>
        </tr>
        <!-- name end -->
        <!-- description_short start -->
        <tr class="l0">
          <td>
            $lang['Short_description']
          </td>
        </tr>
        <tr class="l1">
          <td>
            $sDescriptionShort
          </td>
        </tr>
        <!-- description_short end -->
        <!-- description_full start -->
        <tr class="l0">
          <td>
            $lang['Full_description']
          </td>
        </tr>
        <tr class="l1">
          <td>
            $sDescriptionFull
          </td>
        </tr>
        <!-- description_short end -->
        <tr class="end">
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </fieldset>
</form>
<!-- END FORM_MAIN -->

<!-- BEGIN FORM_TABS -->
<div id="tabs">
  <ul id="tabsNames">
    <!-- tabs start -->
    <li class="tabOptions"><a href="#more" onclick="displayTab( 'tabOptions' )">$lang['Options']</a></li>
    <li class="tabView"><a href="#more" onclick="displayTab( 'tabView' )">$lang['View']</a></li>
    <li class="tabSeo"><a href="#more" onclick="displayTab( 'tabSeo' )">$lang['SEO']</a></li>
    <li class="tabAddFiles"><a href="#more" onclick="displayTab( 'tabAddFiles' )">$lang['Add_files']</a></li>
    <li class="tabAddedFiles"><a href="#more" onclick="displayTab( 'tabAddedFiles' )">$lang['Files']</a></li>
    <!-- tabs end -->
  </ul>
  <div id="tabsForms">
    <!-- tabs list start -->
    <table class="tab" id="tabOptions">
      <tr>
        <td colspan="2">
          <table cellspacing="0" id="colOptions">
            <tr>
              <td class="opt1">$lang['Status']</td>
              <td>$sStatusBox</td>
              <td class="opt2">$lang['Position']</td>
              <td><input type="text" name="iPosition" value="$aData[iPosition]" class="inputr" size="3" maxlength="3" /></td>
            </tr>
            <!-- tab column options -->
          </table>
        </td>
      </tr>
      <tr>
        <td>$lang['Parent_page']</td>
        <td><select name="iPageParent" onchange="checkType( );" id="oPageParent"><option value="">$lang['none']</option>$sPagesSelect</select></td>
      </tr>
      <tr id="type">
        <td>$lang['Menu']</td>
        <td><select name="iType">$sTypesSelect</select></td>
      </tr>
      <tr>
        <td>$lang['Address']</td>
        <td><input type="text" name="sUrl" value="$aData[sUrl]" size="40" class="input" /></td>
      </tr>
      <!-- tab options -->
    </table>

    <table class="tab" id="tabView">
      <tr>
        <td>$lang['Subpages']</td>
        <td><select name="iSubpagesShow">$sSubpagesShowSelect</select></td>
      </tr>
      <tr>
        <td>$lang['Template']</td>
        <td><select name="sTemplate">$sTemplatesSelect</select></td>
      </tr>
      <tr>
        <td>$lang['Theme']</td>
        <td><select name="sTheme">$sThemesSelect</select></td>
      </tr>
      <tr>
        <td>$lang['Banner']</td>
        <td>
          <input type="file" name="sBannerFile" class="input" size="30" /><!-- IF:START BANNER_FORM -->
          <div class="banner">
            <input type="hidden" name="sBanner" value="$aData[sBanner]" />
            <a href="$config[dir_files]$aData[sBanner]" target="_blank">$aData[sBanner]</a>&nbsp;&nbsp;<input type="checkbox" name="iBannerDel" value="1" /> - $lang['delete']
          </div><!-- IF:END BANNER_FORM -->
        </td>
      </tr>
      <!-- tab view -->
    </table>

    <div class="tab" id="tabAddFiles">
      <!-- tab add-files start -->
      $sFilesForm
      $sFilesDir
      <!-- tab add-files end -->
    </div>

    <div class="tab" id="tabAddedFiles">
      <!-- tab added-files start -->
      $sFilesList
      <!-- tab added-files end -->
    </div>

    <table class="tab" id="tabSeo">
      <tr>
        <td>$lang['Page_title']</td>
        <td><input type="text" name="sNameTitle" value="$aData[sNameTitle]" class="input" size="50" /></td>
      </tr>
      <tr>
        <td>$lang['Url_name']</td>
        <td><input type="text" name="sNameUrl" value="$aData[sNameUrl]" class="input" size="50" /></td>
      </tr>
      <tr>
        <td>$lang['Meta_description']</td>
        <td><input type="text" name="sMetaDescription" value="$aData[sMetaDescription]" class="input" size="50" maxlength="255" /></td>
      </tr>
      <tr>
        <td>$lang['Key_words']</td>
        <td><input type="text" name="sMetaKeywords" value="$aData[sMetaKeywords]" class="input" size="50" maxlength="255" /></td>
      </tr>
      <!-- tab seo -->
    </table>
    <!-- tabs list end -->
  </div>
</div>

<script type="text/javascript">
<!--
AddOnload( getTabsArray );
AddOnload( checkType );
AddOnload( checkSelectedTab );
//-->
</script>
<!-- END FORM_TABS -->