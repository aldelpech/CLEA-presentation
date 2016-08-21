<?php
/*
Template Name: page produits standard du plugin
*/
?>

<?php get_header(); ?>
    
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/ald.css' ,  __FILE__ ); ?>">
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/themes/default.css' ,  __FILE__ ); ?>">
	

	<div class="flowtime">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="ft-section" data-id="section-1">
		<h2>plugin's single presentation template</h2>
		<div id="/section-1/page-1" class="ft-page" data-id="page-1" data-title="<?php echo $post->post_title; ?>" >
		
			<div class="posts-wrapper">
				<div class = "text-holder">	
					<a class="post-title" href="<?php the_permalink() ; ?>" title="<?php the_title() ; ?>" ><h1><?php the_title() ?></h1></a>
					<p id="baseline"> 
					<?php echo esc_html( get_post_meta( get_the_ID(), 'ald_baseline2', true ) ); ?></p>
				</div>
			</div>
			<!-- first page comes from the presentation -->
			<div class="stack-center">
				<div class="stacked-center">
					<?php echo apply_filters( 'the_content' , $post->post_content ); ?>
				</div>
			</div>			
		</div>
		<?php
			
		// add the slides 
		
		$section = 1;
		$s_page = 1;

		/* pour afficher le role de l'utilisateur courant 
		// pour debuguer ce qui suit...
		if ( is_user_logged_in() ) {
			$user = new WP_User( $user_ID );
			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role )
			echo '<p>' . $role . '</p>' ;
			}
		}; */
		
		if( current_user_can('editor') || current_user_can('administrator') ) { 
			$status = array( 'draft', 'publish' ) ;
		} else { 
			$status = array( 'publish' ) ;
		}
		
		
		$args = array (
			'post_type' => 'slide',
			'order' => 'ASC',
			'orderby' => 'meta_value_num',
			'meta_key' => 'slideorder',
			'posts_per_page' => -1,
			'post_parent' => $post->ID,
			'post_status' => $status,
		);

		// The Query
		$slides = new WP_Query( $args );
	
		while ( $slides->have_posts() ) {
		
				$slides->the_post();
				
				// check order, throw new section if necessary
				
				$slide_order = get_post_meta( get_the_ID() , 'slideorder', true );
				
				if ( is_numeric($slide_order) ) {
				
					if ( $slide_order > ( $section + 0.99 ) ) {
				
						// close current section 
						echo '</div> <!-- section ' . $section . '-->';
					
						// open new section 
						$section = floor( $slide_order );
						$s_page = 0;
					
						echo '<div class="ft-section" data-id="section-' . $section . '">';
				
					}
				
					$s_page += 1; //$slide_order - $section;
				
					// output slide 
					echo '<div data-slideorder="' . $slide_order . '" id="/section-' . $section . '/page-' . $s_page . '" class="ft-page" data-id="page-' . $s_page . '">';
					
					$post_title = get_the_title();
					
					if ( substr( $post_title, 0, 1 ) != '!' ) 
						echo '<h1>'. $post_title . '</h1>';
						
					echo apply_filters( 'the_content' , get_the_content() ) .
						'</div> <!-- slide ' . $s_page . ' -->';				
						
				}
		}
		
		echo '</div> <!-- section ' . $section . '-->';
				

		?>	
	</div>
	<?php endwhile; // end of the loop. 
		wp_reset_postdata();
		wp_reset_query();
	?>	

<?php get_footer(); ?>