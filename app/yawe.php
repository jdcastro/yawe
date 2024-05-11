<?php
/**
 * 
 * yawe - Yet Another WordPress Enhancer 
 * 
 * @package Yawe
 * @since 1.0.0
 * @copyright 2023 Johnny De Castro
 * @license GPL-2.0+
 * 
 * @wordpress-plugin    
 * Plugin Name: Yet Another WordPress Enhancer 
 * Plugin URI: https://jdcastro.co/
 * Description: Additional settings for WordPress optimization and improvements
 * Version: 1.0.1
 * Author: Johnny De Castro
 * Author URI: https://jdcastro.co
 * License: GPL2
 * Text Domain: yawe
 * Domain Path: /languages
 * tags: optimization
 */

if (!defined('ABSPATH')) {
    exit;
}


if (!isset($YAWE_LOADERS)) {
    require_once plugin_dir_path(__FILE__) . 'loaders.php';
}