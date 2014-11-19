<?php
/**
 * Dequeue Scripts
 */

function flexbones_custom_jquery() {
    // Deregister unless the page is login/admin
    if(!in_array($GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php')) AND !is_admin() ){
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-ui');
    }
}

add_action('init', 'flexbones_custom_jquery');

/**
 * Enqueue Scripts
 */

function flexbones_load_js() {
    // NAME / LOCATION / DEPENDENCIES (accepts array) / VERSION / IN FOOTER (true | false)
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array(), '1.11.1', true);
    wp_register_script('scripts', get_template_directory_uri() . '/scripts.min.js', array( 'jquery' ), '1', true);

    // Enqueue Scripts
    wp_enqueue_script('scripts');

    // wp_enqueue_script('google-analytics');
}

add_action('wp_enqueue_scripts', 'flexbones_load_js'); // For use on the Front end (ie. Theme

/**
 * Localise Vars
 * Make specified PHP data available in your specified scripts
 */

function flexbones_localize_vars() {
    $stylesheet_root = array('dir' => get_stylesheet_directory_uri());
    wp_localize_script('scripts', 'stylesheet_root', $stylesheet_root);
}

add_action('wp_enqueue_scripts', 'flexbones_localize_vars');