<?php
/**
 *
 * enqueue style and scripts for the admin settings page
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.9.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */

// sources are
// https://wpbeaches.com/add-an-rgba-color-picker-to-a-wordpress-plugin-input-field/
// https://github.com/BraadMartin/components/tree/master/alpha-color-picker
 
add_action( 'admin_enqueue_scripts',  'clea_presentation_admin_enqueue_scripts' );


function clea_presentation_admin_enqueue_scripts( $hook ) {
	

	if( 'presentation_page_clea_presentation_settings' != $hook ) { 
	
        // echo "not the right page, this is : " ;
		// echo $hook ;
		return;
		
    }

    wp_enqueue_style(
        'alpha-color-picker',
        CLEA_PRES_DIR_URL . '/admin/css/alpha-color-picker.css', // Update to where you put the file.
        array( 'wp-color-picker' ) // You must include these here.
    );

 wp_enqueue_style(
        'clea-presentation-settings',
        CLEA_PRES_DIR_URL . '/admin/css/clea-presentation-admin.css'
    );	
	

	wp_enqueue_script(
        'alpha-color-picker',
        CLEA_PRES_DIR_URL . '/admin/js/alpha-color-picker.js', 
        array( 'jquery', 'wp-color-picker' ), // You must include these here.
        null,
        true
    );
	
    // This is the JS file that will contain the trigger script.
    // Set alpha-color-picker as a dependency here.
    wp_enqueue_script(
        'xxx-admin-js',
        CLEA_PRES_DIR_URL . '/admin/js/clea-presentation-color-trigger.js', 
        array( 'alpha-color-picker' ),
        null,
        true
    );
	
}