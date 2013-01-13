<?php
/*
  Plugin Name: Plugin Banner
  Plugin URI: http://trenvo.com
  Description: Show WP.org repository banners on your website using a shortcode
  Version: 1.0
  Author: Mike Martel
  Author URI: http://trenvo.com
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Version number
 *
 * @since 0.1
 */
define('PLUGIN_BANNER_VERSION', '1.0');

/**
 * PATHs and URLs
 *
 * @since 0.1
 */
define('PLUGIN_BANNER_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_BANNER_URL', plugin_dir_url(__FILE__));

if ( !function_exists( 'plugin_banner_shortcode' ) ) :

    add_shortcode('plugin-banner', 'plugin_banner_shortcode' );
    function plugin_banner_shortcode( $atts ) {
        $atts = extract(shortcode_atts(array(
            'slug' => '',
            'name' => '',
            'img'  => ''
        ), $atts));

        if ( empty ( $name ) ) {
            if ( empty ( $slug ) ) return;
            $name = $slug;
        }

        if ( empty ( $img ) ) {
            if ( empty ( $slug ) ) return;
            $img = "http://s-plugins.wordpress.org/$slug/assets/banner-772x250.png";
        }

        wp_enqueue_style( 'plugin_banner', PLUGIN_BANNER_URL . 'plugin-banner.css', null, 1.0 );

        return "
            <div class='plugin-banner-sc'>
               <div class='vignette'></div>
               <img src='$img'>
               <h2 itemprop='name'>$name</h2>
           </div>";

    }

endif;