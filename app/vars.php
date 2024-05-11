<?php
if (!defined('ABSPATH')) {
    exit;
}
// Define constants for paths and URLs
if (!defined('YAWE_PLUGIN_FILE')) {
    define('YAWE_PLUGIN_FILE', __FILE__);
}
if (!defined('YAWE_PLUGIN_DIR')) {
    define('YAWE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('YAWE_PLUGIN_URL')) {
    define('YAWE_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('YAWE_PLUGIN_PATH')) {
    define('YAWE_PLUGIN_PATH', plugin_dir_path(__FILE__));
}
// Define names and versions

if (!defined('YAWE_PLUGIN_VERSION')) {
    define('YAWE_PLUGIN_VERSION', '1.0');
}
if (!defined('YAWE_PLUGIN_FULL_NAME')) {
    define('YAWE_PLUGIN_FULL_NAME', 'Yet Another WordPress Enhancer');
}
if (!defined('YAWE_PLUGIN_NAME')) {
    define('YAWE_PLUGIN_NAME', 'YAWE');
}
if (!defined('YAWE_PLUGIN_SLUG')) {
    define('YAWE_PLUGIN_SLUG', 'yawe');
}
if (!defined('YAWE_PLUGIN_AUTHOR')) {
    define('YAWE_PLUGIN_AUTHOR', 'Johnny De Castro');
}
