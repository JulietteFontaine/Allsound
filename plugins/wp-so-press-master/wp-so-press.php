<?php
/*
Plugin Name: WP SO PRESS
Description: Fonction diverses pour la gestion du site.
Version: 1.0
Author: Aina Randrianarijaona & Gilles FRANCOIS
Author URI: https://sopress.net
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}

require_once(dirname(__FILE__) . '/php/config/settings.php');

foreach (glob(dirname(__FILE__) . '/php/includes/*.php') as $file) {
	if (file_exists($file)) {
		require_once $file;
	}
}

foreach (glob(dirname(__FILE__) . '/php/actions/*.php') as $file) {
	if (file_exists($file)) {
		require_once $file;
	}
}

function include_player()
{
	if (is_single()) {
		$cat = get_the_category();
		$catSlug = $cat[0]->slug;
		if ($catSlug == 'podcast') {
			wp_enqueue_style('singlePodcast', ALLSOUND_THEME_URL . 'dist/css/single-podcast.css');
		} else if ($catSlug == 'nos-productions') {
			wp_enqueue_style('singleNosProd', ALLSOUND_THEME_URL . 'dist/css/single-productions.css');
		}

		wp_register_script('amplitude', 'https://cdn.jsdelivr.net/npm/amplitudejs@5.3/dist/amplitude.js');
		wp_register_script('amplitude-visualization', 'https://521dimensions.com/img/open-source/amplitudejs/visualizations/michaelbromley.js');
		wp_enqueue_script('amplitude');
		wp_enqueue_script('amplitude-visualization');
		wp_enqueue_style('singleStyle', ALLSOUND_THEME_URL . 'dist/css/single.css');
	}
}
add_action('wp_enqueue_scripts', 'include_player');
