<?php get_header();

$dir = get_template_directory_uri();
$hoverSvg = $dir . '/dist/img/play-circle-white.svg';

get_template_part('parts/menu');
get_template_part('parts/logo');

$productions = get_post_by_category('Nos productions'); ?>

<div class="productionsContainer">

    <?php foreach ($productions as $production) : ?>

        <div class="production">
            <a href="<?= $production['url'] ?>">
                <img class="play-hover" src="<?= $hoverSvg ?>">
                <img class="cover" src="<?= $production['vignette'] ?>" alt="">
            </a>
        </div>

    <?php endforeach; ?>

</div>

<?php get_footer(); ?>