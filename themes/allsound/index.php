<?php get_header();

$dir = get_template_directory_uri();
$hoverSvg = $dir . '/dist/img/play-circle-white.svg';

get_template_part('parts/menu');
get_template_part('parts/logo');

$podcasts = get_post_by_category('Podcast'); ?>

<div class="podcastsContainer">

    <?php foreach ($podcasts as $podcast) : ?>

        <div class="podcast">
            <a href="<?= $podcast['url'] ?>">
                <img class="play-hover" src="<?= $hoverSvg ?>">
                <img class="cover" src="<?= $podcast['vignette'] ?>" alt="">
            </a>
        </div>

    <?php endforeach; ?>

</div>
<div id="mentions-legales">
    <a class="mentions-legales" href="https://pages.sopress.net/mentions-legales">Mentions légales</a>
</div>
<?php get_footer(); ?>