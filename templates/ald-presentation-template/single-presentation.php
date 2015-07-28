<?php
/*
Template Name: pages produits avec flowtime
*/
?>

<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>
<div id="main-wrapper" class="<?php echo tc__f( 'tc_main_wrapper_classes' , 'container' ) ?>">

    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>
    
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/ald.css' ,  __FILE__ ); ?>">
<link rel="stylesheet" href="<?php echo plugins_url( '../assets/css/themes/default.css' ,  __FILE__ ); ?>">
	
<div class="container" role="main">
	<div class="<?php echo tc__f( 'tc_column_content_wrapper_classes' , 'row column-content-wrapper' ) ?>">
		<?php do_action( '__before_article_container'); ##hook of left sidebar?>
                
                <div id="content" class="<?php echo tc__f( '__screen_layout' , tc__f ( '__ID' ) , 'class' ) ?> article-container">

		<div class="flowtime">
			<h3> this is the single-presentation template from the THEME !!! </h3>
			<?php 
			
				global $post;
				
				// first page comes from the presentation 
			?>

		<div class="ft-section" data-id="section-1">
		
			<div id="/section-1/page-1" class="ft-page" data-id="page-1" data-title="<?php echo $post->post_title; ?>" >
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

				$args = array (
					'post_type' => 'slide',
					'order' => 'ASC',
					'orderby' => 'meta_value_num',
					'meta_key' => 'slideorder',
					'posts_per_page' => -1,
					'post_parent' => $post->ID,
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
				
				wp_reset_postdata();
			
			?>

		</div>
	
	


	</div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>

</div><!-- .container role: main -->
	<?php wp_reset_query(); ?>
	
    <?php do_action( '__after_main_container' ); ?>

</div><!--#main-wrapper"-->
<?php do_action( '__after_main_wrapper' );##hook of the footer with get_get_footer ?>