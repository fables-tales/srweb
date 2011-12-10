<?php

require_once('classes/simplepie/simplepie.inc');

/*
 * Return array of team IDs. If $file_path is true then the array is
 * indexed by team ID with the value set to the path of the status file.
 */
function get_team_list($file_path = False) {
	$teams = glob(TEAM_STATUS_DIR."/*-status.json");
	$team_ids = array_map(function($t) {
	                      return preg_replace('/.*([A-Z]{3}[0-9]*)-status\.json/', '$1', $t);
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
			$json_text = file_get_contents($fn);
			$teams[$team_id] = json_decode($json_text);
			$teams[$team_id]->team_id = $team_id;
		}
		return $teams;
	} else {
		$fn = TEAM_STATUS_DIR."/".$team_id."-status.json";
		if (file_exists($fn)) {
			$json_text = file_get_contents($fn);
			$team = json_decode($json_text);
			$team->team_id = $team_id;
			$team->image->url = TEAM_STATUS_IMG."/".$team->team_id.".png";
			if ($team->feed->live != "")
				_fill_team_latest_post($team);
			return $team;
		} else {
			return False;
		}
	}
}

function _fill_team_latest_post(&$team) {
	$url = $team->feed->live;

	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->set_cache_location(CACHE_DIR);
	$feed->init();

	if ($feed->get_item_quantity() > 0) {
		$item = $feed->get_item(0);
		$team->feed->latest->title = $item->get_title();
		$team->feed->latest->url = $item->get_link();
		$team->feed->latest->description = $item->get_description();
	}
}

?>
