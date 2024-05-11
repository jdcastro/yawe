<?php

class Yawe_Admin_Dashboard {
    public $plugin_full_name = YAWE_PLUGIN_FULL_NAME;
    public $plugin_name = YAWE_PLUGIN_NAME;
    public $plugin_slug = YAWE_PLUGIN_SLUG;


    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'load_assets'));
        //add_action('admin_init', array($this, 'register_pages'));
        $this->register_pages();
    }

    public function add_admin_menu() {
        add_menu_page(
            __($this->plugin_full_name, $this->plugin_slug ),
            __($this->plugin_name, $this->plugin_slug),
            'manage_options',
            $this->plugin_slug,
            array($this, 'admin_page'),
            'dashicons-hammer',
            100
        );
    }

    public function admin_page() {
        include_once YAWE_PLUGIN_DIR . 'views/admin/welcome.php';
    }

    // load css and js 
    public function load_assets() {
        wp_enqueue_style('yawe-admin-css', YAWE_PLUGIN_URL . 'views/admin/assets/css/main.css', array(), YAWE_PLUGIN_VERSION, 'all');
        wp_enqueue_script('yawe-admin-js', YAWE_PLUGIN_URL . 'views/admin/assets/js/main.js', array(), YAWE_PLUGIN_VERSION, true);
    }
    
    public function register_pages() {
        include_once YAWE_PLUGIN_DIR . 'inc/admin-pages.php';
    }

}
new Yawe_Admin_Dashboard();