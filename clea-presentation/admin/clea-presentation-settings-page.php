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

 
$setting_page = 'clea-presentation-settings-3' ;
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
          __( 'option page 3', 'clea-presentation' ), 				// page title
          __( 'Options 3', 'clea-presentation' ), 					// menu title
          'manage_options',               		// capability required to see the page
          $setting_page,                	// admin page slug, unique ID
          'clea_presentation_options_page'          // callback function to display the options page
    );

}

function clea_presentation_settings_section_1_init(  ) { 

	global $setting_page ;
	global $setting_group ;
	global $setting_name ;
	
	// add the sections
	add_settings_section( 
		'our_first_section', 
		__( 'My First Section Title', 'clea-presentation' ), 
		'clea_presentation_settings_section_callback' , 
		$setting_page 		// menu slug
	);

	add_settings_section( 
		'our_second_section', 
		__( 'My second Section Title', 'clea-presentation' ), 
		'clea_presentation_settings_section_callback' , 
		$setting_page 
	);
	
	add_settings_section( 
		'our_third_section', 
		__( 'My third Section Title', 'clea-presentation' ),  
		'clea_presentation_settings_section_callback' , 
		$setting_page 
	);

	// add the fields
	add_settings_field( 
		'clea_presentation_text_field_0', 
		__( 'Field 0 description', 'clea-presentation' ), 
		'clea_presentation_text_field_0_render', 
		$setting_page, 
		'our_first_section',
		array (
            'label_for'   => 'label1', // makes the field name clickable,
            'name'        => 'text', // value for 'name' attribute
            'value'       => 'test value',
            'option_name' => 'reee'
        )
	);
	
	add_settings_field( 
		'clea_presentation_checkbox_field_1', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_presentation_checkbox_field_1_render', 
		$setting_page, 
		'our_first_section' 
	);

	add_settings_field( 
		'clea_presentation_radio_field_2', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_presentation_radio_field_2_render', 
		$setting_page, 
		'our_second_section' 
	);


	add_settings_field( 
		'clea_presentation_textarea_field_3', 
		__( 'Textarea field 3', 'clea-presentation' ), 
		'clea_presentation_textarea_field_3_render', 
		$setting_page, 
		'our_third_section' 
	);

	add_settings_field( 
		'clea_presentation_radio_field_4', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_presentation_radio_field_4_render', 
		$setting_page, 
		'our_third_section' 
	);

	add_settings_field( 
		'clea_presentation_select_field_5', 
		__( 'Settings field description', 'clea-presentation' ), 
		'clea_presentation_select_field_5_render', 
		$setting_page, 
		'our_third_section' 
	);

	add_settings_field( 
		'clea_presentation_text_field_2', 
		__( 'text field 2 description', 'clea-presentation' ), 
		'clea_presentation_text_field_2_render', 
		$setting_page, 
		'our_third_section' 
	);

	// register all the settings
	register_setting( $setting_group, $setting_page , 'clea_presentation_validator' ) ;
	
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


function clea_presentation_text_field_2_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<input type='text' name='<?php echo $setting_page ?>[clea_presentation_text_field_2]' value='<?php echo sanitize_text_field( $options['clea_presentation_text_field_2'] ); ?>'>
	<?php

}

function clea_presentation_text_field_0_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<input type='text' name='<?php echo $setting_page ?>[clea_presentation_text_field_0]' value='<?php echo sanitize_text_field( $options['clea_presentation_text_field_0'] ); ?>'>
	<?php
}


function clea_presentation_checkbox_field_1_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<input type='checkbox' name='<?php echo $setting_page ?>[clea_presentation_checkbox_field_1]' <?php checked( $options['clea_presentation_checkbox_field_1'], 1 ); ?> value='1'>
	<?php

}


function clea_presentation_radio_field_2_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<input type='radio' name='<?php echo $setting_page ?>[clea_presentation_radio_field_2]' <?php checked( $options['clea_presentation_radio_field_2'], 1 ); ?> value='1'>
	<?php

}


function clea_presentation_textarea_field_3_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<textarea cols='40' rows='5' name='<?php echo $setting_page ?>[clea_presentation_textarea_field_3]'> 
		<?php echo sanitize_text_field( $options['clea_presentation_textarea_field_3'] ); ?>
 	</textarea>
	<?php

}


function clea_presentation_radio_field_4_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<input type='radio' name='<?php echo $setting_page ?>[clea_presentation_radio_field_4]' <?php checked( $options['clea_presentation_radio_field_4'], 1 ); ?> value='1'>
	<?php

}


function clea_presentation_select_field_5_render(  ) { 

	global $setting_page ;
	$options = get_option( $setting_page );
	?>
	<select name='<?php echo $setting_page ?>[clea_presentation_select_field_5]'>
		<option value='1' <?php selected( $options['clea_presentation_select_field_5'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['clea_presentation_select_field_5'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function clea_presentation_settings_section_callback( $arguments  ) { 

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


function clea_presentation_options_page(  ) { 

	global $setting_page ;
	?>
	<div class="wrap">
	<form action='options.php' method='post'>

		<h2>clea-presentation-settings</h2>

		<?php
		settings_fields( $setting_page );
		do_settings_sections( $setting_page );
		submit_button();
		?>

	</form>
	</div>
	<?php

}

