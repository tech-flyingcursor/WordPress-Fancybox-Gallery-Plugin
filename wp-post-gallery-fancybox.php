<?php
/*
Plugin Name: WP Post Gallery Fancybox
Description: WP Post Gallery Fancybox is a WordPress plugin that converts the default WordPress Media Gallery into a Fancybox Gallery.
Version: 1.0.0
Author: Flying Cursor
Author URI: https://flyingcursor.com/
License: GNU General Public License v3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
*/


/*
Include FancyBox 3 Javascript File
*/
add_action('wp_enqueue_scripts', 'wp_post_gallery_fancybox_3_js');
function wp_post_gallery_fancybox_3_js()
{
    wp_enqueue_script('wp-post-gallery-fancybox-script', plugins_url('assets/js/jquery.fancybox.min.js', __FILE__));

    $plugin_url = array('pluginUrl' => plugins_url());
    //after wp_enqueue_script
    wp_localize_script('wp-post-gallery-fancybox-script', 'global_name', $plugin_url);
}


/*
Include FancyBox 3 CSS File
*/
add_action('wp_enqueue_scripts', 'wp_post_gallery_fancybox_3_css');
function wp_post_gallery_fancybox_3_css()
{
    wp_enqueue_style('wp-post-gallery-fancybox-style-plugin', plugins_url('assets/css/jquery.fancybox.min.css', __FILE__));
    wp_enqueue_style('wp-post-gallery-fancybox-style-custom', plugins_url('assets/css/wp-gallery-fancybox.css', __FILE__));
}


/*WordPress Custom Gallery  HTML Structure - https://stackoverflow.com/questions/14585538/customise-the-wordpress-gallery-html-layout*/
add_filter('post_gallery', 'postFancyboxGallery', 10, 2);

function postFancyboxGallery($string, $attr)
{
    $output = "<div class=\"wgf-post-gallery\">";
    $posts = get_posts(array('include' => $attr['ids'], 'post_type' => 'attachment'));

    $timeId = str_replace(",", "", $attr['ids']);
    foreach ($posts as $imagePost) {
        $caption = str_replace('"', "'", wp_get_attachment_caption($imagePost->ID));
        $output .= '<div class="wgf-post-gallery-elements" data-src="' . wp_get_attachment_image_src($imagePost->ID, 'large')[0] . '"  data-fancybox="slideshow-' . $timeId . '" class="slideshow"  data-caption="' . $caption . '" >';
        $output .= '<figure><img class="img-responsive" src="' . wp_get_attachment_image_src($imagePost->ID, 'full')[0] . '"/>';
        $output .= '<figcaption>' . $imagePost->post_excerpt . '</figcaption>';
        $output .= '</figure></div>';
    }
    return $output;
}
