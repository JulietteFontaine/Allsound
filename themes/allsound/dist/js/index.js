$(function () {

	// fonction pour le menu ouvert-ferme

	let $menu = $('#menu-container');
	let $menu_img = $('#menu-container img');

	let $menu_ouvert = false;

	$menu_img.on('click', function () {
		$($menu).toggleClass('menu-ouvert');
		$menu_ouvert = !$menu_ouvert;

		if ($menu_ouvert) {
			$('#player-left-bottom').addClass('negative-z-index');

		} else {
			$('#player-left-bottom').removeClass('negative-z-index');

		}
	});

	if (typeof episodes !== 'undefined') {
		let cpt = episodes.length - 1;
		var podcastMp3 = [];
		// var infosPodcast = episode;
		generatePlaylistForAmplitude(cpt);
		Amplitude.init({
			debug: true,
			songs: podcastMp3,
			waveforms: {
				sample_rate: 50
			},
		});
	} else if (typeof metadata !== 'undefined') {

		let productions = generateSongForAmplitude(metadata);
		console.log(productions)
		Amplitude.init({
			debug: true,
			songs: productions,
			waveforms: {
				sample_rate: 50
			},
		});


		//document.querySelector('#song-played-progress').addEventListener('click', function(e) {

		// document.getElementById('song-played-progress').addEventListener('click', function (e) {
		// 	var offset = this.getBoundingClientRect();
		// 	var x = e.pageX - offset.left;

		// 	Amplitude.setSongPlayedPercentage((parseFloat(x) / parseFloat(this.offsetWidth)) * 100);
		// })
	}

	function generatePlaylistForAmplitude(cpt) {

		episodes.forEach(episode => {

			var acastPrivacy = "&#10;&nbsp;<br /><hr><p style='color: grey; font - size: 0.75em; '>See <a style='color: grey; ' target='_blank' rel='noopener noreferrer' href='https://acast.com/privacy'>acast.com/privacy</a> for privacy and opt-out information.</p>";

			var description = episode.description;
			var clean_acast = description.replace(acastPrivacy, "");
			var clean = clean_acast.replace(/<(?:.|\n)*?>/gm, "");

			var raccourcit = clean.slice(0, 150) + "...";

			podcastMp3[cpt] = {
				name: episode.title,
				album: json.channel.title,
				url: episode.enclosure['@attributes'].url,
				cover_art_url: imagePodcast,
				description: raccourcit
			};

			cpt--;
		});
	}

	function generateSongForAmplitude(productions) {
		let cpt = 0;
		let retProd= [];
		productions.forEach(production => {
			retProd[cpt] = {
				name: production.title,
				album: production.album,
				url: production.url,
				cover_art_url: production.image,
				description: production.description
			};
			cpt++;
		});

		return retProd;

	}

	// PAGINATION
	$('.displayed-episodes').hide();
	$('#displayed-episodes0').show();

	// VARIABLES
	var state = 0;
	var $page_btn = $(".page-btn");

	function pageActive(stt, $pactive = false, position = false) {
		if (position != false) {
			$pactive = $($page_btn[stt]);
		}

		for (i = 0; i < $page_btn.length; i++) {
			$page_btn[i].removeAttribute('id', 'page-active');
		};

		$pactive.attr('id', 'page-active');

	};

	function displayEpisode(step, state) {
		if (step == 'previous') {
			$('#displayed-episodes' + (state + 1)).hide();
			$('#displayed-episodes' + state).show();
		} else if (step == 'next') {
			$('#displayed-episodes' + (state - 1)).hide();
			$('#displayed-episodes' + state).show();
		} else {
			$('.displayed-episodes').hide();
			$('#displayed-episodes' + state).show();
		}
	};

	// NEXT BUTTON
	$('#next-btn').click(function nextStep(e) {
		e.preventDefault();
		if (state < (nbr_tab - 1)) {
			state++;
			console.log('NEXT : ' + state)

			displayEpisode('next', state);
			pageActive(state, '', 'next');
		} else {
			$('#displayed-episodes' + state).hide();
			$('#displayed-episodes' + (state - 1)).show();
		}

	});



	// PREVIOUS BUTTON
	$('#previous-btn').click(function previousStep(e) {
		e.preventDefault();
		if (state != 0) {
			state = state - 1;
			displayEpisode('previous', state);
			pageActive(state, '', 'previous');
		} else {
			return;
		}
	});

	// PAGE BUTTON
	for (i = 0; i < $page_btn.length; i++) {

		$page_btn[i].onclick = function pageStep(e) {
			e.preventDefault();

			state = this.getAttribute('data-state');
			console.log('PAGEBTN : ' + state)
			var $page_active = $(this);
			displayEpisode('page', state);
			pageActive(state, $page_active);

		};

	};

});