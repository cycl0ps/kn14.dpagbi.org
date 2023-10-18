<?php
if( isset( $iContent ) && is_numeric( $iContent ) ){
  $aData = $oPage->throwPage( $iContent );
  if( isset( $aData ) ){
    
    if( !empty( $aData['sUrl'] ) ){
      header( 'Location: '.$aData['sUrl'] );
      exit;
    }

    if( !empty( $aData['sTemplate'] ) )
      $oTpl->setFileAlt( $config['default_pages_template'] );
    else{
      if( $config['inherit_from_parents'] === true && !empty( $aData['iPageParent'] ) ){
        $aDataParent = $oPage->throwPage( $aData['iPageParent'] );
        if( !empty( $aDataParent['sTemplate'] ) ){
          $aData['sTemplate'] = $aDataParent['sTemplate'];
          $oTpl->setFileAlt( $config['default_pages_template'] );
        }
      }
    }
    if( empty( $aData['sTemplate'] ) || ( !empty( $aData['sTemplate'] ) && !is_file( DIR_SKIN.$aData['sTemplate'] ) ) ){
      $aData['sTemplate'] = $config['default_pages_template'];
    }
      
    if( !empty( $aData['sTheme'] ) )
      $sTheme = $aData['sTheme'];
    else{
      if( $config['inherit_from_parents'] === true && !empty( $aData['iPageParent'] ) ){
        if( !isset( $aDataParent ) )
          $aDataParent = $oPage->throwPage( $aData['iPageParent'] );
        if( !empty( $aDataParent['sTheme'] ) )
          $sTheme = $aDataParent['sTheme'];
      } 
    }

    if( !empty( $aData['sMetaKeywords'] ) )
      $sKeywords = $aData['sMetaKeywords'];
    if( !empty( $aData['sMetaDescription'] ) )
      $sDescription = $aData['sMetaDescription'];
    if( empty( $aData['sDescriptionFull'] ) )
      $aData['sDescriptionFull'] = $aData['sDescriptionShort'];

    $aData['sPagesTree'] = $oPage->throwPagesTree( $iContent );
    $sBanner = !empty( $aData['sBanner'] ) ? $oTpl->tBlock( $aData['sTemplate'], 'BANNER' ) : null;
    $sTitle = strip_tags( ( !empty( $aData['sNameTitle'] ) ? $aData['sNameTitle'] : $aData['sName'] ).' - ' );
    $sSubpagesList = null;

    $aData['sDescriptionFull'] = changeTxt( $aData['sDescriptionFull'], 'nlNds' );

    if( $aData['iSubpagesShow'] > 0 ){
      if( $aData['iSubpagesShow'] < 3 )
        $sSubpagesList = $oPage->listSubpages( $iContent, $aData['sTemplate'], $aData['iSubpagesShow'] );
    }

    $aImages = $oFile->listImagesByTypes( $aData['sTemplate'], $iContent );
    $sFilesList = $oFile->listFiles( $aData['sTemplate'], $iContent );

    if( $config['text_size'] == true )
      $oTpl->setIf( 'TXT_SIZE' );
    if( isset( $aData['sPages'] ) )
      $oTpl->setIf( 'PAGES' );
    if( isset( $aData['sPagesTree'] ) )
      $oTpl->setIf( 'NAVIPATH' );

    $oTpl->unsetVariables( );
    $content .= $oTpl->tBlock( $aData['sTemplate'], 'CONTAINER' );
  }
  else{
    header( "HTTP/1.0 404 Not Found\r\n" );
    $sTitle = $lang['404_error'].' - ';
    $content .= $oTpl->tBlock( 'messages.tpl', 'ERROR' );
  }
}
?>