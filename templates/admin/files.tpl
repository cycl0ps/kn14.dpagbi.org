<!-- BEGIN ADDED_FILES -->
<table id="files-list" cellspacing="1">
  <thead>
    <tr>
      <th class="delete">$lang[Delete]</th>
      <th class="name">$lang[File]</th>
      <th class="position">$lang[Position]</th>
      <th class="description">$lang[Description]</th>
      <th class="place">$lang[Photo_place]</th>
      <th class="thumb1">$lang[Thumbnail_1]</th>
      <th class="thumb2">$lang[Thumbnail_2]</th>
    </tr>
  </thead>
  <tbody><!-- START LIST -->
    <tr class="l$aData[iStyle]">
      <td>
        <input type="checkbox" name="aFilesDelete[$aData[iFile]]" value="1" />
      </td>
      <td class="name">
        <a href="$config[dir_files]$aData[sFileName]" target="_blank">$aData[sFileName]</a>
      </td>
      <td class="position">
        <input type="text" name="aFilesPositions[$aData[iFile]]" value="$aData[iPosition]" size="2" maxlength="3" class="inputr" />
      </td>
      <td <!-- IF:START FILE -->colspan="4"<!-- IF:END FILE --> class="description">
        <input type="text" name="aFilesDescription[$aData[iFile]]" value="$aData[sDescription]" size="20" class="input description"  />
      </td><!-- IF:START IMAGE -->
      <td class="place">
        <select name="aFilesTypes[$aData[iFile]]" >
          $aData[sPhotoTypesSelect]
        </select>
      </td>
      <td class="thumb1">
        <select name="aFilesSizes1[$aData[iFile]]">
          $aData[sSizes1Select]
        </select>
      </td>
      <td class="thumb2">
        <select name="aFilesSizes2[$aData[iFile]]">
          $aData[sSizes2Select]
        </select>
      </td>
      <!-- IF:END IMAGE -->
    </tr>   
    <!-- END LIST -->
  </tbody>
</table>
<!-- END ADDED_FILES -->

<!-- BEGIN FILES_IN_DIR -->
<h3 class="files-dir">$lang['Files_on_server']</h3>
<table cellspacing="1" class="files-dir" id="files-dir-head">
  <tbody>
    <tr id="files-dir-head-tr">
      <th class="select">$lang[Select]</th>
      <th class="file">$lang[File]</th>
      <th class="position hidden">$lang[Position]</th>
      <th class="description hidden">$lang[Description]</th>
      <th class="place hidden">$lang[Photo_place]</th>
      <th class="thumb1 hidden">$lang[Thumbnail_1]</th>
      <th class="thumb2 hidden">$lang[Thumbnail_2]</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <th class="file"><input type="text" name="sFilesInDirPhrase" id="filesInDirPhrase" value="$lang[search]" class="input" size="50" onkeyup="listTableSearch( this, 'files-dir-table', 1 )" onfocus="if(this.value=='$lang[search]')this.value=''" /></th>
      <th colspan="5">&nbsp;</th>
    </tr>
  </tbody>
</table>
<div id="files-dir">
  <table cellspacing="1" class="files-dir" id="files-dir-table">
    <tbody><!-- START LIST -->
      <tr class="l$aData[iStyle]" id="fileTr$aData[iFile]">
        <td class="select">
          <input type="checkbox" name="aDirFiles[$aData[iFile]]" value="$aData[sFileName]" onclick="displayFilesDirHead( '$aData[iFile]', $aData[iPhoto] )" />
        </td>
        <td class="file">
          <a href="$config[dir_files]$aData[sFileName]" target="_blank" class="a$aData['iStatus']">$aData[sFileName]</a>
        </td>
        <td class="position">
          &nbsp;
        </td>
        <td class="description">
          &nbsp;
        </td>
        <td class="place">
          &nbsp;
        </td>
        <td class="thumb1">
          &nbsp;
        </td>
        <td class="thumb2">
          &nbsp;
        </td>
      </tr><!-- END LIST -->
    </tbody>
  </table>
</div>

<script type="text/javascript">
<!--
function displayFilesDirHead( iFile, iPhoto ){
  //
  var aTh = gEBI( 'files-dir-head-tr' ).getElementsByTagName( 'th' );
  for( var i = 0; i < aTh.length; i++ ){
    removeClassName( aTh[i], 'hidden' );
  } // end for
  var aTd = gEBI( 'fileTr'+iFile ).getElementsByTagName( 'td' );
  for( var i = 0; i < aTd.length; i++ ){
    if( aTd[i].className == 'position' ){
      aTd[i].innerHTML = '<input type="text" name="aDirFilesPositions['+iFile+']" value="0" maxlength="3" class="inputr" />';
    }
    else if( aTd[i].className == 'description' ){
      aTd[i].innerHTML = '<input type="text" name="aDirFilesDescriptions['+iFile+']" class="input" />';
    }
    else if( aTd[i].className == 'place' && iPhoto == 1 ){
      aTd[i].innerHTML = '<select name="aDirFilesTypes['+iFile+']">$sPhotoTypesSelect</select>';
    }
    else if( aTd[i].className == 'thumb1' && iPhoto == 1 ){
      aTd[i].innerHTML = '<select name="aDirFilesSizes1['+iFile+']">$sSize1Select</select>';
    }
    else if( aTd[i].className == 'thumb2' && iPhoto == 1 ){
      aTd[i].innerHTML = '<select name="aDirFilesSizes2['+iFile+']">$sSize2Select</select>';
    }
  } // end for
} // end function displayFilesDirHead

//-->
</script>
<!-- END FILES_IN_DIR -->

<!-- BEGIN FILES_FORM -->
<h3>$lang['Files_from_computer']</h3>
<table id="files-form" cellspacing="1">
  <thead>
    <tr>
      <th class="file">$lang[File]</th>
      <th class="position">$lang[Position]</th>
      <th class="description">$lang[Description]</th>
      <th class="place">$lang[Photo_place]</th>
      <th class="thumb1">$lang[Thumbnail_1]</th>
      <th class="thumb2">$lang[Thumbnail_2]</th>
    </tr>
  </thead>
  <tbody><!-- START LIST -->
    <tr class="l$aData[iStyle]">
      <td class="file">
        <input type="file" name="aNewFiles[]" value="" size="14" class="input" onclick="enableFields(this)" />
      </td>
      <td class="position">
        <input type="text" name="aNewFilesPositions[]" value="0" maxlength="3" size="2" class="inputr disable" />
      </td>
      <td class="description">
        <input type="text" name="aNewFilesDescriptions[]" value="" size="20" class="input description disable" />
      </td>
      <td class="type">
        <select name="aNewFilesTypes[]" class="disable">$sPhotoTypesSelect</select>
      </td>
      <td class="thumb1">
        <select name="aNewFilesSizes1[]" class="disable">$sSize1Select</select>
      </td>
      <td class="thumb2">
        <select name="aNewFilesSizes2[]" class="disable">$sSize2Select</select>
      </td>
    </tr>   
    <!-- END LIST -->
  </tbody>
</table>
<!-- END FILES_FORM -->

<!-- BEGIN LIST_TITLE -->
<h1><img src="$config[dir_templates]admin/img/ico_files.gif" alt="$lang['Files']" />$lang['Files']<a href="$config['manual_link']instruction#8" title="$lang[Manual]" target="_blank"></a></h1>
<form action="" method="get" id="search">
  <fieldset>
    <input type="hidden" name="p" value="$p" />
    <input type="hidden" name="sSort" value="$sSort" />
    <input type="text" name="sPhrase" value="$sPhrase" class="input" size="50" />
    <input type="submit" value="$lang['search'] &raquo;" />
  </fieldset>
</form>
<!-- END LIST_TITLE -->
<!-- BEGIN ALL_FILES -->
<form action="?p=$p&amp;sPhrase=$sPhrase&amp;sSort=$sSort" method="post">
  <fieldset>
    <table id="list" class="files" cellspacing="1">
      <thead>
        <tr class="save">
          <td colspan="6" class="pages">
            $lang[Pages]: <ul>$aData[sPages]</ul>
          </td>
          <th>
            <input type="submit" name="sOption" value="$lang['save'] &raquo;" />
          </th>
        </tr>
        <tr>
          <td class="id"><a href="?p=$p&amp;sSort=id&amp;sPhrase=$sPhrase">$lang['Id']</a></td>
          <td class="name"><a href="?p=$p&amp;sPhrase=$sPhrase">$lang['File']</a></td>
          <td>$lang['Description']</td>
          <td class="position">$lang['Position']</td>
          <td>$lang['Photo_place']</td>
          <td><a href="?p=$p&amp;sSort=added_to&amp;sPhrase=$sPhrase">$lang['Added_to']</a></td>
          <td class="status">$lang['Delete']</td>
        </tr>
      </thead>
      <tfoot>
        <tr class="save">
          <td colspan="6" class="pages">
            $lang[Pages]: <ul>$aData[sPages]</ul>
          </td>
          <th>
            <input type="submit" name="sOption" value="$lang['save'] &raquo;" />
          </th>
        </tr>
      </tfoot>
      <tbody><!-- START LIST -->
        <tr class="l$aData[iStyle]">
          <td class="id">
            $aData[iFile]
          </td><td class="name">
            <a href="$config[dir_files]$aData[sFileName]" target="_blank">$aData[sFileName]</a>
          </td><td>
            <input type="text" name="aFilesDescription[$aData[iFile]]" value="$aData[sDescription]" class="input" size="40" />
          </td><td>
            <input type="text" name="aFilesPositions[$aData[iFile]]" value="$aData[iPosition]" class="inputr" size="2" maxlength="3" title="$lang['Position']" />
          </td><td><!-- IF:START IMAGE -->
          <select name="aFilesTypes[$aData[iFile]]">$aData[sPhotoTypesSelect]</select><!-- IF:END IMAGE -->
          </td><td>
            $aData[sLink]
          </td><td>
            <input type="checkbox" name="aFilesDelete[$aData[iFile]]" value="1" />
          </td>
        </tr>      
      <!-- END LIST -->
      </tbody>
    </table>
  </fieldset>
</form>
<!-- END ALL_FILES -->
