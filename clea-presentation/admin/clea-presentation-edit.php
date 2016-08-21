<?php
/**
 *
 * meta box et autres pour l'édition de présentations et slides
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.9.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */


/* Hook meta box to just the 'slide' post type. */
add_action( 'add_meta_boxes_slide' , 'clea_presentation_slides_add_meta_boxes', 0 ); 

// change the background color of the "slide" editor
add_action( 'admin_head', 'clea_presentation_action_admin_head'); //white background

// place la baseline et le résumé juste en dessous du titre
add_action( 'edit_form_after_title', 'clea_presentation_baseline2_box' );

// Handle baseline and excerpt when saved
add_action( 'save_post', 'clea_presentation_baseline2_box_save' );

//move SEO at the bottom of the page
add_filter( 'wpseo_metabox_prio', 'ald_yoast_tobottom');

// change the default title for both slides and presentations
add_filter( 'enter_title_here', 'clea_presentation_change_default_title' );

// Add the saving of the slideorder to save_post action 
add_action( 'save_post' , 'clea_presentation_save_slideorder' );

// Manage columns in presentation lists 
add_action( 'manage_slide_posts_custom_column' , 'clea_presentation_custom_columns', 10, 2 );
add_filter( 'manage_slide_posts_columns' , 'clea_presentation_add_slide_column' );
add_filter( 'manage_edit-slide_sortable_columns', 'clea_presentation_sortable_slide_columns' );
add_action( 'pre_get_posts', 'clea_presentation_slide_list_queries' );
add_filter( 'posts_orderby', 'clea_presentation_edit_slides_orderby' );

/**********************************************************************
*
* Manage columns in presentation lists 
*
**********************************************************************/
function clea_presentation_custom_columns( $column, $post_id ) {
    
    switch ( $column ) {

		case 'presentation' :
			$post_parent = get_post_field( 'post_parent' , $post_id );
	    	echo get_post_field( 'post_title' , $post_parent ); 
	    	break;    	

		case 'slideorder' :
	    	echo get_post_meta( $post_id , 'slideorder' , true ); 
	    	break;	  
    }
}

/* Add custom column to slide list */
function clea_presentation_add_slide_column( $columns ) {

    return array_merge( $columns, 
        array( 'presentation' => __( 'Presentation', 'clea-presentation' ),
        		'slideorder' => __( 'Order', 'clea-presentation' ),
        ) 
    );

}

function clea_presentation_sortable_slide_columns( $columns ) {

    $columns['presentation'] = 'post_parent';
    $columns['slideorder'] = 'slideorder';
     
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}

function clea_presentation_slide_list_queries( $query ) {
    
    global $pagenow;
    
    if ( !is_admin() ) return;
    
    if ( 'edit.php' !== $pagenow) return $query;
    
    if ( !isset( $_REQUEST['post_type'] ) || $_REQUEST['post_type'] != 'slide' ) return $query;
        
    $query->set('meta_key','slideorder');
    $query->set('orderby','meta_value_num');
    $query->set('order','ASC');
    
    return $query;
    
}

function clea_presentation_edit_slides_orderby($orderby_statement) {

    global $pagenow;
    
    if ( !is_admin() ) return $orderby_statement;
    
    if ( 'edit.php' !== $pagenow) return $orderby_statement;
    
    if ( !isset( $_REQUEST['post_type'] ) || $_REQUEST['post_type'] != 'slide' ) return $orderby_statement;

	$orderby_statement = "post_parent DESC, " . $orderby_statement;
	return $orderby_statement;

}


/**********************************************************************
*
* Save slide order when slide is saved
*
**********************************************************************/
function clea_presentation_save_slideorder( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['slide_order_nonce'] ) ) return $post_id;

  $nonce = $_POST['slide_order_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'clea_presentation_slide_order_metabox' ) ) return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  $slideorder = sanitize_text_field( $_POST['slideorder'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, 'slideorder', $slideorder );

}


/**********************************************************************
*
* change the default title for both slides and presentations
*
**********************************************************************/
function clea_presentation_change_default_title( $title ){
     $screen = get_current_screen();
     if  ( 'slide' == $screen->post_type ) {
          $title = 'Le titre de cet écran';
     }
     if  ( 'presentation' == $screen->post_type ) {
          $title = 'Le nom de ce produit';
     }
     return $title;
}

/**********************************************************************
*
* move SEO at the bottom of the page
* http://wordpress.org/support/topic/plugin-wordpress-seo-by-yoast-change-where-yoast-meta-box-is-positioned-on-all-pagesposttypes
*
**********************************************************************/
function ald_yoast_tobottom() {
	$screen = get_current_screen();
	if  ( 'presentation' == $screen->post_type ) {
		return 'low';
	} else {
		return 'high';
	}
}


/**********************************************************************
*
* Change the background color of the slider editor
*
**********************************************************************/
function clea_presentation_action_admin_head() {
	?>
	<style type="text/css">
		#ald_content {background-color:azure;}
	</style>
	<?php
}

/**********************************************************************
*
* Placer une éditeur pour la baseline et le résumé
*
* Baseline selon Daniel Pataki
* http://www.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/
*
**********************************************************************/
function clea_presentation_baseline2_box() {

	// see TroyDesign.IT solution for moving a metabox above the editor
	// http://wordpress.org/support/topic/move-custom-meta-box-above-editor
	// http://wordpress.stackexchange.com/questions/38562/how-to-customize-default-wordpress-editor
    global $_wp_post_type_features;
	
	// add the metaboxes
	
    add_meta_box( 
        'ald_baseline2_box',
        __( 'La Baseline', 'myplugin_textdomain' ),
        'clea_presentation_baseline2_box_content',
        'presentation',
        'normal',
        'high'
    );
	
	add_meta_box( 
		'postexcerpt', 
		__('Le résumé pour la page de synthèse'), 
		'clea_presentation_post_excerpt_meta_box', 	// 'post_excerpt_meta_box',
		'presentation', 
		'normal', 
		'core' 
	);
	
	// move content editor at the bottom of the page
	if (isset( $_wp_post_type_features['presentation']['editor'] ) 
		   && $_wp_post_type_features['presentation']['editor']) {
		// unset the editor before adding the metaboxes
		unset( $_wp_post_type_features['presentation']['editor'] );
		// ajouter la metabox avec l'éditeur
		add_meta_box(
            'ald_content',
            __('L\'écran 0 de la page produit'),
            'clea_presentation_editor_meta_box',  // array(&$this,'clea_presentation_editor_meta_box'),
            'presentation', 'normal', 'core'
        );
	}
}

/* define the content of the metabox */
 function clea_presentation_baseline2_box_content( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'ald_baseline2_box_content_nonce' );
  
  // Retrieves the stored value from the database
  $meta_value = get_post_meta( get_the_ID(), 'ald_baseline2', true );
  ?>
  <label for="ald_baseline2">Elle sert pour la page de synthèse</label>
  <input type="text" id="ald_baseline2" name="ald_baseline2" placeholder="baseline attirante ici" value="<?php echo $meta_value ; ?>" size="70%" />
  <?php
}

// change the description below the excerpt
// see http://jetpack.wp-a2z.org/oik_api/post_excerpt_meta_box/
function clea_presentation_post_excerpt_meta_box( $post ) {	
	?><label class="screen-reader-text" for="excerpt"><?php _e('Excerpt') ?></label><textarea rows="1" cols="40" name="excerpt" id="excerpt"><?php echo $post->post_excerpt; // textarea_escaped ?></textarea>
<p><?php _e('Le résumé qui apparaîtra sur la page de synthèse des produits'); ?></p>
<?php
}


function clea_presentation_editor_meta_box( $post ) {
	// the editor was unset. We reset it only after adding all the metaboxes	
	echo '<div class="wp-editor-wrap">';
	wp_editor($post->post_content,'content');
	echo '</div>';
}

/**********************************************************************
*
* Handle baseline and excerpt when saved
*
**********************************************************************/
function clea_presentation_baseline2_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( ! isset( $_POST['ald_baseline2_box_content_nonce'] ) 
	   || !wp_verify_nonce( $_POST['ald_baseline2_box_content_nonce'], plugin_basename( __FILE__ ) )
	 )
	return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $ald_baseline2 = $_POST['ald_baseline2'];
  update_post_meta( $post_id, 'ald_baseline2', $ald_baseline2 );
}


/**********************************************************************
*
* Create the slide metabox
*
* hat-tip to Justin Tadlock 
* http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child
*
**********************************************************************/
function clea_presentation_slides_add_meta_boxes( $post ) {  // will be hooked in the slide custom posts
	// see TroyDesign.IT solution for moving a metabox above the editor
	// http://wordpress.org/support/topic/move-custom-meta-box-above-editor
	// http://wordpress.stackexchange.com/questions/38562/how-to-customize-default-wordpress-editor
    global $_wp_post_type_features;
	
	// add the metaboxes
	add_meta_box(
		'slide-presentation',
		__( 'Présentation', 'clea-presentation' ),
		'clea_presentation_slide_presentation_metabox',	// the function called
		$post->post_type,				// renvoie le post-type du post en cours (slide normalement)
		'normal',						// 'side'
		'high'							// 'core'
    );
    
	add_meta_box(
        'slide-order',
        __( 'Ordre d\'écran', 'clea-presentation' ), 	// __( 'Slide Order', 'clea-presentation' ),
        'clea_presentation_slide_order_metabox',
        $post->post_type,
        'normal',						// 'side'
        'high'							// 'core'
    ); 	
	
	if (isset( $_wp_post_type_features['slide']['editor'] ) 
		   && $_wp_post_type_features['slide']['editor']) {
		// unset the editor before adding the metaboxes
		unset( $_wp_post_type_features['slide']['editor'] );
		// ajouter la metabox avec l'éditeur
		add_meta_box(
            'ald_content',
            __('Contenu de l\'écran'),
            'clea_presentation_editor_meta_box',  // array(&$this,'clea_presentation_editor_meta_box'),
            'slide', 'normal', 'core'
        );
	}
}

/* Displays the presentation meta box inside the slide edition page. */
function clea_presentation_slide_presentation_metabox( $post ) {

    $parents = get_posts(
        array(
            'post_type'   	=> 'presentation', 
            'orderby'     	=> 'title', 
            'order'       	=> 'ASC',
			'post_status'	=> array ( 'draft', 'publish' ),
            'numberposts' 	=> -1 
        )
    );

    if ( !empty( $parents ) ) {

        echo '<select name="parent_id" class="widefat">'; // !Important! Don't change the 'parent_id' name attribute.

        foreach ( $parents as $parent ) {
            printf( '<option value="%s"%s>%s</option>', esc_attr( $parent->ID ), selected( $parent->ID, $post->post_parent, false ), esc_html( $parent->post_title ) );
        }

        echo '</select>';
    }
}

/* Displays the slide order meta boxes. */
function clea_presentation_slide_order_metabox( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'clea_presentation_slide_order_metabox', 'slide_order_nonce' );

    $slideorder = get_post_meta( $post->ID, 'slideorder' , true );

    echo '<p><label for="slideorder">' . __( 'N° d\'ordre de l\'écran' ) . '</label>&nbsp;&nbsp;';
    echo '<input type="text" id="slideorder" name="slideorder" value="' . esc_attr( $slideorder ) . '" size="5" />';
	echo __( ' 1 pour l\'écran 1, 2 pour l\'écran 2, etc...</p>' ) ;
}