<?php
/*
Template Name: page-contact
*/
get_header();
get_template_part('parts/logo');
get_template_part('parts/menu');

$linkedin = get_template_directory_uri();
$svgLinkedin = $linkedin . '/dist/img/linkedin-brands.svg';

?>

<?php if (have_posts()) : while (have_posts()) : the_post();
        $data = get_the_content();
    endwhile;
else : endif;

$lignes = explode("<br>", $data);
?>

<div class="contact">
    <?php $cpt = 0;
    foreach ($lignes as $ligne) { ?>
        <div class="adresse">
            <?= $ligne ?>
        </div>
    <?php }
    $cpt++;
    $new_data = implode("\n", $lignes);
    ?>

    <a href="https://www.linkedin.com/company/allsound-allso/">
        <img class="linkedin-icon" src="<?= $svgLinkedin ?>" alt="likendin-icon">
    </a>

    <?php get_footer(); ?>
</div>

<!-- code à modifier si on veut l'adresse et les telephone d'une différente typo -->