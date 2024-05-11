<?php
if (!defined('ABSPATH')) {
    exit;
}

class WP_Version_Remover {
    public function __construct() {
        remove_action('wp_head', 'wp_generator');
        add_filter('script_loader_src', array($this, 'remove_version_from_resources'), 9999);
        add_filter('style_loader_src', array($this, 'remove_version_from_resources'), 9999);
        add_action('init', array($this, 'start_buffer'));
        add_action('shutdown', array($this, 'end_buffer'));
    }

    private function get_wp_version() {
        global $wp_version;
        return $wp_version;
    }

    public function remove_version_from_resources($src) {
        $wpVersion = $this->get_wp_version();
        if (strpos($src, 'ver=' . $wpVersion)) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }

    public function remove_version_from_html($buffer) {
        $wpVersion = $this->get_wp_version();
        $regex = '/\?ver=' . preg_quote($wpVersion, '/') . '/';
        $buffer = preg_replace($regex, '', $buffer);
        return $buffer;
    }

    public function start_buffer() {
        ob_start(array($this, 'remove_version_from_html'));
    }

    public function end_buffer() {
        if (ob_get_length()) {
            ob_end_flush();
        }
    }
}

$wp_version_remover = new WP_Version_Remover();
