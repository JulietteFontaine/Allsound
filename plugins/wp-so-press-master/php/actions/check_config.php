<?php

/* vérification de la configuration wordpress (en cas de migration) */
function check_current_config(){

  if(isset($_GET['config']) && $_GET['config'] == 'force' && !isset($_GET['old']) && !isset($_GET['siteurl'])){
    $new = $_SERVER['REQUEST_SCHEME'].'://' . $_SERVER['HTTP_HOST'];
    ?>
    <form method="get">
      <input type="hidden" name=config value=force>
      <p>Ancienne Url<br><input type="text" name="old" size="100" placeholder="Ancienne url" value="<?php echo get_option('siteurl');?>"></p>

      <p>Nouvelle Url<br><input type="text" name="siteurl" size="100" placeholder="Nouvelle url" value="<?php echo $new;?>"></p>
      <input type="submit">
    </form>
    <?php
    exit;
  }

  $path = realpath('.');
  $config = isset($_GET['config']) ? $_GET['config'] : false;
  $siteurl = addslashes(isset($_GET['siteurl']) ? $_GET['siteurl'] : '') ;
  $old = addslashes(isset($_GET['old']) ? $_GET['old'] : '') ;

  if($config == 'force' && $old && $siteurl){

    /* mise à jour de l'url du site dans les options */
    update_option('home',$siteurl);
    update_option('siteurl',$siteurl);


    /* mise à jour de l'url du site dans les posts */
    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'posts SET post_content = REPLACE(post_content,"'.$old.'","'.$siteurl.'")');

    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'posts SET guid = REPLACE(guid,"'.$old.'","'.$siteurl.'")');

    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'options SET option_value = REPLACE(option_value,"'.$old.'","'.$siteurl.'")');

    echo('update terminated : '.$old.' -> '.$siteurl.' <a href="/wp-admin/">Continue</a>');
    exit;
  }
}
add_action( 'init', 'check_current_config' );
