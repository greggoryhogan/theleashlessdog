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

/**
 * Custom title output for banner section
 */
function leashless_page_title() {
    if(is_home() || is_front_page()) {
        
    } else {
        echo '<div class="page-content">';
    }
    //fallback check for get field. We'll always use but prevents theme from crashing without it
    if(function_exists('get_field')) {
        echo '<h1>';
        if(get_field('page_title') != '') {
            echo get_field('page_title');
        } else {
            if(is_tax()) {
                echo get_the_archive_title();
            } else {
                echo get_the_title();
            }
        }
        echo '</h1>';
        if(get_field('additional_content') != '') {
            echo apply_filters('the_content',get_field('additional_content'));
        } 
    } else {
        echo '<h1>'.get_the_title().'</h1>';
    }
    if(is_home() || is_front_page()) {
        
    } else {
        echo '</div>';
    }
}

/**
 * Filter get_the_archive_title to hide 'archive:' from output
 */
add_filter( 'get_the_archive_title', 'leashless_archive_titles');
function leashless_archive_titles($title) {   
    global $wp_query; 
    if ( is_category() ) {    
            $title = single_cat_title( '', false );    
        } elseif ( is_tag() ) {    
            $title = single_tag_title( '', false );    
        } elseif ( is_author() ) {    
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
        } elseif ( is_tax() ) { //for custom post types
            $query = get_queried_object();
            //echo '<pre>'.print_r($query,true).'</pre>';
            if($query->taxonomy == 'locations') {
                $title = sprintf( __( '<span class="eyebrow">Parks in</span>%1$s' ), single_term_title( '', false ) );
                //$term_id = $wp_query->query->term_id;
                $parent = $query->parent;
                if($parent > 0) {
                    $term = get_term_by('id',$parent,'locations');
                    $category = $term->name;
                    $title .= ', '.$category;
                }
            } else {
                $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
            }
            /*$parent = $location->parent;
            $term = get_term_by('id',$parent,'locations');
            $category = $term->name;
            $name = $location->name.', '.$category;*/
            

        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title( '', false );
        }
    return $title;    
}

function leashless_page_header() {
    global $post;
    $featured_image = '';
    if ( has_post_thumbnail() ) { 
        if(is_home() || is_front_page()) {
            $featured_image = get_the_post_thumbnail_url($post, 'full');
        } else {
            $featured_image = get_the_post_thumbnail_url($post, 'hero-image');
        }
    } else {
        /*if(is_tax()) {
            $query = get_queried_object();
            //echo '<pre>'.print_r($query,true).'</pre>';
            if($query->taxonomy == 'locations') {
                $term_id = $query->term_id;
                $featured_image_data = get_field('featured_image',$query);
                if($featured_image_data) {
                    //print_r($featured_image_data);
                    $featured_image = $featured_image_data['sizes']['hero-image'];
                } else {
                    $parent = $query->parent;
                    if($parent > 0) {
                        $term = get_term_by('id',$parent,'locations');
                        $featured_image_data = get_field('featured_image',$term->term_id);
                        if($featured_image_data) {
                            $featured_image = $featured_image_data['sizes']['hero-image'];
                        }
                    }
                }
                
            } 
        }*/
    }
    if($featured_image != '') {
        echo '<img src="'.$featured_image.'" />';
    } else {
        //echo '<img src="https://theleashlessdog.local/wp-content/uploads/2022/03/leashless-hero-1-1270x475.png" />';
    }
}

add_image_size( 'hero-image', 1270, 475, true );