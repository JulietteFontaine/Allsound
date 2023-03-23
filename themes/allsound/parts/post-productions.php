<?php
$titre = get_the_title();

$svgVolume = asset('/dist/img/volume.svg');
$svgNext = asset('/dist/img/chevron-right.svg');
$svgPrevious = asset('/dist/img/chevron-left.svg');
$cpt=0;
if (have_rows('fichier_custom')) : ?>
	<?php while (have_rows('fichier_custom')) : the_row(); ?>
		<?php if (get_row_layout() == 'production') :
			$mp3Id = get_sub_field('fichier_mp3');
			$mp3Url = wp_get_attachment_url($mp3Id);
			$image = get_sub_field('image');
			$tmp = get_post_meta($mp3Id, "_wp_attachment_metadata");
			$metadata[$cpt] = $tmp[0];
			$metadata[$cpt]['title'] = get_the_title($mp3Id);
			$metadata[$cpt]['image'] = $image;
			$metadata[$cpt]['url'] = $mp3Url;
			$temps = explode(':', $metadata[$cpt]['length_formatted']);
			$metadata[$cpt]['minutes'] = $temps[0];
			$metadata[$cpt]['secondes'] = $temps[1];
		?>

		<div class="player">
				<img src="<?= $image ?>" class="album-art" />
				<div class="meta-container">
					<div class="song-title"><?= $metadata[$cpt]['title'] ?></div>
					<div class="song-artist"><?= $metadata[$cpt]['artist'] ?></div>

					<div class="time-container">
						<div class="current-time">
							<span class="amplitude-current-minutes" data-amplitude-song-index="<?= $cpt ?>"></span>:<span class="amplitude-current-seconds" data-amplitude-song-index="<?= $cpt ?>"></span>
						</div>

						<div class="duration">
							<span class="amplitude-duration-minutes" data-amplitude-song-index="<?= $cpt ?>"><?= $temps[0] ?></span>:<span class="amplitude-duration-seconds" data-amplitude-song-index="<?= $cpt ?>"><?= $temps[1] ?></span>
						</div>
					</div>
					<progress class="amplitude-song-played-progress" data-amplitude-song-index="<?= $cpt ?>" id="song-played-progress-<?= $cpt ?>"></progress>
					<div class="control-container">
						<div class="amplitude-play-pause" data-amplitude-song-index="<?= $cpt ?>">

						</div>
					</div>
				</div>
			</div>


		<?php endif; $cpt++;?>
	<?php endwhile; ?>
<?php endif; ?>
<!-- FIN SI IL Y A FICHIER MP3 -->

<script>
	<?php if (isset($metadata)) : ?>
		const metadata = <?= json_encode($metadata) ?>;
		<?php endif; ?>
</script>