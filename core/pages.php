<?php
class Pages
{

  public $aPages = null;
  public $aPagesChildrens = null;
  public $aPagesParentsTypes = null;
  protected $aPagesKeys = null;
  protected $aPagesParents = null;
  protected $aPageParents = null;
  protected $mData = null;
  protected $aFields = null;
  private static $oInstance = null;

  public static function getInstance( ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new Pages( );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
  */
  private function __construct( ){
    $this->generateCache( );
  } // end function __construct

  /**
  * Return pages to menu
  * @return string
  * @param string $sFile
  * @param int $iType
  * @param int $iPageCurrent
  * @param int $iDepthLimit
  */
  public function throwMenu( $sFile, $iType, $iPageCurrent = null, $iDepthLimit = 1 ){

    if( !isset( $this->aPagesParentsTypes[$iType] ) )
      return null;
    $this->mData = null;
    
    if( isset( $iPageCurrent ) )
      $this->generatePageParents( $iPageCurrent );

    $this->generateMenuData( $iType, $iPageCurrent, $iDepthLimit, 0 );
    if( isset( $this->mData[0] ) ){
      $oTpl = TplParser::getInstance( );
      $content = null;
      $i = 0;
      $iCount = count( $this->mData[0] );

      foreach( $this->mData[0] as $iPage => $bValue ){
        $aData = $this->aPages[$iPage];

        $aData['sSubContent'] = isset( $this->mData[$iPage] ) ? $this->throwSubMenu( $sFile, $iPage, $iPageCurrent, 1 ) : null;

        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;
        $aData['iDepth'] = 0;
        if( $aData['iPage'] == $iPageCurrent )
          $oTpl->setIf( 'SELECTED' );

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST' );

        $i++;
      } // end foreach

      if( isset( $content ) ){
        $aData['sMenuType'] = $GLOBALS['aMenuTypes'][$iType];
        $aData['iType'] = $iType;
        $oTpl->setVariables( 'aData', $aData );
        if( $iType > 2 ) 
          $oTpl->setIf( 'TYPE' );
        return $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'PAGES', 'LIST', 'foot' );
      }
    }
  } // end function throwMenu

  /**
  * Display sub menu
  * @return string
  * @param string $sFile
  * @param int $iPageParent
  * @param int $iPageCurrent
  * @param int $iDepth
  */
  public function throwSubMenu( $sFile, $iPageParent, $iPageCurrent, $iDepth = 1 ){
    if( isset( $this->mData[$iPageParent] ) ){
      $oTpl = TplParser::getInstance( );
      $content = null;
      $i = 0;
      $iCount = count( $this->mData[$iPageParent] );

      foreach( $this->mData[$iPageParent] as $iPage => $bValue ){
        $aData = $this->aPages[$iPage];

        $aData['sSubContent'] = isset( $this->aPagesChildrens[$iPage] ) ? $this->throwSubMenu( $sFile, $iPage, $iPageCurrent, $iDepth + 1 ) : null;

        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;
        $aData['iDepth'] = $iDepth;
        if( $aData['iPage'] == $iPageCurrent )
          $oTpl->setIf( 'SELECTED' );

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST' );
        $i++;
      }

      if( isset( $content ) ){
        return $oTpl->tBlock( $sFile, 'HEAD_SUB' ).$content.$oTpl->tBlock( $sFile, 'FOOT_SUB' );
      }
    }
  } // end function throwSubMenu

  /**
  * Return variable with menu
  * @return null
  * @param int $iType
  * @param int $iPageCurrent
  * @param int $iDepthLimit
  * @param int $iDepth
  * @param int $iPageParent
  */
  protected function generateMenuData( $iType, $iPageCurrent, $iDepthLimit, $iDepth = 0, $iPageParent = null ){
    if( !isset( $this->mData ) ){
      $aData = $this->aPagesParentsTypes[$iType];
    }
    else{
      if( isset( $this->aPagesChildrens[$iPageParent] ) )
        $aData = $this->aPagesChildrens[$iPageParent];
    }

    if( isset( $aData ) ){
      foreach( $aData as $iKey => $iPage ){
        $this->mData[$this->aPages[$iPage]['iPageParent']][$iPage] = true;
        if( $iDepthLimit > $iDepth && ( $iPageCurrent == $iPage || isset( $this->aPageParents[$iPage] ) || DISPLAY_EXPANDED_MENU === true ) ){
          $this->generateMenuData( $iType, $iPageCurrent, $iDepthLimit, $iDepth + 1, $iPage );
        }
      } // end foreach    
    }
  } // end function generateMenuData

  /**
  * Return variable with search results
  * @return array
  * @param string $sPhrase
  */
  protected function generatePagesSearchListArray( $sPhrase ){
    if( isset( $this->aPages ) ){
      $aExp = explode( ' ', $sPhrase );
      $iCount = count( $aExp );
      for( $i = 0; $i < $iCount; $i++ ){
        $aExp[$i] = trim( $aExp[$i] );
        if( !empty( $aExp[$i] ) )
          $aWords[] = $aExp[$i];
      } // end for

      $iCount = count( $aWords );

      foreach( $this->aPages as $iPage => $aPage ){
        $iFound = 0;
        $sSearchData = implode( ' ', $aPage );

        for( $i = 0; $i < $iCount; $i++ ){
          if( stristr( $sSearchData, $aWords[$i] ) )
            $iFound++;
        } // end for

        if( $iFound == $iCount ){
          $aPages[] = $iPage;
        }
      }

      if( isset( $aPages ) )
        return $aPages;
    }
  } // end function generatePagesSearchListArray

  /**
  * Return page data
  * @return array
  * @param int  $iPage
  */
  public function throwPage( $iPage ){
    if( isset( $this->aPages[$iPage] ) ){
      $aData = $this->aPages[$iPage];
      if( isset( $aData ) ){
        $aFile = null;
        if( defined( 'CUSTOMER_PAGE' ) && strstr( $aData['sDescriptionFull'], '[break]' ) ){
          $aExp = explode( '[break]', $aData['sDescriptionFull'] );
          if( isset( $GLOBALS['aActions']['o4'] ) && is_numeric( $GLOBALS['aActions']['o4'] ) )
            $iPageContent = $GLOBALS['aActions']['o4'];
          else
            $iPageContent = 1;

          if( isset( $aExp[$iPageContent - 1] ) ){
            $aData['sDescriptionFull'] = $aExp[$iPageContent - 1];
            $sLink = isset( $this->aPages[$iPage]['sLinkNameHome'] ) ? $this->aPages[$iPage]['sLinkNameHome'] : $this->aPages[$iPage]['sLinkName'];
            $aData['sPages'] = countPages( count( $aExp ), 1, $iPageContent, $sLink.',,', null, null, null, MAX_PAGES );
          }
        }
        return $aData;
      }
    }
    else
      return null;
  } // end function throwPage

  /**
  * Return pages tree
  * @return string
  * @param int  $iPage
  * @param int  $iPageCurrent
  */
  public function throwPagesTree( $iPage, $iPageCurrent = null ){
    if( !isset( $iPageCurrent ) ){
      $iPageCurrent = $iPage;
      $this->mData = null;
    }
    
    if( isset( $this->aPagesParents[$iPage] ) && isset( $this->aPages[$this->aPagesParents[$iPage]] ) ){
      $this->mData[] = '<a href="'.$this->aPages[$this->aPagesParents[$iPage]]['sLinkName'].'">'.$this->aPages[$this->aPagesParents[$iPage]]['sName'].'</a>';
      return $this->throwPagesTree( $this->aPagesParents[$iPage], $iPageCurrent );
    }
    else{
      if( isset( $this->mData ) ){
        array_unshift( $this->mData, '<a href="'.$this->aPages[$iPageCurrent]['sLinkName'].'">'.$this->aPages[$iPageCurrent]['sName'].'</a>' );
        $aReturn = array_reverse( $this->mData );
        $this->mData = null;
        return implode( '&nbsp;&raquo;&nbsp;', $aReturn );
      }
    }
  } // end function throwPagesTree

  /**
  * Return all childrens
  * @return array
  * @param int  $iPage
  */
  protected function throwAllChildrens( $iPage ){
    $bFirst = !isset( $this->mData ) ? true : null;
    if( isset( $this->aPagesChildrens[$iPage] ) ){
      foreach( $this->aPagesChildrens[$iPage] as $iValue ){
        if( isset( $this->aPages[$iValue] ) ){
          $this->mData[] = $iValue;
          $this->throwAllChildrens( $iValue );
        }
      }
    }
    return isset( $bFirst ) ? $this->mData : null;
  } // end function throwAllChildrens

  /**
  * Return list of subpages
  * @return string
  * @param mixed $mData
  * @param string $sFile
  * @param int $iType
  */
  public function listSubpages( $mData, $sFile, $iType ){

    if( is_array( $mData ) )
      $aPages = $mData;
    else{
      if( isset( $this->aPagesChildrens[$mData] ) )
        $aPages = $this->aPagesChildrens[$mData];
    }

    if( isset( $aPages ) ){
      if( $iType > 1 ){
        $oFile = Files::getInstance( );
      }
      
      $sType = ( $iType < 3 ) ? 'DEFAULT' : $iType;
      $iCount = count( $aPages );
      $content= null;
      $oTpl = TplParser::getInstance( );
      
      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $this->aPages[$aPages[$i]];
        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;
        $aData['sImage'] = null;

        if( !empty( $aData['sDescriptionShort'] ) ){
          $aData['sDescriptionShort'] = changeTxt( $aData['sDescriptionShort'], 'nlNds' );
          $oTpl->setVariables( 'aData', $aData );
          $oTpl->setIf( 'DESCRIPTION' );
        }

        if( isset( $oFile ) && isset( $oFile->aImagesDefault[1][$aData['iPage']] ) ){
          $aDataImage = $oFile->aFilesImages[1][$oFile->aImagesDefault[1][$aData['iPage']]];
          $oTpl->setVariables( 'aDataImage', $aDataImage );
          $oTpl->setIf( 'IMAGE' );
        }

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'SUBPAGES_'.$sType, 'LIST' );
      } // end for

      if( isset( $content ) ){
        $aData['iType'] = $iType;
        $oTpl->setVariables( 'aData', $aData );
        return $oTpl->tSubBlock( $sFile, 'SUBPAGES_'.$sType, 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'SUBPAGES_'.$sType, 'LIST', 'foot' );
      }
    }
  } // end function listSubpages

  /**
  * Generate cache variables
  * @return void
  */
  public function generateCache( ){

    if( !is_file( DB_PAGES ) )
      return null;

    $this->aFields = $GLOBALS['aPagesFields'];

    $oFFS = FlatFilesSerialize::getInstance( );
    $aData = $oFFS->getData( DB_PAGES );
    if( !is_array( $aData ) || ( is_array( $aData ) && count( $aData ) == 0 ) )
      return null;

    $iStatus = throwStatus( );
    $sLanguageUrl = ( LANGUAGE_IN_URL == true ) ? LANGUAGE.LANGUAGE_SEPARATOR : null;

    $this->aPages = null;
    $this->aPagesChildrens = null;
    $this->aPagesParents = null;
    $this->aPagesParentsTypes = null;

    foreach( $aData as $iKey => $aValue ){
      if( isset( $aValue['iStatus'] ) && $aValue['iStatus'] >= $iStatus ){
        $this->aPages[$aValue['iPage']] = $aValue;
        $this->aPagesKeys[$iKey] = $aValue['iPage'];
        if( !is_numeric( $aValue['iPageParent'] ) )
          $this->aPages[$aValue['iPage']]['iPageParent'] = 0;

        $sUrlName = !empty( $this->aPages[$aValue['iPage']]['sNameUrl'] ) ? $this->aPages[$aValue['iPage']]['sNameUrl'] : $this->aPages[$aValue['iPage']]['sName'];
        $this->aPages[$aValue['iPage']]['sLinkName'] = '?'.$sLanguageUrl.change2Url( $sUrlName ).','.$aValue['iPage'];
        
        if( $GLOBALS['config']['start_page'] == $aValue['iPage'] ){
          $sLinkHome = './';
          if( !defined( 'MOBILE' ) ){
            $this->aPages[$aValue['iPage']]['sLinkNameHome'] = $this->aPages[$aValue['iPage']]['sLinkName'];
            $this->aPages[$aValue['iPage']]['sLinkName'] = $sLinkHome;
          }
          if( !defined( 'INDEX' ) ){
            $GLOBALS['config']['index'] = $sLinkHome;
            define( 'INDEX', $GLOBALS['config']['index'] );          
          }
        }
        
        if( $aValue['iPageParent'] > 0 ){
          $this->aPagesChildrens[$aValue['iPageParent']][] = $aValue['iPage'];
          $this->aPagesParents[$aValue['iPage']] = $aValue['iPageParent'];
        }
        else{
          if( !empty( $aValue['iType'] ) )
            $this->aPagesParentsTypes[$aValue['iType']][] = $aValue['iPage'];
        }
      }
    }

  } // end function generateCache

  /**
  * Generate page all parents
  * @return void
  * @param int  $iPage
  */
  protected function generatePageParents( $iPage ){
    if( isset( $this->aPagesParents[$iPage] ) ){
      $this->aPageParents[$this->aPagesParents[$iPage]] = true;
      $this->generatePageParents( $this->aPagesParents[$iPage] );
    }
  } // end function generatePageParents

  /**
  * Sort pages
  * @return array
  * @param array $aPages
  * @param string $sSort
  */
  protected function sortPages( $aPages, $sSort = null ){
    $iCount = count( $aPages );
    $sFunctionSort = 'rsort';
    $sKey = 'iPage';

    if( $sSort == 'name' ){
      $sKey = 'sName';
      $sFunctionSort = 'sort';
    }

    for( $i = 0; $i < $iCount; $i++ ){
      $mValue = $this->aPages[$aPages[$i]][$sKey]; 
      $aSort[$i][0] = $mValue;
      $aSort[$i][1] = $aPages[$i];
    } // end for

    $sFunctionSort( $aSort );
    for( $i = 0; $i < $iCount; $i++ ){
      $aPages[$i] = $aSort[$i][1];
    } // end for   
   
    return $aPages;
  } // end function sortPages 

};
?>