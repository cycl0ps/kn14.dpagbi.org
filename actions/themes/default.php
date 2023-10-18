<?php
if( empty( $content ) )
  $content .= $oTpl->tBlock( 'messages.tpl', 'ERROR' );

if( !isset( $bBlockPage ) ){
  $sMenu1 = $oPage->throwMenu( 'menus.tpl', 1, $iContent, 0 );
  $sMenu2 = $oPage->throwMenu( 'menus.tpl', 2, $iContent, 0 );
  $sMenu3 = $oPage->throwMenu( 'menus.tpl', 3, $iContent, 1 );
}

$oTpl->unsetVariables( );
echo $oTpl->tBlock( 'container.tpl', 'HEAD' ).$oTpl->tBlock( 'container.tpl', 'BODY' ).$oTpl->tBlock( 'container.tpl', 'FOOT' );

?>