<?php
/**
 * Child-Theme functions and definitions
 */

function daiquiri_child_scripts() {
    wp_enqueue_style( 'daiquiri-parent-style', get_stylesheet_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'daiquiri_child_scripts' );



 // QuickCal
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-quickcal-script', get_stylesheet_directory_uri() . '/js/custom-quickcal.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

add_filter( 'gettext', 'my_custom_text_changes', 20, 3 );
function my_custom_text_changes( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Book Appointment' :
            $translated_text = 'Reservar una cita';
            break;
    }
    return $translated_text;
}

?>