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
 * @subpackage clea-presentation/includes
 */



/*************************************************************
*
* create the custom post types
*
*************************************************************/
	
function clea_presentation_custom_types() {

	$p_labels = array(
		'name'                => _x( 'Présentations', 'Post Type General Name', 'clea-presentation' ),
		'singular_name'       => _x( 'Présentation', 'Post Type Singular Name', 'clea-presentation' ),
		'menu_name'           => __( 'Pages Produit', 'clea-presentation' ),
		'parent_item_colon'   => __( 'Elément parent :', 'clea-presentation' ),
		'all_items'           => __( 'tous les produits', 'clea-presentation' ),
		'view_item'           => __( 'Voir le produit', 'clea-presentation' ),
		'add_new_item'        => __( 'Ajouter un nouveau produit', 'clea-presentation' ),
		'add_new'             => __( 'Nouveau produit', 'clea-presentation' ),
		'edit_item'           => __( 'Editer le produit', 'clea-presentation' ),
		'update_item'         => __( 'Mettre à jour le produit', 'clea-presentation' ),
		'search_items'        => __( 'Search Item', 'clea-presentation' ),
		'not_found'           => __( 'Not found', 'clea-presentation' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'clea-presentation' ),
	);
	
	$p_args = array(
		'label'               => __( 'presentations', 'clea-presentation' ),
		'description'         => __( 'A collection of slides forming a presentation', 'clea-presentation' ),
		'labels'              => $p_labels,
		'supports'            => array( 
			'title', 					// Text input field to create a post title
			'editor', 					// Content input box for writing
			/* 'comments',*/			// Ability to turn comments on/off
			/* 'trackbacks',	*/		// Ability to turn trackbacks and pingbacks on/off
			'revisions',				// Allows revisions to be made of your post
			/* 'author', */				// Displays a select box for changing the post author
			/* 'excerpt', (see line 520 and below) */	// A textarea for writing a custom excerpt
			'thumbnail',				// The thumbnail (featured image in 3.0) uploading box
			/* 'custom-fields',	*/		// Custom fields input area
			'page-attributes', 			// attributes box shown for pages. important for hierarchical post types, so you can select the parent post
		),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,			// true
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 20,			// 20 = sous "pages"
		'menu_icon'           => 'dashicons-randomize',
		'can_export'          => true,
		'has_archive'         => true,
		/* 'rewrite'             => array( 'slug' => 'NOUVEAU' ), */
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	
	register_post_type( 'presentation', $p_args );

	// Register Custom Post Type "slides"
	$labels = array(
		'name'                => _x( 'Ecrans', 'Post Type General Name', 'clea-presentation' ),
		'singular_name'       => _x( 'Ecran', 'Post Type Singular Name', 'clea-presentation' ),
		'menu_name'           => __( 'Slides', 'clea-presentation' ),
		'parent_item_colon'   => __( 'Parent Item:', 'clea-presentation' ),
		'all_items'           => __( 'Les écrans', 'clea-presentation' ),
		'view_item'           => __( 'View Item', 'clea-presentation' ),
		'add_new_item'        => __( 'Ajouter un écran', 'clea-presentation' ),
		'add_new'             => __( 'Nouvel écran', 'clea-presentation' ),
		'edit_item'           => __( 'Editer l\'écran', 'clea-presentation' ),
		'update_item'         => __( 'Update Item', 'clea-presentation' ),
		'search_items'        => __( 'Search Item', 'clea-presentation' ),
		'not_found'           => __( 'Not found', 'clea-presentation' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'clea-presentation' ),
	);
	$args = array(
		'label'               => __( 'slides', 'clea-presentation' ),
		'description'         => __( 'An individual slide', 'clea-presentation' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php?post_type=presentation', // show in menu presentation
		'map_meta_cap'        => true, // bool (defaults to FALSE) //Whether WordPress should map the meta capabilities (edit_post, read_post, delete_post) for you
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
		'query_var'			  => true,
		);
	register_post_type( 'slide', $args );
}


/*************************************************************
*
* create the taxonomies for the presentations
*
* Voir www.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/ 
* voir aussi http://www.smashingmagazine.com/2012/01/04/create-custom-taxonomies-wordpress/
*
*************************************************************/	

function clea_presentation_taxonomy1() {
	// taxonomie 1
	$labels = array(
		'name'              => _x( 'Famille', 'taxonomy general name' ),
		'singular_name'     => _x( 'Famille de produit', 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher les familles' ),
		'all_items'         => __( 'Toutes les familles de produit' ),
		'parent_item'       => __( 'Famille mère' ),
		'parent_item_colon' => __( 'Famille mère :' ),
		'edit_item'         => __( 'Editer la famille' ), 
		'update_item'       => __( 'Mettre à jour la famille' ),
		'add_new_item'      => __( 'Ajouter une nouvelle famille' ),
		'new_item_name'     => __( 'Nouvelle famille' ),
		'menu_name'         => __( 'Famille' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'hierarchical' 		=> true,
		'show_in_nav_menus' => false,
	);
	register_taxonomy( 'Famille', 'presentation', $args );
}

function clea_presentation_taxonomy2() {
// taxonomie 2
	$labels = array(
		'name'              => _x( 'Groupe', 'taxonomy general name' ),
		'singular_name'     => _x( 'Groupe de produit', 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher les groupes' ),
		'all_items'         => __( 'Tous les groupes de produit' ),
		'parent_item'       => __( 'Groupe père' ),
		'parent_item_colon' => __( 'Groupe père :' ),
		'edit_item'         => __( 'Editer le groupe' ), 
		'update_item'       => __( 'Mettre à jour le groupe' ),
		'add_new_item'      => __( 'Ajouter un nouveau groupe' ),
		'new_item_name'     => __( 'Nouveau groupe' ),
		'menu_name'         => __( 'Groupe' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'hierarchical' 		=> true,
		'show_in_nav_menus' => false,
	);
	register_taxonomy( 'Groupe', 'presentation', $args );
}
