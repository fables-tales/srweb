<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>News | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="student, robotics, news" />
	<meta name="description" content="All the latest news from Student Robotics" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/main.css" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/news.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.php" />
	<base href="{$base_uri}" />

</head>

<body>

<div id="pageWrapper">

	{include file="header.tpl"}


	<div id="content">
		
		<h1>Student Robotics News</h1>

		{newsPage}
		<p></p>

	</div>

	{include file="footer.tpl"}

</div>

</body>

</html>
