<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{getFromContent get="title"} | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="{$root_uri}style.css" />
	<base href='{"$root_uri/content/"}' />

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

		{getFromContent get="content"}

	</div>

	<div id="original">
		Original: <a href="{$root_uri}content/{$page}">{$page}</a>
	</div>


	<div id="footer">
		footer
	</div>

</div>

</body>

</html>

