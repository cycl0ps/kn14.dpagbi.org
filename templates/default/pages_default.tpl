<!-- BEGIN CONTAINER -->
<div id="page"><!-- IF:START TXT_SIZE -->
  <div class="tS"><div><a href="javascript:txtSize( 0 )" class="tS0">A</a></div><div><a href="javascript:txtSize( 1 )" class="tS1">A</a></div><div><a href="javascript:txtSize( 2 )" class="tS2">A</a></div></div><!-- IF:END TXT_SIZE -->
  <h1>$aData[sName]</h1><!-- here load page name --><!-- IF:START NAVIPATH -->
  <h4>$aData[sPagesTree]</h4><!-- IF:END NAVIPATH -->
  $aImages[1]<!-- here is content from IMAGES_DEFAULT or other IMAGES_xx blocks -->
  $aImages[2]<!-- here is content from IMAGES_DEFAULT or other IMAGES_xx blocks -->
  <div class="content" id="pageDescription">$aData[sDescriptionFull]</div><!-- IF:START PAGES -->
  <div class="pages">$lang['Pages']: <ul>$aData[sPages]</ul></div><!-- IF:END PAGES -->
  $sFilesList<!-- here is content from FILES block  -->
  $sSubpagesList<!-- here is content from SUBPAGES_DEFAULT or other SUBPGAGES_xx blocks  -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN SUBPAGES_DEFAULT -->
  <ul class="subpagesList" id="subList$aData[iType]"><!-- START LIST -->
    <li class="l$aData[sStyle]"><!-- IF:START IMAGE -->
      <div class="photo">
        <a href="$aData[sLinkName]"><img src="$config[dir_files]$aDataImage[iSizeValue1]/$aDataImage[sFileName]" alt="$aDataImage[sDescription]" /></a>
      </div><!-- IF:END IMAGE -->
      <h2><a href="$aData[sLinkName]">$aData[sName]</a></h2><!-- IF:START DESCRIPTION -->
      <div class="description">$aData[sDescriptionShort]</div><!-- IF:END DESCRIPTION -->
    </li><!-- END LIST -->  
  </ul>
<!-- END SUBPAGES_DEFAULT -->

<!-- BEGIN FILES -->
  <ul id="filesList"><!-- START LIST -->
    <li class="l$aData[sStyle]">
      <img src="$config[dir_files]ext/$aData[sIcon].gif" alt="ico" /><a href="$config[dir_files]$aData[sFileName]">$aData[sFileName]</a><!-- IF:START DESCRIPTION -->, <em>$aData[sDescription]</em><!-- IF:END DESCRIPTION -->
    </li><!-- END LIST -->
  </ul>
<!-- END FILES -->

<!-- BEGIN IMAGES_DEFAULT -->
  <ul class="imagesList" id="imagesList$aData[iType]"><!-- START LIST -->
    <li>
      <a href="$config[dir_files]$aData[sFileName]" class="mlbox[pages]" title="$aData[sDescription]"><img src="$config[dir_files]$aData[iSizeValue2]/$aData[sFileName]" alt="$aData[sDescription]" /></a><!-- IF:START DESCRIPTION -->
      <div>$aData[sDescription]</div><!-- IF:END DESCRIPTION -->
    </li><!-- END LIST -->
  </ul>
<!-- END IMAGES_DEFAULT -->

<!-- BEGIN BANNER --><style type="text/css">
<!--
#head2 .container{background-image:url('$config[dir_files]$aData[sBanner]');}
@media print{
  #head2 .container{background:inherit;color:#000;}
}
-->
</style><!-- END BANNER -->