<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{$page}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

</head>

<body>

	{if file_exists("$content_dir/$page.$type")}

		{if $type == "md"}
			{include file="$content_dir/$page.$type" assign=md_input}
			{$md_input|markdown}
		{else}
	
			{include file="$content_dir/$page.$type"}

		{/if}

	{/if}

	{makemenu menu=$menu}

</body>

</html>

