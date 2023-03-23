<?php
/*
Template Name: page-contact
*/
get_header();

get_template_part('parts/logo');

?>

<?php if (have_posts()) : while (have_posts()) : the_post();
        $data = get_the_content();
    endwhile;
else : endif;
$lignes = explode('<br>', $data);
?>

            <div class="contact">
            <pre><?= var_dump($lignes) ?></pre>

            <?php
                // $lignesItems = count($ligne);
                // $i = 0;
                foreach ($lignes as $ligne) {
                ?>
                    <?php if ($i === 0) {?>
                        <span class='tel'> <?= $ligne; ?> </span>
                    <?php } else { ?>
                        <span><?= $ligne; ?> </span>
                    <?php }} ?>

            </div>

<?php get_footer(); ?>
</div>
