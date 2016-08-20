<?php
/**
 *
 * Générer les custom post types et leurs taxonomies
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.7.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */




	
// functions which create custom posts and taxonomies
function clea_presentation_custom_types() {
// Register Custom Post Type "presentation"
	$p_labels = array(
		'name'                => _x( 'Présentations', 'Post Type General Name', 'clea-presentation' ),
		'singular_name'       => _x( 'Présentation', 'Post Type Singular Name', 'clea-presentation' ),
		'menu_name'           => __( 'Pages Produit', 'clea-presentation' ),
		'parent_item_colon'   => __( 'Elément parent :', 'clea-presentation' ),
		'all_items'           => __( 'tous les produits', 'clea-presentation' ),
		'view_item'           => __( 'Voir le produit', 'clea-presentation' ),
		'add_new_item'        => __( 'Ajouter un nouveau produit', 'clea-presentation' ),
		'add_new'             => __( 'Nouveau produit', 'clea-presentation' ),
		'edit_item'           => __( 'Editer le produit', 'clea-presentation' ),
		'update_item'         => __( 'Mettre à jour le produit', 'clea-presentation' ),
		'search_items'        => __( 'Search Item', 'clea-presentation' ),
		'not_found'           => __( 'Not found', 'clea-presentation' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'clea-presentation' ),
	);
	
	$p_args = array(
		'label'               => __( 'presentations', 'clea-presentation' ),
		'description'         => __( 'A collection of slides forming a presentation', 'clea-presentation' ),
		'labels'              => $p_labels,
		'supports'            => array( 
			'title', 					// Text input field to create a post title
			'editor', 					// Content input box for writing
			/* 'comments',*/			// Ability to turn comments on/off
			/* 'trackbacks',	*/		// Ability to turn trackbacks and pingbacks on/off
			/* 'revisions',	*/			// Allows revisions to be made of your post
			/* 'author', */				// Displays a select box for changing the post author
			/* 'excerpt', (see line 520 and below) */	// A textarea for writing a custom excerpt
			'thumbnail',				// The thumbnail (featured image in 3.0) uploading box
			/* 'custom-fields',	*/		// Custom fields input area
			'page-attributes', 			// attributes box shown for pages. important for hierarchical post types, so you can select the parent post
		),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,			// true
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 20,			// 20 = sous "pages"
		'menu_icon'           => 'dashicons-randomize',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	
	register_post_type( 'presentation', $p_args );

	// Register Custom Post Type "slides"
	$labels = array(
		'name'                => _x( 'Ecrans', 'Post Type General Name', 'clea-presentation' ),
		'singular_name'       => _x( 'Ecran', 'Post Type Singular Name', 'clea-presentation' ),
		'menu_name'           => __( 'Slides', 'clea-presentation' ),
		'parent_item_colon'   => __( 'Parent Item:', 'clea-presentation' ),
		'all_items'           => __( 'Les écrans', 'clea-presentation' ),
		'view_item'           => __( 'View Item', 'clea-presentation' ),
		'add_new_item'        => __( 'Ajouter un écran', 'clea-presentation' ),
		'add_new'             => __( 'Nouvel écran', 'clea-presentation' ),
		'edit_item'           => __( 'Editer l\'écran', 'clea-presentation' ),
		'update_item'         => __( 'Update Item', 'clea-presentation' ),
		'search_items'        => __( 'Search Item', 'clea-presentation' ),
		'not_found'           => __( 'Not found', 'clea-presentation' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'clea-presentation' ),
	);
	$args = array(
		'label'               => __( 'slides', 'clea-presentation' ),
		'description'         => __( 'A individual slide', 'clea-presentation' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php?post_type=presentation', // show in menu presentation
		'map_meta_cap'        => true, // bool (defaults to FALSE) //Whether WordPress should map the meta capabilities (edit_post, read_post, delete_post) for you
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
		'query_var'			  => true,
		);
	register_post_type( 'slide', $args );
}
	
/* create two taxonomies
* create a separate taxonomy named “Product Categories” to house categories 
* you only use for products 
* Voir www.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/ 
* voir aussi http://www.smashingmagazine.com/2012/01/04/create-custom-taxonomies-wordpress/ */

function clea_presentation_taxonomy1() {
	// taxonomie 1
	$labels = array(
		'name'              => _x( 'Famille', 'taxonomy general name' ),
		'singular_name'     => _x( 'Famille de produit', 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher les familles' ),
		'all_items'         => __( 'Toutes les familles de produit' ),
		'parent_item'       => __( 'Famille mère' ),
		'parent_item_colon' => __( 'Famille mère :' ),
		'edit_item'         => __( 'Editer la famille' ), 
		'update_item'       => __( 'Mettre à jour la famille' ),
		'add_new_item'      => __( 'Ajouter une nouvelle famille' ),
		'new_item_name'     => __( 'Nouvelle famille' ),
		'menu_name'         => __( 'Famille' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'hierarchical' 		=> true,
		'show_in_nav_menus' => false,
	);
	register_taxonomy( 'Famille', 'presentation', $args );
}

function clea_presentation_taxonomy2() {
// taxonomie 2
	$labels = array(
		'name'              => _x( 'Groupe', 'taxonomy general name' ),
		'singular_name'     => _x( 'Groupe de produit', 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher les groupes' ),
		'all_items'         => __( 'Tous les groupes de produit' ),
		'parent_item'       => __( 'Groupe père' ),
		'parent_item_colon' => __( 'Groupe père :' ),
		'edit_item'         => __( 'Editer le groupe' ), 
		'update_item'       => __( 'Mettre à jour le groupe' ),
		'add_new_item'      => __( 'Ajouter un nouveau groupe' ),
		'new_item_name'     => __( 'Nouveau groupe' ),
		'menu_name'         => __( 'Groupe' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'hierarchical' 		=> true,
		'show_in_nav_menus' => false,
	);
	register_taxonomy( 'Groupe', 'presentation', $args );
}

 
function clea_presentation_thumbnails() {
	// add theme support for thumbnails in these custom post types
	// source https://wordpress.org/support/topic/custom-post-type-ui-featured-image-not-showing

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails', array( 'presentation', 'page', 'post' ) );
}
 
 
// hat-tip to Justin Tadlock http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child
/* Creates the slide meta boxes. */
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

function clea_presentation_editor_meta_box( $post ) {
	// the editor was unset. We reset it only after adding all the metaboxes	
	echo '<div class="wp-editor-wrap">';
	wp_editor($post->post_content,'content');
	echo '</div>';
}

// change the background color of the "slide" editor
add_action( 'admin_head', 'clea_presentation_action_admin_head'); //white background

function clea_presentation_action_admin_head() {
	?>
	<style type="text/css">
		#ald_content {background-color:azure;}
	</style>
	<?php
}

// change the default title for both slides and presentations
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
add_filter( 'enter_title_here', 'clea_presentation_change_default_title' );


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

/* Hook meta box to just the 'slide' post type. */
add_action( 'add_meta_boxes_slide' , 'clea_presentation_slides_add_meta_boxes', 0 );

/* Add the saving of the slideorder to save_post action */
add_action( 'save_post' , 'clea_presentation_save_slideorder' );


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

add_action( 'manage_slide_posts_custom_column' , 'clea_presentation_custom_columns', 10, 2 );

/* Add custom column to slide list */
function clea_presentation_add_slide_column( $columns ) {

    return array_merge( $columns, 
        array( 'presentation' => __( 'Presentation', 'clea-presentation' ),
        		'slideorder' => __( 'Order', 'clea-presentation' ),
        ) 
    );

}

add_filter( 'manage_slide_posts_columns' , 'clea_presentation_add_slide_column' );

function clea_presentation_sortable_slide_columns( $columns ) {

    $columns['presentation'] = 'post_parent';
    $columns['slideorder'] = 'slideorder';
     
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}

add_filter( 'manage_edit-slide_sortable_columns', 'clea_presentation_sortable_slide_columns' );

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

add_action( 'pre_get_posts', 'clea_presentation_slide_list_queries' );

function clea_presentation_edit_slides_orderby($orderby_statement) {

    global $pagenow;
    
    if ( !is_admin() ) return $orderby_statement;
    
    if ( 'edit.php' !== $pagenow) return $orderby_statement;
    
    if ( !isset( $_REQUEST['post_type'] ) || $_REQUEST['post_type'] != 'slide' ) return $orderby_statement;

	$orderby_statement = "post_parent DESC, " . $orderby_statement;
	return $orderby_statement;

}

add_filter( 'posts_orderby', 'clea_presentation_edit_slides_orderby' );
 
	/* inspiré de la réponse de Michal Mau sur 
	http://wordpress.stackexchange.com/questions/12295/creating-a-default-custom-post-template-that-a-theme-can-override
	* et pour le choix entre le template du thème et celui du plugin, de 
	* http://code.tutsplus.com/articles/plugin-templating-within-wordpress--wp-31088
	* fonctionne si on place un fichier single-presentation.php dans un répertoire 
	* ald-presentation-template du thème utilisé
	*/

	# Template for displaying a single product
	add_filter( 'single_template', 'clea_presentation_get_single_presentation' ) ;
	
	
	function clea_presentation_get_single_presentation( $single_template ) {
		global $post;           
		$template = 'single-presentation.php' ;
		if ( $post->post_type == 'presentation' ) {
			if ( $theme_file = locate_template( array( 'ald-presentation-template/' . $template ) ) ) {
				$single_template = $theme_file;
			}
			else {
				$single_template = dirname( __FILE__ ) . '/templates/' . $template ;
			}
		}
		return $single_template;
	}

	# Template for displaying the product (presentation) archive
	add_filter( 'archive_template', 'clea_presentation_get_archive_presentation' )  ;

	function clea_presentation_get_archive_presentation( $archive_template ) {
		global $post;
		$template = 'archive-presentation.php' ;
		if ( ( is_post_type_archive() ) && ( $post->post_type == 'presentation' ) ) { 
			if ( $theme_file = locate_template( array( 'ald-presentation-template/' . $template ) ) ) {
				$archive_template = $theme_file;
			}
			else {
				$archive_template = dirname( __FILE__ ) . '/templates/' . $template ;
			}
			
		}
		return $archive_template;
	}
	

/***************************************************************************************
* ajouter une metabox "baseline2' dans le custom post présentation
* et ordonner les boxes dans l'ordre de remplissage
***************************************************************************************/

/***************************************************
* NAMING THE METABOXES
* http://www.wproots.com/complex-meta-boxes-in-wordpress/
* if two meta boxes have identical $context and $priority, the meta boxes will be arranged 
* alphanumerically according to the $id argument, with “a” and “0? being highest and “z” 
* and “8” being the lowest
****************************************************/

/* -------------------------------------
* Baseline 
* selon auteur Daniel Pataki
* http://www.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/
--------------------------------------*/
/* create the metabox */

// place la baseline et le résumé juste en dessous du titre en principe
// voir 

add_action( 'edit_form_after_title', 'clea_presentation_baseline2_box' );

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
	
// change the description below the excerpt
// see http://jetpack.wp-a2z.org/oik_api/post_excerpt_meta_box/
function clea_presentation_post_excerpt_meta_box( $post ) {	
	?><label class="screen-reader-text" for="excerpt"><?php _e('Excerpt') ?></label><textarea rows="1" cols="40" name="excerpt" id="excerpt"><?php echo $post->post_excerpt; // textarea_escaped ?></textarea>
<p><?php _e('Le résumé qui apparaîtra sur la page de synthèse des produits'); ?></p>
<?php
}

// move SEO at the bottom of the page 
// http://wordpress.org/support/topic/plugin-wordpress-seo-by-yoast-change-where-yoast-meta-box-is-positioned-on-all-pagesposttypes
function ald_yoast_tobottom() {
	$screen = get_current_screen();
	if  ( 'presentation' == $screen->post_type ) {
		return 'low';
	} else {
		return 'high';
	}
}

add_filter( 'wpseo_metabox_prio', 'ald_yoast_tobottom');

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
 
 /* handle submitted data */
 add_action( 'save_post', 'clea_presentation_baseline2_box_save' );
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


