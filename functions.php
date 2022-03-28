<?php
/*
Plugin Name:  Leashless
Plugin URI:	  https://theleashlessdog.com
Description:  All the fancy stuff required to run theleashlessdog.com
Version:	  1.0.0
Author:		  Gregg Hogan
Author URI:   https://mynameisgregg.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  lshlss
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LSHLSS_THEME_DIR', get_template_directory() );
define( 'LSHLSS_THEME_URI', get_template_directory_uri() );

/* 
 * Style/Scripts
 */
function load_leashless_theme_scripts() {
	$version = wp_get_theme()->get('Version');
    wp_enqueue_style( 'leashless-theme', LSHLSS_THEME_URI . '/assets/css/main.css',null,$version );
    wp_enqueue_style('google-fonts','https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap');
    wp_enqueue_script( 'site-js', LSHLSS_THEME_URI. '/assets/js/site.js', array('jquery'),$version, true );
    //wp_enqueue_script( 'site-js', LSHLSS_THEME_URI. '/assets/js/site.min.js', array('jquery'),$version, false );
}
add_action( 'wp_enqueue_scripts', 'load_leashless_theme_scripts' );

function leashless_navs(){
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'lshlss' ),
        'footer'  => __( 'Footer Menu', 'lshlss' ),
    ) );
}
add_action( 'after_setup_theme', 'leashless_navs', 0 );

function leashless_theme_support() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'leashless_theme_support' );

add_filter('acf/settings/save_json', 'leashless_acf_save_point');
function leashless_acf_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'leashless_acf_load_point');

function leashless_acf_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

function leashless_page_title() {
    if(function_exists('get_field')) {
        echo '<h1>';
        if(get_field('page_title') != '') {
            echo get_field('page_title');
        } else {
            echo get_the_title();
        }
        echo '</h1>';
        if(get_field('subtitle') != '') {
            echo '<h2>'.get_field('subtitle').'</h2>';
        } 
    } else {
        echo '<h1>'.get_the_title().'</h1>';
    }
}