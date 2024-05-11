<?php

if (!defined('ABSPATH')) { exit; }

class YAWE_Optimization_Functions {
    private $options;
    private $option_key;
    private $option_name;

    public function __construct() {
        $this->option_key = 'optimization';
        $this->option_name = YAWE_PLUGIN_SLUG . '_' . $this->option_key . '_options_name'; 
        $this->options = (array) get_option($this->option_name);
        $this->initialize_actions();
    }
    private function initialize_actions() {
        foreach ($this->options as $option_key => $value) {
            if (isset($value) && $value == 'on') {
                if (method_exists($this, $option_key)) {
                    if ($option_key == 'uw_disable_dashicons') {
                        add_action('init', [$this, $option_key]);
                    } else {
                        $this->$option_key();
                    }
                }
            }
        }
    }

    public function uw_disable_emojis() {
        require_once YAWE_PLUGIN_DIR . 'inc/pages/page-optimization/disable/emojis.php';
    }

    public function uw_disable_dashicons() {
        if (!is_user_logged_in()) {
            add_action('wp_print_styles', function () {
                wp_deregister_style('dashicons');
                wp_dequeue_style('dashicons');
            });
        }
    }

    public function uw_disable_embeds() {
        require_once YAWE_PLUGIN_DIR . 'inc/pages/page-optimization/disable/embeds.php';
    }

    public function uw_disable_xmlrpc() {
        add_filter( 'xmlrpc_enabled', '__return_false' );
        add_filter( 'xmlrpc_methods', function( $methods ) {
            unset( $methods['pingback.ping'] );
            unset( $methods['pingback.extensions.getPingbacks'] );
            return $methods;
        });
    }

    public function uw_disable_rss_feeds() {
        add_action('do_feed', function () {
            wp_die('No feed available.');
        }, 1);
    }

    public function uw_disable_rss_feed_links() {
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
    }

    public function uw_disable_self_pingbacks() {
        add_action('pre_ping', function (&$links) {
            $home = get_option('home');
            foreach ($links as $l => $link) {
                if (0 === strpos($link, $home)) {
                    unset($links[$l]);
                }
            }
        });
    }

    public function uw_disable_heartbeat() {
        add_action('init', function () {
            wp_deregister_script('heartbeat');
        });
    }

    public function uw_disable_jquery_migrate() {
        add_filter('wp_default_scripts', function ($scripts) {
            if (!empty($scripts->registered['jquery'])) {
                $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
            }
        });
    }

    public function uw_disable_google_maps() {
        add_filter('script_loader_src', function ($src) {
            if (strpos($src, 'maps.googleapis.com') !== false) {
                return '';
            }
            return $src;
        });
    }
    
    public function uw_disable_shortlink() {
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    }
    public function uw_disable_rsd_link() {
        remove_action('wp_head', 'rsd_link');
    }
    public function uw_disable_wlwmanifest_link() {
        remove_action('wp_head', 'wlwmanifest_link');
    }

    public function uw_disable_wordpress_widgets() {
        add_action('widgets_init', [$this, 'disable_wordpress_widgets']);
    }
    public function disable_wordpress_widgets() {
        global $wp_widget_factory;
        if (!empty($wp_widget_factory->widgets)) {
            foreach (array_keys($wp_widget_factory->widgets) as $widget_class) {
                unregister_widget($widget_class);  
            }
        }
    }
    public function uw_disable_wordpress_generator() {
        require_once YAWE_PLUGIN_DIR . 'inc/pages/page-optimization/disable/wordpress-generator.php';
    }
    public function uw_disable_file_editor() {
        define('DISALLOW_FILE_EDIT', true);
    }
}

// Usage
$yawe_optimizer = new YAWE_Optimization_Functions();
