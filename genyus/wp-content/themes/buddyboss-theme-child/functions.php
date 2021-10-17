<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */

/****************************** THEME SETUP ******************************/

/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */


function buddyboss_theme_child_languages()
{
    /**
     * Makes child theme available for translation.
     * Translations can be added into the /languages/ directory.
     */

    // Translate text from the PARENT theme.
    load_theme_textdomain('buddyboss-theme', get_stylesheet_directory() . '/languages');

    // Translate text from the CHILD theme only.
    // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
    // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );
    
}
add_action('after_setup_theme', 'buddyboss_theme_child_languages');

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
    /**
     * Scripts and Styles loaded by the parent theme can be unloaded if needed
     * using wp_deregister_script or wp_deregister_style.
     *
     * See the WordPress Codex for more information about those functions:
     * http://codex.wordpress.org/Function_Reference/wp_deregister_script
     * http://codex.wordpress.org/Function_Reference/wp_deregister_style
     *
     */

    // Styles
    wp_enqueue_style('buddyboss-child-css', get_stylesheet_directory_uri() . '/assets/css/custom.css', '', '1.0.0');
}
add_action('wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999);

add_action( 'wp_footer', 'my_footer_scripts' );
function my_footer_scripts(){
  if ( is_single() && 'post' == get_post_type() ) {
    ?>
    <script type="text/javascript">
      jQuery('#text-toggle').change(function() {
          jQuery('.entry-content.aphasia-text').toggle();
      });
    </script>
    <?php
  }
}

// For Custom Notification 
// Registering Custom Componet 
function custom_filter_notifications_get_registered_components( $component_names = array() ) {
 
    // Force $component_names to be an array
    if ( ! is_array( $component_names ) ) {
        $component_names = array();
    }

    // Add 'custom' component to registered components array
    array_push( $component_names, 'custom' );
 
    // Return component's with 'custom' appended
    return $component_names;
}
add_filter( 'bp_notifications_get_registered_components', 'custom_filter_notifications_get_registered_components' );

// Formatting custom with respect to action
function bp_custom_format_buddypress_notifications( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {
    
    //$item_id this your id which you can use to get your respected data
      $data  = get_post($item_id); // this is custom function it depend on your needs and data
      $custom_title = get_the_title($item_id);
      $custom_link  = get_permalink($item_id);
      $custom_text  = $data->text;

    // New custom notifications
    if ( 'custom_action' === $action ) {
        
        // WordPress Toolbar
        if ( 'string' === $format ) {
            $return = apply_filters( 'custom_filter','Your Post ...<a href="'.$custom_link.'">'.$custom_title.'</a> is marked as confusing ', $custom_text, $custom_link );
 
        // Deprecated BuddyBar
        } else {
            $return = apply_filters( 'custom_filter', array(
                'text' => $custom_text,
                'link' => $custom_link
            ), $custom_link, (int) $total_items, $custom_text, $custom_title );
        }
        
        return $return;
        
    }
   
}
add_filter( 'bp_notifications_get_notifications_for_user', 'bp_custom_format_buddypress_notifications', 10, 5 );

// Adding custom Notification in DB 
function bp_custom_notification( $item_id, $author_id ) {

    if ( bp_is_active( 'notifications' ) ) {   // if notification is active from admin panel
      // if notification is active from admin panel bp_notifications_add_notification function to add notification into database
        bp_notifications_add_notification( array(                        
            'user_id'           => $author_id, // User to whom notification has to be send
            'item_id'           => $item_id,  // Id of thing you want to show it can be item_id or post or custom post or anything
            'component_name'    => 'custom', //  component that we registered
            'component_action'  => 'custom_action', // Our Custom Action 
            'date_notified'     => bp_core_current_time(), // current time
            'is_new'            => 1, // It say that is new notification
        ) );
    }
}
add_action( 'custom_hooks', 'bp_custom_notification', 10, 2); 