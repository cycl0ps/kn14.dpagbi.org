<!-- 
  Blocks information:
  - FORM - displays new language form. Actions for this block: admin.php?p=lang-form
  - LIST_TITLE - displays languages title in top of languages list
  - LANG_LIST - displays list of available languages. Actions for this block: admin.php?p=lang-list
  - LANG_FORM - displays variable with translations for specific language, Actions for this block: admin.php?p=lang-translations&sLanguage=xx (where xx is en, pl, cz, de etc.)
-->

<!-- BEGIN FORM -->
<h1><img src="$config[dir_templates]admin/img/ico_lang.gif" alt="$lang[New_language]" />$lang[New_language]<a href="$config['manual_link']instruction#5" title="$lang[Manual]" target="_blank"></a></h1>
<form action="?p=$p" method="post" enctype="multipart/form-data" id="mainForm" onsubmit="return checkForm( this );">
  <fieldset id="type2">
    <table cellspacing="1" class="mainTable" id="language">
      <thead>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </tfoot>
      <tbody>
        <tr class="l0">
          <th>$lang[Language]</th>
          <td><input type="text" name="language" value="" class="input" size="3" maxlength="2" alt="simple" /></td>
        </tr>
        <tr class="l1">
          <th>$lang[Upload_language_file]</th>
          <td><input type="file" name="aFile" value="" class="input" size="30" /><span>$lang[Upload_language_file_info]</span></td>
        </tr>
        <tr class="l0">
          <th>$lang[Use_language]</th>
          <td><select name="language_from">$sLangSelect</select></td>
        </tr>
        <tr class="l1">
          <th>$lang[Clone_data_from_basic_language]</th>
          <td><input type="checkbox" name="clone" value="1" /></td>
        </tr>
      </tbody>
    </table>
  </fieldset>
</form>
<!-- END FORM -->

<!-- BEGIN LIST_TITLE -->
<h1><img src="$config[dir_templates]admin/img/ico_lang.gif" alt="$lang[Languages]" />$lang[Languages] $sLanguage<a href="$config['manual_link']instruction#5" title="$lang[Manual]" target="_blank"></a></h1>
<!-- END LIST_TITLE -->
<!-- BEGIN LANG_LIST -->
<table id="list" class="languages" cellspacing="1">
  <thead>
    <tr>
      <td class="name">$lang['Name']</td>
      <td class="options">&nbsp;</td>
    </tr>
  </thead>
  <tbody><!-- START LIST -->
    <tr class="l$aData[iStyle]">
      <td>
        <a href="?p=$aActions[f]-translations&amp;sLanguage=$aData[sName]">$aData[sName]</a>
      </td>
      <td class="options">
        <a href="?p=$aActions[f]-translations&amp;sLanguage=$aData[sName]"><img src="$config[dir_templates]admin/img/ico_edit.gif" alt="$lang['edit']" title="$lang['edit']" /></a>
        <a href="?p=$aActions[f]-delete&amp;sLanguage=$aData[sName]" onclick="return del( );"><img src="$config[dir_templates]admin/img/ico_del.gif" alt="$lang['delete']" title="$lang['delete']"/></a>  
      </td>
    </tr><!-- END LIST -->
  </tbody>
</table>
<!-- END LANG_LIST -->

<!-- BEGIN LANG_FORM -->
<form action="?p=$p&amp;sLanguage=$sLanguage" method="post" id="mainForm">
  <fieldset id="type2">
    <table cellspacing="1" class="mainTable" id="translations">
      <thead>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <th colspan="2">
            <input type="submit" value="$lang['save'] &raquo;" name="sOption" />
          </th>
        </tr>
      </tfoot>
      <tbody>
        <tr class="l0 title">
          <th colspan="2">$lang[Translation_visible_all]</th>
        </tr><!-- START LIST --><!-- IF:START BACK-END -->
        <tr class="l0 title">
          <th colspan="2">$lang[Translation_visible_back_end]</th>
        </tr><!-- IF:END BACK-END -->
        <tr class="l$aData[iStyle]">
          <th>$aData[sKey]</th>
          <td><input type="text" name="$aData[sKey]" value="$aData[sValue]" class="input" size="80" /></td>
        </tr><!-- END LIST -->
      </tbody>
    </table>
  </fieldset>
</form>      
<!-- END LANG_FORM -->