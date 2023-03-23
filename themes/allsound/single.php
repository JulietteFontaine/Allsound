<?php
get_header();
get_template_part('parts/logo');
get_template_part('parts/menu');

$post = $wp_query->post;

// INIT PARAMS && ASSETS
$titre = get_the_title();

$slug = get_post_field('post_name', get_post());

// Si il y a un flux RSS
if ($rssUrl = get_field('flux_rss')) {
	if (file_exists('../allsound/cron/' . $slug . '.xml')) {
		$rssUrl = '../allsound/cron/' . $slug . '.xml';
	}

	set_query_var('lien_chargé',  $rssUrl );

	list($preDescription, $episodes) = getPodcastRssInfos($rssUrl);
	$description = strip_tags($preDescription['description']);
	$tableaux  = array();
	foreach ($episodes as $tab_episodes) {
		$tableaux[] = $tab_episodes;
	}
	$image = $preDescription['image'];

	$json = getRssJson($rssUrl);
	set_query_var('tabs', $tableaux);
	set_query_var('json', $json);

} else {
	// Si fichier MP3
	$mp3 = have_rows('fichier_custom');
	$cptCustom = count(get_field('fichier_custom'));
	$description = get_the_content();
}

?>
<div class="single-main-container">

	<div class="top-container">
		<?php if (isset($json)) : ?>
			<img data-amplitude-song-info="cover_art_url" class="album-art" />
			<div class="amplitude-visualization" id="large-visualization">
			</div>
		<?php else : ?>
			<img src="<?= get_the_post_thumbnail_url() ?>" class="thumbnail-prod" alt="" max-width="500px">
		<?php endif; ?>

		<div class="single-info-container">
			<h1><?= $titre ?></h1>
			<p><?= $description ?></p>
		</div>
	</div>

	<?php
	if ($rssUrl != false) {
		get_template_part('parts/post-podcast');
	} else {
		get_template_part('parts/post-productions');
	}
	?>
</div>

<?php get_footer(); ?>

<script>
		const lien_chargé = <?= get_query_var('lien_chargé')?>;
</script>