<?php
/**
* Return status limit
* @return int
*/
function throwStatus( ){
  if( defined( 'SESSION_KEY_NAME' ) && isset( $_SESSION[SESSION_KEY_NAME] ) && $_SESSION[SESSION_KEY_NAME] === true ){
    if( defined( 'CUSTOMER_PAGE' ) ){
      if( HIDDEN_SHOWS === true )
        return 0;
      else
        return 1;
    }
    else
      return 0;
  }
  else
    return 1;
} // end function throwStatus

/**
* Return value to $p variable from $_GET
* @return array
*/
function getUrlFromGet( ){
  global $a;
  if( isset( $_GET ) && is_array( $_GET ) ){
    foreach( $_GET as $mKey => $mValue ){
      if( strstr( $mKey, ',' ) ){
        $mKey = htmlspecialchars( $mKey );
        $aExp = explode( ',', $mKey );

        if( empty( $aExp[2] ) )
          $aExp[2] = 'pages';

        for( $i = 2; $i < count( $aExp ); $i++ ){
          $aActions['o'.( $i )] = $aExp[$i];
          if( $aActions['o'.( $i )] == 'pages' )
            $aActions['o'.( $i )] = null;
        } // end for

        if( is_numeric( $aExp[2] ) )
          $aExp[2] = 'pages';

        $aActions['o1'] = $aExp[0];
        $aActions['f'] = $aExp[2];
        $aActions['a'] = $aExp[1];
        $aActions['sLink']= $mKey;
        $a = $aActions['a'];

        return $aActions;
      }
    }
    $a = null;
    return Array( 'f' => 'pages', 'a' => null, 'sLink' => 'pages' );
  }
} // end function getUrlFromGet

/**
* Returns extensions icons
* @return array
*/
function throwIconsFromExt( ){
  return Array( 'rar'=>'zip', 'zip'=>'zip', 'bz2'=>'zip', 'gz'=>'zip', 'fla'=>'fla', 'mp3'=>'media', 'mpeg'=>'media', 'mpe'=>'media', 'mov'=>'media', 'mid'=>'media', 'midi'=>'media', 'asf'=>'media', 'avi'=>'media', 'wav'=>'media', 'wma'=>'media', 'msg'=>'msg', 'eml'=>'msg', 'pdf'=>'pdf', 'jpg'=>'pic', 'jpeg'=>'pic', 'jpe'=>'pic', 'gif'=>'pic', 'bmp'=>'pic', 'tif'=>'pic', 'tiff'=>'pic', 'wmf'=>'pic', 'png'=>'png', 'chm'=>'chm', 'hlp'=>'chm', 'psd'=>'psd', 'swf'=>'swf', 'pps'=>'pps', 'ppt'=>'pps', 'sys'=>'sys', 'dll'=>'sys', 'txt'=>'txt', 'doc'=>'txt', 'rtf'=>'txt', 'vcf'=>'vcf', 'xls'=>'xls', 'xml'=>'xml', 'tpl'=>'web', 'html'=>'web', 'htm'=>'web', 'com'=>'exe', 'bat'=>'exe', 'exe'=>'exe' );
} // end function throwIconsFromExt

/**
* Returns language based on url parameter
* @return string
*/
function getLanguageFromUrl( ){
  $aUrl = getUrlFromGet( );
  if( isset( $aUrl['o1'] ) ){
    $iLangPos = strpos( $aUrl['o1'], LANGUAGE_SEPARATOR );
    if( $iLangPos === false )
      return null;
    else
      return substr( $aUrl['o1'], 0, $iLangPos );
  }
  else
    return null;
} // end function getLanguageFromUrl

/**
* Display date changed by $config['time_diff']
* @return string
* @param int    $iTime
* @param string $sFormat
*/
function displayDate( $iTime = null, $sFormat = 'Y-m-d H:i' ){
  return isset( $iTime ) ? date( $sFormat, $iTime + ( TIME_DIFF * 60 ) ) : date( $sFormat );
} // end function displayDate

/**
* Count page number and positions in database file
* @return array
* @param int $iCount
* @param int $iPage
* @param int $iList
*/
function countPageNumber( $iCount, $iPage, $iList = null ){
  if( !isset( $iList ) )
    $iList = $GLOBALS['config']['admin_list'];
  $iPages = ceil( $iCount / $iList );
  $iPageNumber = isset( $iPage ) ? $iPage : 1;
  if( !isset( $iPageNumber ) || !is_numeric( $iPageNumber ) || $iPageNumber < 1 )
    $iPageNumber = 1;
  if( $iPageNumber > $iPages )
    $iPageNumber = $iPages;

  $iEnd = $iPageNumber * $iList;
  $iStart = $iEnd - $iList;

  if( $iEnd > $iCount )
    $iEnd = $iCount;

  return Array( 'iStart' => $iStart, 'iEnd' => $iEnd, 'iPageNumber' => $iPageNumber ); 
} // end function countPageNumber

/**
* Compare arrays and delete from $aData keys which are not exists in $aKeys
* @return array
* @param array  $aKeys
* @param array  $aData
*/
function compareArrays( $aKeys, $aData ){
  foreach( $aKeys as $sKey ){
    if( isset( $aData[$sKey] ) ){
      if( $sKey[0] == 'i' )
        $aData[$sKey] = (int) $aData[$sKey];
      $aReturn[$sKey] = $aData[$sKey];
    }
  } // end foreach

  if( isset( $aReturn ) )
    return $aReturn;
} // end function compareArrays
?>