<?php
/**
 *
 * Générer une page de réglage de l'extension
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.8.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */


// source https://codex.wordpress.org/Administration_Menus

// create a menu page for this plugin
add_action( 'admin_menu', 'clea_presentation_plugin_menu' );

// add a link under the plugin name in the installed plugin page
// source is contact form 7 plugin !
add_filter( 'plugin_action_links', 'clea_presentation_add_action_links', 10, 2 );

function clea_presentation_plugin_menu(  ) { 

	// add option page in a custom post type menu block
	add_submenu_page('edit.php?post_type=presentation', 'Titre', 'Options', 'manage_options', 'clea-presentation-menu2', 'clea_presentation_plugin_options' );
	
}

function clea_presentation_plugin_options(  ) { 

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	// variables for the field and option names 
    $opt_name = 'mt_favorite_color';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name = 'mt_favorite_color';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put a "settings saved" message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'clea-presentation' ); ?></strong></p></div>
<?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Paramétrage des Présentations', 'clea-presentation' ) . "</h2>";

    // settings form
    
	echo "<br /> page URL :<br />" ;
	menu_page_url( 'clea-presentation-menu2', true ) ; 
	echo "<br /> " ;
	
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Favorite Color:", 'menu-test' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
	
}


function clea_presentation_add_action_links( $links, $file ) {
	if ( $file != CLEA_PRES_BASENAME )
		return $links;

	$settings_link = '<a href="' . menu_page_url( 'clea-presentation-menu2', false ) . '">'
		. esc_html( __( 'Settings', 'clea-presentation' ) ) . '</a>';

	array_unshift( $links, $settings_link );

	return $links;
}



?>