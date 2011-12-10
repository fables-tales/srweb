<?php

require_once('classes/simplepie/simplepie.inc');

function get_team_info($team_id = False) {
	if ($team_id === False) {
		$teams = array();
		foreach (glob(TEAM_STATUS_DIR."/*-status.json") as $fn) {
			$team_id = preg_replace('/.*([A-Z]{3}[0-9]*)-status\.json/', '$1', $fn);
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
