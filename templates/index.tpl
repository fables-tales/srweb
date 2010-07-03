<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{getFromContent get="title"} | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="{getFromContent get='keywords'}" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}style.css" />
	<base href="{$root_uri}content/" />

</head>

<body>

<div id="pageWrapper">

	<div id="header">
		<a href=""><img src="https://www.studentrobotics.org/sites/all/themes/robogrid/logo.png" alt="Student Robotics Logo" /></a>

		<form action="" method="get">
			<input type="text" name="q" />
			<input type="submit" />
		</form>

		<ul>
			<li><a href="">Home</a></li>
			<li><a href="">IDE</a></li>
			<li><a href="">Schools</a></li>
			<li><a href="">Sponsors</a></li>
			<li><a href="">Get Involved</a></li>
			<li><a href="">About Us</a></li>
		</ul>
	</div>


	<div id="content">

		{getFromContent get="content"}

	</div>

	<div id="original">
		Original: <a href="{$root_uri}content/{$page}">{$page}</a>
	</div>


	<div id="footer">
		<span class="rss">RSS</span>
		<span class="copyright">&copy; Student Robotics</span>
	</div>

</div>

</body>

</html>

