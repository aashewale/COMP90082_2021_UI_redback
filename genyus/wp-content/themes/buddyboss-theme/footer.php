<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BuddyBoss_Theme
 */

?>
<?php do_action( THEME_HOOK_PREFIX . 'end_content' ); ?>

</div><!-- .bb-grid -->
</div><!-- .container -->
</div><!-- #content -->

<?php do_action( THEME_HOOK_PREFIX . 'after_content' ); ?>




<?php do_action( THEME_HOOK_PREFIX . 'before_footer' ); ?>
<?php do_action( THEME_HOOK_PREFIX . 'footer' ); ?>
<?php do_action( THEME_HOOK_PREFIX . 'after_footer' ); ?>

</div><!-- #page -->

<?php do_action( THEME_HOOK_PREFIX . 'after_page' ); ?>

<script type="text/javascript">

	jQuery(document).ready(function(){
	
jQuery("article .element.blue").click(function(){
    var $this = jQuery(this);
    if($this.data('clicked')) {
        jQuery("article .element.blue").addClass('LightBlue');
		jQuery("article .element.blue").removeClass('DarkBlue');
		$this.data('clicked', false);
		
		jQuery.ajax({
    type: "POST",
    dataType: "html",
    url: '<?php echo get_site_url();?>/wp-content/themes/buddyboss-theme/getmessage.php',
    data: {"id":<?php echo get_the_ID();?>,'field':'post_content'},
		   error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert(errorThrown);
    },
    success: function(data){
        //alert(data);
		   //jQuery(".aphasia-text").html("");
		   jQuery(".aphasia-text").html(data);
    }
});
		
    }
    else {
		jQuery("article .element.blue").removeClass('LightBlue');
        $this.data('clicked', true);
        jQuery("article .element.blue").addClass('DarkBlue');
		
		jQuery.ajax({
    type: "POST",
    dataType: "html",
    url: '<?php echo get_site_url();?>/wp-content/themes/buddyboss-theme/getmessage.php',
    data: {"id":<?php echo get_the_ID();?>,'field':'post_excerpt'},
		   error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert(errorThrown);
    },
    success: function(data){
        //alert(data);
		   //jQuery(".aphasia-text").html("");
		   jQuery(".aphasia-text").html(data);
    }
});
	
    }
});

		/*add aphasia text in form field*/

jQuery("#btn_Post").click(function(){
	var $this = jQuery(this);
	if(jQuery("#btn_Post").data('clicked'))
		{
			alert('btn');
		}
	
})
		
jQuery("#btn_Post").click(function(){
    var $this = jQuery(this);
if(jQuery("#btn_Post").hasClass('NoText'))
	{
		
	jQuery.ajax({
    url: '<?php echo get_site_url();?>/wp-content/themes/buddyboss-theme/python.php',
		   error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert(errorThrown);
    },
    success: function(data){
        //alert(data);
		   //jQuery(".aphasia-text").html("");
		   jQuery(".wpuf_post_excerpt_525").val(data);
    }
		
	
});	
		
	jQuery("#btn_Post").removeClass('NoText');		

	}
	else
	{
			//alert('not checked');
		jQuery(".wpuf_post_excerpt_525").val('');
		jQuery("#btn_Post").addClass('NoText');
	}
		
		});	
	
			
	});
		
		
</script>


<?php wp_footer(); ?>

</body>
</html>
