<?php
/**
* Function returns editor
* @return string
* @param  string  $sName
* @param  int     $iH
* @param  int     $iW
* @param  string  $sContent
*/

function htmlEditor ( $sName = 'sDescriptionFull', $iH = '300', $iW = '100%', $sContent = '', $aOption = null ) {

  if( !strstr( $iH, '%' ) )
    $iH .= 'px';
  if( !strstr( $iW, '%' ) )
    $iW .= 'px';
  $aHtmlConfig['iH'] = $iH;
  $aHtmlConfig['iW'] = $iW;

  $aHtmlConfig['sName'] = $sName;
  $aHtmlConfig['sContent'] = $sContent;

  $oTpl = TplParser::getInstance( );
  $oTpl->setVariables( 'aHtmlConfig', $aHtmlConfig );

  if( defined( 'WYSIWYG' ) && WYSIWYG == true ){
    if( !defined( 'WYSIWYG_START' ) ){
      define( 'WYSIWYG_START', true );
      return $oTpl->tBlock( 'edit.tpl', 'TINY_HEAD' ).$oTpl->tBlock( 'edit.tpl', 'TINY' );
    }
    else{
      return $oTpl->tBlock( 'edit.tpl', 'TINY' );
    }
  }
  else{

    if( $sName == 'sDescriptionShort' )
      return $oTpl->tBlock( 'edit.tpl', 'TEXTAREA' );
    else
      return $oTpl->tBlock( 'edit.tpl', 'EDIT' );
  }
}

?>
