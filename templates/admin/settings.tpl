<!-- BEGIN CONFIG_MAIN -->
<h1>$lang['Settings']<a href="$config['manual_link']instruction#2" title="$lang[Manual]" target="_blank"></a></h1>
<form action="?p=$p" method="post" id="mainForm" name="form" onsubmit="return checkForm( this );">
  <fieldset id="type2">
    <table cellspacing="1" class="mainTable" id="config">
      <thead>
        <tr class="save">
          <th colspan="3">
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="3">
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </tfoot>
      <tbody>
        <!-- title start -->
        <tr class="l0">
          <th>
            $lang['Page_title']
          </th>
          <td>
            <input type="text" name="title" value="$config[title]" size="70" maxlength="200" class="input" />
          </td>
          <td rowspan="8" class="tabs">$sFormTabs</td>
        </tr>
        <!-- title end -->
        <!-- description start -->
        <tr class="l1">
          <th>
            $lang['Description']
          </th>
          <td>
            <input type="text" name="description" value="$config[description]" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- description end -->
        <!-- keywords start -->
        <tr class="l0">
          <th>
            $lang['Key_words']
          </th>
          <td>
            <input type="text" name="keywords" value="$config[keywords]" size="70" maxlength="255" class="input"/>
          </td>
        </tr>
        <!-- keywords end -->
        <!-- slogan start -->
        <tr class="l1">
          <th>
            $lang['Slogan']
          </th>
          <td>
            <input type="text" name="slogan" value="$config[slogan]" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- slogan end -->
        <!-- foot info start -->
        <tr class="l0">
          <th>
            $lang['Foot_info']
          </th>
          <td>
            <input type="text" name="foot_info" value="$config[foot_info]" size="70" maxlength="200" class="input" />
          </td>
        </tr>
        <!-- foot info end -->
        <!-- login start -->
        <tr class="l1" id="login">
          <th>
            $lang['Login']
          </th>
          <td>
            <input type="text" name="login" value="$config[login]" size="40" class="input" alt="simple" />
          </td>
        </tr>
        <!-- login end -->
        <!-- pass start -->
        <tr class="l0" id="pass">
          <th>
            $lang['Password']
          </th>
          <td>
            <input type="text" name="pass" value="$config[pass]" size="40" class="input" alt="simple" />
          </td>
        </tr>
        <!-- pass end -->
        <tr class="end">
          <td colspan="2">&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </fieldset>
</form>
<!-- END CONFIG_MAIN -->

<!-- BEGIN CONFIG_TABS -->
<div id="tabs">
  <ul id="tabsNames">
    <!-- tabs start -->
    <li class="tabOptions"><a href="#more" onclick="displayTab( 'tabOptions' )">$lang['Options']</a></li>
    <li class="tabPages"><a href="#more" onclick="displayTab( 'tabPages' )">$lang['Pages']</a></li>
    <li class="tabAdvanced"><a href="#more" onclick="displayTab( 'tabAdvanced' )">$lang['Advanced']</a></li>
    <!-- tabs end -->
  </ul>
  <div id="tabsForms">
    <!-- tabs list start -->
    <table class="tab" id="tabOptions">
      <tr>
        <td>$lang['Default_language']</td>
        <td>
          <select name="default_lang">
            $sLangSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Admin_language']</td>
        <td>
          <select name="admin_lang">
            $sLangAdminSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Skin']</td>
        <td>
          <select name="skin">
            $sSkinsSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Admin_see_hidden_pages']</td>
        <td>
          <select name="hidden_shows">
            $sHiddenShowsSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['WYSWIG_editor']</td>
        <td>
          <select name="wysiwyg">
            $sWysiwygSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Display_text_size_option']</td>
        <td>
          <select name="text_size">
            $sTextSizeSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Display_expanded_menu']</td>
        <td>
          <select name="display_expanded_menu">
            $sExpandedMenuSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Language_in_url']</td>
        <td>
          <select name="language_in_url">
            $sLanguageInUrl
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang[Admin_items_on_page]</td>
        <td>
          <input type="text" name="admin_list" value="$config[admin_list]" size="3" maxlength="3" alt="int;0" class="input" />
        </td>
      </tr>
      <!-- tab options -->
    </table>

    <table class="tab" id="tabPages">
      <tr>
        <td>$lang['Start_page']</td>
        <td>
          <select name="start_page">
            $sStartPageSelect
          </select>
        </td>
      </tr>
      <!-- tab pages -->
    </table>

    <table class="tab" id="tabAdvanced">
      <tr>
        <td>$lang['Display_all_files']</td>
        <td>
          <select name="display_all_files">
            $sDisplayAllFilesSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Change_files_names']</td>
        <td>
          <select name="change_files_names">
            $sChangeFilesNamesSelect
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Copy_files_from_server']</td>
        <td>
          <select name="copy_the_same_files">
            $sCopyTheSameFiles
          </select>
        </td>
      </tr>
      <tr>
        <td>$lang['Inherit_from_parents']</td>
        <td>
          <select name="inherit_from_parents">
            $sInheritFromParentsSelect
          </select>
        </td>
      </tr>
      <!-- tab advanced -->
    </table>
    
    <!-- tabs list end -->
  </div>
</div>

<script type="text/javascript">
<!--
AddOnload( getTabsArray );
AddOnload( checkSelectedTab );
//-->
</script>
<!-- END CONFIG_TABS -->