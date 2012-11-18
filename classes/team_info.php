<?php

require_once('classes/simplepie/simplepie.inc');
require_once('classes/team_info_college_lut.php');

class LiveStatusItem extends stdClass
{
	public $content;

	public function __construct($live)
	{
		$this->content = $live;
	}

	public function __toString()
	{
		return $this->content;
	}
}

/*
 * Return array of team IDs. If $file_path is true then the array is
 * indexed by team ID with the value set to the path of the status file.
 */
function get_team_list($file_path = False) {
	$teams = glob(TEAM_STATUS_DIR."/*-status.json");
	// gaurd against there being no teams.
	if (empty($teams))
		return array();
	$team_ids = array_map(function($t) {
	                      return preg_replace('/.*?([A-Z0-9]+)-status\.json/', '$1', $t);
	                      },
	                      $teams);
	if ($file_path)
		return array_combine($team_ids, $teams);
	else
		return $team_ids;
}

function get_team_info($team_id = False) {
	if ($team_id === False) {
		$teams = array();
		$team_files = get_team_list(true);
		foreach ($team_files as $team_id => $fn) {
			$teams[] = _build_team_info($fn, $team_id);
		}
		return $teams;
	} else {
		$fn = TEAM_STATUS_DIR."/".$team_id."-status.json";
		if (file_exists($fn)) {
			$team = _build_team_info($fn, $team_id);
			if (!empty($team->feed))
				_fill_team_latest_post($team);
			return $team;
		} else {
			return False;
		}
	}
}

/**
 * Builds information for a team from a json file and its Id.
 */
function _build_team_info($path, $team_id) {
	$json_text = file_get_contents($path);
	$team_raw = json_decode($json_text);
	$team = new stdClass();
	if (empty($team_raw->image->live)) {
		$team->thumb = null;
		$team->image = null;
	} else {
		$team->thumb = new LiveStatusItem(_get_team_thumb($team_id));
		$team->image = new LiveStatusItem(_get_team_image($team_id));
		$age = intval(floor(time() - filemtime(ROOT_DIR.'/'.TEAM_STATUS_IMG.'/'.$team_id.'.png')) / 86400);
		if ($age == 0)
			$team->image->date = "today";
		elseif ($age == 1)
			$team->image->date = "yesterday";
		else
			$team->image->date = sprintf("%d days ago", $age);
	}
	$team->team_name = empty($team_raw->name->live) ? "Team $team_id" : new LiveStatusItem(strip_tags($team_raw->name->live));
	foreach (array('url', 'feed', 'description') as $item) {
		$team->$item = empty($team_raw->$item->live) ? null : new LiveStatusItem(strip_tags($team_raw->$item->live));
	}
	$team->team_id = $team_id;

	global $team_info_college_lut;
	$team->college = array_key_exists($team_id, $team_info_college_lut) ? $team_info_college_lut[$team_id] : null;

	return $team;
}

/**
 * Returns the path to the thumbnail sized (160*120) image for the team.
 */
function _get_team_thumb($team_id) {
	return TEAM_STATUS_IMG."/".$team_id."_thumb.png";
}

/**
 * Returns the path to the full sized (480*320) image for the team.
 */
function _get_team_image($team_id) {
	return TEAM_STATUS_IMG."/".$team_id.".png";
}

function _fill_team_latest_post(&$team) {
	$url = $team->feed;

	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->set_cache_location(CACHE_DIR);
	$feed->init();

	if ($feed->get_item_quantity() > 0) {
		$item = $feed->get_item(0);
		$team->feed->latest->title = $item->get_title();
		$team->feed->latest->url = $item->get_link();
		$team->feed->latest->description = $item->get_description();
		$team->feed->latest->date->day = $item->get_date("d");
		$team->feed->latest->date->month = $item->get_date("M");
		$team->feed->latest->date->year = $item->get_date("Y");
	}
}

?>
