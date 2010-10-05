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
			<img src="{$root_uri}images/content/srobo_website_robot.png" alt="Image d'un Robot" />
	
			<h1>Bienvenue à Student Robotics</h1>
	
			<p>Student Robotics organise un concours de robotique excitant entre les équipes de 
			lycéens, et les évènements principaux se déroulent à l'Université de Southampton. 
			Gérée par une équipe d'étudiants de l'Université de Southampton, les équipes de lycéens
			doivent concevoir, construire et tester un robot qui est entièrement autonome, et prêt 
			à concurrencer avec les autres équipes.</p>
		</div>

		<div id="latestNews">

			<h2><a href='{$root_uri}news/newsrwebsite'>Qui aurait cru, un nouveau site web pour SR!</a></h2>
			<p>Bonjour, et bienvenue au nouveau site web de Student Robotics. Nous sommes en train de traduire ce site d'Anglais en Français, donc veuillez nous excuser si vous trouvez que quelques pages sont en Anglais...
			<a href="{$root_uri}news/newsrwebsite">En Savoir Plus...</a></p>

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
					<h3><a href="{$root_uri}about/gettinginvolved">Envie de participer?</a></h3>
					<p>
						Student Robotics est toujours à la recherche de plus de gens à participer, et pas juste les
						lycéens. Que vous soyez un étudiant universitaire ou que vous soyez une entreprise qui
						envisagerait de parrainer avec nous - si vous voulez participer, vous seriez plus que bienvenu.
						<a href="{$root_uri}about/contactus">Veuillez contactez-nous!</a>.
					</p>
				</div>

				<div class="box">
					<h3><a href="{$root_uri}schools/kit/">Le Kit</a></h3>
					<p>
						<a href="{$root_uri}schools/kit/"><img src="{$root_uri}images/template/kit_motor_board.jpg" alt="Prototype de la carte Moteur" title="Prototype de la carte Moteur" /></a>
						Student Robotics conçoit et construit un kit électronique facilement programmé,
						conçu spécifiquement pour la construction des robots. Les équipes reçoivent ce kit
						à l'événement «Kickstart», et ils ont à peu près 7 mois pour construire un robot qui
						peut gagner le concours.
					</p>
				</div>

				<div class="box clearboth">
					<h3><a href="{$root_uri}ide">IDE</a></h3>
					<p>
						Notre <abbr title="Integrated Development Environment, ou en français: «Environnement de développement intégré»">IDE</abbr>
						en ligne est utilisé par toutes les équipes participantes, pour écrire les programmes
						pour leurs robots.
						Vous devez vous incrivez pour l'utiliser.
					</p>

				</div>

				<div class="box">
					<h3><a href="{$root_uri}sponsors/">Nos Sponsors</a></h3>
					<p>
						Student Robotics serait impossible sans l'aide de nos sponsors.
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

