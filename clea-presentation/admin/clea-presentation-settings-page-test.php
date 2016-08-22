<?php
/**
 *
 * Générer une page de réglage de l'extension
 * http://www.mendoweb.be/blog/wordpress-settings-api-multiple-sections-on-same-page/ 
 * http://wordpress.stackexchange.com/questions/143263/cant-output-do-settings-sections-cant-understand-why
 * http://wpsettingsapi.jeroensormani.com/settings-generator
 * http://www.mendoweb.be/blog/wordpress-settings-api-multiple-sections-on-same-page/
 * http://wordpress.stackexchange.com/questions/100023/settings-api-with-arrays-example
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.9.1
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */

 
$setting_pg = 'clea-presentation-settings-3' ;
$setting_gp = $setting_pg ;	// the group used for setting_fields 
// if $setting_gp is not = to $setting_pg : "Error: options page not found"...

// Hook to admin_menu the clea_tst_add_pages function above 
add_action( 'admin_menu', 'clea_tst_add_admin_menu' );

// define the plugin's settings for section 1 & 2
add_action( 'admin_init', 'clea_tst_settings_section_1_init' );

function clea_tst_add_admin_menu() {

	global $setting_pg ;
	
	// Add settings Page
	add_submenu_page(
          'edit.php?post_type=presentation', 							// plugin menu slug
          __( 'option page 3', 'clea-presentation' ), 				// page title
          __( 'Options 3', 'clea-presentation' ), 					// menu title
          'manage_options',               		// capability required to see the page
          $setting_pg,                	// admin page slug, unique ID
          'clea_tst_options_page'          // callback function to display the options page
    );

}

function clea_tst_settings_section_1_init(  ) { 

	global $setting_pg ;
	global $setting_gp ;
	global $setting_name ;
	
	// add the sections
	add_settings_section( 
		'our_first_section', 
		__( 'My First Section Title', 'clea-presentation' ), 
		'clea_tst_settings_section_callback' , 
		$setting_pg 		// menu slug
	);

	add_settings_section( 
		'our_second_section', 
		__( 'My second Section Title', 'clea-presentation' ), 
		'clea_tst_settings_section_callback' , 
		$setting_pg 
	);
	
	add_settings_section( 
		'our_third_section', 
		__( 'My third Section Title', 'clea-presentation' ),  
		'clea_tst_settings_section_callback' , 
		$setting_pg 
	);

	// add the fields
	add_settings_field( 
		'clea_tst_text_field_0', 
		__( 'Field 0 description', 'clea-presentation' ), 
		'clea_tst_text_field_0_render', 
		$setting_pg, 
		'our_first_section',
		array (
            'label_for'   => 'label1', 
            'name'        => 'text', 
            'value'       => 'test value',
            'option_name' => 'reee'
        )
	);
	
	add_settings_field( 
		'clea_tst_checkbox_field_1', 
		__( 'élément 1', 'clea-presentation' ), 
		'clea_tst_checkbox_field_1_render', 
		$setting_pg, 
		'our_first_section',
		array (
            'field_name' 	=> 'clea_tst_checkbox_field_1',
			'help'			=> __( 'Aide pour ce champs', 'clea-presentation' )
        ) 
	);

	add_settings_field( 
		'clea_tst_radio_field_2', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_tst_radio_field_2_render', 
		$setting_pg, 
		'our_second_section' 
	);


	add_settings_field( 
		'clea_tst_textarea_field_3', 
		__( 'Textarea field 3', 'clea-presentation' ), 
		'clea_tst_textarea_field_3_render', 
		$setting_pg, 
		'our_third_section' 
	);

	add_settings_field( 
		'clea_tst_radio_field_4', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_tst_radio_field_4_render', 
		$setting_pg, 
		'our_third_section' 
	);

	add_settings_field( 
		'clea_tst_select_field_5', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_tst_select_field_5_render', 
		$setting_pg, 
		'our_third_section' 
	);

	add_settings_field( 
		'clea_tst_text_field_2', 
		__( 'text field 2 description', 'clea-presentation' ), 
		'clea_tst_text_field_2_render', 
		$setting_pg, 
		'our_third_section' 
	);

	// register all the settings
	register_setting( $setting_gp, $setting_pg , 'clea_tst_validator' ) ;
	
}

function clea_tst_validator( $input ) {
	
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
    return apply_filters( 'clea_tst_validator', $output, $input );
 
}




function clea_tst_text_field_2_render( $args ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<input type='text' name='<?php echo $setting_pg ?>[clea_tst_text_field_2]' value='<?php echo sanitize_text_field( $options['clea_tst_text_field_2'] ); ?>'>
	<h4>display the $args</h4>
	<p><?php var_dump( $args ) ; ?></p>
	<?php

}

function clea_tst_text_field_0_render( $args ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<input type='text' name='<?php echo $setting_pg ?>[clea_tst_text_field_0]' value='<?php echo sanitize_text_field( $options['clea_tst_text_field_0'] ); ?>'>
	<h4>display the $args</h4>
	<p><?php var_dump( $args ) ; ?></p>
	<?php
}


function clea_tst_checkbox_field_1_render( $args ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<input type='checkbox' name='<?php echo $setting_pg ?>[clea_tst_checkbox_field_1]' <?php checked( $options['clea_tst_checkbox_field_1'], 1 ); ?> value='1'>
	<?php	
}


function clea_tst_radio_field_2_render(  ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<input type='radio' name='<?php echo $setting_pg ?>[clea_tst_radio_field_2]' <?php checked( $options['clea_tst_radio_field_2'], 1 ); ?> value='1'>
	<?php

}


function clea_tst_textarea_field_3_render(  ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<textarea cols='40' rows='5' name='<?php echo $setting_pg ?>[clea_tst_textarea_field_3]'> 
		<?php echo sanitize_text_field( $options['clea_tst_textarea_field_3'] ); ?>
 	</textarea>
	<?php

}


function clea_tst_radio_field_4_render(  ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<input type='radio' name='<?php echo $setting_pg ?>[clea_tst_radio_field_4]' <?php checked( $options['clea_tst_radio_field_4'], 1 ); ?> value='1'>
	<?php

}


function clea_tst_select_field_5_render(  ) { 

	global $setting_pg ;
	$options = get_option( $setting_pg );
	?>
	<select name='<?php echo $setting_pg ?>[clea_tst_select_field_5]'>
		<option value='1' <?php selected( $options['clea_tst_select_field_5'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['clea_tst_select_field_5'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function clea_tst_settings_section_callback( $arguments  ) { 

	switch( $arguments['id'] ){
		case 'our_first_section':
			$description = __( 'This is the first description here!', 'clea-presentation' ); 
			break;
		case 'our_second_section':
			$description = __( 'This one is number two!', 'clea-presentation' ); 
			break;
		case 'our_third_section':
			$description = __( 'Third time is the charm!', 'clea-presentation' ); 	
			break;
	}

	echo $description ;

}


function clea_tst_options_page(  ) { 

	global $setting_pg ;
	?>
	<div class="wrap">
	<form action='options.php' method='post'>

		<h2><?php echo  __( 'Titre de cette page', 'clea-presentation' ) ?></h2>
		

		<?php
		settings_errors();
		settings_fields( $setting_pg );
		do_settings_sections( $setting_pg );
		submit_button();
		?>

	</form>
	</div>
	<?php

}

