<?php
/**
* Return lang variables list
* @return string
* @param string $sFile
* @param string $sLang
*/
function listLangVariables( $sFile, $sLang ){
  if( is_file( DIR_LANG.$sLang.'.php' ) ){
    include DIR_LANG.$sLang.'.php';
    $oTpl = TplParser::getInstance( );
    $content = null;
    $i = 0;

    foreach( $lang as $aData['sKey'] => $aData['sValue'] ){
      $i++;

      if( $aData['sKey'] == 'Subpage_show_1' )
        $oTpl->setIf( 'BACK-END' );

      $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
      $aData['sValue'] = changeTxt( $aData['sValue'], '' );
      $aData['sValue'] = preg_replace( '/\|n\|/', '\n', $aData['sValue'] );

      $oTpl->setVariables( 'aData', $aData );
      $content .= $oTpl->tSubBlock( $sFile, 'LANG_FORM', 'LIST' );
    }

    if( isset( $content ) ){
      return $oTpl->tSubBlock( $sFile, 'LANG_FORM', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'LANG_FORM', 'LIST', 'foot' );
    }
  }
} // end function listLangVariables

/**
* Return array with languages
* @return array
*/
function throwLanguages( ){
  $oFFS = FlatFilesSerialize::getInstance( );
  foreach( new DirectoryIterator( DIR_LANG ) as $oFileDir ) {
    $sFileName = $oFileDir->isFile( ) ? $oFFS->throwNameOfFile( $oFileDir->getFilename( ) ) : null;
    if( isset( $sFileName ) && strlen( $sFileName ) == 2 ){
      $aLanguages[$sFileName] = $sFileName;
    }
  } // end foreach

  if( isset( $aLanguages ) )
    return $aLanguages;
} // end function throwLanguages

/**
* List all language files
* @return string
* @param string $sFile
*/
function listLanguages( $sFile ){
  $content = null;
  $aLanguages = throwLanguages( );
  if( isset( $aLanguages ) && is_array( $aLanguages ) ){
    $iCount = count( $aLanguages );
    $i = 0;
    $oTpl = TplParser::getInstance( );
    foreach( $aLanguages as $aData['sName'] ){
      $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
      $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;
      $oTpl->setVariables( 'aData', $aData );
      $content .= $oTpl->tSubBlock( $sFile, 'LANG_LIST', 'LIST' );
      $i++;
    } // end foreach

    if( isset( $content ) )
      return $oTpl->tSubBlock( $sFile, 'LANG_LIST', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'LANG_LIST', 'LIST', 'foot' );
  }
} // end function listLanguages

/**
* Return language files select
* @return string
* @param string $sLang
*/
function throwLangSelect( $sLang = null ){
  $content = null;
  $aLanguages = throwLanguages( );
  if( isset( $aLanguages ) && is_array( $aLanguages ) ){
    foreach( $aLanguages as $sFileName ){
      $sSelected = ( isset( $sLang ) && $sLang == $sFileName ) ? ' selected="selected"' : null;
      $content .= '<option value="'.$sFileName.'"'.$sSelected.'>'.$sFileName.'</option>';
    } // end foreach
  }
  return $content;
} // end function throwLangSelect

/**
* Add language files
* @return void
* @param string $sLanguage
* @param string $sLanguageFrom
* @param int $iCloneData
*/
function addLanguage( $sLanguage, $sLanguageFrom, $iCloneData ){
  if( is_file( DIR_LANG.$sLanguage.'.php' ) || !is_file( DIR_LANG.$sLanguageFrom.'.php' ) )
    return null;

  $oFFS = FlatFilesSerialize::getInstance( );

  copy( DIR_DATABASE.'config/lang_'.$sLanguageFrom.'.php', DIR_DATABASE.'config/lang_'.$sLanguage.'.php' );
  copy( DIR_LANG.$sLanguageFrom.'.php', DIR_LANG.$sLanguage.'.php' );

  if( isset( $_FILES['aFile']['name'] ) && $oFFS->throwExtOfFile( $_FILES['aFile']['name'] ) == 'php' && is_uploaded_file( $_FILES['aFile']['tmp_name'] ) ){
    include DIR_LANG.$sLanguageFrom.'.php';
    $aFile = file( $_FILES['aFile']['tmp_name'] );
    $iCount = count( $aFile );
    for( $i = 0; $i < $iCount; $i++ ){
      foreach( $lang as $sKey => $sValue ){
        if( preg_match( '/lang'."\['".$sKey."'\]".' /', $aFile[$i] ) && strstr( $aFile[$i], '=' ) && strstr( $aFile[$i], ';' ) ){
          $lang[$sKey] = str_replace( '";', '', substr( strstr( rtrim( $aFile[$i] ), '"' ), 1 ) );
          $bFound = true;
        }
      } // end foreach
    } // end for
    if( isset( $bFound ) )
      saveVariables( $lang, DIR_LANG.$sLanguage.'.php', 'lang' );  
  }  

  foreach( new DirectoryIterator( DIR_DATABASE ) as $oFileDir ) {
    $sFileName = $oFileDir->isFile( ) ? $oFFS->throwNameOfFile( $oFileDir->getFilename( ) ) : null;
    if( isset( $sFileName ) && substr( $sFileName, 0, 3 ) == $sLanguageFrom.'_' ){
      if( isset( $iCloneData ) ){
        copy( DIR_DATABASE.$oFileDir->getFilename( ), DIR_DATABASE.$sLanguage.substr( $oFileDir->getFilename( ), 2 ) );
      }
      else{
        $rFile = fopen( DIR_DATABASE.$sLanguage.substr( $oFileDir->getFilename( ), 2 ), 'w' );
        fwrite( $rFile, '<?php exit; ?>'."\n" );
        fclose( $rFile );
      }
    }
  } // end foreach

} // end function addLanguage

/**
* Delete language files
* @return void
* @param string $sLanguage
*/
function deleteLanguage( $sLanguage ){
  if( is_file( DIR_LANG.$sLanguage.'.php' ) )
    unlink( DIR_LANG.$sLanguage.'.php' );
  if( is_file( DIR_DATABASE.'config/lang_'.$sLanguage.'.php' ) )
    unlink( DIR_DATABASE.'config/lang_'.$sLanguage.'.php' );
  
  $oFFS = FlatFilesSerialize::getInstance( );
  foreach( new DirectoryIterator( DIR_DATABASE ) as $oFileDir ) {
    $sFileName = $oFileDir->isFile( ) ? $oFFS->throwNameOfFile( $oFileDir->getFilename( ) ) : null;
    if( isset( $sFileName ) && substr( $sFileName, 0, 3 ) == $sLanguage.'_' ){
      unlink( DIR_DATABASE.$oFileDir->getFilename( ) );
    }
  } // end foreach
} // end function deleteLanguage
?>