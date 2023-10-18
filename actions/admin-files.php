<?php
if( $a == 'list' ){
  if( isset( $_POST['sOption'] ) ){
    $oFile->saveFiles( $_POST );
    $sOption = 'save';
  }

  if( isset( $sOption ) ){
    $content .= $oTpl->tBlock( 'messages.tpl', 'DONE' );
  }
  
  $content .= $oTpl->tBlock( 'files.tpl', 'LIST_TITLE' );
  $sList = $oFile->listAllFiles( 'files.tpl' );
  $content .= !empty( $sList ) ? $sList : $oTpl->tBlock( 'messages.tpl', 'EMPTY' );
}
$iTypeSearch = 2;
?>