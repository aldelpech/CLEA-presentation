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
$setting_group = 'clea_pres_group';	// the group used for setting_fields 
$setting_name = 'clea_presentation';	// the name in the $options[] 

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
		__( 'Settings field description', 'clea-presentation' ), 
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
		__( 'Settings field description', 'clea-presentation' ), 
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
		__( 'Settings field 2 description', 'clea-presentation' ), 
		'clea_presentation_text_field_2_render', 
		$setting_page, 
		'our_third_section' 
	);

	// register all the settings
	register_setting( $setting_group, 'our_first_section' , NULL ) ;
	register_setting( $setting_group, 'our_second_section' , NULL ) ;
	register_setting( $setting_group, 'our_third_section' , NULL ) ;
	
}

function clea_presentation_text_field_2_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	?>
	<input type='text' name='clea_presentation_settings[clea_presentation_text_field_2]' value='<?php echo $options['clea_presentation_text_field_2']; ?>'>
	<?php

}

function clea_presentation_text_field_0_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	printf(
        '<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
        $args['option_name'],
        $args['name'],
        $args['label_for'],
        $args['value']
    );

}


function clea_presentation_checkbox_field_1_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	?>
	<input type='checkbox' name='clea_presentation_settings[clea_presentation_checkbox_field_1]' <?php checked( $options['clea_presentation_checkbox_field_1'], 1 ); ?> value='1'>
	<?php

}


function clea_presentation_radio_field_2_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	?>
	<input type='radio' name='clea_presentation_settings[clea_presentation_radio_field_2]' <?php checked( $options['clea_presentation_radio_field_2'], 1 ); ?> value='1'>
	<?php

}


function clea_presentation_textarea_field_3_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	?>
	<textarea cols='40' rows='5' name='clea_presentation_settings[clea_presentation_textarea_field_3]'> 
		<?php echo $options['clea_presentation_textarea_field_3']; ?>
 	</textarea>
	<?php

}


function clea_presentation_radio_field_4_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	?>
	<input type='radio' name='clea_presentation_settings[clea_presentation_radio_field_4]' <?php checked( $options['clea_presentation_radio_field_4'], 1 ); ?> value='1'>
	<?php

}


function clea_presentation_select_field_5_render(  ) { 

	global $setting_group ;
	$options = get_option( $setting_group );
	?>
	<select name='clea_presentation_settings[clea_presentation_select_field_5]'>
		<option value='1' <?php selected( $options['clea_presentation_select_field_5'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['clea_presentation_select_field_5'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function clea_presentation_settings_section_callback( $arguments  ) { 

	switch( $arguments['id'] ){
		case 'our_first_section':
			$description = 'This is the first description here!';
			break;
		case 'our_second_section':
			$description =  'This one is number two';
			break;
		case 'our_third_section':
			$description = 'Third time is the charm!';
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

