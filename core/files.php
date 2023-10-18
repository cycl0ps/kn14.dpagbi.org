<?php
class Files
{

  public $aImagesDefault;
  public $aFilesImages;
  protected $aLinkFilesImages;
  protected $aFiles;
  protected $aImages;
  protected $aFields;
  protected $aImagesTypes;
  protected $mData = null;
  private static $oInstance = null;

  public static function getInstance( ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new Files( );  
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
  * Return database name
  * @return mixed
  * @param int  $iDbType
  */
  protected function throwDbNames( $iDbType = null ){
    $aFiles[1] = DB_PAGES_FILES;

    if( isset( $iDbType ) )
      return isset( $aFiles[$iDbType] ) ? $aFiles[$iDbType] : null;
    else
      return $aFiles;
  } // end function throwDbNames

  /**
  * List all images by types
  * @return array
  * @param string $sFile
  * @param int    $iLink
  * @param int    $iLinkType
  */
  public function listImagesByTypes( $sFile, $iLink, $iLinkType = 1 ){
    if( isset( $this->aImagesTypes[$iLinkType][$iLink] ) ){
      $aReturn = Array( 1 => null, null, null, null );
      $oTpl = TplParser::getInstance( );
      foreach( $this->aImagesTypes[$iLinkType][$iLink] as $iType => $aImages ){
        if( $iType < 3 ){
          $sType = 'DEFAULT';
          $iCount = count( $aImages );
          for( $i = 0; $i < $iCount; $i++ ){
            if( isset( $this->aFilesImages[$iLinkType][$aImages[$i]] ) ){
              $aData = $this->aFilesImages[$iLinkType][$aImages[$i]];
              $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
              $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;
              $aData['iType'] = $iType;

              if( !empty( $aData['sDescription'] ) ){
                $oTpl->setIf( 'DESCRIPTION' );
              }

              $oTpl->setVariables( 'aData', $aData );
              $aReturn[$iType] .= $oTpl->tSubBlock( $sFile, 'IMAGES_'.$sType, 'LIST' );
            }
          } // end for
          if( isset( $aReturn[$iType] ) )
            $aReturn[$iType] = $oTpl->tSubBlock( $sFile, 'IMAGES_'.$sType, 'LIST', 'head' ).$aReturn[$iType].$oTpl->tSubBlock( $sFile, 'IMAGES_'.$sType, 'LIST', 'foot' );
        }
        else{
          // gallery
        }
      }
      if( isset( $aReturn ) )
        return $aReturn;
    }
  } // end function listImagesByTypes

  /**
  * List all files
  * @return array
  * @param string $sFile
  * @param int    $iLink
  * @param int    $iLinkType
  */
  public function listFiles( $sFile, $iLink, $iLinkType = 1 ){
    $content = null;
    if( isset( $this->aFiles[$iLinkType][$iLink] ) ){
      $oTpl = TplParser::getInstance( );
      $oFFS = FlatFilesSerialize::getInstance( );
      $iCount = count( $this->aFiles[$iLinkType][$iLink] );
      $aExt = throwIconsFromExt( );

      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $this->aFilesImages[$iLinkType][$this->aFiles[$iLinkType][$iLink][$i]];
        $aData['iStyle'] = ( $i % 2 ) ? 0: 1;
        $aData['sStyle'] = ( $i == ( $iCount - 1 ) ) ? 'L': $i + 1;

        if( !empty( $aData['sDescription'] ) ){
          $oTpl->setIf( 'DESCRIPTION' );
        }
        
        $aName = $oFFS->throwNameExtOfFile( $aData['sFileName'] );
        if( !isset( $aExt[$aName[1]] ) )
          $aExt[$aName[1]] = 'nn';
        $aData['sIcon'] = 'ico_'.$aExt[$aName[1]];

        $oTpl->setVariables( 'aData', $aData );
        $content .= $oTpl->tSubBlock( $sFile, 'FILES', 'LIST' );
      } // end for

      if( isset( $content ) ){
        $oTpl->setVariables( 'aData', $aData );
        return $oTpl->tSubBlock( $sFile, 'FILES', 'LIST', 'head' ).$content.$oTpl->tSubBlock( $sFile, 'FILES', 'LIST', 'foot' );
      }
    }
  } // end function listFiles

  /**
  * Return default image
  * @return string
  * @param int  $iLink
  * @param int  $iLinkType
  */
  protected function throwDefaultImage( $iLink, $iLinkType ){
    if( isset( $this->aImagesDefault[$iLinkType][$iLink] ) )
      return $this->aFilesImages[$iLinkType][$this->aImagesDefault[$iLinkType][$iLink]];
  } // end function throwDefaultImage

  /**
  * Generate cache variables
  * @return void
  */
  public function generateCache( ){
    global $config;

    $this->aFields = $GLOBALS['aFilesFields'];

    $oFFS = FlatFilesSerialize::getInstance( );
    $aFiles = $this->throwDbNames( );
    $iSize1 = 0;
    $iSize2 = 0;
    $sKey = 'iPage';

    foreach( $aFiles as $iKey => $sValue ){

      $this->aImages[$iKey] = null;
      $this->aFiles[$iKey] = null;
      $this->aImagesTypes[$iKey] = null;

      if( is_file( $sValue ) ){
        $aData = $oFFS->getData( $sValue );
        if( is_array( $aData ) && count( $aData ) > 0 ){
          foreach( $aData as $iKeyFile => $aValue ){
            $this->aFilesImages[$iKey][$aValue['iFile']] = $aValue;
            $this->aLinkFilesImages[$iKey][$aValue[$sKey]][] = $aValue['iFile'];

            if( !empty( $aValue['iPhoto'] ) && $aValue['iPhoto'] == 1 ){
              if( !isset( $this->aImagesDefault[$iKey][$aValue[$sKey]] ) )
                $this->aImagesDefault[$iKey][$aValue[$sKey]] = $aValue['iFile'];
              $this->aImages[$iKey][$aValue[$sKey]][] = $aValue['iFile'];

              if( !is_numeric( $this->aFilesImages[$iKey][$aValue['iFile']]['iSize1'] ) ){
                $this->aFilesImages[$iKey][$aValue['iFile']]['iSize1'] = $iSize1;
              }
              if( !is_numeric( $this->aFilesImages[$iKey][$aValue['iFile']]['iSize2'] ) )
                $this->aFilesImages[$iKey][$aValue['iFile']]['iSize2'] = $iSize2;

              $this->aFilesImages[$iKey][$aValue['iFile']]['iSizeValue1'] = $config['pages_images_sizes'][$this->aFilesImages[$iKey][$aValue['iFile']]['iSize1']];
              $this->aFilesImages[$iKey][$aValue['iFile']]['iSizeValue2'] = $config['pages_images_sizes'][$this->aFilesImages[$iKey][$aValue['iFile']]['iSize2']];

              $this->aImagesTypes[$iKey][$aValue[$sKey]][$aValue['iType']][] = $aValue['iFile'];
            }
            else{
              $this->aFiles[$iKey][$aValue[$sKey]][] = $aValue['iFile'];
            }          
          } // end foreach
        }
      }
    } // end foreach

  } // end function generateCache
};
?>