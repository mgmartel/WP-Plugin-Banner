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
define('PLUGIN_BANNER_VERSION', '0.1');

/**
 * PATHs and URLs
 *
 * @since 0.1
 */
define('PLUGIN_BANNER_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_BANNER_URL', plugin_dir_url(__FILE__));

if (!class_exists('WP_PluginBanner')) :

    class WP_PluginBanner    {

        private $plugin_name = '';
        private $plugin_img  = '';

        /**
         * Creates an instance of the WP_PluginBanner class
         *
         * @return WP_PluginBanner object
         * @since 0.1
         * @static
        */
        public static function &init( $atts, $content = 0 ) {
            $instance = new WP_PluginBanner( $atts );
        }

        /**
         * Constructor
         *
         * @since 0.1
         */
        public function __construct( $atts ) {
            $atts = extract(shortcode_atts(array(
                'slug' => '',
                'name' => '',
                'img'  => ''
            ), $atts));

            if ( empty ( $name ) && empty ( $slug ) ) return;

            if ( ! empty ( $img ) ) {
                $this->plugin_img = $img;
            } elseif ( ! empty ( $slug ) )
                $this->plugin_img = "http://s-plugins.wordpress.org/$slug/assets/banner-772x250.png";
            else return;

            $this->plugin_name = ( ! empty ( $name ) ) ? $name : $slug;

            $this->enqueue_style();
            $this->display();
        }

            /**
             * PHP4
             *
             * @since 0.1
             */
            public function WP_PluginBanner() {
                $this->__construct();
            }

        private function enqueue_style() {
            wp_enqueue_style( 'plugin_banner', PLUGIN_BANNER_URL . 'plugin-banner.css', null, 1.0 );
        }

        private function display() {
            ?>
            <div class="plugin-banner-sc">
                <div class="vignette"></div>
                <img src="<?php echo $this->plugin_img ?>">
                <h2 itemprop="name"><?php echo $this->plugin_name ?></h2>
            </div>
            <?php
        }


    }

    add_shortcode('plugin-banner', array ( WP_PluginBanner, 'init' ) );
endif;