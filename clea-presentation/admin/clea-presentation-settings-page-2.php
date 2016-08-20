<?php
/**
 *
 * Générer une page de réglage de l'extension
 * http://wordpress.stackexchange.com/questions/143263/cant-output-do-settings-sections-cant-understand-why
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.8.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */


/* Hook to admin_menu the yasr_add_pages function above */
add_action( 'admin_menu', 'yasr_add_pages' );

function yasr_add_pages() {

	// Add settings Page
	add_submenu_page(
          'edit.php?post_type=presentation', 							// plugin menu slug
          __( 'Yet option page', 'clea-presentation' ), 				// page title
          __( 'Yet Options', 'clea-presentation' ), 					// menu title
          'manage_options',               		// capability required to see the page
          'yasr_settings_page',                	// admin page slug, unique ID
          'yasr_settings_page_content'          // callback function to display the options page
    );

}

add_action( 'admin_init', 'yasr_multi_form_init' );

function yasr_multi_form_init() {
    register_setting(
        'yasr_multi_form', // A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
        'yasr_multi_form_data' //The name of an option to sanitize and save.
    );

    add_settings_section( 'yasr_section_id', 'Gestione Multi Set', 'yasr_section_callback', 'yasr_settings_page' );
    add_settings_field( 'yasr_field_name_id', 'Nome Set', 'yasr_nome_callback', 'yasr_settings_page', 'yasr_section_id' );
}

function yasr_section_callback() {
    "<h2>" . __( 'Description Section', 'clea-presentation' ) . "</h2>";
}

function yasr_nome_callback() {
    $option = get_option( 'yasr_multi_form_data' );
    $name   = esc_attr( $option['name'] );
    echo "<input type='text' name='yasr_multi_form_data[name]' value='$option' />";
}

/* Settings Page Content */
function yasr_settings_page_content() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'yasr' ) );
    }
    ?>
	 <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		  <div class="updated fade"><p><strong><?php _e( 'yasr Options saved!', 'clea-presentation' ); ?></strong></p></div>
	 <?php endif; ?>
	
    <div class="wrap">
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

        <form action="options.php" method="post">
            <?php
            settings_fields( 'yasr_multi_form' );
            do_settings_sections( 'yasr_settings_page' );
            submit_button( );
            ?>
        </form>
    </div>

<?php
} //End yasr_settings_page_content