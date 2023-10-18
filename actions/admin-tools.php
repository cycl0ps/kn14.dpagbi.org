<?php
if( $a == 'config' ){
  if( isset( $_POST['sOption'] ) ){
    saveVariables( $_POST, DB_CONFIG );
    saveVariables( $_POST, DB_CONFIG_LANG );
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$p.'&sOption=save' );
    exit;
  }
  else{
    if( isset( $sOption ) ){
      $content .= $oTpl->tBlock( 'messages.tpl', 'DONE' );
    }

    $sSkinsSelect = throwSkinsSelect( $config['skin'] );
    $sLangSelect = throwLangSelect( $config['default_lang'] );
    $sLangAdminSelect = throwLangSelect( $config['admin_lang'] );
    $sStartPageSelect = $oPage->throwPagesSelectAdmin( $config['start_page'] );
    $sHiddenShowsSelect = throwTrueFalseOrNullSelect( $config['hidden_shows'] );
    $sWysiwygSelect = throwTrueFalseOrNullSelect( $config['wysiwyg'] );
    $sDisplayAllFilesSelect = throwTrueFalseOrNullSelect( $config['display_all_files'] );
    $sChangeFilesNamesSelect = throwTrueFalseOrNullSelect( $config['change_files_names'] );
    $sInheritFromParentsSelect = throwTrueFalseOrNullSelect( $config['inherit_from_parents'] );
    $sExpandedMenuSelect = throwTrueFalseOrNullSelect( $config['display_expanded_menu'] );
    $sTextSizeSelect = throwTrueFalseOrNullSelect( $config['text_size'] );
    $sLanguageInUrl = throwTrueFalseOrNullSelect( $config['language_in_url'] );
    $sCopyTheSameFiles = throwTrueFalseOrNullSelect( $config['copy_the_same_files'] );

    $sFormTabs = $oTpl->tBlock( 'settings.tpl', 'CONFIG_TABS' );
    $content .= $oTpl->tBlock( 'settings.tpl', 'CONFIG_MAIN' );
  }
}
?>