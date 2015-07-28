<?php
/*
Template Name: pages d'archive des présentations
*/
get_header(); ?>
    
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/ald.css' ,  __FILE__ ); ?>">
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/themes/default.css' ,  __FILE__ ); ?>">
	
<div class="two_third">

<!-- Fin de tout le header -------------------------------------->
	<H3 style="margin-top: 90px;" >This is CB's archive product Page Example stored in the plugin directory</H3>
	<h6>Noter que pour le résumé, c'est le contenu de la case "extrait" si elle est remplie, sinon c'est un bout du contenu de l'article.</h6>
	<h6> et la baseline est bien indiquée !!!</h6>
		</br>
		<?php
			$args = array(
			  'post_type' => 'presentation',
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
					<div class="row widget-area" role="complementary">
					<div class="span4" style="display: inline-block; height: 200px;">
					<div class="thumb-wrapper ">
						<a class="home round-div" href="<?php the_permalink(); ?>" title="<?php the_title() ; ?>" ></a> <?php if ( has_post_thumbnail() ) { the_post_thumbnail(  'thumbnail' ); } ?>              
					</div></div>
					<div class="span4" style="display: inline-block; height: 200px;">
					<h1><?php the_title() ?></h1>
					<div class='content'>Le résumé : 
						<?php the_excerpt() ?>
					</div>
					<div class='baseline'>
						<h3>La baseline :</h3>
						<?php
						echo esc_html( get_post_meta( get_the_ID(), 'ald_baseline2', true ) );
					?>
					</div>
					</div></div>
					<hr>
				<?php	
				}
			}
			else {
				echo 'Oh ohm no products!';
			}
		  ?>

	<?php wp_reset_query(); ?>
	<?php wp_reset_postdata(); ?>


<!-- -------------------------------------->

	
	
<!-- Début de tout le fooder -------------------------------------->	
<?php get_footer(); ?>
