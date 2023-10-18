<?php
final class FilesAdmin extends Files
{

  private $aDirs;
  private $aFilesAll = null;
  private static $oInstance = null;

  public static function getInstance( ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new FilesAdmin( );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
  */
  private function __construct( ){
    $this->generateCache( );
    $this->generateThumbDirs( );
  } // end function __construct

  /**
  * List all files in selected page
  * @return string
  * @param string $sFile
  * @param int $iLink
  * @param int $iLinkType
  */
  public function listAllLinkFiles( $sFile, $iLink, $iLinkType ){
    if( isset( $this->aFilesImages[$iLinkType] ) && isset( $this->aLinkFilesImages[$iLinkType][$iLink] ) ){
      $aSizes = $GLOBALS['config']['pages_images_sizes'];
      $aTypes = $GLOBALS['aPhotoTypes'];
      $oFFS = FlatFilesSerialize::getInstance( );
      $oTpl = TplParser::getInstance( );
      $content = null;
      $iCount = count( $this->aLinkFilesImages[$iLinkType][$iLink] );
      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $this->aFilesImages[$iLinkType][$this->aLinkFilesImages[$iLinkType][$iLink][$i]];
        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;

        if( !empty( $aData['iPhoto'] ) && $aData['iPhoto'] == 1 ){
          $aData['sSizes1Select'] = throwSelectFromArray( $aSizes, $aData['iSize1'] );
          $aData['sSizes2Select'] = throwSelectFromArray( $aSizes, $aData['iSize2'] );
          $aData['sPhotoTypesSelect'] = throwSelectFromArray( $aTypes, $aData['iType'] );
          $oTpl->setIf( 'IMAGE' );
        }
        else
          $oTpl->setIf( 'FILE' );

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'ADDED_FILES', 'LIST' );
      } // end for

      if( isset( $content ) ){
        $oTpl->setVariables( 'aData', $aData );
        return $oTpl->tSubBlock( $sFile, 'ADDED_FILES', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'ADDED_FILES', 'LIST', 'foot' );
      }
    }
  } // end function listAllLinkFiles

  /**
  * Delete all selected files for deletion
  * @return void
  * @param array  $aFiles
  * @param int    $iLinkType
  */
  public function deleteSelectedFiles( $aFiles, $iLinkType ){
    if( isset( $aFiles ) && is_array( $aFiles ) ){
      $sFileName = $this->throwDbNames( $iLinkType );

      foreach( $aFiles as $iFile => $iValue ){
        if( isset( $this->aFilesImages[$iLinkType][$iFile] ) ){
          $aDeleted[$iFile] = $this->aFilesImages[$iLinkType][$iFile];
          unset( $this->aFilesImages[$iLinkType][$iFile] );
        }
      }
      if( isset( $aDeleted ) ){
        $oFFS = FlatFilesSerialize::getInstance( );
        $oFFS->saveData( $this->throwDbNames( $iLinkType ), $this->createArray( $iLinkType ) );
        foreach( $aDeleted as $iFile => $aData ){
          $this->deleteFilesFromDirs( $aData['sFileName'], $aData['iPhoto'], $iLinkType, $iFile );
        } // end foreach
      }
    }
  } // end function deleteSelectedFiles

  /**
  * Delete all files in selected link
  * @return void
  * @param array  $aData
  * @param int    $iLinkType
  * @param string $sIndex
  * @param bool   $bWithoutFiles
  */
  public function deleteFiles( $aData, $iLinkType, $sIndex, $bWithoutFiles = null ){
    if( isset( $this->aFilesImages[$iLinkType] ) ){

      foreach( $this->aFilesImages[$iLinkType] as $iFile => $aFile ){
        if( isset( $aData[$aFile[$sIndex]] ) ){
          if( !isset( $bWithoutFiles ) )
            $aDeleted[$iFile] = $aFile;
          unset( $this->aFilesImages[$iLinkType][$iFile] );
          $bDeleted = true;
        }
      } // end foreach

      if( isset( $bDeleted ) ){
        $oFFS = FlatFilesSerialize::getInstance( );
        $oFFS->saveData( $this->throwDbNames( $iLinkType ), $this->createArray( $iLinkType ) );
        if( isset( $aDeleted ) ){
          foreach( $aDeleted as $iFile => $aData ){
            $this->deleteFilesFromDirs( $aData['sFileName'], $aData['iPhoto'], $iLinkType, $iFile );
          } // end foreach
        }
      }
    }
  } // end function deleteFiles

  /**
  * Return files list from directory
  * @return string
  * @param string $sFile
  * @param int    $iLink
  * @param in     $iLinkType
  */
  public function listFilesInDir( $sFile, $iLink = null, $iLinkType = null ){
    $oTpl = TplParser::getInstance( );
    $oFFS = FlatFilesSerialize::getInstance( );
    $content = null;

    foreach( new DirectoryIterator( DIR_FILES ) as $oFileDir ) {
      if( $oFileDir->isFile( ) && $oFileDir->getFilename( ) != '.htaccess' ){
        $aFiles[] = $oFileDir->getFilename( );
      }
    } // end foreach

    if( isset( $aFiles ) ){
      sort( $aFiles );
      $iCount = count( $aFiles );
      for( $i = 0; $i < $iCount; $i++ ){
        $aData['sFileName'] = $aFiles[$i];
        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['iFile'] = $i;
        $aData['iPhoto'] = ( $oFFS->checkCorrectFile( $aData['sFileName'], 'gif|jpg|png|jpeg' ) == true ) ? 1 : 0;

        $oTpl->setVariables( 'aData', $aData );

        if( $aData['iPhoto'] == 1 )
          $oTpl->setIf( 'IMAGE' );
        else
          $oTpl->setIf( 'FILE' );

        $content .= $oTpl->tSubBlock( $sFile, 'FILES_IN_DIR', 'LIST' );
      } // end for

      return $oTpl->tSubBlock( $sFile, 'FILES_IN_DIR', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'FILES_IN_DIR', 'LIST', 'foot' );
    }
  } // end function listFilesInDir

  /**
  * Delete files from directories
  * @return void
  * @param string $sFileName
  * @param int    $iImage
  * @param int    $iLinkType
  * @param int    $iFile
  */
  private function deleteFilesFromDirs( $sFileName, $iImage, $iLinkType, $iFile ){
    if( !isset( $this->aFilesAll ) ){
      $oFFS = FlatFilesSerialize::getInstance( );
      foreach( new DirectoryIterator( DIR_LANG ) as $oFileDir ) {
        if( $oFileDir->isFile( ) && strstr( $oFileDir->getFileName( ), '.php' ) ){
          $aLangs[] = substr( $oFileDir->getFileName( ), 0, 2 );
        }
      } // end foreach

      foreach( $aLangs as $sLang ){
        $aDatabaseFiles = $this->throwDbNames( );
        foreach( $aDatabaseFiles as $iKey => $sFile ){
          if( !isset( $this->aFilesImages[$iKey] ) )
            $this->aFilesImages[$iKey] = null;
          $aFiles = ( $sLang == LANGUAGE ) ? $this->aFilesImages[$iKey] : $oFFS->getData( str_replace( LANGUAGE.'_', $sLang.'_', $sFile ) );
          if( is_array( $aFiles ) && count( $aFiles ) > 0 ){
            foreach( $aFiles as $iKey => $aData ){
              if( !isset( $this->aFilesAll[$aData['sFileName']] ) )
                $this->aFilesAll[$aData['sFileName']] = 0;
              $this->aFilesAll[$aData['sFileName']]++;      
            } // end foreach
          }
        } // end foreach
      } // end foreach
    }

    if( isset( $this->aFilesAll[$sFileName] ) && $this->aFilesAll[$sFileName] > 0 )
      return null;

    if( $iImage == 1 && isset( $this->aDirs ) ){
      foreach( $this->aDirs as $mDir => $bValue ){
        if( is_file( DIR_FILES.$mDir.'/'.$sFileName ) )
          unlink ( DIR_FILES.$mDir.'/'.$sFileName );
      }
    }
    if( is_file( DIR_FILES.$sFileName ) )
      unlink ( DIR_FILES.$sFileName );
  } // end function deleteFilesFromDirs

  /**
  * Return thumbs dir names
  * @return array
  */
  private function generateThumbDirs( ){
    foreach( new DirectoryIterator( DIR_FILES ) as $oFileDir ) {
      if( is_numeric( $oFileDir->getFilename( ) ) && $oFileDir->isDir( ) ){
        $this->aDirs[$oFileDir->getFilename( )] = true;
      }
    } // end foreach
  } // end function generateThumbDirs

  /**
  * Save files description and sizes
  * @return void
  * @param array $aForm
  * @param int $iLinkType
  * @param int $iLink
  */
  public function saveFiles( $aForm, $iLinkType = 1, $iLink = null ){
    if( isset( $aForm['aFilesDescription'] ) && is_array( $aForm['aFilesDescription'] ) ){
      if( isset( $aForm['aFilesDelete'] ) )
        $this->deleteSelectedFiles( $aForm['aFilesDelete'], $iLinkType );

      if( isset( $iLink ) && is_numeric( $iLink ) ){
        if( isset( $this->aLinkFilesImages[$iLinkType][$iLink] ) ){
          $iCount = count( $this->aLinkFilesImages[$iLinkType][$iLink] );
          for( $i = 0; $i < $iCount; $i++ ){
            $aFiles[$this->aLinkFilesImages[$iLinkType][$iLink][$i]] = $this->aFilesImages[$iLinkType][$this->aLinkFilesImages[$iLinkType][$iLink][$i]];
          } // end for
        }
      }
      else{
        if( isset( $this->aFilesImages[$iLinkType] ) ){
          $aFiles = $this->aFilesImages[$iLinkType];
        }
      }

      if( isset( $aFiles ) ){
        foreach( $aFiles as $iFile => $aData ){
          if( !isset( $aForm['aFilesDelete'][$iFile] ) && isset( $aForm['aFilesDescription'][$iFile] ) ){
            $aForm['aFilesDescription'][$aData['iFile']] = changeTxt( trim( $aForm['aFilesDescription'][$aData['iFile']] ), '' );
            $bSizes = null;

            if( isset( $aForm['aFilesDescription'][$aData['iFile']] ) && $aForm['aFilesDescription'][$aData['iFile']] != $aData['sDescription'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['sDescription'] = $aForm['aFilesDescription'][$aData['iFile']];
              $bChanged = true;
            }

            if( isset( $aForm['aFilesSizes1'][$aData['iFile']] ) && $aForm['aFilesSizes1'][$aData['iFile']] != $aData['iSize1'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['iSize1'] = $aForm['aFilesSizes1'][$aData['iFile']];
              $bChanged = true;
              $bSizes = true;
            }

            if( isset( $aForm['aFilesSizes2'][$aData['iFile']] ) && $aForm['aFilesSizes2'][$aData['iFile']] != $aData['iSize2'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['iSize2'] = $aForm['aFilesSizes2'][$aData['iFile']];
              $bChanged = true;
              $bSizes = true;
            }

            if( $aForm['aFilesPositions'][$aData['iFile']] != $aData['iPosition'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['iPosition'] = $aForm['aFilesPositions'][$aData['iFile']];
              $bChanged = true;
            }
            
            if( isset( $aForm['aFilesTypes'][$aData['iFile']] ) && $aForm['aFilesTypes'][$aData['iFile']] != $aData['iType'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['iType'] = $aForm['aFilesTypes'][$aData['iFile']];
              $bChanged = true;
            }

            if( isset( $bSizes ) ){
              $this->generateThumbs( $this->aFilesImages[$iLinkType][$aData['iFile']]['sFileName'], $this->aFilesImages[$iLinkType][$aData['iFile']]['iSize1'], $this->aFilesImages[$iLinkType][$aData['iFile']]['iSize2'] );
            }
          }
        } // end foreach
      }

      if( isset( $bChanged ) ){
        $oFFS = FlatFilesSerialize::getInstance( );
        $oFFS->saveData( $this->throwDbNames( $iLinkType ), $this->createArray( $iLinkType ) );
      }
    }
  } // end function saveFiles

  /**
  * Add uploaded files
  * @param array  $aForm
  * @param int    $iLink
  * @param int    $iLinkType
  * @param string $sLinkName
  */
  public function addFilesUploaded( $aForm, $iLink, $iLinkType, $sLinkName ){
    if( isset( $_FILES['aNewFiles']['name'] ) ){
      $iCount = count( $_FILES['aNewFiles']['name'] );
      $i2 = 0;
      $oFFS = FlatFilesSerialize::getInstance( );

      $this->mData = null;

      for( $i = 0; $i < $iCount; $i++ ){
        if( !empty( $_FILES['aNewFiles']['name'][$i] ) && !preg_match( '/(\.phtml|\.php|\.php3|\.php4|\.php5|\.php6|\.asp|\.aspx|\.py|\.pyc|\.jse|\.js|\.as|\.sh|\.ksh|\.zsh|\.bat|\.cmd|\.shs|\.vb|\.vbe|\.vbs|\.wsc|\.wsf|\.wsh|\.url|\.exe|\.msi|\.msp|\.htaccess|\.reg|\.scr|\.ocx)/i', $_FILES['aNewFiles']['name'][$i] ) ){
          $this->mData[$i2]['sFileName'] = $oFFS->uploadFile( Array( 'tmp_name' => $_FILES['aNewFiles']['tmp_name'][$i], 'name' => ( $GLOBALS['config']['change_files_names'] === true && isset( $_POST['sName'] ) ) ? change2Url( $_POST['sName'] ).'.'.$oFFS->throwExtOfFile( $_FILES['aNewFiles']['name'][$i] ) : $_FILES['aNewFiles']['name'][$i] ), DIR_FILES );
          $this->mData[$i2]['iSize1'] = $aForm['aNewFilesSizes1'][$i];
          $this->mData[$i2]['iSize2'] = $aForm['aNewFilesSizes2'][$i];
          $this->mData[$i2]['iType'] = is_numeric( $aForm['aNewFilesTypes'][$i] ) ? $aForm['aNewFilesTypes'][$i] : 1;
          $this->mData[$i2]['iPosition'] = is_numeric( $aForm['aNewFilesPositions'][$i] ) ? $aForm['aNewFilesPositions'][$i] : 0;
          $this->mData[$i2]['sDescription'] = changeTxt( $aForm['aNewFilesDescriptions'][$i], '' );
          $this->mData[$i2][$sLinkName] = $iLink;

          $i2++;
        }
      } // end for

      if( isset( $this->mData ) )
        $this->addFiles( $iLinkType );
    }
  } // end function addFilesUploaded

  /**
  * Add files from server
  * @param array  $aForm
  * @param int    $iLink
  * @param int    $iLinkType
  * @param string $sLinkName
  */
  public function addFilesFromServer( $aForm, $iLink, $iLinkType, $sLinkName ){
    if( isset( $aForm['aDirFiles'] ) ){
      $i = 0;
      $oFFS = FlatFilesSerialize::getInstance( );

      $this->mData = null;

      foreach( $aForm['aDirFiles'] as $iKey => $sFile ){
        if( is_file( DIR_FILES.$sFile ) ){
          $this->mData[$i]['sFileName'] = ( $GLOBALS['config']['change_files_names'] === true && isset( $_POST['sName'] ) ) ? change2Url( $_POST['sName'] ).'.'.$oFFS->throwExtOfFile( $sFile ) : $sFile;
          if( defined( 'COPY_THE_SAME_FILES' ) && COPY_THE_SAME_FILES === true )
            $this->mData[$i]['sFileName'] = $oFFS->checkIsFile( $this->mData[$i]['sFileName'], DIR_FILES );
          if( !is_file( DIR_FILES.$this->mData[$i]['sFileName'] ) )
            copy( DIR_FILES.$sFile, DIR_FILES.$this->mData[$i]['sFileName'] );
          $this->mData[$i]['iSize1'] = $aForm['aDirFilesSizes1'][$iKey];
          $this->mData[$i]['iSize2'] = $aForm['aDirFilesSizes2'][$iKey];
          $this->mData[$i]['iType'] = is_numeric( $aForm['aDirFilesTypes'][$iKey] ) ? $aForm['aDirFilesTypes'][$iKey] : 1;
          $this->mData[$i]['iPosition'] = is_numeric( $aForm['aDirFilesPositions'][$iKey] ) ? $aForm['aDirFilesPositions'][$iKey] : 0;
          $this->mData[$i]['sDescription'] = changeTxt( $aForm['aDirFilesDescriptions'][$iKey], '' );
          $this->mData[$i][$sLinkName] = $iLink;
          $i++;
        }
      }

      if( isset( $this->mData ) )
        $this->addFiles( $iLinkType );
    }
  } // end function addFilesFromServer

  /**
  * Add files
  * @return void
  * @param int    $iLinkType
  */
  private function addFiles( $iLinkType ){
    if( isset( $this->mData ) && is_array( $this->mData ) ){
      $oFFS = FlatFilesSerialize::getInstance( );
      $sFile = $this->throwDbNames( $iLinkType );
      $iLastId = $oFFS->throwLastId( $sFile, 'iFile' );
      $iCount = count( $this->mData );
      $i = 0;

      foreach( $this->mData as $iKey => $aData ){
        $aData['iPhoto'] = ( $oFFS->checkCorrectFile( $aData['sFileName'], 'gif|jpg|png|jpeg' ) == true ) ? 1 : 0;

        if( $aData['iPhoto'] == 1 ){
          $this->generateThumbs( $aData['sFileName'], $aData['iSize1'], $aData['iSize2'] );
          if( !is_numeric( $aData['iSize1'] ) )
            $aData['iSize1'] = 0;
          if( !is_numeric( $aData['iSize2'] ) )
            $aData['iSize2'] = 0;
        }
        else{
          $aData['iType'] = '';
          $aData['iSize1'] = '';
          $aData['iSize2'] = '';
        }
        
        $aData['iFile'] = ++$iLastId;

        $this->aFilesImages[$iLinkType][$aData['iFile']] = $aData;
        $i++;
      } // end foreach

      $oFFS = FlatFilesSerialize::getInstance( );
      $oFFS->saveData( $sFile, $this->createArray( $iLinkType ) );

      $this->mData = null;
    }
  } // end function addFiles 

  /**
  * Generate photo thumbnails
  * @return void
  * @param string $sFileName
  * @param int    $iSize1
  * @param int    $iSize2
  */
  private function generateThumbs( $sFileName, $iSize1, $iSize2 ){
    $oImage = ImageJobs::getInstance( );

    $aImgSize = $oImage->throwImgSize( DIR_FILES.$sFileName );
    if( defined( 'MAX_DIMENSION_OF_IMAGE' ) && ( $aImgSize['width'] > MAX_DIMENSION_OF_IMAGE || $aImgSize ['height'] > MAX_DIMENSION_OF_IMAGE ) ){
      if( $aImgSize['width'] < $oImage->iMaxForThumbSize && $aImgSize['height'] < $oImage->iMaxForThumbSize ){
        $oImage->setThumbSize( MAX_DIMENSION_OF_IMAGE );
        $oImage->createThumb( DIR_FILES.$sFileName, DIR_FILES, $sFileName );
      }
    }
    
    if( isset( $GLOBALS['config']['pages_images_sizes'][$iSize1] ) )
      $iSize1 = $GLOBALS['config']['pages_images_sizes'][$iSize1];
    else
      $iSize1 = $GLOBALS['config']['pages_images_sizes'][0];

    if( isset( $GLOBALS['config']['pages_images_sizes'][$iSize2] ) )
      $iSize2 = $GLOBALS['config']['pages_images_sizes'][$iSize2];
    else
      $iSize2 = $GLOBALS['config']['pages_images_sizes'][0];

    $sThumbsDir1 = DIR_FILES.$iSize1.'/';
    $sThumbsDir2 = DIR_FILES.$iSize2.'/';

    if( !is_dir( $sThumbsDir1 ) ){
      mkdir( $sThumbsDir1 );
      chmod( $sThumbsDir1, 0777 );
    }
    if( !is_dir( $sThumbsDir2 ) ){
      mkdir( $sThumbsDir2 );
      chmod( $sThumbsDir2, 0777 );
    }

    if( !is_file( $sThumbsDir1.$sFileName ) )
      $oImage->createCustomThumb( DIR_FILES.$sFileName, $sThumbsDir1, $iSize1, $sFileName, true );
    if( !is_file( $sThumbsDir2.$sFileName ) )
      $oImage->createCustomThumb( DIR_FILES.$sFileName, $sThumbsDir2, $iSize2, $sFileName, true );
  } // end function generateThumbs

  /**
  * List all files from db
  * @return string
  * @param string $sFile
  * @param int    $iLinkType
  */
  public function listAllFiles( $sFile, $iLinkType = 1 ){
    $aSizes = $GLOBALS['config']['pages_images_sizes'];
    $aTypes = $GLOBALS['aPhotoTypes'];
    $oTpl = TplParser::getInstance( );
    $oPage = PagesAdmin::getInstance( );
    $content = null;

    if( isset( $GLOBALS['sPhrase'] ) && !empty( $GLOBALS['sPhrase'] ) ){
      $aFiles = $this->generateFilesSearchListArray( $iLinkType, $GLOBALS['sPhrase'] );
    }
    else{
      if( isset( $this->aFilesImages[$iLinkType] ) ){
        foreach( $this->aFilesImages[$iLinkType] as $iFile => $aData ){
          $aFiles[$iFile] = $iLinkType;
        } // end foreach
      }
    }

    if( isset( $aFiles ) ){
      $sSort = ( isset( $_GET['sSort'] ) && !empty( $_GET['sSort'] ) ) ? $_GET['sSort'] : 'name';
      $aFiles = $this->sortFiles( $aFiles, $sSort );

      $iCount = count( $aFiles );
      $aKeys = countPageNumber( $iCount, ( isset( $_GET['iPage'] ) ? $_GET['iPage'] : null ) );
      
      for( $i = $aKeys['iStart']; $i < $aKeys['iEnd']; $i++ ){
        $aData = $this->aFilesImages[$iLinkType][$aFiles[$i]];
        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;

        $aData['sPhotoTypesSelect'] = throwSelectFromArray( $aTypes, $aData['iType'] );
        $aData['sLink'] = '<a href="?p=pages-form&amp;iPage='.$aData['iPage'].'" target="_blank">'.$oPage->aPages[$aData['iPage']]['sName'].'</a>';

        if( !empty( $aData['iPhoto'] ) && $aData['iPhoto'] == 1 )
          $oTpl->setIf( 'IMAGE' );

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'ALL_FILES', 'LIST' );
      } // end for
    }

    if( isset( $content ) ){
      $aData['sPages'] = countPagesClassic( $iCount, $GLOBALS['config']['admin_list'], $aKeys['iPageNumber'], changeUri( $_SERVER['REQUEST_URI'] ) );
      $oTpl->setVariables( 'aData', $aData );
      return $oTpl->tSubBlock( $sFile, 'ALL_FILES', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'ALL_FILES', 'LIST', 'foot' );
    }
  } // end function listAllFiles

  /**
  * Save all files data
  * @return void
  * @param array  $aForm
  * @param int    $iLinkType
  */
  public function saveAllFiles( $aForm, $iLinkType = 1 ){
    if( isset( $aForm['aFilesDescription'] ) && is_array( $aForm['aFilesDescription'] ) ){

      if( isset( $aForm['aFilesDelete'] ) )
        $this->deleteSelectedFiles( $aForm['aFilesDelete'], $iLinkType );
      if( isset( $this->aFilesImages[$iLinkType] ) ){
        foreach( $this->aFilesImages[$iLinkType] as $aData ){
          if( !isset( $aForm['aFilesDelete'][$aData['iFile']] ) ){
            $aForm['aFilesDescription'][$aData['iFile']] = changeTxt( trim( $aForm['aFilesDescription'][$aData['iFile']] ), '' );
            
            if( isset( $aForm['aFilesDescription'][$aData['iFile']] ) && $aForm['aFilesDescription'][$aData['iFile']] != $aData['sDescription'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['sDescription'] = $aForm['aFilesDescription'][$aData['iFile']];
              $bChanged = true;
            }

            if( $aForm['aFilesPositions'][$aData['iFile']] != $aData['iPosition'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['iPosition'] = $aForm['aFilesPositions'][$aData['iFile']];
              $bChanged = true;
            }
            
            if( isset( $aForm['aFilesTypes'][$aData['iFile']] ) && $aForm['aFilesTypes'][$aData['iFile']] != $aData['iType'] ){
              $this->aFilesImages[$iLinkType][$aData['iFile']]['iType'] = $aForm['aFilesTypes'][$aData['iFile']];
              $bChanged = true;
            } 
          }
        } // end foreach

        if( isset( $bChanged ) ){
          $oFFS = FlatFilesSerialize::getInstance( );
          $oFFS->saveData( $this->throwDbNames( $iLinkType ), $this->createArray( $iLinkType ) );
          $this->generateCache( );
        }
      }
    }
  } // end function saveAllFiles

  /**
  * Create form to pages and products form
  * @return string
  * @param string $sFile
  * @param int    $iCount
  */
  public function createForm( $sFile, $iCount = 3 ){
    $oTpl = TplParser::getInstance( );
    $content = null;
    for( $i = 0; $i < $iCount; $i++ ){
      $iStyle = ( $i % 2 ) ? 0: 1;
      $oTpl->setVariables( 'aData', Array( 'i' => $i, 'iStyle' => $iStyle ) );
      $content .= $oTpl->tSubBlock( $sFile, 'FILES_FORM', 'LIST' );
    } // end for
    
    return $oTpl->tSubBlock( $sFile, 'FILES_FORM', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'FILES_FORM', 'LIST', 'foot' );
  } // end function createForm

  /**
  * Function creates array to save to file
  * @return array
  * @param int  $iLinkType
  */
  protected function createArray( $iLinkType ){
    if( isset( $this->aFilesImages[$iLinkType] ) ){
      // Sorting array before it will save to file 
      foreach( $this->aFilesImages[$iLinkType] as $iKey => $aValue ){
        $aSort[$iKey][0] = (int) $aValue['iPosition'];
        $aSort[$iKey][1] = $aValue['sFileName'];
        $aSort[$iKey][2] = $aValue['iFile'];
      } // end foreach
      if( isset( $aSort ) ){
        sort( $aSort );

        foreach( $aSort as $iKey => $aValue ){
          $aSave[] = compareArrays( $this->aFields, $this->aFilesImages[$iLinkType][$aValue[2]] );
        } // end foreach

        return $aSave;
      }
    }
  } // end function createArray

  /**
  * Sort files 
  * @return array
  * @param array  $aFiles
  * @param string $sSort
  */
  protected function sortFiles( $aFiles, $sSort = null ){
    $sFunctionSort = ( $sSort == 'id' ) ? 'rsort' : 'sort';
    $i = 0;
    $oPage = PagesAdmin::getInstance( );

    foreach( $aFiles as $iFile => $iLinkType ){
      if( $sSort == 'id' )
        $aSort[$i][0] = $iFile;
      elseif( $sSort == 'added_to' )
        $aSort[$i][0] = $oPage->aPages[$this->aFilesImages[$iLinkType][$iFile]['iPage']]['sName'];
      else
        $aSort[$i][0] = $this->aFilesImages[$iLinkType][$iFile]['sFileName'];
      $aSort[$i][1] = $iFile;
      $i++;
    }

    $sFunctionSort( $aSort );
    foreach( $aSort as $iKey => $aValue ){
      $aReturn[] = $aValue[1];
    } // end forearch

    return $aReturn;
  } // end function sortFiles

  /**
  * List last added pages
  * @return string
  * @param string $sFile
  */
  public function listLastFiles( $sFile, $iLinkType = 1 ){

    if( isset( $this->aFilesImages[$iLinkType] ) ){
      foreach( $this->aFilesImages[$iLinkType] as $iFile => $aData ){
        $aFiles[] = $iFile;
      } // end foreach
    }

    if( isset( $aFiles ) ){
      rsort( $aFiles );

      $oTpl = TplParser::getInstance( );
      $oPage = PagesAdmin::getInstance( );
      $iMax = 5;
      $iCount = count( $aFiles );
      if( $iCount > $iMax )
        $iCount = $iMax;

      $content = null;

      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $this->aFilesImages[$iLinkType][$aFiles[$i]];
        
        $oTpl->setVariables( 'aData', Array( 'sData' => null, 'sLink' => DIR_FILES.$aData['sFileName'].'" target="_blank', 'sName' => $aData['sFileName'], 'iId' => $aData['iFile'], 'sData' => '<a href="?p=pages-form&amp;iPage='.$aData['iPage'].'">'.$oPage->aPages[$aData['iPage']]['sName'].'</a>' ) );
        $oTpl->setIf( 'DATA' );

        $content .= $oTpl->tSubBlock( $sFile, 'EVENTS', 'LIST' );
      } // end for
      
      $oTpl->setIf( 'FILES' );
      return $oTpl->tSubBlock( $sFile, 'EVENTS', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'EVENTS', 'LIST', 'foot' );
    }
  } // end function listLastFiles

  /**
  * Return variable with search results
  * @return array
  * @param string $sPhrase
  */
  protected function generateFilesSearchListArray( $iLinkType, $sPhrase ){
    if( isset( $this->aFilesImages[$iLinkType] ) ){
      $aExp = explode( ' ', $sPhrase );
      $iCount = count( $aExp );
      for( $i = 0; $i < $iCount; $i++ ){
        $aExp[$i] = trim( $aExp[$i] );
        if( !empty( $aExp[$i] ) )
          $aWords[] = $aExp[$i];
      } // end for

      $iCount = count( $aWords );

      foreach( $this->aFilesImages[$iLinkType] as $iFile => $aData ){
        $iFound = 0;
        $sSearchData = implode( ' ', $aData );

        for( $i = 0; $i < $iCount; $i++ ){
          if( stristr( $sSearchData, $aWords[$i] ) )
            $iFound++;
        } // end for

        if( $iFound == $iCount ){
          $aFiles[$iFile] = $iLinkType;
        }
      }

      if( isset( $aFiles ) )
        return $aFiles;
    }
  } // end function generatePagesSearchListArray

};
?>