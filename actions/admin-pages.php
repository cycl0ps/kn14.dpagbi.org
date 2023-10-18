<?php
if( $a == 'list' ){
  if( isset( $_POST['sOption'] ) ){
    $oPage->savePages( $_POST );
    $sOption = 'save';
  }

  if( isset( $sOption ) ){
    $content .= $oTpl->tBlock( 'messages.tpl', 'DONE' );
  }
  
  $content .= $oTpl->tBlock( 'pages.tpl', 'LIST_TITLE' );
  $sList = ( isset( $sPhrase ) && !empty( $sPhrase ) ) ? $oPage->listPagesAdminSearch( 'pages.tpl', $sPhrase ) : $oPage->listPagesAdmin( 'pages.tpl' );
  $content .= !empty( $sList ) ? $sList : $oTpl->tBlock( 'messages.tpl', 'EMPTY' );
}
elseif( $a == 'form' ){
  if( isset( $_POST['sName'] ) ){
    $iPage = $oPage->savePage( $_POST );
    if( isset( $_POST['sOptionList'] ) )
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['f'].'-list&sOption=save' );
    else
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$p.'&sOption=save&iPage='.$iPage );
    exit;
  }

  if( isset( $sOption ) )
    $content .= $oTpl->tBlock( 'messages.tpl', 'DONE' );

  if( isset( $iPage ) && is_numeric( $iPage ) ){
    $aData = $oPage->throwPage( $iPage );
  }

  if( isset( $aData ) && is_array( $aData ) ){
    $aData['sDescriptionShort'] = changeTxt( $aData['sDescriptionShort'], 'nlNds' );
    $aData['sDescriptionFull'] = changeTxt( $aData['sDescriptionFull'], 'nlNds' );
    $sFilesList = $oFile->listAllLinkFiles( 'files.tpl', $iPage, 1 );
  }
  else{
    $aData['iStatus'] = 1;
    $aData['iType'] = 1;
    $aData['iSubpagesShow'] = 1;
    $aData['iPageParent'] = null;
    $aData['iPosition'] = 0;
    $iPage = null;
    $aData['sDescriptionFull'] = null;
    $aData['sDescriptionShort']= null;
  }

  $sStatusBox = throwYesNoBox( 'iStatus', $aData['iStatus'] );
  $sTypesSelect = throwSelectFromArray( $aMenuTypes, $aData['iType'] );
  $sTemplatesSelect = throwTemplatesSelect( 'pages_', isset( $aData['sTemplate'] ) ? $aData['sTemplate'] : null );
  $sThemesSelect = throwThemesSelect( isset( $aData['sTheme'] ) ? $aData['sTheme'] : null );
  $sSubpagesShowSelect = throwSubpagesShowSelect( $aData['iSubpagesShow'] );
  $sPagesSelect = $oPage->throwPagesSelectAdmin( $aData['iPageParent'] );
  $sSize1Select = throwSelectFromArray( $config['pages_images_sizes'], $config['pages_default_image_size'] );
  $sSize2Select = throwSelectFromArray( $config['pages_images_sizes'], $config['pages_default_image_size'] );
  $sPhotoTypesSelect = throwSelectFromArray( $aPhotoTypes, 1 );
  $sFilesDir = ( $config['display_all_files'] === true ) ? $oFile->listFilesInDir( 'files.tpl', $iPage, 1 ) : null;
  $oTpl->unsetVariables( );

  $sDescriptionShort = htmlEditor ( 'sDescriptionShort', '120', '100%', $aData['sDescriptionShort'], Array( 'aOptions' => Array( 'ToolbarStartExpanded' => false ), 'ToolbarSet' => 'Basic' ) ) ;
  $sDescriptionFull = htmlEditor ( 'sDescriptionFull', '280', '100%', $aData['sDescriptionFull'], Array( 'ToolbarSet' => 'DescriptionFull' ) ) ;
  
  $sFilesForm = $oFile->createForm( 'files.tpl' );
  if( !isset( $sFilesList ) )
    $sFilesList = $oTpl->tBlock( 'messages.tpl', 'EMPTY' );

  if( !empty( $aData['sBanner'] ) )
    $oTpl->setIf( 'BANNER_FORM' );
  
  $oTpl->unsetVariables( );
  $sFormTabs = $oTpl->tBlock( 'pages.tpl', 'FORM_TABS' );
  $content .= $oTpl->tBlock( 'pages.tpl', 'FORM_MAIN' );
}
elseif( $a == 'delete' && isset( $iPage ) && is_numeric( $iPage ) ){
  if( !isset( $bWithoutFiles ) )
    $bWithoutFiles = null;
  $oPage->deletePage( $iPage, $bWithoutFiles );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['f'].'-list&sOption=del' );
  exit;
}
$iTypeSearch = 1;
?>