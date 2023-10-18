<?php
/*
* Quick.Cms by OpenSolution.org
* www.OpenSolution.org
*/
extract( $_GET );
define( 'CUSTOMER_PAGE', true );

require 'database/config/general.php';
require DB_CONFIG_LANG;

if( HIDDEN_SHOWS === true )
 session_start( );

header( 'Content-Type: text/html; charset='.$config['charset'] );
require_once DIR_LIBRARIES.'tpl-parser.php';
require_once DIR_LIBRARIES.'file-jobs.php';
require_once DIR_LIBRARIES.'flat-files.php';
require_once DIR_LIBRARIES.'trash.php';
require_once DIR_PLUGINS.'plugins.php';

require_once DIR_DATABASE.'_fields.php';
require_once DIR_CORE.'pages.php';
require_once DIR_CORE.'files.php';

$aActions = isset( $p ) ? getAction( $p ) : getUrlFromGet( );
if( isset( $aActions['f'] ) && $aActions['f'] == 'pages' )
  $iContent = ( isset( $aActions['a'] ) && is_numeric( $aActions['a'] ) ) ? $aActions['a'] : $config['start_page'];
else
  $iContent = null;

$oFFS = FlatFilesSerialize::getInstance( );
$oTpl = TplParser::getInstance( DIR_SKIN, $config['embed_php'], DIR_TEMPLATES.'default/' );

if( defined( 'MOBILE' ) && $config['mobile'] === true ){
  $config['style'] = $config['style_mobile'];
}

if( !defined( 'MOBILE' ) && $config['mobile'] === true && $config['detect_mobile'] === true && detectMobile( $_SERVER['HTTP_USER_AGENT'] ) === true ){
  header( 'Location: mobile.php' );
  exit;
}



$oFile = Files::getInstance( );
$oPage = Pages::getInstance( );
$content = null;
$sTheme = null;
$sBanner = null;

$sKeywords = $config['keywords'];
$sDescription = $config['description'];

if( isset( $aActions ) && is_file( DIR_ACTIONS.$aActions['f'].'.php' ) )
 require DIR_ACTIONS.$aActions['f'].'.php';

if( isset( $sTheme ) && !empty( $sTheme ) && is_file( DIR_THEMES.$sTheme ) ){
  require DIR_THEMES.$sTheme;
}
else{
  if( is_file( DIR_THEMES.$aActions['f'].'-'.$aActions['a'].'.php' ) ){
    require DIR_THEMES.$aActions['f'].'-'.$aActions['a'].'.php';
  }
  else{
    require DIR_THEMES.$config['default_theme'];
  }
}

?>