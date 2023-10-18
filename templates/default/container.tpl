<!-- BEGIN HEAD -->
<?xml version="1.0" encoding="$config[charset]"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$config[language]">
<head>
  <title>$sTitle$config[title]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=$config[charset]" />
  <meta name="Language" content="$config[language]" />
  <meta name="Description" content="$sDescription" />
  <meta name="Keywords" content="$sKeywords" />
  <meta name="Generator" content="Quick.Cms" />

  <script type="text/javascript" src="$config[dir_core]common.js"></script>
  <script type="text/javascript" src="$config[dir_plugins]mlbox/mlbox.js"></script>
  <script type="text/javascript">
    <!--
    var cfBorderColor     = "#aeb7bb";
    var cfLangNoWord      = "$lang[cf_no_word]";
    var cfLangMail        = "$lang[cf_mail]";
    var cfWrongValue      = "$lang[cf_wrong_value]";
    var cfToSmallValue    = "$lang[cf_to_small_value]";
    var cfTxtToShort      = "$lang[cf_txt_to_short]";
    //-->
  </script>

  <style type="text/css">@import "$config[dir_skin]$config[style]";</style>
  $sBanner <!-- END HEAD --><!-- BEGIN BODY -->
</head>
<body>
<div class="skiplink"><a href="#content" accesskey="1">$lang['Skip_navigation']</a></div>

<div id="container">
  <div id="header">
    <div id="head1"><!-- first top menu starts here -->
      <div class="container">
        $sMenu1<!-- content of top menu -->
      </div>
    </div>
    <div id="head2"><!-- banner, logo and slogan starts here -->
      <div class="container">
        <div id="logo"><!-- logo and slogan -->
          <div id="title"><a href="$config[index]" tabindex="1">Quick<span>.</span><strong>Cms</strong></a></div>
          <div id="slogan">$config[slogan]</div>
        </div>
      </div>
    </div>
    <div id="head3"><!-- second top menu starts here -->
      <div class="container">
        $sMenu2<!-- content of top menu -->
      </div>
    </div>
  </div>
  <div id="body">
    <div class="container">
      <div id="column"><!-- left column with left menu -->
        $sMenu3<!-- content of left menu -->
      </div>
      <div id="content"><!-- right column with page details, images and files -->
        $content <!-- this variable loads page details with included files and subpages list -->
        <!-- END BODY --><!-- BEGIN FOOT -->
        <div id="options"><div class="print"><a href="javascript:window.print();">$lang['print']</a></div><div class="back"><a href="javascript:history.back();">&laquo; $lang['back']</a></div></div>
      </div>
    </div>
  </div>
  <div id="foot"><!-- footer starts here -->
    <div class="container">
      <div id="copy">$config[foot_info]</div><!-- copyrights here -->
      <!--
        LICENSE REQUIREMENTS - DONT DELETE/HIDE LINK "CMS by Quick.Cms" TO www.OpenSolution.org
      -->
      <div class="foot" id="powered"><a href="http://opensolution.org/">$sLangFooter</a></div><!-- dont delete or hide this line please -->
    </div>
  </div>
</div>
</body>
</html>
<!-- END FOOT -->