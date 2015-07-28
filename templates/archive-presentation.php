<?php
/*
Template Name: pages d'archive des présentations
*/
get_header(); ?>

<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/ald.css' ,  __FILE__ ); ?>">
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/themes/default.css' ,  __FILE__ ); ?>">
	
<div class="container" role="main">
<div class="ald-presentation-archive">
<!-- Fin de tout le header -------------------------------------->
<h1>L'offre CLEA</h1>
<p id="baseline"> Toutes les étapes de votre marketing web : du site "plaquette" au site "communicant"</p>
<img class="alignnone size-full wp-image-446" src="http://knowledge.parcours-performance.com/wp-content/uploads/2014/12/Offre-CLEA.png" alt="L'offre CLEA pour un site communicant, authentique et professionnel" width="656" height="402" />

<h2>En résumé :</h2>
<?php echo do_shortcode( '[easy-pricing-table id="299"]' ); ?>


<hr/>
<h2>Les produits présentés élégamment</h2>
<div class="row">
	<div class="sixteen columns">
<?php 
$args = array(
			  'post_type' => 'presentation',
			  'orderby' => 'menu_order', //Edit Page Attributes box
			  'order'   => 'ASC',
			  /* 'tax_query' => array(
				array(
				  'taxonomy' => 'product_category',
				  'field' => 'slug',
				  'terms' => 'boardgames'
				) 
			  ) */
			);
$products = new WP_Query( $args );
	if( $products->have_posts() ) {
		while( $products->have_posts() ) {
			$products->the_post();
			?>
		<div class="recent-work">
			<div class="rk-thumb">
				<?php 
				if ( has_post_thumbnail() ) { 
					the_post_thumbnail( 'medium' );
				} ?>					
				</div><!-- .rk-thumb -->
			<div class="rk-content">
				<a class="post-title" href="<?php the_permalink() ; ?>" title="<?php the_title() ; ?>" ><h3><?php the_title() ?></h3></a>
				<p id="baseline"><?php echo esc_html( get_post_meta( get_the_ID(), 'ald_baseline2', true ) ); ?></p>
			</div><!-- .rk-content -->
		</div>
	<?php			
		}	// end while
	} else {	// endif
		echo 'Il n\'y a aucune page produit!';
	} 			// end if else  
	?>
	</div><!-- .sixteen columns -->
</div>	<!-- end row -->
<hr/>
<h2>Les produits présentés plus classiquement</h2>

	<?php
			
$products = new WP_Query( $args );
	if( $products->have_posts() ) {
		while( $products->have_posts() ) {
			$products->the_post();
			?>
			<div class="posts-wrapper">
			<div class="image-holder">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail(  'medium' ); } ?>
			</div>
			<div class = "text-holder">
				<a class="post-title" href="<?php the_permalink() ; ?>" title="<?php the_title() ; ?>" ><h3><?php the_title() ?></h3></a>
				<p id="baseline"><?php echo esc_html( get_post_meta( get_the_ID(), 'ald_baseline2', true ) ); ?></p>
				<p id="excerpt"><?php the_excerpt(); ?></p>
				
			</div>
			</div>
	<?php			
		}
	}
	else {
		echo 'Il n\'y a aucune page produit!';
	}
	?>
<hr/>	
Lien vers <a title="construisez votre demande de devis personnalisé" href="http://knowledge.parcours-performance.com/devis/" target="_blank">demander un devis</a>
</div>  <!-- end ald-presentation-archive -->
</div>  <!-- end container -->
	<?php wp_reset_query(); ?>
	<?php wp_reset_postdata(); ?>

	
	
<!-- Début de tout le fooder -------------------------------------->	
<?php get_footer(); ?>