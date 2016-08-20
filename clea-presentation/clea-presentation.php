<?php
/**
* Plugin Name: ALD Presentation Pages Produits
* Plugin URI:  http://knowledge.parcours-performance.com
* Description: pour afficher nos pages produits
* Version:     0.8
* Author:      Anne-Laure Delpech
* Author URI:  http://knowledge.parcours-performance.com
* License:     GPL2
* Domain Path: /languages
* Text Domain: clea-presentation
* 
 * @package			clea-presentation
 * @version			0.7.0
 * @author 			Anne-Laure Delpech
 * @copyright 		Copyright (c) 2014-2014, Anne-Laure Delpech
 * @link			https://github.com/aldelpech/CLEA-presentation
 * @license 		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 			0.1.0
*/
 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Path to files
 * @since 0.7.0
 *----------------------------------------------------------------------------*/

	define( 'CLEA_PRES_MAIN_FILE', __FILE__ );
	define( 'CLEA_PRES_BASENAME', plugin_basename( CLEA_PRES_MAIN_FILE ));
	define( 'CLEA_PRES_DIR_PATH', plugin_dir_path( CLEA_PRES_MAIN_FILE ));
	define( 'CLEA_PRES_DIR_URL', plugin_dir_url( CLEA_PRES_MAIN_FILE ));
	

/********************************************************************************
* appeler d'autres fichiers php et les exécuter
* @since 0.7
********************************************************************************/	
	
	// charger des styles, fonts ou scripts correctement
	require_once CLEA_PRES_DIR_PATH . 'includes/clea-presentation-enqueues.php'; 

	// fonctions pour générer des boîtes avec des couleurs à tester
	require_once CLEA_PRES_DIR_PATH . 'includes/clea-presentation-custom-post-types.php'; 
	
	// générer une page de réglages de l'extension pour l'administrateur
	require_once CLEA_PRES_DIR_PATH . 'admin/clea-presentation-settings-page.php';
	require_once CLEA_PRES_DIR_PATH . 'admin/clea-presentation-settings-page-2.php';



/******************************************************************************
* Actions à réaliser à l'initialisation et l'activation du plugin
* see http://codex.wordpress.org/Function_Reference/register_post_type juste avant NOTES
******************************************************************************/
	add_action( 'init', 'clea_presentation_custom_types' );
	add_action( 'init', 'clea_presentation_taxonomy1' );
	add_action( 'init', 'clea_presentation_taxonomy2' );
	add_action( 'init', 'clea_presentation_thumbnails' );
		
	function clea_presentation_activation() {
		// register the custom post types and taxonomies
		clea_presentation_custom_types();
		clea_presentation_taxonomy1();
		clea_presentation_taxonomy2();
		// reflush (in order to create the new permalink system)
		// see http://code.tutsplus.com/articles/the-rewrite-api-post-types-taxonomies--wp-25488
		flush_rewrite_rules();
	}
	register_activation_hook(__FILE__, 'clea_presentation_activation');
	
/*----------------------------------------------------------------------------*
 * deactivation and uninstall
 *----------------------------------------------------------------------------*/
/* upon deactivation, wordpress also needs to rewrite the rules */
register_deactivation_hook(__FILE__, 'clea_presentation_deactivation');

function clea_presentation_deactivation() {
	flush_rewrite_rules(); // pour remettre à 0 les permaliens
}

// register uninstaller
register_uninstall_hook(__FILE__, 'clea_presentation_uninstall');

function clea_presentation_uninstall() {    
	// actions to perform once on plugin uninstall go here
	// remove all options and custom tables
}