<?php
/**
 * Deshabilita los emojis en WordPress.
 */
function disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');
//disable_emojis();

/**
 * Elimina el plugin de emoji de TinyMCE.
 *
 * @param array $plugins Plugins de TinyMCE.
 * @return array Plugins de TinyMCE sin el plugin de emoji.
 */
function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, ['wpemoji']);
    }
    return []; // Retorna un array vacío si $plugins no es un array.
}

/**
 * Remueve la URL del CDN de emoji de las sugerencias de DNS prefetch.
 *
 * @param array $urls URLs para sugerencias de recursos.
 * @param string $relation_type Tipo de relación para el cual se imprimen las URLs.
 * @return array URLs modificadas.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if ($relation_type === 'dns-prefetch') {
        // Filtro documentado en wp-includes/formatting.php
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
        return array_diff($urls, [$emoji_svg_url]);
    }
    return $urls;
}
