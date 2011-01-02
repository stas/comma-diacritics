<?php
/*
Plugin Name: Comma Diacritics
Plugin URI: http://ubuntu.ro
Description: Searches and replaces the wrong (sedilla) diacritics with the correct ones on data saving
Version: 0.1
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

define( 'COMMA_DIAS_VERSION', '0.1' );

function comma_dias_check( $data ) { 
    if( !is_array( $data ) )
        return $data;
    
    $diacritics = array(
        'Ş' => 'Ș',
        'ş' => 'ș',
        'Ţ' => 'Ț',
        'ţ' => 'ț'
    );

    foreach( $diacritics as $wrong => $right ) {
        $data['post_title'] = str_replace( $wrong, $right, $data['post_title'] );
        $data['post_excerpt'] = str_replace( $wrong, $right, $data['post_excerpt'] );
        $data['post_content'] = str_replace( $wrong, $right, $data['post_content'] );
    }
    
    return $data;
}

function comma_dias_enqueues() {
    wp_register_script( 'commadias', plugins_url( '/js/commadias.plugin.js', __FILE__ ), array( 'jquery' ), COMMA_DIAS_VERSION );
    wp_enqueue_script( 'comma_dias_check', plugins_url( '/js/comma_dias_check.js', __FILE__ ), array( 'commadias' ), COMMA_DIAS_VERSION, true );
}

add_filter( 'wp_insert_post_data', 'comma_dias_check' );
add_action( 'init', 'comma_dias_enqueues' );
?>
