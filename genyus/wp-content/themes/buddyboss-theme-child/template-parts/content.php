<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */
?>

<?php 
global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( !is_single() || is_related_posts() ) { ?>
		<div class="post-inner-wrap">
	<?php } ?>

	<?php 
	if ( ( !is_single() || is_related_posts() ) && function_exists( 'buddyboss_theme_entry_header' ) ) {
		buddyboss_theme_entry_header( $post );
	} 
	?>

	<div class="entry-content-wrap">
		<?php 
		$featured_img_style = buddyboss_theme_get_option( 'blog_featured_img' );

		if ( !empty( $featured_img_style ) && $featured_img_style == "full-fi-invert" ) {

			if ( is_single() && ! is_related_posts() ) { ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<figure class="entry-media entry-img bb-vw-container1">
						<?php the_post_thumbnail( 'large', array( 'sizes' => '(max-width:768px) 768px, (max-width:1024px) 1024px, (max-width:1920px) 1920px, 1024px' ) ); ?>
					</figure>
				<?php } ?>
			<?php } ?>

			<?php
			if ( has_post_format( 'link' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon"><i class="bb-icon-link-1"></i></span>';
			}

			if ( has_post_format( 'quote' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon white"><i class="bb-icon-quote"></i></span>';
			}
			?>

            <?php if (!is_singular('lesson') && !is_singular('llms_assignment') ) : ?>

			<header class="entry-header"><?php
				if ( is_singular() && ! is_related_posts() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					$prefix = "";
					if( has_post_format( 'link' ) ){
						$prefix = __( '[Link]', 'buddyboss-theme' );
						$prefix .= " ";//whitespace
					}
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $prefix, '</a></h2>' );
				endif;

				if( has_post_format( 'link' ) && function_exists( 'buddyboss_theme_get_first_url_content' ) && ( $first_url = buddyboss_theme_get_first_url_content( $post->post_content ) ) != "" ) : ?>
					<p class="post-main-link"><?php echo $first_url;?></p>
				<?php endif; ?></header><!-- .entry-header -->

            <?php endif; ?>

			<?php if ( !is_singular() || is_related_posts() ) { ?>
				<div class="entry-content">
					<?php 
					if( empty($post->post_excerpt) ) {
						the_excerpt();
					} else {
						echo bb_get_excerpt($post->post_excerpt, 150);
					}
					?>
				</div>
			<?php } ?>

			<?php if ( ( isset($post->post_type) && $post->post_type === 'post' ) || ( ! has_post_format( 'quote' ) && is_singular( 'post' ) ) ) : ?>
				<?php get_template_part( 'template-parts/entry-meta' ); ?>
			<?php endif; ?>

		<?php } else { ?>

			<?php
			if ( has_post_format( 'link' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon"><i class="bb-icon-link-1"></i></span>';
			}

			if ( has_post_format( 'quote' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon white"><i class="bb-icon-quote"></i></span>';
			}
			?>

			<header class="entry-header"><?php
				if ( is_singular() && ! is_related_posts() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					$prefix = "";
					if( has_post_format( 'link' ) ){
						$prefix = __( '[Link]', 'buddyboss-theme' );
						$prefix .= " ";//whitespace
					}
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $prefix, '</a></h2>' );
				endif;
				?>

				<?php if( has_post_format( 'link' ) && function_exists( 'buddyboss_theme_get_first_url_content' ) && ( $first_url = buddyboss_theme_get_first_url_content( $post->post_content ) ) != "" ):?>
				<p class="post-main-link"><?php echo $first_url;?></p>
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( !is_singular() || is_related_posts() ) { ?>
				<div class="entry-content">
					<?php 
					if( empty($post->post_excerpt) ) {
						the_excerpt();
					} else {
						echo bb_get_excerpt($post->post_excerpt, 150);
					}
					?>
				</div>
			<?php } ?>

			<?php if ( ( isset($post->post_type) && $post->post_type === 'post' ) || ( ! has_post_format( 'quote' ) && is_singular( 'post' ) ) ) : ?>

				
				<?php get_template_part( 'template-parts/entry-meta' ); ?>

				
			<?php endif; ?>

			<?php if ( is_single() && ! is_related_posts() ) { ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<figure class="entry-media entry-img bb-vw-container1">
						<?php if ( !empty( $featured_img_style ) && $featured_img_style == "full-fi" ) {
							the_post_thumbnail( 'large', array( 'sizes' => '(max-width:768px) 768px, (max-width:1024px) 1024px, (max-width:1920px) 1920px, 1024px' ) );
						} else {
							the_post_thumbnail( 'large' ); 
						} ?>
					</figure>
				<?php } ?>
			<?php } ?>

		<?php } ?>
		
		<?php if ( is_singular() && ! is_related_posts() ) { ?>
			<!-- <div class="element"> -->
				<!-- <label class="switch">
				  <input type="checkbox" id="text-toggle">
				  <span class="slider round"></span>
				</label> -->
				<div class="element blue" id="aphasiabtn">
					 <img src="https://i.imgur.com/o9u4B9Q.png" alt="'Aphasia toggle'" width="32" style="vertical-align:top"> 
					 <span class="bold"> Make </span> This <span class="bold"> Easier</span> To <span class="bold"> Read </span> 
				</div>

				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				<div class="element blue" id="unsurebtn"> 
					<img src="https://i.imgur.com/hANyN8v.png" alt="'Aphasia text report'" width="32" style="vertical-align:top"> I'm Still Unsure 
				</div>
				
				<!-- TESTING ! -->
				
				<div id="ex1" class="modal">
				  <p> Make your voice heard!</p>
			  	  <form>
				  	<input id="inputname" type="text" placeholder="name" value="">
				  	<input id="inputmsg" type="text" placeholder="what's wrong?" value="">
				  	<a href="" id="ex2" class="button"> Submit </a>
				  </form>
				</div>

				<!-- <div class="bg-modal">
					<div class="modal-content">
						<div class="close"> x </div>
						<form>
							<input class="inputform" type="text" placeholder="name">
							<input class="inputform" type="text" placeholder="what's wrong?">
							<a href="" class="button"> Submit </a>
						</form>
					</div>
				</div> -->

			<br>
			<br>
			<br>

			<div class="entry-content aphasia-text" style="display: none;">
			<?php 
			if ( is_single() && 'post' == get_post_type()) {
				$post_id = get_the_ID();
				echo '<p>'.get_post_meta($post_id , 'message', true).'</p>';
			} 
			?>
			</div>
			<div class="entry-content aphasia-text">
			<?php
				the_content( sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'buddyboss-theme' ), array(
					'span' => array(
						'class' => array(),
					),
				)
				), get_the_title()
				) );
			?>
			</div><!-- .entry-content -->
		<?php } ?>
	</div>

	<?php if ( !is_single() || is_related_posts() ) { ?>
		</div><!--Close '.post-inner-wrap'-->
	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php if( is_single() && ( has_category() || has_tag() ) ) { ?>
	<div class="post-meta-wrapper">
		<?php if  ( has_category() ) : ?>
			<div class="cat-links">
				<i class="bb-icon-folder"></i>
				<?php _e( 'Categories: ', 'buddyboss-theme' ); ?>
				<span><?php the_category( __( ', ', 'buddyboss-theme' ) ); ?></span>
			</div>
		<?php endif; ?>

		<?php if  ( has_tag() ) : ?>
			<div class="tag-links">
				<i class="bb-icon-tag"></i>
				<?php _e( 'Tagged: ', 'buddyboss-theme' ); ?>
				<?php the_tags( '<span>', __( ', ', 'buddyboss-theme' ),'</span>' ); ?>
			</div>
		<?php endif; ?>
	</div>
<?php } ?>

<?php
get_template_part( 'template-parts/content-subscribe' );
get_template_part( 'template-parts/author-box' );
get_template_part( 'template-parts/related-posts' );