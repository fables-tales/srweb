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

	{literal}

	<!-- Syntax highlighting using JS -->
	<script type="text/javascript" src="https://yandex.st/highlightjs/6.1/highlight.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<link rel="stylesheet" href="https://yandex.st/highlightjs/6.1/styles/sunburst.min.css" /><!-- stylesheet for syntax highlighting -->

	<!-- Use jQuery to add a class 'python' to all <code> blocks -->
	<script type="text/javascript">
	  add_python_attr = function(){
	    $("pre code").addClass("python");
	  }
	  $(document).ready(add_python_attr);

	  <!-- Do highlighting -->
	  hljs.initHighlightingOnLoad();
	</script>

	{/literal}

	{include file=tracking.tpl}
</head>

<body>
{include file=tracking-image.tpl}
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

