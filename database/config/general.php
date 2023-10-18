<?php
$sValue = (float) phpversion( );
if( $sValue < '5.2' ){
  exit( '<h2><center>REQUIRED PHP VERSION IS 5.2.0, YOU HAVE '.phpversion( ).'</center></h2>' );
}

#error_reporting( E_ALL );
unset( $config, $aMenuTypes, $aPhotoTypes, $lang );

/*
* Set true if logged administrator will be able
* to see hidden pages (in client-side)
*/
$config['hidden_shows'] = false;

/*
* Set true if mobile version will be able
*/
$config['mobile'] = true;

/*
* If mobile browser is detected then redirect to mobile version
*/
$config['detect_mobile'] = true;

/*
* If You want embed PHP code in template files
* set this variable true but it is not recommended and
* script will generate code much slower
*/
$config['embed_php'] = false;

/*
* Add minutes difference between your local time and server time
*/
$config['time_diff'] = 0;

/*
* Administrator login and password
*/
$config['login'] = "admin";
$config['pass'] = "admin";

/*
* Default language
*/
$config['default_lang'] = "en";

/*
* Admin panel language
*/
$config['admin_lang'] = "en";

/*
* If should be use wysiwyg editor or default
*/
$config['wysiwyg'] = true;

/*
* CSS styles file
*/
$config['style'] = "style.css";

/*
* Mobile CSS styles file
*/
$config['style_mobile'] = "mobile.css";

/*
* If should be text size change option on pages
*/
$config['text_size'] = true;

/*
* If files should be copied if use the same
*/
$config['copy_the_same_files'] = false;

$config['display_all_files'] = true;
$config['display_expanded_menu'] = true;
$config['change_files_names'] = false;
$config['inherit_from_parents'] = false;

$config['pages_images_sizes'] = Array( 0 => 100, 1 => 150, 2 => 200 );
$config['pages_default_image_size'] = 1;
$config['max_dimension_of_image'] = 900;
$config['admin_list'] = 25;

/*
* If should be language parameter added to url
*/
$config['language_in_url'] = false;

/*
* Language separator in url
*/
$config['language_separator'] = '_';

define( 'LANGUAGE_IN_URL', $config['language_in_url'] );
define( 'LANGUAGE_SEPARATOR', $config['language_separator'] );

/*
* Skin directory
*/
$config['skin'] = "default";

/*
* DONT CHANGE CODE BELOW!
*
* Directories
*/
$config['dir_core'] = 'core/';
$config['dir_database'] = 'database/';
$config['dir_libraries'] = $config['dir_core'].'libraries/';
$config['dir_lang'] = $config['dir_database'].'translations/';
$config['dir_templates'] = 'templates/';
$config['dir_skin'] = $config['dir_templates'].$config['skin'].'/';
$config['dir_files'] = 'files/';
$config['dir_plugins'] = 'plugins/';
$config['dir_actions'] = 'actions/';
$config['dir_themes'] = $config['dir_actions'].'themes/';

require_once $config['dir_core'].'common.php';

$config['cookie_admin'] = defined( 'CUSTOMER_PAGE' ) ? null : 'A';

if( defined( 'CUSTOMER_PAGE' ) && !isset( $sLang ) && LANGUAGE_IN_URL === true )
  $sLang = getLanguageFromUrl( );

if( isset( $sLang ) && is_file( $config['dir_lang'].$sLang.'.php' ) && strlen( $sLang ) == 2 ){
  setCookie( 'sLanguage'.$config['cookie_admin'], $sLang, time( ) + 86400 );
  define( 'LANGUAGE', $sLang );
}
else{
  if( !empty( $_COOKIE['sLanguage'.$config['cookie_admin']] ) && is_file( $config['dir_lang'].$_COOKIE['sLanguage'.$config['cookie_admin']].'.php' ) && strlen( $_COOKIE['sLanguage'.$config['cookie_admin']] ) == 2 )
    define( 'LANGUAGE', $_COOKIE['sLanguage'.$config['cookie_admin']] );
  else
    define( 'LANGUAGE', $config['default_lang'] );
}

require_once defined( 'CUSTOMER_PAGE' ) ? $config['dir_lang'].LANGUAGE.'.php' : $config['dir_lang'].$config['admin_lang'].'.php';

$aMenuTypes = Array( 1 => $lang['Menu_1'], 2 => $lang['Menu_2'], 3 => $lang['Menu_3'] );
$aPhotoTypes = Array( 1 => $lang['Left'], 2 => $lang['Right'] );

$config['config'] = $config['dir_database'].'config/general.php';
$config['config_lang'] = $config['dir_database'].'config/lang_'.LANGUAGE.'.php';

$config_db['pages'] = $config['dir_database'].LANGUAGE.'_pages.php';
$config_db['pages_files'] = $config['dir_database'].LANGUAGE.'_pages_files.php';

$config['language'] = LANGUAGE;
$config['version'] = '4.1';

$config['last_login'] = 0;
$config['before_last_login'] = 0;
$config['failed_login_time'] = 0;
$config['failed_login_count'] = 0;

$config['default_theme'] = "default.php";
$config['default_pages_template'] = "pages_default.tpl";

$config['manual_link'] = 'http://opensolution.org/Quick.Cms/docs/?id='.( ( $config['admin_lang']=='pl' ) ? 'pl' : 'en' ).'-';

define( 'DIR_CORE', $config['dir_core'] );
define( 'DIR_DATABASE', $config['dir_database'] );
define( 'DIR_FILES', $config['dir_files'] );
define( 'DIR_LIBRARIES', $config['dir_libraries'] );
define( 'DIR_PLUGINS', $config['dir_plugins'] );
define( 'DIR_LANG', $config['dir_lang'] );
define( 'DIR_TEMPLATES', $config['dir_templates'] );
define( 'DIR_SKIN', $config['dir_skin'] );
define( 'DIR_THEMES', $config['dir_themes'] );
define( 'DIR_ACTIONS', $config['dir_actions'] );

define( 'DB_PAGES', $config_db['pages'] );
define( 'DB_PAGES_FILES', $config_db['pages_files'] );

define( 'DB_CONFIG', $config['config'] );
define( 'DB_CONFIG_LANG', $config['config_lang'] );

define( 'MAX_DIMENSION_OF_IMAGE', $config['max_dimension_of_image'] );
define( 'HIDDEN_SHOWS', $config['hidden_shows'] );
define( 'DISPLAY_EXPANDED_MENU', $config['display_expanded_menu'] );
define( 'WYSIWYG', $config['wysiwyg'] );
define( 'COPY_THE_SAME_FILES', $config['copy_the_same_files'] );
define( 'VERSION', $config['version'] );
define( 'TIME_DIFF', $config['time_diff'] );
define( 'SESSION_KEY_NAME', md5( dirname( $_SERVER['SCRIPT_FILENAME'] ) ) );
?>