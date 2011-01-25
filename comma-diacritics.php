<?php
/*
Plugin Name: Correct Romanian Diacritics
Plugin URI: https://github.com/stas/comma-diacritics
Description: Searches and replaces the wrong (sedilla) diacritics with the correct ones on data saving
Version: 0.3
Author: Stas Sușcov
Author URI: http://stas.nerd.ro/
*/
?>
<?php
/*  Copyright 2010  Stas Sușcov <stas@nerd.ro>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

define( 'COMMA_DIAS_VERSION', '0.3' );

/**
 * comma_dias_get()
 *
 * Just a wrapper to generate the correct array of diacritics that are to be changed
 * @return Array
 */
function comma_dias_get() {
    return array(
        'Ş' => 'Ș',
        'ş' => 'ș',
        'Ţ' => 'Ț',
        'ţ' => 'ț'
    );
}

/**
 * comma_dias_check_string( $data )
 *
 * Hook for 'pre_term_{field}' to filter the correct/wrong diacritics
 * @param String $data, user posted content
 * @return String
 */
function comma_dias_check_string( $data ) { 
    $diacritics = comma_dias_get();
    
    foreach( $diacritics as $wrong => $right )
        $data = str_replace( $wrong, $right, $data );
    
    return $data;
}

/**
 * comma_dias_check_array( $data )
 *
 * Hook for 'wp_insert_post_data' to filter the correct/wrong diacritics
 * @param Array $data, user posted content
 * @return Array
 */
function comma_dias_check_array( $data ) { 
    if( !is_array( $data ) )
        return $data;
    
    $diacritics = comma_dias_get(); 

    foreach( $diacritics as $wrong => $right ) {
        $data['post_title'] = str_replace( $wrong, $right, $data['post_title'] );
        $data['post_excerpt'] = str_replace( $wrong, $right, $data['post_excerpt'] );
        $data['post_content'] = str_replace( $wrong, $right, $data['post_content'] );
    }
    
    return $data;
}

/**
 * comma_dias_enqueues()
 *
 * Sets up the enqueues that add the compatibility layer for Windows platform
 */
function comma_dias_enqueues() {
    // Skip if in wp-admin
    if( defined( 'WP_ADMIN' ) && WP_ADMIN == true )
        return;
    
    wp_register_script( 'commadias', plugins_url( '/js/commadias.plugin.js', __FILE__ ), array( 'jquery' ), COMMA_DIAS_VERSION );
    wp_enqueue_script( 'comma_dias_check', plugins_url( '/js/comma_dias_check.js', __FILE__ ), array( 'commadias' ), COMMA_DIAS_VERSION, true );
}

/* Register the hooks */
add_filter( 'esc_html', 'comma_dias_check_string' ); // blogname and blogdescription
add_filter( 'sanitize_title', 'comma_dias_check_string' ); // categories use this
add_filter( 'pre_term_name', 'comma_dias_check_string' ); // term name use this
add_filter( 'pre_term_description', 'comma_dias_check_string' ); // term description uses this
add_filter( 'wp_insert_post_data', 'comma_dias_check_array' ); // post and pages content uses this
add_action( 'init', 'comma_dias_enqueues' );
?>
