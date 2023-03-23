<?php
function getPodcastRssInfos($rssUrl)
{
	
	$podcastInfo = array();

	$acastPrivacy = " &#10;&nbsp;<br /><hr><br /><hr><p style='color:grey; font-size:0.75em;'> Voir <a style='color:grey;' target='_blank' rel='noopener noreferrer' href='https://acast.com/privacy'>Acast.com/privacy</a> pour les informations sur la vie privée et l'opt-out.";
	$acastPrivacyDesc = "<br /><hr><p style='color:grey; font-size:0.75em;'> Voir <a style='color:grey;' target='_blank' rel='noopener noreferrer' href='https://acast.com/privacy'>Acast.com/privacy</a> pour les informations sur la vie privée et l'opt-out.";

	if ($rss = simplexml_load_file($rssUrl, "SimpleXMLElement", LIBXML_NOCDATA)) {

		$rss = $rss->channel;

		$preDescription = array(
			"image" => (string) $rss->image->url,
			"description" => preg_replace("/<p[^>]*>(?:\s|<br>)*<\/p>/", '', str_replace($acastPrivacyDesc, "", $rss->description))
		);

		$cpt = count($rss->item) - 1;

		foreach ($rss->item as $episode) {

			$podcastInfo[$cpt]['description'] = str_replace($acastPrivacy, "", $episode->description);
			$podcastInfo[$cpt]['titre'] = (string) $episode->title[0];
			$podcastInfo[$cpt]['mp3'] = (string) $episode->enclosure->attributes()['url'];
			$podcastInfo[$cpt]['date'] = substr($episode->pubDate, 0, -12);
			$podcastInfo[$cpt]['duration'] = (string) $episode->children('itunes', true)->duration[0];

			$cpt--;
		};
		$podcastInfo = array_reverse($podcastInfo);

		$groupes_episodes = array_chunk($podcastInfo, 5);

		// foreach ($groupes_episodes as $groupe) {
		// echo "<pre>";
		// var_dump("TABLEAU", $groupes_episodes);
		// echo "</pre>";
		// }
		
		return array($preDescription, $groupes_episodes, $podcastInfo);
	}
};

function get_post_by_category($cat)
{
	$ret = [];

	$the_query = new WP_Query(array(
		'category_name' => $cat,
		'posts_per_page' => -1
	));

	// The Loop
	if ($the_query->have_posts()) {
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$id = get_the_ID();

			$ret[$id]['titre'] = get_the_title();
			$ret[$id]['vignette'] = get_the_post_thumbnail_url();
			$ret[$id]['url'] = get_permalink();
		}
	}
	wp_reset_postdata();

	return $ret;
}

function getRssJson($url)
{
	$simpleXml = simplexml_load_file($url, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($simpleXml);
	return $json;
}

function asset($url)
{
	return get_template_directory_uri() . $url;
}

function getSongMetadata($p)
{

}
