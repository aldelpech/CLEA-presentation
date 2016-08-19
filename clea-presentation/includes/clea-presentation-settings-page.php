<?php
/**
 *
 * créer une page de réglage pour l'extension
 * utilise des classes placées dans /test1/wp-content/plugins/clea-presentation/library/apf 
 * et générées avec l'extension Admin Page Framework 
 * https://wordpress.org/plugins/admin-page-framework/
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.8.0
 *
 * @package    clea-presentation
 * @subpackage clea-presentation/includes
 */

// source code is http://admin-page-framework.michaeluno.jp/tutorials/01-create-a-wordpress-admin-page/

include( dirname( __FILE__ ) . '/library/apf/admin-page-framework.php' );
    
// Extend the class
class CLEA_PRES_CreatePage extends AdminPageFramework {
    
    /**
     * The set-up method which is triggered automatically with the 'wp_loaded' hook.
     * 
     * Here we define the setup() method to set how many pages, page titles and icons etc.
     */
    public function setUp() {
       
        // Create the root menu - specifies to which parent menu to add.
        $this->setRootMenuPage( 'Settings' );  
 
        // Add the sub menus and the pages.
        $this->addSubMenuItems(
            array(
                'title'     => '1. My First Setting Page',  // page and menu title
                'page_slug' => 'my_first_settings_page'     // page slug
            )
        );
 
    }
 
    /**
     * One of the pre-defined methods which is triggered when the page contents is going to be rendered.
     * 
     * Notice that the name of the method is 'do_' + the page slug.
     * So the slug should not contain characters which cannot be used in function names such as dots and hyphens.
     */    
    public function do_my_first_settings_page() {   
 
        ?>
        <h3>Action Hook</h3>
        <p>This is inserted by the 'do_' + page slug method.</p>
        <?php
 
    }
 
}
 
// Instantiate the class object.
new CLEA_PRES_CreatePage; 

?>