<?php
/*
Template Name: pages d'archive des présentations
*
*  @package    clea-presentation
*/
get_header(); // up to <div id="main" class="main"> and breadcrumbs?>

<?php // if (  ) : ?>
<h1><?php post_type_archive_title(); ?></h1>

<h3>DEBUG</h3>
<?php 

$options = get_option( 'clea_presentation_settings' ); 
$obj = get_post_type_object( 'presentation' );

echo "<hr /><p>Options des settings</p>" ;
var_dump( $options ) ;
echo "<hr /><p>Options du custom post type</p>" ;
print_r( $obj ) ;

?>
<br />
<hr />

	
	
<!-- Début de tout le fooder -------------------------------------->	
<?php get_sidebar(); ?>
<?php get_footer(); ?>	