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
<p> voir plus bas pour tous les essais de présentations selon d'autres critères </p>
</br>
	<h3> la présentation standard, sans tri par famille ou groupe</h3>

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
					<div class="posts-wrapper">
					<div class="image-holder">
						<?php if ( has_post_thumbnail() ) { the_post_thumbnail(  'thumbnail' ); } ?>
					</div>
					<div class = "text-holder">
						<a class="post-title" href="<?php the_permalink() ; ?>" title="<?php the_title() ; ?>" ><h3><?php the_title() ?></h3></a>
						<h4>Le résumé </h4>
						<?php the_excerpt(); ?>
						<h4>La baseline </h4>
						<?php echo esc_html( get_post_meta( get_the_ID(), 'ald_baseline2', true ) ); ?>
					</div>
					</div>
			<?php			
				}
			}
			else {
				echo 'Il n\'y a aucune page produit!';
			}
		  ?>
</div>
</div>
	<?php wp_reset_query(); ?>
	<?php wp_reset_postdata(); ?>

	<H3 style="margin-top: 90px;" >Test de tri par famille et groupe</H3>
	<h6>Noter que </h6>
	<ul>
		<li>pour le résumé, c'est le contenu de la case "extrait" si elle est remplie, sinon c'est un bout du contenu de l'article.</li>
		<li> et la baseline est bien indiquée !!!</li>
	</ul>
		</br>
	<h3> essai de présenter les familles et groupes</h3>
	<hr />
	<h4> Toutes les taxomomies existantes</h4>
	<?php
	// source http://codex.wordpress.org/Function_Reference/get_taxonomies
	// visualiser par taxonomie
	// will Output a list all registered taxonomies
	$taxonomies = get_taxonomies(); 
	foreach ( $taxonomies as $taxonomy ) {
		echo '<p>' . $taxonomy . '</p>';
	}
	?>
	<hr />
	<h4> Les éléments de la taxonomie Famille</h4>
	<p> Uniquement ceux qui ont au moins un article </p>
	<?php
	// source http://codex.wordpress.org/Function_Reference/get_terms
	// List all the terms in a custom taxonomy, without a link:
	$terms = get_terms( 'Famille' );
	 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		 echo '<ul>';
		 foreach ( $terms as $term ) {
		   echo '<li>' . $term->name . '</li>';
			
		 }
		 echo '</ul>';
	 }
	?>
	<hr />
	<h4> Les éléments de la taxonomie Groupe</h4>
	<p> Uniquement ceux qui ont au moins un article </p>
	<?php
	$terms = get_terms( 'Groupe' );
	 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		 echo '<ul>';
		 foreach ( $terms as $term ) {
		   echo '<li>' . $term->name . '</li>';
			
		 }
		 echo '</ul>';
	 }
	?>
	
	<hr />
	<h4> Un élement déroulant pour "Famille" avec bouton submit, sans javascript</h4>
	<p> pour tous les éléments, même sans article lié </p>
	<?php
	// source http://codex.wordpress.org/Function_Reference/wp_dropdown_categories
	// Dropdown with Submit Button
	// Displays a hierarchical category dropdown list in HTML form with a submit button, in a WordPress sidebar unordered list, with a count of posts in each category.
	
	$args = array(
		'show_count' 	=> 1,
		'hierarchical'	=> 1,
		'hide_if_empty'	=> false,
		'taxonomy'      => 'Famille',
	);
	?>
	<li id="categories">
		<h2><?php _e( 'Categories:' ); ?></h2>
		<form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<?php wp_dropdown_categories( $args ); ?>
			<input type="submit" name="submit" value="view" />
		</form>
	</li>
	
	<hr />
	<h4> Un élement déroulant pour "Groupe" avec bouton submit, AVEC javascript</h4>
	<p> pour tous les éléments, même sans article lié </p>
	<!--  source http://codex.wordpress.org/Function_Reference/wp_dropdown_categories
	// Dropdown without a Submit Button using JavaScript -->
	<li id="categories">
	<h2><?php _e( 'Posts by Groupe' ); ?></h2>
	<form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<?php
		$args = array(
			'show_option_none' 	=> __( 'Select category' ),
			'show_count'       	=> 1,
			'orderby'          	=> 'name',
			'echo'             	=> 0,
			'hierarchical'		=> 1,
			'hide_if_empty'		=> false,
			'taxonomy'      	=> 'Groupe',
		);
		?>

		<?php $select  = wp_dropdown_categories( $args ); ?>
		<?php $replace = "<select$1 onchange='return this.form.submit()'>"; ?>
		<?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>

		<?php echo $select; ?>

		<noscript>
			<input type="submit" value="View" />
		</noscript>

	</form>
	</li>

	<hr />
	<h4> liste de tous les éléments pour lesquels Famille = famille1</h4>
	
	<?php
	$args = array(
		'post_type' => 'presentation',
		'tax_query' => array(
			array(
			  'taxonomy' => 'Famille',
			  'field' => 'slug',
			  'terms' => 'famille1'
			) 
		)
	);
	
	$products = new WP_Query( $args );
	if( $products->have_posts() ) {
		while( $products->have_posts() ) {
			$products->the_post();
			?>
			<div class="posts-wrapper">
			<div class="image-holder">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail(  'thumbnail' ); } ?>
			</div>
			<div class = "text-holder">
				<a class="post-title" href="<?php the_permalink() ; ?>" title="<?php the_title() ; ?>" ><h3><?php the_title() ?></h3></a>
				<h4>Le résumé </h4>
				<?php the_excerpt(); ?>
				<h4>La baseline </h4>
				<?php echo esc_html( get_post_meta( get_the_ID(), 'ald_baseline2', true ) ); ?>
			</div>
			</div>
	<?php			
		}
	}
	else {
		echo 'Il n\'y a aucune page produit! correspondant à ' . $taxonomy . ' = ' . $terms . ' !';
	}
  ?>
</div>
</div>
	<?php wp_reset_query(); ?>
	<?php wp_reset_postdata(); ?>
	
	


	
	<hr />
	
	
<!-- Début de tout le fooder -------------------------------------->	
<?php get_footer(); ?>