<?php
/**
 *
 * choisir les templates pour ce custom post types et ses taxonomies
 * modifier des éléments selon les settings définis par l'administrateur
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.9.0
 *
 * @package    clea-presentation
 */

// choose the plugin's template or the theme's template
add_filter( 'template_include', 'clea_presentation_template_chooser');

// change the H1 title of the 'presentation' page
// add_filter( 'wp_title','clea_presentation_title_changer' );
add_filter( 'document_title_parts', 'clea_presentation_title_changer' );


function clea_presentation_template_chooser( $template ) {
	
	// http://code.tutsplus.com/articles/plugin-templating-within-wordpress--wp-31088 
    // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'presentation' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single( ) ) {
        return clea_presentation_get_template_hierarchy( 'single-presentation' );
    }
	
	if ( is_post_type_archive( ) ) {
        return clea_presentation_get_template_hierarchy( 'archive-presentation' );
    }
 
}

function clea_presentation_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'templates/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = CLEA_PRES_DIR_PATH . '/templates/' . $template;
    }
 
    return apply_filters( 'clea_presentation_template_' . $template, $file );
}


function clea_presentation_title_changer( $orig_title ) {
	
	// http://themehybrid.com/board/topics/title-tag-would-like-to-change-using-a-function
	
	/* global $post ;
	if ( !is_post_type_archive( 'presentation' ) ) {
		
		return $orig_title ;
	}
	*/
	return array( 'prefix' => 'LCL' ) + $orig_title; 
	
}


