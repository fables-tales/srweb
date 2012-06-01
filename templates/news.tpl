<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>News | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="student, robotics, news" />
	<meta name="description" content="All the latest news from Student Robotics" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/main.css" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/news.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.php" />
	<link rel="shortcut icon" href="{$root_uri}images/template/favicon.ico" />

	{include file=tracking.tpl}
</head>

<body>
{include file=tracking-image.tpl}
<div id="pageWrapper">

	{include file="header-en.tpl"}


	<div class="content">

		<h1>Student Robotics News</h1>

		{newsPage}
		<p></p>

	</div>

	{include file="footer-en.tpl"}

</div>

</body>

</html>
