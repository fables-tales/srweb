<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{getFromContent get="title"} | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="{getFromContent get='keywords'}" />
	<meta name="description" content="{getFromContent get='description'}" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/main.css" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/docs.css" />
	<link rel="stylesheet" type="text/css" media="print" href="{$root_uri}css/print.css" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/docs_extra.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.php" />
	<link rel="shortcut icon" href="{$root_uri}images/template/favicon.ico" />

	{if $live_site}
	{literal}

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-831291-4']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>

	<!-- Piwik -->
	<script type="text/javascript">
	  var pkBaseURL = (("https:" == document.location.protocol) ? "https://www.studentrobotics.org/piwik/" : "http://www.studentrobotics.org/piwik/");
	  document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
	</script><script type="text/javascript">
	  try {
	  var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
	  piwikTracker.trackPageView();
	  piwikTracker.enableLinkTracking();
	  } catch( err ) {}
	</script>
	<!-- End Piwik Tag -->

	{/literal}
	{/if}


</head>

<body>
<!-- More Piwik stuff -->
{if $live_site}
<noscript><p><img src="http://www.studentrobotics.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
{/if}
<!-- End More Piwik Stuff -->
<div id="pageWrapper">

	{include file=$header_file}


	<div id="{$page_id}" class="content docs">

		<div id="docsNav">
			{makemenu menu=$docsNav}
		</div>

		<div id="content">
			<div id="print_warning">
				As you have printed this it is now out of date. Please visit<br /><strong>https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}</strong><br />for the latest documentation.
			</div>
			{getFromContent get="content"}
		</div>
		<p></p>

	</div>

	<div id="original">
		Original: <a href="{$root_uri}content/{$original}">{$original}</a>
	</div>


	{include file=$footer_file}

</div>

</body>

</html>

