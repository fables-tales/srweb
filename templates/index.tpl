<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{getFromContent get="title"} | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="{getFromContent get='keywords'}" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}style.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.rss" />
	<base href="{$root_uri}" />

</head>

<body>

<div id="pageWrapper">

	<div id="header">
		<a href=""><img src="{$root_uri}images/template/website_logo.png" alt="Student Robotics Logo" /></a>

		<form action="" method="get">
			<input type="text" name="q" />
			<input type="submit" value="" />
		</form>

		<ul>
			<li><a href="{$root_uri}home">Home</a></li>
			<li><a href="{$root_uri}ide">IDE</a></li>
			<li><a href="{$root_uri}schools/">Schools</a></li>
			<li><a href="{$root_uri}sponsors/">Sponsors</a></li>
			<li><a href="{$root_uri}about/gettinginvolved">Get Involved</a></li>
			<li><a href="{$root_uri}about">About Us</a></li>
		</ul>
	</div>


	<div id="content">

		{getFromContent get="content"}
		<p></p>

	</div>

	<div id="original">
		Original: <a href="{$root_uri}content/{$page}">{$page}</a>
	</div>


	<div id="footer">
		<span class="rss"><a href="{$root_uri}feed.rss"><img src="{$root_uri}images/template/feed.png" alt="RSS" title="SR RSS Latest News Feed" /></a></span>
		<span class="copyright">&copy; Student Robotics</span>
	</div>

</div>

</body>

</html>

