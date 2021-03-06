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

<article id="post-<?php the_ID();?>" <?php post_class();?>>

	<?php if (!is_single() || is_related_posts()) {?>
		<div class="post-inner-wrap">
	<?php }?>

	<?php
if ((!is_single() || is_related_posts()) && function_exists('buddyboss_theme_entry_header')) {
    buddyboss_theme_entry_header($post);
}
?>

	<div class="entry-content-wrap">
		<?php
$featured_img_style = buddyboss_theme_get_option('blog_featured_img');

if (!empty($featured_img_style) && $featured_img_style == "full-fi-invert") {

    if (is_single() && !is_related_posts()) {?>
				<?php if (has_post_thumbnail()) {?>
					<figure class="entry-media entry-img bb-vw-container1">
						<?php the_post_thumbnail('large', array('sizes' => '(max-width:768px) 768px, (max-width:1024px) 1024px, (max-width:1920px) 1920px, 1024px'));?>
					</figure>
				<?php }?>
			<?php }?>

			<?php
if (has_post_format('link') && (!is_singular() || is_related_posts())) {
        echo '<span class="post-format-icon"><i class="bb-icon-link-1"></i></span>';
    }

    if (has_post_format('quote') && (!is_singular() || is_related_posts())) {
        echo '<span class="post-format-icon white"><i class="bb-icon-quote"></i></span>';
    }
    ?>

            <?php if (!is_singular('lesson') && !is_singular('llms_assignment')): ?>

			<header class="entry-header"><?php
if (is_singular() && !is_related_posts()):
        the_title('<h1 class="entry-title">', '</h1>');
    else:
        $prefix = "";
        if (has_post_format('link')) {
            $prefix = __('[Link]', 'buddyboss-theme');
            $prefix .= " "; //whitespace
        }
        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $prefix, '</a></h2>');
    endif;

    if (has_post_format('link') && function_exists('buddyboss_theme_get_first_url_content') && ($first_url = buddyboss_theme_get_first_url_content($post->post_content)) != ""): ?>
					<p class="post-main-link"><?php echo $first_url; ?></p>
				<?php endif;?></header><!-- .entry-header -->

            <?php endif;?>

			<?php if (!is_singular() || is_related_posts()) {?>
				<div class="entry-content">
					<?php
if (empty($post->post_excerpt)) {
        the_excerpt();
    } else {
        echo bb_get_excerpt($post->post_excerpt, 150);
    }
        ?>
				</div>
			<?php }?>

			<?php if ((isset($post->post_type) && $post->post_type === 'post') || (!has_post_format('quote') && is_singular('post'))): ?>
				<?php get_template_part('template-parts/entry-meta');?>
			<?php endif;?>

		<?php } else {?>

			<?php
if (has_post_format('link') && (!is_singular() || is_related_posts())) {
    echo '<span class="post-format-icon"><i class="bb-icon-link-1"></i></span>';
}

    if (has_post_format('quote') && (!is_singular() || is_related_posts())) {
        echo '<span class="post-format-icon white"><i class="bb-icon-quote"></i></span>';
    }
    ?>

			<header class="entry-header"><?php
if (is_singular() && !is_related_posts()):
        the_title('<h1 class="entry-title">', '</h1>');
    else:
        $prefix = "";
        if (has_post_format('link')) {
            $prefix = __('[Link]', 'buddyboss-theme');
            $prefix .= " "; //whitespace
        }
        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $prefix, '</a></h2>');
    endif;
    ?>

				<?php if (has_post_format('link') && function_exists('buddyboss_theme_get_first_url_content') && ($first_url = buddyboss_theme_get_first_url_content($post->post_content)) != ""): ?>
				<p class="post-main-link"><?php echo $first_url; ?></p>
				<?php endif;?>
			</header><!-- .entry-header -->

			<?php if (!is_singular() || is_related_posts()) {?>
				<div class="entry-content">
					<?php
if (empty($post->post_excerpt)) {
        the_excerpt();
    } else {
        echo bb_get_excerpt($post->post_excerpt, 150);
    }
        ?>
				</div>
			<?php }?>

			<?php if ((isset($post->post_type) && $post->post_type === 'post') || (!has_post_format('quote') && is_singular('post'))): ?>
				<?php get_template_part('template-parts/entry-meta');?>
			<?php endif;?>

			<?php if (is_single() && !is_related_posts()) {?>
				<?php if (has_post_thumbnail()) {?>
					<figure class="entry-media entry-img bb-vw-container1">
						<?php if (!empty($featured_img_style) && $featured_img_style == "full-fi") {
        the_post_thumbnail('large', array('sizes' => '(max-width:768px) 768px, (max-width:1024px) 1024px, (max-width:1920px) 1920px, 1024px'));
    } else {
        the_post_thumbnail('large');
    }?>
					</figure>
				<?php }?>
			<?php }?>

		<?php }?>

		<?php if (is_singular() && !is_related_posts()) {
    $post_id = get_the_ID();
    ?>

				<div id="ex1" class="modal" style="text-align: center;">
				  <p style="font-weight: bold;"> What is your concern?</p>
			  	  <form id="aphasiareport">
				  	<input style="margin-bottom: 10px" id="inputname" type="text" placeholder="Name" value="">
				  	<input style="margin-bottom: 10px" id="inputmsg" type="text" placeholder="What's wrong?" value="">
				  	<!-- <a href="" id="ex2" class="button"> Submit </a> -->

					  <input type="submit" value="Submit" id="reportsubmit" class="button">
				  </form>
				</div>
			<br>


			<div class="entry-content aphasia-text" style="display: none;">
			<?php
if (is_single() && 'post' == get_post_type()) {
        $post_id = get_the_ID();
        echo '<p>' . get_post_meta($post_id, 'message', true) . '</p>';
    }
    ?>
			</div>
			<div class="entry-content aphasia-text">
			<?php
the_content(sprintf(
        wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'buddyboss-theme'), array(
                'span' => array(
                    'class' => array(),
                ),
            )
        ), get_the_title()
    ));
    ?>
			</div><!-- .entry-content --><br>


			<div style="display: inline;">
				<div class="element blue myaphasiabtn" id="aphasiabtn">
					 <img src="https://i.imgur.com/o9u4B9Q.png" alt="'Aphasia toggle'" width="32" style="vertical-align:top">
					 <span class="bold"> Make </span> This <span class="bold"> Aphasia</span>-<span class="bold">Friendly</span>
				</div>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<div class="element blue" id="unsurebtn">
					<img src="https://i.imgur.com/hANyN8v.png" alt="'Aphasia text report'" width="32" style="vertical-align:top"> I'm Still Unsure
				</div>
				<div class="approvals" style="display: none;">
				<br>
					<span style="display: inline;"><img src="<?=(get_post_meta($post_id, 'admin_approved', true) ? site_url() . '/wp-content/uploads/2021/10/check.jpg' : site_url() . '/wp-content/uploads/2021/10/cancel.png')?>" style="width: 25px; height: 25px; margin-top: 5px;" /> Admin Approved</span>&nbsp

					<span style="display: inline;"><img src="<?=(get_post_meta($post_id, 'author_approved', true) ? site_url() . '/wp-content/uploads/2021/10/check.jpg' : site_url() . '/wp-content/uploads/2021/10/cancel.png')?>" style="width: 25px; height: 25px; margin-top: 5px;" /> Author Approved</span>&nbsp

					<span style="display: inline;"><img src="<?=(get_post_meta($post_id, 'fully_automatic', true) ? site_url() . '/wp-content/uploads/2021/10/check.jpg' : site_url() . '/wp-content/uploads/2021/10/cancel.png')?>" style="width: 25px; height: 25px; margin-top: 5px;" /> Fully Automatic</span>
				</div>
			</div>

		<?php }?>
	</div>
<br>
	<?php if (!is_single() || is_related_posts()) {?>
		</div><!--Close '.post-inner-wrap'-->
	<?php }?>

</article><!-- #post-<?php the_ID();?> -->

<?php if (is_single() && (has_category() || has_tag())) {?>
	<div class="post-meta-wrapper">
		<?php if (has_category()): ?>
			<div class="cat-links">
				<i class="bb-icon-folder"></i>
				<?php _e('Categories: ', 'buddyboss-theme');?>
				<span><?php the_category(__(', ', 'buddyboss-theme'));?></span>
			</div>
		<?php endif;?>

		<?php if (has_tag()): ?>
			<div class="tag-links">
				<i class="bb-icon-tag"></i>
				<?php _e('Tagged: ', 'buddyboss-theme');?>
				<?php the_tags('<span>', __(', ', 'buddyboss-theme'), '</span>');?>
			</div>
		<?php endif;?>
<br>
		<?php
global $wpdb;
    $comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM `wp_aphasia_feedback` WHERE post_id = '%d'", get_the_ID()));
    if ($comments): ?>

		<div class="comments">
			<i class="bb-icon-comment"></i>
			<?php _e('Reported Comments  ', 'buddyboss-theme');?>
			<br>
<br>
			<?php
echo '<ul class="comments-list">';
    foreach ($comments as $comment) { ?>
        			<li><?php echo '<strong>' . ucfirst($comment->report_user) . '</strong> : ' . $comment->report_message; ?>
        		</li><br>
        	<?php
}
    echo '</ul>';?>
		</div>
	<?php endif;?>

	</div>
<?php }?>

<?php
get_template_part('template-parts/content-subscribe');
get_template_part('template-parts/author-box');
get_template_part('template-parts/related-posts');