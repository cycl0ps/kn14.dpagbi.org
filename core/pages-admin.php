<?php
final class PagesAdmin extends Pages{

  private static $oInstance = null;

  public static function getInstance( ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new PagesAdmin( );  
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
  * Return pages list
  * @return string
  * @param string $sFile
  */
  public function listPagesAdmin( $sFile ){
    if( isset( $this->aPagesParentsTypes ) ){
      $oTpl = TplParser::getInstance( );
      $content = null;

      foreach( $this->aPagesParentsTypes as $iType => $aPages ){
        $iCount = count( $aPages );
       
        $oTpl->setVariables( 'sType', $GLOBALS['aMenuTypes'][$iType] );
        $oTpl->setIf( 'TYPE' );

        if( isset( $_GET['sSort'] ) && !empty( $_GET['sSort'] ) ){
          $aPages = $this->sortPages( $aPages, $_GET['sSort'] );
        }

        for( $i = 0; $i < $iCount; $i++ ){
          $aData = $this->aPages[$aPages[$i]];
          $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
          $aData['iDepth'] = 0;

          $aData['sStatusBox'] = ( $aData['iStatus'] == 1 ) ? ' checked="checked"' : null;

          $oTpl->setVariables( 'aData', $aData );
          $content .= $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST' );
          if( isset( $this->aPagesChildrens[$aData['iPage']] ) ){
            $content .= $this->listSubpagesAdmin( $sFile, $aData['iPage'], $aData['iDepth'] + 1 );
          }
        } // end for
      }
      if( isset( $content ) )
        return $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'PAGES', 'LIST', 'foot' );
    }
  } // end function listPagesAdmin

  /**
  * Return subpages to admin
  * @return string
  * @param string $sFile
  * @param int $iPageParent
  * @param int $iDepth
  */
  public function listSubPagesAdmin( $sFile, $iPageParent, $iDepth ){
    $oTpl = TplParser::getInstance( );
    $content = null;
    $iCount = count( $this->aPagesChildrens[$iPageParent] );
    
    if( isset( $_GET['sSort'] ) && !empty( $_GET['sSort'] ) ){
      $this->aPagesChildrens[$iPageParent] = $this->sortPages( $this->aPagesChildrens[$iPageParent], $_GET['sSort'] );
    }

    for( $i = 0; $i < $iCount; $i++ ){
      $aData = $this->aPages[$this->aPagesChildrens[$iPageParent][$i]];
      $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
      $aData['iDepth'] = $iDepth;

      $aData['sStatusBox'] = ( $aData['iStatus'] == 1 ) ? ' checked="checked"' : null;

      $oTpl->setVariables( 'aData', $aData );
      $content .= $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST' );
      if( isset( $this->aPagesChildrens[$aData['iPage']] ) ){
        $content .= $this->listSubpagesAdmin( $sFile, $aData['iPage'], $aData['iDepth'] + 1 );
      }
    } // end for
    return $content;
  } // end function listSubPagesAdmin

  /**
  * Return pages searched by phrase
  * @return string
  * @param string $sFile
  * @param string $sPhrase
  */
  public function listPagesAdminSearch( $sFile, $sPhrase ){

    $aPages = $this->generatePagesSearchListArray( $sPhrase );

    if( isset( $aPages ) ){
      if( isset( $_GET['sSort'] ) && !empty( $_GET['sSort'] ) ){
        $aPages = $this->sortPages( $aPages, $_GET['sSort'] );
      }
      $oTpl = TplParser::getInstance( );
      $content = null;
      $iCount = count( $aPages );
      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $this->aPages[$aPages[$i]];
        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['sStatusBox'] = ( $aData['iStatus'] == 1 ) ? ' checked="checked"' : null;

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST' );
      } // end for

      return $oTpl->tSubBlock( $sFile, 'PAGES', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'PAGES', 'LIST', 'foot' );
    }
  } // end function listPagesAdminSearch

  /**
  * Return pages select for admin panel
  * @return string
  * @param int  $iPageSelected
  */
  public function throwPagesSelectAdmin( $iPageSelected ){
    if( isset( $this->aPagesParentsTypes ) ){
      $content = null;
      foreach( $this->aPagesParentsTypes as $iType => $aPages ){
        $iCount = count( $aPages );
        $sType = $GLOBALS['aMenuTypes'][$iType];
        $content .= '<option value="0" disabled="disabled" style="color:#999;">'.$sType.'</option>';

        for( $i = 0; $i < $iCount; $i++ ){
          $sSelected = ( $iPageSelected == $this->aPages[$aPages[$i]]['iPage'] ) ? ' selected="selected"' : null;
          $content .= '<option value="'.$this->aPages[$aPages[$i]]['iPage'].'"'.$sSelected.'>'.$this->aPages[$aPages[$i]]['sName'].'</option>';
          if( isset( $this->aPagesChildrens[$aPages[$i]] ) ){
            $content .= $this->throwSubPagesSelectAdmin( $iPageSelected, $aPages[$i], 1 );
          }
        } // end for
      }
      return $content;
    }
  } // end function throwPagesSelectAdmin

  /**
  * Return pages select for admin panel
  * @return string
  * @param int $iPageSelected
  * @param int $iPageParent
  * @param int $iDepth
  */
  public function throwSubPagesSelectAdmin( $iPageSelected, $iPageParent, $iDepth = 1 ){
    $iCount = count( $this->aPagesChildrens[$iPageParent] );
    $sSeparator = ( $iDepth > 0 ) ? str_repeat( '&nbsp;&nbsp;', $iDepth ) : null;
    $content = null;

    for( $i = 0; $i < $iCount; $i++ ){
      $iPage = $this->aPagesChildrens[$iPageParent][$i];
      $sSelected = ( $iPageSelected == $iPage ) ? ' selected="selected"' : null;
      $content .= '<option value="'.$this->aPages[$iPage]['iPage'].'"'.$sSelected.'>'.$sSeparator.$this->aPages[$iPage]['sName'].'</option>';
      if( isset( $this->aPagesChildrens[$iPage] ) ){
        $content .= $this->throwSubPagesSelectAdmin( $iPageSelected, $iPage, $iDepth + 1 );
      }
    } // end for
    return $content;
  } // end function throwSubPagesSelectAdmin

  /**
  * Delete page and subpages
  * @return void
  * @param int  $iPage
  * @param bool $bWithoutFiles
  */
  public function deletePage( $iPage, $bWithoutFiles ){
    $oFile = FilesAdmin::getInstance( );

    // array with page to delete
    $this->mData[$iPage] = true;
    // if page have some sub-pages then script will delete sub-pages too
    if( isset( $this->aPagesChildrens[$iPage] ) ){
      $this->throwSubpagesIdAdmin( $iPage );
    }

    foreach( $this->mData as $iKey => $bValue ){
      unset( $this->aPages[$iKey] );
    } // end foreach
    $aSave = $this->createArray( $this->aPages );

    $oFFS = FlatFilesSerialize::getInstance( );
    $oFFS->saveData( DB_PAGES, $aSave );

    $oFile->deleteFiles( $this->mData, 1, 'iPage', $bWithoutFiles );

  } // end function deletePage

  /**
  * Return all subpages id
  * @return void
  * @param int  $iPage
  */
  private function throwSubpagesIdAdmin( $iPage ){
    $iCount = count( $this->aPagesChildrens[$iPage] );
    for( $i = 0; $i < $iCount; $i++ ){
      $this->mData[$this->aPagesChildrens[$iPage][$i]] = true;
      if( isset( $this->aPagesChildrens[$this->aPagesChildrens[$iPage][$i]] ) ){
        $this->throwSubpagesIdAdmin( $this->aPagesChildrens[$iPage][$i] );
      }
    } // end for
  } // end function throwSubpagesIdAdmin

  /**
  * Save page data
  * @return int
  * @param array  $aForm
  */
  public function savePage( $aForm ){
    $oFFS = FlatFilesSerialize::getInstance( );
    $oFile = FilesAdmin::getInstance( );

    $aData = $this->aPages;

    if( isset( $aForm['iPage'] ) && is_numeric( $aForm['iPage'] ) && isset( $aData[$aForm['iPage']] ) ){
    }
    else{
      $aForm['iPage'] = $oFFS->throwLastId( DB_PAGES, 'iPage' ) + 1;
    }
    
    if( empty( $aForm['iPageParent'] ) || ( !empty( $aForm['iPageParent'] ) && $aForm['iPageParent'] == $aForm['iPage'] ) )
      $aForm['iPageParent'] = 0;
    else{
      if( $aForm['iPageParent'] > 0 && isset( $aData[$aForm['iPageParent']] ) ){
        $aForm['iType'] = $aData[$aForm['iPageParent']]['iType'];
      }
    }

    if( empty( $aForm['sTemplate'] ) || $aForm['sTemplate'] == $GLOBALS['config']['default_pages_template'] )
      unset( $aForm['sTemplate'] );

    if( empty( $aForm['sTheme'] ) || $aForm['sTheme'] == $GLOBALS['config']['default_theme'] )
      unset( $aForm['sTheme'] );

    if( isset( $aForm['iPosition'] ) && !is_numeric( $aForm['iPosition'] ) )
      $aForm['iPosition'] = 0;

    if( !isset( $aForm['iStatus'] ) )
      $aForm['iStatus'] = 0;

    if( isset( $_SESSION['iAdminId'] ) && $_SESSION['iAdminId'] > 0 && isset( $this->aPages[$aForm['iPage']] ) && isset( $this->aPages[$aForm['iPage']]['iAdmin'] ) && $this->aPages[$aForm['iPage']]['iAdmin'] != $_SESSION['iAdminId'] ){
      $aForm['iAdmin'] = $this->aPages[$aForm['iPage']]['iAdmin'];
    }

    $aForm = changeMassTxt( $aForm, '', Array( 'sDescriptionShort', 'Nds' ), Array( 'sDescriptionFull', 'Nds' ), Array( 'sMetaDescription', 'Nds' ) );

    if( isset( $aForm['iBannerDel'] ) ){
      unlink( DIR_FILES.$aForm['sBanner'] );
      unset( $aForm['sBanner'] );
    }

    if( !empty( $_FILES['sBannerFile']['name'] ) && $oFFS->checkCorrectFile( $_FILES['sBannerFile']['name'], 'gif|jpg|png|jpeg|swf|bmp|tiff' ) == true ){
      $aForm['sBanner'] = $oFFS->uploadFile( $_FILES['sBannerFile'], DIR_FILES );
    }

    if( isset( $this->aPages[$aForm['iPage']] ) && $aForm['iStatus'] == 0 && $aForm['iStatus'] != $this->aPages[$aForm['iPage']]['iStatus'] && isset( $this->aPagesChildrens[$aForm['iPage']] ) ){
      $this->mData = null;
      $this->throwSubpagesIdAdmin( $aForm['iPage'] );
      foreach( $this->mData as $iPage => $bValue ){
        $this->aPages[$iPage]['iStatus'] = 0;
      } // end foreach
    }

    // deleting keys from array $aForm that not exists in $aPagesFields in database/_fields.php
    $this->aPages[$aForm['iPage']] = $aForm;

    if( isset( $aForm['aFilesDescription'] ) )
      $oFile->saveFiles( $aForm, 1, $aForm['iPage'] );
    if( isset( $_FILES['aNewFiles'] ) )
      $oFile->addFilesUploaded( $aForm, $aForm['iPage'], 1, 'iPage' );
    if( isset( $aForm['aDirFiles'] ) )
      $oFile->addFilesFromServer( $aForm, $aForm['iPage'], 1, 'iPage' );    

    $oFFS->saveData( DB_PAGES, $this->createArray( ) );

    $this->generateCache( );
    return $aForm['iPage'];
  } // end function savePage 

  /**
  * Save pages position and status
  * @return void
  * @param array  $aForm
  */
  public function savePages( $aForm ){
    if( isset( $aForm['aPositions'] ) && is_array( $aForm['aPositions'] ) ){
      foreach( $this->aPages as $iPage => $aData ){
        if( isset( $aForm['aPositions'][$iPage] ) && !isset( $aPagesChanged[$iPage] ) ){
          $aForm['aPositions'][$iPage] = trim( $aForm['aPositions'][$iPage] );
          if( is_numeric( $aForm['aPositions'][$iPage] ) && $aForm['aPositions'][$iPage] != $aData['iPosition'] ){
            $this->aPages[$iPage]['iPosition'] = $aForm['aPositions'][$iPage];
            $bChanged = true;
          }
          
          $iStatus = isset( $aForm['aStatus'][$iPage] ) ? 1 : 0;
          
          if( !isset( $aChangedStatus[$iPage] ) && $iStatus != $this->aPages[$iPage]['iStatus'] ){
            $this->aPages[$iPage]['iStatus'] = $iStatus;
            $bChanged = true;

            if( $iStatus == 0 && isset( $this->aPagesChildrens[$iPage] ) ){
              $this->mData = null;
              $this->throwSubpagesIdAdmin( $iPage );
              foreach( $this->mData as $iPage => $bValue ){
                $this->aPages[$iPage]['iStatus'] = 0;
                $aChangedStatus[$iPage] = true;
              } // end foreach
            }
          }
        }
      } // end foreach

      if( isset( $bChanged ) ){
        $oFFS = FlatFilesSerialize::getInstance( );
        $oFFS->saveData( DB_PAGES, $this->createArray( ) );
        $this->generateCache( );
      }
    }
  } // end function savePages


  /**
  * Function creates array to save to file
  * @return array
  */
  protected function createArray( ){
    if( isset( $this->aPages ) ){
      // Sorting array before it will save to file 
      foreach( $this->aPages as $iKey => $aValue ){
        $aSort[$iKey][0] = (int) $aValue['iPosition'];
        $aSort[$iKey][1] = $aValue['sName'];
        $aSort[$iKey][2] = $aValue['iPage'];
      } // end foreach

      if( isset( $aSort ) ){
        sort( $aSort );
        
        foreach( $aSort as $iKey => $aValue ){
          $aSave[] = compareArrays( $this->aFields, $this->aPages[$aValue[2]] );
        } // end foreach

        return $aSave;
      }
    }
  } // end function createArray

  /**
  * List last added pages
  * @return string
  * @param string $sFile
  */
  public function listLastPages( $sFile ){
    if( isset( $this->aPages ) ){
      $oTpl = TplParser::getInstance( );

      $iMax = 5;
      $aPages = $this->sortPages( array_keys( $this->aPages ) );
      $iCount = count( $aPages );
      if( $iCount > $iMax )
        $iCount = $iMax;
      
      $content = null;

      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $this->aPages[$aPages[$i]];
        $aData['sLink'] = '?p=pages-form&amp;iPage='.$aData['iPage'];
        $aData['iId'] = $aData['iPage'];
        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'EVENTS', 'LIST' );
      } // end for
      
      $oTpl->setIf( 'PAGES' );
      return $oTpl->tSubBlock( $sFile, 'EVENTS', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'EVENTS', 'LIST', 'foot' );
    }
  } // end function listLastPages

};
?>