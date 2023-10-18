<!-- BEGIN PAGES -->
<div id="menu$aData[iType]">
  <!-- IF:START TYPE --><div class="type">$aData[sMenuType]</div><!-- IF:END TYPE -->
  <ul>
  <!-- START LIST -->
    <li class="l$aData[sStyle]<!-- IF:START SELECTED --> selected<!-- IF:END SELECTED -->">
      <a href="$aData[sLinkName]">$aData[sName]</a>
      $aData[sSubContent]
    </li>
  <!-- END LIST -->
  </ul>
</div>
<!-- END PAGES -->

<!-- 
HEAD_SUB and FOOT_SUB it is only header and footer of subpgages list
Subpages content are listing from block PAGES from LIST sub-block 
-->

<!-- BEGIN HEAD_SUB -->
  <ul class="sub$aData[iDepth]">
<!-- END HEAD_SUB -->
<!-- BEGIN FOOT_SUB -->
  </ul>
<!-- END FOOT_SUB -->
