<!-- original page -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<script type="text/javascript">

jQuery(document).ready(function(){

jQuery("article #aphasiabtn").click(function(){
    var $this = jQuery(this);
    if($this.data('clicked')) {
		jQuery("article #aphasiabtn").removeClass('DarkBlue');
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
				   jQuery(".aphasia-text").html(data);
		    }
		});
		
    }
    else {
        $this.data('clicked', true);
        jQuery("article #aphasiabtn").addClass('DarkBlue');
		
		jQuery.ajax({
		    type: "POST",
		    dataType: "html",
		    url: '<?php echo get_site_url();?>/wp-content/themes/buddyboss-theme/getmessage.php',
		    data: {"id":<?php echo get_the_ID();?>,'field':'post_excerpt'},
				   error: function(XMLHttpRequest, textStatus, errorThrown) {
		      alert(errorThrown);
		    },
		    success: function(data){
				   jQuery(".aphasia-text").html(data);
		    }
		});
			
    }
});

	jQuery('#post_excerpt_525').on('click', function() {
	if(!jQuery("#post_excerpt_525").hasClass('WarningText')){
	alert('WARNING -- There is already text in this textbox, are you sure you want to override it?');

		$('.wpuf_author_approved_525')[1].checked = true;
		$('.wpuf_author_approved_525')[0].checked = false;
		$('.wpuf_fully_automatic_525')[0].checked = true;
		$('.wpuf_fully_automatic_525')[1].checked = false;		
		jQuery("#post_excerpt_525").addClass('WarningText');
		}
		});

/* I'm still unsure button */
jQuery("#unsurebtn").click(function(){
	var $this = jQuery(this);
	if(jQuery("#unsurebtn").data('clicked'))
		{
			//jQuery("#unsurebtn").removeClass('DarkBlue');
			$this.data('clicked', false);
			jQuery('#unsurebtn').html(jQuery("#inputname").value);
		}
	else 
		{
			$this.data('clicked', true);
			//jQuery("#unsurebtn").addClass('DarkBlue');
			$("#ex1").modal()
			$("#unsurebtn").html("Thanks for the feedback!");
		}
	
})

/* I'm still unsure "aphasia report" form */
jQuery("#aphasiareport").submit(function(){
	var name = jQuery("#inputname").val();
	if (name == "") {
		name = "Anonymous";
	} 

	var msg = jQuery("#inputmsg").val();
	if (msg == "") {
		msg = "No message given in the user feedback.";
	}

	$postid = <?php echo get_the_ID();?>;
	$author = <?php echo get_the_author_ID();?>;
	

	jQuery.ajax({
		type: "POST",
	    url: '<?php echo get_site_url();?>/wp-content/themes/buddyboss-theme/sendreport.php',
	    data: {
	    	"id":$postid,
	    	"author":$author,
	    	"title":"sample title",
	    	"name":name,
	    	"msg":msg,
	    },
	    error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert(errorThrown);
		},
	    success: function(response){
	    	alert("Thanks for the feedback, " + name + "!");
	    }
	});

});

/*add aphasia text in form field*/
jQuery("#btn_Post").click(function(){
    var $this = jQuery(this);
if(jQuery("#btn_Post").hasClass('NoText'))
	{
	jQuery.ajax({
		type: "POST",
    url: '<?php echo get_site_url();?>/wp-content/themes/buddyboss-theme/python.php',
		   error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert(errorThrown);
    },
	async:open,
        data:{
          post_content: jQuery("#post_content_525_ifr").contents().find('body').text(),
        },
        
    success: function(data){
        //alert(data);
		   //jQuery(".aphasia-text").html("");
		   jQuery(".wpuf_post_excerpt_525").val(data); //fill it in textbox1
		  // alert(data);
           jQuery(".wpuf_edited_author_output_525").val(data); //fill it in hidden textbox
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
<script type="text/javascript"> 
	$('.myaphasiabtn').on('click', function(){
		$('.approvals').toggle();
	});

</script>
<?php wp_footer(); ?>
</body>
</html>
