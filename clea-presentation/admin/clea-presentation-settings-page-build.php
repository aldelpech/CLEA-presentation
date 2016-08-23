<?php
/**
 *
 * Générer une page de réglage de l'extension
 * uses data from clea-presentation-settings-page-values.php
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.9.1
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */


/**********************************************************************

* to set the title of the setting page see clea_presentation_add_admin_menu()
* to set the description of the setting page see clea_presentation_options_page()
* to set other content in the settings page see clea_presentation_options_page()
* to set the titles of the sections see clea_presentation_settings_sections_val()
* to set the description of each section see clea_presentation_settings_section_callback()
* to set everything for the fields see clea_presentation_settings_fields_val()

**********************************************************************/
 
$setting_page = 'clea_presentation_settings' ;
$setting_group = $setting_page ;	// the group used for setting_fields 
// if $setting_group is not = to $setting_page : "Error: options page not found"...

// Hook to admin_menu the clea_presentation_add_pages function above 
add_action( 'admin_menu', 'clea_presentation_add_admin_menu' );

// define the plugin's settings for section 1 & 2
add_action( 'admin_init', 'clea_presentation_settings_section_1_init' );

function clea_presentation_add_admin_menu() {

	global $setting_page ;
	
	// Add settings Page
	add_submenu_page(
          'edit.php?post_type=presentation', 							// plugin menu slug
          __( 'Option des Présentations', 'clea-presentation' ), 				// page title
          __( 'Options', 'clea-presentation' ), 					// menu title
          'manage_options',               		// capability required to see the page
          $setting_page,                	// admin page slug, unique ID
          'clea_presentation_options_page'          // callback function to display the options page
    );

}

function clea_presentation_settings_section_1_init(  ) { 

	global $setting_page ;
	global $setting_group ;

	// array with the sections to generate
	$sections = clea_presentation_settings_sections_val( ) ;
	
	foreach( $sections as $section ) {
		
		add_settings_section( 
			$section[ 'section_name' ], 
			htmlspecialchars_decode( $section[ 'section_title' ] ), 
			$section[ 'section_callbk' ], 
			$section[ 'section_page' ]
		);
		
	}

	// return an array with the fields for each section name
	$section_fields = clea_presentation_settings_fields_val() ;

	
	foreach ( $section_fields as $section_field ) {

		foreach( $section_field as $field ){

			add_settings_field( 
				$field['field_id'], 
				$field['label'], 
				$field['field_callbk'],  
				$setting_page, 
				$field['section_name'], 
				$field 
			);
		}

		// register all the settings
		register_setting( $setting_group, $setting_page , 'clea_presentation_validator' ) ;
	
	}

	
}

function clea_presentation_validator( $input ) {
	
	// http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-7-validation-sanitisation-and-input-i--wp-25289
	
	 // Create our array for storing the validated options
    $output = array();
     
    // Loop through each of the incoming options
    foreach( $input as $key => $value ) {
         
        // Check to see if the current option has a value. If so, process it.
        if( isset( $input[$key] ) ) {
         
            // Strip all HTML and PHP tags and properly handle quoted strings
            $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
             
        } // end if
         
    } // end foreach
     
    // Return the array processing any additional functions filtered by this action
    return apply_filters( 'clea_presentation_validator', $output, $input );
 
}


function clea_presentation_field_callback( $arguments ) {
	
	/*
		array(
			'field_id' 		=> 'field_2',
			'label'			=> __( 'champs 2', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'our_first_section',
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> 'JJ/MM/YYYY',
			'helper'		=> __( 'help 2', 'clea-presentation' ),
			'default'		=> '01/08/2016',
			'supplement'	=> ''
		), 	
	*/
	
	
	global $setting_page ;
	$options = get_option( $setting_page );
	
	$value = get_option( $arguments['field_id'] );
	
	if( ! $value ) { // If no value exists
        $value = $arguments['default']; // Set to our default
    }
	
	// Check which type of field we want
    switch( $arguments['type'] ){
		
        case 'text': // If it is a text field
            printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['field_id'], $arguments['type'], $arguments['placeholder'], $value );
            break;
		case 'textarea': // If it is a textarea
			printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['field_id'], $arguments['placeholder'], $value );
			break;
		case 'select': // If it is a select dropdown
			if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
				$options_markup = '';
				foreach( $arguments['options'] as $key => $label ){
					$options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value, $key, false ), $label );
				}
				printf( '<select name="%1$s" id="%1$s">%2$s</select>', $arguments['field_id'], $options_markup );
			}
			break;
    }

	// If there is help text
    if( $helper = $arguments['helper'] ){
        printf( '<span class="helper"> %s</span>', $helper ); // Show it
    }

	// If there is supplemental text
    if( $suppliment = $arguments['supplement'] ){
        printf( '<p class="description">%s</p>', $suppliment ); // Show it
    }
}


function clea_presentation_settings_section_callback( $arguments  ) { 

	$sect_descr = array(

		'section_1' 	=> __( 'Pour modifier les paramètres de la page qui liste tous les produits publiés au format "présentation"', 'clea-presentation' ),
		'section_2' 	=> __( 'Un bouton qui se retrouve sur les écrans', 'clea-presentation' ),
		'section_3' 	=> __( 'Bouton sur les écrans 1 et 2', 'clea-presentation' ),
		'section_4' 	=> __( 'Bouton sur l\'écran 3', 'clea-presentation' ),
		'section_5' 	=> __( 'Bouton sur l\'écran 3', 'clea-presentation' ),
		'section_6' 	=> __( 'Définit les autres extensions à utiliser', 'clea-presentation' )

	);	

	$description = $sect_descr[ $arguments['id'] ] ;
	echo "<p><em>" . $description ."</em></p>" ;

}

function clea_presentation_options_page(  ) { 

	global $setting_page ;
	?>
	<div class="wrap">
	<form action='options.php' method='post'>

		<h1><?php  echo esc_html( get_admin_page_title() ); ?></h1>
		<p><em><?php echo __( 'Tous les réglages pour l\'extension "Présentations"', 'clea-presentation' ) ;?></em></p>

		<?php
		settings_errors();
		settings_fields( $setting_page );
		do_settings_sections( $setting_page );
		submit_button();
		?>

	</form>
	<?php 

	$current_colors = clea_presentation_get_current_colors() ;
	echo "<hr />";
	var_dump( $current_colors ) ;
	echo "<hr />";

	?>
	
	</div>
	<?php

}

function clea_presentation_get_current_colors() {

	// to get all the current theme data in an array
	$mods = get_theme_mods();

	$color = array() ;
	
	foreach ( $mods as $key => $values ) {
		
		if ( !is_array( $values ) ) {
			
			// echo "<p>values :" . $values . "</p>" ;

			if ( is_string( $values ) && trim( $values ) != '' ) {
				
				$hex = sanitize_hex_color_no_hash( $values ) ;
				
				if ( trim( $hex ) != '' ) {
					
					$color[ $key ] = $hex ;
					// echo "<p>key : " . $key . "color : " . $color[ $key ] ."</p>" ;
					// echo "<p>--------------------------------------</p>" ;
				}

			}
		} 
	}
	
	return $color ;
	
}

function clea_presentation_settings_sections_val() {

	global $setting_page ;
	
	$sections = array(
		array(
			'section_name' 	=> 'section_1',
			'section_title'	=> __( 'Page récapitulative', 'clea-presentation' ),
			'section_callbk'=> 'clea_presentation_settings_section_callback' ,
			'section_page'	=> $setting_page
		),
		array(
			'section_name' 	=> 'section_2',
			'section_title'	=> __( 'Bouton "retour à la liste de produits"', 'clea-presentation' ),
			'section_callbk'=> 'clea_presentation_settings_section_callback' ,
			'section_page'	=> $setting_page
		),
		array(
			'section_name' 	=> 'section_3',
			'section_title'	=> __( 'Bouton "je veux en savoir plus"', 'clea-presentation' ),
			'section_callbk'=> 'clea_presentation_settings_section_callback' ,
			'section_page'	=> $setting_page
		),
		array(
			'section_name' 	=> 'section_4',
			'section_title'	=> __( 'Bouton "Je contacte X"', 'clea-presentation' ),
			'section_callbk'=> 'clea_presentation_settings_section_callback' ,
			'section_page'	=> $setting_page
		),
		array(
			'section_name' 	=> 'section_5',
			'section_title'	=> __( 'Bouton "Je m\'inscris"', 'clea-presentation' ),
			'section_callbk'=> 'clea_presentation_settings_section_callback' ,
			'section_page'	=> $setting_page
		),
		array(
			'section_name' 	=> 'section_6',
			'section_title'	=> __( 'Autres réglages', 'clea-presentation' ),
			'section_callbk'=> 'clea_presentation_settings_section_callback' ,
			'section_page'	=> $setting_page
		)
	);	
	
	return $sections ;
	
}

function clea_presentation_settings_fields_val() {
	
	$section_1_fields = array(
		array(
			'field_id' 		=> 'presentation_title',
			'field_desc'	=> __( 'titre de la page récapitulative', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'label'			=> __( 'Le titre de la page', 'clea-presentation' ),
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> '#cccccc',
			'helper'		=> __( 'help 1', 'clea-presentation' ),
			'default'		=> '#cc11cc',
			'supplement'	=> ''
		), 	
		array(
			'field_id' 		=> 'page_baseline',
			'field_desc'	=> __( 'baseline pour la liste de tous les produits', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'label'			=> __( 'La baseline de la page récapitulative', 'clea-presentation' ),
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> 'votre texte ici',
			'helper'		=> __( 'Permet de mettre un message compact avant la liste de tous les produits', 'clea-presentation' ),
			'default'		=> '',
			'supplement'	=> ''
		), 
		array(
			'field_id' 		=> 'breadcrumb_title',
			'field_desc'	=> __( 'titre pour les breadcrumbs', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'label'			=> __( 'Le nom qui est affiché dans le fil d\'Ariane', 'clea-presentation' ),
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> 'un titre court',
			'helper'		=> __( 'Aide les utilisateurs à revenir en arrière', 'clea-presentation' ),
			'default'		=> '',
			'supplement'	=> ''
		), 
		array(
			'field_id' 		=> 'read_more_txt',
			'label'			=> __( 'Texte du "read more"', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> 'JJ/MM/YYYY',
			'helper'		=> __( 'le texte qui finit les résumé', 'clea-presentation' ),
			'default'		=> '',
			'supplement'	=> ''
		), 	
		array(
			'field_id' 		=> 'presentation_layout',
			'label'			=> __( 'Aspect des pages de présentation', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'select',
			'options'		=> array(
								__( 'Pleine page', 'clea-presentation' ) 	=> 'full',
								__( 'barre lat. gauche', 'clea-presentation' )	=> 'gauche',
								__( 'barre lat. droite', 'clea-presentation' )	=> 'droit'
							),
			'placeholder'	=> 'JJ/MM/YYYY',
			'helper'		=> __( 'help 2', 'clea-presentation' ),
			'default'		=> 'full',
			'supplement'	=> __( 'Un seul choix possible', 'clea-presentation' ),
		),
		array(
			'field_id' 		=> 'product_list_layout',
			'label'			=> __( 'Présentation de la liste de produits', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'select',
			'options'		=> array(
								'style "articles PP"' 	=> '1',
								'style "cartes"'	=> '2',
								'autre'	=> '3'
							),
			'placeholder'	=> '',
			'helper'		=> __( 'pour définir la présentation de chaque produit dans la liste récapitulative', 'clea-presentation' ),
			'default'		=> '2',
			'supplement'	=> __( 'Un seul choix possible', 'clea-presentation' ),
		),
		array(
			'field_id' 		=> 'author',
			'label'			=> __( 'Afficher l\'auteur', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'select',
			'options'		=> array(
								'oui' 	=> true,
								'non'	=> false,
							),
			'placeholder'	=> '',
			'helper'		=> '',
			'default'		=> true,
			'supplement'	=> __( 'Un seul choix possible', 'clea-presentation' ),
		),		
		array(
			'field_id' 		=> 'publish_date',
			'label'			=> __( 'Afficher la date de publication', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'select',
			'options'		=> array(
								'oui' 	=> true,
								'non'	=> false,
							),
			'placeholder'	=> '',
			'helper'		=> '',
			'default'		=> true,
			'supplement'	=> __( 'Un seul choix possible', 'clea-presentation' ),
		),	
		array(
			'field_id' 		=> 'backgnd_color_ecrans',
			'label'			=> __( 'couleur de fond des écrans"', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> '#BBBBBB',
			'helper'		=> __( 'le texte qui finit les résumé', 'clea-presentation' ),
			'default'		=> '#c3c3c3',
			'supplement'	=> ''
		),		
	) ;

	$section_2_fields = array(
		array(
			'field_id' 		=> 'icone_section_2',
			'field_desc'	=> __( 'icone', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_2',
			'label'			=> __( 'Icone pour ce bouton', 'clea-presentation' ),
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> 'fa-deaf',
			'helper'		=> '<i class="fa fa-barcode" aria-hidden="true"></i>',
			'default'		=> __( '!!!!! donner un type icone et afficher l\icone à côté de ce champs', 'clea-presentation' ),
			'supplement'	=> '<a target="_blank" href="http://fontawesome.io/icons/">Voir les codes sur Font Awesome</a>'
		), 
		array(
			'field_id' 		=> 'bkgd_color_section_2',
			'field_desc'	=> __( 'couleur du fond du bouton', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_2',
			'label'			=> __( 'couleur de fond', 'clea-presentation' ),
			'type'			=> 'color',
			'options'		=> false,
			'placeholder'	=> 'rgba(60,60,60,0.8)',
			'helper'		=> '<i class="fa fa-barcode" aria-hidden="true"></i>',
			'default'		=> '#ffffff',
			'supplement'	=> __( 'couleur en hexa (#ffffff) ou rgba rgba(60,60,60,0.8)', 'clea-presentation' )
		), 
		array(
			'field_id' 		=> 'text_color_section_2',
			'field_desc'	=> __( 'couleur du texte du bouton', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_2',
			'label'			=> __( 'couleur du texte', 'clea-presentation' ),
			'type'			=> 'color',
			'options'		=> false,
			'placeholder'	=> 'rgba(60,60,60,0.8)',
			'helper'		=> '<i class="fa fa-barcode" aria-hidden="true"></i>',
			'default'		=> '#ffffff',
			'supplement'	=> __( 'couleur en hexa (#ffffff) ou rgba rgba(60,60,60,0.8)', 'clea-presentation' )
		), 
		array(
			'field_id' 		=> 'text_section_2',
			'field_desc'	=> __( 'texte dans le bouton', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_2',
			'label'			=> __( 'texte du bouton', 'clea-presentation' ),
			'type'			=> 'text',
			'options'		=> false,
			'placeholder'	=> 'texte',
			'helper'		=> '',
			'default'		=> __( 'Retour à la liste des produits', 'clea-presentation' ),
			'supplement'	=> ''
		), 
	) ;
	
	$section_fields = array(
	
		'section_1'	=> $section_1_fields,
		'section_2' => $section_2_fields
	) ;	
	
	return $section_fields ;
}
