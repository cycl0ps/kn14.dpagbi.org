<?php
/*
* Quick.Cms by OpenSolution.org
* www.OpenSolution.org
*/
extract( $_GET );

require 'database/config/general.php';
require DB_CONFIG_LANG;

session_start( );

header( 'Content-Type: text/html; charset='.$config['charset'] );
require_once DIR_LIBRARIES.'tpl-parser.php';
require_once DIR_LIBRARIES.'file-jobs.php';
require_once DIR_LIBRARIES.'flat-files.php';
require_once DIR_LIBRARIES.'image-jobs.php';
require_once DIR_LIBRARIES.'trash.php';
require_once DIR_PLUGINS.'plugins-admin.php';

require_once DIR_DATABASE.'_fields.php';
require_once DIR_CORE.'common-admin.php';
require_once DIR_CORE.'pages.php';
require_once DIR_CORE.'pages-admin.php';
require_once DIR_CORE.'lang-admin.php';
require_once DIR_CORE.'files.php';
require_once DIR_CORE.'files-admin.php';

if( !isset( $p ) || empty( $p ) )
 $p = 'news';

if( !isset( $iTypeSearch ) )
  $iTypeSearch = 1;

if( $p == 'search' ){
  $aSearchActions = Array( 1 => 'pages-list', 2 => 'files-list' );
  $p = ( isset( $aSearchActions[$iTypeSearch] ) ) ? $aSearchActions[$iTypeSearch] : null;
}

if( isset( $sPhrase ) && !empty( $sPhrase ) ){
  $sPhrase = trim( changeSpecialChars( htmlspecialchars( stripslashes( $sPhrase ) ) ) );
}

$aActions = getAction( $p );

$oFFS = FlatFilesSerialize::getInstance( );
$oImage = ImageJobs::getInstance( );
$oTpl = TplParser::getInstance( DIR_TEMPLATES.'admin/', $config['embed_php'] );

$oFile = FilesAdmin::getInstance( );
$oPage = PagesAdmin::getInstance( );
$content = null;
$sDateLog = displayDate( $config['before_last_login'] );

loginActions( $p, SESSION_KEY_NAME, 'container.tpl' );

if( $p == 'news' || $p == 'login' ){
  $sListEventsPages = $oPage->listLastPages( 'container.tpl' );
  $sListEventsFiles = $oFile->listLastFiles( 'container.tpl' );
  $content .= $oTpl->tBlock( 'container.tpl', 'HOME' );
}
elseif( isset( $aActions ) && is_file( DIR_ACTIONS.'admin-'.$aActions['f'].'.php' ) ){
  if( ( $a == 'delete' || count( $_POST ) > 0 ) && !empty( $_SERVER['HTTP_REFERER'] ) && !strstr( $_SERVER['HTTP_REFERER'], $_SERVER['SCRIPT_NAME'] ) ){
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p=error' );
    exit;
  }
  require DIR_ACTIONS.'admin-'.$aActions['f'].'.php';
}

if( empty( $content ) )
  $content .= $oTpl->tBlock( 'messages.tpl', 'ERROR' );

$sLangSelect = throwLangSelect( $config['language'] );
$sTypeSearchSelect = throwSelectFromArray( Array( 1 => $lang['Pages'], 2 => $lang['Files'] ), $iTypeSearch );

if( isset( $config['login'] ) && isset( $config['pass'] ) && $config['login'] == $config['pass'] )
  $sMsg .= $oTpl->tBlock( 'messages.tpl', 'CHANGE_LOGIN_PASSWORD' );

echo $oTpl->tBlock( 'container.tpl', 'HEAD' ).$oTpl->tBlock( 'container.tpl', 'BODY' ).$oTpl->tBlock( 'container.tpl', 'FOOT' );
?>