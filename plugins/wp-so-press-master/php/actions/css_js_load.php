<?php
/**
 * Fonction automatiquemenct appelée à l'initialisation de la page avec
 * add_action ('init')
 */
function modify_css_js_loading() {
	wp_deregister_script('jquery');

	// Enregistrement du JS
	wp_register_script('global', ALLSOUND_THEME_URL.'dist/js/index.js', false, '3.2.1');
	wp_register_script('jquery', ALLSOUND_THEME_URL.'dist/js/jquery.js', false, '3.2.1');
	wp_register_script('requirejs', ALLSOUND_THEME_URL.'dist/js/require.js', false, '3.2.1');
	wp_register_script('transitions', ALLSOUND_THEME_URL.'dist/js/transitions.js', false, '3.2.1');
	wp_register_script('modal', ALLSOUND_THEME_URL.'dist/js/modal.js', false, '3.2.1');

	// Link to CSS
	wp_enqueue_style('global', ALLSOUND_THEME_URL.'dist/css/index.css');
	wp_enqueue_style('menu', ALLSOUND_THEME_URL.'dist/css/menu.css');
	wp_enqueue_style('style', ALLSOUND_THEME_URL.'dist/css/style.css');
	wp_enqueue_style('contact', ALLSOUND_THEME_URL.'dist/css/contact.css');
	wp_enqueue_style('modal', ALLSOUND_THEME_URL.'dist/css/modal.css');

	// Link to JS
	wp_enqueue_script('jquery', '', array(), null, true);
	wp_enqueue_script('global', "", array(), false, true);
	wp_enqueue_script('transitions', "", array(), false, true);
	wp_enqueue_script('requirejs', "", array(), false, true);
	wp_enqueue_script('modal', "", array(), false, true);

	wp_localize_script('global', 'myScript', array(
		'pluginsUrl' => plugins_url(),
		'permalink' => get_permalink(),
		'ajaxurl' => admin_url('admin-ajax.php'),
	));
add_filter('script_loader_tag', 'add_type_attribute' , 10, 3); 

}

function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}

function add_type_attribute($tag, $handle, $src) {
    // if not your script, do nothing and return original $tag
    if ( 'transitions' !== $handle ) {
        return $tag;
    } else if ($handle == 'transitions') {
			// change the script tag by adding type="module" and return it.
			$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		} else if($handle == 'requirejs') {
			
			$tag = '<script data-main="scripts/main" type="module" src="' . esc_url( $src ) . '"></script>';
			// <script data-main="scripts/main" src="scripts/require.js"></script>
		}
    return $tag;
}

// Load JS & CSS
add_action('wp_enqueue_scripts', 'modify_css_js_loading');

// Enlève les emoji WP
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action( 'wp_footer', 'my_deregister_scripts' );