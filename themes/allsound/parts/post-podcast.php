<?php
$svgVolume = asset('/dist/img/volume.svg');
$svgNext = asset('/dist/img/chevron-right.svg');
$svgPrevious = asset('/dist/img/chevron-left.svg');
$acastPrivacyDesc = "<br /><hr><p style='color:grey; font-size:0.75em;'> Voir <a style='color:grey;' target='_blank' rel='noopener noreferrer' href='https://acast.com/privacy'>Acast.com/privacy</a> pour les informations sur la vie privée et l'opt-out.";

?>

<!-- Playlist des episodes -->

<div id="amplitude-right">

	<div class="colonnes-info">
		<div>
			<p class="titre-colonne-info">Episodes</p>
		</div>
		<div>
			<p class="titre-colonne-info"></p>
		</div>
		<div>
			<p class="titre-colonne-info">Date</p>
		</div>
		<div>
			<p class="titre-colonne-info">Durée</p>
		</div>
	</div>

	<?php
	$tableaux = get_query_var('tabs');
	for ($i = 0; $i < count($tableaux); $i++) : ?>
		<div class="displayed-episodes" id="displayed-episodes<?= $i ?>">
			<?php

			foreach ($tableaux[$i]  as $k => $episode) :
				$episode['description'] = preg_replace("/<p[^>]*>(?:\s|<br>)*<\/p>/", '', str_replace($acastPrivacyDesc, "", $episode['description']));
			?>
				<!-- DEBUT FOR EACH -->

				<div class="song amplitude-song-container">
					<div>
						<div class="song-meta-data amplitude-play-pause" data-amplitude-song-index="<?= $k ?>"></div>
						<img id="img-playlist" data-amplitude-song-info="cover_art_url" class="img-playlist-vignette" />
					</div>

					<!-- MODAL Description -->
					<div id="afficherModal<?= $k ?>" class="modal">
						<span class="song-desc-lien"><?= $episode['description'] ?></span>
					</div>

					<div class="info-text">
						<span class="song-title"><?= $episode['titre'] ?></span>
						<span class="song-description-list"><?= $episode['description'] ?></span>

						<p><a class="btn-modal" href="#afficherModal<?= $k ?>" rel="modal:open">Description de l'épisode</a></p>

					</div>
					<div class="info-date">
						<span class="song-date"><?= date_i18n('j F Y', strtotime($episode['date'])) ?></span>
					</div>

					<div class="info-duree">
						<span class="duration">
							<span><?= $episode['duration'] ?></span>
						</span>
					</div>

				</div>

				<!-- FIN FOR EACH -->
			<?php endforeach; ?>
		</div>
	<?php endfor; ?>

	<div class="btnContainer">

		<!-- PREVIOUS  -->
		<button id="previous-btn" class="previous-btn">
			<img class="previous-icon" src="<?= $svgPrevious ?>">
		</button>
		<?php $cpt = count($tableaux); ?>

		<!-- PAGES -->
		<?php for ($i = 0; $i < $cpt; $i++) :
			if ($i == 0) {
				$idButton = 'page-active';
			} else {
				$idButton = '';
			}
		?>

			<button id="<?= $idButton ?>" class="page-btn" data-state="<?= $i ?>">
				<a href="#"><?= $i + 1 ?></a>
			</button>
		<?php endfor; ?>

		<!-- NEXT  -->
		<button id="next-btn" class="next-btn" data-state="0">
			<img class="next-icon" src="<?= $svgNext ?>">
		</button>
	</div>

</div>

<!-- player -->
<div class="player-container">

	<div id="blue-playlist-container">

		<!-- Amplitude Player -->
		<div id="amplitude-player">

			<div id="amplitude-left">

				<!-- image player -->
				<div id="meta-container">
					<img data-amplitude-song-info="cover_art_url" class="img-playlist-vignette player" />
				</div>

				<!-- Volume container player -->
				<div id="volume-container">
					<span class="amplitude-mute">
						<img class="volume-img" src="<?= $svgVolume ?>">
						<span>
							<div class="volume-controls">
								<input type="range" class="amplitude-volume-slider" />
							</div>
				</div>

				<!-- info player -->
				<div id="info-player">
					<span data-amplitude-song-info="name" class="song-name-player"></span>
					<div>
						<span data-amplitude-song-info="description" class="song-desc-player"></span>
					</div>
				</div>
				<!-- Boutton play/pause -->
				<div id="player-play-pause" class="song-meta-data amplitude-play-pause"></div>

				<!-- Barre de progression -->
				<div id="control-container">

					<div id="progress-container">

						<div class="amplitude-wave-form"></div>

						<input type="range" class="amplitude-song-slider" />
						<progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
						<progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
						<div id="time-container">

							<span class="duration">
								<span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span>
							</span>

							<span class="remaining">
								<span class="amplitude-time-remaining"></span>
							</span>

						</div>
					</div>
				</div>

			</div>
		</div> <!-- FIN AMPLITUDE PLAYER -->
	</div> <!-- FIN PLAYLIST CONTAINER -->
</div> <!-- FIN PLAYER CONTAINER  -->

<script>
	<?php if (isset($json)) : ?>
		const json = <?= $json ?>;
		const imagePodcast = json.channel.image.url;
		const episodes = json.channel.item;
		let nbr_tab = <?= json_encode(count($tableaux)) ?>;
		<?php endif; ?>
</script>