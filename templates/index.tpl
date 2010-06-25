<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{$page}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="{$root_uri}style.css" />


</head>

<body>

<div id="pageWrapper">

	<div id="header">
		header
	</div>


	<div id="navigation">
		{makemenu menu=$menu}
	</div>


	<div id="content">

		{if file_exists("$content_dir/$page.$type")}

			{if $type == "md"}
				{include file="$content_dir/$page.$type" assign=md_input}
				{$md_input|markdown}
			{else}
	
				{include file="$content_dir/$page.$type"}

			{/if}

		{/if}

	</div>

	<div id="original">
		Original: <a href="{$root_uri}content/{"$page.$type"}">{"$page.$type"}</a>
	</div>


	<div id="footer">
		footer
	</div>

</div>

</body>

</html>

