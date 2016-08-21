<?php
/**
 *
 * Générer les custom post types et leurs taxonomies
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.9.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includessingle
 */

// http://code.tutsplus.com/articles/plugin-templating-within-wordpress--wp-31088
add_filter( 'template_include', 'clea_presentation_template_chooser');



function clea_presentation_template_chooser( $template ) {
 
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





