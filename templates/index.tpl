<html>
<head>
<title>{$page}</title>
</head>
<body>

{if file_exists("$content_dir/$page.$type")}
	
	{include file="$content_dir/$page.$type"}

{/if}

{makemenu menu=$menu}

</body>
</html>

