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
	
	// https://codex.wordpress.org/Creating_Options_Pages
	
	 // Create our array for storing the validated options
    $output = array();
    

	if( isset( $input['label'] ) ) {
		
		$output['label'] = sanitize_text_field( $input['label'] );

		}

        return $output;
		
}


function clea_presentation_field_callback( $arguments ) {
	
	/****
	* with the settings API, sanitation is done by WordPress
	****/
	
	global $setting_page ;
	$options = get_option( $setting_page );
	$field_id = $arguments['field_id'] ;
			
	if( isset( $options[ $field_id ] ) ) {
		
		// and sanitize
		$value = esc_attr( $options[ $field_id ] ) ;
		
	} else {
		
		$value = $arguments['default']; // Set to our default

	}

	/*
	echo "<hr /><pre>";
	print_r( $arguments ) ;
	echo "</pre><hr />";
	echo "<p>field ID : " . $field_id . "</p>" ;
	echo "<p>field value : " . $value . "</p>" ;
	*/
/*
	if ( isset( $arguments[ 'label' ] ) ) {
		
		$arguments[ 'label' ] = esc_attr( $arguments[ 'label' ] ) ;
		
	}
	if ( isset( $arguments[ 'field_desc' ] ) ) {
		
		$arguments[ 'field_desc' ] = esc_attr( $arguments[ 'field_desc' ] ) ;
		
	}	
	if ( isset( $arguments[ 'helper' ] ) ) {
		
		$arguments[ 'helper' ] = esc_attr( $arguments[ 'helper' ] ) ;
		
	}	
	if ( isset( $arguments[ 'supplement' ] ) ) {
		
		$arguments[ 'supplement' ] = esc_attr( $arguments[ 'supplement' ] ) ;
		
	}	
	if ( isset( $arguments[ 'placeholder' ] ) ) {
		
		$arguments[ 'placeholder' ] = esc_attr( $arguments[ 'placeholder' ] ) ;
		
	}	

	if ( isset( $arguments[ 'options' ] ) && is_array( $arguments[ 'options' ] ) ) {

	// http://www.openmutual.org/2012/01/using-error_log-with-print_r-to-gracefully-debug-php/
	// in wpconfig.php, define('WP_DEBUG_LOG', true); 
	// the logged arrays will be printed in /wp-content/debug.log
	// error_log( print_r( $arguments[ 'options' ], true ) ) ;
	
		array_map( 'sanitize_text_field', $arguments[ 'options' ] );
		
	} else {
		
		$arguments[ 'options' ] = false ;
		
	}

	
	// display debug text if the mode debug checkbox is checked
	if (  isset( $options[ 'presentation_debug' ] ) && $options[ 'presentation_debug' ] == 1 ) {
		// Checkbox checked : show debug info
		
		echo "<p>DEBUG : display the arguments array</p>" ;
		var_dump( $arguments ) ; 
		echo "<hr />";
		// echo "$options : " ;
		echo "<p>options pour ce champs : " . $options[ $field_id ] . "</p>" ;
		echo "<p> value : $value , $option_set </p><br />" ;	
	} 

*/	
	// If there is a help text and / or description
	printf( '<span class="field_desc">' ) ;
	
    if( $helper = $arguments['helper'] ){
		printf( '<img src="%1$s/images/question-mark.png" class="alignleft" id="helper" alt="help" title="%2$s" data-pin-nopin="true">',CLEA_PRES_DIR_URL, $helper ) ;
    }
	
	// If there is a description
    if( isset( $arguments['field_desc'] ) && $description = $arguments['field_desc'] ){
        printf( ' %s', $description ); // Show it
    }

	printf( '</span>' ) ;

	// Check which type of field we want
    switch( $arguments['type'] ){
		
        case 'text': // If it is a text field
			printf( '<input name="%1$s[%2$s]" id="%2$s" type="%3$s" value="%4$s" placeholder="%5$s" />', $setting_page, $field_id, $arguments['type'], $value, $arguments['placeholder'] ) ;
            break;

		case 'textarea': // If it is a textarea
			printf( '<textarea name="%1$s[%2$s]" id="%2$s" placeholder="%3$s" rows="%6$d" cols="%5$d">%4$s</textarea>', $setting_page, $field_id, $arguments['placeholder'], $value, $arguments['cols'], $arguments['rows'] );
			break;
			
		case 'select': // If it is a select dropdown
			if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
			
			printf( '<select id="%2$s" name="%1$s[%2$s]">', $setting_page, $field_id );
			foreach( $arguments['options'] as $item ) {
				$selected = ( $value	 == $item ) ? 'selected="selected"' : '';
				echo "<option value='$item' $selected>$item</option>";
			}
			echo "</select>";	
			
			} else {
				echo __( 'Indiquer les options dans la définition du champs', 'clea-presentation' ) ;
			}
			break;

		case 'checkbox' : // it's a checkbox
			
			printf( '<input type="hidden" name="%1s["%2$s"]" id="%2$s" value="0" />', $setting_page, $field_id ) ;			
			if( $value ) { $checked = ' checked="checked" '; }
			printf( ' <input %3$s id="%2$s" name="%1$s[%2$s]" type="checkbox" />', $setting_page, $field_id, $checked ) ;
			break ;
			
		case 'radio' : // radio buttons
			if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
				
				echo "<span class='radio'>" ;
				foreach( $arguments['options'] as $key => $label ){
					
					$items[] = $label ;
				}

				foreach( $arguments['options'] as $item) {
					$checked = ( $value == $item ) ? ' checked="checked" ' : '';
					printf( '<label><input "%1$s" value="%3$d" name="%1$s[%2$s]" type="radio" /> %3$s</label><br />', $setting_page, $field_id, $item, $checked );
				}
				echo "</span>" ;
			}
			break ;
		case 'WYSIWYG' :
		
			
			$args = array( 
				$options[ $field_id ] => $setting_page . "[" . $field_id . "]"
			);
			
			wp_editor( $options[ $field_id ], $setting_page . "[" . $field_id . "]", $args );		
			break ;
		case 'color-picker' :
	
			// get the colors used by the theme
			$current_colors = clea_presentation_get_current_colors() ;
			$data_palette = "";
			
			// remove duplicate colors
			$current_colors = array_unique( $current_colors ) ;
			
			foreach ( $current_colors as $color ) {
				
				$data_palette .= $color . '|' ;
				
			}
			
			$data_palette = rtrim( $data_palette, '|' ) ;
			
			
			// uses https://github.com/BraadMartin/components/tree/master/alpha-color-picker
			printf( '<input type="text" class="alpha-color-picker" name="%1$s[%2$s]" value="%3$s" data-palette="%5$s" data-default-color="%4$s" data-show-opacity="true" />', $setting_page, $field_id, $value, $arguments['default'], $data_palette  ) ;
			break ;			
	}

	// If there is supplemental text
    if( $suppliment = $arguments['supplement'] ){
        printf( '<p class="complement">%s</p>', $suppliment ); // Show it
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
	<h4> is debug mode set ? </h4>
	<?php
	$options = get_option( $setting_page );
	if (  isset( $options[ 'presentation_debug' ] ) ) {
			echo"<p>we are in debug mode</p>"  ; 
	} else {
			echo "<p>Presentation debug set to " . esc_attr( $options[ 'presentation_debug' ] ) . "</p>"  ; 
	}
	?>
	
	<h4>display the colors used in the theme</h4>
	<?php 
	
	$current_colors = clea_presentation_get_current_colors() ;
	echo "<hr /><pre>";
	print_r( $current_colors ) ;
	echo "</pre><hr />";

	?>
	<h4>display all the field data of this options page</h4>
	<?php 
	
	$plugin_fields = clea_presentation_settings_fields_val() ;

	if ( !empty( $plugin_fields ) ) {
		echo"<p> tous les fields</p>" ;
		echo "<hr /><pre>";
		print_r( $plugin_fields ) ;
		echo "</pre><hr />";
	}

	?>
	<h4>list all field ids which may be in the options</h4>
	<p> then use <code>$options = get_option( $setting_page )</code><p>
	<p> <code>$options[ 'field-name' ]</code> will contain the value of the setting<p>	
	<?php 
	
	foreach ( $plugin_fields as $values ) {
		
		foreach ( $values as $val ) {
			
			echo"<p>field_id : " . $val[ 'field_id' ] .  "</p>"  ;
		
		}

	}


	
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

	/*********************************
	        'text'
			'textarea'
			'select'
			'checkbox'
			'radio'
			'WYSIWYG' : éditeur wysiwig
	*********************************/			
	$section_1_fields = array(
		array(
			'field_id' 		=> 'presentation_debug',
			'field_desc'	=> '',
			'label'			=> __( 'Mode Debug', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'options'		=> false,
			'type'			=> 'checkbox',
			'helper'		=> __( 'Option cochée : affichage de toutes les valeurs de deboguage en bas de cette page', 'clea-presentation' ),
			'default'		=> 1,
			'supplement'	=> ''
		),
		array(
			'field_id' 		=> 'presentation_title',
			'field_desc'	=> __( 'titre de la page récapitulative', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'label'			=> __( 'Le titre de la page', 'clea-presentation' ),
			'type'			=> 'textarea',
			'options'		=> false,
			'placeholder'	=> 'votre titre ici',
			'helper'		=> __( 'help 1', 'clea-presentation' ),
			'default'		=> '',
			'supplement'	=> '',
			'cols'			=> 80,
			'rows'			=> 1
		), 	
		array(
			'field_id' 		=> 'page_baseline',
			'field_desc'	=> __( 'baseline pour la liste de tous les produits', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'label'			=> __( 'La baseline de la page récapitulative', 'clea-presentation' ),
			'type'			=> 'textarea',
			'options'		=> false,
			'placeholder'	=> 'votre texte ici',
			'helper'		=> __( 'Permet de mettre un message compact avant la liste de tous les produits', 'clea-presentation' ),
			'default'		=> '',
			'supplement'	=> '',
			'cols'			=> 100,
			'rows'			=> 6
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
			'placeholder'	=> '',
			'helper'		=> __( 'le texte qui finit les résumé', 'clea-presentation' ),
			'default'		=> '',
			'supplement'	=> ''
		), 	
		array(
			'field_id' 		=> 'presentation_layout',
			'label'			=> __( 'Aspect des pages de présentation', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_1',
			'type'			=> 'radio',
			'options'		=> array(
								__( 'Pleine page', 'clea-presentation' ) ,
								__( 'barre lat. gauche', 'clea-presentation' )	,
								__( 'barre lat. droite', 'clea-presentation' )
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
								__( 'style "articles PP', 'clea-presentation' ),
								__( 'style "cartes', 'clea-presentation' ),
								__( 'autre', 'clea-presentation' ),
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
								__( 'Oui', 'clea-presentation' ),
								__( 'Non', 'clea-presentation' ),
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
								__( 'Oui', 'clea-presentation' ),
								__( 'Non', 'clea-presentation' ),
								__( '<a href="/Function_Reference/sanitize_title" title="Function Reference/sanitize title">sanitize_title()</a>', 'clea-presentation' ),
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
			'type'			=> 'color-picker',
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
			'default'		=> '',
			'supplement'	=> printf( '%1$s : http://fontawesome.io/icons/', __( 'Voir les codes des icones sur Font Awesome','clea-presentation' ) ) 
		), 
		array(
			'field_id' 		=> 'bkgd_color_section_2',
			'field_desc'	=> __( 'couleur du fond du bouton', 'clea-presentation' ),
			'field_callbk'	=> 'clea_presentation_field_callback' ,
			'section_name'	=> 'section_2',
			'label'			=> __( 'couleur de fond', 'clea-presentation' ),
			'type'			=> 'color-picker',
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
			'type'			=> 'color-picker',
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
			'type'			=> 'textarea',
			'options'		=> false,
			'placeholder'	=> 'texte',
			'helper'		=> '',
			'default'		=> __( 'Retour à la liste des produits', 'clea-presentation' ),
			'supplement'	=> '',
			'cols'			=> 80,
			'rows'			=> 1
		), 
	) ;
	
	$section_fields = array(
	
		'section_1'	=> $section_1_fields,
		'section_2' => $section_2_fields
	) ;	
	
	return $section_fields ;
}
