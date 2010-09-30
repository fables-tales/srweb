<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="student, robotics, robot, competition, southampton" />
	<meta name="description" content="Student Robotics is an exciting competition between sixth form schools and colleges in the Southampton area to build fully autonomous robots. " />
	<meta name="google-site-verification" content="GizX0DcCqEeGihd9CyYaqM1bVXUB-lhB9rhm53UdRC8" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/main.css" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/home.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.php" />
	<link rel="shortcut icon" href="{$root_uri}images/template/favicon.ico" />
	<base href="{$base_uri}" />

	{literal}

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-831291-4']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>

	<!-- Piwik -->
	<script type="text/javascript">
	  var pkBaseURL = (("https:" == document.location.protocol) ? "https://www.studentrobotics.org/piwik/" : "http://www.studentrobotics.org/piwik/");
	  document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
	</script><script type="text/javascript">
	  try {
	  var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
	  piwikTracker.trackPageView();
	  piwikTracker.enableLinkTracking();
	  } catch( err ) {}
	</script><noscript><p><img src="http://www.studentrobotics.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
	<!-- End Piwik Tag -->

	{/literal}


</head>

<body>

<div id="pageWrapper">

	{include file="header-fr.tpl"}

	<div class="content">

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

			<h2><a href='{$root_uri}news/sr2011_comp_starts_soon'>Hold onto your hats, here comes SR 2011</a></h2>
			<p>Kickstart, the introductory event that starts the annual Student Robotics competition, is almost upon us.
			So, if you want to take part, make sure you've registered.
			<a href="{$root_uri}news/sr2011_comp_starts_soon">Read More...</a></p>

		</div>

		<div id="expMenuAndBoxWrapper">

			<div id="expandedMenu">

				<h3>Portail du Site</h3>

				<ul>
					<li><a href='{$root_uri}schools'>Lycées et Collèges</a>

						<ul>
							<li><a href='{$root_uri}schools/competition'>Concours</a></li>
							<li><a href='{$root_uri}schools/joining'>S'inscrire</a></li>
							<li><a href='{$root_uri}schools/kit'>Kit</a></li>
						</ul>
					</li>
					<li><a href='{$root_uri}docs'>Documents</a></li>
					<li><a href='{$root_uri}sponsors'>Sponsors</a></li>
					<li><a href='{$root_uri}about'>À Propos</a>
						<ul>
							<li><a href='{$root_uri}about/team'>L'équipe</a></li>
							<li><a href='{$root_uri}about/media'>Médias</a></li>
							<li><a href='{$root_uri}about/mission'>Énoncé de mission</a></li>
							<li><a href='{$root_uri}about/publicdocs'>Documents Publics</a></li>
							<li><a href='{$root_uri}about/contactus'>Contactez-Nous</a></li>
						</ul>
					</li>
				</ul>


			</div>

			<div id="boxWrapper">

				<div class="box">
					<h3><a href="{$root_uri}ide">The IDE</a></h3>
					<p>
						<a href="{$root_uri}ide"><img src="{$root_uri}images/template/sr_round_flat.png" alt="SR logo" title="SR logo" /></a>

						The Student Robotics web&ndash;based <abbr title="Integrated Development Environment">IDE</abbr>
						is used by all of the schools &amp; colleges taking part to write programs for their robots.
						You will need to be registered to use it.
					</p>
				</div>

				<div class="box">
					<h3><a href="{$root_uri}schools/kit/">The Kit</a></h3>
					<p>
						<a href="{$root_uri}schools/kit/"><img src="{$root_uri}images/template/kit_motor_board.jpg" alt="motor board prototpye" title="Motor Board Prototype" /></a>
						Student Robotics design and build a range of easily&ndash;programmable boards
						designed specifically for building robots. The teams receive the kit at Kickstart
						and have about 7 months to build a competition&ndash;winning robot.
					</p>
				</div>

				<div class="box clearboth">
					<h3><a href="{$root_uri}about/gettinginvolved">Want to Get Involved?</a></h3>
					<p>
						Student Robotics is always looking for more people to get involved, and not just schools.
						Whether you're a University student or a company considering sponsoring the competition,
						you are more than welcome to get involved.
					</p>

				</div>

				<div class="box">
					<h3><a href="{$root_uri}sponsors/">Our Sponsors</a></h3>
					<p>
						Student Robotics really couldn't happen if we didn't have our sponsors.
					</p>

				</div>

			</div>

		</div>

		<p></p>

	</div>


	{include file="footer-fr.tpl"}

</div>

</body>

</html>

