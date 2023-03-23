<?php
/*
Template Name: page-about
*/
get_header();
get_nav_menu_locations();
get_template_part('parts/logo');
get_template_part('parts/menu');

?>

<?php
if (have_posts()) : while (have_posts()) : the_post();
        $data = get_the_content();
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
    endwhile;
else : endif;

?>

<div class="about">
    <h1>ABOUT</h1>
    <a id="image_about" href="<?=$featured_img_url?>" rel="lightbox">
    <?php the_post_thumbnail($size= 'medium'); ?>
    </a>
    <div class="texte">
    <?= $data ?>
    <div>
</div>

<?php get_footer(); ?>
</div>
