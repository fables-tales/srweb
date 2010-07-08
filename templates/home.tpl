<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Welcome to Student Robotics | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="student, robotics, robot, competition, southampton" />
	<meta description="Student Robotics is an exciting competition between sixth form schools and colleges in the Southampton area to build fully autonomous robots. " />
	<link rel="stylesheet" type="text/css" href="{$root_uri}style.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.php" />
	<base href="{$root_uri}" />

</head>

<body>

<div id="pageWrapper">

	<div id="header">
		<a href="{$root_uri}"><img src="{$root_uri}images/template/website_logo.png" alt="Student Robotics Logo" /></a>

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

		<div id="topBanner">
			<img src="{$root_uri}images/content/srobo_website_robot.png" alt="Image of Robot" />
	
			<h1>Welcome to Student Robotics</h1>
	
			<p>Student Robotics is an exciting competition between sixth form schools 
			and colleges in the Southampton area to build fully autonomous robots. Led 
			by a group of students from the University of Southampton, the teams in the 
			competition will have to design, build and test their robots ready to 
			compete against other local teams.</p>
		</div>

		<div id="latestNews">

			{latestRSS}

		</div>

		<div id="expMenuAndBoxWrapper">

			<div id="expandedMenu">

				<h3>Take a Look Around</h3>

				{makemenu menu=$side_menu}

			</div>

			<div id="boxWrapper">

				<div class="box">
					<h3>The IDE</h3>
					<p>
						<img src="{$root_uri}images/template/sr_round_flat.png" alt="" />

						The Student Robotics web&ndash;based <acronym title="Integrated Development Environment">IDE</acronym>
						is used by all of the schools &amp; colleges taking part to write programs for their robots.
						You will need to be registered to use it.
					</p>
				</div>

				<div class="box">
					<h3>The Kit</h3>
					<p>
						<img src="{$root_uri}images/template/kit_motor_board.jpg" alt="motor board prototpye" title="motor board prototype" />
						Student Robotics design and build a range of easily&ndash;programmable boards
						designed specifically for building robots. The teams receive the kit at Kickstart
						and have about 7 months to build a competition&ndash;winning robot.
					</p>
				</div>

				<div class="box clearboth">
					<h3>Want to Get Involved?</h3>
					<p>
						Student Robotics is always looking for more people to get involved, and not just schools.
						Whether you're a University student or a company considering sponsoring the competition,
						you are more than welcome to get involved.
					</p>

				</div>

				<div class="box">
					<h3>Our Sponsors</h3>
					<p>
						<img src="" alt="" />

						Student Robotics really couldn't happen if we didn't have our sponsors.
					</p>

				</div>

			</div>

		</div>

		<p></p>

	</div>


	<div id="footer">
		<span class="rss"><a href="{$root_uri}feed.php"><img src="{$root_uri}images/template/feed.png" alt="RSS" title="SR RSS Latest News Feed" /></a></span>
		<span class="copyright">&copy; Student Robotics</span>
	</div>

</div>

</body>

</html>

