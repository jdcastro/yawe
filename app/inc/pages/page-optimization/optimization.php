<?php

class YAWE_Optimization
{
    public $plugin_slug;
    public $plugin_name;
    public $page_slug;
    public $page_name;
    public $page_url;
    public $page_options;

    private $page_group_name;
    private $options_array = array(
        "Disable Emojis" => "uw_disable_emojis",
        "Disable Dashicons" => "uw_disable_dashicons",
        "Disable Embeds" => "uw_disable_embeds",
        "Disable XML-RPC" => "uw_disable_xmlrpc",
        "Disable RSS Feeds" => "uw_disable_rss_feeds",
        "Disable RSS Feed Links" => "uw_disable_rss_feed_links",
        "Disable Self Pingbacks" => "uw_disable_self_pingbacks",
        "Disable Heartbeat" => "uw_disable_heartbeat",
        "Disable jQuery Migrate" => "uw_disable_jquery_migrate",
        "Disable Google Maps" => "uw_disable_google_maps",
        "Disable Shortlink" => "uw_disable_shortlink",
        "Disable RSD Link" => "uw_disable_rsd_link",
        "Disable wlwmanifest Link/Windows Live Writer" => "uw_disable_wlwmanifest_link",
        "Disable Wordpress widgets" => "uw_disable_wordpress_widgets",
        "Disable WordPress Generator, Stats and Version" => "uw_disable_wordpress_generator",
        "Disable File Editor" => "uw_disable_file_editor"
    );

    public function __construct()
    {
        $this->plugin_slug = YAWE_PLUGIN_SLUG;
        $this->plugin_name = YAWE_PLUGIN_FULL_NAME;
        $this->page_slug = basename(__FILE__, '.php'); // 'optimization' change this to the page slug of your page
        $this->page_name = __('Optimization', $this->plugin_slug); // change this to the name of your page
        $this->page_url = $this->plugin_slug . '_' . $this->page_slug;
        $this->page_options = $this->plugin_slug . '_' . $this->page_slug . '_options';
        $this->page_group_name = $this->plugin_slug . '_' . $this->page_slug . '_options_name';
        add_action('admin_menu', array($this, 'add_option_page'));
        add_action('admin_init', array($this, 'page_init'));
        $this->initialize_options();
    }

    public function add_option_page()
    {
        add_submenu_page(
            $this->plugin_slug,
            $this->page_slug,
            $this->page_name,
            'manage_options',
            $this->page_url,
            array($this, 'create_admin_page')
        );
    }

    public function create_admin_page()
    {
        echo '<div class="wrap unweb">';
        echo '<h2>' . $this->page_name . __(' Options', $this->page_slug) . ' </h2>';
        echo '<form method="post" action="options.php">';
        settings_fields($this->page_options);
        do_settings_sections($this->page_url);
        submit_button();
        echo '</form>';
        echo '</div>';
    }

    public function page_init()
    {
        register_setting(
            $this->page_options,
            $this->page_group_name,
            array($this, 'sanitize_options')
        );

        add_settings_section(
            $this->page_group_name . '_section',
            $this->page_name,
            array($this, 'section_callback'),
            $this->page_url
        );

        foreach ($this->options_array as $option_title => $option_value) {
            add_settings_field(
                $option_value,
                $option_title,
                array($this, 'option_callback'),
                $this->page_url,
                $this->page_group_name . '_section',
                array('option_value' => $option_value) // $args
            );
        }


    }
    public function initialize_options()
    // Initialize options with default values if they don't exist
    // and fix the first click save bug
    // is not elegant but it works
    {
        $options_array = array_values($this->options_array);

        $default_options = array();
        foreach ($options_array as $key => $value) {
            $default_options[$value] = false;
        }

        if (false === get_option($this->page_group_name)) {
            add_option($this->page_group_name, $default_options);
        }
    }

    public function option_callback($args)
    {
        $options = get_option($this->page_group_name);
        $option_value = $args['option_value'];
        $is_checked = isset($options[$option_value]) && $options[$option_value];
        echo '
        <label class="switch">
          <input type="checkbox" id="' . esc_attr($option_value) . '" name="' . esc_attr($this->page_group_name . '[' . $option_value . ']') . '" ' . checked($is_checked, true, false) . ' />
          <span class="slider"></span>
        </label>';
    }

    public function sanitize_options($options)
    {
        foreach ($options as $key => $value) {
            $options[$key] = sanitize_text_field($value);
        }
        return $options;
    }
    public function section_callback()
    {
        echo '<p>' . __('Configura las opciones de ', $this->plugin_slug) . esc_html($this->plugin_name) . '.</p>';
    }

}

$custom_options_plugin = new YAWE_Optimization();
include_once YAWE_PLUGIN_DIR . 'inc/pages/page-optimization/functions.php';



