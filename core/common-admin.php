<?php
/**
* Return templates select
* @return string
* @param string $sPrefix
* @param string $sFileCurrent
*/
function throwTemplatesSelect( $sPrefix, $sFileCurrent = null ){

  if( empty( $sFileCurrent ) ){
    $sFileCurrent = $GLOBALS['config']['default_pages_template'];
  }

  foreach( new DirectoryIterator( DIR_SKIN ) as $oFileDir ) {
    if( $oFileDir->isFile( ) && strstr( $oFileDir->getFilename( ), '.tpl' ) && strstr( $oFileDir->getFilename( ), $sPrefix ) ){
      $aFiles[$oFileDir->getFilename( )] = $oFileDir->getFilename( );
    }
  } // end foreach 

  if( !isset( $aFiles ) ){
    $aFiles[] = $GLOBALS['config']['default_pages_template'];
  }

  if( isset( $aFiles ) ){
    $content = isset( $aFiles[$GLOBALS['config']['default_pages_template']] ) ? '' : '<option value="">'.$GLOBALS['config']['default_pages_template'].'</option>';
    sort( $aFiles );
    $iCount = count( $aFiles );
    for( $i = 0; $i < $iCount; $i++ ){
      $sSelected = ( $sFileCurrent == $aFiles[$i] ) ? ' selected="selected"' : null;
      $content .= '<option value="'.$aFiles[$i].'"'.$sSelected.'>'.$aFiles[$i].'</option>';
    } // end for

    return $content;
  }
} // end function throwTemplatesSelect

/**
* Return skins select
* @return string
* @param string $sDirCurrent
*/
function throwSkinsSelect( $sDirCurrent = null ){

  if( empty( $sDirCurrent ) ){
    $sFileCurrent = $GLOBALS['config']['skin'];
  }

  foreach( new DirectoryIterator( DIR_TEMPLATES ) as $oFileDir ){
    if( $oFileDir->isDir( ) && !strstr( $oFileDir->getFilename( ), 'admin' ) && !strstr( $oFileDir->getFilename( ), '.' ) ){
      $aDirs[] = $oFileDir->getFilename( );
    }
  } // end foreach

  if( isset( $aDirs ) ){
    $content = null;
    sort( $aDirs );
    $iCount = count( $aDirs );
    for( $i = 0; $i < $iCount; $i++ ){
      $sSelected = ( $sDirCurrent == $aDirs[$i] ) ? ' selected="selected"' : null;
      $content .= '<option value="'.$aDirs[$i].'"'.$sSelected.'>'.$aDirs[$i].'</option>';
    } // end for

    return $content;
  }
} // end function throwCssSelect

/**
* Return themes select
* @return string
* @param string $sFileCurrent
*/
function throwThemesSelect( $sFileCurrent = null ){
  
  if( empty( $sFileCurrent ) ){
    $sFileCurrent = $GLOBALS['config']['default_theme'];
  }

  foreach( new DirectoryIterator( DIR_THEMES ) as $oFileDir ){
    if( $oFileDir->isFile( ) && strstr( $oFileDir->getFilename( ), '.php' ) ){
      $aFiles[] = $oFileDir->getFilename( );
    }
  } // end foreach

  if( isset( $aFiles ) ){
    $content = null;
    sort( $aFiles );
    $iCount = count( $aFiles );
    for( $i = 0; $i < $iCount; $i++ ){
      $sSelected = ( $sFileCurrent == $aFiles[$i] ) ? ' selected="selected"' : null;
      $sValue = ( $aFiles[$i] == $GLOBALS['config']['default_theme'] ) ? null : $aFiles[$i];

      $content .= '<option value="'.$sValue.'"'.$sSelected.'>'.$aFiles[$i].'</option>';
    } // end for

    return $content;
  }
} // end function throwThemesSelect

/**
* Saves variables to config
* @return void
* @param array  $aForm
* @param string $sFile
* @param string $sVariable
*/
function saveVariables( $aForm, $sFile, $sVariable = 'config' ){
  $aFile = file( $sFile );
  $iCount = count( $aFile );
  $rFile = fopen( $sFile, 'w' );

  for( $i = 0; $i < $iCount; $i++ ){
    foreach( $aForm as $sKey => $sValue ){
      if( preg_match( '/'.$sVariable."\['".$sKey."'\]".' /', $aFile[$i] ) && strstr( $aFile[$i], '=' ) ){
        $sValue = changeSpecialChars( $sValue );
        $sValue = str_replace( '"', '&quot;', $sValue );
        $sValue = stripslashes( $sValue );
        if( ( is_numeric( $sValue ) || preg_match( '/^(true|false|null)$/', $sValue ) == true ) && !preg_match( '/0[0-9]+/', $sValue ) )
          $aFile[$i] = "\$".$sVariable."['".$sKey."'] = ".$sValue.";";
        else
          $aFile[$i] = "\$".$sVariable."['".$sKey."'] = \"".$sValue."\";";
      }
    } // end foreach

    fwrite( $rFile, rtrim( $aFile[$i] ).( $iCount == ( $i + 1 ) ? null : "\r\n" ) );

  } // end for
  fclose( $rFile );
} // end function saveVariables

/**
* Log in and out actions
* @return void
* @param string $p
* @param string $sKey
* @param string $sFile
* @date 2007-09-20 09:42:35
*/
function loginActions( $p, $sKey = 'bLogged', $sFile ){
  global $sLoginInfo, $sLoginPage;
  $oTpl = TplParser::getInstance( );
  $sCheck = 'checkContent';
  
  if( !isset( $_SESSION[$sKey] ) || $_SESSION[$sKey] !== TRUE ){
    if( $GLOBALS['config']['failed_login_count'] > 2 && time( ) - $GLOBALS['config']['failed_login_time'] <= 900 ){
      $bLoginExceed = true;
      $p = null;
    }

    if( $p == 'login' && isset( $_POST['sLogin'] ) && isset( $_POST['sPass'] ) ){
      $iCheckLogin = checkLogin( $_POST['sLogin'], $_POST['sPass'], $sKey );
      if( $iCheckLogin == 1 ){
        if( !isset( $_COOKIE['sLogin'] ) || $_COOKIE['sLogin'] != $_POST['sLogin'] )
          @setCookie( 'sLogin', $_POST['sLogin'], time( ) + 2592000 );
        
        $sRedirect = !empty( $_POST['sLoginPageNext'] ) ? $_POST['sLoginPageNext'] : $_SERVER['PHP_SELF'];
        saveVariables( Array( 'last_login' => time( ), 'before_last_login' => $GLOBALS['config']['last_login'], 'failed_login_time' => 0, 'failed_login_count' => 0 ), DB_CONFIG );

        header( 'Location: '.$sRedirect );
        exit;
      }
      elseif( $iCheckLogin == 2 ){
        $sLoginPage = $_SERVER['PHP_SELF'];
        $oTpl->setIf( 'INACTIVE' );
      }
      else{
        $sLoginPage = $_SERVER['PHP_SELF'];
        $oTpl->setIf( 'INCORRECT' );
      }
    }
    else{
      if( isset( $bLoginExceed ) ){
        $sLoginPage = $_SERVER['PHP_SELF'];
        $oTpl->setIf( 'FAILED_LOGIN' );
      }
      else{
        $sLoginPage = '?p=login';
        if( !empty( $_SERVER['REQUEST_URI'] ) )
          $_SERVER['REQUEST_URI'] = strip_tags( $_SERVER['REQUEST_URI'] );
        $oTpl->setIf( 'FORM' );
      }
    }

    unset( $GLOBALS['aActions'] );
    $sContent = $oTpl->tBlock( $sFile, 'LOGIN_PANEL' );
    echo $oTpl->tBlock( $sFile, 'HEAD' ).$sContent.$oTpl->tBlock( $sFile, 'FOOT' );
    exit;
  }
  else{
    if( $p == 'logout' ){
      unset( $_SESSION[$sKey] );
      $sLoginPage = $_SERVER['PHP_SELF'];
      header( 'Location: '.$_SERVER['PHP_SELF'] );
      exit;
    }
    if( isset( $sCheck ) )
      $sCheck();
  }
} // end function loginActions

/**
* Check login and password saved in config/general.php
* @return int
* @param string $sLogin
* @param string $sPass
* @param string $sKey
*/
function checkLogin( $sLogin, $sPass, $sKey ){
  if( $GLOBALS['config']['login'] == $sLogin && $GLOBALS['config']['pass'] == $sPass ){
    $_SESSION[$sKey] = true;
    return 1;
  }
  else{
    saveVariables( Array( 'failed_login_time' => time( ), 'failed_login_count' => ( $GLOBALS['config']['failed_login_count'] + 1 ) ), DB_CONFIG );
    return 0;
  }
} // end function checkLogin

/**
* Return subpages show select
* @return string
* @param int  $iShow
*/
function throwSubpagesShowSelect( $iShow = null ){
  $aSubpages[1] = $GLOBALS['lang']['Subpage_show_1'];
  $aSubpages[2] = $GLOBALS['lang']['Subpage_show_2'];
  return throwSelectFromArray( $aSubpages, $iShow );
} // end function throwSubpagesShowSelect

/**
* Delete from address iPage=Something
* @return string
* @param string $sUrl
*/
function changeUri( $sUrl ){
  return preg_replace( "/&iPage=[0-9]*/", '', $sUrl );
} // end function changeUri

/**
* Return true/false or null select
* @return string
* @param bool $bFalseNull
* @param string $sFalseNull
*/
function throwTrueFalseOrNullSelect( $bFalseNull = false, $sFalseNull = 'false' ){
  
  $aSelect = Array( null, null );
  
  if( $bFalseNull == true )
    $aSelect[1] = 'selected="selected"';
  else
    $aSelect[0] = 'selected="selected"';
  
  return '<option value="true" '.$aSelect[1].'>'.LANG_YES_SHORT.'</option><option value="'.$sFalseNull.'" '.$aSelect[0].'>'.LANG_NO_SHORT.'</option>';
} // end function throwTrueFalseOrNullSelect
?>