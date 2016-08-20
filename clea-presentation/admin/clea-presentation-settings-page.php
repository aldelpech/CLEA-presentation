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
	add_submenu_page(
		'edit.php?post_type=presentation', 
		'Titre', 
		'Options', 
		'manage_options', 
		'clea-presentation-menu2', 
		'clea_presentation_plugin_options' 
	);

	// Add another submenu (test 2)
	add_submenu_page(
          'edit.php?post_type=presentation', 	// plugin menu slug
          __( 'WPORG Options', 'wporg' ), // page title
          __( 'WPORG Options', 'wporg' ), // menu title
          'manage_options',               // capability required to see the page
          'wporg_options',                // admin page slug, e.g. options-general.php?page=wporg_options
          'wporg_options_page'            // callback function to display the options page
    );
	
}

/* TEST 2 
* 
* source https://developer.wordpress.org/plugins/settings/creating-and-using-options/
*/
/**
 * Register the settings
 */
function wporg_register_settings() {

    register_setting(
        'wporg_options',  // settings section
        'wporg_hide_meta' // setting name
     );
	 
	 
}
add_action( 'admin_init', 'wporg_register_settings' );
 
/**
 * Build the options page
 */
function wporg_options_page() {
     if ( ! isset( $_REQUEST['settings-updated'] ) )
          $_REQUEST['settings-updated'] = false; ?>
 
     <div class="wrap">
 
          <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
               <div class="updated fade"><p><strong><?php _e( 'WPORG Options saved!', 'wporg' ); ?></strong></p></div>
          <?php endif; ?>
           
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
           
          <div id="poststuff">
               <div id="post-body">
                    <div id="post-body-content">
                         <form method="post" action="options.php">
                              <?php settings_fields( 'wporg_options' ); ?>
                              <?php $options = get_option( 'wporg_hide_meta' ); ?>
                              <table class="form-table">
                                   <tr valign="top"><th scope="row"><?php _e( 'Hide the post meta information on posts?', 'wporg' ); ?></th>
                                        <td>
                                             <select name="wporg_hide_meta[hide_meta]" id="hide-meta">
                                                  <?php $selected = $options['hide_meta']; ?>
                                                  <option value="1" <?php selected( $selected, 1 ); ?> >Yes, hide the post meta!</option>
                                                  <option value="0" <?php selected( $selected, 0 ); ?> >No, show my post meta!</option>
                                             </select><br />
                                             <label class="description" for="wporg_hide_meta[hide_meta]"><?php _e( 'Toggles whether or not to display post meta under posts.', 'wporg' ); ?></label>
                                        </td>
                                   </tr>
                              </table>
							  <?php submit_button(); ?>
                         </form>
                    </div> <!-- end post-body-content -->
               </div> <!-- end post-body -->
          </div> <!-- end poststuff -->
     </div>
<?php
}

/* TEST 1 */
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