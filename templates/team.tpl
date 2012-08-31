<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Team {$team->team_id} | Student Robotics</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="SR Student Robotics Team {$team->team_name} {$team->college_name}" />
	<meta name="description" content="Information about Student Robotics team '{$team->team_name}'" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/main.css" />
	<link rel="stylesheet" type="text/css" href="{$root_uri}css/content_extra.css" />
	<link rel="stylesheet" type="text/css" media="print" href="{$root_uri}css/print.css" />
	<link rel="alternate" type="application/rss+xml" title="SR RSS" href="{$root_uri}feed.php" />
	<link rel="shortcut icon" href="{$root_uri}images/template/favicon.ico" />

	{include file=tracking.tpl}
</head>

<body>
{include file=tracking-image.tpl}
<div id="pageWrapper">

	{include file=$header_file}


	<div id="{$page_id}" class="content team-page">
		<a class="link-top" href="{$root_uri}teams">&lArr; Back to all teams</a>

		<h1>{$team->team_id}: {$team->team_name}</h1>

		{if !empty($team->image) }
		<div id="team-img">
			<img alt="Photograph of the progress made by team {$team->team_name}" src="{$root_uri}{$team->image}" />
			<p>Last updated {$team->image->date}</p>
		</div>
		{/if}

		{if !empty($team->description) }
		<p>
		{$team->description}
		</p>
		{/if}

		<p id="team-name">
		{if !empty($team->url) }
		<a href="{$team->url}">
		{/if}
		Team {$team->team_id}
		{if !empty($team->url) }
		</a>
		{/if}
		</p>

		{if !empty($team->college) }
		<p id="college-name">
		from
		{if !empty($team->college.URL) }
		<a href="{$team->college.URL}" target="_blank">
		{/if}
		{$team->college.name}
		{if !empty($team->college.URL) }
		</a>
		{/if}
		</p>
		{/if}

		{if isset($team->feed->latest)}
		<h2>Latest Blog Post</h2>
		<div class="blog-post-date">
		<div class="day">{$team->feed->latest->date->day}</div>
		<div class="month">{$team->feed->latest->date->month}</div>
		<div class="year">{$team->feed->latest->date->year}</div>
		</div>
		<div class="blog-post-content">
		<h3><a href="{$team->feed->latest->url}">{$team->feed->latest->title}</a></h3>
		<p>
		{$team->feed->latest->description}
		</p>
		</div>
		{/if}

		<div class="clearboth"><a class="link-bottom-left" href="{$root_uri}teams">&lArr; Back to all teams</a></div>

	</div>
	<div id="original"></div>

	{include file=$footer_file}

</div>

</body>

</html>

